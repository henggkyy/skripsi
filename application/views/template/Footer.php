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
	<script src="<?php echo base_url();?>assets/js/plugins/fullcalendar/moment.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
	<script type="text/javascript">
		var mem = $('#data_1 .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true
		});
		function addFields(){
		    // Number of inputs to create
		    var number = document.getElementById("jml_pertemuan").value;
		    // Container <div> where dynamic content will be placed
		    var container = document.getElementById("container");
		    // Clear previous contents of the container
		    while (container.hasChildNodes()) {
		        container.removeChild(container.lastChild);
		    }
		    for (i=0;i<number;i++){
		        // Append a node with a random text
		        container.appendChild(document.createTextNode("Pertemuan ke- " + (i+1)));
		        // Create an <input> element, set its type and name attributes
		        var input = document.createElement("input");
		        input.type = "text";
		        input.name = "hari[]";
		        input.placeholder = "Hari";
		        input.id = 'hari'+i;
		        input.className = "form-control col-md-8 npm";
		        input.setAttribute('required', 'true');
		        var input2 = document.createElement("input");
		        input2.type = "text";
		        input2.id = "jam_mulai"+i;
		        input2.name = "jam_mulai[]";
		        input2.placeholder = "Jam Mulai";
		        input2.className = "form-control col-md-3";
		        input2.setAttribute('required', 'true');
		        input.setAttribute("target", input2.id);
		        // input.onchange = function(){getData(input.value,input2.id);};
		        container.appendChild(input);
		        container.appendChild(input2);
		        // Append a line break 
		        container.appendChild(document.createElement("br"));
		    }
		}
	</script>
	<script src="<?php echo base_url();?>assets/js/plugins/dataTables/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.mainDataTable').DataTable({
				pageLength: 25,
				responsive: true

			});
			$('#range_periode .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

			<?php if(isset($jadwal) && $jadwal){
				?>
				$('#calendar').fullCalendar({
		            header: {
		                left: 'prev,next today',
		                center: 'title',
		                right: 'month,agendaWeek,agendaDay'
		            },
		            events: <?php echo $jadwal;?>,
		            eventClick: function(event, jsEvent, view) {

					    $('#modal_event').modal('show');
					    $('#judul_event').text(event.title);
					    $('#event').text(event.title);
					    $('#start').text(event.start);
					    $('#end').text(event.end);
					    $('#lokasi_event').text(event.nama_lab);
					  }
		        });
				<?php
			}
			?>
	        

		});
		$(".input_pdf").change(function(e){
			var file = e.target.files[0]
			var filesize = e.target.files[0].size;
			var name = e.target.files[0].name;
			var extension = name.substr( (name.lastIndexOf('.') +1) );
			switch(extension) {
				case 'pdf':
				break;
				default:
				$( this ).val('');
				   	alert('Ektensi file tidak sesuai! Ekstensi harus .pdf');
				    return false;
				}
				if (filesize > 4142880) {
				    $( this ).val('');
					alert('Ukuran File '+ name +' tidak boleh melebihi 5 MB. File ini berukuran ' + filesize/1024/1024+' MB');
				    return false;
				}
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