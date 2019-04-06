			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                    	<div class="col-lg-12">
                            <div class="ibox float-e-margins">
                            	<div class="ibox-title">
                                    <h3>Input Laporan Gaji/Absensi Admin</h3>
                                </div>
                                <div class="ibox-content">
                                	<div class="row">
                                        <?php echo form_open('laporan_gaji/proses_input_gaji');?>
                                    		<div class="form-group">
    	                                		<label class="col-sm-4 col-form-label">Periode Input Gaji/Laporan :</label>
    	                                		<div class="col-sm-8">
    		                                			<?php
    		                                			if(isset($data_aktif) && $data_aktif){
    		                                				foreach ($data_aktif as $aktif) {
                                                                $id_periode = $aktif['ID'];
    		                                					echo "<h4>".$aktif['KETERANGAN']." (".$aktif['START_PERIODE']." s/d ".$aktif['END_PERIODE'].") "."</h4>";
    		                                				}
    		                                			}
    		                                			?>
    	                                		</div>
                                    		</div>
                                    		<div class="form-group">
                                    			<label class="col-sm-4 col-form-label">Admin :</label>
    	                                		<div class="col-sm-8">
    		                                			<?php
    		                                			if(isset($data_admin) && $data_admin){
    		                                				foreach ($data_admin as $admin) {
                                                                $id_admin = $admin['ID'];
    		                                					echo "<h4>".$admin['NAMA']." (".$admin['NIK']." / ".$admin['EMAIL'].") "."</h4>";
    		                                				}
    		                                			}
    		                                			else{
    		                                				echo '<h4 style="color:red;">Tidak dapat melakukan input laporan gaji/absensi karena tidak ada admin yang terdaftar!</h4>';
    		                                			}
    		                                			?>
    	                                		</div>
                                    		</div>
                                            <div class="form-group">
                                                <label class="col-sm-4 col-form-label" style="margin-top : 20px;">Tanggal Masuk : <span style="color: red">*</span></label>
                                                <div class="col-sm-8" style="margin-top : 20px;">
                                                    <input class="form-control" type="text" id="tgl_mulai" name="tgl_masuk" required placeholder="mm/dd/yyyy" data-mask="99/99/9999">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 col-form-label" style="margin-top : 20px;">Jam Masuk : <span style="color: red">*</span></label>
                                                <div class="col-sm-8" style="margin-top : 20px;">
                                                    <input class="form-control" type="text" id="waktu_awal_2" name="jam_mulai" required placeholder="hh:mm" data-mask="99:99">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 col-form-label" style="margin-top : 20px;">Jam Pulang : <span style="color: red">*</span></label>
                                                <div class="col-sm-8" style="margin-top : 20px;">
                                                    <input class="form-control" type="text" id="waktu_akhir_2" name="jam_selesai" required placeholder="hh:mm" data-mask="99:99">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 col-form-label" style="margin-top : 20px;">Jumlah Istirahat (Dalam Jam) <span style="color: red">*</span> :</label>
                                                <div class="col-sm-8" style="margin-top : 20px;">
                                                    <input class="form-control" type="number" name="istirahat" min="0" value="0" required >
                                                </div>
                                            </div>
                                            <input type="hidden" name="id_periode" value="<?php echo $id_periode;?>" required>
                                            <input type="hidden" name="id_admin" value="<?php echo $id_admin;?>" required>
                                    		<div class="form-group">
                                    			<div class="col-sm-12"  style="margin-top : 20px;">
                                                    <p style="color: red; font-weight: bold;" align="center">* Required Field</p>
                                    				<button type="submit" style="display: block; margin: 0 auto;" class="btn btn-primary btn-lg">Simpan <i class="fas fa-arrow-right"></i></button>
                                    			</div>
                                    		</div>
                                        <form>
                                	</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>