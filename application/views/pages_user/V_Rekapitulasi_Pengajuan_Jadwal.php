 			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                	<div class="row">
                	 	<div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <?php $this->load->view('pages_user/V_Template_Periode_Aktif');?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox float-e-margins">
                        		<div class="ibox-content">
                        			<div class="row">
                            			<div class="form-group">
                                            <form method="GET" action="<?php echo base_url()."admin_lab/rekapitulasi_pengajuan";?>">
                            				<label class="col-sm-4 col-form-label">Periode Akademik : </label>
                            				<div class="col-sm-8">
		                                       <select name="id_periode" onchange="this.form.submit()" class="form-control">
		                                                    <?php
		                                                    if(isset($daftar_periode) && $daftar_periode){
		                                                        foreach ($daftar_periode as $list_periode) {
		                                                    ?>
		                                        <option value="<?php echo $list_periode['ID'];?>" <?php if($list_periode['ID'] == $id_periode_aktif){ echo 'selected';}?>><?php echo $list_periode['NAMA'];?></option>
		                                                    <?php
		                                                        }
		                                                    }
		                                                    ?>
		                                        </select>
		                                    </div>
                                            <br>
                                            <label style="margin-top: 15px;" class="col-sm-4 col-form-label">Hari : </label>
                                            <div class="col-sm-8" style="margin-top: 15px;">
                                                <select name="day"  onchange="this.form.submit()" class="form-control">
                                                    <option <?php if($day == 99){ echo 'selected';}?> value="99">All</option>
                                                    <option <?php if($day == 1){ echo 'selected';}?> value="1">Senin</option>
                                                    <option <?php if($day == 2){ echo 'selected';}?> value="2">Selasa</option>
                                                    <option <?php if($day == 3){ echo 'selected';}?> value="3">Rabu</option>
                                                    <option <?php if($day == 4){ echo 'selected';}?> value="4">Kamis</option>
                                                    <option <?php if($day == 5){ echo 'selected';}?> value="5">Jumat</option>
                                                    <option <?php if($day == 6){ echo 'selected';}?> value="6">Sabtu</option>
                                                    <option <?php if($day == 7){ echo 'selected';}?> value="7">Minggu</option>
                                                </select>
                                            </div>
                                            </form>
                            			</div>
                            		</div>
                        		</div>
                        	</div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox float-e-margins collapsed">
                        		<div class="ibox-title collapse-link">
								    <h5>Pengajuan Masa Perkuliahan</h5>
								    <div class="ibox-tools" style="float:left;">
								        <a>
								            <i class="fa fa-chevron-up"></i>
								        </a>
								    </div>
								</div>

								<div class="ibox-content collapsed">
                                    <div class="row">
                                        <h4>Timetable Jadwal Bertugas Admin (Masa Perkuliahan)</h4>
                                        <div class="tiva-timetable" tipe-bertugas="1" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="week" data-mode="day" data-header-time="hide">
                                        </div>
                                    </div>
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<thead>
	                                            <tr>
	                                                <th>#</th>
	                                                <th>Admin</th>
	                                                <th>Hari</th>
	                                                <th>Waktu Bertugas Yang Diajukan</th>
                                                    <th>Waktu Bertugas Yang Disetujui</th>
	                                                <th>Last Update</th>
	                                                <th>Action</th>
	                                            </tr>
                                            </thead>
                                            <tbody>
                                            	<?php
                                            	if(isset($pengajuan_kuliah) && $pengajuan_kuliah){
                                            		$iterator = 1;
                                            		foreach ($pengajuan_kuliah as $pengkul) {
                                            			?>
                                            		<tr>
                                            			<td><?php echo $iterator;?></td>
                                            			<td><?php echo $pengkul['NAMA'];?></td>	
                                            			<td><?php echo $pengkul['HARI'];?></td>	
                                            			<td><?php echo $pengkul['JAM_MULAI'].' s/d '.$pengkul['JAM_SELESAI'];?></td>
                                                        <td>
                                                        <?php
                                                        if($pengkul['JAM_MULAI_DISETUJUI'] != NULL){
                                                            echo $pengkul['JAM_MULAI_DISETUJUI'].' s/d '.$pengkul['JAM_SELESAI_DISETUJUI'];
                                                        }
                                                        else{
                                                            echo '-';
                                                        }?>
                                                        </td>      
                                            			<td><?php echo $pengkul['DATE_SUBMITTED'];?></td>	
                                            			<td align="center">
                                                            <?php

                                                                if($pengkul['STATUS'] == 0 && $flag){
                                                                    
                                                                    ?>
                                                                <button type="submit" onclick="loadModalAccept(<?php echo $pengkul['ID'];?>, <?php echo $pengkul['ID_ADMIN'];?>,0, 'rekap');" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
                                                                <?php
                                                                echo form_open('admin_lab/reject_pengajuan');
                                                                ?>
                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $pengkul['ID'];?>" required>
                                                                <input type="hidden" name="id_admin" value="<?php echo $pengkul['ID_ADMIN'];?>" required>
                                                                <input type="hidden" name="method" value="rekap" required>
                                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan jadwal ini?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
                                                                </form>
                                                                <?php
                                                                }
                                                                else if($pengkul['STATUS'] == 1 && $flag){
                                                                    
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($pengkul['STATUS'] == 1 && !$flag){
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($pengkul['STATUS'] == 2){
                                                                    echo 'Tidak disetujui';
                                                                }
                                                                else{
                                                                    echo '-';
                                                                }
                                                                ?>         
                                                        </td>	
                                            		</tr>
                                            			
                                            			<?php
                                            			$iterator++;
                                            		}
                                            	}
                                            	else{
                                            		echo "<tr><td colspan='7'>Belum ada Pengajuan Jadwal Bertugas yang dilakukan oleh Admin pada masa Perkuliahan!</td></tr>";
                                            	}
                                            	?>
                                            </tbody>
                                        </table>
									</div>	
								</div>
                        	</div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox float-e-margins collapsed">
                        		<div class="ibox-title collapse-link">
								    <h5>Pengajuan Masa Ujian (UTS/UAS)</h5>
								    <div class="ibox-tools" style="float:left;">
								        <a>
								            <i class="fa fa-chevron-up"></i>
								        </a>
								    </div>
								</div>
								<div class="ibox-content collapsed">
                                    <div class="row">
                                        <h4>Timetable Jadwal Bertugas Admin (Masa UTS/UAS)</h4>
                                        <p align="center" style="color: red;">Untuk melihat jadwal bertugas pada masa UTS/UAS, silahkan geser tanggal ke minggu periode UTS/UAS</p>
                                        <div class="tiva-timetable" tipe-bertugas="2" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="week">
                                        </div>
                                    </div>
									<div class="table-responsive">
                                        <h4>Tabel Pengajuan masa UTS</h4>
										<table class="table table-striped table-bordered table-hover">
											<thead>
	                                            <tr>
	                                                <th>#</th>
	                                                <th>Admin</th>
	                                                <th>Hari/Tanggal</th>
	                                                <th>Waktu Bertugas Yang Diajukan</th>
                                                    <th>Waktu Bertugas Yang Disetujui</th>
	                                                <th>Last Update</th>
	                                                <th>Action</th>
	                                            </tr>
                                            </thead>
                                            <tbody>
                                            	<?php
                                            	if(isset($pengajuan_uts) && $pengajuan_uts){
                                            		$iterator = 1;
                                            		foreach ($pengajuan_uts as $penguts) {
                                            			?>
                                            		<tr>
                                            			<td><?php echo $iterator;?></td>
                                            			<td><?php echo $penguts['NAMA'];?></td>	
                                            			<td><?php echo $penguts['HARI']."/".$penguts['TANGGAL'];?></td>	
                                            			<td><?php echo $penguts['JAM_MULAI'].' s/d '.$penguts['JAM_SELESAI'];?></td>
                                                        <td>
                                                        <?php
                                                        if($penguts['JAM_MULAI_DISETUJUI'] != NULL){
                                                            echo $penguts['JAM_MULAI_DISETUJUI'].' s/d '.$penguts['JAM_SELESAI_DISETUJUI'];
                                                        }
                                                        else{
                                                            echo '-';
                                                        }?>
                                                        </td>  	
                                            			<td><?php echo $penguts['DATE_SUBMITTED'];?></td>	
                                            			<td align="center">
                                                            <?php

                                                                if($penguts['STATUS'] == 0 && $flag){
                                                                    ?>
                                                                
                                                                <button type="submit" onclick="loadModalAccept(<?php echo $penguts['ID'];?>, <?php echo $penguts['ID_ADMIN'];?>, 1, 'rekap');" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
                                                                <?php
                                                                echo form_open('admin_lab/reject_pengajuan');
                                                                ?>
                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $penguts['ID'];?>" required>
                                                                <input type="hidden" name="id_admin" value="<?php echo $penguts['ID_ADMIN'];?>" required>
                                                                <input type="hidden" name="method" value="rekap" required>
                                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan jadwal ini?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
                                                                </form>
                                                                <?php
                                                                }
                                                                else if($penguts['STATUS'] == 1 && $flag){
                                                                    
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($penguts['STATUS'] == 1 && !$flag){
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($penguts['STATUS'] == 2){
                                                                    echo 'Tidak disetujui';
                                                                }
                                                                else{
                                                                    echo '-';
                                                                }
                                                                ?>         
                                                        </td>	
                                            		</tr>
                                            			
                                            			<?php
                                            			$iterator++;
                                            		}
                                            	}
                                            	else{
                                            		echo "<tr><td colspan='7'>Belum ada Pengajuan Jadwal Bertugas yang dilakukan oleh Admin pada masa UTS!</td></tr>";
                                            	}
                                            	?>
                                            </tbody>
                                        </table>
                                        <h4>Table pengajuan masa UAS</h4>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Admin</th>
                                                    <th>Hari/Tanggal</th>
                                                    <th>Waktu Bertugas Yang Diajukan</th>
                                                    <th>Waktu Bertugas Yang Disetujui</th>
                                                    <th>Last Update</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($pengajuan_uas) && $pengajuan_uas){
                                                    $iterator = 1;
                                                    foreach ($pengajuan_uas as $penguas) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $penguas['NAMA'];?></td> 
                                                        <td><?php echo $penguas['HARI']."/".$penguas['TANGGAL'];?></td> 
                                                        <td><?php echo $penguas['JAM_MULAI'].' s/d '.$penguas['JAM_SELESAI'];?></td>
                                                        <td>
                                                        <?php
                                                        if($penguas['JAM_MULAI_DISETUJUI'] != NULL){
                                                            echo $penguas['JAM_MULAI_DISETUJUI'].' s/d '.$penguas['JAM_SELESAI_DISETUJUI'];
                                                        }
                                                        else{
                                                            echo '-';
                                                        }?>    
                                                        </td>
                                                        <td><?php echo $penguas['DATE_SUBMITTED'];?></td>   
                                                        <td align="center">
                                                            <?php

                                                                if($penguas['STATUS'] == 0 && $flag){
                                                                    ?>
                                                                
                                                                <button type="submit" onclick="loadModalAccept(<?php echo $penguas['ID'];?>, <?php echo $penguas['ID_ADMIN'];?>,2,'rekap');" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
                                                                <?php
                                                                echo form_open('admin_lab/reject_pengajuan');
                                                                ?>
                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $penguas['ID'];?>" required>
                                                                <input type="hidden" name="id_admin" value="<?php echo $penguas['ID_ADMIN'];?>" required>
                                                                <input type="hidden" name="method" value="rekap" required>
                                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan jadwal ini?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
                                                                </form>
                                                                <?php
                                                                }
                                                                else if($penguas['STATUS'] == 1 && $flag){
                                                                    
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($penguas['STATUS'] == 1 && !$flag){
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($penguas['STATUS'] == 2){
                                                                    echo 'Tidak disetujui';
                                                                }
                                                                else{
                                                                    echo '-';
                                                                }
                                                                ?>          
                                                        </td>   
                                                    </tr>
                                                        
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='7'>Belum ada Pengajuan Jadwal Bertugas yang dilakukan oleh Admin pada masa UAS!</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
									</div>	
								</div>
                        	</div>
                        </div>
                    
                        
                        <div class="col-lg-4">
                            <a class="btn btn-md btn-primary" href="<?php echo base_url();?>admin_lab"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                	</div>
                </div>
            </div>
            <div class="modal inmodal" id="modalAccept" tabindex="-1" role="dialog"  aria-hidden="true">
            	<div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                    	<div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Setujui Pengajuan Jadwal Bertugas Admin</h4>
                        </div>
                        <div class="modal-body" id="modal-content">
                        	<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
            	var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
                function loadModalAccept(id, id_admin, tipe_bertugas, method){
                    $("#modal-content").html(loader);
                    $('#modalAccept').modal('show');
                    $.ajax({
                        url: "<?php echo base_url();?>" + "admin_lab/get_pengajuan",
                        method: "GET",
                        data: {id : id, id_admin : id_admin, tipe_bertugas:tipe_bertugas, method:method},
                        success: function(data) { 
                            $("#modal-content").html(data);
                            $('#waktu_awal_modal').clockpicker({
                                autoclose: true
                            });
                            $('#waktu_akhir_modal').clockpicker({
                                autoclose: true
                            });
                        }
                    }); 
                }
            </script>
            <script src="<?php echo base_url();?>assets/js/timetable.min.js"></script>
            