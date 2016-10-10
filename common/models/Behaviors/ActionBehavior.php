<?php

    namespace common\models\Behaviors;

    use Yii;
    use yii\base\Behavior;
    use yii\db\ActiveRecord;

    class ActionBehavior extends Behavior{
        public $dateS;
        public $dateE;

        public function events(){
            return [
                ActiveRecord::EVENT_AFTER_FIND      => 'afterFind',
                ActiveRecord::EVENT_BEFORE_INSERT   => 'onBeforeSave',
                ActiveRecord::EVENT_BEFORE_UPDATE   => 'onBeforeSave',
            ];
        }


        public function afterFind(){
            $this->dateS = date('m/d/Y', $this->owner->date_start);
            $this->dateE = date('m/d/Y', $this->owner->date_end);

            if($this->owner->date_end <= time() && $this->owner->status == 'active'){
                $this->owner->status = 'inactive';
                if($this->owner->save(false)){
                    Yii::$app->session->addFlash('info', 'акция '.$this->owner->title.' закончилась');
                }
            }
        }

        public function onBeforeSave($insert){
            $this->owner->date_start = strtotime($this->dateS);
            $this->owner->date_end = strtotime($this->dateE);

            if($this->owner->name == 'discount'){
                $this->owner->value = '{"attr":"price","discount":'.$this->owner->value.'}';
            }

            return true;
        }


    }