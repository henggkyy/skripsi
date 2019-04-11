<div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-lg welcome-message"><span style="font-weight: bold;">You're logged in as :</span> <?php echo $this->session->userdata('nama');?> (<?php echo $this->session->userdata('email');?>) - <span style="text-decoration: underline;"><?php echo $this->session->userdata('nama_role'); ?></span></span>
                </li>
                <?php
                $count = 0;
                if(isset($count_lab) && $count_lab){
                    $count++;
                }
                if(isset($count_alat) && $count_alat){
                    $count++;
                }
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary"><?php echo $count;?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <?php
                        if($count){
                            ?>
                            <?php if(isset($count_lab) && $count_lab){?>
                        <li>
                            <a href="<?php echo base_url();?>peminjaman_lab" class="dropdown-item">
                                <div>
                                    <i class="fas fa-exclamation-circle fa-fw"></i> <?php echo $count_lab;?> Permintaan peminjaman lab
                                </div>
                            </a>
                        </li>   
                            <?php } ?>
                            <?php if(isset($count_alat) && $count_alat){?>
                        <li>
                            <a href="<?php echo base_url();?>peminjaman_alat" class="dropdown-item">
                                <div>
                                    <i class="fas fa-exclamation-circle fa-fw"></i> <?php echo $count_alat;?> Permintaan peminjaman alat
                                </div>
                            </a>
                        </li>   
                            <?php } ?>
                            <?php
                        }
                        ?>
                        
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url();?>logout">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
        
        
