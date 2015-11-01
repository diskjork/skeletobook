<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Aviso */

$this->title = Yii::t('app', 'Publicar vehiculo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aviso-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="col-lg-12 well bs-component">

    <?php

    if ($model->tipo == \common\models\Aviso::MOTO){
        echo $this->render('_formmoto', [
            'model' => $model,
        ]);
    }
    ?>

    </div>

</div>
