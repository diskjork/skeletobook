<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Marca]].
 *
 * @see Marca
 */
class MarcaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Marca[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Marca|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}