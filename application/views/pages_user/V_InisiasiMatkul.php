            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <?php $this->load->view('pages_user/V_Template_Periode_Aktif');?>
                            </div>
                        </div> 
                        
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Administrasi Mata Kuliah</h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if($periode_aktif){
                                        if($this->session->userdata('id_role') == 1 || $this->session->userdata('id_role') == 3){
                                        ?>
                                    <button type="button" data-toggle="modal" data-target="#modalAddMatkul" class="btn btn-w-m btn-success"><i class="fas fa-plus"></i> Tambah Mata Kuliah</button>
                                    <!--Modal Add Matkul-->
                                    <div class="modal inmodal" id="modalAddMatkul" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Tambah Mata Kuliah</h4>
                                                </div>
                                                <?php echo form_open('/administrasi_matkul/tambah'); ?>
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Mata Kuliah <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" required name="matkul">
                                                                <option disabled selected value="">-- Please Select One --</option>
                                                                <?php
                                                                if(isset($list_matkul) && $list_matkul){
                                                                    foreach ($list_matkul as $lst_matkul) {
                                                                        ?>
                                                                <option value="<?php echo $lst_matkul['ID'];?>"><?php echo $lst_matkul['KODE_MATKUL']." / ".$lst_matkul['NAMA_MATKUL'];?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Dosen Koordinator <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="dosen_koor" required>
                                                                <option selected disabled value="">-- Please Select One --</option>
                                                                <?php
                                                                if(isset($data_dosen) && $data_dosen){
                                                                    foreach ($data_dosen as $dosen) {
                                                                        ?>
                                                                        <option value="<?php echo $dosen['ID'];?>"><?php echo $dosen['NAMA'];?> (<?php echo $dosen['NIK'];?>)</option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <p style="color: red;" align="center">* Wajib Diisi</p>
                                                </div>
                                                <div class="modal-footer">
                                                    
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Tambah Mata Kuliah</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END MODAL ADD Matkul-->
                                        <?php
                                    }
                                    if($this->session->userdata('id_role') == 4){
                                        ?>
                                    <button type="button" data-toggle="modal" data-target="#modalInfoChecker" class="btn btn-md btn-warning"><i class="fas fa-check"></i> Cek Kebutuhan Software</button>
                                    <div class="modal inmodal" id="modalInfoChecker" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" style="color: red;">Informasi</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 align="center">Setelah menekan button dibawah, sistem akan secara otomatis mengunduh JAR untuk melakukan pengecekan perangkat lunak. <br> Silahkan Anda buka JAR tersebut dan tunggu hingga JAR membuka tab browser baru untuk melakukan pengecekan perangkat lunak!</h4>
                                                    <h4 align="center" style="color: red;">JAR hanya dapat mendeteksi perangkat lunak yang terpasang pada OS Windows saja!<br>Untuk melakukan pengecekan perangkat lunak, harap Anda membuka SI ini dengan menggunakan default browser yang terpasang pada komputer Anda</h4>
                                                    <a style="display: block; margin: 0 auto;" href="<?php echo base_url();?>download/checker" class="btn btn-w-m btn-success"><i class="fas fa-download"></i> Download JAR</a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                    }
                                    ?>
                                    <hr>
                                    <label class="col-sm-4 col-form-label">Periode Akademik:</label>
                                    <div class="col-sm-8 ">
                                        <form method="GET" action="<?php echo base_url()."administrasi_matkul";?>">
                                            
                                            <select name="id_periode" onchange="this.form.submit()" class="form-control">
                                                    <?php
                                                    if(isset($daftar_periode) && $daftar_periode){
                                                        foreach ($daftar_periode as $list_periode) {
                                                    ?>
                                                    <option value="<?php echo $list_periode['ID'];?>" <?php if($list_periode['ID'] == $id_periode_aktif){ echo 'selected';}?>><?php echo $list_periode['NAMA'];?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                        </form>
                                    </div>
                                    <br>
                                    <hr>
                                    <h3>Daftar Mata Kuliah</h3>
                                    <div class="table-responsive">
                                    	<table class="table table-bordered">
	                                        <thead>
	                                        <tr>
	                                            <th>#</th>
	                                            <th>Kode Mata Kuliah</th>
	                                            <th>Nama Mata Kuliah</th>
	                                            <th>Dosen Koordinator</th>
	                                            <th>Periode Akademik</th>
	                                            <th>Action</th>
	                                        </tr>
	                                        </thead>
	                                        <tbody>
	                                        <?php
	                                        if(isset($matkul) && $matkul){
	                                            $iterator = 1;
	                                            foreach ($matkul as $mtk) {
	                                                ?>
	                                                <tr>
	                                                    <td><?php echo $iterator;?></td>
	                                                    <td><?php echo $mtk['KD_MATKUL'];?></td>
	                                                    <td><?php echo $mtk['NAMA_MATKUL'];?></td>
	                                                    <td><?php echo $mtk['NAMA_DOSEN'];?></td>
	                                                    <td><?php echo $mtk['NAMA_PERIODE'];?></td>
	                                                    <td><a href="<?php echo base_url().'administrasi_matkul_detail?id='.$mtk['ID'];?>" class="btn btn-primary btn-sm"><i class="fas fa-info"></i> Detail</button></a>
	                                                </tr>
	                                                <?php
	                                                $iterator++;
	                                            }
	                                        }   
	                                        else{
	                                            echo "<tr><td colspan='6'>Belum ada mata kuliah</td></tr>";
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