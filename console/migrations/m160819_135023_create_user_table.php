<?php

    use yii\db\Migration;

    /**
     * Handles the creation for table 'user'.
     */
    class m160819_135023_create_user_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable('{{%user}}', [
                'id'                   => $this->primaryKey(),
                'username'             => $this->string(50)
                                               ->unique(),
                'password_hash'        => $this->string(255),
                'password_reset_token' => $this->string(255),
                'email'                => $this->string(255)
                                               ->unique(),
                'auth_key'             => $this->string(255),
                'status'               => $this->integer()
                                               ->defaultValue(null),
                'created_at'           => $this->integer(),
                'updated_at'           => $this->integer(),
                'password'             => $this->string(255),
            ]);


            $this->addForeignKey('FK_realty_author', '{{%realty}}', 'author_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

            //example row change in to web admin password '123'
            $this->insert('{{%user}}', [
                'username'      => 'admin',
                'password_hash' => '$2y$13$vzXxPWWU//GH8X2w7fvcL.G8ua0pnnfP.C2P7PioPjnjTCZMIdntW',
                'email'         => 'admin@example.ru',
                'created_at'    => 1,
                'updated_at'    => 1,
                'status'        => 10,
                'password'      => '123',
            ]);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_realty_author', '{{%realty}}');
            $this->dropTable('{{%user}}');
        }
    }
