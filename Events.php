<?php
/**
 * Events class
 *
 * Menangani event-event yang ada pada modul ppid.
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 20 June 2019, 18:13 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

namespace ommu\ppid;

use Yii;
use ommu\ppid\models\PpidFormat;

class Events extends \yii\base\BaseObject
{
	/**
	 * {@inheritdoc}
	 */
	public static function onBeforeSavePpids($event)
	{
		$ppid = $event->sender;

		self::setPpidFormat($ppid);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function setPpidFormat($ppid)
	{
		$oldFormat = array_flip($ppid->getFormats(true));
		$format = $ppid->format;

		// insert difference format
        if (is_array($format)) {
			foreach ($format as $val) {
                if (in_array($val, $oldFormat)) {
					unset($oldFormat[array_keys($oldFormat, $val)[0]]);
					continue;
				}

				$model = new PpidFormat();
				$model->ppid_id = $ppid->ppid_id;
				$model->type = $val;
				$model->save();
			}
		}

		// drop difference format
        if (!empty($oldFormat)) {
			foreach ($oldFormat as $key => $val) {
				PpidFormat::findOne($key)->delete();
			}
		}
	}
}
