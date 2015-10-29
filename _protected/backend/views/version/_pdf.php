<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Version */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="version-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Version'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'nombre',
        [
            'attribute' => 'modeloIdmodelo.nombre',
            'label' => 'Modelo',
        ],
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
            'label' => 'User',
        ],
        'titulo',
        'descripcion:ntext',
        'created_at',
        'updated_at',
        'categoria',
        [
            'attribute' => 'versionIdversion.nombre',
            'label' => 'Version',
        ],
        'anio',
        'combustible',
        'transmision',
        'direccion',
        'puertas',
        [
            'attribute' => 'colorIdcolor.nombre',
            'label' => 'Color',
        ],
        'kilometros',
        'precio',
        'moneda',
        'formadepago',
        'uso',
        [
            'attribute' => 'confortIdconfort.idconfort',
            'label' => 'Confort',
        ],
        [
            'attribute' => 'seguridadIdseguridad.idseguridad',
            'label' => 'Seguridad',
        ],
        [
            'attribute' => 'multimediaIdmultimedia.idmultimedia',
            'label' => 'Multimedia',
        ],
        [
            'attribute' => 'exteriorIdexterior.idexterior',
            'label' => 'Exterior',
        ],
        'visitas',
        'estado',
        [
            'attribute' => 'publicacionIdpublicacion.nombre',
            'label' => 'Publicacion',
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAviso,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . Html::encode('Aviso'.' '. $this->title) . ' </h3>',
        ],
        'columns' => $gridColumnAviso
    ]);
?>
    </div>
</div>