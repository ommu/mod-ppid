<?php
/**
 * Ppid Pics (ppid-pic)
 * @var $this app\components\View
 * @var $this ommu\ppid\controllers\PicController
 * @var $model ommu\ppid\models\PpidPic
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 20 June 2019, 05:07 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PPID'), 'url' => ['setting/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PIC'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="ppid-pic-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
