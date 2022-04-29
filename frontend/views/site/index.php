<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

/* @var $docs array|\common\models\Docs[] */
/* @var $articles array|\common\models\Articles[] */

$this->title = Yii::$app->name;
?>
<!-- Feature Items Section -->
<div id="feature-items" class="our-services section section-invert py-4">
    <div class="container">
        <div class="row">
            <?php foreach($docs as $doc): ?>
                <div class="col-md-3 mb-2 d-flex">
                    <div class="item py-4">
                        <div class="avatar">
                            <img src="<?= $doc->cover_image ?>" class="w-100" alt="<?= $doc->doc_title ?>" />
                        </div>
                        <div class="px-4">
                            <h5 class="mb-1">
                                <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version]) ?>" target="_blank">
                                    <?= $doc->doc_title ?>
                                </a>
                            </h5>
                            <span class="text-muted d-block mb-2"><?= $doc->subtitle ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- / Feature items Section -->

<!-- Our Services Section -->
<div id="our-services" class="our-services section py-4">
    <h3 class="section-title text-center my-5">بخش‌ها</h3>
    <!-- Features -->
    <div class="features py-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="feature py-4 col-md-6 d-flex">
                    <div class="icon text-primary mr-3"><i class="fas fa-book"></i></div>
                    <div class="px-4">
                        <h5>داکیومنت</h5>
                        <p>در بخش داکیومنت می‌توانید از داکیومنت‌‌های مربوط به زبان‌های برنامه‌نویسی، فریمورک‌ها و برخی ابزار مرتبط استفاده کنید.</p>
                    </div>
                </div>
                <div class="feature py-4 col-md-6 d-flex">
                    <div class="icon text-primary mr-3"><i class="fas fa-language"></i></div>
                    <div class="px-4">
                        <h5>اصطلاحات فنی</h5>
                        <p>از نظر ما یادگیری مفهوم اصطلاحات تخصصی بهتر از معادل‌سازی فارسی است که در اثر موارد باعث گیج شدن نویسنده می‌شود.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="feature py-4 col-md-6 d-flex">
                    <div class="icon text-primary mr-3"><i class="fas fa-map-signs"></i></div>
                    <div class="px-4">
                        <h5>رفرنس</h5>
                        <p>رفرنس راهی سریع برای دسترسی به داکیومنت زبان‌ها، فریمورک‌ها و ابزار هستند، ابتدا حداقل یکبار داکیومنت را مطالعه کنید.</p>
                    </div>
                </div>
                <div class="feature py-4 col-md-6 d-flex">
                    <div class="icon text-primary mr-3"><i class="fas fa-pencil-alt"></i></div>
                    <div class="px-4">
                        <h5>وبلاگ</h5>
                        <p>اخبار دنیای برنامه‌نویسی، آموزش‌های برنامه‌نویسی و نحوه استفاده از ابزار را در وبلاگ باورژن می‌توانید دنبال کنید.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Features -->
</div>
<!-- / Our Services Section -->

<!-- Our Blog Section -->
<div class="blog section section-invert py-4">
    <h3 class="section-title text-center m-5">آخرین مطالب وبلاگ</h3>

    <div class="container">
        <div class="py-4">
            <div class="row">
                <div class="card-deck">
                    <?php foreach ($articles as $article): ?>
                        <div class="col-md-12 col-lg-4">
                            <div class="card mb-4">
                                <?php if ($article->cover_image !== null): ?>
                                    <img src="<?= $article->cover_image ?>" class="card-img-top" alt="<?= $article->article_title ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h4 class="card-title"><?= $article->article_title ?></h4>
                                    <p class="card-text"><?= $article->excerpt ?></p>
                                    <a class="btn btn-outline-primary btn-pill" href="<?= Url::to(['blog/post/' . $article->slug]) ?>">ادامه مطلب &larr;</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Our Blog Section -->

<!-- Documents Section -->
<div class="testimonials section py-4">
    <h3 class="section-title text-center m-5">داکیومنت‌ها</h3>
    <div class="container py-5">
        <div class="row">
            <?php foreach($docs as $key => $doc): ?>
                <?php if($key == 3) {break;} ?>
                <div class="col-md-4 testimonial text-center">
                    <div class="avatar mb-3 ml-auto mr-auto">
                        <img src="<?= $doc->cover_image ?>" class="w-100" alt="<?= $doc->doc_title ?>" />
                    </div>
                    <h5 class="mb-1"><?= $doc->doc_title ?></h5>
                    <span class="text-muted d-block mb-2"><?= $doc->subtitle ?></span>
                    <p><?= $doc->content ?></p>
                    <a href="<?= Url::to(['docs/' . $doc->slug . '/' . $doc->doc_version]) ?>" class="btn btn-outline-primary btn-pill" target="_blank">مشاهده داکیومنت</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- / Documents Section -->

<!-- Terminology Section -->
<div class="section-invert py-4">
    <h3 class="section-title text-center m-5">اصطلاحات فنی</h3>
    <div class="container py-4">
        <div class="row justify-content-md-center px-4">
            <div class="contact-form col-sm-12 col-md-10 col-lg-7 p-4 mb-4">
                <?php foreach ($terms as $term): ?>
                    <a href="<?= Url::to(['terminologies/term/' . $term->slug]) ?>" class="btn btn-outline-light mb-1"><?= $term->term_title ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- / Terminology Section -->