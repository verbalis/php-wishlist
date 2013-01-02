<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	(!Yii::app()->user->isAdmin) ? array('label'=>'Create User', 'url'=>array('create')) : array(),
	(!Yii::app()->user->isAdmin) ? array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)) : array(),
	(!Yii::app()->user->isAdmin) ? array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')) : array(),
	(!Yii::app()->user->isAdmin) ? array('label'=>'Manage User', 'url'=>array('admin')) : array(),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'password',
		'email',
	),
)); ?>
