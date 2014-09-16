<?php
/* @var $this GamestepController */
?>

    <h1>Игра окончена</h1>
<?php echo TbHtml::muted(Yii::app()->session['loser']); ?>
<?php echo TbHtml::linkButton('Играть еще раз', array('color' => TbHtml::BUTTON_COLOR_INFO, 'url'=>array('start'))); ?>