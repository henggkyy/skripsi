<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title?></title>

    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
   
    <link href="<?php echo base_url();?>assets/css/magnific-popup.css" rel="stylesheet"> 
    <link href="<?php echo base_url();?>assets/css/timetable.css" rel="stylesheet"> 
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.js"></script>
    <script src="<?php echo base_url();?>assets/js/timetable.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fontawesome_new/css/all.css">
</head>

<body class="gray-bg">
	 <div class="wrapper wrapper-content animated fadeIn">
        <div class="p-w-md m-t-sm">
		    <div class="ibox-content">
		        <div class="row">
		            <div class="col-md-12">
		                <img style="width: 60px; height: 60px; display: inline;" src="<?php echo base_url();?>assets/img/unpar.png">
		                <h3 class="font-bold">SI Kegiatan Operasional</h3>
		                <h4 class="font-bold">Lab. Komputasi TIF UNPAR</h4>
		                <div class="ibox-content">
		                    <h3>Jadwal Pemakaian Laboratorium & Jadwal Bertugas Admin</h3>
		                    <hr>
		                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
		                        <label class="col-sm-4 col-form-label">Pilihan Jadwal :</label>
		                        <div class="col-sm-8">
		                            <form method="GET" action="<?php echo base_url()."jadwal";?>">
		                                <select name="type" onchange="this.form.submit()" required class="form-control">
		                                    <option value="lab" <?php if($type == 'lab'){ echo 'selected';}?>>Jadwal Pemakaian Laboratorium</option>
		                                    <option value="admin" <?php if($type == 'admin'){ echo 'selected';}?>>Jadwal Bertugas Admin</option>
		                                </select>
		                            </form>
		                        </div>
		                    </div>
		                    <hr>
		                    <?php
		                    if($type == 'admin'){
		                        ?>
		                    <div class="tiva-timetable" data-url="<?php echo base_url();?>" data-source="all_admin" data-view="week">   
		                    </div>
		                        <?php
		                    }
		                    else{
		                        ?>
		                    <div class="tiva-timetable" data-url="<?php echo base_url();?>" data-source="all_ruangan" data-view="month">   
		                    </div>  
		                        <?php
		                    }
		                    ?>
		                    
		                    <div>
		                        <br>
		                        <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"><i class="fas fa-arrow-left"></i> Back</a>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <hr/>
		        <div class="row">
		            <div class="col-md-12" align="center">
		                Copyright © 2019. Hengky Surya (2015730051)
		            </div>
		        </div>
		    </div>
		</div>
	</div>

<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/clockpicker/clockpicker.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/fullcalendar/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>

</body>
</html>