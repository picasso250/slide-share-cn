<?php
/* @var $this PptController */
/* @var $model Ppt */

$this->breadcrumbs=array(
	'Ppts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ppt', 'url'=>array('index')),
	array('label'=>'Create Ppt', 'url'=>array('create')),
	array('label'=>'View Ppt', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Ppt', 'url'=>array('admin')),
);
?>

<h1>Update Ppt <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>