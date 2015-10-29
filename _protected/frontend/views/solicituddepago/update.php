<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Solicituddepago */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Solicituddepago',
]) . ' ' . $model->idsolicitudepago;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Solicituddepago'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idsolicitudepago, 'url' => ['view', 'id' => $model->idsolicitudepago]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="solicituddepago-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
