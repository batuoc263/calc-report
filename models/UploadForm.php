<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf, docx, doc'],
        ];
    }
    
    public function upload($filename)
    {
        if ($this->validate()) {
            $this->file->saveAs('uploads/' . $filename );
            return true;
        } else {
            return false;
        }
    }
}