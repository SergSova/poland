<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table 'apartment'.
     */
    class m160819_134753_create_apartment_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%apartment}}', [
                'id'                => $this->primaryKey()->unique(),
                'realty_id'         => $this->integer()
                                            ->defaultValue(null),
                'house_year'        => 'year(4) NOT NULL',
                'house_material'    => $this->string(50)
                                            ->defaultValue(null),
                'house_floor_count' => $this->integer()
                                            ->notNull(),
                'room_count'        => $this->integer()
                                            ->notNull(),
                'bathroom_type'     => 'enum(\'separated\',\'combined\') NOT NULL',
                'area'              => $this->float()
                                            ->notNull(),
                'floor'             => $this->integer()
                                            ->notNull(),
                'rooms_area'        => $this->string(255),
                'balcony'           => $this->string(255),
                'kitchen_area'      => $this->integer()
                                            ->defaultValue(null),
                'cover'             => $this->string(255),
                'photos'            => $this->text()
            ]);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%apartment}}');
        }
    }
