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
                                                            <div class="form-group  row">
                                                                <label class="col-sm-2 col-form-label">Nama Periode Akademik <span style="color: red">*</span> :</label>
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
                                                            <div class="form-group row" id="range_periode">
                                                                <label class="col-sm-2 col-form-label">Tanggal Periode Akademik <span style="color: red">*</span> :</label>
                                                                <div class="input-daterange input-group col-sm-6" id="datepicker">
                                                                    <input type="text" class="form-control-sm form-control" id="start_periode" name="start_periode" placeholder="mm/dd/yyyy" data-mask="99/99/9999" required/>
                                                                    <span class="input-group-addon">s/d</span>
                                                                    <input type="text" class="form-control-sm form-control" id="end_periode" name="end_periode" placeholder="mm/dd/yyyy" data-mask="99/99/9999"  required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row" id="range_periode">
                                                                <label class="col-sm-2 col-form-label">Periode UTS <span style="color: red">*</span> :</label>
                                                                <div class="input-daterange input-group col-sm-6" id="datepicker">
                                                                    <input type="text" id="start_uts" class="form-control-sm form-control" name="start_uts" placeholder="mm/dd/yyyy" data-mask="99/99/9999" required/>
                                                                    <span class="input-group-addon">s/d</span>
                                                                    <input type="text" id="end_uts" class="form-control-sm form-control" name="end_uts" placeholder="mm/dd/yyyy" data-mask="99/99/9999" required />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row" id="range_periode">
                                                                <label class="col-sm-2 col-form-label">Periode UAS <span style="color: red">*</span> :</label>
                                                                <div class="input-daterange input-group col-sm-6" id="datepicker">
                                                                    <input type="text" id="start_uas" class="form-control-sm form-control" name="start_uas" placeholder="mm/dd/yyyy" data-mask="99/99/9999" required/>
                                                                    <span class="input-group-addon">s/d</span>
                                                                    <input type="text" id="end_uas" class="form-control-sm form-control" name="end_uas" placeholder="mm/dd/yyyy" data-mask="99/99/9999" required />
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <p style="color: red;">* Required Field</p>
                                                        <p id="error" style="font-weight: bold; color: red;"></p>
                                                        <button id="submit_btn" type="submit" class="btn btn-w-m btn-success">Aktifkan Periode</button>
                                                            
                                                    </div>
                                                    </form>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <h3>Histori Periode Akademik</h3>
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover <?php
                                                        if(isset($data_periode) && $data_periode){ echo 'mainDataTable';}?>">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nama Periode</th>
                                                            <th>Periode Akademik</th>
                                                            <th>Periode UTS</th>
                                                            <th>Periode UAS</th>
                                                            <th>Status</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if(isset($data_periode) && $data_periode){
                                                                $iterator = 1;
                                                                foreach ($data_periode as $per) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $iterator;?></td>
                                                                        <td><?php echo $per['NAMA'];?></td>
                                                                        <td><?php echo $per['START_PERIODE'].' s/d '.$per['END_PERIODE'];?></td>
                                                                        <td><?php echo $per['START_UTS'].' s/d '.$per['END_UTS'];?></td>
                                                                        <td><?php echo $per['START_UAS'].' s/d '.$per['END_UAS'];?></td>
                                                                        <td><?php if($per['STATUS'] == 1) {
                                                                                echo "Sedang Berlangsung";
                                                                            }
                                                                            else{
                                                                                echo "Selesai";
                                                                            }?></td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                    $iterator++;
                                                                }
                                                            }
                                                            else{
                                                                echo "<tr><td colspan='6'>Belum ada dokumen Periode Akademik</td></tr>";
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
                </div>
            </div>
