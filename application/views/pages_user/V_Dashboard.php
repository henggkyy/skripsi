            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h2>Status Anda : <?php echo $this->session->userdata('nama_role'); ?></h2>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
