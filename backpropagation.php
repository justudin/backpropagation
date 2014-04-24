<div id="page-wrapper">

        <div class="row">
            <h1> Backpropagation</h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-desktop"></i> Home</a></li>
              <li class="active"><i class="fa fa-wrench"></i> Backpropagation</li>
            </ol>
        </div><!-- /.row -->
        <div class="row">
		<div id="bpn">
            <div class="form-horizontal" role="form">
			  <div class="form-group">
				<label for="Learning Rate" class="col-sm-2 control-label">Learning Rate</label>
				<div class="col-xs-3">
				  <input type="text" id="lr" class="form-control" size="5" value="0.3" placeholder="Learning Rate">
				</div>
			  </div>
			  <div class="form-group">
				<label for="Momentum" class="col-sm-2 control-label">Momentum</label>
				<div class="col-xs-3">
				  <input type="text" id="mm" class="form-control" size="5" value="0.1" placeholder="Momentum">
				</div>
			  </div>
			  <div class="form-group">
				<label for="Threshold" class="col-sm-2 control-label">Threshold</label>
				<div class="col-xs-3">
				  <input type="text" id="th" class="form-control" size="5" value="0.0001" placeholder="Threshold">
				</div>
			  </div>
			  <div class="form-group">
				<label for="Training Time" class="col-sm-2 control-label">Training Time</label>
				<div class="col-xs-3">
				  <input type="text" id="tt" class="form-control" size="5" value="200000" placeholder="Training Time">
				</div>
			  </div>
			  <div class="form-group">
				<label for="Input Layer" class="col-sm-2 control-label">Input Layer</label>
				<div class="col-xs-3">
				  <input type="text" id="il" class="form-control" size="5" value="18" readonly placeholder="Input Layer">
				</div>
			  </div>
			  <div class="form-group">
				<label for="Hidden Layer" class="col-sm-2 control-label">Hidden Layer</label>
				<div class="col-xs-3">
				  <input type="text" id="hl" class="form-control" size="5" value="9" placeholder="Hidden Layer">
				</div>
			  </div>
			  <div class="form-group">
				<label for="Output" class="col-sm-2 control-label">Output</label>
				<div class="col-xs-3">
				  <input type="text" id="ot" class="form-control" size="5" value="1" readonly placeholder="Output">
				</div>
			  </div>
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				<div class="controls">
					<button id="process" name="button1id" class="btn btn-success">Process</button>
					<button id="reset" name="button2id" class="btn btn-danger">Reset</button>
				  </div>
				</div>
			  </div>
			</div>
        </div><!-- /#bpn -->
        </div><!-- /.row -->
      </div><!-- /#page-wrapper -->