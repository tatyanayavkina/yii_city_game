<?php
/* @var $this GamestepController */
/* @var $model Gamestep */
/* @var $form CActiveForm */
?>



    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml:: FORM_LAYOUT_HORIZONTAL,
    )); ?>

    <fieldset>

        <legend ></legend>


        <?php echo $form->textFieldControlGroup($model,'cityName',
            array('help' =>  'Введите город','size'=>60,'maxlength'=>128)); ?>

        <?php if($model->error != GameUtils::ERROR_SUCCESS): ?>
        <div id="error_wrapper">
            <?php echo TbHtml::labelTb($model->error, array('color' => TbHtml::LABEL_COLOR_IMPORTANT, 'id'=>'error_label')); ?>
        </div>
        <?php endif; ?>

    <?php echo TbHtml::formActions(array(
        TbHtml::submitButton('Ходить',
            array('color'=> TbHtml::BUTTON_COLOR_PRIMARY)),
        TbHtml::linkButton('Сдаться',
            array('color'=> TbHtml::BUTTON_COLOR_INFO, 'url'=>array('game/delete','id'=>Yii::app()->session['gameId']))),
    )); ?>

    </fieldset>
    <?php $this->endWidget(); ?>
