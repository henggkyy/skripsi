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
                        <?php
                        if($periode_aktif){
                            ?>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Daftar Mata Kuliah</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Mata Kuliah</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Tanggal UTS</th>
                                            <th>Tanggal UAS</th>
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
                                                    <td><?php echo $mtk['TANGGAL_UTS'];?></td>
                                                    <td><?php echo $mtk['TANGGAL_UAS'];?></td>
                                                </tr>
                                                <?php
                                                $iterator++;
                                            }
                                        }   
                                        else{
                                            echo "<tr><td colspan='5'>Belum ada mata kuliah</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>      
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Tambah Mata Kuliah</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                           <div class="panel panel-success">
                                                <div class="panel-heading ">
                                                    <p>Tambah Mata Kuliah</p>
                                                </div>
                                                <?php echo form_open('/inisiasi_administrasi_matkul/tambah'); ?>
                                                <div class="panel-body">
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-2 col-form-label">Kode Mata Kuliah :</label>
                                                        <div class="col-sm-10">
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
                                                        <label class="col-sm-2 col-form-label">Nama Mata Kuliah :</label>
                                                        <div class="col-sm-10">
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
                                                </div>
                                                <div class="panel-footer">
                                                    <button type="submit" class="btn btn-w-m btn-success">Add</button>     
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Set Jadwal UTS dan Jadwal UAS</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                           <div class="panel panel-info">
                                                <div class="panel-heading ">
                                                    <p>Set Jadwal UTS dan Jadwal UAS</p>
                                                </div>
                                                <?php echo form_open('/inisiasi_administrasi_matkul/set_jadwal'); ?>
                                                <div class="panel-body">
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>" id="data_tgl">
                                                        <label class="col-sm-2 col-form-label">Pilih Mata Kuliah :</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if(isset($matkul) && $matkul){
                                                                ?>
                                                                <select name="nama_matkul" class="form-control" required>
                                                                    <option disabled selected>-- Please Select One --</option>
                                                                    <?php
                                                                    foreach ($matkul as $mtk) {
                                                                        ?>
                                                                        <option value="<?php echo $mtk['ID'];?>"><?php echo $mtk['KD_MATKUL'];?> : <?php echo $mtk['NAMA_MATKUL'];?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <?php
                                                            }
                                                            else{
                                                                echo 'Belum ada mata kuliah!';
                                                            }
                                                            ?>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>" id="data_1">
                                                        <label class="col-sm-2 col-form-label">Tanggal UTS :</label>
                                                        <div class="input-group date col-sm-10">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input name="tgl_uts" type="text" class="form-control" required>
                                                        </div>

                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>" id="data_1">
                                                        <label class="col-sm-2 col-form-label">Tanggal UAS :</label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input name="tgl_uas" type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <button type="submit" class="btn btn-w-m btn-success">Set Jadwal</button>     
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                            <?php
                        }
                        ?>
                                          
                    </div>
                </div>
            </div>