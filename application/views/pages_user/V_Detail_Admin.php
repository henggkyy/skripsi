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
                                    <h5>Detail Admin Laboratorium</h5>
                                </div>
                                <div class="ibox-content">
                                    <h3 align="center"><?php echo $nama_admin;?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Informasi Admin</h5>
                                </div>
                                <div class="ibox-content">
                                    <ul class="unstyled">
                                            <li>
                                                    <ul>
                                                        <?php
                                                        if(isset($data_admin) && $data_admin){
                                                            foreach ($data_admin as $admin) {
                                                                ?>
                                                                <li><span style="font-weight: bold;">Nama : </span><?php echo $admin['NAMA'];?></li>
                                                                <li><span style="font-weight: bold;">Email : </span><?php echo $admin['EMAIL'];?></li>
                                                                <li><span style="font-weight: bold;">NIK : </span><?php echo $admin['NIK'];?></li>
                                                                <li><span style="font-weight: bold;">Angkatan : </span><?php echo $admin['ANGKATAN'];?></li>
                                                                <li><span style="font-weight: bold;">Periode Kontrak : </span><?php echo $admin['AWAL_KONTRAK'].' - '. $admin['AKHIR_KONTRAK'];?></li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                </div>
                            </div>
                        </div>  
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                 <div class="ibox-title">
                                    <h5>Edit Data Admin</h5>
                                </div>
                                <div class="ibox-content">
                                    <button class="btn btn-md btn-primary">Edit Data Admin</button>
                                    <button class="btn btn-md btn-success">Add Jadwal Bertugas</button>
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
