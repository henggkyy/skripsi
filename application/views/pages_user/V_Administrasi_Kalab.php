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
                                    <h5>Administrasi Kepala Laboratorium</h5>
                                </div>
                                <div class="ibox-content">
                                	<button data-toggle="modal" data-target="#changeKalab" style="display: block; margin: 0 auto;" type="button" class="btn btn-md btn-danger"><i class="fas fa-user-edit fa-1x"></i> Ganti Kepala Laboratorium</button>
                                	<div class="modal inmodal" id="changeKalab" tabindex="-1" role="dialog"  aria-hidden="true">
                                		<div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                            	<div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Ganti Kepala Laboratorium</h4>
                                                </div>
                                                <div class="modal-body">
                                                	<?php echo form_open('kalab/change');?>
                                                	<div class="form-group row">
                                                		<label class="col-sm-4 col-form-label">Pilih Dosen <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select required class="form-control" name="dosen">
                                                            	<option disabled selected value="">-- Please Select One --</option>
                                                           	<?php
                                                                if(isset($data_dosen) && $data_dosen){
                                                                    foreach ($data_dosen as $dosen ) {
                                                                    	if($dosen['ID'] != $this->session->userdata('id')){
                                                                    		?>
                                                                <option value="<?php echo $dosen['ID'];?>"><?php echo $dosen['NAMA']." (".$dosen['NIK'].")";?></option>
                                                                    		<?php
                                                                    	}
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                	</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mengubah status Kepala Laboratorium?')">Ganti Kepala Laboratorium</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                	</div>
                                	<hr>
                                	<h4 align="center" style="color: red;">Pengguna yang dapat menjadi Kepala Laboratorium adalah pengguna yang sebelumnya telah terdaftar sebagai Dosen pada sistem!</h4>
                                	<h4 align="center">Dengan mengubah status Kepala Laboratorium, status Anda akan secara otomatis berubah menjadi Dosen dan pengguna yang dipilih akan otomatis menjadi Kepala Laboratorium</h4>
                                	<h4 align="center">Setelah berhasil mengubah status, akun Anda akan logout secara otomatis dan Anda akan diarahkan ke halaman login.</h4>
                                </div>
                            </div>
                        </div> 
                	</div>
                </div>
            </div>