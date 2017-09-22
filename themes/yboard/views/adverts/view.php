<?php
/* @var $this SiteController */
/* @var $model Bulletin */

$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = array();
if ($model->category->parent)
    $this->breadcrumbs[$model->category->parent->name] = array('site/category', 'id' => $model->category->parent->id);
$this->breadcrumbs[$model->category->name] = array('site/category', 'id' => $model->category->id);
?>
<div class="advert_full">
    <div class='title' style='padding:0px 3px;'><?php echo  $model->name ?> 
    </div>
    <div class='date'>
        <span><a href='<?php echo Yii::app()->createUrl('user/view', array('id' => $model->user->id))
            ?>'>
                <i class='fa fa-user'></i><?php echo  $model->user->username ?>
            </a></span>  
        <span><i class='fa fa-clock-o'></i><?php echo  PeopleDate::format($model->created_at) ?></span> 
        <span><i class='fa fa-eye'></i><?php echo  $model->views ?></span>
        <div style='float:right; font-size:20px;'>
            <a href='<?
            echo Yii::app()->createUrl('adverts/update', array('id' => $model->id));
            ?>'><i class='fa fa-pencil'></i></a> 
            <a href='javascript:void(0)' onclick='setFavoriteAdv("<?php echo  $model->id ?>", this)'><i class='fa fa-bookmark-o'></i></a>
        </div>
    </div>
    <div class="content">
        <div>
            <?php $this->widget('application.widgets.ShowImagesWidget', array('bulletin' => $model)); ?>
        </div>
        <div>
            <?php $model->youtube_id ? $this->widget('ext.Yiitube', array('v' => $model->youtube_id, 'size' => 'small')) : '';
            ?>
        </div>
        <div>
            <?php echo str_replace("\n", "<br/>", $model->text); ?>
        </div>

        <br/>

        <div class='attributes'>

            <?php if (sizeof($model->fields) > 0 and is_array($model->fields)) { ?>
                <?php
                if (is_array($model->fields))
                    foreach ($model->fields as $f_name => $field) {
                        echo "<div>"
                        . Yii::app()->params['categories'][$model->category_id]
                        ['fields'][$f_name]['name'] . " - " . $field
                        . "</div>";
                    }
                ?>

            <?php } ?>
        </div>
        <div class='price'><?php echo  t('Price') ?> - 
            <?php if ($model->price) { ?>
                <?php echo  $model->price ?> ( <?php echo  Yii::app()->params['currency'][$model->currency] ?> ) 
                <a href='javascript:void(0);' onclick='show_converter()' > открыть конвертор </a>
                <div class='price_converter'><?
                    foreach (Yii::app()->params['currency'] as $cn => $cur) {
                        printf("%.2f", $model->price / Yii::app()->params['exchange'][$model->currency] * Yii::app()->params['exchange'][$cn]);
                        echo " " . $cur . " | ";
                    }
                    ?></div>
                <?
            } else {
                echo "<i>" . t('Not set') . "</i>";
            }
            ?>
        </div>

        <div> 
            <span> Контакты : </span> <br/>
            <?php echo  $model->user->phone ?> <br/>
            <?php echo  $model->user->email ?> <br/>
            <?php echo  $model->user->skype ?> 
        </div>
		
		
        <?php if (Yii::app()->user->id != $model->user->id and isset($model->user->id) ) { ?>
            <div>
                <?php
                echo $this->renderPartial('/messages/_form', array(
                    'model' => $mes_model,
                    'receiver' => $model->user->id)
                );
                ?>
            </div>

            <?
        }
        ?>

        <div class='related'> <span>Похожие объявления: </span>

            <?
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataRel,
                'itemView' => '_view_short',
                'ajaxUpdate' => false,
            ));
            ?>
        </div>
    </div>

</div>