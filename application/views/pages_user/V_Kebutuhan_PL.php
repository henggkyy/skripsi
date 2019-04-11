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
                                    <h5>Periksa Kebutuhan Perangkat Lunak Mata Kuliah</h5>
                                </div>
                                <div class="ibox-content">
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                            if(isset($list_matkul) && $list_matkul){ echo 'mainDataTable';}?>">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Mata Kuliah</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
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
                                                                <button class="btn btn-sm btn-success" onclick="periksaSoftware(<?php echo $matkul['ID'];?>);"><i class="fas fa-check"></i> Periksa</button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo '<tr><td colspan="3">Tidak ada mata kuliah yang aktif pada periode akademik!</td></tr>';
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
            <div class="modal inmodal" id="modal_checker" tabindex="-1" role="dialog"  aria-hidden="true">
                                
            </div>
