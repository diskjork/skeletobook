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

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

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
                        'ratio' => 800/600,
                        'width' => '100%',
                        'allowfullscreen' => 'true',
                    ]
                ]
            );
        }else{
        ?>
        <div id="sinFoto"><?= Icon::show('bus', ['class'=>'fa-3x iconFontSize'], Icon::FA);?></div>
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
                    'heading' => Icon::show('bus', ['class'=>'fa-1x'], Icon::FA).' Datos generales: '.strtoupper($this->title),
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [
                    //'descripcion:ntext',
                    [
                        'label' => 'Año',
                        'attribute' => 'anio',
                    ],
                    [
                        'attribute' => 'color_idcolor',
                        'value' => $model->colorIdcolor->nombre,
                    ],
                    [
                        'attribute' =>  'transmision',
                        'value' => $model::getTransmisionName($model->transmision),
                    ],
                    [
                        'attribute' =>  'marchas',
                    ],
                    [
                        'attribute' =>  'motor',
                    ],
                    [
                        'attribute' =>  'direccion',
                        'value' => $model::getDireccionName($model->direccion),
                    ],

                    [
                        'attribute' =>  'combustible',
                        'value' => $model::getCombustibleName($model->combustible),
                    ],
                    [
                        'attribute' =>  'capacidadtanque',
                        'value' => $model->capacidadtanque. ' ltrs.',
                    ],
                    [
                        'attribute' =>  'largototal',
                        'value' => $model->largototal. ' mts.',
                    ],
                    [
                        'attribute' =>  'cpersonas',
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
    <?php
    echo DetailView::widget([
        'model' => $modelConfort,
        'condensed' => true,
        'hover' => false,
        'responsive' => true,
        'bordered' => false,
        'striped' => false,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 800,
        'panel' => [
            'heading' => '<span class="glyphicon glyphicon-play"></span> CONFORT',
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [
                'columns' => [
                        [
                            'attribute' => 'aireacondicionado',
                            'value' => ($modelConfort->aireacondicionado == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'aelectricos',
                            'value' => ($modelConfort->aelectricos == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'aregulable',
                            'value' => ($modelConfort->aregulable == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                            'format' => 'html',
                        ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'atermico',
                        'value' => ($modelConfort->atermico == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'abrazocentral',
                        'value' => ($modelConfort->abrazocentral == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'ccentralizado',
                        'value' => ($modelConfort->ccentralizado == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'ccentralizadodist',
                        'value' => ($modelConfort->ccentralizadodist == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'climatizador',
                        'value' => ($modelConfort->climatizador == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'computadora',
                        'value' => ($modelConfort->computadora == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'cveloccrucero',
                        'value' => ($modelConfort->cveloccrucero == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'eelectricos',
                        'value' => ($modelConfort->eelectricos == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'fregulainterior',
                        'value' => ($modelConfort->fregulainterior == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'vregulable',
                        'value' => ($modelConfort->vregulable == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'velectricodel',
                        'value' => ($modelConfort->velectricodel == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'scabina',
                        'value' => ($modelConfort->scabina == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
        ],
    ]);

?>

<?php
    echo DetailView::widget([
        'model' => $modelSeguridad,
        'condensed' => true,
        'hover' => true,
        'responsive' => true,
        'bordered' => false,
        'striped' => false,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 800,
        'panel' => [
            'heading' => '<span class="glyphicon glyphicon-play"></span> SEGURIDAD',
            'type' => DetailView::TYPE_WARNING,
        ],
        'attributes' => [
            [
                'columns' => [
                    [
                        'attribute' => 'aconductor',
                        'value' => ($modelSeguridad->aconductor == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'aacompa',
                        'value' => ($modelSeguridad->aacompa == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'alateral',
                        'value' => ($modelSeguridad->alateral == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'alarma',
                        'value' => ($modelSeguridad->alarma == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'avelocidad',
                        'value' => ($modelSeguridad->avelocidad == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'cierremov',
                        'value' => ($modelSeguridad->cierremov == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'cinerciales',
                        'value' => ($modelSeguridad->cinerciales == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'ctraccion',
                        'value' => ($modelSeguridad->ctraccion == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'esp',
                        'value' => ($modelSeguridad->esp == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'dtraccion',
                        'value' => ($modelSeguridad->dtraccion == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'fantiniebla',
                        'value' => ($modelSeguridad->fantiniebla == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'fabs',
                        'value' => ($modelSeguridad->fabs == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'afrenado',
                        'value' => ($modelSeguridad->afrenado == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'aluces',
                        'value' => ($modelSeguridad->aluces == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'imotor',
                        'value' => ($modelSeguridad->imotor == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'sestacionamiento',
                        'value' => ($modelSeguridad->sestacionamiento == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'slluvia',
                        'value' => ($modelSeguridad->slluvia == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'llavecod',
                        'value' => ($modelSeguridad->llavecod == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],

                ],
            ],
        ],
    ]);
?>

    <?php
    echo DetailView::widget([
        'model' => $modelMultimedia,
        'condensed' => true,
        'hover' => true,
        'responsive' => true,
        'bordered' => false,
        'striped' => false,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 800,
        'panel' => [
            'heading' => '<span class="glyphicon glyphicon-play"></span> AUDIO Y MULTIMEDIA',
            'type' => DetailView::TYPE_SUCCESS,
        ],
        'attributes' => [
            [
                'columns' => [
                    [
                        'attribute' => 'bluetooth',
                        'value' => ($modelMultimedia->bluetooth == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'cargadorcd',
                        'value' => ($modelMultimedia->cargadorcd == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'csatelital',
                        'value' => ($modelMultimedia->csatelital == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'eauxiliar',
                        'value' => ($modelMultimedia->eauxiliar == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'eusb',
                        'value' => ($modelMultimedia->eusb == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'etmemoria',
                        'value' => ($modelMultimedia->etmemoria == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'gps',
                        'value' => ($modelMultimedia->gps == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'mlibres',
                        'value' => ($modelMultimedia->mlibres == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'radiocassette',
                        'value' => ($modelMultimedia->radiocassette == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'rcd',
                        'value' => ($modelMultimedia->rcd == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'rmp3',
                        'value' => ($modelMultimedia->rmp3 == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'stactil',
                        'value' => ($modelMultimedia->stactil == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],


        ],
    ]);
?>

    <?php
    echo DetailView::widget([
        'model' => $modelExterior,
        'condensed' => true,
        'hover' => true,
        'responsive' => true,
        'bordered' => false,
        'striped' => false,
        'enableEditMode' => false,
        'mode' => DetailView::MODE_VIEW,
        'fadeDelay' => 800,
        'panel' => [
            'heading' => '<span class="glyphicon glyphicon-play"></span> EXTERIOR',
            'type' => DetailView::TYPE_DANGER,
        ],
        'attributes' => [
            [
                'columns' => [
                    [
                        'attribute' => 'fxenon',
                        'value' => ($modelExterior->fxenon == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'lfaros',
                        'value' => ($modelExterior->lfaros == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'luneta',
                        'value' => ($modelExterior->luneta == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'paragolpes',
                        'value' => ($modelExterior->paragolpes == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'polarizados',
                        'value' => ($modelExterior->polarizados == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'etecho',
                        'value' => ($modelExterior->etecho == 0) ? '<span class="glyphicon glyphicon-remove"></span>':'<span class="glyphicon glyphicon-ok"></span>',
                        'format' => 'html',
                    ],
                ],
            ],
        ],
    ]);
    ?>
</div>
