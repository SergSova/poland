<?php

    use yii\db\Migration;

    class m160931_104851_add_column_to_action_table extends Migration{
        public function up(){
            $this->addColumn('{{%action}}', 'create_at', $this->integer());
            $this->addColumn('{{%action}}', 'update_at', $this->integer());
        }

        public function down(){
            $this->dropColumn('{{%action}}', 'create_at');
            $this->dropColumn('{{%action}}', 'update_at');
        }

    }
