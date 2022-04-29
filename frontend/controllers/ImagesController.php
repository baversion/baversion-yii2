<?php

namespace frontend\controllers;

use common\models\Images;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use frontend\models\UploadForm;
use yii\web\UploadedFile;

class ImagesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['upload'],
                        'allow' => true,
                        'roles' => ['createContent'],
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => ['manageContent'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->post())
        {
            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->image)
            {
                $imageModel = new Images();
                $hash = Yii::$app->getSecurity()->generateRandomString();
                $image_name = (strlen($model->image->baseName . $model->image->extension > 96 ) ? substr($model->image->baseName, 0, 96 - strlen($model->image->extension)): $model->image->baseName) . '-' . $hash . '.' . $model->image->extension;
                $imageModel->image_name = $image_name;
                $imageModel->image_hash = $hash;
                $imageModel->original_name = $model->image->baseName . '.' . $model->image->extension;
                $imageModel->user_id = Yii::$app->user->identity->id;
                $imageModel->created_at = time();
                $model->image->saveAs(Yii::getAlias('@webroot') . '/images/' . date('Y/m') . '/' . $image_name);
                Yii::$app->session->setFlash('info', 'http://baversion.com/images/' . $image_name);
//                if ($imageModel->save())
//                {
//                    $model->image->saveAs('public_html/images/' . $image_name);
//                    Yii::$app->session->setFlash('info', 'http://baversion.com/images/' . $image_name);
//                }
//                else
//                {
//                    Yii::$app->session->setFlash('danger', "مشکلی در آپلود به وجود آمده است.");
//                }
            }
            else
            {
                $tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();

                Yii::$app->session->setFlash('danger', "عکس معتبر نیست." . $tmp_dir);
            }
        }

        return $this->render('upload',[
            'model' => $model,
        ]);
    }

}
