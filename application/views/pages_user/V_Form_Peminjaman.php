			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                        	<div class="ibox-title">
                                <h3>Form Peminjaman Ruangan Laboratorium & Alat</h3>
                            </div>
                            <div class="ibox-content">
                            	<div class="row">
                            		<div class="alert alert-danger alert-dismissable">
		                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		                                <span style="font-weight: bold;">Peminjaman ruangan laboratorium dapat dilakukan minimal 1 minggu sebelum ruangan laboratorium akan digunakan. Untuk alat-alat, dapat dilakukan minimal 3 hari sebelum alat akan digunakan.</span>
		                            </div>
                            	</div>
                            	<?php
                            	$attributes = array('id' => 'form_peminjaman');
                            	echo form_open('peminjaman/ajuan', $attributes);?>
                            	<div class="form-group row">
			                        <label class="col-sm-4 col-form-label">Pilih Tipe Peminjaman <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <select id="choice" name="choice" required class="form-control"> 
			                                <option selected disabled value="">-- Please Select One --</option>
			                                <option value="lab">Ruangan Laboratorium</option>
			                                <option value="alat">Alat Laboratorium</option>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label class="col-sm-4 col-form-label">Acara/Keperluan <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <input type="text" class="form-control" placeholder="Contoh : Tutorial Power Point" required name="keperluan">
			                        </div>
			                    </div>
			                    <div class="form-group row " id="data_1">
			                        <label class="col-sm-4 col-form-label">Tanggal Pinjam <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6 input-group date">
			                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgl_pinjam" name="tgl_pinjam" class="form-control" placeholder="mm/dd/yyyy" data-mask="99/99/9999" onchange="checkLab();" required>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label id="label_jam_mulai" class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6 input-group clockpicker" data-autoclose="true">
			                            <input type="text" id="waktu_awal_2" name="jam_mulai" class="form-control" placeholder="09:30" data-mask="99:99" onchange="checkLab();" required>
			                            <span class="input-group-addon">
			                                <span class="fa fa-clock-o"></span>
			                            </span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label id="label_jam_selesai" class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6 input-group clockpicker" data-autoclose="true">
			                            <input type="text" id="waktu_akhir_2" name="jam_selesai" class="form-control" placeholder="09:30" data-mask="99:99" onchange="checkLab();" required>
			                            <span class="input-group-addon">
			                                <span class="fa fa-clock-o"></span>
			                            </span>
			                        </div>
			                    </div>
			                    <div class="form-group row" style="display: none;" id="div_lab">
			                        <label class="col-sm-4 col-form-label">Pilih Ruangan Laboratorium <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6" >
			                            <div id="select_lab">
			                                <span style="color: red;">Silahkan isi tanggal, jam mulai, dan jam selesai peminjaman terlebih dahulu</span>
			                            </div>
			                            
			                        </div>

			                    </div>
			                    <div class="form-group row" style="display: none;" id="div_alat">
			                        <label class="col-sm-4 col-form-label">Pilih Alat <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <select id="choice_alat" name="alat" required class="form-control"> 
			                                <option selected disabled value="">-- Please Select One --</option>
			                                <?php
			                                if(isset($daftar_alat) && $daftar_alat){
			                                    foreach ($daftar_alat as $alat) {
			                                        ?>
			                                        <option value="<?php echo $alat['ID'];?>"><?php echo $alat['NAMA_ALAT'];?></option>
			                                        <?php
			                                    }
			                                }
			                                ?>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label class="col-sm-4 col-form-label">Keterangan <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <textarea style="height: 80px;" placeholder="Dapat diisi dengan keperluan peminjaman lab, kebutuhan, dsb." name="keterangan" class="form-control" required></textarea>
			                        </div>
			                    </div>
			                    <p style="color: red;" align="center">* Wajib Diisi</p>
			                    <p id="notif" style="color: red; font-weight: bold;" align="center"></p>
			                    <div class="form-group row">
			                        <div class="col-sm-12">
			                            <button class="btn btn-primary btn-lg" type="submit" id="button_submit">Ajukan Peminjaman</button>
			                        </div>
			                    </div>
			                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
            	var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
            	function checkLab(){
            		var date_today = new Date();
            		var tanggal_data = $("#tgl_pinjam").val();
					if($("#choice").val() == 'lab'){
			           	
			            var jam_mulai_data = $("#waktu_awal_2").val();
			            var jam_selesai_data = $("#waktu_akhir_2").val();
			            var date_input = new Date(tanggal_data);
			            date_next_week = date_today.setDate(date_today.getDate()+6);
			            if(date_input < date_next_week){
			            	$('#notif').html('Tanggal peminjaman minimal harus H+7 dari tanggal hari ini!');
			            	$('#button_submit').prop('disabled', true);
			            	return;
			            }
			            else{
			            	$('#notif').html('');
			            	$('#button_submit').prop('disabled', false);
			            }
			            $("#select_lab").html(loader);
			            if(tanggal_data == "" || jam_mulai_data == "" || jam_selesai_data == ""){
			                if(tanggal_data == ""){
			                    $("#select_lab").html('<span style="color:red;">Tanggal peminjaman harus diisi terlebih dahulu!</span>');
			                }
			                else if(jam_mulai_data == ""){
			                    $("#select_lab").html('<span style="color:red;">Jam mulai peminjaman harus diisi terlebih dahulu!</span>');
			                }
			                else{
			                    $("#select_lab").html('<span style="color:red;">Jam selesai peminjaman harus diisi terlebih dahulu!</span>');
			                }
			                    
			                return;
			            }   
			            if(jam_selesai_data < jam_mulai_data){
			                $("#select_lab").html('<span style="color:red;">Jam mulai tidak boleh melebihi jam selesai!</span>');
			                return;
			            }
			            console.log(tanggal_data);
			            console.log(jam_mulai_data);
			            console.log(jam_selesai_data);
			               
			                
			            $.ajax({
			                    //Ganti URL nanti kl udah dipindah server
				            url: "<?php echo base_url('ketersediaan_lab'); ?>",
				            method: "GET",
				            data: {tanggal : tanggal_data, jam_mulai : jam_mulai_data, jam_selesai : jam_selesai_data},
				            success: function(data) { 
				                $("#select_lab").html(data);
				                $('#button_submit').prop('disabled', false);
				            },
					        error: function() {
					            alert('error!');
					        }
			            }); 
					}
					else{
						var date_input = new Date(tanggal_data);
			            date_next_week = date_today.setDate(date_today.getDate()+2);
			            if(date_input < date_next_week){
			            	$('#notif').html('Tanggal peminjaman minimal harus H+3 dari tanggal hari ini!');
			            	$('#button_submit').prop('disabled', true);
			            	
			            }
			            else{
			            	$('#notif').html('');
			            	$('#button_submit').prop('disabled', false);
			            }
					}	
				}
		$("#choice").change(function(e){
	        if($("#choice").val() == 'lab'){
	            $('#button_submit').prop('disabled', true);
	            $("#div_alat").hide();
	            $("#choice_alat").prop('required',false);
	            $("#div_lab").show();
	            $("#choice_lab").prop('required',true);
	            checkLab();
	        }
	        else{
	            $("#div_alat").show();
	            $("#choice_alat").prop('required',true);
	            $("#div_lab").hide();
	            $("#choice_lab").prop('required',false);
	            $('#button_submit').prop('disabled', false);
	            checkLab();
	        }
	    });
            </script>