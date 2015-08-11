<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\ArchivosHistorial;

class UploadForm extends Model
{
    public $files;

    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf,doc,jpg,png', 'maxFiles' => 5],
        ];
    }
    
    // public function upload($his)
    // {
    //     if ($this->validate()) 
    //     { 
    //         foreach ($this->files as $file) 
    //         {
    //             $nombre = md5(time()) . '.' . $file->extension;
    //             $file->saveAs('images/hist' . $nombre);
    //             $archivo = new ArchivosHistorial();
    //             $archivo->archivo = $nombre;
    //             $archivo->id_historia = $his;
    //             $archivo->save();
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}
?>