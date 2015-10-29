<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

Pjax::begin();
$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Aviso',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'id' => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
        'user_id' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
                'options' => ['placeholder' => 'Choose User'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'titulo' => ['type' => TabularForm::INPUT_TEXT],
        'descripcion' => ['type' => TabularForm::INPUT_TEXTAREA],
        'created_at' => ['type' => TabularForm::INPUT_TEXT],
        'updated_at' => ['type' => TabularForm::INPUT_TEXT],
        'categoria' => ['type' => TabularForm::INPUT_TEXT],
        'version_idversion' => [
            'label' => 'Version',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Version::find()->orderBy('nombre')->asArray()->all(), 'idversion', 'nombre'),
                'options' => ['placeholder' => 'Choose Version'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'anio' => ['type' => TabularForm::INPUT_TEXT],
        'combustible' => ['type' => TabularForm::INPUT_TEXT],
        'transmision' => ['type' => TabularForm::INPUT_TEXT],
        'direccion' => ['type' => TabularForm::INPUT_TEXT],
        'puertas' => ['type' => TabularForm::INPUT_TEXT],
        'color_idcolor' => [
            'label' => 'Color',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Color::find()->orderBy('nombre')->asArray()->all(), 'idcolor', 'nombre'),
                'options' => ['placeholder' => 'Choose Color'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'kilometros' => ['type' => TabularForm::INPUT_TEXT],
        'precio' => ['type' => TabularForm::INPUT_TEXT],
        'moneda' => ['type' => TabularForm::INPUT_TEXT],
        'formadepago' => ['type' => TabularForm::INPUT_TEXT],
        'uso' => ['type' => TabularForm::INPUT_TEXT],
        'confort_idconfort' => [
            'label' => 'Confort',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Confort::find()->orderBy('idconfort')->asArray()->all(), 'idconfort', 'idconfort'),
                'options' => ['placeholder' => 'Choose Confort'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'seguridad_idseguridad' => [
            'label' => 'Seguridad',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Seguridad::find()->orderBy('idseguridad')->asArray()->all(), 'idseguridad', 'idseguridad'),
                'options' => ['placeholder' => 'Choose Seguridad'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'multimedia_idmultimedia' => [
            'label' => 'Multimedia',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Multimedia::find()->orderBy('idmultimedia')->asArray()->all(), 'idmultimedia', 'idmultimedia'),
                'options' => ['placeholder' => 'Choose Multimedia'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'exterior_idexterior' => [
            'label' => 'Exterior',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Exterior::find()->orderBy('idexterior')->asArray()->all(), 'idexterior', 'idexterior'),
                'options' => ['placeholder' => 'Choose Exterior'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'visitas' => ['type' => TabularForm::INPUT_TEXT],
        'estado' => ['type' => TabularForm::INPUT_TEXT],
        'publicacion_idpublicacion' => [
            'label' => 'Publicacion',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Publicacion::find()->orderBy('nombre')->asArray()->all(), 'idpublicacion', 'nombre'),
                'options' => ['placeholder' => 'Choose Publicacion'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'del' => [
            'type' => TabularForm::INPUT_STATIC,
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRow(' . $key . '); return false;', 'id' => 'aviso-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> ' . 'Aviso' . '  </h3>',
            'type' => GridView::TYPE_INFO,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Row', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowAviso()']),
        ]
    ]
]);
Pjax::end();
?>