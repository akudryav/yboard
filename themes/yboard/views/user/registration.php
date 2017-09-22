<?php
$this->pageTitle = Yii::app()->name . ' - ' . t("Registration");
$this->breadcrumbs = array(
    t("Registration"),
);
?>

<h1><?php echo t("Registration"); ?></h1>

<?php if (Yii::app()->user->hasFlash('registration')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('registration'); ?>
    </div>
<?php else: ?>

    <div class="form well">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'registration-form',
            'enableAjaxValidation' => false,
                //'disableAjaxValidationAttributes' => array('RegistrationForm_verifyCode'),
                /*
                  'clientOptions' => array(
                  'validateOnSubmit' => true,
                  ),
                 * 
                 */
                //'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>

        <p class="note"><?php echo t('Fields with <span class="required">*</span> are required.'); ?></p>

        <?php echo $form->errorSummary(array($model)); ?>

        <div >
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div >
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>
            <p class="hint">
                <?php echo t("Minimal password length 4 symbols."); ?>
            </p>
        </div>

        <div >
            <?php echo $form->labelEx($model, 'verifyPassword'); ?>
            <?php echo $form->passwordField($model, 'verifyPassword'); ?>
            <?php echo $form->error($model, 'verifyPassword'); ?>
        </div>

        <div >
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div >
            <?php echo $form->labelEx($model, 'verifyCode'); ?>

            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model, 'verifyCode'); ?>
            <?php echo $form->error($model, 'verifyCode'); ?>

            <p class="hint"><?php echo t("Please enter the letters as they are shown in the image above."); ?>
                <br/><?php echo t("Letters are not case-sensitive."); ?></p>
        </div>


        <div class="row submit">	
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'label' => "Зарегистрироваться"
            ));
            ?>
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
<?php endif; ?>