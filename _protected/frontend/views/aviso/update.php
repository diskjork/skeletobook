<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */

$this->title = Yii::t('app', 'Actualizar aviso') . ': ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="article-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="col-lg-12 well bs-component">

        <?php

        if($model->tipo == \common\models\Aviso::AUTO) {
            echo $this->render('_form', [
                'model' => $model,
                'modelConfort' => $modelConfort,
                'modelSeguridad' => $modelSeguridad,
                'modelMultimedia' => $modelMultimedia,
                'modelExterior' => $modelExterior
            ]);
        }else if ($model->tipo == \common\models\Aviso::CAMION){
            echo $this->render('_formcamion', [
                'model' => $model,
                'modelConfort' => $modelConfort,
                'modelSeguridad' => $modelSeguridad,
                'modelMultimedia' => $modelMultimedia,
                'modelExterior' => $modelExterior
            ]);
        }else if ($model->tipo == \common\models\Aviso::CASARODANTE){
            echo $this->render('_formcrodante', [
                'model' => $model,
                'modelConfort' => $modelConfort,
                'modelSeguridad' => $modelSeguridad,
                'modelMultimedia' => $modelMultimedia,
                'modelExterior' => $modelExterior
            ]);
        }
        ?>

    </div>

</div>
