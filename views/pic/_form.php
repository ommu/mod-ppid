<?php
/**
 * Ppid Pics (ppid-pic)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\PicController
 * @var $model ommu\ppid\models\PpidPic
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 20 June 2019, 05:07 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
?>

<div class="ppid-pic-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'pic_name')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('pic_name')); ?>

<?php echo $form->field($model, 'pic_desc')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('pic_desc')); ?>

<?php echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>