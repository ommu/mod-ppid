<?php
/**
 * m210825_195518_ppid_module_create_table_format
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2021 OMMU (www.ommu.id)
 * @created date 25 August 2021, 19:55 WIB
 * @link https://github.com/ommu/mod-ppid
 *
 */

use Yii;
use yii\db\Schema;

class m210825_195518_ppid_module_create_table_format extends \yii\db\Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$tableName = Yii::$app->db->tablePrefix . 'ommu_article_ppid_format';
		if (!Yii::$app->db->getTableSchema($tableName, true)) {
			$this->createTable($tableName, [
				'id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL AUTO_INCREMENT',
				'ppid_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED NOT NULL',
				'type' => Schema::TYPE_STRING . ' NOT NULL',
				'creation_date' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'trigger\'',
				'creation_id' => Schema::TYPE_INTEGER . '(11) UNSIGNED',
				'PRIMARY KEY ([[id]])',
				'CONSTRAINT ommu_article_ppid_format_ibfk_1 FOREIGN KEY ([[ppid_id]]) REFERENCES ommu_article_ppid ([[ppid_id]]) ON DELETE CASCADE ON UPDATE CASCADE',
			], $tableOptions);
		}
	}

	public function down()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_article_ppid_format';
		$this->dropTable($tableName);
	}
}
