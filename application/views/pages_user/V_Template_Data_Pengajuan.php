<?php echo form_open($form);
if(isset($data_pengajuan) && $data_pengajuan){
	foreach ($data_pengajuan as $pengajuan) {
        $jam_masuk = date('H:i', strtotime($pengajuan['JAM_MULAI']));
        $jam_selesai = date('H:i', strtotime($pengajuan['JAM_SELESAI']));
		?>

<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
         <input class="form-control" type="text" id="waktu_awal_modal" name="jam_mulai" required placeholder="hh:mm" data-mask="99:99" value="<?php echo $jam_masuk;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
        <input class="form-control" type="text" id="waktu_akhir_modal" name="jam_selesai" required placeholder="hh:mm" data-mask="99:99" value="<?php echo $jam_selesai?>">
    </div> 
</div>

		<?php
	}
}
?>
<input type="hidden" name="id_admin" value="<?php echo $id_admin;?>" required>
<input type="hidden" name="id_pengajuan" value="<?php echo $id_pengajuan;?>" required>
<input type="hidden" name="method" value="<?php echo $method;?>" required>
 <p align="center" style="color: red">* Wajib Diisi</p>
 <div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    <button type="submit" id="button_submit" class="btn btn-primary">Setujui</button>
</div>
</form>