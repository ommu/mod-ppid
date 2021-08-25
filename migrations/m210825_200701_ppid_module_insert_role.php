<?php
/**
 * m210825_200701_ppid_module_insert_role
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 25 August 2021, 20:07 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use Yii;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m210825_200701_ppid_module_insert_role extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

	public function up()
	{
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;

        // route
		$tableName = Yii::$app->db->tablePrefix . $authManager->itemTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'type', 'data', 'created_at'], [
				['ppidModLevelAdmin', '2', '', time()],
				['ppidModLevelModerator', '2', '', time()],
				['/ppid/admin/*', '2', '', time()],
				['/ppid/admin/index', '2', '', time()],
				['/ppid/pic/*', '2', '', time()],
				['/ppid/pic/index', '2', '', time()],
				['/ppid/setting/index', '2', '', time()],
				['/ppid/setting/update', '2', '', time()],
				['/ppid/setting/delete', '2', '', time()],
			]);
		}

		$tableName = Yii::$app->db->tablePrefix . $authManager->itemChildTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
            // permission
			$this->batchInsert($tableName, ['parent', 'child'], [
				['ppidModLevelAdmin', 'ppidModLevelModerator'],
				['ppidModLevelAdmin', '/ppid/setting/update'],
				['ppidModLevelAdmin', '/ppid/setting/delete'],
				['ppidModLevelModerator', '/ppid/setting/index'],
				['ppidModLevelModerator', '/ppid/admin/*'],
				['ppidModLevelModerator', '/ppid/pic/*'],
			]);

            // role
			$this->batchInsert($tableName, ['parent', 'child'], [
				['userAdmin', 'ppidModLevelAdmin'],
				['userModerator', 'ppidModLevelModerator'],
			]);
		}
	}
}
