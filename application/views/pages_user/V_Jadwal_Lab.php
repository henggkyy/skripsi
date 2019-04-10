            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h2>Periode Aktif : 
                                        <?php
                                        if($periode_aktif){
                                            ?>
                                            <span><?php echo $periode_aktif;?></span>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <span style="color: red;"> <br>Belum ada periode semester aktif!</span>
                                            <?php
                                        }
                                        ?>
                                    </h2>
                                </div>
                            </div>
                        </div> 
                        <?php
                        if($this->session->userdata('id_role') == 1){
                            ?>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                     <h5>Add Jadwal Pemakaian Laboratorium</h5>
                                     <div class="ibox-tools">
                                        <a>
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content collapsed">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <i class="far fa-calendar-plus"></i> Add Jadwal Pemakaian Laboratorium
                                        </div>
                                        <?php echo form_open('jadwal_lab/add');?>
                                            <div class="panel-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Acara/Keperluan <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-8">
                                                        <input required type="text" placeholder="Contoh : Acara Presentasi Power Point PPK"  class="form-control" name="keperluan">
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="data_1">
                                                    <label class="col-sm-4 col-form-label">Tanggal Pemakaian <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-8 input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required type="text" placeholder="mm/dd/yyy" data-mask="99/99/9999" onchange="checkLab();" class="form-control" id="tgl_pemakaian" name="tgl_pemakaian">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Jam Mulai <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-8">
                                                        <input id="waktu_awal_2" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" onchange="checkLab();" name="jam_mulai">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Jam Selesai <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-8">
                                                        <input id="waktu_akhir_2" required type="text" placeholder="hh:mm" data-mask="99:99" class="form-control" onchange="checkLab();" name="jam_selesai">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Ruangan Laboratorium <span style="color: red">*</span> :</label>
                                                    <div class="col-sm-8" id="select_lab">
                                                        <span style="color: red;">Silahkan isi tanggal, jam mulai, dan jam selesai peminjaman terlebih dahulu</span>
                                                    </div>
                                                </div>
                                                <p align="center" style="color: red;">* Wajib Diisi</p>
                                                <p align="center" id="notif" style="color: red;"></p>
                                            </div>
                                            <div class="panel-footer">
                                                <button id="btn_submit" type="submit" class="btn btn-md btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                        
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins ">
                                <div class="ibox-title">
                                    <h5>Jadwal Pemakaian Laboratorium (CalendarView)</h5>
                                    
                                </div>
                                <div class="ibox-content ">
                                   <div id="calendar"></div>
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
                                            <h3>Lokasi : <span style="font-weight: normal;" id="lokasi_event"></span></h3>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <?php
                        if($this->session->userdata('id_role') == 1){?>
                            <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Jadwal Pemakaian Laboratorium (DataTables)</h5>
                                    <div class="ibox-tools">
                                        <a>
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content collapsed">
                                   <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php if(isset($pemakaian_lab) && $pemakaian_lab){ echo 'mainDataTable';}?>">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Lab</th>
                                                    <th>Acara/Keperluan</th>
                                                    <th>Waktu Pemakaian</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($pemakaian_lab) && $pemakaian_lab){
                                                    $iterator = 1;
                                                    foreach ($pemakaian_lab as $pemakaian) {
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><?php echo $pemakaian['nama_lab'];?></td>
                                                        <td><?php echo $pemakaian['title'];?></td>
                                                        <td><?php echo $pemakaian['start']. ' s/d '.$pemakaian['end'];?></td>
                                                        <td align="center">
                                                            <button onclick="getDataJadwal(<?php echo $pemakaian['id'];?>);" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i> Update</button>
                                                            <?php echo form_open('jadwal_lab/delete');?>
                                                            <input type="hidden" name="id_pemakaian" required value="<?php echo $pemakaian['id'];?>">
                                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='4'>Belum ada Jadwal Pemakaian Laboratorium yang akan datang</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                   </div>
                                </div>
                            </div>
                        </div>   
                        <?php
                        }
                        ?>    
                    </div>
                </div>
            </div>
            <!--START MODAL UPDATE LAPORAN GAJI-->
            <div class="modal inmodal" id="modalUpdateJadwalLab" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                       <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Update Jadwal Pemakaian Laboratorium</h4>
                        </div>
                        <div class="modal-body" id="modal-content">
                            <img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">
                        </div>
                    </div>
                </div>
            </div>
            <!--END MODAL UPDATE LAPORAN GAJI-->
            <script type="text/javascript">
                var loader = '<img style="display: block; margin:auto;" src="<?php echo base_url();?>assets/img/loader.gif">';
                function getDataJadwal(id){
                    $("#modal-content").html(loader);
                    $('#modalUpdateJadwalLab').modal('show');
                    $.ajax({
                        url: "<?php echo base_url();?>" + "jadwal_lab/get_data",
                        method: "GET",
                        data: {id_pemakaian : id},
                        success: function(data) { 
                            $("#modal-content").html(data);
                            $('#waktu_awal_modal').clockpicker({
                                autoclose: true
                            });
                            $('#waktu_akhir_modal').clockpicker({
                                autoclose: true
                            });
                            $('#tanggal_modal').datepicker({
                                todayBtn: "linked",
                                keyboardNavigation: false,
                                forceParse: false,
                                calendarWeeks: true,
                                autoclose: true
                            });
                        }
                    }); 
                }
                function checkLabModal(){
                    $("#select_lab_modal").html(loader);
                    var tanggal_data = $("#tanggal_modal").val();
                    var jam_mulai_data = $("#waktu_awal_modal").val();
                    var jam_selesai_data = $("#waktu_akhir_modal").val();
                    var date_today = new Date();
                    date_today = date_today.setDate(date_today.getDate()-1);
                    var date_input = new Date(tanggal_data);
                    if(date_input <= date_today){
                        $('#notif_modal').html('Tanggal pemakaian tidak boleh lebih kecil daripada tanggal hari ini!');
                        $('#button_modal').prop('disabled', true);
                    }
                    else{
                        $('#notif_modal').html('');
                        $('#button_modal').prop('disabled', false);
                    }
                    $('#button_modal').prop('disabled', true);
                    if(tanggal_data == "" || jam_mulai_data == "" || jam_selesai_data == ""){
                        if(tanggal_data == ""){
                            $("#select_lab_modal").html('<span style="color:red;">Tanggal peminjaman harus diisi terlebih dahulu!</span>');
                        }
                        else if(jam_mulai_data == ""){
                            $("#select_lab_modal").html('<span style="color:red;">Jam mulai peminjaman harus diisi terlebih dahulu!</span>');
                        }
                        else{
                            $("#select_lab_modal").html('<span style="color:red;">Jam selesai peminjaman harus diisi terlebih dahulu!</span>');
                        }
                                
                        return;
                    }   
                    if(jam_selesai_data < jam_mulai_data){
                        $("#select_lab_modal").html('<span style="color:red;">Jam mulai tidak boleh melebihi jam selesai!</span>');
                        return;
                    }    
                    $.ajax({
                                //Ganti URL nanti kl udah dipindah server
                        url: "<?php echo base_url('ketersediaan_lab'); ?>",
                        method: "GET",
                        data: {tanggal : tanggal_data, jam_mulai : jam_mulai_data, jam_selesai : jam_selesai_data},
                        success: function(data) { 
                            $("#select_lab_modal").html(data);
                            $('#button_modal').prop('disabled', false);
                        },
                        error: function() {
                            alert('error!');
                         }
                    }); 
                }
                function checkLab(){
                    $("#select_lab").html(loader);
                    var tanggal_data = $("#tgl_pemakaian").val();
                    var jam_mulai_data = $("#waktu_awal_2").val();
                    var jam_selesai_data = $("#waktu_akhir_2").val();
                    var date_today = new Date();
                    date_today = date_today.setDate(date_today.getDate()-1);
                    var date_input = new Date(tanggal_data);
                    if(date_input <= date_today){
                        $('#notif').html('Tanggal pemakaian tidak boleh lebih kecil daripada tanggal hari ini!');
                        $('#btn_submit').prop('disabled', true);
                    }
                    else{
                        $('#notif').html('');
                        $('#btn_submit').prop('disabled', false);
                    }
                    $('#btn_submit').prop('disabled', true);
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
                    console.log(tanggal_data);    
                    $.ajax({
                                //Ganti URL nanti kl udah dipindah server
                        url: "<?php echo base_url('ketersediaan_lab'); ?>",
                        method: "GET",
                        data: {tanggal : tanggal_data, jam_mulai : jam_mulai_data, jam_selesai : jam_selesai_data},
                        success: function(data) { 
                            $("#select_lab").html(data);
                            $('#btn_submit').prop('disabled', false);
                        },
                        error: function() {
                            alert('error!');
                         }
                    }); 
                }
            </script>
            
