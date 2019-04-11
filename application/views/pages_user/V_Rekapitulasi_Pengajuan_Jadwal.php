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
                            				<label class="col-sm-4 col-form-label">Periode Akademik:</label>
                            				<div class="col-sm-8 ">
		                                        <form method="GET" action="<?php echo base_url()."rekapitulasi_pengajuan";?>">
		                                            
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
		                                        </form>
		                                    </div>
                            			</div>
                            		</div>
                        		</div>
                        	</div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox float-e-margins collapsed">
                        		<div class="ibox-title collapse-link">
								    <h5>Pengajuan Masa Perkuliahan</h5>
								    <div class="ibox-tools">
								        <a>
								            <i class="fa fa-chevron-up"></i>
								        </a>
								    </div>
								</div>
								<div class="ibox-content collapsed">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<thead>
	                                            <tr>
	                                                <th>#</th>
	                                                <th>Admin</th>
	                                                <th>Hari</th>
	                                                <th>Waktu Bertugas</th>
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
                                            			<td><?php echo $pengkul['DATE_SUBMITTED'];?></td>	
                                            			<td align="center">
                                                            <?php

                                                                if($pengkul['STATUS'] == 0 && $flag){
                                                                    echo form_open('admin_lab/accept_pengajuan_kuliah');
                                                                    ?>
                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $pengkul['ID'];?>" required>
                                                                <input type="hidden" name="id_admin" value="<?php echo $pengkul['ID_ADMIN'];?>" required>
                                                                <input type="hidden" name="method" value="rekap" required>
                                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
                                                                </form>
                                                                <?php
                                                                }
                                                                else if($pengkul['STATUS'] == 1 && $flag){
                                                                    
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($pengkul['STATUS'] == 1 && !$flag){
                                                                    echo 'Sudah disetujui';
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
                                            		echo "<tr><td colspan='6'>Belum ada Pengajuan Jadwal Bertugas yang dilakukan oleh Admin pada masa Perkuliahan!</td></tr>";
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
								    <h5>Pengajuan Masa UTS</h5>
								    <div class="ibox-tools">
								        <a>
								            <i class="fa fa-chevron-up"></i>
								        </a>
								    </div>
								</div>
								<div class="ibox-content collapsed">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<thead>
	                                            <tr>
	                                                <th>#</th>
	                                                <th>Admin</th>
	                                                <th>Hari/Tanggal</th>
	                                                <th>Waktu Bertugas</th>
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
                                            			<td><?php echo $penguts['DATE_SUBMITTED'];?></td>	
                                            			<td align="center">
                                                            <?php

                                                                if($penguts['STATUS'] == 0 && $flag){
                                                                    echo form_open('admin_lab/accept_pengajuan_ujian');
                                                                    ?>
                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $penguts['ID'];?>" required>
                                                                <input type="hidden" name="id_admin" value="<?php echo $penguts['ID_ADMIN'];?>" required>
                                                                <input type="hidden" name="method" value="rekap" required>
                                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
                                                                </form>
                                                                <?php
                                                                }
                                                                else if($penguts['STATUS'] == 1 && $flag){
                                                                    
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($penguts['STATUS'] == 1 && !$flag){
                                                                    echo 'Sudah disetujui';
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
                                            		echo "<tr><td colspan='6'>Belum ada Pengajuan Jadwal Bertugas yang dilakukan oleh Admin pada masa UTS!</td></tr>";
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
								    <h5>Pengajuan Masa UAS</h5>
								    <div class="ibox-tools">
								        <a>
								            <i class="fa fa-chevron-up"></i>
								        </a>
								    </div>
								</div>
								<div class="ibox-content collapsed">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<thead>
	                                            <tr>
	                                                <th>#</th>
	                                                <th>Admin</th>
	                                                <th>Hari/Tanggal</th>
	                                                <th>Waktu Bertugas</th>
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
                                            			<td><?php echo $penguas['DATE_SUBMITTED'];?></td>	
                                            			<td align="center">
                                                            <?php

                                                                if($penguas['STATUS'] == 0 && $flag){
                                                                    echo form_open('admin_lab/accept_pengajuan_ujian');
                                                                    ?>
                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $penguas['ID'];?>" required>
                                                                <input type="hidden" name="id_admin" value="<?php echo $penguas['ID_ADMIN'];?>" required>
                                                                <input type="hidden" name="method" value="rekap" required>
                                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
                                                                </form>
                                                                <?php
                                                                }
                                                                else if($penguas['STATUS'] == 1 && $flag){
                                                                    
                                                                    echo 'Sudah disetujui';
                                                                }
                                                                else if($penguas['STATUS'] == 1 && !$flag){
                                                                    echo 'Sudah disetujui';
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
                                            		echo "<tr><td colspan='6'>Belum ada dokumen Pengajuan Jadwal Bertugas yang dilakukan oleh Admin pada masa UAS!</td></tr>";
                                            	}
                                            	?>
                                            </tbody>
                                        </table>
									</div>	
								</div>
                        	</div>
                        </div>
                	</div>
                </div>
            </div>