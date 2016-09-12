<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table 'house'.
     */
    class m160819_134918_create_house_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%house}}', [
                'id'                    => $this->primaryKey(),
                'realty_id'             => $this->integer()
                                                ->defaultValue(null),
                'house_area'            => $this->float()
                                                ->notNull(),
                'land_area'             => $this->float()
                                                ->notNull(),
                'distance'              => $this->float()
                                                ->notNull(),
                'house_type'            => $this->string(10)
                                                ->notNull(),
                'communication_water'   => $this->string(50),
                'communication_electro' => $this->string(50),
                'communication_gas'     => $this->string(50),
                'communication_sewage'  => $this->string(50),
                'cover'                 => $this->string(255),
                'photos'                => $this->text(),
                'decor_inside'          => $this->string(150),
                'decor_outside'         => $this->string(150),
                'bath_count'            => $this->string(250),
            ]);

            $this->addForeignKey('nad_house_ibfk_1', '{{%house}}', 'realty_id', '{{%realty}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('nad_house_ibfk_1','{{%house}}');
            $this->dropTable('{{%house}}');
        }
    }
