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
                                    <button data-toggle="modal" data-target="#modalKontrak" class="btn btn-md btn-primary"><i class="fas fa-user-edit"></i> Perbaharui Masa Kontrak</button>
                                                                <!--Modal Update Kontrak-->
                                                                <div class="modal inmodal" id="modalKontrak" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Perbaharui Masa Kontrak</h4>
                                                                            </div>
                                                                            <?php echo form_open('admin_lab/update_kontrak');?>
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
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h3>Jadwal Bertugas Admin (Calendar View)</h3>
                                </div>
                                <div class="ibox-content">
                                    <div id="calendar">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h3>Jadwal Bertugas Admin (Datatables)</h3>
                                </div>
                                <div class="ibox-content">
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
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                    $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='6'>Belum ada dokumen SOP</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
