<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table 'feedback'.
     */
    class m160819_134904_create_feedback_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%feedback}}', [
                'id'      => $this->primaryKey(),
                'name'    => $this->string(50),
                'email'   => $this->string(150),
                'subject' => $this->string(250),
                'body'    => $this->text(),
            ]);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%feedback}}');
        }
    }
