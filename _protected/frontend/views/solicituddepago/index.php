<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use common\helpers\CssHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel SolicituddepagoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mis solicitudes de pago');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicituddepago-index">

        <span class="pull-right">
            <?= Html::a(Yii::t('app', 'Cargar aviso'), ['aviso/nuevo'], ['class' => 'btn btn-success btn-sm']) ?>
        </span>
   <br><br>

    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
      /*  [
            'attribute' => 'aviso.id',
            'label' => Yii::t('app', 'Aviso'),
        ],*/
        'created_at:date',
        'expira:date',
        [
            'label' => Yii::t('app', 'Publicacion'),
            'attribute' => 'publicacion',
            'value' => 'publicacion.nombre',
        ],
        [
            'attribute' => 'precio',
            'value' => 'precio'
        ],
        'concepto',
        'codigodepago',
        [
            'attribute'=>'estado',
            'filter' => $searchModel->statusList,
            'value' => function ($data) {
                return $data->getStatusName($data->estado);
            },
            'contentOptions'=>function($model, $key, $index, $column) {
                return ['class'=>CssHelper::articleStatusCss($model->statusName)];
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {imprimir} {delete}',
            'header' => 'Opciones',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Yii::t('app', 'Editar'),
                        //'target' => '_blank',
                        'data' => ['pjax' => 0]
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('app', 'Eliminar'),
                        'data-confirm' => Yii::t('yii', 'Esta seguro que desea eliminar este cupon de pago?'),
                        'data-method' => 'post',
                    ]);
                },
                'imprimir' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-print"></span>', $url, [
                        'title' => Yii::t('app', 'Imprimir'),
                        'target' => '_blank',
                        'data' => ['pjax' => 0]
                    ]);
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'imprimir') {
                    return Url::toRoute([$action, 'id' => $model->idsolicitudepago]);
                }elseif ($action === 'delete') {
                    return Url::toRoute([$action, 'id' => $model->idsolicitudepago]);
                }elseif ($action === 'update') {
                    return Url::toRoute([$action, 'id' => $model->idsolicitudepago]);
                }
            }
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'summary' => false,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        //'panel' => [
          //  'type' => GridView::TYPE_PRIMARY,
          //  'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . Html::encode($this->title) . ' </h3>',
        //],
        // set a label for default menu
        /*'export' => [
            'label' => 'Page',
            'fontAwesome' => true,
        ],
        // your toolbar can include the additional full export menu
        /*'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],*/
    ]); ?>

</div>
