			<div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                        	<div class="ibox-title">
                                <h3>Form Peminjaman Ruangan Laboratorium & Alat</h3>
                            </div>
                            <div class="ibox-content">
                            	<?php echo form_open('peminjaman/ajuan');?>
                            	<div class="form-group row">
			                        <label class="col-sm-4 col-form-label">Pilih Tipe Peminjaman <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <select id="choice" name="choice" required class="form-control"> 
			                                <option selected disabled value="">-- Please Select One --</option>
			                                <option value="lab">Ruangan Laboratorium</option>
			                                <option value="alat">Alat Laboratorium</option>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label class="col-sm-4 col-form-label">Acara/Keperluan <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <input type="text" class="form-control" placeholder="Contoh : Tutorial Power Point" required name="keperluan">
			                        </div>
			                    </div>
			                    <div class="form-group row " id="data_1">
			                        <label class="col-sm-4 col-form-label">Tanggal Pinjam <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6 input-group date">
			                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgl_pinjam" name="tgl_pinjam" class="form-control" placeholder="mm/dd/yyyy" data-mask="99/99/9999" onchange="checkLab();" required>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label id="label_jam_mulai" class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6 input-group clockpicker" data-autoclose="true">
			                            <input type="text" id="waktu_awal_2" name="jam_mulai" class="form-control" placeholder="09:30" data-mask="99:99" onchange="checkLab();" required>
			                            <span class="input-group-addon">
			                                <span class="fa fa-clock-o"></span>
			                            </span>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label id="label_jam_selesai" class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6 input-group clockpicker" data-autoclose="true">
			                            <input type="text" id="waktu_akhir_2" name="jam_selesai" class="form-control" placeholder="09:30" data-mask="99:99" onchange="checkLab();" required>
			                            <span class="input-group-addon">
			                                <span class="fa fa-clock-o"></span>
			                            </span>
			                        </div>
			                    </div>
			                    <div class="form-group row" style="display: none;" id="div_lab">
			                        <label class="col-sm-4 col-form-label">Pilih Ruangan Laboratorium <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6" >
			                            <div id="select_lab">
			                                <span style="color: red;">Silahkan isi tanggal, jam mulai, dan jam selesai peminjaman terlebih dahulu</span>
			                            </div>
			                            
			                        </div>

			                    </div>
			                    <div class="form-group row" style="display: none;" id="div_alat">
			                        <label class="col-sm-4 col-form-label">Pilih Alat <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <select id="choice_alat" name="alat" required class="form-control"> 
			                                <option selected disabled value="">-- Please Select One --</option>
			                                <?php
			                                if(isset($daftar_alat) && $daftar_alat){
			                                    foreach ($daftar_alat as $alat) {
			                                        ?>
			                                        <option value="<?php echo $alat['ID'];?>"><?php echo $alat['NAMA_ALAT'];?></option>
			                                        <?php
			                                    }
			                                }
			                                ?>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="form-group row">
			                        <label class="col-sm-4 col-form-label">Keterangan <span style="color: red">*</span> :</label>
			                        <div class="col-sm-6">
			                            <textarea style="height: 80px;" placeholder="Dapat diisi dengan keperluan peminjaman lab, kebutuhan, dsb." name="keterangan" class="form-control" required></textarea>
			                        </div>
			                    </div>
			                    <p style="color: red;" align="center">* Wajib Diisi</p>
			                    <div class="form-group row">
			                        <div class="col-sm-12">
			                            <a href="<?php echo base_url();?>" class="btn btn-white btn-lg"> < Back</a>
			                            <button class="btn btn-primary btn-lg" type="submit" id="button_submit">Ajukan Peminjaman</button>
			                        </div>
			                    </div>
			                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>