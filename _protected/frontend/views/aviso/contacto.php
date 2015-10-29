<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

?>
<div class="site-contact">
    <div class="col-lg-12 well bs-component">
        <?php //$form = ActiveForm::begin(['id' => 'contact-form']); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
            'enableClientValidation' => true,
            'type' => ActiveForm::TYPE_VERTICAL,
            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
        ]); ?>

        <?= $form->field($modelContacto, 'name') ?>
        <?= $form->field($modelContacto, 'email') ?>
        <?= $form->field($modelContacto, 'body')->textArea(['rows' => 6]) ?>
        <?= $form->field($modelContacto, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-6">{input}</div></div>',
        ]) ?>
        <div class="form-group" style="text-align: center">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
