<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Publicacion */

$this->title = Yii::t('app', 'Create Publicacion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publicacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
