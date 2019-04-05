			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                    	<div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                	<h3>Set Periode Gaji Admin</h3>
                                </div>
                                <div class="ibox-content">
                                	<?php
                                	if(!$is_aktif){
                                	?>
                                	<button class="btn btn-md btn-primary" data-toggle="modal" data-target="#modalSetPeriode">Set Periode Gaji</button>
                                	<!--START MODAL SET PERIODE-->
                                	 <div class="modal inmodal" id="modalSetPeriode" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Set Periode Gaji Admin</h4>
                                                                            </div>
                                                                            <?php echo form_open('laporan_gaji/periode/add');?>
                                                                            <div class="modal-body">
                                                                                <div class="form-group  row">
                                                                                	<label class="col-sm-5 col-form-label">Keterangan <span style="color: red">*</span> :</label>
                                                                                	<div class="input-group col-sm-7">
                                                                                		<input type="text" name="ket_periode" placeholder="Contoh : Periode Bulan Agustus - September" required class="form-control">
                                                                                	</div>
                                                                                </div>
                                                                                <div class="form-group  row" id="range_periode">
                                                                                    <label class="col-sm-5 col-form-label">Periode Gaji <span style="color: red">*</span> :</label>
					                                                                <div class="input-daterange input-group col-sm-7" id="datepicker">
					                                                                    <input type="text" class="form-control-sm form-control" id="start_periode" name="start_periode" placeholder="mm/dd/yyyy" data-mask="99/99/9999" required/>
					                                                                    <span class="input-group-addon">s/d</span>
					                                                                    <input type="text" class="form-control-sm form-control" id="end_periode" name="end_periode" placeholder="mm/dd/yyyy" data-mask="99/99/9999"  required />
					                                                                </div>
                                                                                </div>
                                                                                <p align="center" style="color: red">* Wajib Diisi</p>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                                <button type="submit" id="button_save" class="btn btn-primary">Add Periode</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                	<!--END MODAL SET PERIODE-->
                                	<?php
                                	}
                                	else{
                                		?>
                                		<h4 style="color: red;">Tidak dapat set periode karena masih terdapat periode yang sedang aktif!</h4>
                                		<?php
                                	}
                                	?>
                                	
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox-title">
                               	<h3>Histori Periode Gaji</h3>
                            </div>
                            <div class="ibox-content">
                            	<div class="table-responsive">
                            		<table class="table table-striped table-bordered table-hover <?php
                                       if(isset($data_periode) && $data_periode){ echo 'mainDataTable';}?>">
                                       <thead>
                                       		<tr>
                                       			<th>#</th>
                                                <th>Periode Gaji</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                       		</tr>
                                       </thead>
                                       <tbody>
                                       		
                                       			<?php
                                       			if(isset($data_periode) && $data_periode){
                                       				$iterator = 1;
                                       				foreach ($data_periode as $periode) {
                                       					?>
                                       				<tr>
	                                       				<td><?php echo $iterator;?></td>
	                                       				<td><?php echo $periode['START_PERIODE']." s/d ". $periode['END_PERIODE'];?></td>
	                                       				<td><?php echo $periode['KETERANGAN'];?></td>
	                                       				<td>
	                                       					<?php
	                                       					if($periode['STATUS'] == 1){
	                                       						echo 'Sedang Berlangsung';
	                                       					}
	                                       					else{
	                                       						echo 'Sudah Berakhir';
	                                       					}
	                                       					?>
	                                       				</td>
	                                       				<td align="center">
	                                       					<?php
	                                       					if($periode['STATUS'] == 1){
	                                       						echo form_open('laporan_gaji/periode/nonactivate');
	                                       						?>
	                                       						<input type="hidden" name="id_periode_gaji" required value="<?php echo $periode['ID'];?>">
	                                       						<button class="btn btn-danger" type="submit" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan periode ini?')"><i class="fas fa-minus-circle"></i> Nonaktifkan</button>
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
                                       				echo '<tr><td colspan="5">Belum ada periode gaji</td></tr>';
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