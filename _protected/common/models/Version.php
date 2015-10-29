<?php

namespace common\models;

use Yii;
use \common\models\base\Version as BaseVersion;

/**
 * This is the model class for table "version".
 */
class Version extends BaseVersion
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'idversion' => 'Idversion',
            'nombre' => 'Nombre',
            'modelo_idmodelo' => 'Modelo Idmodelo',
        ];
    }
}
