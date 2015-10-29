<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Aviso */

$this->title = Yii::t('app', 'Publicar vehiculo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aviso-create">

    <h3><?= Html::encode($this->title) ?></h3>

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
