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

/* @var $this yii\web\View */
/* @var $model frontend\models\Aviso */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="aviso-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>
        <h4>Datos generales del vehículo</h4>
    <hr>
    <?= $form->errorSummary($model); ?>
    <div class="container-fluid">
        <div class="row">
        <div class="form-group-sm col-xs-12 col-md-6">
            <?= $form->field($model, 'titulo')->textInput(['maxlength' => 255]) ?>

            <?php
            echo $form->field($model, 'descripcion')->widget(RemainingCharacters::classname(), [
                'type' => RemainingCharacters::INPUT_TEXTAREA,
                'text' => Yii::t('app', 'quedan: {n}'),
                'label' => [
                    'tag' => 'small',
                    'id' => 'my-counter',
                    'class' => 'counter',
                    'invalidClass' => 'error'
                ],
                'options' => [
                    'rows' => '5',
                    'class' => 'col-md-12',
                    'maxlength' => 500,
                    'placeholder' => Yii::t('app', 'Agregue aqui características especiales...')
                ]
            ]);
            ?>

            <?= $form->field($model, 'categoria')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->categoryList,
                'options' => ['placeholder' => Yii::t('app', 'Elegir categoría')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>


            <?= $form->field($model, 'marca_idmarca')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Marca::find()->where(['tipovehiculo'=>Marca::MOTO])->orderBy('nombre')->asArray()->all(), 'idmarca', 'nombre'),
                'options' => ['placeholder' => Yii::t('app', 'Elegir marca')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
            <?= $form->field($model, 'modelo')->textInput(['maxlength' => 255]) ?>

            <?php
                $anios=[];
                for ($i=date('Y')+1;$i>1980;$i--){
                    $anios[$i]=$i;
                }
            ?>
            <?= $form->field($model, 'anio')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $anios,
                'options' => ['placeholder' => Yii::t('app', 'Elegir año')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'tipomotor')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->tipoMotorList,
                'options' => ['placeholder' => Yii::t('app', 'Elegir tipo motor')],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>

            <?= $form->field($model, 'cilindrada')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 7, 'greedy' => false]
            ]) ?>



            <?= $form->field($model, 'kilometros')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 7, 'greedy' => false]
            ]) ?>


            <?= $form->field($model, 'moneda')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->monedaList,
                'pluginOptions' => [
                    'allowClear' => false,
                    'class' => 'col-xs-2',
                ],
            ]) ?>
            <?= $form->field($model, 'precio')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9',
                'clientOptions' => ['repeat' => 9, 'greedy' => false]
            ]) ?>
        </div>
    </div>
    </div>
    <hr>

    <h4>FOTOS DEL VEHICULO</h4>
    <?php
    $objPub=ArrayHelper::toArray(\common\models\Publicacion::find()->all());
    $exposicion=['Baja','Media','Alta','Muy alta'];
    ?>
    <small>Podrá cargar hasta un máximo de <?= $objPub[3]['cantfotos'] ?> fotos. El tipo de publicación que elija definirá la cantidad a mostrar.</small>
    <?= \nemmo\attachments\components\AttachmentsInput::widget([
        'id' => 'file-input', // Optional
        'model' => $model,
        'options' => [ // Options of the Kartik's FileInput widget
            'multiple' => true, // If you want to allow multiple upload, default to false
            'accept' => 'image/*'
        ],
        'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget
            'maxFileCount' => 5, // Client max files
            'maxFileSize' => 1024,
            'showRemove' => true,
            'showUpload' => false,
            'overwriteInitial' => false,
            'layoutTemplates' => [
                'actions' => '{delete}{indicator}',
            ],
        ]
    ]) ?>

    <hr>
    <?php
  //print_r(ArrayHelper::toArray($objPub));
    //$pubList = ArrayHelper::map(\common\models\Publicacion::find()->all(), 'idpublicacion', 'duracion');
    ?>
    <h4>TIPO DE PUBLICACION</h4>
    <?php $model->isNewRecord ? $model->publicacion_id = 1: $model->publicacion_id = $model->publicacion_id ;  ?>
    <?php
    //print_r($pubList);
    for($i=0;$i<count($objPub);$i++){
        $item = "<br>".strtoupper($objPub[$i]['nombre']);
        $item .= "<div>Precio: $".$objPub[$i]['precio']."</div>";
        $item .= "<div>Duracion: ".$objPub[$i]['duracion']." dias</div>";
        $item .= "<div>Exposición: ".$exposicion[$objPub[$i]['exposicion']-1]."</div>";
        $item .= "<div>Cantidad de fotos: ".$objPub[$i]['cantfotos']."</div>";
        $items[$i+1] = $item;
    }
    ?>

        <?php //=$form->field($model, 'publicacion_id',['template' => '{input}{error}',])->radioList($pubList,['inline'=>true]);?>
        <?= Html::activeRadioList($model, 'publicacion_id', $items, ['encode'=>false]); ?>


    <?php
    /*$name = "model";
   // $items = [1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E"];
    $selection = 'publicacion_id';

    echo Html::activeRadioList($model, $selection, $items, [
        'item' => function ($index, $label, $name, $checked, $value) {
            $disabled = false; // replace with whatever check you use for each item
            return Html::radio($name, $checked, [
                'value' => $value,
                'label' => Html::encode($label),
                'disabled' => $disabled,
            ]);
        },
    ]);*/
    ?>
    <div class="row">
    <?php //echo $form->field($model, 'publicacion_id',['template' => '{input}{error}',])->radioList($items,['separator'=>"<hr />",'inline'=>true]);
    ?>
    </div>
    <hr>
    <h4>VERIFICACION</h4>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group-sm col-xs-12 col-md-6">
                <?= $form->field($model, 'captcha')->widget(Captcha::className()) ?>
                </div>
            </div>
        </div>
    <hr>
    <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Siguiente')
            : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord
            ? 'btn btn-primary fuenteBoton' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['aviso/admin'], ['class' => 'btn btn-default fuenteBoton']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
