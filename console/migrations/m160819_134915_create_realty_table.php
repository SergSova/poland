<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table `realty`.
     */
    class m160819_134915_create_realty_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%realty}}', [
                'id'              => $this->primaryKey(),
                'realty_type_id'  => $this->integer(),
                'service_type_id' => $this->integer(),
                'district_id'     => $this->integer(),
                'price'           => $this->integer()
                                          ->notNull(),
                'address'         => $this->string(255)
                                          ->notNull(),
                'map_coord'       => $this->string(255)
                                          ->notNull(),
                'short_description'     => $this->text()
                                          ->notNull(),
                'full_description'     => $this->text()
                                          ->notNull(),
                'status'          => "enum('active','inactive','sale','deposit') NOT NULL DEFAULT 'active'"
            ]);

            $this->addForeignKey('nad_realty_ibfk_1', '{{%realty}}', 'realty_type_id', '{{%realty_type}}', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('nad_realty_ibfk_2', '{{%realty}}', 'service_type_id', '{{%service_type}}', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('nad_realty_ibfk_3', '{{%realty}}', 'district_id', '{{%district}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('nad_realty_ibfk_1', '{{%realty}}');
            $this->dropForeignKey('nad_realty_ibfk_2', '{{%realty}}');
            $this->dropForeignKey('nad_realty_ibfk_3', '{{%realty}}');
            $this->dropTable('{{%realty}}');
        }
    }
