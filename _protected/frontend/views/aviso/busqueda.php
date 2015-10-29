<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mis avisos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-admin">

    <h3>

    <?= Html::encode($this->title) ?>

    </h3>
    <?php //echo $this->render('_search',['model'=> $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [

            [
            'label'=>'Imagen',
           
            'options' => ['style' => 'width:20%'],
            'format'=>'raw',
            'value' => function($data){
                $count=0;
                foreach ($data->files as $file) {
                //echo Html::img($image->getUrl('small'));
                    if ($count<$data->publicacion->cantfotos) {
                        $items[] = [
                            'img' => $file->url,
                        ];
                    }else{
                        break;
                    }
                    $count++;
                }
                return  \metalguardian\fotorama\Fotorama::widget(
                    [
                        'items' => $items,
                        'options' => [
                            'nav' => 'false',
                        'loop' => true,
                        'hash' => true,
                        'ratio' => 800/600,
                        'width' => '150px',
                        'heith'=>'130px',
                        'allowfullscreen' => 'false',
                        ]
                    ]
                );
            }
            
        ],
           [
               'attribute'=>'titulo',
               'label'=>'Título',
               // 'filter'=>true,
               'options' => ['style' => 'width:40%'],
           ],
           [
               'attribute'=>'descripcion',
               'label'=>'Descripción',
               // 'filter'=>true,
               'options' => ['style' => 'width:40%'],
           ],     
            
          
        ],
    ]); ?>

</div>