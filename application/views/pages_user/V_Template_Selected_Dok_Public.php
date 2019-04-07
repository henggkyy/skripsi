 <table class="table table-striped table-bordered table-hover <?php if(isset($daftar_file) && $daftar_file){ echo 'mainDataTable';}?>">
    <?php
    if($jenis_dokumen == 'SOP'){?>
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
    <?php
    }
    else if($jenis_dokumen == 'Buku_saku'){
        ?>
        <thead>
        <tr>
            <th>#</th>
            <th>Dokumen Buku Saku</th>
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
                <td><a target="_blank" href="<?php echo base_url();?>uploads/buku_saku/<?php echo $file['path'];?>"><?php echo $file['judul'];?></a></td>
                <td><?php echo $file['LAST_UPDATE']." (".$file['USER'].")"; ?></td>
            </tr>
            <?php
            $iterator++;
            }  
        }
        else{
            ?>
            <tr>
                <td colspan="4">Belum ada dokumen Buku Saku!</td>
            </tr>
            <?php
            }
        ?>
    </tbody>
        <?php
    }
    ?>
                            
</table>