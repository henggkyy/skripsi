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
                                	<h4 style="display: inline;"><span style="font-weight: bold;">Periode Absensi/Gaji : </span><?php echo $nama_periode;?></h4>
                                	<a style="float: right;" target="_blank" href="<?php echo base_url();?>laporan_gaji/cetak?id_periode=<?php echo $id_periode_aktif;?>&id_admin=<?php echo $admin['ID'];?>" class="btn btn-md btn-success"><i class="fas fa-print"></i> Print</a>
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
													<th>Aksi</th>
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
														<td>
															<?php
															if($flag){
																?>
																<button class="btn btn-primary btn-sm" onclick="loadModalUpdate(<?php echo $gaji['UNIQ'];?>);"><i class="fas fa-pen"></i> Update</button>
															<?php echo form_open('laporan_gaji/delete');?>
															<input type="hidden" name="uniq" required value="<?php echo $gaji['UNIQ'];?>">
															<input type="hidden" name="id_periode" required value="<?php echo $id_periode_aktif;?>">
															<input type="hidden" name="id_admin" required value="<?php echo $admin['ID'];?>">
															<button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
															</form>
																<?php
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
	                                        		echo "<tr><td colspan='9'>Belum ada daftar laporan gaji/absensi admin</td></tr>";
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
									<br>
									<a href="<?php echo base_url();?>laporan_gaji/report" class="btn btn-md btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--START MODAL UPDATE LAPORAN GAJI-->
                                        <div class="modal inmodal" id="modalUpdateLaporan" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content animated fadeIn">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title">Update Laporan Gaji/Absensi Admin</h4>
                                                    </div>
                                                    <div class="modal-body" id="modal-content">
                                                        <img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--END MODAL UPDATE LAPORAN GAJI-->
        <script type="text/javascript">
        	var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
        	function loadModalUpdate(uniq){
        		$("#modal-content").html(loader);
        		$('#modalUpdateLaporan').modal('show');
        		$.ajax({
			        url: "<?php echo base_url();?>" + "laporan_gaji/get_laporan",
			        method: "GET",
			        data: {uniq : uniq},
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