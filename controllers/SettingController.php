<?php
/**
 * SettingController
 * @var $this ommu\ppid\controllers\SettingController
 * @var $model ommu\ppid\models\PpidSetting
 *
 * SettingController implements the CRUD actions for PpidSetting model.
 * Reference start
 * TOC :
 *	Index
 *	Update
 *	Delete
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 20 June 2019, 21:29 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

namespace ommu\ppid\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\ppid\models\PpidSetting;

class SettingController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
		$model = PpidSetting::findOne(1);
		if($model == null)
			return $this->redirect(['update']);

		$this->view->title = Yii::t('app', 'PPID Settings');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_index', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing PpidSetting model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionUpdate()
	{
		$model = PpidSetting::findOne(1);
		if($model == null)
			$model = new PpidSetting(['id'=>1]);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Ppid setting success updated.'));
				return $this->redirect(['update']);
				//return $this->redirect(['view', 'id'=>$model->id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'PPID Settings');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing PpidSetting model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->delete();

		Yii::$app->session->setFlash('success', Yii::t('app', 'Ppid setting success deleted.'));
		return $this->redirect(['index']);
	}

	/**
	 * Finds the PpidSetting model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return PpidSetting the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = PpidSetting::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}