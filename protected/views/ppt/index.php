<?php
/* @var $this PptController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ppts',
);

$this->menu=array(
	array('label'=>'Create Ppt', 'url'=>array('create')),
);
?>

<h1>Ppts</h1>

<ul>
    <?php foreach ($dataProvider->getData() as $k => $item): ?>
    <li>
        <div>
            <a href="?r=ppt/view&amp;id=<?= $item->id ?>"><?= $item->name ?></a>
        </div>
        <a href="<?= Yii::app()->params['upload_url'].$item->url ?>">link</a>
        <div><?= $item->created ?></div>
    </li>
    <?php endforeach ?>
</ul>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
