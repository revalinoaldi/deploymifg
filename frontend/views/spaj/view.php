<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Spaj */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Spajs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="spaj-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fullname',
            'identity_type',
            'identity_number',
            'birth_place',
            'birth_date',
            'gender',
            'marital_status',
            'identity_address',
            'residential_address',
            'jobs_desc',
            'business_fields',
            'business_position',
            'business_institution_name',
            'business_institution_address',
            'business_contact',
            'correspondence_address',
            'relationship_insured',
            'insured_fullname',
            'insured_identity_type',
            'insured_identity_number',
            'insured_birth_place',
            'insured_birth_date',
            'insured_gender',
            'insured_marital_status',
            'insured_identity_address',
            'insured_residential_address',
            'insured_jobs_desc',
            'insured_business_fields',
            'insured_business_position',
            'insured_business_institution_name',
            'insured_business_institution_address',
            'insured_business_contact',
            'is_premi_polis',
            'insurance_protection',
            'source_income',
            'gross_income',
            'payment_method',
            'pay_interval',
            'insurance_class',
            'additional_benefit',
            'provider',
            'insurance_period',
            'currency',
            'history_insurance',
            'history_insurance_desc',
        ],
    ]) ?>

</div>
