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
                'id'                => $this->primaryKey(),
                'author_id'         => $this->integer(),
                'realty_type_id'    => $this->integer(),
                'service_type_id'   => $this->integer(),
                'district_id'       => $this->integer(),
                'price'             => $this->integer()
                                            ->notNull(),
                'address'           => $this->string(255)
                                            ->notNull(),
                'map_coord'         => $this->string(255)
                                            ->notNull(),
                'short_description' => $this->text()
                                            ->notNull(),
                'full_description'  => $this->text()
                                            ->notNull(),
                'status'            => "enum('active','inactive','sale','deposit') NOT NULL DEFAULT 'active'",
                'create_at'         => $this->integer(),
                'update_at'         => $this->integer(),
            ]);

            $this->addForeignKey('FK_realty_realty_type', '{{%realty}}', 'realty_type_id', '{{%realty_type}}', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('FK_realty_service_type', '{{%realty}}', 'service_type_id', '{{%service_type}}', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('FK_realty_district', '{{%realty}}', 'district_id', '{{%district}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_realty_realty_type', '{{%realty}}');
            $this->dropForeignKey('FK_realty_service_type', '{{%realty}}');
            $this->dropForeignKey('FK_realty_district', '{{%realty}}');
            $this->dropTable('{{%realty}}');
        }
    }
