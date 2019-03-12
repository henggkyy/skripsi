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
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Tambah Dokumen SOP</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                           <div class="panel panel-success">
                                                <div class="panel-heading ">
                                                    <p>Tambah Dokumen SOP</p>
                                                </div>
                                                <?php echo form_open_multipart('/dokumen_sop/add'); ?>
                                                <div class="panel-body">
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Kategori Dokumen SOP : <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select required class="form-control" name="kategori_sop">
                                                                <option disabled selected> -- Please Select One --</option>
                                                                <?php
                                                                if(isset($kategori_sop) && $kategori_sop){
                                                                    foreach ($kategori_sop as $kategori ) {
                                                                        ?>
                                                                        <option value="<?php echo $kategori['ID'];?>"><?php echo $kategori['NAMA_KATEGORI'];?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Visibility Dokumen SOP : <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <select required class="form-control" name="visibility">
                                                                <option disabled selected> -- Please Select One --</option>
                                                                <option value="1">Public</option>
                                                                <option value="0">Private</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Judul Dokumen SOP <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" required name="judul_sop" placeholder="Contoh : SOP Pengadaan Ujian" class="form-control">
                                                            <?php
                                                                if(isset($error_form) && $error_form){
                                                                        ?>
                                                                    <span class="form-text m-b-none" style="color: red;"><?php echo $error_form;?></span>
                                                                        <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                        <label class="col-sm-4 col-form-label">Dokumen SOP (.pdf maks. 4MB) <span style="color: red">*</span> :</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" required name="dokumen" class="form-control">
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
                                    <h5>Daftar Dokumen SOP</h5>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Dokumen SOP</th>
                                            <th>Kategori</th>
                                            <th>Visibility</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($file_sop) && $file_sop){
                                                $iterator = 1;
                                                foreach ($file_sop as $sop) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $iterator;?></td>
                                                        <td><a target="_blank" href="<?php echo base_url();?>uploads/sop/<?php echo $sop['path'];?>"><?php echo $sop['judul'];?></a></td>
                                                        <td><?php echo $sop['nama_kategori'];?></td>
                                                        <td><?php if($sop['visibility'] == 1) {
                                                                echo "Public";
                                                            }
                                                            else{
                                                                echo "Private";
                                                            }?></td>
                                                        <td align="center">
                                                            <a class="btn btn-primary btn-sm" href=""><i class="fas fa-pen"></i> Update</a>
                                                            <?php echo form_open('dokumen_sop/delete');?>
                                                            <input type="hidden" name="id_sop" value="<?php echo $sop['ID'];?>" required>
                                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')" type="submit"><i class="far fa-trash-alt"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $iterator++;
                                                }
                                            }
                                            else{
                                                echo "<tr><td colspan='5'>Belum ada dokumen SOP</td></tr>";
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