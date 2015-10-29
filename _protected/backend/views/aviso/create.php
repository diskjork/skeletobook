<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Aviso */

$this->title = Yii::t('app', 'Publicar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aviso-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="col-lg-12 well bs-component">

        <?= $this->render('_form', [
            'model' => $model,
            'modelConfort'=>$modelConfort,
            'modelSeguridad'=>$modelSeguridad,
            'modelMultimedia' => $modelMultimedia,
            'modelExterior' => $modelExterior
        ])?>

    </div>

</div>
