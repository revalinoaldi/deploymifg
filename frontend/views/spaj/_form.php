<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Spaj */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spaj-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identity_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identity_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marital_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identity_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'residential_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jobs_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_fields')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_institution_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_institution_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correspondence_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relationship_insured')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_identity_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_identity_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_birth_place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_birth_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_marital_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_identity_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_residential_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_jobs_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_business_fields')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_business_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_business_institution_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_business_institution_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insured_business_contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_premi_polis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_protection')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gross_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_interval')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_benefit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provider')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'insurance_period')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'history_insurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'history_insurance_desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
