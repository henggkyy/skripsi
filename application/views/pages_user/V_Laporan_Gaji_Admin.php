 			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                	<h3>Daftar Laporan Absensi/Gaji Admin</h3>
                                </div>
                                <div class="ibox-content">
                                	<?php
                                	if(isset($detail_admin) && $detail_admin){
                                		foreach ($detail_admin as $admin) {
                                			?>
                                	<h4><span style="font-weight: bold;">Nama : </span><?php echo $admin['NAMA'];?></h4>
                                	<h4><span style="font-weight: bold;">NIK : </span><?php echo $admin['NIK'];?></h4>
                                	<h4><span style="font-weight: bold;">Email : </span><?php echo $admin['EMAIL'];?></h4>
                                			<?php
                                		}
                                	}
                                	?>
                                	<h4><span style="font-weight: bold;">Periode Gaji/Absensi : </h4>
                                		
                                			<form method="GET" action="<?php echo base_url()."laporan_gaji";?>">
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
                                	
                                	<br>
                                	<a style="float: right;" target="_blank" href="<?php echo base_url();?>laporan_gaji/cetak_laporan?id_periode=<?php echo $id_periode_aktif;?>" class="btn btn-md btn-success"><i class="fas fa-print"></i>Print</a>
                                	<?php
										$total_jam = 0;
										$jumlah_gaji = 0;
									?>
									<hr>
									<div class="table-responsive">
	                                	<table class="table table-striped table-bordered table-hover <?php
	                                                if(isset($daftar_gaji) && $daftar_gaji){ echo 'mainDataTable';}?>">
	                                        <thead>
	                                        	<tr>
	                                        		<th>#</th>
													<th>Hari/Tanggal Masuk</th>
													<th>Jam Masuk</th>
													<th>Jam Pulang</th>
													<th>Total Jam</th>
													<th>Istirahat</th>
													<th>Waktu Real</th>
													<th>Total</th>
	                                        	</tr>
	                                        </thead>
	                                        <tbody>
	                                        	<?php
	                                        	if(isset($daftar_gaji) && $daftar_gaji){
	                                        		$iterator = 1;
	                                        		foreach ($daftar_gaji as $gaji) {
	                                        		?>
	                                        		<tr>
														<td><?php echo $iterator;?></td>
														<td><?php echo $gaji['HARI']."/".$gaji['TANGGAL_MASUK'];?></td>
														<td><?php echo $gaji['JAM_MASUK'];?></td>
														<td><?php echo $gaji['JAM_KELUAR'];?></td>
														<td><?php echo $gaji['TOTAL_JAM'];?></td>
														<td><?php echo $gaji['ISTIRAHAT'];?></td>
														<td><?php
														$total_jam += $gaji['WAKTU_REAL'];
														echo $gaji['WAKTU_REAL'];?></td>
														<td><?php
														$jumlah_gaji += $gaji['BIAYA'];
														echo "Rp. " .$gaji['BIAYA'].",-";?></td>
														
													</tr>
	                                        		<?php
	                                        		$iterator++;
	                                        		}
	                                        	}
	                                        	else{
	                                        		echo "<tr><td colspan='8'>Belum ada daftar laporan gaji/absensi admin</td></tr>";
	                                        	}
	                                        	?>
	                                        </tbody>
	                                    </table>
                                    </div>
                                    <?php
									if($total_jam > $maks_jam){
										$total_jam = $maks_jam;
										$jumlah_gaji = $maks_jam * $tarif;
									}
									?>
									<h4>Jam kerja yang dihitung : <?php echo $total_jam;?> jam</h4>
									<h4>Tarif : Rp. <?php echo $tarif;?>/jam</h4>
									<h4>Jumlah Gaji : Rp. <?php echo $tarif;?>,- * <?php echo $total_jam;?> = Rp. <?php echo $jumlah_gaji;?>,-</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>