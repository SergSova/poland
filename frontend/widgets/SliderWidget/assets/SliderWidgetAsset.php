<?php

    namespace frontend\widgets\SliderWidget\assets;

    use yii\web\AssetBundle;

    class SliderWidgetAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = [
            'js/sliderwidget.js'
        ];

        public $depends = [
            'yii\web\JqueryAsset'
        ];
    }