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
                <li <?php if(isset($dokumen_sop) || isset($dokumen_saku)){ echo 'class='. '"active"';}?>>
                	<a href="#"><i class="fa fa-envelope-open"></i> <span class="nav-label">Dokumen </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li <?php if(isset($dokumen_sop)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>dokumen_sop">Standard Operational Procedure (SOP)</a>
                            </li>
                            <li <?php if(isset($dokumen_saku)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>dokumen_saku">Buku Saku</a>
                            </li>

                        </ul>
                </li>
                <li <?php if(isset($periode) || isset($matkul)){ echo 'class='. '"active"';}?>>
                    <a href="#"><i class="fas fa-book"></i> <span class="nav-label">Administrasi Perkuliahan </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li <?php if(isset($periode)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>periode_akademik">Periode Akademik</a>
                            </li>
                            <li <?php if(isset($matkul)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>administrasi_matkul">Mata Kuliah</a>
                            </li>

                        </ul>
                </li>
                <li <?php if(isset($admin_dosen) || isset($admin_lab) || isset($admin_tu)){ echo 'class='. '"active"';}?>>
                    <a href="#"><i class="fas fa-group"></i> <span class="nav-label">Administrasi User </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li <?php if(isset($admin_dosen)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>dosen">Administrasi Dosen</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>admin_lab">Administrasi Admin Laboratorium</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url();?>tata_usaha">Administrasi Tata Usaha</a>
                            </li>
                        </ul>
                </li>
        </div>
    </nav>