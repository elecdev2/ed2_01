<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadFormImages is the model behind the upload form.
 */
class UploadFormImages extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;
    // public $usuario;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'gif, jpg, png'],
            // [['usuario'], 'required'],
        ];
    }

}
?>