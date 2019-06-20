<?php
/**
 * Ppid Settings (ppid-setting)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\SettingController
 * @var $model ommu\ppid\models\PpidSetting
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 20 June 2019, 21:29 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use ommu\ppid\models\PpidSetting;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ppid-setting-index">

<?php
$attributes = [
	'id',
	'license',
	[
		'attribute' => 'permission',
		'value' => PpidSetting::getPermission($model->permission),
	],
	[
		'attribute' => 'meta_description',
		'value' => $model->meta_description ? $model->meta_description : '-',
	],
	[
		'attribute' => 'meta_keyword',
		'value' => $model->meta_keyword ? $model->meta_keyword : '-',
	],
	[
		'attribute' => 'category_id',
		'value' => isset($model->category) ? $model->category->title->message : '-',
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
		'attribute' => '',
		'value' => Html::a(Yii::t('app', 'Update'), ['update', 'id'=>$model->primaryKey], ['title'=>Yii::t('app', 'Update'), 'class'=>'btn btn-primary']),
		'format' => 'html',
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