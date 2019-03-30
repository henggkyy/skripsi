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
                                    <h5>Periksa Kebutuhan Perangkat Lunak Mata Kuliah</h5>
                                </div>
                                <div class="ibox-content">
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                            if(isset($list_matkul) && $list_matkul){ echo 'mainDataTable';}?>">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th>Action</th>
                                            </tr>
                                            <tbody>
                                                <?php
                                                if(isset($list_matkul) && $list_matkul){
                                                    $iterator = 1;
                                                    foreach ($list_matkul as $matkul) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $iterator;?></td>
                                                            <td><?php echo $matkul['NAMA_MATKUL'];?></td>
                                                            <td>
                                                                <input type="hidden" id="id_matkul" value="<?php echo $matkul['ID']; ?>" name="id_matkul" required>
                                                                <button class="btn btn-sm btn-success" id="button_cek">Periksa</button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{

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