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
    <link href="<?php echo base_url();?>assets/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fontawesome_new/css/all.css">
</head>

<body class="gray-bg">
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <img style="width: 60px; height: 60px; display: inline;" src="<?php echo base_url();?>assets/img/unpar.png">
                <h3 class="font-bold">SI Kegiatan Operasional</h3>
                <h4 class="font-bold">Lab. Komputasi TIF UNPAR</h4>
                <div class="ibox-content">
                    <h4>Form Peminjaman Alat/ Ruangan Laboratorium</h4>

                    <hr>
                    <?php
                    $attributes = array('id' => 'form_peminjaman');
                    echo form_open('peminjaman/add', $attributes);?>
                    <?php $this->load->view('template/Notification');?>
                    <h5>Nama : <?php echo $this->session->userdata('name'); ?></h5>
                    <h5>Email : <?php echo $this->session->userdata('email'); ?>.  <a href="<?php echo base_url()?>logout">Logout</a></h5>
                    <hr>
                    <div class="form-group row">
                       
                            <div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <span style="font-weight: bold;">Peminjaman ruangan laboratorium dapat dilakukan minimal 1 minggu sebelum ruangan laboratorium akan digunakan. Untuk alat-alat, dapat dilakukan minimal 3 hari sebelum alat akan digunakan.</span>
                            </div>
                        <label class="col-sm-4 col-form-label">Pilih Tipe Peminjaman <span style="color: red">*</span> :</label>
                        <div class="col-sm-6">
                            <select id="choice" name="choice" required class="form-control"> 
                                <option selected disabled value="">-- Please Select One --</option>
                                <option value="lab">Ruangan Laboratorium</option>
                                <option value="alat">Alat Laboratorium</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Acara/Keperluan <span style="color: red">*</span> :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Contoh : Tutorial Power Point" required name="keperluan">
                        </div>
                    </div>
                    <div class="form-group row " id="data_1">
                        <label class="col-sm-4 col-form-label">Tanggal Pinjam <span style="color: red">*</span> :</label>
                        <div class="col-sm-6 input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tgl_pinjam" name="tgl_pinjam" class="form-control" placeholder="mm/dd/yyyy" data-mask="99/99/9999" onchange="checkLab();" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label id="label_jam_mulai" class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
                        <div class="col-sm-6 input-group clockpicker" data-autoclose="true">
                            <input type="text" id="jam_awal" name="jam_mulai" class="form-control" placeholder="09:30" data-mask="99:99" onchange="checkLab();" required>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label id="label_jam_selesai" class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
                        <div class="col-sm-6 input-group clockpicker" data-autoclose="true">
                            <input type="text" id="jam_berakhir" name="jam_selesai" class="form-control" placeholder="09:30" data-mask="99:99" onchange="checkLab();" required>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row" style="display: none;" id="div_lab">
                        <label class="col-sm-4 col-form-label">Pilih Ruangan Laboratorium <span style="color: red">*</span> :</label>
                        <div class="col-sm-6" >
                            <div id="select_lab">
                                <span style="color: red;">Silahkan isi tanggal, jam mulai, dan jam selesai peminjaman terlebih dahulu</span>
                            </div>
                            
                        </div>

                    </div>
                    <div class="form-group row" style="display: none;" id="div_alat">
                        <label class="col-sm-4 col-form-label">Pilih Alat <span style="color: red">*</span> :</label>
                        <div class="col-sm-6">
                            <select id="choice_alat" name="alat" required class="form-control"> 
                                <option selected disabled value="">-- Please Select One --</option>
                                <?php
                                if(isset($daftar_alat) && $daftar_alat){
                                    foreach ($daftar_alat as $alat) {
                                        ?>
                                        <option value="<?php echo $alat['ID'];?>"><?php echo $alat['NAMA_ALAT'];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan <span style="color: red">*</span> :</label>
                        <div class="col-sm-6">
                            <textarea style="height: 80px;" placeholder="Dapat diisi dengan keperluan peminjaman lab, kebutuhan, dsb." name="keterangan" class="form-control" required></textarea>
                        </div>
                    </div>
                    <p id="notif" style="color: red;" align="center"></p>
                    <p style="color: red;" align="center">* Wajib Diisi</p>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <a href="<?php echo base_url();?>logout" class="btn btn-primary btn-lg"><i class="fas fa-arrow-left"></i> Back</a>
                            <button class="btn btn-primary btn-lg" type="submit" id="button_submit">Ajukan Peminjaman</button>
                        </div>
                    </div>
                    </form>
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
<script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/clockpicker/clockpicker.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
    $('#form_peminjaman').submit(function(){
        $('#button_submit').prop('disabled', true);
        $("#notif").html(loader);
    });
    function checkLab(){
        
        var date_today = new Date();
        var tanggal_data = $("#tgl_pinjam").val();
        var jam_mulai_data = $("#jam_awal").val();
        var jam_selesai_data = $("#jam_berakhir").val();
        if($("#choice").val() == 'lab'){
            $("#select_lab").html(loader);
            var date_input = new Date(tanggal_data);
            date_next_week = date_today.setDate(date_today.getDate()+6);
            if(date_input < date_next_week){
                $('#notif').html('Tanggal peminjaman minimal harus H+7 dari tanggal hari ini!');
                $('#button_submit').prop('disabled', true);
                return;
            }
            else{
                $('#notif').html('');
                $('#button_submit').prop('disabled', false);
            }
            if(tanggal_data == "" || jam_mulai_data == "" || jam_selesai_data == ""){
                if(tanggal_data == ""){
                    $("#select_lab").html('<span style="color:red;">Tanggal peminjaman harus diisi terlebih dahulu!</span>');
                }
                else if(jam_mulai_data == ""){
                    $("#select_lab").html('<span style="color:red;">Jam mulai peminjaman harus diisi terlebih dahulu!</span>');
                }
                else{
                    $("#select_lab").html('<span style="color:red;">Jam selesai peminjaman harus diisi terlebih dahulu!</span>');
                }
                    
                return;
            }   
            if(jam_selesai_data < jam_mulai_data){
                $("#select_lab").html('<span style="color:red;">Jam mulai tidak boleh melebihi jam selesai!</span>');
                return;
            }
                
            $.ajax({
                    //Ganti URL nanti kl udah dipindah server
                url: "<?php echo base_url();?>" + "ketersediaan_lab",
                method: "GET",
                data: {tanggal : tanggal_data, jam_mulai : jam_mulai_data, jam_selesai : jam_selesai_data},
                success: function(data) { 
                     $("#select_lab").html(data);
                    $('#button_submit').prop('disabled', false);
                }
            }); 
        }
        else{
            if(jam_selesai_data < jam_mulai_data){
                $("#notif").html('<span style="color:red;">Jam mulai tidak boleh melebihi jam selesai!</span>');
                $('#button_submit').prop('disabled', true);
                return;
            }
            var date_input = new Date(tanggal_data);
            date_next_week = date_today.setDate(date_today.getDate()+2);
            if(date_input < date_next_week){
                $('#notif').html('Tanggal peminjaman minimal harus H+3 dari tanggal hari ini!');
                $('#button_submit').prop('disabled', true);
            }
            else{
                $('#notif').html('');
                $('#button_submit').prop('disabled', false);
            }
        }
    }
    $("#choice").change(function(e){
        if($("#choice").val() == 'lab'){
            $('#button_submit').prop('disabled', true);
            $("#div_alat").hide();
            $("#choice_alat").prop('required',false);
            $("#div_lab").show();
            $("#choice_lab").prop('required',true);
            checkLab();
        }
        else{
            $("#div_alat").show();
            $("#choice_alat").prop('required',true);
            $("#div_lab").hide();
            $("#choice_lab").prop('required',false);
            $('#button_submit').prop('disabled', false);
            checkLab();
        }
    });
    var mem = $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    $('.clockpicker').clockpicker();
</script>
</body>



</html>