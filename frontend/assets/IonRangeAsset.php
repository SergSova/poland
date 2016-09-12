<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class IonRangeAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $css = ['css/ion.rangeSlider.css', 'css/ion.rangeSlider.skinHTML5.css'];
        public $js = ['js/ion.rangeSlider.min.js'];

        public $depends = [
            'yii\web\JqueryAsset'
        ];
    }