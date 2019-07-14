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

<?php echo $this->renderWidget('/pic/admin_manage', [
	'contentMenu' => true,
	'searchModel' => $searchModel,
	'dataProvider' => $dataProvider,
	'columns' => $columns,
]); ?>

<?php echo $this->renderWidget(!$model->isNewRecord ? 'admin_view' : 'admin_update', [
	'contentMenu' => true,
	'model'=>$model,
]); ?>