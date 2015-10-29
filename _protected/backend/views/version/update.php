<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Version */

$this->title = 'Update Version: ' . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idversion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="version-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
