<?php
/**
 * PpidFormat
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 19 June 2019, 18:22 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 * This is the model class for table "ommu_article_ppid_format".
 *
 * The followings are the available columns in table "ommu_article_ppid_format":
 * @property integer $id
 * @property integer $ppid_id
 * @property string $type
 * @property string $creation_date
 * @property integer $creation_id
 *
 * The followings are the available model relations:
 * @property Ppid $pp
 * @property Users $creation
 *
 */

namespace ommu\ppid\models;

use Yii;
use ommu\users\models\Users;

class PpidFormat extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	public $articleTitle;
	public $creationDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_article_ppid_format';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['ppid_id', 'type'], 'required'],
			[['ppid_id', 'creation_id'], 'integer'],
			[['type'], 'string'],
			[['ppid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ppid::className(), 'targetAttribute' => ['ppid_id' => 'ppid_id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'ppid_id' => Yii::t('app', 'Ppid'),
			'type' => Yii::t('app', 'Type'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'articleTitle' => Yii::t('app', 'Information Title'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPpid()
	{
		return $this->hasOne(Ppid::className(), ['ppid_id' => 'ppid_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\query\PpidFormat the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\ppid\models\query\PpidFormat(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		if(!$this->hasMethod('search'))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['articleTitle'] = [
			'attribute' => 'articleTitle',
			'value' => function($model, $key, $index, $column) {
				return isset($model->ppid) ? $model->ppid->article->title : '-';
				// return $model->articleTitle;
			},
			'visible' => !Yii::$app->request->get('ppid') ? true : false,
		];
		$this->templateColumns['type'] = [
			'attribute' => 'type',
			'value' => function($model, $key, $index, $column) {
				return self::getType($model->type);
			},
			'filter' => self::getType(),
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		$this->templateColumns['creationDisplayname'] = [
			'attribute' => 'creationDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->creation) ? $model->creation->displayname : '-';
				// return $model->creationDisplayname;
			},
			'visible' => !Yii::$app->request->get('creation') ? true : false,
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
			$model = $model->where(['id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getType
	 */
	public static function getType($value=null)
	{
		$items = array(
			'hard' => Yii::t('app', 'Hardcopy'),
			'soft' => Yii::t('app', 'Softcopy'),
		);

		if($value !== null)
			return $items[$value];
		else
			return $items;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->articleTitle = isset($this->ppid) ? $this->ppid->article->title : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
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
			}
		}
		return true;
	}
}
