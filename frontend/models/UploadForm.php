<?php
/**
 * User: Ashkan
 * Date: 4/24/2018
 * Time: 12:24
 */

namespace frontend\models;

use yii\base\Model;
use yii\web\uploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadForm image attribute
     */
    public $image;

    /**
     * return array the validation rules.
     */
    public function rules()
    {
        return [
            [['image'], 'image', 'extensions' => 'jpg,png,jpeg']
        ];
    }
}