<?php
/**
 * Ppid
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 18:13 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

namespace ommu\ppid\models;

use Yii;

class Articles extends \ommu\article\models\Articles
{
	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			$this->body = '-';
			$this->clearErrors('image');
		}

		return true;
	}
}
