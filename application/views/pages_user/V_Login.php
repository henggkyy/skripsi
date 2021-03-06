<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SI Kegiatan Operasional Lab. Komputasi TIF UNPAR</title>

    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6" align="center">
                <img style="width: 150px; height: 150px;" src="<?php echo base_url();?>assets/img/unpar.png">
                <h2 class="font-bold">SI Kegiatan Operasional</h2>
                <h3 class="font-bold">Lab. Komputasi TIF UNPAR</h3>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                        
                        <a href="<?php echo $google_login_url;?>" class="btn btn-lg btn-danger block full-width m-b"><i class="fab fa-google"></i> Login With Google</a>
                    <hr>
                    <div align="center">
                        <a class="btn btn-primary" href="<?php echo $google_login_url;?>"><i class="fas fa-building"></i> Peminjaman Lab & Alat</a>
                        <a style="margin-top:5px;" class="btn btn-warning" href="<?php echo base_url();?>dokumen"><i class="fas fa-file"></i> Dokumen SOP & Buku Saku</a>
                        <a style="margin-top:5px;" class="btn btn-success" href="<?php echo base_url();?>jadwal"><i class="far fa-clock"></i> Jadwal Laboratorium & Jadwal Admin</a>
                    </div>
                    <?php
                    if($this->session->flashdata('message')){
                        ?>
                        <div align="center" style="margin-top:10px;">
                            <p style="color: red; font-weight: bold;"><?php echo $this->session->flashdata('message');?></p>
                        </div>
                        <?php
                    }
                    ?>
                    
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6" align="center">
                Copyright © 2019. Hengky Surya (2015730051)
            </div>
        </div>
    </div>

</body>

</html>
