<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Publicacion */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'Aviso', 
        'relID' => 'aviso', 
        'value' => \yii\helpers\Json::encode($model->avisos),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="publicacion-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

    <?= $form->field($model, 'precio')->textInput(['placeholder' => 'Precio']) ?>

    <?= $form->field($model, 'duracion')->textInput(['placeholder' => 'Duracion']) ?>

    <?= $form->field($model, 'exposicion')->textInput(['placeholder' => 'Exposicion']) ?>

    <?= $form->field($model, 'cantfotos')->textInput(['placeholder' => 'Cantfotos']) ?>

    <div class="form-group" id="add-aviso"></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
