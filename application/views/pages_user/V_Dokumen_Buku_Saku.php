            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <?php $this->load->view('pages_user/V_Template_Periode_Aktif');?>
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Tambah Dokumen Buku Saku</h5>
                                    <div style="float:left;" class="ibox-tools">
                                        <a>
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                           <div class="panel panel-success">
                                                <div class="panel-heading ">
                                                    <p>Tambah Dokumen Buku Saku</p>
                                                </div>
                                                <?php echo form_open_multipart('/dokumen_saku/add'); ?>
                                                <div class="panel-body">
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Visibility Dokumen Buku Saku : <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select required class="form-control" name="visibility">
                                                                <option disabled selected> -- Please Select One --</option>
                                                                <option value="1">Public</option>
                                                                <option value="0">Private</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Judul Dokumen Buku Saku <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" required name="judul_saku" placeholder="Contoh : Buku Saku Mahasiswa" class="form-control">
                                                            <?php
                                                                if(isset($error_form) && $error_form){
                                                                        ?>
                                                                    <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                        <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label class="col-sm-4 col-form-label">Dokumen Buku Saku (.pdf maks. 2MB) <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input class="input_pdf" type="file" required name="dokumen" class="form-control">
                                                            <?php
                                                                if(isset($error_form) && $error_form){
                                                                        ?>
                                                                    <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                        <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <p style="color: red;">* Required Field</p>
                                                    <button type="submit" class="btn btn-w-m btn-success">Add</button>     
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Daftar Dokumen Buku Saku</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover <?php
                                                if(isset($file_saku) && $file_saku){ echo 'mainDataTable';}?>">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Dokumen Buku Saku</th>
                                                <th>Visibility</th>
                                                <th>Last Update</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($file_saku) && $file_saku){
                                                    $iterator = 1;
                                                    foreach ($file_saku as $saku) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $iterator;?></td>
                                                            <td><a target="_blank" href="<?php echo base_url();?>uploads/buku_saku/<?php echo $saku['path'];?>"><?php echo $saku['judul'];?></a></td>
                                                            <td><?php if($saku['visibility'] == 1) {
                                                                    echo "Public";
                                                                }
                                                                else{
                                                                    echo "Private";
                                                                }?></td>
                                                            <td><?php echo $saku['LAST_UPDATE']." (".$saku['USER'].")"; ?></td>
                                                            <td align="center">
                                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdate<?php echo $saku['ID'];?>"><i class="fas fa-pen"></i> Update</button>
                                                                <!--Link Delete Dokumen SOP -->
                                                                <?php echo form_open('dokumen_saku/delete');?>
                                                                <input type="hidden" name="id_saku" value="<?php echo $saku['ID'];?>" required>
                                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                                                                </form>
                                                                <!--End Delete SOP -->
                                                            </td>
                                                             <!--Modal Update-->
                                                                <div class="modal inmodal" id="modalUpdate<?php echo $saku['ID'];?>" tabindex="-1" role="dialog"  aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content animated fadeIn">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                                <h4 class="modal-title">Update Dokumen Buku Saku</h4>
                                                                            </div>
                                                                            <?php echo form_open_multipart('dokumen_saku/update');?>
                                                                            <div class="modal-body">
                                                                                
                                                                                <div class="form-group  row">
                                                                                    <label class="col-sm-4 col-form-label">Visibility Dokumen Buku Saku <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <select required class="form-control" name="visibility">
                                                                                            
                                                                                            <option <?php if($saku['visibility'] == 1){ echo 'selected';}?> value="1">Public</option>
                                                                                            <option <?php if($saku['visibility'] == 0){ echo 'selected';}?> value="0">Private</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group  row">
                                                                                    <label class="col-sm-4 col-form-label">Judul Dokumen Buku Saku <span style="color: red">*</span> :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <input type="text" value="<?php echo $saku['judul'];?>" required name="judul_saku" placeholder="Contoh : SOP Pengadaan Ujian" class="form-control">
                                                                                        <?php
                                                                                            if(isset($error_form) && $error_form){
                                                                                                    ?>
                                                                                                <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                                                    <?php
                                                                                            }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="form-group  row">
                                                                                    <label class="col-sm-4 col-form-label">Dokumen Buku Saku (.pdf maks. 4MB) :</label>
                                                                                    <div class="col-sm-8">
                                                                                        <p align="left">Dokumen Buku Saku saat ini : <a target="_blank" href="<?php echo base_url();?>uploads/buku_saku/<?php echo $saku['path'];?>"><?php echo $saku['judul'];?></a></p>
                                                                                        <p align="left" style="color: red; font-size: 10px;">Apabila ingin update dokumen pdf, silahkan upload kembali. Jika tidak terdapat update pada dokumen pdf, maka kosongkan input file</p>
                                                                                        <input type="file" name="dokumen" class="form-control">
                                                                                        <?php
                                                                                            if(isset($error_form) && $error_form){
                                                                                                    ?>
                                                                                                <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                                                    <?php
                                                                                            }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="id_saku" value="<?php echo $saku['ID'];?>" required>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </tr>
                                                        <?php
                                                        $iterator++;
                                                    }
                                                }
                                                else{
                                                    echo "<tr><td colspan='6'>Belum ada dokumen Buku Saku</td></tr>";
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