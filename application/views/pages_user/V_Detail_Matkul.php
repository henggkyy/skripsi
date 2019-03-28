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
                                                    <span style="font-weight: bold;">Tanggal UTS : </span>
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
                                                    <span style="font-weight: bold;">Tanggal UAS : </span>
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
                                                    <span style="font-weight: bold;">Peserta Mata Kuliah : </span>
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
                                                <li>
                                                    <span style="font-weight: bold;">Jadwal Kelas : </span>
                                                    <button id="btn_insert_jadwal" class="btn btn-success btn-sm" type="submit"><i class="fas fa-group"></i> Insert Jadwal Kelas</button>
                                                    <div style="display: none;" id="container_jadwal" class="panel panel-warning">
                                                        <div class="panel-heading">
                                                            Insert Jadwal Kelas
                                                        </div>
                                                        <div class="panel-body">
                                                            <?php echo form_open_multipart('administrasi_matkul/insert_kelas');?>
                                                            <div class="form-group  row">
                                                                <label class="col-sm-4 col-form-label">Jumlah Pertemuan <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" type="number" name="jml_pertemuan" min="0" onchange="addFields()" id="jml_pertemuan">
                                                                </div>              
                                                            </div>
                                                            <div class="form-group  row">
                                                                <label class="col-sm-4 col-form-label">Jadwal Kelas <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8" id="container">                
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
                                                <li>
                                                    <span style="font-weight: bold;">Kebutuhan Perangkat Lunak : </span>
                                                </li>
                                                <li>
                                                    <span style="font-weight: bold;">Cetak Absensi Ujian : </span>
                                                </li>
                                                <li>
                                                    <span style="font-weight: bold;">Inisiasi Tempat Duduk UTS : </span>
                                                </li>
                                                <li>
                                                    <span style="font-weight: bold;">Inisiasi Tempat Duduk UAS : </span>
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
