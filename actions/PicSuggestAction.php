<?php
/**
 * PicSuggestAction
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 20 June 2019, 05:23 WIB
 * @link https://bitbucket.org/ommu/ppid
 */

namespace ommu\ppid\actions;

use Yii;
use ommu\ppid\models\PpidPic;

class PicSuggestAction extends \yii\base\Action
{
	/**
	 * {@inheritdoc}
	 */
	protected function beforeRun()
	{
		if (parent::beforeRun()) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			Yii::$app->response->charset = 'UTF-8';
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function run()
	{
		$term = Yii::$app->request->get('term');

		if($term == null) return [];

		$model = PpidPic::find()
			->alias('t')
			->suggest()
			->andWhere(['like', 't.pic_name', $term])
			->limit(15)
			->all();

		$result = [];
		foreach($model as $val) {
			$result[] = [
				'id' => $val->id, 
				'label' => $val->pic_name,
			];
		}
		return $result;
	}
}