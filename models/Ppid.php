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
use yii\helpers\ArrayHelper;
use ommu\article\models\ArticleCategory;
use yii\base\Event;

class Ppid extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname'];

	public $articleCatId;
	public $articleTitle;
	public $picName;
	public $creationDisplayname;
	public $modifiedDisplayname;
	public $format;
	public $publish;
	public $filter;

	const EVENT_BEFORE_SAVE_PPIDS = 'BeforeSavePpids';

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
			[['pic_id'], 'required'],
			[['ppid_id', 'creation_id', 'modified_id'], 'integer'],
			[['ppid_id'], 'unique'],
			[['ppid_id', 'release_year', 'retention', 'format'], 'safe'],
			[['release_year'], 'string', 'max' => 32],
			[['retention'], 'string', 'max' => 64],
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
			'articleCatId' => Yii::t('app', 'Category'),
			'articleTitle' => Yii::t('app', 'Information Title'),
			'picName' => Yii::t('app', 'Person In Charge'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'format' => Yii::t('app', 'Format'),
			'publish' => Yii::t('app', 'Publish'),
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
	public function getFormats($result=false, $val='id')
	{
		if($result == true)
			return \yii\helpers\ArrayHelper::map($this->formats, 'type', 'id');

		return $this->hasMany(PpidFormat::className(), ['ppid_id' => 'ppid_id']);
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
		$this->templateColumns['articleCatId'] = [
			'attribute' => 'articleCatId',
			'value' => function($model, $key, $index, $column) {
				return isset($model->article) ? $model->article->category->title->message : '-';
				// return $model->articleCatId;
			},
			'filter' => ArticleCategory::getCategory(1),
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
			// 'filter' => Ppid::getFilter('release'),
		];
		$this->templateColumns['retention'] = [
			'attribute' => 'retention',
			'value' => function($model, $key, $index, $column) {
				return $model->retention;
			},
			// 'filter' => Ppid::getFilter('retention'),
		];
		$this->templateColumns['format'] = [
			'attribute' => 'format',
			'value' => function($model, $key, $index, $column) {
				return self::parseFormat(array_flip($model->getFormats(true)), ', ');
			},
			'filter' => PpidFormat::getType(),
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
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'value' => function($model, $key, $index, $column) {
					return  $this->filterYesNo($model->article->publish);
				},
				'filter' => $this->filterYesNo(),
				'contentOptions' => ['class'=>'center'],
				'format' => 'raw',
			];
		}
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
	 * User get information
	 */
	public static function getFilter($filter='release')
	{
		$model = self::find();
		if($filter == 'release')
			$model->filterRelease();
		else if($filter == 'retention')
			$model->filterRetention();
		
		$model = $model->all();

		return ArrayHelper::map($model, 'filter', 'filter');
	}

	/**
	 * function parseRelated
	 */
	public static function parseFormat($format, $sep='li')
	{
		if(!is_array($format) || (is_array($format) && empty($format)))
			return '-';

		$formats = PpidFormat::getType();
		$items = [];
		foreach ($format as $val) {
			if(array_key_exists($val, $formats))
				$items[] = $formats[$val];
		}

		if($sep == 'li') {
			return Html::ul($items, ['item' => function($item, $index) {
				return Html::tag('li', $item);
			}, 'class'=>'list-boxed']);
		}

		return implode($sep, $items);
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->articleCatId = isset($this->article) ? $model->article->category->title->message : '-';
		// $this->articleTitle = isset($this->article) ? $model->article->title : '-';
		// $this->picName = isset($this->pic) ? $this->pic->pic_name : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
		$this->format = array_flip($this->getFormats(true));
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

	/**
	 * before save attributes
	 */
	public function beforeSave($insert)
	{
		parent::beforeSave($insert);

		// insert new person in charge
		if(!isset($this->pic)) {
			$model = new PpidPic();
			$model->pic_name = $this->pic_id;
			if($model->save())
				$this->pic_id = $model->id;
		}
		
		if(!$insert) {
			// set ppid format
			$event = new Event(['sender' => $this]);
			Event::trigger(self::className(), self::EVENT_BEFORE_SAVE_PPIDS, $event);
		}

		return true;
	}

	/**
	 * After save attributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		
		if($insert) {
			// set ppid format
			$event = new Event(['sender' => $this]);
			Event::trigger(self::className(), self::EVENT_BEFORE_SAVE_PPIDS, $event);

		}
	}
}
