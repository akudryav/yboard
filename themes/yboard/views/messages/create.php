<?php
/* @var $this MessagesController */
/* @var $model Messages */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Messages', 'url'=>array('index')),
	array('label'=>'Manage Messages', 'url'=>array('admin')),
);

//var_dump(User::model()->findByPk($receiver)->id);


?>

<div><?php echo t('Write messages to')?> 
    <a href='<?php echo Yii::app()->createUrl('user/view',array('id'=>$receiver))?>'> 
        <?php echo User::model()->findByPk($receiver)->username?>
    </a>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'receiver'=>$receiver)); ?>