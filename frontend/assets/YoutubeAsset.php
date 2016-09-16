<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class YoutubeAsset extends AssetBundle{
        public $js = [
            'https://www.youtube.com/iframe_api',
        ];

        public $depends = [
            'yii\web\JqueryAsset'
        ];
    }