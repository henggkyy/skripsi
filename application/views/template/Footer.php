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
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/clockpicker/clockpicker.js"></script>
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
		//Jquery untuk form input pada detail admin
		//Form terdiri dari update masa kontrak, insert jadwal bertugas baik secara auto maupun manual
		//Menggunakan library clockpicker
		//Ada pengecekan apabila input jam selesai lebih kecil daripada jam mulai
		//If Button Add Hari on click, maka akan menambah form.
		<?php
		if(isset($detail_admin) && $detail_admin){
			?>
		$('document').ready(function(){
			var form = '<div class="form-group row"><label class="col-sm-6 col-form-label">Hari Bertugas <span style="color: red">*</span> :</label><div class="col-sm-6"><select name="hari_bertugas[]" class="form-control" required><option value="" selected disabled>-- Please Select One --</option><option value="Monday">Senin</option><option value="Tuesday" >Selasa</option><option value="Wednesday" >Rabu</option><option value="Thursday" >Kamis</option><option value="Friday" >Jumat</option><option value="Saturday" >Sabtu</option></select></div></div><div class="form-group row"><label class="col-sm-6 col-form-label">Jam Mulai Bertugas <span style="color: red">*</span> :</label> <div class="col-sm-6"><input id="waktu_awal" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai[]"></div></div><div class="form-group row"><label class="col-sm-6 col-form-label">Jam Selesai Bertugas <span style="color: red">*</span> :</label><div class="col-sm-6"><input id="waktu_akhir" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai[]"></div></div>';
			

			function bindClockPicker() {
		        $('#waktu_awal').clockpicker({
					autoclose: true
				});
				$('#waktu_akhir').clockpicker({
					autoclose: true
				});
		    }
			bindClockPicker();
			$('#add_day').on('click', function(){
				$('#form_bertugas_auto').append(form);
				bindClockPicker();
			});
			$('#waktu_awal_2').clockpicker({
				autoclose: true
			});
			$('#waktu_akhir_2').clockpicker({
				autoclose: true
			});
		});
			<?php
		}
		?>
		
		$("#tgl_mulai").datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true
		});
		$("#tgl_akhir").datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true});

		$('#btn_insert_jadwal').click(function () {
			if($('#container_jadwal').css('display') == 'none'){
				$('#container_jadwal').show();
			}
			else{
				$('#container_jadwal').hide();
			}
	    });
	    
		//Method untuk mendapatkan individual jadwal admin
		function getJadwal(id_bertugas, id_admin){
		    $.ajax({
		        
		        url: "<?php echo base_url();?>" + "admin_lab/get_jadwal_bertugas",
		        method: "GET",
		        data: {id_bertugas : id_bertugas, id_admin : id_admin},
		        success: function(data) { 
		            $("#modalUpdateJadwal").html(data);
		            $('#waktu_awal_modal').clockpicker({
						autoclose: true
					});
					$('#waktu_akhir_modal').clockpicker({
						autoclose: true
					});
					$('#tanggal_modal').datepicker({
						todayBtn: "linked",
						keyboardNavigation: false,
						forceParse: false,
						calendarWeeks: true,
						autoclose: true
					});
		        }
		    }); 
		}
	</script>
	<script src="<?php echo base_url();?>assets/js/plugins/dataTables/datatables.min.js"></script>
	<script type="text/javascript">
		$('document').ready(function(){
			var input_text_pl = '<input class="form-control" type="text" required name="nama_pl" placeholder="Contoh: netbeans, spotify, googlechrome"></input>'
			var button_add_pl = $('#button_add_pl');
			$(button_add_pl).click(function(e){
		        $('#input_pl').html(input_text_pl);

		    });
			

			var header = '<h5>Pertemuan Ke - </h5>'; 
			var field_select = '<select name="hari[]" class="form-control col-md-8" required><option value="" selected disabled>-- Please Select One --</option><option value="Monday">Senin</option><option value="Tuesday" >Selasa</option><option value="Wednesday" >Rabu</option><option value="Thursday" >Kamis</option><option value="Friday" >Jumat</option><option value="Saturday" >Sabtu</option></select>';
		    var jam_mulai_html = '<div class="col-sm-8 input-group clockpicker" data-autoclose="true"><label>Jam Mulai :</label> <input type="text" name="jam_mulai[]" class="form-control" value="" data-mask="99:99" required></div>';
		    var jam_selesai_html = '<div class="col-sm-8 input-group clockpicker" data-autoclose="true"><label>Jam Selesai :</label> <input type="text" name="jam_selesai[]" class="form-control" value="" data-mask="99:99" required></div><br>';
		    
		    var maxField = 6; //Input fields increment limitation
		    var addButton = $('.add_button_pertemuan'); //Add button selector
		    var wrapper = $('#container'); //Input field wrapper
		    var x = 1; //Initial field counter is 1
		    $(addButton).click(function(e){
		    	console.log('asd');
		        //Check maximum number of input fields
		        if(x < maxField){ 
		            x++; //Increment field counter
		            $(wrapper).append('<h5>Pertemuan Ke - ' + x+'</h5>');
		            $(wrapper).append(field_select);
		            $(wrapper).append(jam_mulai_html);
		            $(wrapper).append(jam_selesai_html); //Add field html
		            $('.clockpicker').clockpicker();
		        }

		    });
		    $(wrapper).on('click', '.remove_button', function(e){
		        e.preventDefault();
		        $(this).parent('div').remove(); //Remove field html
		        x--; //Decrement field counter
		    });
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
	        <?php if(isset($jadwal_admin) && $jadwal_admin){
				?>
				$('#calendar').fullCalendar({
		            header: {
		                left: 'prev,next today',
		                center: 'title',
		                right: 'month,agendaWeek,agendaDay'
		            },
		            events: <?php echo $jadwal_json;?>
		     //        eventClick: function(event, jsEvent, view) {

					  //   $('#modal_event').modal('show');
					  //   $('#judul_event').text(event.title);
					  //   $('#event').text(event.title);
					  //   $('#start').text(event.start);
					  //   $('#end').text(event.end);
					  //   $('#lokasi_event').text(event.nama_lab);
					  // }
		        });

				<?php
			}
			?>

		});
		<?php
			if(isset($data_software_cek) && $data_software_cek){
				?>
				function periksaSoftware(id_matkul){
					var data_software_res = '<?php echo $data_software_cek;?>';
					console.log(id_matkul);
					 $.ajax({
	                    //Ganti URL nanti kl udah dipindah server
		                url: "<?php echo base_url();?>" + "administrasi_matkul/perangkat_lunak/checker",
		                method: "GET",
		                data: {data_software : data_software_res , id_matkul_cek : id_matkul},
		                success: function(data) { 
		                    $('#modal_checker').html(data);
		                    $('#modal_checker').modal('show');
		                }
		            }); 
				}
				<?php
			}
			?>
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