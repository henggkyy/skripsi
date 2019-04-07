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
                if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 4){
                    ?>
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
                    <?php
                }
                ?>
                
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
                <?php
                if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
                    ?>
                <li <?php if(isset($admin_dosen) || isset($admin_lab) || isset($tata_usaha)){ echo 'class='. '"active"';}?>>
                    <a href="#"><i class="fas fa-group"></i> <span class="nav-label">Administrasi User </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <?php
                            if($this->session->userdata('id_role') == 1){
                                ?>
                            <li <?php if(isset($admin_dosen)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>dosen">Administrasi Dosen</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php
                            if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
                                ?>
                            <li <?php if(isset($admin_lab)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>admin_lab">Administrasi Admin Laboratorium</a>
                            </li>
                                <?php
                            }
                            ?>
                            <?php
                            if($this->session->userdata('id_role') == 1){
                                ?>
                            <li <?php if(isset($tata_usaha)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>tata_usaha">Administrasi Tata Usaha</a>
                            </li>
                                <?php
                            }
                            ?>
                            
                        </ul>
                </li>
                    <?php
                }
                ?>
                
                <li <?php if(isset($periode_gaji) || isset($input_gaji) || isset($laporan_gaji)){ echo 'class='. '"active"';}?>>
                    <a href="#"><i class="fas fa-user-clock"></i> <span class="nav-label">Laporan Gaji/Absensi Admin </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li <?php if(isset($periode_gaji)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>laporan_gaji/periode">Set Periode Gaji & Konfigurasi</a>
                            </li>
                            <li <?php if(isset($input_gaji)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>laporan_gaji/input">Input Gaji/Absensi Admin</a>
                            </li>
                            <li <?php if(isset($laporan_gaji)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>laporan_gaji/report">Laporan Gaji/Absensi Admin</a>
                            </li>
                        </ul>
                </li>
                <li <?php if(isset($alat_lab) || isset($peminjaman_lab) || isset($peminjaman_alat) || isset($form_peminjaman)){ echo 'class='. '"active"';}?>>
                    <a href="#"><i class="fas fa-building"></i> <span class="nav-label">Peminjaman Lab & Alat </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <?php
                            if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 4){
                                ?>
                            <li <?php if(isset($alat_lab)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>alat_lab">Daftar Alat</a>
                            </li>
                            <?php
                            }
                            ?>
                            <?php
                            if($this->session->userdata('id_role') == 1){
                                ?>
                            <li <?php if(isset($peminjaman_lab)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>peminjaman_lab">Daftar Peminjaman Laboratorium</a>
                            </li>
                            <?php
                            }
                            ?>
                            <?php
                            if($this->session->userdata('id_role') == 1){
                                ?>
                            <li <?php if(isset($peminjaman_alat)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>peminjaman_alat">Daftar Peminjaman Alat</a>
                            </li>
                                <?php
                            }
                            ?>
                            <li <?php if(isset($form_peminjaman)){ echo 'class='. '"active"';}?>>
                                <a href="<?php echo base_url();?>peminjaman/form">Form Peminjaman</a>
                            </li>
                        </ul>
                </li>
                <li <?php if(isset($jadwal_lab)){ echo 'class='. '"active"';}?>>
                    <a href="<?php echo base_url();?>jadwal_lab"><i class="fas fa-clock"></i> <span class="nav-label">Jadwal Laboratorium </span></a>
                </li>        
            </div>
    </nav>