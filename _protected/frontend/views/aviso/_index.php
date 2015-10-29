<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Avisos';
?>

    <h2>
        <a href=<?= Url::to(['aviso/view', 'id' => $model->id]) ?>><?= $model->titulo ?></a>
    </h2>

    <p class="time"><span class="glyphicon glyphicon-time"></span> 
        Published on <?= date('F j, Y, g:i a', $model->created_at) ?></p>

    <br>

    <p><?= $model->descripcion ?></p>

    <a class="btn btn-primary" href=<?= Url::to(['aviso/view', 'id' => $model->id]) ?>>
        Read More <span class="glyphicon glyphicon-chevron-right"></span>
    </a>

    <hr class="article-devider">
