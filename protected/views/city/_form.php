<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml:: FORM_LAYOUT_HORIZONTAL,
)); ?>

    <fieldset>

        <Legend >Добавить город</legend>

        <?php echo $form->textFieldControlGroup($model,'name',array('size'=>60,'maxlength'=>128) ); ?>
        <?php echo TbHtml::formActions(array( TbHtml::submitButton('Create',array('color'=> TbHtml::BUTTON_COLOR_PRIMARY)),)); ?>

    </fieldset>



<?php $this->endWidget(); ?>