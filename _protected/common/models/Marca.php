<?php

namespace common\models;

use Yii;
use \common\models\base\Marca as BaseMarca;

/**
 * This is the model class for table "marca".
 */
class Marca extends BaseMarca
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'idmarca' => 'Idmarca',
            'nombre' => 'Nombre',
        ];
    }
}
