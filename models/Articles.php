<?php
/**
 * Ppid
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 19 June 2019, 18:13 WIB
 * @link https://github.com/ommu/mod-ppid
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
        if (parent::beforeValidate()) {
			$this->body = '-';
			$this->clearErrors('image');
		}

		return true;
	}
}
