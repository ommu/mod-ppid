<?php
/**
 * Ppid Settings (ppid-setting)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\SettingController
 * @var $model ommu\ppid\models\PpidSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 20 June 2019, 21:29 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Url;

if($breadcrumb) {
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PPID'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
}

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Reset'), 'url' => Url::to(['delete']), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to reset this setting?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
?>

<div class="ppid-setting-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>