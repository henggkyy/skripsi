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
                                    <h5>Administrasi Admin Laboratorium</h5>
                                </div>
                                <div class="ibox-content">
                                    <button type="button" data-toggle="modal" data-target="#modalAddAdmin" class="btn btn-w-m btn-success"><i class="fas fa-user-plus"></i> Tambah Admin</button>
                                    <!--Modal Add Dosen-->
                                    <div class="modal inmodal" id="modalAddAdmin" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Tambah Admin</h4>
                                                </div>
                                                <?php echo form_open('admin_lab/add');?>
                                                <div class="modal-body">
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">NIK Admin <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="nik" class="form-control" data-mask="99999999" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Nama Admin <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="nama" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Email Admin <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" name="email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Angkatan <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="angkatan" class="form-control" data-mask="9999" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" id="data_1">
                                                        <label class="col-sm-4 col-form-label">Mulai Kontrak <span style="color: red">*</span> :</label>
                                                        <div class="input-group date col-sm-8">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" placeholder="mm/dd/yyyy" data-mask="99/99/9999" name="awal_kontrak" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" id="data_1">
                                                        <label class="col-sm-4 col-form-label">Akhir Kontrak <span style="color: red">*</span> :</label>
                                                        <div class="input-group date col-sm-8">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" placeholder="mm/dd/yyyy" data-mask="99/99/9999" name="akhir_kontrak" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" id="data_1">
                                                        <label class="col-sm-4 col-form-label">Golongan Gaji <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select name="id_gol" required class="form-control">
                                                                <option value="" selected disabled>-- Please Select One --</option>
                                                                <?php
                                                                if(isset($konfigurasi_gaji) && $konfigurasi_gaji){
                                                                    foreach ($konfigurasi_gaji as $konf) {
                                                                        ?>
                                                                <option value="<?php echo $konf['ID'];?>"><?php echo $konf['NAMA_GOLONGAN']." (".$konf['TARIF']."/jam)";?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <p style="color: red;" align="center">* Wajib Diisi</p>
                                                </div>
                                                <div class="modal-footer">
                                                    
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Tambah Admin</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END MODAL ADD DOSEN-->
                                    <hr>
                                    <h3>Data Admin</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                                if(isset($data_admin) && $data_admin){ echo 'mainDataTable';}?>">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>NIK</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($data_admin) && $data_admin){
                                                    $iterator = 1;
                                                    foreach ($data_admin as $admin) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $admin['NAMA'];?></td>
                                                        <td><?php echo $admin['EMAIL'];?></td>
                                                        <td><?php echo $admin['NIK'];?></td>
                                                        <td>
                                                        <?php if($admin['STATUS'] == 1){
                                                            echo 'Aktif';
                                                        }
                                                        else{
                                                            echo 'Tidak Aktif';
                                                        }
                                                        ?>
                                                        </td>
                                                        <td align="center">
                                                            <a href="<?php echo base_url().'admin_lab/detail?id_admin='.$admin['ID'];?>" class="btn btn-primary btn-sm"><i class="fas fa-info"></i> Detail</button></a>
                                                            <?php if($admin['STATUS'] == 1){
                                                                echo form_open('admin_lab/nonactivate');?>
                                                                <input type="hidden" name="id_admin" value="<?php echo $admin['ID'];?>" required>
                                                                <button onclick="return confirm('Apakah Anda yakin ingin menonaktifkan admin ini?')" class="btn btn-danger btn-sm" type="submit">Nonaktifkan</button>
                                                                </form>
                                                                <?php
                                                            }
                                                            else{
                                                                echo form_open('admin_lab/activate');?>
                                                                <input type="hidden" name="id_admin" value="<?php echo $admin['ID'];?>" required>
                                                                <button onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali admin ini?')" class="btn btn-success btn-sm" type="submit">Aktifkan</button>
                                                                </form>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php    
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='6'>Belum ada admin yang terdaftar</td></tr>";
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