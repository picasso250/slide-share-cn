<?php
/* @var $this PptController */
/* @var $model Ppt */

$this->breadcrumbs=array(
	'Ppts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ppt', 'url'=>array('index')),
	array('label'=>'Manage Ppt', 'url'=>array('admin')),
);
?>

<h1>Create Ppt</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>