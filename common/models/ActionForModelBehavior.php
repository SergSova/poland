<?php

    namespace common\models;

    use yii\base\Behavior;

    class ActionForModelBehavior extends Behavior{
        public    $price;
        protected $name = 'newPrice';

        public function attach($owner){
            parent::attach($owner);
        }

        /**
         * @param $event
         */
        public function getActionForModel($event){
            $model = $this->owner;
            $actions = $model->actions;
            foreach($actions as $action){
                if($this->hasMethod('get'.ucfirst($action->name))){
                    $method = 'get'.ucfirst($action->name);
                    $this->$method($action->value);
                }
            }
        }

        #region Discount
        public function getDiscount($value){
            $property = json_decode($value);
            if(!isset($this->owner->{$this->name})){
                $this->owner->{$this->name} = $this->owner->{$property->attr} - $this->owner->{$property->attr} * ($property->discount / 100);
            }
        }

        public function setNewPrice($value){
            $this->owner->{$this->name} = $value;
        }

        public function getNewPrice(){
            return $this->owner->{$this->name};
        }

        #endregion



    }