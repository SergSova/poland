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
         * if method by action name exist processed this
         *
         * @param $event
         */
        public function getActionForModel($event){
            $model = $this->owner;
            $actions = $model->actions;
            foreach($actions as $action){
                if($this->hasMethod($method = 'get'.ucfirst($action->name))){
                    $this->$method($action->value);
                }
            }
        }

        #region Discount
        /**
         * @param $value string JSON with parameters for discount
         */
        public function getDiscount($value){
            $property = json_decode($value);
            if(!isset($this->owner->{$this->name})){
                $this->owner->{$this->name} = $this->owner->{$property->attr} - $this->owner->{$property->attr} * ($property->discount / 100);
            }
        }

        /**
         * @param $value integer
         */
        public function setNewPrice($value){
            $this->owner->{$this->name} = $value;
        }

        /**
         * @return mixed
         */
        public function getNewPrice(){
            return $this->owner->{$this->name};
        }
        #endregion

    }