<div class="footer">
			<div>
				<strong>Copyright</strong> Universitas Katolik Parahyangan &copy; 2018-2019
			</div>
		</div>
	</div>

	<!-- Mainly scripts -->
	<script type="text/javascript" src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js'></script>
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>
	<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.24/themes/start/jquery-ui.css" type="text/css" />
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.24/jquery-ui.min.js" type="text/javascript"></script>
	<script src="https://github.com/pipwerks/PDFObject/blob/master/pdfobject.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		var mem = $('#data_1 .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true
		});
	</script>
	<script src="<?php echo base_url();?>assets/js/plugins/dataTables/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.mainDataTable').DataTable({
				pageLength: 25,
				responsive: true

			});
			
	
		});

	</script>
	<!-- Flot -->
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.spline.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.resize.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.symbol.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/flot/jquery.flot.time.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="<?php echo base_url();?>assets/js/inspinia.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/pace/pace.min.js"></script>
</body>
</html>