<?php
/**
 * m210825_200748_ppid_module_insert_menu
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 25 August 2021, 04:25 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use Yii;
use mdm\admin\components\Configs;
use app\models\Menu;

class m210825_200748_ppid_module_insert_menu extends \yii\db\Migration
{
	public function up()
	{
        $menuTable = Configs::instance()->menuTable;
		$tableName = Yii::$app->db->tablePrefix . $menuTable;

        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['PPID', 'ppid', null, Menu::getParentId('Publications#rbac'), '/ppid/admin/index', null, null],
				['PPID Settings', 'ppid', null, Menu::getParentId('Settings#rbac'), '/ppid/setting/index', null, null],
			]);
		}
	}
}
