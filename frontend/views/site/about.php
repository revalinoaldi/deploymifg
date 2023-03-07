<?php
use yii\helpers\Html;

$this->title = 'PONDOK INDAH MEDICAL CENTER';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="position-relative p-0 no-transition" id="home">
    <!-- <h2 class="d-none">as</h2> -->
    <img class="img-fluid" src="/uploads/<?=Yii::$app->generalFunction->getSetting('banner-about') ?>">
</section>

<section class="bg-light-gray text-center about">
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <h1 class="lt"><?= Html::encode($this->title) ?></h1>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row mt-50">
                    <div class="col-md-6 p-0">
                        <img class="img-fluid" src="/uploads/<?=$model[0]->image ?>">
                    </div>
                    <div class="col-md-6 p-0 text-left">
                        <div class="about-content">
                            <h2 class="round-side"><?=$model[0]->title ?></h2>
                            <?=$model[0]->description ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-left">
                        <div class="about-content">
                            <h2><?=$model[1]->title ?></h2>
                            <?=$model[1]->description ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-left">
                        <div class="about-content">
                            <h2><?=$model[2]->title ?></h2>
                            <?=$model[2]->description ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Map -->
<section id="contactus" class="position-relative p-0">
    <a target="_blank" href="https://www.google.co.id/maps/place/Pondok+Indah+/medical+Centre/@-6.281927,106.7873494,17z/data=!3m1!4b1!4m5!3m4!1s0x2e69f1c0dc6aa4d7:0xd421c380467d5037!8m2!3d-6.281927!4d106.7895381?hl=id">
    <img src="/images/footer-contact.png" style="width: 100%" class="desktop">
    <img src="/images/footer-contact-mobile.png" style="width: 100%" class="mobile">
</a>
</section>
