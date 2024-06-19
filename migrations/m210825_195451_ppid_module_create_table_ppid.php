<?php
/**
 * m210825_195451_ppid_module_create_table_ppid
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 25 August 2021, 19:55 WIB
 * @link https://bitbucket.org/ommu/ppid
 *
 */

use Yii;
use yii\db\Schema;

class m210825_195451_ppid_module_create_table_ppid extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_article_ppid';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'ppid_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
				'pic_id' => Schema::TYPE_SMALLINT . '(5) UNSIGNED',
				'release_year' => Schema::TYPE_STRING . '(32) NOT NULL',
				'retention' => Schema::TYPE_STRING . '(64) NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'modified_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'trigger,on_update\'',
				'modified_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[ppid_id]])',
				'CONSTRAINT ommu_article_ppid_ibfk_1 FOREIGN KEY ([[pic_id]]) REFERENCES ommu_article_ppid_pic ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
			], $tableOptions);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_article_ppid';
		$this->dropTable($tableName);
	}
}
