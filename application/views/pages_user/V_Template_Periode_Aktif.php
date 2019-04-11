<div class="ibox-title collapse-link">
    <h5>Status & Informasi Periode Akademik</h5>
    <div class="ibox-tools">
        <a>
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
</div>
<div class="ibox-content collapsed">
    <?php
    if($periode_aktif){
        ?>
    <h4><span style="font-weight: bold;">Periode : </span><?php echo $periode_aktif[0]['NAMA']?></h4>
    <h4><span style="font-weight: bold;">Periode Perkuliahan : </span><?php echo $periode_aktif[0]['START_PERIODE']." s/d ". $periode_aktif[0]['END_PERIODE'];?></h4>
    <h4><span style="font-weight: bold;">Periode UTS : </span><?php echo $periode_aktif[0]['START_UTS']." s/d ". $periode_aktif[0]['END_UTS'];?></h4>
    <h4><span style="font-weight: bold;">Periode UAS : </span><?php echo $periode_aktif[0]['START_UAS']." s/d ". $periode_aktif[0]['END_UAS'];?></h4>
        <?php
    }
    else{
        ?>
    <h4><span style="color: red;"> <br>Belum ada periode semester aktif!</span></h4>    
        <?php
    }
    ?>
</div>