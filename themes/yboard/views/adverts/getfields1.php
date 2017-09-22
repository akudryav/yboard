<div id='fields_list'>
    <?php if (sizeof($fields) > 0)
                foreach ($fields as $f_iden => $fv) {
                    ?>
                    <div class="controls">
                        <label for='Fields[<?php echo  $f_iden ?>]'><?php echo  $fv->name ?></label>
                        <?php if ($fv->type == 1) { ?>
                            <input type="checkbox" id="Fields[<?php echo  $f_iden ?>]" name="Fields[<?php echo  $f_iden ?>]" <?php ($fv->atr ? "checked='checked'" : "") ?> >
                            <?
                        } elseif ($fv->type == 2) {
                            echo CHtml::dropDownList("Fields[" . $f_iden . "]", array()
                                    , explode(",", $fv->atr));
                        } else {
                            ?>
                            <input type="text" id="Fields[<?php echo  $f_iden ?>]" name="Fields[<?php echo  $f_iden ?>]" >
                        <?php } ?>
                    </div>  

                    <?
                }
                ?>
    </div>
    <input type="hidden" class="error" value="<?php echo $cat_id?>" id="Adverts_category_id" name="Adverts[category_id]">