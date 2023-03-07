<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="loading" lang="<?= Yii::$app->language ?>" data-textdirection="ltr">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="PIMC">
    <meta name="google-site-verification" content="pF_0bfNycvfX8Ufp5gVqZyRI00h-WozYW9JpUXuFtEw" />
    

    <link rel="icon" href="<?=Yii::$app->request->baseUrl ?>/medical/img/favicon.ico">
    <?= Html::csrfMetaTags() ?>
    <title><?=$this->title ?></title>
  <?php $this->head() ?>

</head>
<?php $this->beginBody() ?>
<?php if(strpos($_SERVER['REQUEST_URI'],'form-permintaan/')){?>
<img src="../images/backgrounds/batiktr.png" style=" position: absolute;top: 0px;right: 0px; height: 320px; z-index: 20;">
<?php }elseif(strpos($_SERVER['REQUEST_URI'],'spaj/')){?>
<img src="../images/backgrounds/hdr.jpg" style="width:100%;">
<?php }elseif(strpos($_SERVER['REQUEST_URI'],'otp')){?>
<img src="images/backgrounds/hdr.jpg" style="width:100%;">
<?php }elseif(strpos($_SERVER['REQUEST_URI'],'closing')){?>
<img src="../images/backgrounds/hdr.jpg" style="width:100%;">
<?php }else{ ?>
<img src="images/backgrounds/hdr.jpg" style="width:100%;">
<?php } ?>
    <!-- BEGIN: Content-->
          
<?=$content ?>




    <!-- END: Content-->


<?php 
$script = <<< JS


JS;
$this->registerJs($script);
?>

<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
