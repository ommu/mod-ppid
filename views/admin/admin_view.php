<?php
/**
 * Ppids (ppid)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\AdminController
 * @var $model ommu\ppid\models\Ppid
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 18:36 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use ommu\ppid\models\Ppid;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ppids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->pic->pic_name;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->ppid_id]), 'icon' => 'eye', 'htmlOptions' => ['class'=>'btn btn-success']],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->ppid_id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->ppid_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
?>

<div class="ppid-view">

<?php
$attributes = [
	'ppid_id',
	[
		'attribute' => 'picName',
		'value' => function ($model) {
			$picName = isset($model->pic) ? $model->pic->pic_name : '-';
			if($picName != '-')
				return Html::a($picName, ['pic/view', 'id'=>$model->pic_id], ['title'=>$picName, 'class'=>'modal-btn']);
			return $picName;
		},
		'format' => 'html',
	],
	'release_year',
	'retention',
	[
		'attribute' => 'creation_date',
		'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
	],
	[
		'attribute' => 'creationDisplayname',
		'value' => isset($model->creation) ? $model->creation->displayname : '-',
	],
	[
		'attribute' => 'modified_date',
		'value' => Yii::$app->formatter->asDatetime($model->modified_date, 'medium'),
	],
	[
		'attribute' => 'modifiedDisplayname',
		'value' => isset($model->modified) ? $model->modified->displayname : '-',
	],
	[
		'attribute' => 'format',
		'value' => function ($model) {
			return Ppid::parseFormat(array_flip($model->getFormats(true)), ', ');
		},
	],
	[
		'attribute' => '',
		'value' => Html::a(Yii::t('app', 'Update'), ['update', 'id'=>$model->primaryKey], ['title'=>Yii::t('app', 'Update'), 'class'=>'btn btn-primary']),
		'format' => 'html',
		'visible' => Yii::$app->request->isAjax ? true : false,
	],
];

echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => $attributes,
]); ?>

</div>