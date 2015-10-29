<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Solicituddepago */

$this->title = Yii::t('app', 'Create Solicituddepago');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Solicituddepago'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicituddepago-create">

    <h3>Usted ha decido contratar el servicio: </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
