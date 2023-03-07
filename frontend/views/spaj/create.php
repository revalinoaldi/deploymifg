<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Spaj */

$this->title = 'Create Spaj';
$this->params['breadcrumbs'][] = ['label' => 'Spajs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spaj-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
