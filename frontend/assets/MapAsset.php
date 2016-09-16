<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class MapAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = [
            'js/markerclusterer.js', 'js/map.js'
        ];

        public $depends = [
            'yii\web\JqueryAsset',
            'frontend\assets\GoogleMapAsset',
        ];

    }