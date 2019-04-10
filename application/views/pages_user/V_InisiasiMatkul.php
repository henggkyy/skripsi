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
                                    <h5>Administrasi Mata Kuliah</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if($periode_aktif){
                                        if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
                                        ?>
                                    <button type="button" data-toggle="modal" data-target="#modalAddMatkul" class="btn btn-w-m btn-success"><i class="fas fa-plus"></i> Tambah Mata Kuliah</button>
                                    <!--Modal Add Matkul-->
                                    <div class="modal inmodal" id="modalAddMatkul" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Tambah Mata Kuliah</h4>
                                                </div>
                                                <?php echo form_open('/administrasi_matkul/tambah'); ?>
                                                <div class="modal-body">
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Kode Mata Kuliah <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" required name="kode_matkul" placeholder="Contoh : AIF - 183012" class="form-control">
                                                            <?php
                                                                if(isset($error_form) && $error_form){
                                                                        ?>
                                                                    <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                        <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Nama Mata Kuliah <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" required name="nama_matkul" placeholder="Contoh : Algoritma Data" class="form-control">
                                                            <?php
                                                                if(isset($error_form) && $error_form){
                                                                        ?>
                                                                    <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                        <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Dosen Koordinator <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="dosen_koor" required>
                                                                <option selected disabled value="">-- Please Select One --</option>
                                                                <?php
                                                                if(isset($data_dosen) && $data_dosen){
                                                                    foreach ($data_dosen as $dosen) {
                                                                        ?>
                                                                        <option value="<?php echo $dosen['ID'];?>"><?php echo $dosen['NAMA'];?> (<?php echo $dosen['NIK'];?>)</option>
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
                                                    <button type="submit" class="btn btn-primary">Tambah Mata Kuliah</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END MODAL ADD Matkul-->
                                        <?php
                                    }
                                    if($this->session->userdata('id_role') == 4){
                                        ?>
                                    <a href="<?php echo base_url();?>download/checker" class="btn btn-w-m btn-warning"><i class="fas fa-check"></i> Cek Kebutuhan Perangkat Lunak Mata Kuliah</a>
                                        <?php
                                    }
                                    }
                                    ?>
                                    <hr>
                                    <label class="col-sm-4 col-form-label">Periode Akademik:</label>
                                    <div class="col-sm-8 ">
                                        <form method="GET" action="<?php echo base_url()."administrasi_matkul";?>">
                                            
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
                                    <br>
                                    <hr>
                                    <h3>Daftar Mata Kuliah</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Mata Kuliah</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Dosen Koordinator</th>
                                            <th>Periode Akademik</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(isset($matkul) && $matkul){
                                            $iterator = 1;
                                            foreach ($matkul as $mtk) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $iterator;?></td>
                                                    <td><?php echo $mtk['KD_MATKUL'];?></td>
                                                    <td><?php echo $mtk['NAMA_MATKUL'];?></td>
                                                    <td><?php echo $mtk['NAMA_DOSEN'];?></td>
                                                    <td><?php echo $mtk['NAMA_PERIODE'];?></td>
                                                    <td><a href="<?php echo base_url().'administrasi_matkul_detail?id='.$mtk['ID'];?>" class="btn btn-primary btn-sm"><i class="fas fa-info"></i> Detail</button></a>
                                                </tr>
                                                <?php
                                                $iterator++;
                                            }
                                        }   
                                        else{
                                            echo "<tr><td colspan='6'>Belum ada mata kuliah</td></tr>";
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