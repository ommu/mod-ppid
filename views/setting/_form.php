<?php
/**
 * Ppid Settings (ppid-setting)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\SettingController
 * @var $model ommu\ppid\models\PpidSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 20 June 2019, 21:29 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\article\models\ArticleCategory;
?>

<div class="ppid-setting-form">

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

<?php if($model->isNewRecord && !$model->getErrors())
	$model->license = $model->licenseCode();
echo $form->field($model, 'license')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('license'))
	->hint(Yii::t('app', 'Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please contact support team.').'<br/>'.Yii::t('app', 'Format: XXXX-XXXX-XXXX-XXXX')); ?>

<?php $permission = $model::getPermission();
echo $form->field($model, 'permission', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($permission)
	->label($model->getAttributeLabel('permission'))
	->hint(Yii::t('app', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles, Blogs, and Albums), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here. For more permissions settings, please visit the General Settings page.')); ?>

<?php echo $form->field($model, 'meta_description')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('meta_description')); ?>

<?php echo $form->field($model, 'meta_keyword')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('meta_keyword')); ?>

<?php $category = ArticleCategory::getCategory();
echo $form->field($model, 'category_id')
	->dropDownList($category, ['prompt'=>''])
	->label($model->getAttributeLabel('category_id')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>