<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Marca */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Marca',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Marcas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idmarca]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="marca-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
