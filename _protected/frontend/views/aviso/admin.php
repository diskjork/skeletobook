<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mis avisos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-admin">
    <span class="pull-right">
        <?= Html::a(Yii::t('app', 'Cargar aviso'), ['nuevo'], ['class' => 'btn btn-success btn-sm']) ?>
    </span>  
    <br><br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // author
            [
                'header' => 'Creado',
                'attribute'=>'created_at',
                'format' => ['date', 'php:d/m/Y'],
                'filter' => false,
            ],
            [
                'header' => 'Expira',
                'value' => function ($data) {
                    return $data->getExpira($data->created_at,$data->publicacion->duracion);
                },
            ],
            /*[
                'attribute'=>'user_id',
                'value' => function ($data) {
                    return $data->getAuthorName();
                },
            ],*/
            'titulo',
            // status

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
                'attribute'=>'publicacion_id',
                'value' => 'publicacion.nombre'
            ],
            /*[
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Menu')
            ],*/

           [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => 'Opciones',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'Ver detalles'),
                            //'target' => '_blank',
                            'data' => ['pjax' => 0]
                        ]);
                    },
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
                            'data-confirm' => Yii::t('yii', 'Esta seguro que desea eliminar este aviso?'),
                            'data-method' => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                        if ($model->tipo == \common\models\Aviso::MOTO)
                            return Url::toRoute(['updatemoto', 'id' => $model->id]);
                        else
                            return Url::toRoute([$action, 'id' => $model->id]);
                    }elseif ($action === 'view') {
                            return Url::toRoute([$action, 'id' => $model->id]);
                    }elseif ($action === 'delete') {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                }
            ],
        ],
    ]); ?>

</div>
