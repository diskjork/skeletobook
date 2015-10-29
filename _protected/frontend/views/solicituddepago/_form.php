<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Solicituddepago */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="solicituddepago-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    Tipo de servicio: <?= $model->publicacion->nombre?>
    <br>
    Precio: $<?= $model->precio ?>
    <br>
    Aviso: <?= $model->aviso->descripcion ?>


    <?php /* $form->field($model, 'aviso_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Aviso::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Aviso')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) */?>

    <?php /*$form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
        'options' => ['placeholder' => Yii::t('app', 'Choose User')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'publicacion_idpublicacion')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Publicacion::find()->orderBy('idpublicacion')->asArray()->all(), 'idpublicacion', 'idpublicacion'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Publicacion')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) */?>
    <h5>Si está de acuerdo, tildar casilla de confirmación y aceptar.</h5>
    <?=
    $form->field($model, 'control', [
        'template' => '{input}{label}{error}',
        'labelOptions' => ['class' => 'cbx-label'],
    ])->widget(CheckboxX::classname(), [
        'autoLabel' => true,
        'pluginOptions' => [
            'size'=>'xs',
            'iconChecked' => '<b>&check;</b>',
            'threeState'=>false,
        ],
        'labelSettings' => ['label' => 'Blue Small', 'options'=>['class'=>'text-info']]
    ])->label(false);
    ?>

    <?php //= $form->field($model, 'aviso_id')->hiddenInput()->label(false);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Confirmar') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick' => "$('#w0').showLoading();"]) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['aviso/update','id'=>$model->aviso_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
