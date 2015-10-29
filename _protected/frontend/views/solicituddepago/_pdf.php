<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Solicituddepago */

$this->title = $model->idsolicitudepago;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Solicituddepago'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicituddepago-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Solicituddepago').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'idsolicitudepago',
        'precio',
        'venc',
        'codigo',
        'concepto',
        'moneda',
        'created_at',
        'updated_at',
        'codigodepago',
        'expira',
        'estado',
        [
            'attribute' => 'aviso.id',
            'label' => Yii::t('app', 'Aviso'),
        ],
        [
            'attribute' => 'user.id',
            'label' => Yii::t('app', 'User'),
        ],
        [
            'attribute' => 'publicacionIdpublicacion.idpublicacion',
            'label' => Yii::t('app', 'Publicacion'),
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>