<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */

$this->title = Yii::t('app', 'Actualizar aviso') . ': ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="article-update">

    <h2><?= Html::encode($this->title) ?></h2>

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
