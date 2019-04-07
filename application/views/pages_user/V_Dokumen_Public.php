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
                    <h3>Dokumen Laboratorium Komputasi TIF UNPAR</h3>
                    <hr>
                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                        <label class="col-sm-4 col-form-label">Jenis Dokumen :</label>
                        <div class="col-sm-8">
                            <select id="jenis_dokumen" onchange="getDokumen()" required class="form-control">
                                <option value="sop">Dokumen Standard Operational Procedure (SOP)</option>
                                <option value="buku_saku">Dokumen Buku Saku</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive" id="template_dokumen">
                        <table class="table table-striped table-bordered table-hover <?php if(isset($daftar_file) && $daftar_file){ echo 'mainDataTable';}?>">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Dokumen SOP</th>
                                    <th>Kategori</th>
                                    <th>Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($daftar_file) && $daftar_file){
                                    $iterator = 1;
                                    foreach ($daftar_file as $file) {
                                        ?>
                                    <tr>
                                        <td><?php echo $iterator;?></td>
                                        <td><a target="_blank" href="<?php echo base_url();?>uploads/sop/<?php echo $file['path'];?>"><?php echo $file['judul'];?></a></td>
                                        <td><?php echo $file['nama_kategori'];?></td>
                                        <td><?php echo $file['LAST_UPDATE']." (".$file['USER'].")"; ?></td>
                                    </tr>
                                        <?php
                                        $iterator++;
                                    }  
                                }
                                else{
                                    ?>
                                    <tr>
                                        <td colspan="4">Belum ada dokumen SOP!</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <br>
                        <a href="<?php echo base_url();?>" class="btn btn-white btn-lg"> < Back</a>
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
<script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/clockpicker/clockpicker.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.mainDataTable').DataTable({
            pageLength: 25,
            responsive: true
        });
    });
    function getDokumen(){   
        var jenis_dokumen = $('#jenis_dokumen').val();
        $.ajax({
            url: "<?php echo base_url();?>" + "get_dokumen",
            method: "GET",
            data: {jenis_dokumen : jenis_dokumen},
            success: function(data) { 
                $("#template_dokumen").html(data);
                $('.mainDataTable').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        }); 
    }
</script>
</body>



</html>