<?php echo form_open('laporan_gaji/update');
if(isset($daftar_gaji) && $daftar_gaji){
	foreach ($daftar_gaji as $gaji) {
        $tanggal = date("m/d/Y", strtotime($gaji['TANGGAL_MASUK']));
        $jam_mulai = date('H:i', strtotime($gaji['JAM_MASUK']));
            $jam_selesai = date('H:i', strtotime($gaji['JAM_KELUAR']));
		?>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Tanggal Masuk <span style="color: red">*</span> :</label>
    <div class="col-sm-6 input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required type="text" id="tanggal_modal" placeholder="mm/dd/yyy" data-mask="99/99/9999" class="form-control" name="tgl_masuk" value="<?php echo $tanggal;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jam Masuk <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
         <input class="form-control" type="text" id="waktu_awal_modal" name="jam_mulai" required placeholder="hh:mm" data-mask="99:99" value="<?php echo $jam_mulai;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jam Keluar <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
        <input class="form-control" type="text" id="waktu_akhir_modal" name="jam_selesai" required placeholder="hh:mm" data-mask="99:99" value="<?php echo $jam_selesai;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jumlah Istirahat (Dalam Jam) <span style="color: red">*</span> :</label>
    <div class="col-sm-6 input-group date">
        <input class="form-control" type="number" name="istirahat" min="0" value="0" required value="<?php echo $gaji['ISTIRAHAT'];?>" min="0">
    </div>
</div>
<input type="hidden" name="id_admin" value="<?php echo $gaji['ID_ADMIN'];?>">
<input type="hidden" name="id_periode" value="<?php echo $gaji['ID_PERIODE'];?>">
<input type="hidden" name="uniq" value="<?php echo $uniq;?>" required>
		<?php
	}
}
?>
 <p align="center" style="color: red">* Wajib Diisi</p>
 <div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</div>
</form>