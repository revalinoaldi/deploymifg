<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SpajSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Spajs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spaj-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Spaj', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fullname',
            'identity_type',
            'identity_number',
            'birth_place',
            //'birth_date',
            //'gender',
            //'marital_status',
            //'identity_address',
            //'residential_address',
            //'jobs_desc',
            //'business_fields',
            //'business_position',
            //'business_institution_name',
            //'business_institution_address',
            //'business_contact',
            //'correspondence_address',
            //'relationship_insured',
            //'insured_fullname',
            //'insured_identity_type',
            //'insured_identity_number',
            //'insured_birth_place',
            //'insured_birth_date',
            //'insured_gender',
            //'insured_marital_status',
            //'insured_identity_address',
            //'insured_residential_address',
            //'insured_jobs_desc',
            //'insured_business_fields',
            //'insured_business_position',
            //'insured_business_institution_name',
            //'insured_business_institution_address',
            //'insured_business_contact',
            //'is_premi_polis',
            //'insurance_protection',
            //'source_income',
            //'gross_income',
            //'payment_method',
            //'pay_interval',
            //'insurance_class',
            //'additional_benefit',
            //'provider',
            //'insurance_period',
            //'currency',
            //'history_insurance',
            //'history_insurance_desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
