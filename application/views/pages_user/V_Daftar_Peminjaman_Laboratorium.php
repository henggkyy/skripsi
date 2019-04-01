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
                                    <h5>Daftar Peminjaman Laboratorium</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                                if(isset($daftar_peminjaman) && $daftar_peminjaman){ echo 'mainDataTable';}?>">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tanggal Rekam</th>
                                                <th>User Peminjam</th>
                                                <th>Laboratorium</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Waktu</th>
                                                <th>Keterangan Peminjam</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($daftar_peminjaman) && $daftar_peminjaman){
                                                    $iterator = 1;
                                                    foreach ($daftar_peminjaman as $peminjam) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $iterator;?></td>
                                                            <td><?php echo $peminjam['TANGGAL_REKAM'];?></td>
                                                            <td><?php echo $peminjam['NAMA_PEMINJAM']. " (" .$peminjam['EMAIL_PEMINJAM']. ")";?></td>
                                                            <td><?php echo $peminjam['NAMA_LAB'].' ('.$peminjam['LOKASI']. ')';?></td>
                                                            <td><?php echo $peminjam['TANGGAL_PINJAM'];?></td>
                                                            <td><?php echo $peminjam['JAM_MULAI'].' - '.  $peminjam['JAM_SELESAI'];?></td>
                                                            <td><?php echo $peminjam['KETERANGAN_PEMINJAM'];?></td>
                                                            <td><?php if($peminjam['STATUS'] == 0) {
                                                                    echo "Pending";
                                                                }
                                                                else if($peminjam['STATUS'] == 1){
                                                                    echo "Disetujui";
                                                                }
                                                                else {
                                                                    echo "Ditolak";
                                                                }?></td>
                                                            <td align="center">
                                                                <?php
                                                                if($peminjam['STATUS'] == 0){
                                                                    ?>
                                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdate<?php echo $peminjam['ID'];?>"><i class="fas fa-pen"></i> Tindakan</button>
                                                                 
                                                                    <?php
                                                                }
                                                                else{
                                                                    echo 'Sudah Ditindaklanjuti';
                                                                }
                                                                ?>
                                                            </td>
                                                            <!--START MODAL ADD Tindakan-->
                                                                <div class="modal inmodal" id="modalUpdate<?php echo $peminjam['ID'];?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Tindaklanjuti Permintaan Peminjaman Laboratorium</h4>
                                                                            </div>
                                                                            <?php echo form_open('/peminjaman/tindakan'); ?>
                                                                            <div class="modal-body">
                                                                                <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                                                    <label class="col-sm-4 col-form-label">Tindakan <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <select name="tindakan" class="form-control" required>
                                                                                            <option value="" selected disabled>-- Please Choose One --</option>
                                                                                            <option value="1">Setujui Permintaan</option>
                                                                                            <option value="2">Tolak Permintaan</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                                                    <label class="col-sm-4 col-form-label">Keterangan <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <textarea style="height: 100px;" required name="keterangan" placeholder="Dapat diisi dengan alasan penolakan, langkah-langkah setelah disetujui, dsb." class="form-control"></textarea>
                                                                                        <?php
                                                                                            if(isset($error_form) && $error_form){
                                                                                                    ?>
                                                                                                <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                                                    <?php
                                                                                            }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="id_pinjaman" value="<?php echo $peminjam['ID'];?>" required>
                                                                                <p style="color: red;" align="center">* Wajib Diisi</p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                
                                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save Change</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--END MODAL ADD Tindakan-->
                                                        </tr>
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='5'>Belum ada permintaan Peminjaman Laboratorium</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>   
                                          
                    </div>
                </div>
            </div>