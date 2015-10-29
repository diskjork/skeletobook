<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Publicacion */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publicacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicacion-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Publicacion').' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
                        
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model['idpublicacion']], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model['idpublicacion']], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'nombre',
        'precio',
        'duracion',
        'exposicion',
        'cantfotos',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
    $gridColumnAviso = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        [
            'attribute' => 'user.id',
            'label' => Yii::t('app', 'User'),
        ],
        'titulo',
        'descripcion:ntext',
        'created_at',
        'updated_at',
        'categoria',
        [
            'attribute' => 'marcaIdmarca.nombre',
            'label' => Yii::t('app', 'Marca'),
        ],
        [
            'attribute' => 'modeloIdmodelo.nombre',
            'label' => Yii::t('app', 'Modelo'),
        ],
        [
            'attribute' => 'versionIdversion.nombre',
            'label' => Yii::t('app', 'Version'),
        ],
        'anio',
        'combustible',
        'transmision',
        'direccion',
        'puertas',
        [
            'attribute' => 'colorIdcolor.nombre',
            'label' => Yii::t('app', 'Color'),
        ],
        'kilometros',
        'precio',
        'moneda',
        'formadepago',
        'uso',
      /*  [
            'attribute' => 'confortIdconfort.idconfort',
            'label' => Yii::t('app', 'Confort'),
        ],
        [
            'attribute' => 'seguridadIdseguridad.idseguridad',
            'label' => Yii::t('app', 'Seguridad'),
        ],
        [
            'attribute' => 'multimediaIdmultimedia.idmultimedia',
            'label' => Yii::t('app', 'Multimedia'),
        ],
        [
            'attribute' => 'exteriorIdexterior.idexterior',
            'label' => Yii::t('app', 'Exterior'),
        ],*/
        'visitas',
        'estado',
       /* [
            'attribute' => 'publicacionIdpublicacion.nombre',
            'label' => Yii::t('app', 'Publicacion'),
        ],*/
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAviso,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . Html::encode(Yii::t('app', 'Aviso').' '. $this->title) . ' </h3>',
        ],
        'columns' => $gridColumnAviso
    ]);
?>
    </div>
</div>