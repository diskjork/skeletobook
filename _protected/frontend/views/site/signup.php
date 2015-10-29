<?php

use yii\base\Model;
use common\models\User;

use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-5 well bs-component">

        <p><?= Yii::t('app', 'Please fill out the following fields to signup:') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'input-36',
                'clientOptions' => [
                'alias' =>  'email'],
            ]) ?>

            <?= $form->field($model, 'telefono')->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'input-1',
                'mask' => '(9999) 999-999999'
            ]) ?>
            <?= $form->field($model, 'telefonoalt')->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'input-1',
                'mask' => '(9999) 999-999999'
            ]) ?>

            <?php
                $catList = ArrayHelper::map(common\models\base\Pais::find()->all(), 'idpais', 'nombre');
            ?>

            <?= $form->field($model, 'pais_idpais')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $catList,
                'options' => ['id'=>'cat-id','placeholder' => Yii::t('app', 'Elegir pais')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

                   
            <?=
             $form->field($model, 'provincia_idprovincia')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>['id'=>'subcat-id'],
                'pluginOptions'=>[
                    'depends'=>['cat-id'],
                    'placeholder'=>'Elegir provincia',
                    'url'=>Url::to(['/site/subcat'])
                ]
            ]);
            ?>
            <?=
            $form->field($model, 'localidad_idlocalidad')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>['id'=>'prodcat-id'],
                'pluginOptions'=>[
                    'depends'=>['cat-id', 'subcat-id'],
                    'placeholder'=>'Elegir localidad',
                    'url'=>Url::to(['/site/prod'])
                ]
            ]);
            ?>


            <?= $form->field($model, 'password')->widget(PasswordInput::classname(), []) ?>

            <?= $form->field($model, 'repeat_password')->widget(PasswordInput::classname(), []) ?>
            
            

            <?= $form->field($model, "verifyCode")->widget(Captcha::className(), ['captchaAction' => 'site/captcha']); ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

        <?php if ($model->scenario === 'rna'): ?>
            <div style="color:#666;margin:1em 0">
                <i>*<?= Yii::t('app', 'We will send you an email with account activation link.') ?></i>
            </div>
        <?php endif ?>

    </div>
</div>