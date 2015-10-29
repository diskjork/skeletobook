<?php
use evgeniyrru\yii2slick\Slick;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;

use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use yii\imagine\Image;


/* @var $this yii\web\View */
$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="site-index">
    <div class="well text-center">
        <h3><span class="label label-default">PUBLICITE AQUI</span></h3>
    </div>
      <?php
      $test = [];
      foreach($dataProvider->getModels() as $i => $a ):
          $test[$i] = Html::beginTag('div', ['class'=> '']);//,'style' => 'width:215px;']);
          $test[$i] .= Html::beginTag('div', ['class' => 'item-content2']);
          if($a->files[$i]['name'] != null):
              if($a->files[$i]['url'] != null):
                  //Image::getImagine()->open($a->files[$i]['path'])->thumbnail(new Box(200, 200))->save($a->files[$i]['path'].".thumb.jpg");
                  $test[$i] .= Html::beginTag('a target=_blank', ['href' => Url::to(['aviso/view', 'id' => $a->id])]);
                  $test[$i] .= Html::img($a->files[$i]['url'], ['height'=>'160']);
                  $test[$i] .= Html::endTag('a');
              endif;
              $test[$i] .= Html::endTag('div');
              $test[$i] .= Html::beginTag('div', ['class' => 'item-description2']);
              $test[$i] .= Html::beginTag('p');
              $test[$i] .= Html::encode($a->marcaIdmarca->nombre);
              $test[$i] .= Html::encode(' '.$a->modeloIdmodelo->nombre);
              $test[$i] .= Html::beginTag('br');
              $test[$i] .= Html::encode(' '.$a->versionIdversion->nombre);
              $test[$i] .= Html::beginTag('br');
              $test[$i] .= Html::encode(\common\models\Aviso::getMonedaNameAbrv($a->moneda).' '.number_format($a->precio,0,'','.'));
              $test[$i] .= Html::endTag('p');
              $test[$i] .= Html::endTag('div');
              $test[$i] .= Html::endTag('div');
          endif;
      endforeach
     ?>
    <h4>AVISOS DESTACADOS</h4>
        <?=Slick::widget([
            // HTML tag for container. Div is default.
            'itemContainer' => 'div',
            // HTML attributes for widget container
            'containerOptions' => ['class' => 'container-fluid'],
            // Items for carousel. Empty array not allowed, exception will be throw, if empty
            'items' => $test,
            // HTML attribute for every carousel item
            'itemOptions' => ['class' => 'cat-image'],
            // settings for js plugin
            // @see http://kenwheeler.github.io/slick/#settings
            'clientOptions' => [
                 'infinite' => true,
                 'slidesToShow' => 3,
                 'slidesToScroll' => 3,
                'centerMode' => true,
                'variableWidth' => true,
                //'adaptiveHeight' => true,
                'autoplay' => true,
                //'dots'     => true,
                'autoplaySpeed' => '1000',
                'speed'    => 800,
                'centerPadding'=>'1px',
                // note, that for params passing function you should use JsExpression object
                //'onAfterChange' => new JsExpression('function() {console.log("The cat has shown")}'),
                'responsive' => [
                    [
                        'breakpoint' => 768,
                        'settings' => [
                            'slidesToShow' => 3,
                            'arrows' => false,
                            'centerMode' => true,
                            'centerPadding' => '40px',
                        ],
                    ],
                    [
                        'breakpoint' => 480,
                        'settings' => [
                            'slidesToShow' => 1,
                            'arrows' => false,
                            'centerMode' => true,
                            'centerPadding' => '40px',
                        ],
                    ],
                ]
            ],

        ]);
        ?>
    <div class="jumbotron">
        <h1>BUSCADOR PRINCIPAL</h1>
    </div>

    <div class="well text-center">
        <h3><span class="label label-default">PUBLICITE AQUI</span></h3>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 bloque-novedad">
                <?= Html::img(Yii::getAlias('@web').'/images/img1.jpg')?>
                <h4 class="text-center infoHomeTitulo">CONSEJOS PARA VENDER</h4>
                <p class="infoHomeTexto">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.
                </p>

                <div class="botonNovedad"><h5><a class="'btn btn-warning btn-sm" href="../galeria/view?idgaleria=2">Leer mas &raquo;</a></h5></div>
            </div>
            <div class="col-lg-4 bloque-novedad">
                <?= Html::img(Yii::getAlias('@web').'/images/img2.jpg')?>
                <h4 class="text-center infoHomeTitulo">CONSEJOS PARA COMPRAR</h4>
                <p class="infoHomeTexto">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.
                </p>

                <div class="botonNovedad"><h5><a class="'btn btn-warning btn-sm" href="../galeria/view?idgaleria=8">Leer mas &raquo;</a></h5></div>
            </div>
            <div class="col-lg-4 bloque-novedad">
                <?= Html::img(Yii::getAlias('@web').'/images/img3.jpg')?>
                <h4 class="text-center infoHomeTitulo">NOVEDADES</h4>
                <p class="infoHomeTexto">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.
                </p>
                <div class="botonNovedad"><h5><a class="'btn btn-warning btn-sm" href="../galeria/view?idgaleria=8">Leer mas &raquo;</a></h5></div>
            </div>
        </div>
    </div>
</div>

