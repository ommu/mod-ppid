<?php
/**
 * Ppids (ppid)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\AdminController
 * @var $model ommu\ppid\models\Ppid
 * @var $searchModel ommu\ppid\models\search\Ppid
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
use app\components\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use ommu\ppid\models\PpidPic;

$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Add Information'), 'url' => Url::to(['create']), 'icon' => 'plus-square', 'htmlOptions' => ['class'=>'btn btn-success']],
];
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="ppid-manage">
<?php Pjax::begin(); ?>

<?php if($pic != null) {
$model = $pic;
echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'pic_name',
			'value' => function ($model) {
				if($model->pic_name != '')
					return Html::a($model->pic_name, ['pic/view', 'id'=>$model->id], ['title'=>$model->pic_name, 'class'=>'modal-btn']);
				return $model->pic_name;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'pic_desc',
			'value' => $model->pic_desc ? $model->pic_desc : '-',
		],
	],
]);
}?>

<?php //echo $this->render('_search', ['model'=>$searchModel]); ?>

<?php echo $this->render('_option_form', ['model'=>$searchModel, 'gridColumns'=>$searchModel->activeDefaultColumns($columns), 'route'=>$this->context->route]); ?>

<?php
$columnData = $columns;
array_push($columnData, [
	'class' => 'app\components\grid\ActionColumn',
	'header' => Yii::t('app', 'Option'),
	'urlCreator' => function($action, $model, $key, $index) {
		if($action == 'view')
			return Url::to(['view', 'id'=>$key]);
		if($action == 'update')
			return Url::to(['update', 'id'=>$key]);
		if($action == 'delete')
			return Url::to(['delete', 'id'=>$key]);
	},
	'template' => '{view} {update} {delete}',
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => $columnData,
]); ?>

<?php Pjax::end(); ?>
</div>