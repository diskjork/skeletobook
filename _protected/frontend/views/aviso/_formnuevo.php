<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use common\models\Marca;
//use common\models\Confort;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use yii\captcha\Captcha;
use jlorente\remainingcharacters\RemainingCharacters;
use kartik\icons\Icon;
Icon::map($this, Icon::FA);

/* @var $this yii\web\View */
/* @var $model frontend\models\Aviso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aviso-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
    ]); ?>
    <h4>Elegir el tipo de vehículo</h4>
    <hr>
    <?php $model->isNewRecord ? $model->tipo = 1: $model->tipo = $model->tipo;  ?>
    <?php
    $tipoVehiculo=['Auto / Camioneta','Camion','Casilla Rodante','Moto'];
    $icono=['car','truck','bus','motorcycle'];
    for($i=0;$i<count($tipoVehiculo);$i++){
        $item = "<div>".strtoupper($tipoVehiculo[$i])."</div>";
        $item .= "<div>".Icon::show($icono[$i], ['class'=>'fa-3x iconFontSizeNuevo'], Icon::FA)."</div>";
        $items[$i+1] = $item;
    }
    ?>
      <?= Html::activeRadioList($model, 'tipo', $items, ['encode'=>false]); ?>
    <br>
    <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Siguiente')
            : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord
            ? 'btn btn-primary fuenteBoton' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['aviso/admin'], ['class' => 'btn btn-default fuenteBoton']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
