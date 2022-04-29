<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
/* @var $articles common\models\Articles */
/* @var $pagination \yii\data\Pagination */

$this->title = 'وبلاگ';
$this->params['breadcrumbs'][] = ['label' => 'پنل', 'url' => ['panel/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(); ?>

<?php if (Yii::$app->user->can('manageContent')): ?>
    <p>
        <?= Html::a('افزودن پست', ['create'], ['class' => 'btn btn-outline-light']) ?>
    </p>
<?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'article_title',
            /*[
                'attribute' => 'author_id',
                'label' => 'نویسنده',
                'value' => function($post) {
                    return $post->author->display_name;
                }
            ],*/
            [
                'attribute' => 'created_at',
                'label' => 'تاریخ ایجاد',
                'value' => function($post) {
                    return Yii::$app->jdate->date('o/n/d', $post->created_at);
                }
            ],
            [
                'label' => 'عملیات',
                'value' => function($post) {
                    if($post->lock_to == Yii::$app->user->identity->id)
                    {
                        $output = '<a href="' . Url::to(['blog/post/' . $post->id]) . '" target="_blank" title="ویرایش پست">
                                       <span class="fas fa-pencil-alt"></span>
                                   </a>';
                        $output .= Html::a('<span class="fas fa-hand-rock"></span>', ['catch', 'id' => $post->id], [
                            'title' => 'آزاد کردن',
                            'data' => [
                                'confirm' => 'آزاد کردن پست، امکان انتخاب و ویرایش آن را به اعضا می‌دهد. آیا از ویرایش منصرف شده‌اید؟',
                                'method' => 'post',
                            ],
                        ]);
                    }
                    elseif($post->lock_to == null)
                    {
                        $output = '<a href="' . Url::to(['panel/blog/post/' . $post->id]) . '" target="_blank" title="مشاهده پست">
                                       <span class="fas fa-eye"></span>
                                   </a>';
                        $output .= Html::a('<span class="fas fa-hand-paper"></span>', ['catch', 'id' => $post->id], [
                            'title' => 'رزرو',
                            'data' => [
                                'confirm' => 'برای ویرایش پست باید آن را انتخاب و رزرو کنید. آیا می‌خواهید پست را رزرو کنید؟',
                                'method' => 'post',
                            ],
                        ]);
                    }
                    else
                    {
                        $output = '<span class="fas fa-lock"></span>';
                    }

                    if ($post->article_status == 6 && $post->slug != null)
                    {
                        $output .= '<a href="' . Url::to(['blog/post/' . $post->slug]) . '" target="_blank" title="لینک پست">
                                        <span class="fas fa-link"></span>
                                    </a>';
                    }
                    return $output;
                },
                'format' => 'html',
            ],
        ],
    ]); ?>

<?php Pjax::end(); ?>
