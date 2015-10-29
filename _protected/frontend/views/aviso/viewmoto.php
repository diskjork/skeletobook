<?php
use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
//use yii\bootstrap\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use raoul2000\widget\scrollup\Scrollup;
use kartik\icons\Icon;
Icon::map($this, Icon::FA);

/* @var $this yii\web\View */
/* @var $model frontend\models\Aviso */

$this->title = Html::encode($model->marcaIdmarca->nombre." ".$model->modelo);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avisos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Scrollup::widget([
    'theme' => Scrollup::THEME_IMAGE,
    'pluginOptions' => [
        'scrollText' => "Hacia arriba", // Text for element
        'scrollName'=> 'scrollUp', // Element ID
        'topDistance'=> 400, // Distance from top before showing element (px)
        'topSpeed'=> 3000, // Speed back to top (ms)
        'animation' => Scrollup::ANIMATION_SLIDE, // Fade, slide, none
        'animationInSpeed' => 200, // Animation in speed (ms)
        'animationOutSpeed'=> 200, // Animation out speed (ms)
        'activeOverlay' => false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
    ]
]);

?>
<?php
//Contador de visitas
$model->getBehavior('hit')->touch();

?>
<div class="aviso-view">

    <h3><?= Html::encode($model->marcaIdmarca->nombre." ".$model->modelo) ?>

    <div class="pull-right">

    <?php if (Yii::$app->user->can('adminArticle')): ?>

        <?= Html::a(Yii::t('app', 'Back'), ['admin'], ['class' => 'btn btn-warning']) ?>

    <?php endif ?>

    <?php if (Yii::$app->user->can('updateArticle', ['model' => $model])): ?>

        <?= Html::a(Yii::t('app', 'Update'), ['updatemoto', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?php endif ?>

    <?php if (Yii::$app->user->can('deleteArticle')): ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Seguro desea eliminar este aviso?'),
                'method' => 'post',
            ],
        ]) ?>

    <?php endif ?>
    
    </div>
        <small>Visitas: <?=$model->getBehavior('hit')->getHitsCount()?></small>
    </h3>

    <br>

    <?php
        //Se limita cantidad de fotos a mostrar dependiendo del tipo de publicacion elegido
        if (isset($model->files)) {
            $count = 0;
            foreach ($model->files as $file) {
                //echo Html::img($image->getUrl('small'));
                if ($count < $model->publicacion->cantfotos) {
                    $items[] = [
                        //'url' => $file->url,
                        //'src' => $file->url,
                        //'options' => array('title' => "")
                        'img' => $file->url,
                    ];
                } else {
                    break;
                }
                $count++;
            }
        }
    ?>
    <div class="row">
        <div class="col-md-6">
    <?php
        if (isset($items)) {
            echo \metalguardian\fotorama\Fotorama::widget(
                [
                    'items' => $items,
                    'options' => [
                        'nav' => 'thumbs',
                        'loop' => true,
                        'hash' => true,
                        'ratio' => 800 / 600,
                        'width' => '100%',
                        'allowfullscreen' => 'true',
                    ]
                ]
            );
        }else{
    ?>
        <div id="sinFoto"><?= Icon::show('motorcycle', ['class'=>'fa-3x iconFontSize'], Icon::FA);?></div>
        <?php
        }
    ?>
        </div>
        <div class="col-md-6">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'condensed' => true,
                'hover' => true,
                'responsive' => true,
                'mode' => DetailView::MODE_VIEW,
                'fadeDelay' => 800,
                'enableEditMode' => false,
                'panel' => [
                    'heading' => Icon::show('motorcycle', ['class'=>'fa-1x'], Icon::FA).' Datos generales: '.strtoupper($this->title),
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [
                    //'descripcion:ntext',
                    [
                        'attribute' =>  'tipomotor',
                        'value' => $model::getTipoMotor($model->tipomotor),
                    ],
                    [
                        'attribute' => 'cilindrada',
                        'value' => $model->cilindrada.' cc',
                    ],
                    [
                        'label' => 'Año',
                        'attribute' => 'anio',
                    ],
                    'kilometros',
                    [
                        'label' => 'Publicado',
                        'attribute' => 'created_at',
                        'format'=>'date',
                        'type' => DetailView::INPUT_DATE
                    ],
                ],

            ]);

            ?>
            <h3><strong><?= $model::getMonedaNameAbrv($model->moneda).' '.number_format($model->precio,0,'','.') ?></strong></h3>

            <p>
                <?php if(!(Yii::$app->user->can('updateArticle', ['model' => $model])))echo Html::button('Contactar vendedor',['value'=>Url::to('contacto'),'class'=> 'btn btn-primary','id'=>'modalButton']) ?>
            </p>
            <?php
                Modal::begin([
                    'header' => '<h5>Ponganse en contacto con el vendedor</h5>',
                    'id' => 'modal',
                    //'size' => 'modal-lg',
                ]);
                echo "<div id='modalContent' style='height:450px;'></div>";
                Modal::end();
            ?>
        </div>
    </div>
        <hr>
        <blockquote style="border-left-color:#710909">
            <p>
                <small><strong><?= $model->descripcion?></strong></small>
            </p>
        </blockquote>
</div>
