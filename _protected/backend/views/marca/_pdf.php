<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Marca */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Marcas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marca-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Marca').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'nombre',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
    $gridColumnModelo = [
        ['class' => 'yii\grid\SerialColumn'],
        'idmodelo',
        'nombre',
        [
            'attribute' => 'marcaIdmarca.nombre',
            'label' => Yii::t('app', 'Marca'),
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerModelo,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . Html::encode(Yii::t('app', 'Modelo').' '. $this->title) . ' </h3>',
        ],
        'columns' => $gridColumnModelo
    ]);
?>
    </div>
</div>