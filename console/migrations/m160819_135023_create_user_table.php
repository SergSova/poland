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
                'username'             => $this->string(50)->unique(),
                'password_hash'        => $this->string(255),
                'password_reset_token' => $this->string(255),
                'email'                => $this->string(255)->unique(),
                'auth_key'             => $this->string(255),
                'status'               => $this->integer()
                                               ->defaultValue(null),
                'created_at'           => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                'updated_at'           => $this->integer()
                                               ->notNull(),
                'password'             => $this->string(255),
            ]);

        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable('{{%user}}');
        }
    }
