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
    <script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body class="gray-bg">
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <img style="width: 60px; height: 60px; display: inline;" src="<?php echo base_url();?>assets/img/unpar.png">
                <h3 class="font-bold">Administrasi Kegiatan Akademik</h3>
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
                    <div id="calendar">
                        
                    </div>
                    <div>
                        <br>
                        <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"> < Back</a>
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
        <div class="modal inmodal" id="modal_event" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn"> 
                                        <div class="modal-body">
                                            <h2 id="judul_event" align="center"></h2>
                                            <hr>
                                            <h3>Nama Event : <span style="font-weight: normal;" id="event"></span></h3>
                                            <h3>Waktu Mulai : <span style="font-weight: normal;" id="start"></span></h3>
                                            <h3>Waktu Selesai : <span style="font-weight: normal;" id="end"></span></h3>
                                            <?php
                                            if($type == 'lab'){
                                                ?>
                                            <h3>Lokasi : <span style="font-weight: normal;" id="lokasi_event"></span></h3>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </div>
<script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/clockpicker/clockpicker.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/fullcalendar/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript">
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: <?php echo $jadwal;?>,
        eventClick: function(event, jsEvent, view) {
            $('#modal_event').modal('show');
            $('#judul_event').text(event.title);
            $('#event').text(event.title);
            $('#start').text(event.start);
            $('#end').text(event.end);
            <?php
            if($type == 'lab'){ ?>
             $('#lokasi_event').text(event.nama_lab);
                <?php
            }
            ?>
           
        }
    });
</script>
</body>



</html>