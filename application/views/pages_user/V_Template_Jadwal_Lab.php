<?php echo form_open('jadwal_lab/updatePemakaian');
if(isset($data_pemakaian) && $data_pemakaian){
	foreach ($data_pemakaian as $pemakaian) {
        $start = $pemakaian['start'];
        $end = $pemakaian['end'];
        $tanggal = substr($start, 0, strpos($start, ' '));
        $jam_mulai = substr($start, strpos($start, ' '), (strlen($start)-1));
        $jam_mulai = date('H:i', strtotime($jam_mulai));
        $jam_selesai =  substr($end, strpos($end, ' '), (strlen($end)-1));
        $jam_selesai = date('H:i', strtotime($jam_selesai));
        $tanggal = date("m/d/Y", strtotime($tanggal));
		?>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Acara/Keperluan <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
        <input class="form-control" type="text" value="<?php echo $pemakaian['title'];?>" disabled readonly>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Tanggal Pemakaian<span style="color: red">*</span> :</label>
    <div class="col-sm-6 input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required type="text" id="tanggal_modal" placeholder="mm/dd/yyy" onchange="checkLabModal();" data-mask="99/99/9999" class="form-control" name="tgl_pemakaian" value="<?php echo $tanggal;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
         <input class="form-control" type="text" onchange="checkLabModal();" id="waktu_awal_modal" name="jam_mulai" required placeholder="hh:mm" data-mask="99:99" value="<?php echo $jam_mulai;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
    <div class="col-sm-6">
        <input class="form-control" type="text" onchange="checkLabModal();" id="waktu_akhir_modal" name="jam_selesai" required placeholder="hh:mm" data-mask="99:99" value="<?php echo $jam_selesai;?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-6 col-form-label">Ruangan Laboratorium <span style="color: red">*</span> :</label>
    <div class="col-sm-6" id="select_lab_modal">
        <select class="form-control" required>
            <option value="<?php echo $pemakaian['id_lab'];?>"><?php echo $pemakaian['nama_lab'];?></option>
        </select>
    </div>
</div>
<input required type="hidden" name="id_pemakaian" value="<?php echo $pemakaian['id'];?>">
		<?php
	}
}
?>
 <p align="center" style="color: red">* Wajib Diisi</p>
 <p align="center" style="color:red" id="notif_modal"></p>
 <div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    <button type="submit" id="button_modal" class="btn btn-primary">Save Changes</button>
</div>
</form>