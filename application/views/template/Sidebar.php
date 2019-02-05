<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <div align="center">
                                <img alt="image" style="width: 50px; height: 50px;" class="img-circle" src="<?php echo base_url()?>assets/img/unpar.png" />
                                <h4 style="color: white;">Administrasi Kegiatan Akademik Lab. Komputasi TIF UNPAR</h4>
                            </div>
                            </span>
                    </div>
                    <div class="logo-element">
                        UNPAR
                    </div>
                </li>
                <li <?php if(isset($dashboard)){ echo 'class='. '"active"';}?>>
                    <a href="<?php echo base_url();?>dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <?php
                if($this->session->userdata('id_role') == 1){
                ?>
                <li <?php if(isset($periode_akademik)){ echo 'class='. '"active"';}?>>
                    <a href="<?php echo base_url();?>periode_akademik"><i class="fa fa-institution"></i> <span class="nav-label">Periode Akademik</span></a>
                </li>
                <?php  
                }
                ?>

        </div>
    </nav>