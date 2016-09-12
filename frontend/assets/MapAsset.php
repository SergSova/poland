<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class MapAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = [
            'https://maps.googleapis.com/maps/api/js?key=AIzaSyAUYPzaG4lQCw-v_7JUodo1mgWDlztuD0s', 'js/map.js'
        ];

    }