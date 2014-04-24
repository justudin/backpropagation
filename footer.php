   </div><!-- /#wrapper -->
    <!-- JavaScript -->
	
	
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
	<script type="text/javascript">
    jQuery(document).ready(function($){
		$('li').each(function(){
			if(window.location.href.indexOf($(this).find('a:first').attr('href'))>-1)
			{
			$(this).addClass('active').siblings().removeClass('active');
			}
		});
		//process bpn
		$(document).on( "click", "#process", function(e) {
			e.preventDefault();
			var lr 	= $("#lr").val();
			var mm 	= $("#mm").val();
			var th 	= $("#th").val();
			var tt 	= $("#tt").val();
			var il 	= $("#il").val();
			var hl 	= $("#hl").val();
			var ot 	= $("#ot").val();
			console.log(lr);
			$ajax01 = $.ajax({
						url : "exec-bpn.php",
						type: "POST",
						beforeSend: function(){
							$("#bpn").html('<br /><center><img src="loading.gif"><br />Now training the network....</center>');
						},
						cache	: false,
						data    : "lr="+lr+"&mm="+mm+"&th="+th+"&tt="+tt+"&il="+il+"&hl="+hl+"&ot="+ot,									
			});
			$ajax01.done(function(data){ 
				console.log(data);
				$("#bpn").html(data);
			});
		});
		//reset bpn
		$(document).on( "click", "#reset", function(e) {
			e.preventDefault();
			$("#lr").val("");
			$("#mm").val("");
			$("#th").val("");
			$("#tt").val("");
			$("#hl").val("");
		});
		
		//chart plot for error bpn
    });
</script>
  </body>
</html>
