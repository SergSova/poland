<?php

use yii\db\Migration;

/**
 * Handles the creation for table `action`.
 */
class m160919_065244_create_action_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%action}}', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(150)->notNull()->unique()->comment('Название'),
            'name'=>$this->string(50)->notNull(),
            'icon'=>$this->string()->defaultValue('')->comment('Иконка'),
            'date_start'=>$this->integer()->notNull()->comment('Дата начала'),
            'date_end'=>$this->integer()->notNull()->comment('Дата окончания'),
            'value'=>$this->string()->notNull()->comment('Значение'),
            'status'=>'ENUM("active", "inactive", "blocked")',
            'create_at'          => $this->integer(),
            'update_at'          => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%action}}');
    }
}
