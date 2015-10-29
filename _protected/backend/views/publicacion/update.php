<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Publicacion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Publicacion',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publicacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idpublicacion]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="publicacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
