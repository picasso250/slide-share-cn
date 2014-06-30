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
            <strong><a href="?r=ppt/view&amp;id=<?= $item->id ?>"><?= $item->name ?></a></strong>
        </div>
        <a href="<?= Yii::app()->params['upload_url'].$item->url ?>">link</a>
        <div><?= $item->created ?></div>
    </li>
    <?php endforeach ?>
</ul>

<?php
$pager=array();
$class='CLinkPager';

$pager['pages']=$dataProvider->getPagination();

if($pager['pages']->getPageCount()>1)
{
    echo '<div class="'.'pager'.'">';
    $this->widget($class,$pager);
    echo '</div>';
}
else
    $this->widget($class,$pager);
?>
