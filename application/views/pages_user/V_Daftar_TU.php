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
                                    <h5>Administrasi Tata Usaha</h5>
                                </div>
                                <div class="ibox-content">
                                    <button type="button" data-toggle="modal" data-target="#modalAddTU" class="btn btn-w-m btn-success"><i class="fas fa-user-plus"></i> Tambah Petugas Tata Usaha</button>
                                    <!--Modal Add Dosen-->
                                    <div class="modal inmodal" id="modalAddTU" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Tambah Tata Usaha</h4>
                                                </div>
                                                <?php echo form_open('tata_usaha/add');?>
                                                <div class="modal-body">
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">NIK Petugas <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="nik" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Nama Petugas <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="nama" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Email Petugas <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" name="email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <p style="color: red;" align="center">* Wajib Diisi</p>
                                                </div>
                                                <div class="modal-footer">
                                                    
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Tambah Tata Usaha</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END MODAL ADD TU-->
                                    <hr>
                                    <h3>Data Petugas Tata Usaha</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                                if(isset($data_tu) && $data_tu){ echo 'mainDataTable';}?>">
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
                                                if(isset($data_tu) && $data_tu){
                                                    $iterator = 1;
                                                    foreach ($data_tu as $tu) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $tu['NAMA'];?></td>
                                                        <td><?php echo $tu['EMAIL'];?></td>
                                                        <td><?php echo $tu['NIK'];?></td>
                                                        <td>
                                                        <?php if($tu['STATUS'] == 1){
                                                            echo 'Aktif';
                                                        }
                                                        else{
                                                            echo 'Tidak Aktif';
                                                        }
                                                        ?>
                                                        </td>
                                                        <td align="center">
                                                           
                                                            <?php if($tu['STATUS'] == 1){
                                                                echo form_open('tata_usaha/nonactivate');?>
                                                                <input type="hidden" name="id_tu" value="<?php echo $tu['ID'];?>" required>
                                                                <button onclick="return confirm('Apakah Anda yakin ingin menonaktifkan petugas tata usaha ini?')" class="btn btn-danger btn-sm" type="submit">Nonaktifkan</button>
                                                                </form>
                                                                <?php
                                                            }
                                                            else{
                                                                echo form_open('tata_usaha/activate');?>
                                                                <input type="hidden" name="id_tu" value="<?php echo $tu['ID'];?>" required>
                                                                <button onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali petugas tata usaha ini?')" class="btn btn-success btn-sm" type="submit">Aktifkan</button>
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
                                                    echo "<tr><td colspan='6'>Belum ada data petugas tata usaha yang terdaftar</td></tr>";
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