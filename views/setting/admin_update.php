<?php
/**
 * Ppid Settings (ppid-setting)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\SettingController
 * @var $model ommu\ppid\models\PpidSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 20 June 2019, 21:29 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ppid-setting-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>