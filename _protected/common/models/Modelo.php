<?php

namespace common\models;

use Yii;
use \common\models\base\Modelo as BaseModelo;

/**
 * This is the model class for table "modelo".
 */
class Modelo extends BaseModelo
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'idmodelo' => Yii::t('app', 'Idmodelo'),
            'nombre' => Yii::t('app', 'Nombre'),
            'marca_idmarca' => Yii::t('app', 'Marca Idmarca'),
        ];
    }
}
