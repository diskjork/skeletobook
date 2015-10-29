<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SolicituddepagoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicituddepago-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idsolicitudepago') ?>

    <?= $form->field($model, 'precio') ?>

    <?= $form->field($model, 'venc') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'concepto') ?>

    <?php // echo $form->field($model, 'moneda') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'codigodepago') ?>

    <?php // echo $form->field($model, 'expira') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'aviso_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'publicacion_idpublicacion') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
