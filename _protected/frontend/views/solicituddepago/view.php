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
            <h2><?= Yii::t('app', 'Solicitudepago').' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
                        
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model['idsolicitudepago']], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model['idsolicitudepago']], [
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
            'attribute' => 'user.username',
            'label' => Yii::t('app', 'User'),
        ],
        [
            'attribute' => 'publicacion.nombre',
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