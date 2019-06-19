<?php
/**
 * Ppid
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 18:24 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 * This is the model class for table "ommu_article_ppid".
 *
 * The followings are the available columns in table "ommu_article_ppid":
 * @property integer $ppid_id
 * @property integer $pic_id
 * @property string $release_year
 * @property string $retention
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property Articles $article
 * @property PpidPic $pic
 * @property PpidFormat[] $formats
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\ppid\models;

use Yii;
use yii\helpers\Html;
use ommu\users\models\Users;
use ommu\ppid\models\Articles;

class Ppid extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = ['creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname'];

	public $articleTitle;
	public $picName;
	public $creationDisplayname;
	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_article_ppid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['ppid_id', 'pic_id', 'release_year', 'retention'], 'required'],
			[['ppid_id', 'pic_id', 'creation_id', 'modified_id'], 'integer'],
			[['release_year'], 'string', 'max' => 32],
			[['retention'], 'string', 'max' => 64],
			[['ppid_id'], 'unique'],
			[['pic_id'], 'exist', 'skipOnError' => true, 'targetClass' => PpidPic::className(), 'targetAttribute' => ['pic_id' => 'id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'ppid_id' => Yii::t('app', 'Ppid'),
			'pic_id' => Yii::t('app', 'Person In Charge'),
			'release_year' => Yii::t('app', 'Release Year'),
			'retention' => Yii::t('app', 'Retention'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'formats' => Yii::t('app', 'Formats'),
			'articleTitle' => Yii::t('app', 'Information Title'),
			'picName' => Yii::t('app', 'Person In Charge'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getArticle()
	{
		return $this->hasOne(Articles::className(), ['id' => 'ppid_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPic()
	{
		return $this->hasOne(PpidPic::className(), ['id' => 'pic_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFormats($count=false)
	{
		if($count == false)
			return $this->hasMany(PpidFormat::className(), ['ppid_id' => 'ppid_id']);

		$model = PpidFormat::find()
			->where(['ppid_id' => $this->ppid_id]);
		$formats = $model->count();

		return $formats ? $formats : 0;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\query\Ppid the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\ppid\models\query\Ppid(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['articleTitle'] = [
			'attribute' => 'articleTitle',
			'label' => Yii::t('app', 'Information'),
			'value' => function($model, $key, $index, $column) {
				return isset($model->article) ? $model->article->title : '-';
				// return $model->articleTitle;
			},
		];
		if(!Yii::$app->request->get('pic')) {
			$this->templateColumns['pic_id'] = [
				'attribute' => 'pic_id',
				'label' => Yii::t('app', 'PIC'),
				'value' => function($model, $key, $index, $column) {
					return isset($model->pic) ? $model->pic->pic_name : '-';
					// return $model->picName;
				},
				'filter' => PpidPic::getPic(),
			];
		}
		$this->templateColumns['release_year'] = [
			'attribute' => 'release_year',
			'label' => Yii::t('app', 'Release'),
			'value' => function($model, $key, $index, $column) {
				return $model->release_year;
			},
		];
		$this->templateColumns['retention'] = [
			'attribute' => 'retention',
			'value' => function($model, $key, $index, $column) {
				return $model->retention;
			},
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creationDisplayname'] = [
				'attribute' => 'creationDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
					// return $model->creationDisplayname;
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modifiedDisplayname'] = [
				'attribute' => 'modifiedDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
					// return $model->modifiedDisplayname;
				},
			];
		}
		$this->templateColumns['formats'] = [
			'attribute' => 'formats',
			'value' => function($model, $key, $index, $column) {
				$formats = $model->getFormats(true);
				return Html::a($formats, ['format/manage', 'ppid'=>$model->primaryKey], ['title'=>Yii::t('app', '{count} formats', ['count'=>$formats])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['ppid_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->articleTitle = isset($this->article) ? $model->article->title : '-';
		// $this->picName = isset($this->pic) ? $this->pic->pic_name : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			} else {
				if($this->modified_id == null)
					$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}
		}
		return true;
	}
}
