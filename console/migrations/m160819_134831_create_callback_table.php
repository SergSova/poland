<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table 'callback'.
     */
    class m160819_134831_create_callback_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%callback}}', [
                'id'      => $this->primaryKey(),
                'name'    => $this->string(50),
                'subject' => $this->string(50),
                'phone'   => $this->string(25),
                'create_at'          => $this->integer(),
                'update_at'          => $this->integer(),
            ]);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%callback}}');
        }
    }
