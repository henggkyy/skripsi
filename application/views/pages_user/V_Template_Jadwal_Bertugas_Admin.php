
        	<?php echo form_open('admin_lab/update_jadwal');?>
            	<?php if( isset($data_jadwal) && $data_jadwal){
            		foreach ($data_jadwal as $jadwal) {
            		$tanggal = date("m/d/Y", strtotime($jadwal['TANGGAL']));
            		?>
            	<div class="form-group row">
                    <label class="col-sm-6 col-form-label">Tanggal Bertugas <span style="color: red">*</span> :</label>
                    <div class="col-sm-6 input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required type="text" id="tanggal_modal" placeholder="mm/dd/yyy" data-mask="99/99/9999" class="form-control" name="tgl_bertugas" value="<?php echo $tanggal;?>">
                    </div>
                </div>
                 <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Jam Mulai Bertugas <span style="color: red">*</span> :</label>
                    <div class="col-sm-6">
                        <input id="waktu_awal_modal" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai" value="<?php echo $jadwal['JAM_MULAI'];?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Jam Selesai Bertugas <span style="color: red">*</span> :</label>
                    <div class="col-sm-6">
                        <input id="waktu_akhir_modal" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai" value="<?php echo $jadwal['JAM_SELESAI'];?>">
                    </div>
                </div>
                <input type="hidden" name="id_bertugas" value="<?php echo $jadwal['ID'];?>" required>
                <?php
                if($this->session->userdata('id') != 4){
                    ?>
                <input type="hidden" name="id_admin" value="<?php echo $id_admin;?>" required>
                    <?php
                }
                ?>
               
            		<?php
            		}
            	}
            	?>
            	<p align="center" style="font-size: 12px; font-weight: bold;">Tanggal bertugas harus berada pada tanggal periode akademik yg sdg aktif<br>
                                                                                Tanggal bertugas pada periode UTS/UAS akan langsung masuk ke dalam shift bertugas UTS/UAS</p>
                                                                                <p align="center" style="color: red">* Wajib Diisi</p>
            </div>                                            
        <div class="modal-footer">
                                                    
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>