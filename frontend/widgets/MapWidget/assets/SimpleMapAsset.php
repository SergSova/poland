<?php
    namespace frontend\widgets\MapWidget\assets;

    use yii\web\AssetBundle;

    class SimpleMapAsset extends AssetBundle{
        const API_KEY = 'AIzaSyAUYPzaG4lQCw-v_7JUodo1mgWDlztuD0s';
        const LIBRARIES = 'places';

        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = [
            'https://maps.googleapis.com/maps/api/js?key='.self::API_KEY.'&libraries='.self::LIBRARIES, 'js/simple-map.js'
        ];
    }