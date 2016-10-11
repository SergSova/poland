<?php

    use yii\db\Migration;

    class m160913_122455_create_service_table extends Migration{
        public function up(){
            $this->createTable('{{%service}}', [
                'id' => $this->primaryKey(),
                'title' => $this->string()
                                ->notNull()->comment('Название'),
                'description' => $this->text()
                                           ->notNull()->comment('Описание'),
                'icon' => $this->string()->defaultValue('service/icon-serv2.png'),
                'create_at'          => $this->integer(),
                'update_at'          => $this->integer(),

            ]);

        }

        public function down(){
            $this->dropTable('{{%service}}');
        }
    }
