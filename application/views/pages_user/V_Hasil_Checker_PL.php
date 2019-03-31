                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Hasil Pemeriksaan Perangkat Lunak</h4>
                                            <h3><?php echo $nama_matkul; ?></h3>
                                        </div>
                                        <div class="modal-body">
                                            <?php 
                                            if(isset($hasil_checker) && $hasil_checker){
                                                foreach ($hasil_checker as $checker) {
                                                    ?>
                                                        <?php
                                                        if($checker[0] == 1){
                                                            ?>
                                                            <div class="alert alert-danger">
                                                                <h4><i class="fas fa-check fa-lg"></i>  <?php echo $checker[1];?> : Belum Terinstall</h4>
                                                            </div>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <div class="alert alert-danger">
                                                                <h4 align="center"><i class="fas fa-times fa-lg"></i>  <?php echo $checker[1];?> : Belum Terinstall</h4>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    
                                                    <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                <div class="alert alert-danger">
                                                    <h4 align="center">Belum ada kebutuhan perangkat lunak yang diinput!</h4>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>