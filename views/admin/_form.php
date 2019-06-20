<?php
/**
 * Ppids (ppid)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\AdminController
 * @var $model ommu\ppid\models\Ppid
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 18:36 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\ppid\models\PpidPic;
use ommu\ppid\models\PpidFormat;
use ommu\selectize\Selectize;
use yii\helpers\ArrayHelper;
?>

<div class="ppid-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

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
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('release_year')); ?>

<?php echo $form->field($model, 'retention')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('retention')); ?>

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

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>