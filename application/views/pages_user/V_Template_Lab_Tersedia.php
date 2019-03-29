<select id="choice_lab" name="lab" required class="form-control"> 
                                <option selected disabled value="">-- Please Select One --</option>
                                <?php
                                if(isset($daftar_lab) && $daftar_lab){
                                    foreach ($daftar_lab as $lab) {
                                        ?>
                                        <option value="<?php echo $lab['0'];?>"><?php echo $lab['1'];?> (<?php echo $lab['2'];?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>