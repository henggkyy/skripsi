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
                        		<div class="ibox-content">
                        			<div class="row">
                            			<div class="form-group">
                                            <form method="GET" action="<?php echo base_url()."admin_lab/rekapitulasi_jadwal";?>">
                            				<label class="col-sm-4 col-form-label">Periode Akademik : </label>
                            				<div class="col-sm-8">
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
		                                    </div>
                                            </form>
                            			</div>
                            		</div>
                        		</div>
                        	</div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox float-e-margins">
                        		<div class="ibox-title">
								    <h5>Cetak Jadwal Bertugas Admin</h5>
								    
								</div>
                        		<div class="ibox-content">
                        			 <a target="_blank" class="btn btn-sm btn-success" href="<?php echo base_url();?>admin_lab/jadwal/cetak"><i class="fas fa-print"></i> Cetak</a>
                                    <p style="color:red;font-size:10px;">Jadwal bertugas admin yang dicetak merupakan jadwal pada bulan yang sedang berjalan!</p>
                        		</div>
                        	</div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="ibox float-e-margins">
                        		<div class="ibox-title">
								    <h5>Jadwal Bertugas Masa Perkuliahan</h5>
								    
								</div>
								<div class="ibox-content">
									<div class="row">
										<div class="tiva-timetable" tipe-bertugas="1" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="week" data-mode="day" data-header-time="hide">
                                		</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
                        	<div class="ibox float-e-margins ">
                        		<div class="ibox-title">
								    <h5>Jadwal Bertugas Masa Ujian (UTS/UAS)</h5>
								</div>
								<div class="ibox-content">
									<p align="center" style="color: red;">Untuk melihat jadwal bertugas pada masa UTS/UAS, silahkan geser tanggal ke minggu periode UTS/UAS</p>
									<div class="row">
										<div class="tiva-timetable" tipe-bertugas="2" id-periode="<?php echo $id_periode_aktif; ?>" data-url="<?php echo base_url();?>" data-source="data_bertugas_admin" data-view="week">
	                           	 		</div>
	                           	 	</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
                            <a class="btn btn-md btn-primary" href="<?php echo base_url();?>admin_lab"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                	</div>
                </div>
            </div>