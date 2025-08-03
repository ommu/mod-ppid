<?php
/**
 * PpidFormat
 *
 * This is the ActiveQuery class for [[\ommu\ppid\models\PpidFormat]].
 * @see \ommu\ppid\models\PpidFormat
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 19 June 2019, 18:22 WIB
 * @link https://github.com/ommu/mod-ppid
 *
 */

namespace ommu\ppid\models\query;

class PpidFormat extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\PpidFormat[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\PpidFormat|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
