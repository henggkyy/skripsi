            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <?php $this->load->view('pages_user/V_Template_Periode_Aktif');?>
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
                                        <li><h3>Informasi</h3>
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
                                                    <h4 style="font-weight: bold;">Jadwal & Ruangan UTS : </h4>
                                                    <?php
                                                    if($set_uts){
                                                        ?>
                                                        <div class="col-md-12">
                                                           <div class="col-md-4">
                                                                <h5>Tanggal : <?php echo $tanggal_uts;?></h5>
                                                                <h5>Jam Mulai : <?php echo $jam_mulai_uts;?></h5>
                                                                <h5>Jam Selesai : <?php echo $jam_selesai_uts;?></h5>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h5>Ruangan Laboratorium : </h5>
                                                                <?php
                                                                if(isset($lab_uts) && $lab_uts){
                                                                    ?>
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($lab_uts as $ruang_uts) {
                                                                            ?>
                                                                        <li><?php echo $ruang_uts['nama_lab']." (".$ruang_uts['lokasi'].")";?></li>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                    <?php
                                                                }
                                                                else{
                                                                    echo 'Ruangan UTS belum diset oleh Admin!';
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php
                                                            if($flag && $this->session->userdata('id_role') == 4){
                                                                ?>
                                                            <div class="col-md-4">
                                                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalRuangUTS">Add Ruangan UTS</button>
                                                                <!--Modal Set Ruangan UTS-->
                                                                <div class="modal inmodal" id="modalRuangUTS" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h3 class="modal-title">Set Ruangan UTS - <?php echo $nama_matkul;?></h3>
                                                                            </div>
                                                                            <?php echo form_open('administrasi_matkul/add_ruang_uts');?>
                                                                            <div class="modal-body">
                                                                                <div class="form-group  row" id="data_1">
                                                                                    <label class="col-sm-4 col-form-label">Tanggal UTS <span style="color: red">*</span> :</label>
                                                                                    <div class="input-group date">
                                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="<?php echo $tanggal_uts;?>" data-mask="9999-99-99" readonly disabled >
                                                                                    </div>

                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input required value="<?php echo $jam_mulai_uts;?>" disabled readonly type="text" placeholder="hh:mm" data-mask="99:99" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input required value="<?php echo $jam_selesai_uts;?>" disabled readonly  type="text" placeholder="hh:mm" data-mask="99:99" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Ruangan Laboratorium <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <?php
                                                                                        if(isset($list_lab_uts) && $list_lab_uts){
                                                                                            ?>
                                                                                        <select class="form-control" name="lab" required>
                                                                                            <option value="" disabled selected>-- Please Select One --</option>
                                                                                            <?php
                                                                                            foreach ($list_lab_uts as $lab) {
                                                                                                ?>
                                                                                            <option value="<?php echo $lab[0];?>"><?php echo $lab['1']." (".$lab['2'].")";?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                            <?php
                                                                                        }
                                                                                        else{
                                                                                            echo '<span style="color:red;">Tidak ada ruangan laboratorium yang tersedia!</span>';
                                                                                        }
                                                                                        ?>
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
                                                                <!--END MODAL Set Ruang UTS-->
                                                            </div> 
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                        </div>
                                                        
                                                        <?php
                                                    }
                                                    else{
                                                        if($flag && ($this->session->userdata('id_role') == 3) ){

                                                        
                                                        ?>
                                                        <button data-toggle="modal" data-target="#modalUTS" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-clock"></i> Set Jadwal UTS</button>
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
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"placeholder="mm/dd/yyyy" data-mask="99/99/9999"class="form-control" name="tgl_uts">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
                                                                        <div class="col-sm-8">
                                                                            <input id="waktu_awal_2" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
                                                                        <div class="col-sm-8">
                                                                            <input id="waktu_akhir_2" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai">
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
                                                        else{
                                                        echo '<h5 style="color:red">Jadwal UTS belum diset oleh Tata Usaha!</h5>';
                                                    }
                                                    }
                                                    ?>
                                                    
                                                </li>
                                                <li>
                                                    <h4 style="font-weight: bold;">Jadwal & Ruangan UAS : </h4>
                                                    <?php

                                                    if($set_uas){
                                                       ?>
                                                        <div class="col-md-12">
                                                            <div class="col-md-4">
                                                                <h5>Tanggal : <?php echo $tanggal_uas;?></h5>
                                                                <h5>Jam Mulai : <?php echo $jam_mulai_uas;?></h5>
                                                                <h5>Jam Selesai : <?php echo $jam_selesai_uas;?></h5>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h5>Ruangan Laboratorium : </h5>
                                                                <?php
                                                                if(isset($lab_uas) && $lab_uas){
                                                                    ?>
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($lab_uas as $ruang_uas) {
                                                                            ?>
                                                                        <li><?php echo $ruang_uas['nama_lab']." (".$ruang_uas['lokasi'].")";?></li>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                    <?php
                                                                }
                                                                else{
                                                                    echo 'Ruangan UTS belum diset oleh Admin!';
                                                                }
                                                                ?>
                                                            </div>
                                                            <?php
                                                            if($flag && $this->session->userdata('id_role') == 4){
                                                                ?>
                                                            <div class="col-md-4">
                                                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalRuangUAS">Add Ruangan UAS</button>
                                                                <!--Modal Set Ruangan UAS-->
                                                                <div class="modal inmodal" id="modalRuangUAS" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h3 class="modal-title">Set Ruangan UAS - <?php echo $nama_matkul;?></h3>
                                                                            </div>
                                                                            <?php echo form_open('administrasi_matkul/add_ruang_uas');?>
                                                                            <div class="modal-body">
                                                                                <div class="form-group  row" id="data_1">
                                                                                    <label class="col-sm-4 col-form-label">Tanggal UAS <span style="color: red">*</span> :</label>
                                                                                    <div class="input-group date">
                                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="<?php echo $tanggal_uas;?>" data-mask="9999-99-99" readonly disabled >
                                                                                    </div>

                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input id="waktu_awal_uas" required value="<?php echo $jam_mulai_uas;?>" disabled readonly type="text" placeholder="hh:mm" data-mask="99:99" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input id="waktu_akhir_uas" required value="<?php echo $jam_selesai_uas;?>" disabled readonly  type="text" placeholder="hh:mm" data-mask="99:99" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label">Ruangan Laboratorium <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <?php
                                                                                        if(isset($list_lab_uas) && $list_lab_uas){
                                                                                            ?>
                                                                                        <select class="form-control" name="lab" required>
                                                                                            <option value="" disabled selected>-- Please Select One --</option>
                                                                                            <?php
                                                                                            foreach ($list_lab_uas as $lab) {
                                                                                                ?>
                                                                                            <option value="<?php echo $lab['0'];?>"><?php echo $lab['1']." (".$lab['2'].")";?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                            <?php
                                                                                        }
                                                                                        else{
                                                                                            echo '<span style="color:red;">Tidak ada ruangan laboratorium yang tersedia!</span>';
                                                                                        }
                                                                                        ?>
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
                                                                <!--END MODAL Set Ruang UAS-->
                                                            </div> 
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                        </div>
                                                       <?php
                                                    }
                                                    else{
                                                       if($flag && ($this->session->userdata('id_role') == 3) ){ ?>
                                                        <button data-toggle="modal" data-target="#modalUAS" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-clock"></i> Set Jadwal UAS</button>
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
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" placeholder="mm/dd/yyyy" data-mask="99/99/9999" name="tgl_uas">
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
                                                                        <div class="col-sm-8">
                                                                            <input id="waktu_awal_uas" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
                                                                        <div class="col-sm-8">
                                                                            <input id="waktu_akhir_uas" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai">
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
                                                    else{ 
                                                        echo '<h5 style="color:red">Jadwal UAS belum diset oleh Tata Usaha!</h5>';
                                                    }
                                                    }
                                                    ?>
                                                    
                                                </li>
                                                <li>
                                                    <h4 style="font-weight: bold;">Peserta Mata Kuliah : </h4>
                                                    <?php if(!$set_peserta){
                                                        if($flag && $this->session->userdata('id_role') == 3){?>
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

                                                        }
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
                                                    <?php
                                                    if($flag && $this->session->userdata('id_role') == 3){
                                                        ?>
                                                    <button id="btn_insert_jadwal" class="btn btn-success btn-sm" type="submit"><i class="fas fa-group"></i> Insert Jadwal Kelas</button>
                                                    <div style="display: none;" id="container_jadwal" class="panel panel-warning">
                                                        <div class="panel-heading">
                                                            Insert Jadwal Kelas
                                                        </div>
                                                        <div class="panel-body">
                                                            <?php
                                                            if(isset($daftar_lab) && $daftar_lab){
                                                                $option = "";
                                                                foreach ($daftar_lab as $lab ) {
                                                                    $option.= '<option value="'.$lab['ID'].'">'.$lab['NAMA_LAB']." (".$lab['LOKASI'].") </option>";
                                                                }
                                                            }
                                                            echo form_open_multipart('administrasi_matkul/insert_kelas');?>
                                                            
                                                            <div class="form-group  row">
                                                                <label class="col-sm-4 col-form-label">Jadwal Kelas <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8"> 
                                                                    <h5>Pertemuan Ke - 1</h5>       
                                                                    <label>Hari :</label><select id="select_0" name="hari[]" class="form-control col-md-4" required><option value="" selected disabled>-- Please Select One --</option><option value="1">Senin</option><option value="2" >Selasa</option><option value="3" >Rabu</option><option value="4" >Kamis</option><option value="5" >Jumat</option><option value="6" >Sabtu</option></select>  
                                                                    <div class="col-sm-4 input-group clockpicker" data-autoclose="true"><label>Jam Mulai :</label> <input id="jam_mulai_0" type="text" name="jam_mulai[]" class="form-control" value="" data-mask="99:99" required></div>
                                                                    <div class="col-sm-4 input-group clockpicker" data-autoclose="true"><label>Jam Selesai :</label> <input id="jam_selesai_0" type="text" name="jam_selesai[]" class="form-control" value="" data-mask="99:99" required></div>
                                                                    <label>Ruangan Laboratorium :</label>
                                                                        <select name="lab[]" class="form-control" required>
                                                                            <option value="" disabled selected>-- Please Select One --</option>
                                                                            <?php echo $option;?>
                                                                        </select>
                                                                    
                                                                    <br>    
                                                                    <div id="container">
                                                                        
                                                                    </div>
                                                                    <a  href="javascript:void(0)" class="btn btn-sm add_button_pertemuan">Add Pertemuan</a>  
                                                                </div>
                                                                                
                                                            </div>
                                                            <div class="form-group  row">
                                                                <label class="col-sm-4 col-form-label">Kode Kelas <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" type="text" maxlength="1" placeholder="Contoh : A" name="kd_kelas" required>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                            <p style="color: red;" align="center">* Wajib Diisi</p>
                                                            <button type="submit" class="btn btn-success" name="">Masukkan Jadwal</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Kode Kelas</th>
                                                                    <th>Jadwal</th>
                                                                    <th>Lokasi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if(isset($jadwal_kelas) && $jadwal_kelas){
                                                                    $iterator = 1;
                                                                    foreach ($jadwal_kelas as $kelas) {
                                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $iterator;?></td>
                                                                    <td><?php echo $kelas['KODE_KELAS'];?></td>
                                                                    <td><?php echo $kelas['HARI']. " / ".$kelas['JAM_MULAI'] ." - ".$kelas['JAM_SELESAI'];?></td>
                                                                    <td><?php echo $kelas['NAMA_LAB']." (".$kelas['LOKASI'].")";?></td>
                                                                </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                }
                                                                else{
                                                                     echo "<tr><td colspan='4'>Jadwal kuliah belum diinput!</td></tr>";
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </li>
                                                <!--Menu Kebutuhan Perangkat Lunak-->
                                                <li>
                                                    <h4 style="font-weight: bold;">Kebutuhan Perangkat Lunak : </h4>
                                                    <?php
                                                    if($flag && $this->session->userdata('id_role') == 2){
                                                        ?>
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
                                                        <?php
                                                    }
                                                        ?>
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
                                                                                <?php
                                                                                if($flag && $this->session->userdata('id_role') == 2){

                                                                                 echo form_open('administrasi_matkul/perangkat_lunak/delete');?>
                                                                                
                                                                                <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                                <input type="hidden" name="id_pl" value="<?php echo $pl['ID'];?>" required>
                                                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kebutuhan perangkat lunak ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
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
                                                    <?php
                                                    if($flag && $this->session->userdata('id_role') == 2){
                                                        ?>
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
                                                        <?php
                                                    }
                                                        ?>
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
                                                                            <?php
                                                                            if($flag && $this->session->userdata('id_role') == 2){
                                                                                echo form_open('administrasi_matkul/file_bantuan/remove');?>
                                                                            <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                            <input type="hidden" name="id_file_bantuan" value="<?php echo $file['ID'];?>" required>
                                                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus file bantuan ini?')" class="btn btn-sm btn-danger" href=""><i class="fas fa-trash"></i> Hapus</button>
                                                                            </form>
                                                                            <?php
                                                                        }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                }
                                                                else{
                                                                    echo '<tr><td colspan="6">Belum ada file bantuan!</td></tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </li>
                                                <!-- END MENU FILE BANTUAN UJIAN-->
                                                <!--START MENU CHECKLIST PERSIAPAN UJIAN-->
                                                <li>
                                                    <h4 style="font-weight: bold;">Checklist Persiapan Ujian : </h4>
                                                    <?php
                                                    if($flag && $this->session->userdata('id_role') == 2){
                                                        ?>
                                                    <button class="btn btn-sm btn-success" id="btn_checklist"><i class="fas fa-tasks"></i> Checklist Persiapan Ujian</button>
                                                    <div style="display: none;" id="container_checklist" class="panel panel-success">
                                                        <div class="panel-heading">
                                                            <i class="fas fa-tasks"></i> Checklist Persiapan Ujian
                                                        </div>
                                                        <div class="panel-body">
                                                            <?php echo form_open_multipart('administrasi_matkul/checklist_ujian');?>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Tipe Ujian <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8">
                                                                    <select required class="form-control" name="tipe_ujian">
                                                                        <option value="" selected disabled>-- Please Select One --</option>
                                                                        <option value="0">Ujian Tengah Semester (UTS)</option>
                                                                        <option value="1">Ujian Akhir Semester (UAS)</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Hal yang diperiksa <span style="color: red">*</span> :</label>
                                                                <div class="col-sm-8">
                                                                    <div class="i-checks"><label> <input type="checkbox" value="01" name="checklist[]"> <i></i> Admin telah memiliki daftar terbaru peserta ujian</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="02" name="checklist[]"> <i></i> Posisi peserta ujian telah diacak, dicetak, dan ditempel.</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="03" name="checklist[]"> <i></i> Soal Ujian (hardcopy/softcopy) telah diberikan di komputer peserta</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="04" name="checklist[]"> <i></i> Pembuatan tempat pengumpulan jawaban ujian: (ujian.ftis.unpar/) atau (judgeujian.ftis.unpar/)</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="05" name="checklist[]"> <i></i> Penyetelan & Sinkronisasi waktu ujian di setiap ruangan</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="06" name="checklist[]"> <i></i> Penutupan/pembukaan drive Z mahasiswa</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="07" name="checklist[]"> <i></i> Penyalinan file bantuan dari dosen</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="08" name="checklist[]"> <i></i> Pembukaan/penutupan jalur ke server dan/atau internet</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value=09 name="checklist[]"> <i></i> Admin telah memiliki daftar terbaru peserta ujian</label></div>
                                                                    <div class="i-checks"><label> <input type="checkbox" value="10" name="checklist[]"> <i></i> Server bantuan telah diperiksa dan dapat digunakan untuk ujian</label></div>
                                                                </div>
                                                                <input type="hidden" name="id_matkul" value="<?php echo $_GET['id'];?>" required>
                                                                <button type="submit" class="btn btn-success" style="margin-left: 40px;">Submit Checklist</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>  
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="table-responsive">
                                                        <h5>Checklist UTS</h5>
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hal yang diperiksa</th>
                                                                    <th>Status</th>
                                                                    <th>Last Checked</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(isset($checklist_uts) && $checklist_uts){
                                                                    foreach ($checklist_uts as $uts) {
                                                                        ?>
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>Admin telah memiliki daftar terbaru peserta ujian</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_01'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>Posisi peserta ujian telah diacak, dicetak, dan ditempel</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_02'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>Soal ujian (hardcopy/softcopy) telah diberikan di komputer peserta</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_03'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>Pembuatan tempat pengumpulan jawaban ujian: (ujian.ftis.unpar/) atau (judgeujian.ftis.unpar/)</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_04'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td>Penyetelan & sinkronisasi waktu ujian di setiap ruangan ujian</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_05'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>6</td>
                                                                        <td>Penutupan/pembukaan drive Z mahasiswa</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_06'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>7</td>
                                                                        <td>Penyalinan file bantuan dari dosen</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_07'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>8</td>
                                                                        <td>Pembukaan/penutupan jalur ke server dan/atau internet</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_08'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>9</td>
                                                                        <td>Koordinasi jam buka/tutup pintu laboratorium</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_09'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>10</td>
                                                                        <td>Server bantuan telah diperiksa dan dapat digunakan untuk ujian</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uts['CHECKLIST_10'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uts['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                }
                                                                else{
                                                                    echo '<tr><td colspan="4">Checklist persiapan UTS belum dilakukan!</td></tr>';
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <h5>Checklist UAS</h5>
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hal yang diperiksa</th>
                                                                    <th>Status</th>
                                                                    <th>Last Checked</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(isset($checklist_uas) && $checklist_uas){
                                                                    $iterator = 1;
                                                                    foreach ($checklist_uas as $uas) {
                                                                        ?>
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>Admin telah memiliki daftar terbaru peserta ujian</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_01'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>Posisi peserta ujian telah diacak, dicetak, dan ditempel</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_02'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>Soal ujian (hardcopy/softcopy) telah diberikan di komputer peserta</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_03'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>Pembuatan tempat pengumpulan jawaban ujian: (ujian.ftis.unpar/) atau (judgeujian.ftis.unpar/)</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_04'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td>Penyetelan & sinkronisasi waktu ujian di setiap ruangan ujian</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_05'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>6</td>
                                                                        <td>Penutupan/pembukaan drive Z mahasiswa</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_06'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>7</td>
                                                                        <td>Penyalinan file bantuan dari dosen</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_07'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>8</td>
                                                                        <td>Pembukaan/penutupan jalur ke server dan/atau internet</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_08'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>9</td>
                                                                        <td>Koordinasi jam buka/tutup pintu laboratorium</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_09'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i>Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>10</td>
                                                                        <td>Server bantuan telah diperiksa dan dapat digunakan untuk ujian</td>
                                                                        <td>
                                                                            <?php
                                                                            if($uas['CHECKLIST_10'] != NULL){
                                                                                echo '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                                                                            }
                                                                            else{
                                                                                echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $uas['LAST_UPDATE'];?></td>
                                                                    </tr>
                                                                        <?php
                                                                        $iterator++;
                                                                    }
                                                                }
                                                                else{
                                                                    echo '<tr><td colspan="4">Checklist persiapan UAS belum dilakukan!</td></tr>';
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </li> 
                                                <!--END MENU CHECKLIST PERSIAPAN UJIAN-->
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>            
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                
                $('#btn_checklist').click(function () {
                    if($('#container_checklist').css('display') == 'none'){
                        $('#container_checklist').show();
                    }
                    else{
                        $('#container_checklist').hide();
                    }
                });
            </script>
