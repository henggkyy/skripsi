            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <?php $this->load->view('pages_user/V_Template_Periode_Aktif');?>
                            </div>
                        </div> 
                        
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h3>Detail Admin Laboratorium</h3>
                                </div>
                                <div class="ibox-content">
                                    <h2 align="center"><?php echo $nama_admin;?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h3>Informasi Admin</h3>
                                </div>
                                <div class="ibox-content">
                                    <ul class="unstyled">
                                            <li style="list-style-type: none;">
                                                    <ul>
                                                        <?php
                                                        if(isset($data_admin) && $data_admin){
                                                            foreach ($data_admin as $admin) {
                                                                ?>
                                                                <li><h4><span style="font-weight: bold;">Nama : </span><?php echo $admin['NAMA'];?></li></h4>
                                                                <li><h4><span style="font-weight: bold;">Email : </span><?php echo $admin['EMAIL'];?></h4></li>
                                                                <li><h4><span style="font-weight: bold;">NIK : </span><?php echo $admin['NIK'];?></h4></li>
                                                                <li><h4><span style="font-weight: bold;">Angkatan : </span><?php echo $admin['ANGKATAN'];?></h4></li>
                                                                <li><h4><span style="font-weight: bold;">Periode Kontrak : </span><?php echo $admin['AWAL_KONTRAK'].' s/d '. $admin['AKHIR_KONTRAK'];?></h4></li>
                                                                <li><h4><span style="font-weight: bold;">Golongan : </span><?php echo $admin['NAMA_GOLONGAN'].' ('. $admin['TARIF']."/jam)";?></h4></li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                </div>
                            </div>
                        </div>  
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                 <div class="ibox-title">
                                    <h3>Pengajuan Jadwal Bertugas Admin</h3>
                                </div>
                                <div class="ibox-content">               
                                    <?php
                                    if($periode_aktif && $flag_admin){

                                    ?>
                                    <button data-toggle="modal" data-target="#modalJadwalAuto" class="btn btn-md btn-success"><i class="far fa-calendar-alt"></i> Pengajuan Jadwal Bertugas (Masa Perkuliahan)</button>
                                    <!--Modal Pengajuan Jadwal Bertugas (Masa Kuliah)-->
                                                                <div class="modal inmodal" id="modalJadwalAuto" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Pengajuan Jadwal Bertugas (Masa Perkuliahan)</h4>
                                                                            </div>
                                                                            <?php echo form_open('admin_lab/pengajuan_masa_kuliah');?>
                                                                            <div class="modal-body">
                                                                                <div id="form_bertugas_auto">
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-6 col-form-label">Hari Bertugas <span style="color: red">*</span> :</label>
                                                                                        <div class="col-sm-6 input-group">
                                                                                            <select name="hari_bertugas[]" class="form-control" required><option value="" selected disabled>-- Please Select One --</option><option value="Monday">Senin</option><option value="Tuesday" >Selasa</option><option value="Wednesday" >Rabu</option><option value="Thursday" >Kamis</option><option value="Friday" >Jumat</option><option value="Saturday" >Sabtu</option></select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-6 col-form-label">Jam Mulai Bertugas <span style="color: red">*</span> :</label>
                                                                                        <div class="col-sm-6">
                                                                                            <input id="waktu_awal" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai[]">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group row">
                                                                                        <label class="col-sm-6 col-form-label">Jam Selesai Bertugas <span style="color: red">*</span> :</label>
                                                                                        <div class="col-sm-6">
                                                                                            <input id="waktu_akhir" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai[]">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <a href="javascript:void(0)" id="add_day" class="btn btn-sm btn-primary">Add Hari</a>
                                                                               
                                                                                <p align="center" style="font-size: 12px; font-weight: bold;">Form ini akan melakukan pengajuan jadwal bertugas kepada Kepala Laboratorium untuk masa Perkuliahan</p>
                                                                                <p align="center" style="color: red">* Wajib Diisi</p>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END Modal Pengajuan Jadwal (Masa Kuliah)-->
                                    <button data-toggle="modal" data-target="#modalJadwalManual" class="btn btn-md btn-success"><i class="far fa-calendar-alt"></i> Pengajuan Jadwal Bertugas (Masa UTS/UAS)</button>
                                    <!--Modal Pengajuan Jadwal (UJian)-->
                                                                <div class="modal inmodal" id="modalJadwalManual" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Pengajuan Jadwal Bertugas (Masa UTS/UAS)</h4>
                                                                            </div>
                                                                            <?php echo form_open('admin_lab/pengajuan_masa_ujian');?>
                                                                            <div class="modal-body">
                                                                                
                                                                                <div class="form-group row" id="data_1">
                                                                                    <label class="col-sm-6 col-form-label">Tanggal Bertugas <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-6 input-group date">
                                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required type="text" placeholder="mm/dd/yyy" data-mask="99/99/9999" class="form-control" name="tgl_bertugas">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-6 col-form-label">Jam Mulai Bertugas <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-6">
                                                                                        <input id="waktu_awal_2" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_mulai">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-6 col-form-label">Jam Selesai Bertugas <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-6">
                                                                                        <input id="waktu_akhir_2" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" name="jam_selesai">
                                                                                    </div>
                                                                                </div>
                                                                               
                                                                                <p align="center" style="font-size: 12px; font-weight: bold;">Form ini akan melakukan pengajuan jadwal bertugas kepada Kepala Laboratorium untuk masa Ujian (UTS/UAS)</p>
                                                                                <p align="center" style="color: red">* Wajib Diisi</p>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END Modal Pengajuan Jadwal (Ujian)-->
                                        <?php
                                        }
                                        else{
                                            if(!$periode_aktif){
                                                echo '<h4 style="color: red;">Tidak dapat melakukan pengajuan jadwal bertugas admin karena tidak ada periode akademik yang sedang berjalan!</h4>';
                                            }
                                            if(!$flag_admin){
                                                echo '<h4 style="color: red;">Tidak dapat menambahkan jadwal bertugas admin karena admin dalam status nonaktif!</h4>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h3>Jadwal Bertugas Admin</h3>
                                </div>
                                <div class="ibox-content">
                                    <label class="col-sm-4 col-form-label">Periode Akademik:</label>
                                    <div class="col-sm-8 ">
                                        <form method="GET" action="<?php echo base_url()."admin_lab/jadwal_bertugas";?>">
                                            <select name="id_periode" onchange="this.form.submit()" class="form-control">
                                                <?php
                                                if(isset($daftar_periode) && $daftar_periode){
                                                    foreach ($daftar_periode as $list_periode) {
                                                ?>
                                                <option value="<?php echo $list_periode['ID'];?>" <?php if($list_periode['ID'] == $id_periode_aktif){ echo 'selected';}?>><?php echo $list_periode['NAMA'];?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </form>
                                    </div>
                                    <hr>
                                    <h4>Calendar View</h4>
                                    <div id="calendar">
                                        
                                    </div>
                                    <hr>
                                    <h4>Datatables</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                                if(isset($jadwal_admin) && $jadwal_admin){ echo 'mainDataTable';}?>">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Hari/Tanggal</th>
                                                    <th>Waktu Bertugas</th>
                                                    <th>Jenis Bertugas</th>
                                                    <th>Last Update</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($jadwal_admin) && $jadwal_admin){
                                                    $iterator = 1;
                                                    foreach ($jadwal_admin as $jadwal) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $jadwal['HARI'].'/'. $jadwal['TANGGAL'];?></td>
                                                        <td><?php echo $jadwal['JAM_MULAI']. ' s/d '. $jadwal['JAM_SELESAI'];?></td>
                                                        <td><?php echo $jadwal['TIPE_BERTUGAS'];?></td>
                                                        <td><?php echo $jadwal['INSERT_DATE'];?></td>
                                                    </tr>
                                                    <?php
                                                    $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='6'>Belum ada jadwal bertugas admin</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                         <!--START MODAL UPDATE JADWAL-->
                                        <div class="modal inmodal" id="modalUpdateJadwal" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content animated fadeIn">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title">Update Jadwal Bertugas</h4>
                                                    </div>
                                                    <div class="modal-body" id="modal-content">
                                                        <img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--END MODAL UPDATE JADWAL-->
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal inmodal" id="modal_event" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn"> 
                                        <div class="modal-body">
                                            <h2 id="judul_event" align="center"></h2>
                                            <hr>
                                            <h3>Nama Event : <span style="font-weight: normal;" id="event"></span></h3>
                                            <h3>Waktu Mulai : <span style="font-weight: normal;" id="start"></span></h3>
                                            <h3>Waktu Selesai : <span style="font-weight: normal;" id="end"></span></h3>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
