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
                    'placeholder' => Yii::t('app', 'Ej.: Le agregué llantas...')
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


            <?php
            $catList = ArrayHelper::map(Marca::find()->where(['tipovehiculo'=>Marca::AUTO])->all(), 'idmarca', 'nombre');
            ?>

            <?= $form->field($model, 'marca_idmarca')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $catList,
                'options' => ['id'=>'cat-id','placeholder' => Yii::t('app', 'Elegir marca')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?=
             $form->field($model, 'modelo_idmodelo')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>['id'=>'subcat-id'],
                'pluginOptions'=>[
                    'depends'=>['cat-id'],
                    'placeholder'=>'Elegir modelo',
                    'url'=>Url::to(['/aviso/subcat'])
                ]
            ]);
            ?>
            <?=
            $form->field($model, 'version_idversion')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>['id'=>'prodcat-id'],
                'pluginOptions'=>[
                    'depends'=>['cat-id', 'subcat-id'],
                    'placeholder'=>'Elegir versión',
                    'url'=>Url::to(['/aviso/prod'])
                ]
            ]);
            ?>
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

            <?= $form->field($model, 'color_idcolor')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Color::find()->orderBy('nombre')->asArray()->all(), 'idcolor', 'nombre'),
                'options' => ['placeholder' => Yii::t('app', 'Elegir color')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'direccion')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->direccionList,
                'options' => ['placeholder' => Yii::t('app', 'Elegir dirección')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'transmision')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->transmisionList,
                'options' => ['placeholder' => Yii::t('app', 'Elegir transmisión')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'combustible')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->combustibleList,
                'options' => ['placeholder' => Yii::t('app', 'Elegir combustible')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'puertas')->widget(\kartik\widgets\Select2::classname(), [
                'data' => $model->puertaList,
                'options' => ['placeholder' => Yii::t('app', 'Elegir cantidad de puertas')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
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
    <h4>CONFORT</h4>

    <div class="row">
        <div class="col-md-4">
            <?=
                $form->field($modelConfort, 'aireacondicionado', [
                    'template' => '{input}{label}{error}',
                    'labelOptions' => ['class' => 'cbx-label'],
                ])->widget(CheckboxX::classname(), [
                    'autoLabel' => true,
                    'pluginOptions' => [
                        'size'=>'xs',
                        'iconChecked' => '<b>&check;</b>',
                        'threeState'=>false,
                    ],
                    //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
                ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'aperturabaul', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'aregulable', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'atraserorebatible', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'aelectricos', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'atermico', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'acuero', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'abrazocentral', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'ccentralizado', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'ccentralizadodist', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'climatizador', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'computadora', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'cveloccrucero', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'eelectricos', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'fregulainterior', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'tsolar', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'velectricodel', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'velectricotra', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelConfort, 'vregulable', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <hr>

    <h4>SEGURIDAD</h4>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'aconductor', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'aacompa', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'alateral', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'atrasero', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'acortina', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'alarma', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'avelocidad', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'apoyacabeza', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'cierremov', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'cinerciales', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'ctraccion', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'esp', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'dtraccion', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'fantiniebla', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'fabs', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'afrenado', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'fdiscot', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'imotor', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'sestacionamiento', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'slluvia', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'tluzstop', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'llavecod', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'aluces', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelSeguridad, 'isofix', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>
    <hr>
    <h4>AUDIO Y MULTIMEDIA</h4>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'bluetooth', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'cargadorcd', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'csatelital', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'eauxiliar', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'eusb', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'etmemoria', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'gps', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'mlibres', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'radiocassette', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'rcd', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'rmp3', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelMultimedia, 'stactil', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>
    <hr>
    <h4>EXTERIOR</h4>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'pequipaje', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'fxenon', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'luneta', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'lfaros', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'aleacion', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'tdescapota', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'paragolpes', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'polarizados', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($modelExterior, 'pcarter', [
                'template' => '{input}{label}{error}',
                'labelOptions' => ['class' => 'cbx-label'],
            ])->widget(CheckboxX::classname(), [
                'autoLabel' => true,
                'pluginOptions' => [
                    'size'=>'xs',
                    'iconChecked' => '<b>&check;</b>',
                    'threeState'=>false,
                ],
                //'labelSettings' => ['label' => 'Blue Small', 'options'=>[]]
            ])->label(false);
            ?>
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
