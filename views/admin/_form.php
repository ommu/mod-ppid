<?php
/**
 * Ppids (ppid)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\AdminController
 * @var $model ommu\ppid\models\Ppid
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 19 June 2019, 18:36 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use ommu\ppid\models\PpidPic;
use ommu\ppid\models\PpidFormat;
use ommu\selectize\Selectize;
use yii\helpers\ArrayHelper;
use ommu\article\models\ArticleCategory;
use ommu\ppid\models\Ppid;
use ommu\ppid\models\Articles;
use ommu\ppid\models\PpidSetting;
?>

<div class="ppid-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php // echo $form->errorSummary($model);?>
<?php // echo $form->errorSummary($article);?>

<?php $category = ArticleCategory::getCategory(1, PpidSetting::getInfo('category_id'));
echo $form->field($article, 'cat_id')
	->dropDownList($category, ['prompt'=>''])
	->label($article->getAttributeLabel('cat_id')); ?>

<?php echo $form->field($article, 'title')
	->textInput(['maxlength'=>true])
	->label($article->getAttributeLabel('title')); ?>

<?php echo $form->field($model, 'pic_id')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a person in charge..'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a person in charge..')], PpidPic::getPic()),
		'pluginOptions' => [
			'persist' => false,
			'createOnBlur' => false,
			'create' => true,
		],
	])
	->label($model->getAttributeLabel('pic_id')); ?>

<?php echo $form->field($model, 'release_year')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a release year..'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a release year..')], Ppid::getFilter('release')),
		'pluginOptions' => [
			'persist' => false,
			'createOnBlur' => false,
			'create' => true,
		],
	])
	->label($model->getAttributeLabel('release_year')); ?>

<?php echo $form->field($model, 'retention')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a retention..'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a retention..')], Ppid::getFilter('retention')),
		'pluginOptions' => [
			'persist' => false,
			'createOnBlur' => false,
			'create' => true,
		],
	])
	->label($model->getAttributeLabel('retention')); ?>

<?php $uploadPath = join('/', [Articles::getUploadPath(false), $article->id]);
$file = !$article->isNewRecord && $article->document ? Html::a($article->document, Url::to(join('/', ['@webpublic', $uploadPath, $article->document])), ['title'=>$article->document, 'target'=>'_blank', 'class'=>'d-inline-block mb-3']) : '';
echo $form->field($article, 'file', ['template' => '{label}{beginWrapper}<div>'.$file.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($article->getAttributeLabel('file'))
	->hint(Yii::t('app', 'extensions are allowed: {extensions}', ['extensions'=>$setting->media_file_type])); ?>

<?php echo $form->field($model, 'format')
	->widget(Selectize::className(), [
		'items' => PpidFormat::getType(),
		'options' => [
			'multiple' => true,
		],
		'pluginOptions' => [
			'plugins' => ['remove_button'],
		],
	])
	->label($model->getAttributeLabel('format')); ?>

<?php if($model->isNewRecord && !$model->getErrors())
	$article->publish = 1;
echo $form->field($article, 'publish')
	->checkbox()
	->label($article->getAttributeLabel('publish')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>