<?php
/**
 * AdminController
 * @var $this ommu\ppid\controllers\AdminController
 * @var $model ommu\ppid\models\Ppid
 *
 * AdminController implements the CRUD actions for Ppid model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Create
 *	Update
 *	View
 *	Delete
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 18:36 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

namespace ommu\ppid\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\ppid\models\Ppid;
use ommu\ppid\models\search\Ppid as PpidSearch;
use ommu\ppid\models\Articles;
use yii\helpers\ArrayHelper;
use app\components\widgets\ActiveForm;
use yii\web\UploadedFile;

class AdminController extends Controller
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
		return $this->redirect(['manage']);
	}

	/**
	 * Lists all Ppid models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new PpidSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$gridColumn = Yii::$app->request->get('GridColumn', null);
		$cols = [];
		if($gridColumn != null && count($gridColumn) > 0) {
			foreach($gridColumn as $key => $val) {
				if($gridColumn[$key] == 1)
					$cols[] = $key;
			}
		}
		$columns = $searchModel->getGridColumn($cols);

		if(($pic = Yii::$app->request->get('pic')) != null)
			$pic = \ommu\ppid\models\PpidPic::findOne($pic);

		$this->view->title = Yii::t('app', 'PPID Informations');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'pic' => $pic,
		]);
	}

	/**
	 * Creates a new Ppid model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Ppid();
		$article = new Articles();
		$setting = $article->getSetting(['media_file_type']);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$article->load(Yii::$app->request->post());
			$article->file = UploadedFile::getInstance($article, 'file');
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			$isValid = $model->validate();
			$isValid = $article->validate() && $isValid;

			if($isValid) {
				$article->save();
				$model->ppid_id = $article->id;
				if($model->save()) {
					Yii::$app->session->setFlash('success', Yii::t('app', 'PPID information success created.'));
					return $this->redirect(['manage']);
					//return $this->redirect(['view', 'id'=>$model->ppid_id]);
				}

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(ArrayHelper::merge(ActiveForm::validate($model), ActiveForm::validate($article)));
			}
		}

		$this->view->title = Yii::t('app', 'Create PPID Information');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
			'article' => $article,
			'setting' => $setting,
		]);
	}

	/**
	 * Updates an existing Ppid model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$article = Articles::findOne($model->ppid_id);
		$setting = $article->getSetting(['media_file_limit', 'media_file_type']);

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$article->load(Yii::$app->request->post());
			$article->file = UploadedFile::getInstance($article, 'file');
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			$isValid = $model->validate();
			$isValid = $article->validate() && $isValid;

			if($isValid) {
				if($model->save() && $article->save()) {
					Yii::$app->session->setFlash('success', Yii::t('app', 'PPID information success updated.'));
					return $this->redirect(['update', 'id'=>$model->ppid_id]);
				}

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Update PPID Information: {article-title}', ['article-title' => $model->article->title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
			'article' => $article,
			'setting' => $setting,
		]);
	}

	/**
	 * Displays a single Ppid model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$article = Articles::findOne($model->ppid_id);

		$this->view->title = Yii::t('app', 'Detail PPID Information: {article-title}', ['article-title' => $model->article->title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
			'article' => $article,
		]);
	}

	/**
	 * Deletes an existing Ppid model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->delete();

		Yii::$app->session->setFlash('success', Yii::t('app', 'PPID information success deleted.'));
		return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
	}

	/**
	 * Finds the Ppid model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Ppid the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = Ppid::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}