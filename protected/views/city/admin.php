<?php
/* @var $this CityController */
/* @var $model City */
?>

<?php $this->renderPartial('_form', array(
    'model' => $city,
)); ?>



<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template'=>'{summary}{items}{pager}',
    'columns' => array(
        'id',
        'name',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array
            (
                'delete' => array(
                    'icon'=>'icon-remove-sign',
                ),
            ),
        ),
    ),
)); ?>
