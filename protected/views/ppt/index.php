<?php
/* @var $this PptController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ppts',
);

$this->menu=array(
	array('label'=>'Create Ppt', 'url'=>array('create')),
	array('label'=>'Manage Ppt', 'url'=>array('admin')),
);
?>

<h1>Ppts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
