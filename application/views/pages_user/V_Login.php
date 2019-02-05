<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrasi Kegiatan Akademik Lab. Komputasi TIF UNPAR</title>

    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6" align="center">
                <img style="width: 150px; height: 150px;" src="<?php echo base_url();?>assets/img/unpar.png">
                <h2 class="font-bold">Administrasi Kegiatan Akademik</h2>
                <h3 class="font-bold">Lab. Komputasi TIF UNPAR</h3>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <?php 
                    $attributes = array('class' => 'm-t', 'role' => 'form');
                    echo form_open('/proses_login', $attributes);?>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Username" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required="">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                    </form>
                    <?php
                    if($this->session->flashdata('error')){
                        ?>
                        <h4 align="center" style="color: red"><?php echo $this->session->flashdata('error'); ?></h4>
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
