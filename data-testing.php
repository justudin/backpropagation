<div id="page-wrapper">

        <div class="row">
            <h1>Data Testing</h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-desktop"></i> Home</a></li>
              <li class="active"><i class="fa fa-table"></i> Data Testing</li>
            </ol>
        </div><!-- /.row -->
        <div class="row">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                   <tr>
					<th>ID</th>
					<th>ID_TR</th>
					<th>IR_P</th>
					<th>IR_A</th>
					<th>IR_N</th>
					<th>MR_P</th>
					<th>MR_A</th>
					<th>MR_N</th>
					<th>FF_P</th>
					<th>FF_A</th>
					<th>FF_N</th>
					<th>CR_P</th>
					<th>CR_A</th>
					<th>CR_N</th>
					<th>CO_P</th>
					<th>CO_A</th>
					<th>CO_N</th>
					<th>OP_P</th>
					<th>OP_A</th>
					<th>OP_N</th>
					<th>TARGET</th>
				  </tr>
                </thead>
                <tbody>
				<?php
				//dt_testing
				$query = "select * from dt_testing";
				$exec_query = mysql_query($query);
				while ($row = mysql_fetch_array($exec_query))
				{
					echo "
					<tr>
						<td>$row[0]</td>
						<td>$row[1]</td>
						<td>$row[2]</td>
						<td>$row[3]</td>
						<td>$row[4]</td>
						<td>$row[5]</td>
						<td>$row[6]</td>
						<td>$row[7]</td>
						<td>$row[8]</td>
						<td>$row[9]</td>
						<td>$row[10]</td>
						<td>$row[11]</td>
						<td>$row[12]</td>
						<td>$row[13]</td>
						<td>$row[14]</td>
						<td>$row[15]</td>
						<td>$row[16]</td>
						<td>$row[17]</td>
						<td>$row[18]</td>
						<td>$row[19]</td>
						<td>$row[21]</td>
				  </tr>";
				}
				?>
                  
                </tbody>
              </table>
            </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->