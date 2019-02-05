            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Informasi Periode Akademik</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    Periode Akademik Aktif
                                                </div>
                                                <?php
                                                if($info_periode){
                                                    foreach ($info_periode as $info) {
                                                        ?>
                                                        <div class="panel-body">
                                                            <h4><?php echo $info['NAMA'];?></h4>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <?php echo form_open('/periode_akademik/nonaktif');?>
                                                            <input hidden type="text" required name="id_periode" value="<?php echo $info['ID'];?>">
                                                            <button type="submit" class="btn btn-w-m btn-danger">Nonaktifkan Periode</button>
                                                            </form>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                else{
                                                    ?>
                                                    <div class="panel-body">
                                                        <p>Belum ada Periode Aktif</p>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    Set Periode Akademik
                                                </div>
                                                <?php
                                                if($info_periode){
                                                    ?>
                                                    <div class="panel-body">
                                                        <p style="color: red;">Tidak dapat set periode. Masih ada periode akademik aktif!</p>
                                                    </div>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <?php echo form_open('/periode_akademik/aktifasi'); ?>
                                                    <div class="panel-body">
                                                            <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                                <label class="col-sm-2 col-form-label">Nama Periode Akademik :</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" required name="nama_periode" placeholder="Contoh : Semester Genap 2018/2019" class="form-control">
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
                                                        <button type="submit" class="btn btn-w-m btn-success">Aktifkan Periode</button>
                                                            
                                                    </div>
                                                    </form>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                  
                    </div>
                </div>
            </div>
