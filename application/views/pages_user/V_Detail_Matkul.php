            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h2>Periode Aktif : 
                                        <?php
                                        if($periode_aktif){
                                            ?>
                                            <span><?php echo $periode_aktif;?></span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <span style="color: red;"> <br>Belum ada periode semester aktif!</span>
                                            <?php
                                        }
                                        ?>
                                    </h2>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Detail Mata Kuliah</h5>
                                </div>
                                <div class="ibox-content">
                                    <h3 align="center"><?php echo $nama_matkul;?></h3>
                                    <hr>
                                    <ul class="unstyled">
                                        <li><h4>Informasi</h4>
                                            <ul>
                                                <?php
                                                if(isset($info_matkul) && $info_matkul){
                                                    foreach ($info_matkul as $info) {
                                                        ?>
                                                        <li><span style="font-weight: bold;">Nama Mata Kuliah :</span> <?php echo $info['NAMA_MATKUL'];?></li>
                                                        <li><span style="font-weight: bold;">Kode Mata Kuliah :</span> <?php echo $info['KD_MATKUL'];?></li>
                                                        <li><span style="font-weight: bold;">Dosen Koordinator :</span> <?php echo $info['NAMA_DOSEN'];?></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                    <hr>
                                    <ul class="unstyled">
                                        <li><h4>Administrasi Akademik</h4>
                                            <ul>
                                                <li>
                                                    <h4 style="font-weight: bold;">Tanggal UTS : </h4>
                                                    <?php
                                                    if($set_uts != NULL){
                                                        echo $set_uts;
                                                    }
                                                    else{
                                                        ?>
                                                        <button data-toggle="modal" data-target="#modalUTS" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-clock"></i> Set Tanggal UTS</button>
                                                    <!--Modal Set UTS-->
                                                    <div class="modal inmodal" id="modalUTS" tabindex="-1" role="dialog"  aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content animated fadeIn">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                    <h3 class="modal-title">Set Tanggal UTS - <?php echo $nama_matkul;?></h3>
                                                                </div>
                                                                <?php echo form_open('administrasi_matkul/set_uts');?>
                                                                <div class="modal-body">
                                                                    <div class="form-group  row" id="data_1">
                                                                        <label class="col-sm-4 col-form-label">Tanggal UTS <span style="color: red">*</span> :</label>
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_uts">
                                                                        </div>

                                                                    </div>
                                                                    <p style="color: red;" align="center">* Wajib Diisi</p>
                                                                    <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save Changes </button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--END MODAL Set UTS-->
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                </li>
                                                <li>
                                                    <h4 style="font-weight: bold;">Tanggal UAS : </h4>
                                                    <?php

                                                    if($set_uas != NULL){
                                                        echo $set_uas;
                                                    }
                                                    else{
                                                        ?>
                                                        <button data-toggle="modal" data-target="#modalUAS" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-clock"></i> Set Tanggal UAS</button>
                                                    <!--Modal Set UAS-->
                                                    <div class="modal inmodal" id="modalUAS" tabindex="-1" role="dialog"  aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content animated fadeIn">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                    <h3 class="modal-title">Set Tanggal UAS - <?php echo $nama_matkul;?></h3>
                                                                </div>
                                                                <?php echo form_open('administrasi_matkul/set_uas');?>
                                                                <div class="modal-body">
                                                                    <div class="form-group  row" id="data_1">
                                                                        <label class="col-sm-4 col-form-label">Tanggal UAS <span style="color: red">*</span> :</label>
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_uas">
                                                                        </div>

                                                                    </div>
                                                                    <p style="color: red;" align="center">* Wajib Diisi</p>
                                                                    <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save Changes </button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--END MODAL Set UAS-->
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                </li>
                                                <li>
                                                    <h4 style="font-weight: bold;">Peserta Mata Kuliah : </h4>
                                                    <?php if(!$set_peserta){
                                                        ?>
                                                        <button data-toggle="modal" data-target="#insertMhs" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-group"></i> Insert Mahasiswa Peserta Kuliah</button>
                                                        <!--Modal Set Peserta Matkul-->
                                                        <div class="modal inmodal" id="insertMhs" tabindex="-1" role="dialog"  aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content animated fadeIn">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h3 class="modal-title">Insert Peserta Mata Kuliah - <?php echo $nama_matkul;?></h3>
                                                                    </div>
                                                                    <?php echo form_open_multipart('administrasi_matkul/insert_mhs');?>
                                                                    <div class="modal-body">
                                                                        <a class="btn btn-success" target="_blank" href="<?php echo base_url();?>download/template_insertMhs"><i class="fas fa-download"></i> Download Template </a>
                                                                        <br>
                                                                        <div class="form-group  row" id="data_1">
                                                                            <label class="col-sm-4 col-form-label">Upload Excel Mhs <span style="color: red">*</span> :</label>
                                                                            <div class="col-sm-8">
                                                                                <input class="form-control" type="file" name="excel_mhs">
                                                                            </div>
                                                                            <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                        </div>
                                                                        <p style="color: red;" align="center">* Wajib Diisi</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        
                                                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save Changes </button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--END MODAL Set Peserta Matkul-->
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>NPM Mahasiswa</th>
                                                                        <th>Nama Mahasiswa</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $iterator = 1;
                                                                    foreach ($set_peserta as $peserta ) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $iterator;?></td>
                                                                            <td><?php echo $peserta['NPM_MHS'];?></td>
                                                                            <td><?php echo $peserta['NAMA_MHS'];?></td>
                                                                        </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php
                                                    } ?>
                                                    
                                                </li>

                                                <!--MENU JADWAL KELAS-->
                                                <li>
                                                    <h4 style="font-weight: bold;">Jadwal Kelas : </h4>
                                                    <button id="btn_insert_jadwal" class="btn btn-success btn-sm" type="submit"><i class="fas fa-group"></i> Insert Jadwal Kelas</button>
                                                    <div style="display: none;" id="container_jadwal" class="panel panel-warning">
                                                        <div class="panel-heading">
                                                            Insert Jadwal Kelas
                                                        </div>
                                                        <div class="panel-body">
                                                            <?php echo form_open_multipart('administrasi_matkul/insert_kelas');?>
                                                            
                                                            <div class="form-group  row">
                                                                <label class="col-sm-4 col-form-label">Jadwal Kelas <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8"> 
                                                                    <h5>Pertemuan Ke - 1</h5>       
                                                                    <label>Hari :</label><select name="hari[]" class="form-control col-md-4" required><option value="" selected disabled>-- Please Select One --</option><option value="Monday">Senin</option><option value="Tuesday" >Selasa</option><option value="Wednesday" >Rabu</option><option value="Thursday" >Kamis</option><option value="Friday" >Jumat</option><option value="Saturday" >Sabtu</option></select>  
                                                                    <div class="col-sm-4 input-group clockpicker" data-autoclose="true"><label>Jam Mulai :</label> <input type="text" name="jam_mulai[]" class="form-control" value="" data-mask="99:99" required></div>
                                                                    <div class="col-sm-4 input-group clockpicker" data-autoclose="true"><label>Jam Selesai :</label> <input type="text" name="jam_selesai[]" class="form-control" value="" data-mask="99:99" required></div>
                                                                    <br>    
                                                                    <div id="container">
                                                                        
                                                                    </div>
                                                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary">Cek Ketersediaan Laboratorium</a>
                                                                    <a href="javascript:void(0)" class="btn btn-sm add_button_pertemuan">Add Pertemuan</a>  
                                                                </div>
                                                                                
                                                            </div>
                                                            <div class="form-group  row">
                                                                <label class="col-sm-4 col-form-label">Kode Kelas <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" type="text" maxlength="1" placeholder="Contoh : A" name="kd_kelas" min="0">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                            <p style="color: red;" align="center">* Wajib Diisi</p>
                                                            <button type="submit" class="btn btn-success" name="">Masukkan Jadwal</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                      
                                                </li>
                                                <!--Menu Kebutuhan Perangkat Lunak-->
                                                <li>
                                                    <h4 style="font-weight: bold;">Kebutuhan Perangkat Lunak : </h4>
                                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#insertPL">Tambah Perangkat Lunak</button>
                                                    <!--Modal Add Perangkat Lunak-->
                                                        <div class="modal inmodal" id="insertPL" tabindex="-1" role="dialog"  aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content animated fadeIn">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h3 class="modal-title">Tambah Kebutuhan Perangkat Lunak - <?php echo $nama_matkul;?></h3>
                                                                    </div>
                                                                    <?php echo form_open_multipart('administrasi_matkul/perangkat_lunak/add');?>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                        <div class="form-group row" >
                                                                            <label class="col-sm-4 col-form-label">Nama Perangkat Lunak <span style="color: red">*</span> :</label>
                                                                            <div class="col-sm-8" id="input_pl">
                                                                               <select  name="nama_pl" class="form-control col-sm-4" required>
                                                                                    <option value="" disabled selected>-- Please Select One --</option>
                                                                                    <option value="netbeans">Netbeans</option>
                                                                                    <option value="bluej">Blue J</option>
                                                                                    <option value="Miktex">Miktex</option>
                                                                                    <option value="visualstudio">Visual Studio</option>
                                                                                    <option value="sublimetext">Sublime Text</option>
                                                                                    <option value="xampp">XAMPP</option>
                                                                                </select> 
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <p>Perangkat lunak tidak ada dalam list? <a id="button_add_pl" href="javascript:void(0)">Klik disini.</a></p>
                                                                            </div>
                                                                        </div>
                                                                        <p style="color: red;" align="center">* Wajib Diisi</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        
                                                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save Changes </button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--END MODAL Add Perangkat Lunak-->
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Nama Perangkat Lunak</th>
                                                                    <th>Status</th>
                                                                    <th>Last Checked</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if(isset($daftar_pl) && $daftar_pl){
                                                                    $iterator = 1;
                                                                    foreach ($daftar_pl as $pl) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $iterator?></td>
                                                                            <td><?php echo $pl['NAMA_PL'];?></td>
                                                                            <td>
                                                                                <?php
                                                                                if($pl['STATUS'] == 1){
                                                                                    echo 'Sudah Terinstall';
                                                                                }
                                                                                else if($pl['STATUS'] == 2){
                                                                                    echo 'Belum Terinstall';
                                                                                }
                                                                                else{
                                                                                    echo 'Belum diperiksa';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo $pl['LAST_CHECKED'];?></td>
                                                                            <td align="center">
                                                                                <?php echo form_open('administrasi_matkul/perangkat_lunak/delete');?>
                                                                                <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                                <input type="hidden" name="id_pl" value="<?php echo $pl['ID'];?>" required>
                                                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kebutuhan perangkat lunak ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                }
                                                                else{
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="5">Belum ada kebutuhan perangkat lunak!</td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </li>
                                                <!-- START MENU FILE BANTUAN UJIAN-->
                                                <li>
                                                    <h4 style="font-weight: bold;">File Bantuan Ujian : </h4>
                                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#insertFileBantuan"><i class="fas fa-file-upload"></i> Upload File Bantuan</button>
                                                    <!--Modal ADD FILE BANTUAN-->
                                                        <div class="modal inmodal" id="insertFileBantuan" tabindex="-1" role="dialog"  aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content animated fadeIn">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h3 class="modal-title">Upload File Bantuan Ujian - <?php echo $nama_matkul;?></h3>
                                                                    </div>
                                                                    <?php echo form_open_multipart('administrasi_matkul/insert_file_bantuan');?>
                                                                    <div class="modal-body">
                                                                        <div class="form-group  row">
                                                                            <label class="col-sm-4 col-form-label">Tipe Ujian <span style="color: red">*</span> :</label>
                                                                            <div class="col-sm-8">
                                                                                <select required class="form-control" name="tipe_ujian">
                                                                                    <option value="" selected disabled>-- Please Select One --</option>
                                                                                    <option value="0">Ujian Tengah Semester (UTS)</option>
                                                                                    <option value="1">Ujian Akhir Semester (UAS)</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group  row">
                                                                            <label class="col-sm-4 col-form-label">Nama/Keterangan File <span style="color: red">*</span> :</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" name="nama_keterangan" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group  row">
                                                                            <label class="col-sm-4 col-form-label">Upload File (.zip, .pdf, .docx. Max 2MB) <span style="color: red">*</span> :</label>
                                                                            <div class="col-sm-8">
                                                                                <input class="form-control" type="file" name="file_bantuan">
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                        <p style="color: red;" align="center">* Wajib Diisi</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        
                                                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Upload </button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--END MODAL ADD FILE BANTUAN-->
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Nama/Keterangan File</th>
                                                                    <th>Tipe Ujian</th>
                                                                    <th>Waktu Upload</th>
                                                                    <th>Uploader</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($file_bantuan) && $file_bantuan) {
                                                                    $iterator = 1;
                                                                    foreach ($file_bantuan as $file) {
                                                                        ?>
                                                                    <tr>
                                                                        <td><?php echo $iterator;?></td>
                                                                        <td><?php echo $file['NAMA_KETERANGAN'];?></td>
                                                                        <td><?php
                                                                        if($file['TIPE_UJIAN'] == 0){
                                                                            echo 'UTS';
                                                                        }else{
                                                                            echo 'UAS';
                                                                        }
                                                                        ?></td>
                                                                        <td><?php echo $file['LAST_UPDATE'];?></td>
                                                                        <td><?php echo $file['USER_UPLOAD'];?></td>
                                                                        <td align="center">
                                                                            <a class="btn btn-sm btn-success" target="_blank" href="<?php echo base_url();?>download/file_bantuan/<?php echo $file['PATH_FILE'];?>"><i class="fas fa-download"></i> Download</a>
                                                                            <?php echo form_open('administrasi_matkul/file_bantuan/remove');?>
                                                                            <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                            <input type="hidden" name="id_file_bantuan" value="<?php echo $file['ID'];?>" required>
                                                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus file bantuan ini?')" class="btn btn-sm btn-danger" href=""><i class="fas fa-trash"></i> Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                }
                                                                else{
                                                                    echo '<tr><td colspan="5">Belum ada file bantuan!</td></tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </li>
                                                <!-- END MENU FILE BANTUAN UJIAN-->
                                                <li>
                                                    <h4 style="font-weight: bold;">Cetak Absensi Ujian : </h4>
                                                </li>
                                                <li>
                                                    <h4 style="font-weight: bold;">Inisiasi Tempat Duduk UTS : </h4>
                                                </li>
                                                <li>
                                                    <h4 style="font-weight: bold;">Inisiasi Tempat Duduk UAS : </h4>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>            
                    </div>
                </div>
            </div>
