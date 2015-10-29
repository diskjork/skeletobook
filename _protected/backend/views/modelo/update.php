<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Modelo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Modelo',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modelos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idmodelo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="modelo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
