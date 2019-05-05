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
                                    <h2 align="center"><?php echo $nama_admin;?> (<?php echo $inisial;?>)</h2>
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
                                                                <li><h4><span style="font-weight: bold;">Nama : </span><?php echo $admin['NAMA'];?> (<?php echo $inisial;?>)</h4></li>
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
                                    <h3>Edit Masa Kontrak & Jadwal Bertugas Admin</h3>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if($this->session->userdata('id_role') == 1){
                                        ?>
                                    <button data-toggle="modal" data-target="#modalKontrak" class="btn btn-md btn-primary"><i class="fas fa-user-edit"></i> Perbaharui Masa Kontrak</button>
                                        <?php
                                    }
                                    ?>
                                    
                                    <?php
                                    if(!$flag_gaji && $flag_admin && $this->session->userdata('id_role') == 3){?>
                                         <button data-toggle="modal" data-target="#modalGolongan" class="btn btn-md btn-info"><i class="fas fa-user-edit"></i> Perbaharui Golongan Gaji</button>
                                    <!--Modal Golongan Gaji-->
                                    <div class="modal inmodal" id="modalGolongan" tabindex="-1" role="dialog"  aria-hidden="true">
                                         <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                 <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Perbaharui Golongan Gaji</h4>
                                                 </div>
                                                 <?php echo form_open('admin_lab/update_golongan');?>
                                                 <div class="modal-body">
                                                    <div class="form-group row" >
                                                        <label class="col-sm-6 col-form-label">Golongan Gaji <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control" name="id_gol" required>
                                                                <?php
                                                                if(isset($konfigurasi_gaji) && $konfigurasi_gaji){
                                                                    foreach ($konfigurasi_gaji as $konf) {
                                                                        ?>
                                                                    <option <?php if($id_gol == $konf['ID']){ echo 'selected';}?> value="<?php echo $konf['ID'];?>" ><?php echo $konf['NAMA_GOLONGAN']." (".$konf['TARIF']."/jam)";?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="id_admin" required value="<?php echo $id_admin;?>">
                                                    </div>
                                                 </div>
                                                 <div class="modal-footer">
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="button_save" class="btn btn-primary">Save changes</button>
                                                </div>
                                                </form>
                                            </div>
                                         </div>
                                    </div>
                                    <?php
                                    }
                                    else{
                                        if(!$flag_admin){
                                            echo '<h4 style="color: red;">Tidak dapat melakukan edit golongan gaji admin karena admin dalam status nonaktif!</h4>';
                                        }
                                        if($flag_gaji){
                                            echo '<h4 style="color: red;">Tidak dapat melakukan edit golongan gaji admin karena terdapat periode gaji yang sedang berjalan!</h4>';
                                        }
                                        
                                    }
                                    ?>
                                   
                                                                <!--Modal Update Kontrak-->
                                                                <div class="modal inmodal" id="modalKontrak" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Perbaharui Masa Kontrak</h4>
                                                                            </div>
                                                                            <?php echo form_open_multipart('admin_lab/update_kontrak');?>
                                                                            <div class="modal-body">
                                                                                
                                                                                <div class="form-group  row" >
                                                                                    <label class="col-sm-6 col-form-label">Tanggal Mulai Kontrak <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-6 input-group date">
                                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tgl_mulai" required type="text" placeholder="mm/dd/yyy"  class="form-control" name="mulai_kontrak">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group  row" >
                                                                                    <label class="col-sm-6 col-form-label">Tanggal Berakhir Kontrak <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-6 input-group date">
                                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required id="tgl_akhir" type="text" placeholder="mm/dd/yyy" data-mask="99/99/9999" class="form-control" name="akhir_kontrak">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group  row">
                                                                                    <label class="col-sm-6 col-form-label">Surat Tugas (.pdf maks. 2MB) <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-6">
                                                                                        <input class="input_pdf" type="file" required name="dokumen" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="id_admin" value="<?php echo $id_admin;?>" required>
                                                                                <p align="center" style="color: red">* Wajib Diisi</p>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                                <button type="submit" id="button_save" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- END Modal Update Kontrak-->
                                    <?php
                                    if($periode_aktif && $flag_admin && $this->session->userdata('id_role') == 1){

                                    ?>
                                    <button data-toggle="modal" data-target="#modalJadwalAuto" class="btn btn-md btn-success"><i class="far fa-calendar-alt"></i> Add Jadwal Bertugas (Auto)</button>
                                    <!--Modal Jadwal (Auto)-->
                                                                <div class="modal inmodal" id="modalJadwalAuto" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Insert Jadwal Bertugas Admin (Auto)</h4>
                                                                            </div>
                                                                            <?php echo form_open('admin_lab/insert_jadwal_auto');?>
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
                                                                                <input type="hidden" name="id_admin" value="<?php echo $id_admin;?>" required>
                                                                                <p align="center" style="font-size: 12px; font-weight: bold;">Form ini akan melakukan generate seluruh tanggal bertugas pada periode akademik yg sdg aktif berdasarkan hari yang dipilih<br>
                                                                                Tanggal bertugas pada periode UTS/UAS tidak akan masuk dari form ini. Jadwal bertugas UTS/UAS harap input secara manual</p>
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
                                                                <!-- END Modal Jadwal (Auto)-->
                                    <button data-toggle="modal" data-target="#modalJadwalManual" class="btn btn-md btn-success"><i class="far fa-calendar-alt"></i> Add Jadwal Bertugas (Manual)</button>
                                    <!--Modal Jadwal (Manual)-->
                                                                <div class="modal inmodal" id="modalJadwalManual" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Insert Jadwal Bertugas Admin (Manual)</h4>
                                                                            </div>
                                                                            <?php echo form_open('admin_lab/insert_jadwal_manual');?>
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
                                                                                <input type="hidden" name="id_admin" value="<?php echo $id_admin;?>" required>
                                                                                <p align="center" style="font-size: 12px; font-weight: bold;">Tanggal bertugas harus berada pada tanggal periode akademik yg sdg aktif<br>
                                                                                Tanggal bertugas pada periode UTS/UAS akan langsung masuk ke dalam shift bertugas UTS/UAS</p>
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
                                                                <!-- END Modal Jadwal (Manual)-->
                                        <?php
                                        }
                                        else{
                                            if(!$periode_aktif){
                                                echo '<h4 style="color: red;">Tidak dapat menambahkan jadwal bertugas admin karena tidak ada periode akademik yang sedang berjalan!</h4>';
                                            }
                                            if(!$flag_admin){
                                                echo '<h4 style="color: red;">Tidak dapat menambahkan jadwal bertugas admin karena admin dalam status nonaktif!</h4>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        if($this->session->userdata('id_role') == 1){
                            ?>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Surat Tugas Admin</h5>
                                    <div class="ibox-tools" style="float:left;">
                                        <a>
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Periode Kontrak</th>
                                                    <th>Dokumen Surat Tugas</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($surat_tugas) && $surat_tugas){
                                                    $iterator = 1;
                                                    foreach ($surat_tugas as $surat) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $surat['AWAL_KONTRAK']." s/d ". $surat['AKHIR_KONTRAK'];?></td>
                                                        <td><a target="_blank" href="<?php echo base_url();?>uploads/surat_tugas/<?php echo $surat['PATH_FILE'];?>">Lihat Dokumen</a></td>
                                                    </tr>
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='3'>Belum ada surat tugas admin!</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Pengajuan Jadwal Bertugas</h5>
                                    <div class="ibox-tools" style="float:left;">
                                        <a>
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content collapsed">
                                    <label class="col-sm-4 col-form-label">Periode Akademik:</label>
                                    <div class="col-sm-8 ">
                                        <form method="GET" action="<?php echo base_url()."admin_lab/detail?id_admin=".$id_admin;?>">
                                            <input type="hidden" name="id_admin" required value="<?php echo $id_admin;?>">
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
                                    <div class="row">
                                    	<label class="col-sm-4 col-form-label">Masa Perkuliahan :</label>
	                                    <div class="col-sm-8 table-responsive">
	                                        <table class="table table-striped table-bordered table-hover">
	                                            <thead>
	                                                <tr>
	                                                    <th>#</th>
	                                                    <th>Hari/Tanggal</th>
	                                                    <th>Waktu Bertugas Yang Diajukan</th>
	                                                    <th>Waktu Bertugas Yang Disetujui</th>
	                                                    <th>Last Update</th>
	                                                    <th>Aksi</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                                <?php
	                                                if(isset($jadwal_pending_kuliah) && $jadwal_pending_kuliah){
	                                                    $iterator = 1;
	                                                    $total_hours = 0;
	                                                    $total_hours_accept = 0;
	                                                    foreach ($jadwal_pending_kuliah as $pend_kul) {
	                                                        if($pend_kul['STATUS'] == 1){
	                                                            $start = explode(':', $pend_kul['JAM_MULAI_DISETUJUI']);
	                                                            $end = explode(':', $pend_kul['JAM_SELESAI_DISETUJUI']);
	                                                            $total_hours_accept += $end[0] - $start[0] - ($end[1] < $start[1]);
	                                                        }
	                                                       
	                                                        $start = explode(':', $pend_kul['JAM_MULAI']);
	                                                        $end = explode(':', $pend_kul['JAM_SELESAI']);
	                                                        $total_hours += $end[0] - $start[0] - ($end[1] < $start[1]);
	                                                        
	                                                        ?>
	                                                        <tr>
	                                                            <td><?php echo $iterator;?></td>
	                                                            <td><?php echo $pend_kul['HARI'];?></td>
	                                                            <td><?php echo $pend_kul['JAM_MULAI']." s/d ". $pend_kul['JAM_SELESAI'];?></td>
	                                                            <td>
	                                                            <?php
	                                                            if($pend_kul['JAM_MULAI_DISETUJUI'] != NULL){
	                                                                echo $pend_kul['JAM_MULAI_DISETUJUI'].' s/d '.$pend_kul['JAM_SELESAI_DISETUJUI'];
	                                                            }
	                                                            else{
	                                                                echo '-';
	                                                            }?>    
	                                                            </td>
	                                                            <td><?php echo $pend_kul['DATE_SUBMITTED'];?></td>
	                                                            <td align="center">
	                                                                <?php

	                                                                if($pend_kul['STATUS'] == 0 && $flag){
	                                                                    ?>
	                                                                <button type="submit" onclick="loadModalAccept(<?php echo $pend_kul['ID'];?>, <?php echo $_GET['id_admin'];?>, 0, 'det');" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
	                                                                    <?php
	                                                                    echo form_open('admin_lab/reject_pengajuan');
	                                                                    ?>
	                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $pend_kul['ID'];?>" required>
	                                                                <input type="hidden" name="id_admin" value="<?php echo $_GET['id_admin'];?>" required>
	                                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan jadwal ini?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
	                                                                </form>
	                                                                    <?php
	                                                                }
	                                                                else if($pend_kul['STATUS'] == 1 && $flag){
	                                                                    
	                                                                    echo 'Sudah disetujui';
	                                                                }
	                                                                else if($pend_kul['STATUS'] == 1 && !$flag){
	                                                                    echo 'Sudah disetujui';
	                                                                }
	                                                                else if($pend_kul['STATUS'] == 2 ){
	                                                                    echo 'Tidak disetujui';
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
	                                                    echo'<tr>
	                                                            <td align="center" colspan="6">Total : '.$total_hours.' jam/minggu<br>Yang disetujui : '.$total_hours_accept.' jam/minggu</td>
	                                                        </tr>' ;
	                                                }
	                                                else{
	                                                    echo'<tr><td colspan="6">Admin belum melakukan pengajuan jadwal bertugas pada masa perkuliahan!</td></tr>' ;
	                                                }
	                                                ?>
	                                            </tbody>
	                                        </table>
	                                    </div>
	                                    <label class="col-sm-4 col-form-label">Masa UTS :</label>
	                                    <div class="col-sm-8 table-responsive">
	                                        <table class="table table-striped table-bordered table-hover">
	                                            <thead>
	                                                <tr>
	                                                    <th>#</th>
	                                                    <th>Hari/Tanggal</th>
	                                                    <th>Waktu Bertugas Yang Diajukan</th>
	                                                    <th>Waktu Bertugas Yang Disetujui</th>
	                                                    <th>Last Update</th>
	                                                    <th>Aksi</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                                <?php
	                                                if(isset($jadwal_pending_uts) && $jadwal_pending_uts){
	                                                    $iterator = 1;
	                                                    $total_hours = 0;
	                                                    $total_hours_accept = 0;
	                                                    foreach ($jadwal_pending_uts as $pend_uts) {
	                                                        if($pend_uts['STATUS'] == 1){
	                                                            $start = explode(':', $pend_uts['JAM_MULAI_DISETUJUI']);
	                                                            $end = explode(':', $pend_uts['JAM_SELESAI_DISETUJUI']);
	                                                            $total_hours_accept += $end[0] - $start[0] - ($end[1] < $start[1]);
	                                                        }
	                                                       
	                                                        $start = explode(':', $pend_uts['JAM_MULAI']);
	                                                        $end = explode(':', $pend_uts['JAM_SELESAI']);
	                                                        $total_hours += $end[0] - $start[0] - ($end[1] < $start[1]);
	                                                        ?>
	                                                        <tr>
	                                                            <td><?php echo $iterator;?></td>
	                                                            <td><?php echo $pend_uts['HARI']."/".$pend_uts['TANGGAL'];?></td>
	                                                            <td><?php echo $pend_uts['JAM_MULAI']." s/d ". $pend_uts['JAM_SELESAI'];?></td>
	                                                            <td>
	                                                            <?php
	                                                            if($pend_uts['JAM_MULAI_DISETUJUI'] != NULL){
	                                                                echo $pend_uts['JAM_MULAI_DISETUJUI'].' s/d '.$pend_uts['JAM_SELESAI_DISETUJUI'];
	                                                            }
	                                                            else{
	                                                                echo '-';
	                                                            }?>    
	                                                            </td>
	                                                            <td><?php echo $pend_uts['DATE_SUBMITTED'];?></td>
	                                                            <td align="center">
	                                                                <?php

	                                                                if($pend_uts['STATUS'] == 0 && $flag){
	                                                                    ?>
	                                                                <button type="submit" onclick="loadModalAccept(<?php echo $pend_uts['ID'];?>, <?php echo $_GET['id_admin'];?>, 0, 'det');" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
	                                                                    <?php
	                                                                    echo form_open('admin_lab/reject_pengajuan');
	                                                                    ?>
	                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $pend_uts['ID'];?>" required>
	                                                                <input type="hidden" name="id_admin" value="<?php echo $_GET['id_admin'];?>" required>
	                                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan jadwal ini?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
	                                                                </form>
	                                                                    <?php
	                                                                }
	                                                                else if($pend_uts['STATUS'] == 1 && $flag){
	                                                                    
	                                                                    echo 'Sudah disetujui';
	                                                                }
	                                                                else if($pend_uts['STATUS'] == 1 && !$flag){
	                                                                    echo 'Sudah disetujui';
	                                                                }
	                                                                else if($pend_uts['STATUS'] == 2 ){
	                                                                    echo 'Tidak disetujui';
	                                                                }
	                                                                else{
	                                                                	echo '-' ;
	                                                                }
	                                                                ?>
	                                                            </td>
	                                                        </tr>
	                                                        <?php
	                                                        $iterator++;
	                                                    }
	                                                    echo'<tr>
	                                                            <td align="center" colspan="6">Total : '.$total_hours.' jam/minggu<br>Yang disetujui : '.$total_hours_accept.' jam/minggu</td>
	                                                        </tr>' ;
	                                                }
	                                                else{
	                                                    echo'<tr><td colspan="6">Admin belum melakukan pengajuan jadwal bertugas pada masa UTS!</td></tr>' ;
	                                                }
	                                                ?>
	                                            </tbody>
	                                        </table>
	                                    </div>
	                                    <label class="col-sm-4 col-form-label">Masa UAS :</label>
	                                    <div class="col-sm-8 table-responsive">
	                                        <table class="table table-striped table-bordered table-hover">
	                                            <thead>
	                                                <tr>
	                                                    <th>#</th>
	                                                    <th>Hari/Tanggal</th>
	                                                    <th>Waktu Bertugas Yang Diajukan</th>
	                                                    <th>Waktu Bertugas Yang Disetujui</th>
	                                                    <th>Last Update</th>
	                                                    <th>Aksi</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                                <?php
	                                                if(isset($jadwal_pending_uas) && $jadwal_pending_uas){
	                                                    $iterator = 1;
	                                                    $total_hours = 0;
	                                                    $total_hours_accept = 0;
	                                                    foreach ($jadwal_pending_uas as $pend_uas) {
	                                                        if($pend_uas['STATUS'] == 1){
	                                                            $start = explode(':', $pend_uas['JAM_MULAI_DISETUJUI']);
	                                                            $end = explode(':', $pend_uas['JAM_SELESAI_DISETUJUI']);
	                                                            $total_hours_accept += $end[0] - $start[0] - ($end[1] < $start[1]);
	                                                        }
	                                                       
	                                                        $start = explode(':', $pend_uas['JAM_MULAI']);
	                                                        $end = explode(':', $pend_uas['JAM_SELESAI']);
	                                                        $total_hours += $end[0] - $start[0] - ($end[1] < $start[1]);
	                                                        ?>
	                                                        <tr>
	                                                            <td><?php echo $iterator;?></td>
	                                                            <td><?php echo $pend_uas['HARI']."/".$pend_uas['TANGGAL'];?></td>
	                                                            <td><?php echo $pend_uas['JAM_MULAI']." s/d ". $pend_uas['JAM_SELESAI'];?></td>
	                                                            <td>
	                                                            <?php
	                                                            if($pend_uas['JAM_MULAI_DISETUJUI'] != NULL){
	                                                                echo $pend_uas['JAM_MULAI_DISETUJUI'].' s/d '.$pend_uas['JAM_SELESAI_DISETUJUI'];
	                                                            }
	                                                            else{
	                                                                echo '-';
	                                                            }?>    
	                                                            </td>
	                                                            <td><?php echo $pend_uas['DATE_SUBMITTED'];?></td>
	                                                            <td align="center">
	                                                                <?php

	                                                                if($pend_uas['STATUS'] == 0 && $flag){
	                                                                    ?>
	                                                                 <button type="submit" onclick="loadModalAccept(<?php echo $pend_uas['ID'];?>, <?php echo $_GET['id_admin'];?>, 0, 'det');" class="btn btn-sm btn-primary"><i class="fas fa-vote-yea"></i> Accept</button>
	                                                                <?php
	                                                                    echo form_open('admin_lab/reject_pengajuan');
	                                                                    ?>
	                                                                <input type="hidden" name="id_pengajuan" value="<?php echo $pend_uas['ID'];?>" required>
	                                                                <input type="hidden" name="id_admin" value="<?php echo $_GET['id_admin'];?>" required>
	                                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan jadwal ini?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</button>
	                                                                </form>
	                                                                    <?php
	                                                                }
	                                                                else if($pend_uas['STATUS'] == 1 && $flag){
	                                                                    
	                                                                    echo 'Sudah disetujui';
	                                                                }
	                                                                else if($pend_uas['STATUS'] == 1 && !$flag){
	                                                                    echo 'Sudah disetujui';
	                                                                }
	                                                                else if($pend_uas['STATUS'] == 2 ){
	                                                                    echo 'Tidak disetujui';
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
	                                                    echo'<tr>
	                                                            <td align="center" colspan="6">Total : '.$total_hours.' jam/minggu<br>Yang disetujui : '.$total_hours_accept.' jam/minggu</td>
	                                                        </tr>' ;
	                                                }
	                                                else{
	                                                    echo'<tr><td colspan="6">Admin belum melakukan pengajuan jadwal bertugas pada masa UAS!</td></tr>' ;
	                                                }
	                                                ?>
	                                            </tbody>
	                                        </table>
	                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Jadwal Bertugas Admin</h5>
                                    
                                </div>
                                <div class="ibox-content">
                                    <label class="col-sm-4 col-form-label">Periode Akademik:</label>
                                    <div class="col-sm-8 ">
                                        <form method="GET" action="<?php echo base_url()."admin_lab/detail?id_admin=".$id_admin;?>">
                                            <input type="hidden" name="id_admin" required value="<?php echo $id_admin;?>">
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
                                    <div class="row">
                                        <div class="tiva-timetable" data-url="<?php echo base_url();?>" id-periode="<?php echo $id_periode_aktif; ?>" id-admin="<?php echo $id_admin;?>" data-source="ind_admin" data-view="month">  
                                        </div>
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
                                                    <th>Aksi</th>
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
                                                        <td align="center">
                                                            <?php
                                                            if($flag && $flag_admin){
                                                                ?>
                                                            <button class="btn btn-primary btn-sm" data-toggle="modal" onclick="getJadwal(<?php echo $jadwal['ID_JADWAL'];?>,<?php echo $id_admin;?>);" data-target="#modalUpdateJadwal"><i class="fas fa-pen"></i> Update</button>
                                                            <?php echo form_open('admin_lab/delete_jadwal', 'style="margin: 0; padding: 0;"');?>
                                                            <input type="hidden" name="id_bertugas" required value="<?php echo $jadwal['ID_JADWAL'];?>">
                                                            <input type="hidden" name="id_admin" required value="<?php echo $id_admin;?>">
                                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
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
                            <?php
                        }
                        ?>
                        
                        <div class="col-lg-4">
                            <a class="btn btn-md btn-primary" href="<?php echo base_url();?>admin_lab"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal inmodal" id="modalAccept" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Setujui Pengajuan Jadwal Bertugas Admin</h4>
                        </div>
                        <div class="modal-body" id="modal-content-pengajuan">
                            <img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
                function loadModalAccept(id, id_admin, tipe_bertugas, method){
                    $("#modal-content-pengajuan").html(loader);
                    $('#modalAccept').modal('show');
                    console.log(id);
                    console.log(id_admin);
                    console.log(tipe_bertugas);
                    console.log(method);
                    $.ajax({

                        url: "<?php echo base_url();?>" + "admin_lab/get_pengajuan",
                        method: "GET",
                        data: {id : id, id_admin : id_admin, tipe_bertugas:tipe_bertugas, method:method},
                        success: function(data) { 
                            $("#modal-content-pengajuan").html(data);
                            $('#waktu_awal_modal').clockpicker({
                                autoclose: true
                            });
                            $('#waktu_akhir_modal').clockpicker({
                                autoclose: true
                            });
                        }
                    }); 
                }
            </script>
