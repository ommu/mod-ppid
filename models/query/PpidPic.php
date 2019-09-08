<?php
/**
 * PpidPic
 *
 * This is the ActiveQuery class for [[\ommu\ppid\models\PpidPic]].
 * @see \ommu\ppid\models\PpidPic
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 18:23 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

namespace ommu\ppid\models\query;

class PpidPic extends \yii\db\ActiveQuery
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
	public function published() 
	{
		return $this->andWhere(['t.publish' => 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unpublish() 
	{
		return $this->andWhere(['t.publish' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deleted() 
	{
		return $this->andWhere(['t.publish' => 2]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function suggest() 
	{
		return $this->select(['id', 'pic_name'])
			->published();
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\PpidPic[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\ppid\models\PpidPic|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
