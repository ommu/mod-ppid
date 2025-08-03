<?php
/**
 * Ppid
 *
 * Ppid represents the model behind the search form about `ommu\ppid\models\Ppid`.
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 19 June 2019, 18:36 WIB
 * @link https://github.com/ommu/mod-ppid
 *
 */

namespace ommu\ppid\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\ppid\models\Ppid as PpidModel;

class Ppid extends PpidModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['ppid_id', 'pic_id', 'creation_id', 'modified_id', 'articleCatId'], 'integer'],
			[['release_year', 'retention', 'creation_date', 'modified_date', 'articleTitle', 'picName', 'creationDisplayname', 'modifiedDisplayname', 'format', 'publish'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Tambahkan fungsi beforeValidate ini pada model search untuk menumpuk validasi pd model induk. 
	 * dan "jangan" tambahkan parent::beforeValidate, cukup "return true" saja.
	 * maka validasi yg akan dipakai hanya pd model ini, semua script yg ditaruh di beforeValidate pada model induk
	 * tidak akan dijalankan.
	 */
	public function beforeValidate() {
		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $column=null)
	{
        if (!($column && is_array($column))) {
            $query = PpidModel::find()->alias('t');
        } else {
            $query = PpidModel::find()->alias('t')
                ->select($column);
        }
		$query->joinWith([
			'article article', 
			'article.category.title category', 
			'pic pic', 
			'creation creation', 
			'modified modified',
			'formats formats', 
		]);

		$query->groupBy(['ppid_id']);

        // add conditions that should always apply here
		$dataParams = [
			'query' => $query,
		];
        // disable pagination agar data pada api tampil semua
        if (isset($params['pagination']) && $params['pagination'] == 0) {
            $dataParams['pagination'] = false;
        }
		$dataProvider = new ActiveDataProvider($dataParams);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['articleCatId'] = [
			'asc' => ['category.message' => SORT_ASC],
			'desc' => ['category.message' => SORT_DESC],
		];
		$attributes['articleTitle'] = [
			'asc' => ['article.title' => SORT_ASC],
			'desc' => ['article.title' => SORT_DESC],
		];
		$attributes['pic_id'] = [
			'asc' => ['pic.pic_name' => SORT_ASC],
			'desc' => ['pic.pic_name' => SORT_DESC],
		];
		$attributes['picName'] = [
			'asc' => ['pic.pic_name' => SORT_ASC],
			'desc' => ['pic.pic_name' => SORT_DESC],
		];
		$attributes['creationDisplayname'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modifiedDisplayname'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$attributes['format'] = [
			'asc' => ['formats.type' => SORT_ASC],
			'desc' => ['formats.type' => SORT_DESC],
		];
		$attributes['publish'] = [
			'asc' => ['article.publish' => SORT_ASC],
			'desc' => ['article.publish' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['ppid_id' => SORT_DESC],
		]);

        if (Yii::$app->request->get('ppid_id')) {
            unset($params['ppid_id']);
        }
		$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		// grid filtering conditions
		$query->andFilterWhere([
			't.ppid_id' => $this->ppid_id,
			't.pic_id' => isset($params['pic']) ? $params['pic'] : $this->pic_id,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
			'formats.type' => $this->format,
			'article.publish' => $this->publish,
			'article.cat_id' => $this->articleCatId,
		]);

		$query->andFilterWhere(['like', 't.release_year', $this->release_year])
			->andFilterWhere(['like', 't.retention', $this->retention])
			->andFilterWhere(['like', 'article.title', $this->articleTitle])
			->andFilterWhere(['like', 'pic.pic_name', $this->picName])
			->andFilterWhere(['like', 'creation.displayname', $this->creationDisplayname])
			->andFilterWhere(['like', 'modified.displayname', $this->modifiedDisplayname]);

		return $dataProvider;
	}
}
