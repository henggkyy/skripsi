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
                                	<?php
                                	if(!$is_aktif){
                                		echo '<h4 style="color:red;">Tidak dapat melakukan input laporan gaji/absensi karena tidak ada periode gaji yang sedang aktif!</h4>';
                                	}
                                	else{
                                		?>
                                		<form method="get" action="<?php echo base_url();?>laporan_gaji/input">
                                		<div class="form-group">
	                                		<label class="col-sm-4 col-form-label">Pilih Periode Input Gaji/Laporan :</label>
	                                		<div class="col-sm-8">
	                                			<select class="form-control" name="id_periode" required>
		                                			<?php
		                                			if(isset($data_aktif) && $data_aktif){
		                                				foreach ($data_aktif as $aktif) {
		                                					?>
		                                				<option value="<?php echo $aktif['ID'];?>"><?php echo $aktif['KETERANGAN']. ' ('. $aktif['START_PERIODE']. ' s/d '.$aktif['END_PERIODE'].') ';?></option>
		                                					<?php
		                                				}
		                                			}
		                                			?>
		                                		</select>
	                                		</div>
                                		</div>
                                		<div class="form-group" >
                                			<label class="col-sm-4 col-form-label" style="margin-top: 15px;">Pilih Admin :</label>
	                                		<div class="col-sm-8">
	                                			<select style="margin-top: 15px;" class="form-control" name="id_admin" required>
	                                				<option value="" disabled selected>-- Please Select One --</option>
		                                			<?php
		                                			if(isset($data_admin) && $data_admin){
		                                				foreach ($data_admin as $admin) {
		                                					?>
		                                				<option value="<?php echo $admin['ID'];?>"><?php echo $admin['NAMA']. ' ('. $admin['EMAIL']. '/'.$admin['NIK'].') ';?></option>
		                                					<?php
		                                				}
		                                			}
		                                			else{
		                                				echo '<h4 style="color:red;">Tidak dapat melakukan input laporan gaji/absensi karena tidak ada admin yang terdaftar!</h4>';
		                                			}
		                                			?>
		                                		</select>
	                                		</div>
                                		</div>
                                		<div class="form-group" >
                                			<div class="col-sm-12" style="margin-top: 25px;">
                                				<button style="display: block; margin: 0 auto;" class="btn btn-primary btn-lg">Next <i class="fas fa-arrow-right"></i></button>
                                			</div>
                                		</div>
                                		</form>
										<?php
                                	}
                                	?>
                                	</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>