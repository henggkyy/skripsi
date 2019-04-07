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
                        <div class="col-lg-12">
                            <div class="ibox-title">
                                <h3>Log User</h3>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama/Email</th>
                                                <th>Status</th>
                                                <th>Last Login</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($data_login) && $data_login){
                                                $iterator = 1;
                                                foreach ($data_login as $login) {
                                                ?>
                                            <tr>
                                                <td><?php echo $iterator;?></td>
                                                <td><?php echo $login['NAMA']."/".$login['EMAIL'];?></td>
                                                <td><?php echo $login['NAMA_ROLE'];?></td>
                                                <td><?php echo $login['LAST_LOGIN']."/".$login['LAST_IP'];?></td>
                                            </tr>
                                                <?php
                                                $iterator++;
                                                }
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
