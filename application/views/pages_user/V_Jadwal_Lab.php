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
                        
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Jadwal Pemakaian Laboratorium</h5>
                                </div>
                                <div class="ibox-content">
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
                    </div>
                </div>
            </div>
            
