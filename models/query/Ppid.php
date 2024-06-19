<?php
/**
 * Ppid
 *
 * This is the ActiveQuery class for [[\ommu\ppid\models\Ppid]].
 * @see \ommu\ppid\models\Ppid
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 19 June 2019, 18:24 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

namespace ommu\ppid\models\query;

class Ppid extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 */
	public function filterRelease()
	{
		return $this->select(['ppid_id', 'release_year as filter'])
			->andWhere(['<>', 'release_year', ''])
			->groupBy(['release_year']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function filterRetention()
	{
		return $this->select(['ppid_id', 'retention as filter'])
			->andWhere(['<>', 'retention', ''])
			->groupBy(['retention']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\Ppid[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\Ppid|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
