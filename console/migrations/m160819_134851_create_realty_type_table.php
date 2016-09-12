<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `realty_type`.
     */
    class m160819_134851_create_realty_type_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%realty_type}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)
                               ->notNull(),
                'realty_table' => $this->string(50)
                                       ->notNull()
                                       ->unique()
            ]);
            $rows = [
                ['Дом','house'],
                ['Квартира','apartment']
            ];
            $this->batchInsert('{{%realty_type}}', [
                'name',
                'realty_table'
            ], $rows);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%realty_type}}');
        }
    }
