<?php

    /**
     * @var View $this ;
     */

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\View;

    $this->registerJsFile('js/uploadPhoto.js', [
        'position' => \yii\web\View::POS_END,
        'depends' => 'backend\assets\AppAsset'
    ]);
    $uploadUrl = Url::to(['realty/upload-photo']);
    $deleteUrl = Url::to(['realty/delete-photo']);
    $script = <<<JS
var uploadUrl="{$uploadUrl}";
var deleteUrl="{$deleteUrl}";

if($('#photo-wrap').find('.photo-box').length != 0){
        $('#photo-wrap .alert').hide();
    }
JS;
    $style = <<<CSS
#photo-wrap{
position:relative;
}
.photo-box{
display: inline-block;
margin: 0 5px;
position:relative;
}
.photo-box .photo-prev{
width: 150px;
height: 150px;
overflow: hidden;
}
.photo-box .photo-prev img{
width: 100%;
}
.photo-box .photo-prev img.isCover{
border: 2px solid blue;
}
.photo-box .photo-remove{
position: absolute;
left: 50%;
bottom: 0;
transform: translateX(-50%);
}
.preloader{
    position:absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
    background-color: rgba(0,0,0,0.7);
    color: white;
    font-size: 20px;
    line-height: 100px;
    z-index: 20;
}
CSS;
    $this->registerJs($script, View::POS_END);
    $this->registerCss($style);
?>
<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">Фото</div>
        <div class="panel-body" id="photo-wrap">
            <div class="alert alert-info">Ни одного фото не загружено...</div>
            <div class="preloader" id="preloader" style="display: none">loading...</div>
            <?php
                $uploadedPhoto = Yii::$app->session->get('uploadedPhoto');
                if(!empty($uploadedPhoto)):
                    foreach($uploadedPhoto as $photo):
                        ?>
                        <div class="photo-box">
                            <div class="photo-prev">
                                <img src="<?= $photo['url'] ?>">
                            </div>
                            <button class="btn btn-danger photo-remove" data-path="<?= $photo['path'] ?>" type="button">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                        <?php
                    endforeach;
                endif;
                if(!$model->baseModel->isNewRecord):
                    $realtyPhotos = [];
                    $photos = json_decode($model->entityModel->photos);
                    foreach($photos as $p){
                        $realtyPhotos[] = [
                            'url' => Yii::getAlias('@storageUrl').'/'.$p,
                            'path' => $p
                        ];
                    }
                    foreach($realtyPhotos as $photo):
                        ?>
                        <div class="photo-box">
                            <div class="photo-prev">
                                <img src="<?= $photo['url'] ?>">
                            </div>
                            <button class="btn btn-danger photo-remove" data-path="<?= $photo['path'] ?>" type="button">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                        <?php
                    endforeach;
                endif;
            ?>
        </div>
        <div class="panel-footer">
            <div class="form-group" id="uploadInpWrap">
                <div class="col-sm-12">
                    <?= Html::input('file', 'picture', null, [
                        'class' => 'form-control',
                        'id' => 'uploadInp'
                    ]) ?>
                </div>
                <div class="col-sm-12">
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div>
</div>

