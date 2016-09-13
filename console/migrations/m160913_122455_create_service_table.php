<?php

    use yii\db\Migration;

    class m160913_122455_create_service_table extends Migration{
        public function up(){
            $this->createTable('{{%service}}', [
                                                 'id' => $this->primaryKey(),
                                                 'title' => $this->string(),
                                                 'short_description' => $this->text(),
                                                 'full_description' => $this->text(),
                                                 'icon' => $this->string(),
                                             ]);
        }

        public function down(){
            $this->dropTable('{{%service}}');
        }
    }
