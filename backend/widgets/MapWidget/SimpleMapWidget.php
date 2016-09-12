<?php
    namespace backend\widgets\MapWidget;


    use backend\widgets\MapWidget\assets\SimpleMapAsset;
    use Yii;
    use yii\base\Widget;
    use yii\helpers\Html;
    use yii\web\View;

    class SimpleMapWidget extends Widget{
        public $mapSetting;
        public $markers = [];

        public function init(){
            $this->mapSetting['center'] = json_encode($this->mapSetting['center']);
            $this->mapSetting['draggable'] = ($this->mapSetting['draggable']) ? 1 : 0;
            $this->markers = json_encode($this->markers);
            parent::init();
        }

        public function run(){
            SimpleMapAsset::register(Yii::$app->getView());
            $script = <<<JS
var mapConfig = {
    center: {$this->mapSetting['center']},
    zoom: {$this->mapSetting['zoom']},
    draggable: {$this->mapSetting['draggable']}
};
var markersData = {$this->markers};
mapInit();
showMarkers();
JS;
            Yii::$app->view->registerJs($script, View::POS_END);
            return $this->renderMap();
        }

        protected function renderMap(){
            return Html::tag('div', null, ['id'=> 'map']);
        }
    }