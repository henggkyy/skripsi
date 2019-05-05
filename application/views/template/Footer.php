<div class="footer">
			<div>
				<strong>Copyright</strong> Universitas Katolik Parahyangan &copy; 2018-2019
			</div>
		</div>
	</div>
<?php
                                                            if(isset($daftar_lab) && $daftar_lab && isset($page_detail_matkul)){
                                                                $option = "";
                                                                foreach ($daftar_lab as $lab ) {
                                                                    $option.= '<option value="'.$lab['ID'].'">'.$lab['NAMA_LAB']." (".$lab['LOKASI'].") </option>";
                                                                }
                                                            }?>
	<!-- Mainly scripts -->
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css" type="text/css" />
	<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js" type="text/javascript"></script>

	<script src="<?php echo base_url();?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/clockpicker/clockpicker.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/iCheck/icheck.min.js"></script>
	<script type="text/javascript">
		$('.color_picker').colorpicker();
		var mem = $('#data_1 .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true
		});
		<?php
		if(isset($form_peminjaman) && $form_peminjaman){
			?>

		
			<?php
		}
		?>
		//Jquery untuk form input pada detail admin
		//Form terdiri dari update masa kontrak, insert jadwal bertugas baik secara auto maupun manual
		//Menggunakan library clockpicker
		//Ada pengecekan apabila input jam selesai lebih kecil daripada jam mulai
		//If Button Add Hari on click, maka akan menambah form.
		<?php
		if((isset($detail_admin) && $detail_admin) || isset($jadwal_admin_flag) && $jadwal_admin_flag){
			?>
		$('document').ready(function(){
			var form = '<div class="form-group row"><label class="col-sm-6 col-form-label">Hari Bertugas <span style="color: red">*</span> :</label><div class="col-sm-6"><select name="hari_bertugas[]" class="form-control" required><option value="" selected disabled>-- Please Select One --</option><option value="Monday">Senin</option><option value="Tuesday" >Selasa</option><option value="Wednesday" >Rabu</option><option value="Thursday" >Kamis</option><option value="Friday" >Jumat</option><option value="Saturday" >Sabtu</option></select></div></div><div class="form-group row"><label class="col-sm-6 col-form-label">Jam Mulai Bertugas <span style="color: red">*</span> :</label> <div class="col-sm-6"><input id="waktu_awal" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai[]"></div></div><div class="form-group row"><label class="col-sm-6 col-form-label">Jam Selesai Bertugas <span style="color: red">*</span> :</label><div class="col-sm-6"><input id="waktu_akhir" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai[]"></div></div>';
			

			$('#waktu_awal').clockpicker({
				autoclose: true
			});
			$('#waktu_akhir').clockpicker({
				autoclose: true
			});
			$('#add_day').on('click', function(){
				$('#form_bertugas_auto').append(form);
				
				$('#waktu_awal').clockpicker({
					autoclose: true
				});
				$('#waktu_akhir').clockpicker({
					autoclose: true
				});
			});
			
		});
			<?php
		}
		?>
		$('#waktu_awal_uas').clockpicker({
			autoclose: true
		});
		$('#waktu_akhir_uas').clockpicker({
			autoclose: true
		});
		$('#waktu_awal_2').clockpicker({
			autoclose: true
		});
		$('#waktu_akhir_2').clockpicker({
			autoclose: true
		});
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
			var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
			$("#modal-content").html(loader);
		    $.ajax({
		        
		        url: "<?php echo base_url();?>" + "admin_lab/get_jadwal_bertugas",
		        method: "GET",
		        data: {id_bertugas : id_bertugas, id_admin : id_admin},
		        success: function(data) { 

		            $("#modal-content").html(data);
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
			
			var input_text_pl = '<input class="form-control" type="text" required name="nama_pl" placeholder="Contoh: netbeans, spotify, googlechrome"></input><p style="color:red;font-size:10px;">Tulis nama software tanpa menggunakan spasi!</p>'
			var button_add_pl = $('#button_add_pl');
			$(button_add_pl).click(function(e){
		        $('#input_pl').html(input_text_pl);
		        $('#manual_add_pl').hide();
		    });
			
			$('.clockpicker').clockpicker();
			<?php
			if( isset($page_detail_matkul) && $page_detail_matkul){
				?>
			var header = '<h5>Pertemuan Ke - </h5>'; 
            
                
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
                    $(wrapper).append('<select name="hari[]" id="select_'+x+'" class="form-control col-md-8" required><option value="" selected disabled>-- Please Select One --</option><option value="1">Senin</option><option value="2" >Selasa</option><option value="3" >Rabu</option><option value="4" >Kamis</option><option value="5" >Jumat</option><option value="6" >Sabtu</option></select>');
                    $(wrapper).append('<div class="col-sm-8 input-group clockpicker" data-autoclose="true"><label>Jam Mulai :</label> <input id="jam_mulai_'+x+'" type="text" name="jam_mulai[]" class="form-control" value="" data-mask="99:99" required></div>');
                    $(wrapper).append('<div class="col-sm-8 input-group clockpicker" data-autoclose="true"><label>Jam Selesai :</label> <input id="jam_selesai_'+x+'" type="text" name="jam_selesai[]" class="form-control" value="" data-mask="99:99" required></div>'); //Add field html
                    $(wrapper).append('<label>Ruangan Laboratorium :</label><select name="lab[]" class="form-control" required><option value="" disabled selected>-- Please Select One --</option>'+'<?php echo $option;?>'+'</select><br>');
                    $('.clockpicker').clockpicker();
                }
            });
				<?php
			}
			?>
            

			$('.mainDataTable').DataTable({
				pageLength: 25,
				responsive: true

			});

			$('#range_periode .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

		});
		<?php
			if(isset($data_software_cek) && $data_software_cek){
				?>
				function periksaSoftware(id_matkul){
					var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
					
					var data_software_res = '<?php echo $data_software_cek;?>';
					$('#modal_checker').modal('show');
					$('#modal_checker').html(loader);
					console.log(id_matkul);
					 $.ajax({
	                    //Ganti URL nanti kl udah dipindah server
		                url: "<?php echo base_url();?>" + "administrasi_matkul/perangkat_lunak/checker",
		                method: "POST",
		                type:"POST",
		                data: {data_software : data_software_res , id_matkul_cek : id_matkul},
		                success: function(data) { 
		                    $('#modal_checker').html(data);
		                    
		                }
		            }); 
				}
				<?php
			}
			?>
		$(".input_pdf").change(function(e){
			var file = e.target.files[0];
			var filesize = e.target.files[0].size;
			var name = e.target.files[0].name;
			name = name.toLowerCase();
			var extension = name.substr( (name.lastIndexOf('.') +1) );
			switch(extension) {
				case 'pdf':

				break;
				default:
				$( this ).val('');
				   	alert('Ektensi file tidak sesuai! Ekstensi harus .pdf');
				    return false;
				}
				if (filesize > 2140000) {
				    $( this ).val('');
					alert('Ukuran File '+ name +' tidak boleh melebihi 2 MB. File ini berukuran ' + filesize/1024/1024+' MB');
				    return false;
				}
		});
		$(".input_custom_file").change(function(e){
			var file = e.target.files[0];
			var filesize = e.target.files[0].size;
			var name = e.target.files[0].name;
			name = name.toLowerCase();
			var extension = name.substr( (name.lastIndexOf('.') +1) );
			switch(extension) {
				case 'pdf':
				case 'zip':
				case 'docx':
				break;
				default:
				$( this ).val('');
				   	alert('Ektensi file tidak sesuai! Ekstensi harus .pdf/.zip/.docx');
				    return false;
				}
				if (filesize > 2140000) {
				    $( this ).val('');
					alert('Ukuran File '+ name +' tidak boleh melebihi 2 MB. File ini berukuran ' + filesize/1024/1024+' MB');
				    return false;
				}
		});
		
	</script>
	<!-- Custom and plugin javascript -->
	<script src="<?php echo base_url();?>assets/js/inspinia.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.js"></script>
	<script src="<?php echo base_url();?>assets/js/timetable.js"></script>
	<script src="<?php echo base_url();?>assets/js/plugins/pace/pace.min.js"></script>

</body>
</html>