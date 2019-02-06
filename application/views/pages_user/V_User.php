            <div class="wrapper wrapper-content animated fadeIn">
                <div class="p-w-md m-t-sm">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Daftar User</h5>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(isset($data_user) && $data_user){
                                            $iterator = 1;
                                            foreach ($data_user as $du) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $iterator;?></td>
                                                    <td><?php echo $du['NAMA'];?></td>
                                                    <td><?php echo $du['EMAIL'];?></td>
                                                    <td><?php echo $du['NAMA_ROLE'];?></td>
                                                    <td><?php 
                                                        if($du['STATUS'] == 1){
                                                            echo "Aktif";
                                                        } 
                                                        else{
                                                            echo "Tidak Aktif";
                                                        }?>      
                                                    </td>
                                                    <td>
                                                        <?php echo form_open('/user/change_status'); ?>
                                                        <input hidden type="text" name="id_user" value="<?php echo $du['ID'];?>">
                                                            <?php 
                                                            if($du['STATUS'] == 1){
                                                                ?>
                                                                <button type="submit" class="btn btn-w-m btn-danger">Nonaktifkan</button>
                                                                <?php
                                                            } 
                                                            else{
                                                                ?>
                                                                <button type="submit" class="btn btn-w-m btn-success">Aktifkan</button>
                                                                <?php
                                                            }?> 
                                                        
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                                $iterator++;
                                            }
                                        }   
                                        else{
                                            echo "<tr><td colspan='5'>Belum ada user</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div> 
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins collapsed">
                                <div class="ibox-title collapse-link">
                                    <h5>Tambah User</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="panel panel-success">
                                        <div class="panel-heading ">
                                            <p>Tambah User Baru</p>
                                        </div>
                                        <?php echo form_open('/user/tambah_user'); ?>
                                        <div class="panel-body">
                                            <div class="form-group  row <?php if(isset($error_form) && $error_form){ echo 'has-error';}?>">
                                                <label class="col-sm-2 col-form-label">Nama User <span style="color: red">*</span> :</label>
                                                <div class="col-sm-10">
                                                    <input type="text" required name="nama_user" placeholder="Contoh : Kevin Pratama" class="form-control">
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
                                                <label class="col-sm-2 col-form-label">Email User <span style="color: red">*</span> :</label>
                                                <div class="col-sm-10">
                                                    <input type="email" required name="email_user" placeholder="Contoh : 7314073@student.unpar.ac.id" class="form-control">
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
                                                <label class="col-sm-2 col-form-label">Role User <span style="color: red">*</span> :</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="role_user" required>
                                                        <option selected disabled>-- Please Select One --</option>
                                                        <?php
                                                        foreach ($role as $ro) {
                                                            ?>
                                                            <option value="<?php echo $ro['ID'];?>"><?php echo $ro['NAMA_ROLE'];?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <p style="color: red;">* Required Field</p>
                                            <button type="submit" class="btn btn-w-m btn-success">Tambah User</button>     
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>      
                        </div>         
                    </div>
                </div>
            </div>
