<?php
$this->breadcrumbs = array(
    t('Users') => array('index'),
    $model->username,
);
$this->layout = '//main-template';
$this->menu = array(
    array('label' => t('List User'), 'icon' => 'icon-list', 'url' => array('index')),
);
?>

<?php
// For all users
$attributes = array(
    'username',
    'full_name',
    'email',
    'birthday',
    'location',
    'phone',
    'skype',
    'contacts',
    'lastvisit_at',
    'create_at',
        //'value' => (($model->lastvisit_at != '0000-00-00 00:00:00') ? $model->lastvisit_at : t('Not visited')),
);

/*
  array_push($attributes, 'create_at', array(

  )
  );
 * 
 */
?>
<div class='userHead'>
    <h4><?php echo $model->username; ?></h4> <?php if ($model->lastvisit_at) { 
        echo "(".PeopleDate::format($model->lastvisit_at) .")"; 
    } ?>
    <?php if (Yii::app()->user->id == Yii::app()->request->getParam("id")) { ?>
        <a href='<?php echo Yii::app()->createUrl('user/update', array('id' => $model->id)) ?>'> Редактировать </a>
    <?php } ?>
    <?php if (Yii::app()->user->isAdmin() and Yii::app()->user->id != $model->id ) { ?>
        <a href='<?php echo Yii::app()->createUrl('user/ban', array('id' => $model->id)) ?>'> Заблокировать </a>
    <?php } ?>
    <div> 
        <a href='<?php echo Yii::app()->createUrl("adverts/user", array('id' => $model->id)) ?>'> <?php echo  t('Adverts') ?> </a> 
        | <a href='<?php echo Yii::app()->createUrl("user/view", array('id' => $model->id)) ?>'> <?php echo  t('Personal dates') ?> </a> 
    </div>
</div>
<div> 
    <dl>
        <?php if ($model->full_name) { ?>
            <dt><?php echo  t('Полное имя') ?> :</dt> <dd> <?php echo  $model->full_name ?> </dd>
        <?php } if ($model->birthday and $model->birthday !== "0000-00-00") { ?>
            <dt><?php echo  t('Дата рождения') ?> :</dt> <dd> <?php echo  PeopleDate::format($model->birthday) ?> </dd>
        <?php } if ($model->location) { ?>
            <dt><?php echo  t('Место проживания') ?> :</dt> <dd> <?php echo  $model->location ?> </dd>
        <?php } ?>
        <br/>
        <h4><?php echo  t('Контакты') ?> : </h4>
        <?php if ($model->phone) { ?>
            <dt><?php echo  t('Телефон') ?> :</dt> <dd> <?php echo  $model->phone ?> </dd>
        <?php } if ($model->skype) { ?>
            <dt><?php echo  t('Skype') ?> :</dt> <dd> <?php echo  $model->skype ?> </dd>
        <?php } if ($model->email) { ?>
            <dt><?php echo  t('Почта') ?> :</dt> <dd> <?php echo  $model->email ?> </dd>
        <?php } if ($model->contacts) { ?>


            <dt><?php echo  t('Другие контакты') ?> :</dt> <dd> <?php echo  $model->contacts ?> </dd>
        <?php } if ($model->create_at) { ?>
            <dt><?php echo  t('Дата регистрации') ?> :</dt> <dd> <?php echo  PeopleDate::format($model->create_at) ?> </dd>
        <?php } ?>

    </dl>
    <?
    if (Yii::app()->user->id !== $model->id) {
        echo $this->renderPartial('/messages/_form', array('model' => $mes_model, 'receiver' => $model->id));
    }
    ?>
</div>
