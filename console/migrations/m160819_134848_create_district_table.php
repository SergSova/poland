<?php

use yii\db\Migration;

/**
 * Handles the creation for table `district`.
 */
class m160819_134848_create_district_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%district}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(255)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%district}}');
    }
}
