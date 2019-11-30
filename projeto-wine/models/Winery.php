<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "winery".
 *
 * @property int $id
 * @property string $name
 *
 * @property Wine[] $wines
 */
class Winery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWines()
    {
        return $this->hasMany(Wine::className(), ['winery_id' => 'id']);
    }
}
