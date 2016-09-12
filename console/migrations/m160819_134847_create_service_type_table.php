<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `service_type`.
     */
    class m160819_134847_create_service_type_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%service_type}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)
                               ->notNull()
            ]);

            $rows = [
                ['Продажа'],
                ['Аренда']
            ];
            $this->batchInsert('{{%service_type}}', ['name'], $rows);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%service_type}}');
        }
    }
