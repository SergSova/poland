<?php
    namespace backend\widgets\MapWidget;

    use backend\widgets\MapWidget\assets\FormMapAsset;
    use Yii;
    use yii\base\Widget;
    use yii\helpers\Html;
    use yii\web\View;

    class FormMapWidget extends Widget{
        public $mapSetting;
        public function init(){
            $this->mapSetting['center'] = json_encode($this->mapSetting['center']);
            $this->mapSetting['draggable'] = ($this->mapSetting['draggable']) ? 1 : 0;
            parent::init();
        }

        public function run(){
            FormMapAsset::register(Yii::$app->getView());
            $script = <<<JS
var mapConfig = {
    center: {$this->mapSetting['center']},
    zoom: {$this->mapSetting['zoom']},
    draggable: {$this->mapSetting['draggable']},
    addressInpId: '{$this->mapSetting['addressInpId']}',
    coordInpId: '{$this->mapSetting['coordInpId']}',
};
mapInit();
JS;
            Yii::$app->view->registerJs($script, View::POS_END);
            return $this->renderMap();
        }

        protected function renderMap(){
            return Html::tag('div', null, ['id'=> 'map']);
        }
    }