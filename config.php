<?php
/**
 * ppid module config
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 19 June 2019, 17:36 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use ommu\ppid\Events;
use ommu\ppid\models\Ppid;

return [
	'id' => 'ppid',
	'class' => ommu\ppid\Module::className(),
	'events' => [
		[
			'class'    => Ppid::className(),
			'event'    => Ppid::EVENT_BEFORE_SAVE_PPIDS,
			'callback' => [Events::className(), 'onBeforeSavePpids']
		],
	],
];