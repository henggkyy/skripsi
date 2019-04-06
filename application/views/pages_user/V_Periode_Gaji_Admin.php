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
                           <div class="ibox float-e-margins">
                              <div class="ibox-title">
                                  <h3>Konfigurasi</h3>
                              </div>
                              <div class="ibox-content">
                                  <div class="row">
                                    <?php
                                    if(isset($konfigurasi) && $konfigurasi){
                                      foreach ($konfigurasi as $konf) {
                                        ?>
                                          <div class="form-group col-lg-3">
                                            <label>Maksimal Jam :</label><input class="form-control" type="number" min="0" id="maks_jam" name="maks_jam" value="<?php echo $konf['JAM_MAX'];?>" disabled>
                                          </div>
                                          <div class="form-group col-lg-3">
                                            <label>Tarif per Jam :</label><input class="form-control" type="number" min="0" id="tarif" name="tarif" value="<?php echo $konf['TARIF'];?>" disabled>
                                          </div>
                                        <?php
                                      }
                                    }
                                    ?>
                                   
                                    <div class="form-group col-lg-6"> 
                                      <br>
                                      <button id="edit_btn" class="btn btn-primary btn-md"><i class="far fa-edit"></i> Edit</button>
                                      <button style="display: none;" id="save_btn" class="btn btn-success btn-md"><i class="fas fa-save"></i> Save</button>
                                      <h4 style="display: none;" id="notif"></h4>
                                    </div>
                                  </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="ibox float-e-margins">
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
            </div>
            <script type="text/javascript">
              $( "#edit_btn" ).click(function() {
                $('#save_btn').show();
                $('#edit_btn').hide();
                $('#maks_jam').prop('disabled', false);
                $('#tarif').prop('disabled', false);
              });
              $('#save_btn').click(function(){
                var jam_maks = $('#maks_jam').val();
                var tarif = $('#tarif').val();
                if(jam_maks != "" && tarif != ""){
                  $.ajax({
                      //Ganti URL nanti kl udah dipindah server
                    url: "<?php echo base_url('laporan_gaji/edit_konfigurasi'); ?>",
                    type: "POST",
                    data: {tarif : tarif, jam_max : jam_maks},
                    success: function(data) { 
                        $("#notif").show();
                        $("#notif").html(data);
                        $('#save_btn').hide();
                        $('#edit_btn').show();
                        $('#maks_jam').prop('disabled', true);
                        $('#tarif').prop('disabled', true);
                    },
                    error: function() {
                        alert('error!');
                    }
                  }); 
                }
              });
            </script>