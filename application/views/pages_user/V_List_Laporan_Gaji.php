			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                    	<div class="col-lg-12">
                            <div class="ibox float-e-margins">
                            	<div class="ibox-title">
                            		<h3>Histori Laporan Gaji/Absensi Admin</h3>
                            	</div>
                            	<div class="ibox-content">
                            		<div class="row">
                            			<div class="form-group">
                            				<label class="col-sm-4 col-form-label">Periode Gaji:</label>
                                    		<div class="col-sm-8 ">
                                    			<form method="GET" action="<?php echo base_url()."laporan_gaji/report";?>">
	                                    			<select name="id_periode" onchange="this.form.submit()" class="form-control">
		                                                <?php
		                                                if(isset($data_periode) && $data_periode){
		                                                    foreach ($data_periode as $list_periode) {
		                                                ?>
		                                                <option value="<?php echo $list_periode['ID'];?>" <?php if($list_periode['ID'] == $id_periode_aktif){ echo 'selected';}?>><?php echo $list_periode['KETERANGAN']." (".$list_periode['START_PERIODE']." s/d ".$list_periode['END_PERIODE'].") ";?></option>
		                                                <?php
		                                                    }
		                                                }
		                                                ?>
		                                            </select>
	                                        	</form>
                                    		</div>
                            			</div>
                            		</div>
                            		<hr>
                            		<h4>Daftar Admin</h4>
                            		<div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php if(isset($data_admin) && $data_admin){ echo 'mainDataTable';}?>">
                                        	<thead>
                                        		<tr>
	                                                <th>#</th>
	                                                <th>Data Admin</th>
	                                                <th>Periode Gaji</th>
	                                                <th>Status</th>
	                                                <th>Jumlah Hari Masuk</th>
	                                                <th>Aksi</th>
	                                            </tr>
                                        	</thead>
                                        	<tbody>
                                        		<?php
                                        		if(isset($data_admin) && $data_admin){
                                        			$iterator = 1;
                                        			foreach ($data_admin as $admin) {
                                        				?>
                                        			<tr>
                                        				<td><?php echo $iterator;?></td>
                                        				<td><?php echo $admin['NAMA']." (".$admin['NIK']." / ".$admin['EMAIL'].") ";?></td>
                                        				<td><?php echo $ket_periode;?></td>
                                        				<td>
                                        					<?php if($admin['STATUS'] == 1){
                                                            echo 'Aktif';
                                                        }
                                                        else{
                                                            echo 'Tidak Aktif';
                                                        }
                                                        ?>
                                        				</td>
                                        				<td>
                                        					<?php
                                        					if(isset($jmlh_masuk) && $jmlh_masuk){
                                        						foreach ($jmlh_masuk as $jumlah) {
                                        							if($admin['ID'] == $jumlah[0]){
                                        								echo $jumlah[1];
                                        							}
                                        						}
                                        					}
                                        					?>
                                        				</td>
                                        				<td>
                                        					<a href="<?php echo base_url();?>laporan_gaji/detail?id_periode=<?php echo $id_periode_aktif;?>&id_admin=<?php echo $admin['ID'];?>" class="btn btn-sm btn-primary"><i class="fas fa-info"></i> Detail</a>
                                        					<a target="_blank" href="<?php echo base_url();?>laporan_gaji/cetak?id_periode=<?php echo $id_periode_aktif;?>&id_admin=<?php echo $admin['ID'];?>" class="btn btn-sm btn-success"><i class="fas fa-print"></i> Print</a>
                                        				</td>
                                        			</tr>
                                        				<?php
                                        			$iterator++;
                                        			}
                                        		}
                                        		else{
                                        			echo "<tr><td colspan='6'>Belum ada dokumen SOP</td></tr>";
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