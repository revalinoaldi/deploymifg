<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SpajSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spaj-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fullname') ?>

    <?= $form->field($model, 'identity_type') ?>

    <?= $form->field($model, 'identity_number') ?>

    <?= $form->field($model, 'birth_place') ?>

    <?php // echo $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'identity_address') ?>

    <?php // echo $form->field($model, 'residential_address') ?>

    <?php // echo $form->field($model, 'jobs_desc') ?>

    <?php // echo $form->field($model, 'business_fields') ?>

    <?php // echo $form->field($model, 'business_position') ?>

    <?php // echo $form->field($model, 'business_institution_name') ?>

    <?php // echo $form->field($model, 'business_institution_address') ?>

    <?php // echo $form->field($model, 'business_contact') ?>

    <?php // echo $form->field($model, 'correspondence_address') ?>

    <?php // echo $form->field($model, 'relationship_insured') ?>

    <?php // echo $form->field($model, 'insured_fullname') ?>

    <?php // echo $form->field($model, 'insured_identity_type') ?>

    <?php // echo $form->field($model, 'insured_identity_number') ?>

    <?php // echo $form->field($model, 'insured_birth_place') ?>

    <?php // echo $form->field($model, 'insured_birth_date') ?>

    <?php // echo $form->field($model, 'insured_gender') ?>

    <?php // echo $form->field($model, 'insured_marital_status') ?>

    <?php // echo $form->field($model, 'insured_identity_address') ?>

    <?php // echo $form->field($model, 'insured_residential_address') ?>

    <?php // echo $form->field($model, 'insured_jobs_desc') ?>

    <?php // echo $form->field($model, 'insured_business_fields') ?>

    <?php // echo $form->field($model, 'insured_business_position') ?>

    <?php // echo $form->field($model, 'insured_business_institution_name') ?>

    <?php // echo $form->field($model, 'insured_business_institution_address') ?>

    <?php // echo $form->field($model, 'insured_business_contact') ?>

    <?php // echo $form->field($model, 'is_premi_polis') ?>

    <?php // echo $form->field($model, 'insurance_protection') ?>

    <?php // echo $form->field($model, 'source_income') ?>

    <?php // echo $form->field($model, 'gross_income') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'pay_interval') ?>

    <?php // echo $form->field($model, 'insurance_class') ?>

    <?php // echo $form->field($model, 'additional_benefit') ?>

    <?php // echo $form->field($model, 'provider') ?>

    <?php // echo $form->field($model, 'insurance_period') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'history_insurance') ?>

    <?php // echo $form->field($model, 'history_insurance_desc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
