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
                                    <h5>Daftar Alat Laboratorium</h5>
                                </div>
                                <div class="ibox-content">
                                    <button type="button" data-toggle="modal" data-target="#modalAddAlat" class="btn btn-w-m btn-success"><i class="fas fa-plus"></i> Tambah Alat Laboratorium</button>
                                    <!--Modal Add ALAT-->
                                    <div class="modal inmodal" id="modalAddAlat" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Tambah Alat Laboratorium</h4>
                                                </div>
                                                <?php echo form_open('alat_lab/add');?>
                                                <div class="modal-body">
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Nama Alat <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="nama" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <p style="color: red;" align="center">* Wajib Diisi</p>
                                                </div>
                                                <div class="modal-footer">
                                                    
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Tambah Alat</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END MODAL ADD ALAT-->
                                    <hr>
                                    <h3>Data Alat Laboratorium</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                                if(isset($data_alat) && $data_alat){ echo 'mainDataTable';}?>">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Alat</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($data_alat) && $data_alat){
                                                    $iterator = 1;
                                                    foreach ($data_alat as $alat) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $alat['NAMA_ALAT'];?></td>
                                                        <td align="center">
                                                            <?php echo form_open('alat_lab/delete');?>
                                                            <input type="hidden" name="id_alat" value="<?php echo $alat['ID'];?>" required>
                                                            <button onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini?')" class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php  
                                                    $iterator++;  
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='6'>Belum ada alat lab yang terdaftar</td></tr>";
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