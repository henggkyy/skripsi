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
							<h3>Laboratorium Komputasi Teknik Informatika</h3>
							<h4>Universitas Katolik Parahyangan</h4>
							<hr>
							<h5>Jadwal Pemakaian Laboratorium Laboratorium</h5>
						</div>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row">
						<h4>Jadwal penggunaan laboratorium untuk bulan: <?php echo $nama_bulan;?> <?php echo date("Y");?></h4>
					</div>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Ruangan Lab</th>
								<th>Waktu Pemakaian</th>
								<th>Penggunaan</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($jadwal_lab) && $jadwal_lab){
								$iterator = 1;
								
								foreach ($jadwal_lab as $jadwal) {
									?>
								<tr>
									<td><?php echo $iterator;?></td>
									<td><?php echo $jadwal['nama_lab']." (".$jadwal['lokasi'].")";?></td>
									<td><?php echo $jadwal['start']." s/d ".$jadwal['end'];?></td>
									<td><?php echo $jadwal['title'];?></td>
								</tr>
									<?php
									$iterator++;
								}
							}
							else{
								echo "<tr><td colspan='8'>Belum ada daftar pemakaian laboratorium</td></tr>";
							}
							?>
						</tbody>
					</table>
					<p style="float: right">printed at : <?php echo $now_date;?></p>
				</div>
			</div>
		</div>
	</div>

