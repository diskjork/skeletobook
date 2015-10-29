<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Modelo */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modelos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Modelo').' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
                        
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model['idmodelo']], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model['idmodelo']], [
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
        [
            'attribute' => 'marcaIdmarca.nombre',
            'label' => Yii::t('app', 'Marca'),
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
    $gridColumnVersion = [
        ['class' => 'yii\grid\SerialColumn'],
        'idversion',
        'nombre',
        [
            'attribute' => 'modeloIdmodelo.nombre',
            'label' => Yii::t('app', 'Modelo'),
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerVersion,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . Html::encode(Yii::t('app', 'Version').' '. $this->title) . ' </h3>',
        ],
        'columns' => $gridColumnVersion
    ]);
?>
    </div>
</div>