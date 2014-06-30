<?php
/* @var $this PptController */
/* @var $model Ppt */

$this->breadcrumbs=array(
	'Ppts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Ppt', 'url'=>array('index')),
	array('label'=>'Create Ppt', 'url'=>array('create')),
	array('label'=>'Update Ppt', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ppt', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ppt', 'url'=>array('admin')),
);
?>

<h1>View Ppt #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'url',
		'created',
	),
)); ?>
