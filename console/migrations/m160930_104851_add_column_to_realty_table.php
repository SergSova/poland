<?php

    use yii\db\Migration;

    class m160930_104851_add_column_to_realty_table extends Migration{
        public function up(){
            $this->addColumn('{{%realty}}', 'create_at', $this->integer());
            $this->addColumn('{{%realty}}', 'update_at', $this->integer());
        }

        public function down(){
            $this->dropColumn('{{%realty}}', 'create_at');
            $this->dropColumn('{{%realty}}', 'update_at');
        }

    }
