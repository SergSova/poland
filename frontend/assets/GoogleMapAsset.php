<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class GoogleMapAsset extends AssetBundle{
        public $js = [
            '//maps.googleapis.com/maps/api/js?key=AIzaSyAUYPzaG4lQCw-v_7JUodo1mgWDlztuD0s',
        ];
        public $depends = [
            'yii\web\JqueryAsset'
        ];
    }