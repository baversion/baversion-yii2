<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<footer class="bg-dark pt-4 mt-4">
    <div class="container text-center text-md-left">
        <div class="row">

            <!--First column-->
            <div class="col-md-4"><?php /*
                <h5 class="text-light mb-4 mt-3 font-weight-bold">خبرنامه</h5>
                <p>هر هفته مطالب منتخب سایت را برای شما ارسال خواهیم کرد. ایمیل شما را اسپم نمی‌کنیم و آن را به هیچ شخص یا شرکت ثالثی نخواهیم داد.</p>
                <form class="form-inline d-table mb-5 mx-auto" action="/">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="email@example.com" dir="ltr">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-danger" type="button"><span class="fas fa-fire"></span> اشتراک</button>
                        </div>
                    </div>
                </form>*/ ?>
                <h5 class="text-light mb-4 mt-3 font-weight-bold">محتوای باورژن</h5>
                <p>در باورژن ملاک ما کیفیت است. باورژن مرتبا به روز می‌شود. البته این یک هدف است که سعی می‌کنیم به آن عمل کنیم، ولی در صورتی که به هر دلیل نتوانیم طبق زمانبندی مطالب را آماده انتشار نماییم، کیفیت را فدای کمیت نمی‌کنیم و ترجیح ما انتشار مطلب کمتر ولی با کیفیت‌تر است.</p>
            </div>
            <!--/.First column-->

            <hr class="clearfix w-100 d-md-none">

            <!--Second column-->
            <div class="col-md-2 mx-auto">
                <h5 class="text-light mb-4 mt-3 font-weight-bold">باورژن</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= Url::to(['/about']) ?>">درباره</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/contact']) ?>">تماس</a>
                    </li>
                </ul>
            </div>
            <!--/.Second column-->

            <hr class="clearfix w-100 d-md-none">

            <!--Third column-->
            <div class="col-md-2 mx-auto">
                <h5 class="text-light mb-4 mt-3 font-weight-bold">فیدها</h5>
                <ul class="list-unstyled">
                    <?php /*
                    <li class="mb-2">
                        <a href="<?= Url::to(['/rss']) ?>" title="فید باورژن">
                            <span class="fas fa-rss"></span> باورژن
                        </a>
                    </li> */ ?>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/docs/rss']) ?>" title="فید داکیومنت‌ها">
                            <span class="fas fa-rss"></span> داکیومنت
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/blog/rss']) ?>" title="فید وبلاگ">
                            <span class="fas fa-rss"></span> وبلاگ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/terminologies/rss']) ?>" title="فید اصطلاحات فنی">
                            <span class="fas fa-rss"></span> اصطلاحات فنی
                        </a>
                    </li>
                </ul>
            </div>
            <!--/.Third column-->

            <hr class="clearfix w-100 d-md-none">

            <!--Fourth column-->
            <div class="col-md-2 mx-auto">
                <h5 class="text-light mb-4 mt-3 font-weight-bold">داکیومنت‌ها</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= Url::to(['/docs/composer/1']) ?>">کامپوزر</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/docs/codeigniter/3']) ?>">کدایگنایتر</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/docs/laravel/5.6']) ?>">لاراول</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= Url::to(['/docs/php-ml/0.6']) ?>">PHP-ML</a>
                    </li>
                </ul>
            </div>
            <!--/.Fourth column-->
        </div>
    </div>

    <hr>

    <div class="footer-copyright py-3 text-center">
        <p>کلیه حقوق برای <a href="http://baversion.com">باورژن</a> محفوظ است.</p
    </div>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110207826-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-110207826-1');
    </script>
</footer>