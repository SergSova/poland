<?php
    namespace backend\components;

    use Imagine\Image\Box;
    use Imagine\Image\Point;
    use Yii;
    use yii\base\Object;
    use yii\helpers\FileHelper;
    use yii\imagine\Image;
    use yii\web\UploadedFile;

    class RealtyPhoto extends Object{
        const THUMB_PREFIX = 'thumb_';
        const FULL_PREFIX  = 'full_';

        public $basePhoto;
        public $basePhotoName;
        public $basePhotoUrl;
        public $basePhotoPath;

        public function __construct($pathToPhoto){
            $this->basePhotoPath = $pathToPhoto;
            $this->basePhoto = Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$pathToPhoto;
            $this->basePhotoUrl = Yii::$app->params['photoUrl'].'/'.$pathToPhoto;
            $this->basePhotoName = substr($pathToPhoto, strrpos($pathToPhoto, '/') + 1);

            parent::__construct();
        }

        public static function uploadPhoto(UploadedFile $photo){
            $fileName = uniqid(time(), true).'.'.$photo->extension;
            $directory = Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'tmp';
            if($photo->saveAs($directory.DIRECTORY_SEPARATOR.$fileName)){
                $sessionPhoto = Yii::$app->session->get('uploadedPhoto');
                if(!$sessionPhoto){
                    $sessionPhoto = [];
                }
                $data = [
                    'error' => [
                        'uploadError' => 0,
                    ],
                    'url' => Yii::$app->params['photoUrl'].'tmp/'.$fileName,
                    'path' => 'tmp/'.$fileName,
                ];
                $sessionPhoto[] = [
                    'url' => Yii::$app->params['photoUrl'].'tmp/'.$fileName,
                    'path' => 'tmp/'.$fileName
                ];
                Yii::$app->session->set('uploadedPhoto', $sessionPhoto);
            }else{
                $data = [
                    'error' => [
                        'uploadError' => $photo->error,
                    ],
                ];
            }

            return $data;
        }

        public static function deletePhoto($path){
            $sessionPhotos = Yii::$app->session->get('uploadedPhoto');
            if(is_array($sessionPhotos) && !empty($sessionPhotos)){
                foreach($sessionPhotos as $key => $value){
                    if($value['path'] == $path){
                        if(file_exists(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$path)){
                            unset($sessionPhotos[$key]);
                            unlink(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$path);
                        }
                        break;
                    }
                }
                Yii::$app->session->set('uploadedPhoto', $sessionPhotos);
            }else{
                if(file_exists(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$path)){
                    $fileName =  substr($path, strrpos($path, '/') + 1);
                    $directory = substr($path, 0, strrpos($path, '/'));

                    unlink(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$fileName);
                    unlink(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.self::FULL_PREFIX.$fileName);
                    unlink(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.self::THUMB_PREFIX.$fileName);
                }
            }
        }

        public function savePhoto($directory){
            $path = Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.$directory;
            if(!is_dir($path)){
               FileHelper::createDirectory($path);
            }
            $picture = Image::getImagine()
                            ->open(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$this->basePhotoPath);
            $pictureSize = $picture->getSize();

            $picture->save($path.DIRECTORY_SEPARATOR.self::FULL_PREFIX.$this->basePhotoName, ['quality' => 100]);
            if($pictureSize->getWidth() - $pictureSize->getHeight() > 0){
                $imageSide = $pictureSize->getHeight();
                $cropX = ($pictureSize->getWidth() - $imageSide) / 2;
                $cropY = 0;
            }else if($pictureSize->getWidth() - $pictureSize->getHeight() < 0){
                $imageSide = $pictureSize->getWidth();
                $cropX = 0;
                $cropY = ($pictureSize->getHeight() - $imageSide) / 2;
            }else{
                $imageSide = $pictureSize->getWidth();
                $cropX = 0;
                $cropY = 0;
            }

            $cropPoints = new Point($cropX, $cropY);
            $cropBox = new Box($imageSide, $imageSide);
            $thumbBox = new Box(Yii::$app->params['realtyThumb']['width'], Yii::$app->params['realtyThumb']['height']);

            $picture->crop($cropPoints, $cropBox)
                    ->save($path.DIRECTORY_SEPARATOR.$this->basePhotoName, ['quality' => 100]);

            $picture->thumbnail($thumbBox)
                    ->save($path.DIRECTORY_SEPARATOR.self::THUMB_PREFIX.$this->basePhotoName, ['quality' => 100]);
            $this->deletePhoto($this->basePhotoPath);
            return 'catalog/'.$directory.'/'.$this->basePhotoName;
        }

        public function render(){
            return Yii::$app->view->renderFile('@backend/views/realty/includes/_photo.php', ['photo' => $this]);
        }
    }