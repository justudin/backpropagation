<?php
set_time_limit(0);
include "config.php";
include('lib/phpgraphlib.php');
if($_POST){

	//delete error data
	$del_data = mysql_query("DELETE FROM mse");
	
	echo "<b>Result of Backpropagation Implementation Using Parameters below:</b><p><p>";
	global $koneksi_db,$maxdata, $maxkonten;
	
	//$go				= $_POST['go'];
	$learning_rate	= $_POST['lr'];
	$momentum		= $_POST['mm'];
	$threshold		= $_POST['th'];
	$training_time	= $_POST['tt'];
	$hidden			= $_POST['hl'];
	$inputl			= $_POST['il'];
	$outputl		= $_POST['ot'];

	$beta			= $learning_rate;
	$alpha			= $momentum;
	$Thresh 		= $threshold;
	$numEpoch		= $training_time;
	?>
	<div class="col-lg-4">
		<div class="bs-example">
		  <ul class="list-group">
			<li class="list-group-item">
			  <span class="badge"><?php echo $beta;?></span>
			  Learning rate
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $Thresh;?></span>
			  Threshold
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $training_time;?></span>
			  Training Time
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $inputl;?></span>
			  Input Layer
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $hidden;?></span>
			  Hidden Layer
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $outputl;?></span>
			  Output
			</li>		
		  </ul>
		</div>
	</div>
	<?php
	//get dt training
	$sql_training = mysql_query("SELECT * FROM dt_training ORDER BY `dt_training`.`id_training` ASC");
	while ($r_tr = mysql_fetch_array($sql_training)) {
		$data_training [] = array(
				$r_tr[1],
				$r_tr[2],
				$r_tr[3],
				$r_tr[4],
				$r_tr[5],
				$r_tr[6],
				$r_tr[7],
				$r_tr[8],
				$r_tr[9],
				$r_tr[10],
				$r_tr[11],
				$r_tr[12],
				$r_tr[13],
				$r_tr[14],
				$r_tr[15],
				$r_tr[16],
				$r_tr[17],
				$r_tr[18],
				$r_tr[19]
			);
	}
	//print_r($data_training);
	//get dt testing
	$sql_testing = mysql_query("SELECT * FROM dt_testing ORDER BY `dt_testing`.`id_testing` ASC");
	while ($r_ts = mysql_fetch_array($sql_testing)) {
		$data_testing [] = array(
				$r_ts[2],
				$r_ts[3],
				$r_ts[4],
				$r_ts[5],
				$r_ts[6],
				$r_ts[7],
				$r_ts[8],
				$r_ts[9],
				$r_ts[10],
				$r_ts[11],
				$r_ts[12],
				$r_ts[13],
				$r_ts[14],
				$r_ts[15],
				$r_ts[16],
				$r_ts[17],
				$r_ts[18],
				$r_ts[19]
			);
	}
	//print_r($data_testing);
	
	//******
	// Process BPN
	//
	/**
	Exclusive OR (XOR)

	0 XOR 0 = 0 (no)
	1 XOR 0 = 1 (yes)
	0 XOR 1 = 1 (yes)
	1 XOR 1 = 0 (no)

	The rule: Say yes if the first one is 0 or the second is 1,
	but not both.

	TODO Scale data for values beyond 0 and 1.

	By freedelta freedelta.free.fr January-2010
	 */
	error_reporting(E_STRICT);
	define("_RAND_MAX",32767);

	class BackPropagation
	{	
	/* Output of each neuron */
	public $output=null;

	/* delta error value for each neuron */
	public $delta=null;

	/* Array of weights for each neuron */
	public $weight=null;

	/* Num of layers in the net, including input layer */
	public $numLayers=null;

	/* Array num elments containing size for each layer */
	public $layersSize=null;

	/* Learning rate */
	public $beta=null;

	/* Momentum */
	public $alpha=null;

	/* Storage for weight-change made in previous epoch (three-dimensional array) */
	public $prevDwt=null;

	/* Data */
	public $data=null;

	/* Test Data */
	public $testData=null;

	/* N lines of Data */
	public $NumPattern=null;

	/* N columns in Data */
	public $NumInput=null;


	public function __construct($numLayers,$layersSize,$beta,$alpha)
	{			
		$this->alpha=$alpha;
		$this->beta=$beta;
		
		// Set no of layers and their sizes
		$this->numLayers=$numLayers;
		$this->layersSize=$layersSize;
		
		// Seed and assign random weights
		for($i=1;$i<$this->numLayers;$i++)
		{
			for($j=0;$j<$this->layersSize[$i];$j++)
			{
				for($k=0;$k<$this->layersSize[$i-1]+1;$k++)				
				{
					$this->weight[$i][$j][$k]=$this->rando();
				}
				// bias in the last neuron				
				$this->weight[$i][$j][$this->layersSize[$i-1]]=-1;
			}
		}	
		
		// initialize previous weights to 0 for first iteration		
		for($i=1;$i<$this->numLayers;$i++)
		{
			for($j=0;$j<$this->layersSize[$i];$j++)
			{
				for($k=0;$k<$this->layersSize[$i-1]+1;$k++)
				{					
					$this->prevDwt[$i][$j][$k]=(double)0.0;
				}				
			}
		}	
		
		/*
		// Note that the following variables are unused,
		//
		// delta[0]
		// weight[0]
		// prevDwt[0]

		//  I did this intentionaly to maintains consistancy in numbering the layers.
		//  Since for a net having n layers, input layer is refered to as 0th layer,
		//  first hidden layer as 1st layer and the nth layer as outputput layer. And 
		//  first (0th) layer just stores the inputs hence there is no delta or weigth
		//  values corresponding to it.
		*/
	}

	public function rando()
	{
		return (double)(rand())/(_RAND_MAX/2) - 1;//32767
	}

	// sigmoid function
	public function sigmoid($inputSource)
	{
		return (double)(1.0 / (1.0 + exp(-$inputSource)));
	}

	// mean square error
	public function mse($target)
	{	
		$mse=0;
		
		for($i=0;$i<$this->layersSize[$this->numLayers-1];$i++)
		{
			$mse+=($target-$this->output[$this->numLayers-1][$i])*($target-$this->output[$this->numLayers-1][$i]);		
		}	
		return $mse/2;	
	}

	// returns i'th outputput of the net
	public function Out($i)
	{
		return $this->output[$this->numLayers-1][$i];
	}

	// Feed forward one set of input
	// to update the output values for each neuron. 
	// This function takes the input to the net and finds the output of each neuron
	public function ffwd($inputSource)
	{	
		$sum=0.0;

		// assign content to input layer
		for($i=0;$i<$this->layersSize[0];$i++)
		{
			$this->output[0][$i]=$inputSource[$i];  // outputput_from_neuron(i,j) Jth neuron in Ith Layer		
		}
			
		// assign output (activation) value to each neuron usng sigmoid func
		for($i=1;$i<$this->numLayers;$i++)									// For each layer
		{	
			for($j=0;$j<$this->layersSize[$i];$j++)								// For each neuron in current layer
			{	
				$sum=0.0;
				for($k=0;$k<$this->layersSize[$i-1];$k++)						// For each input from each neuron in preceeding layer
				{					
							  $sum+=$this->output[$i-1][$k]*$this->weight[$i][$j][$k];	                        // Apply weight to inputs and add to sum	
				}
				// Apply bias
				$sum+=$this->weight[$i][$j][$this->layersSize[$i-1]];	
				// Apply sigmoid function					
				$this->output[$i][$j]=$this->sigmoid($sum);						
			}
		}	
	}

	/* ---	Backpropagate errors from outputput layer back till the first hidden layer */
	public function bpgt($inputSource,$target)
	{	
		/* ---	Update the output values for each neuron */
		$this->ffwd($inputSource);

		///////////////////////////////////////////////
		/// FIND DELTA FOR OUPUT LAYER (Last Layer) ///
		///////////////////////////////////////////////
		
		for($i=0;$i<$this->layersSize[$this->numLayers-1];$i++)
		{	
			$this->delta[$this->numLayers-1][$i]=$this->output[$this->numLayers-1][$i]*(1-$this->output[$this->numLayers-1][$i])*($target-$this->output[$this->numLayers-1][$i]);
		}
		
		/////////////////////////////////////////////////////////////////////////////////////////////
		/// FIND DELTA FOR HIDDEN LAYERS (From Last Hidden Layer BACKWARDS To First Hidden Layer) ///
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		for($i=$this->numLayers-2;$i>0;$i--)
		{
			for($j=0;$j<$this->layersSize[$i];$j++)
			{
				$sum=0.0;
				for($k=0;$k<$this->layersSize[$i+1];$k++)
				{
					$sum+=$this->delta[$i+1][$k]*$this->weight[$i+1][$k][$j];
				}			
				$this->delta[$i][$j]=$this->output[$i][$j]*(1-$this->output[$i][$j])*$sum;
			}
		}
		
		////////////////////////
		/// MOMENTUM (Alpha) ///
		////////////////////////
		
		for($i=1;$i<$this->numLayers;$i++)
		{
			for($j=0;$j<$this->layersSize[$i];$j++)
			{
				for($k=0;$k<$this->layersSize[$i-1];$k++)
				{
					$this->weight[$i][$j][$k]+=$this->alpha*$this->prevDwt[$i][$j][$k];				
				}
				$this->weight[$i][$j][$this->layersSize[$i-1]]+=$this->alpha*$this->prevDwt[$i][$j][$this->layersSize[$i-1]];
			}
		}
		
		///////////////////////////////////////////////
		/// ADJUST WEIGHTS (Using Steepest Descent) ///
		///////////////////////////////////////////////
		
		for($i=1;$i<$this->numLayers;$i++)
		{
			for($j=0;$j<$this->layersSize[$i];$j++)
			{
				for($k=0;$k<$this->layersSize[$i-1];$k++)
				{
					$this->prevDwt[$i][$j][$k]=$this->beta*$this->delta[$i][$j]*$this->output[$i-1][$k];
					$this->weight[$i][$j][$k]+=$this->prevDwt[$i][$j][$k];
				}
				/* --- Apply the corrections */
				$this->prevDwt[$i][$j][$this->layersSize[$i-1]]=$this->beta*$this->delta[$i][$j];
				$this->weight[$i][$j][$this->layersSize[$i-1]]+=$this->prevDwt[$i][$j][$this->layersSize[$i-1]];
			}
		}
	}

	public function Run($data,$testData,$numEpoch,$Thresh)
	{
		/* --- Threshhold - thresh (value of target mse, training stops once it is achieved) */
		//$Thresh =  0.0001;
		//$numEpoch = 200000;	
		$MSE=0.0;	
		$NumPattern=count($data);	// Lines
		$NumPattern2=count($testData);	
		$NumInput=count($data[0]);	// Columns
		//$error_array = array();
		/* --- Start training: looping through epochs and exit when MSE error < Threshold */
		//echo  "\nNow training the network....<p><p>";	
		$i = 1;
		for($e=0;$e<$numEpoch;$e++)
		{			
			/* -- Backpropagate */
			$this->bpgt($data[$e%$NumPattern],$data[$e%$NumPattern][$NumInput-1]);
					
			$MSE=$this->mse($data[$e%$NumPattern][$NumInput-1]);
			//echo $MSE."<br/>";
			//$error_array[] = $MSE;
			$mseInsert = mysql_query("insert into mse values('$i','$MSE')");
			$i++;
			if($e==0)
			{
				$firsEmse = $MSE;
				//echo "<p><p>\nFirst epoch Mean Square Error: $MSE";
			}
			if( $MSE < $Thresh)		
			{
			   $epochke = $e; 
			   //echo "<p><p>\nNetwork Trained. Threshold value achieved in ".$e." iterations.";
			   // echo "<p><p>\nMSE:  ".$MSE;
			   break;
			}
			mysql_close($link);
		}
		//echo "<p><p>\nThat's it\n";
		//echo "<br/>";
		//$json = json_encode($error_array);
		//print_r($json);
		//print_r(array_values($error_array));
		?>
		<div class="col-lg-4">
		<div class="bs-example">
		  <ul class="list-group">
			<li class="list-group-item">
			  <span class="badge"><?php echo $firsEmse;?></span>
			  First epoch MSE
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $epochke;?> iterations</span>
			  Threshold value achieved in 
			</li>
			<li class="list-group-item">
			  <span class="badge"><?php echo $MSE;?></span>
			  Last epoch MSE
			</li>	
		  </ul>
		</div>
	</div>
		<div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Line Graph for Learning Error</h3>
              </div>
              <div class="panel-body">
                <div class="flot-chart">
					<center><img width="900" height="400" src="graphbpn.php" /></center>
                </div>
              </div>
			  <button><a href="graphbpnfull.php" target="_blank">Full Error Graph</a></button>
            </div>
          </div>
        </div><!-- /.row -->
		<?php
		echo "<p><p>\nNow using the trained network to make predictions on data testing<p><p>";	
		for ($i = 0 ; $i < $NumPattern2; $i++ )
		{
			$this->ffwd($testData[$i]);
					
			echo "<p><p>";
			
			for($j=0;$j<$NumInput-1;$j++)
			{
				echo $testData[$i][$j]."  ";
			}
						
			echo (double)$this->Out(0);	
		}
	}

	}

	/* --- Sample use */


	/**			
	 * Defining a net with 4 layers having 3,3,3, and 1 neuron respectively,
	 * the first layer is input layer i.e. simply holder for the input parameters
	 * and has to be the same size as the no of input parameters, in out example 3
	 */

	//$layersSize=array(21,21,21,1);
	$layersSize=array(18,$hidden,1);
	$numLayers = count($layersSize);

	// Learning rate - beta
	// momentum - alpha


	// Creating the net    
	$bp=new BackPropagation($numLayers,$layersSize,$beta,$alpha);
	$bp->Run($data_training,$data_testing,$numEpoch,$Thresh);
	//var_dump($data_training);
	//var_dump($data_testing);
}
else echo "Forbidden direct access!";
?>

