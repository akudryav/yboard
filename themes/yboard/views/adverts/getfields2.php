<?php echo CHtml::dropDownList('subcat_' . $cat_id, 0, $drop_cats, array('empty' => t('Choose category'), 'onchange' => 'loadFields(this)'));?>