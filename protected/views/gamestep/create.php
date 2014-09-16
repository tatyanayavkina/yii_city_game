<?php
/* @var $this GamestepController */
/* @var $model Gamestep */
?>

        <div class="span6">
            <?php $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>

        <div class="span6">
            <?php if(Gamestep::model()->getLastStepNumber()>0): ?>
                <?php $this->widget('bootstrap.widgets.TbGridView', array(
                    'dataProvider' => $step->search(),
                    'template'=>'{items}{pager}',
                    'columns' => array(
                        array(
                            'name'=> 'Номер хода',
                            'value'=>'$data->stepNumber',
                        ),
                        array(
                            'name'=>'Города',
                            'value'=>'$data->city->name',
                        ),
                    ),
                )); ?>
            <?php endif; ?>
        </div>


