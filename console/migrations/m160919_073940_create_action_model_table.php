<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `action_model`.
     */
    class m160919_073940_create_action_model_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%action_model}}', [
                'id' => $this->primaryKey(),
                'model_id' => $this->integer()
                                   ->notNull(),
                'action_id' => $this->integer()
                                    ->notNull()
            ]);

            $this->addForeignKey('FK_action_model_action', '{{%action_model}}', 'action_id', '{{%action}}', 'id');
            $this->addForeignKey('FK_action_model_model', '{{%action_model}}', 'model_id', '{{%realty}}', 'id');
            $this->createIndex('IX_action_model', '{{%action_model}}', [
                'model_id',
                'action_id'
            ], true);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%action_model}}');
        }
    }
