<?php
    namespace backend\widgets\MapWidget\assets;

    use yii\web\AssetBundle;

    class FormMapAsset extends AssetBundle{
        const API_KEY = 'AIzaSyAUYPzaG4lQCw-v_7JUodo1mgWDlztuD0s';
        const LIBRARIES = 'places';

        public $basePath = '@webroot';
        public $baseUrl = '@web';


        public $css = [
            'css/map-style.css',
        ];
        public $js = [
            'https://maps.googleapis.com/maps/api/js?key='.self::API_KEY.'&libraries='.self::LIBRARIES, 'js/form-map.js'
        ];
    }