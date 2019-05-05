<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/timetable.css">
</head>
<body>
	<div class="tiva-timetable" tipe-bertugas="1" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="week" data-mode="day" data-header-time="hide">
	<hr>
	<div class="tiva-timetable" tipe-bertugas="2" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="week">
	</div>
	<hr>
	<div class="tiva-timetable" tipe-bertugas="3" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="month">
    </div>
    <hr>
     <script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.magnific-popup.js"></script>
	<script src="<?php echo base_url();?>assets/js/timetable.js"></script>
</body>
</html>