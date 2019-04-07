<body class="gray-bg" onload="window.print()">
	<div class="col-md-12">
		<div class="row">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<div class="row">
						<div class="col-md-1">
							<img style="width: 100px; height: 100px;" src="<?php echo base_url()?>assets/img/unpar.png">
						</div>
						<div class="col-md-11">
							<h3>Fakultas Teknologi Informasi dan Sains</h3>
							<h4>Universitas Katolik Parahyangan</h4>
							<hr>
							<h5>Laporan Gaji/Absensi Admin Laboratorium</h5>
						</div>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row">
						<h4>Detail Admin : </h4>
						<?php
						if(isset($detail_admin) && $detail_admin){
							foreach ($detail_admin as $admin) {
							?>
						<div class="col-md-12">
							<p><span style="font-weight: bold;">Nama :</span> <?php echo $admin['NAMA'];?></p>
							<p><span style="font-weight: bold;">NIK :</span> <?php echo $admin['NIK'];?></p>
							<p><span style="font-weight: bold;">Email :</span> <?php echo $admin['EMAIL'];?></p>
							<?php
							}
						}
						?>
						<p><span style="font-weight: bold;">Periode Gaji :</span> <?php echo $nama_periode;?> </p>
						</div>
					</div>
					<?php
					$total_jam = 0;
					$jumlah_gaji = 0;
					?>
					<table class="table table-striped table-bordered">
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
					<?php
					if($total_jam > $maks_jam){
						$total_jam = $maks_jam;
						$jumlah_gaji = $maks_jam * $tarif;
					}
					?>
					<h4>Jam kerja yang dihitung : <?php echo $total_jam;?> jam</h4>
					<h4>Tarif : Rp. <?php echo $tarif;?>/jam</h4>
					<h4>Jumlah Gaji : Rp. <?php echo $tarif;?>,- * <?php echo $total_jam;?> = Rp. <?php echo $jumlah_gaji;?>,-</h4>
					<p style="float: right">printed at : <?php echo $now_date;?></p>
				</div>
			</div>
		</div>
	</div>

