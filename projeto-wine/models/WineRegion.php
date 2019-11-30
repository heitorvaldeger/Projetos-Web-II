<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wine_region".
 *
 * @property int $region_id
 * @property int $wine_id
 *
 * @property Region $region
 * @property Wine $wine
 */
class WineRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wine_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'wine_id'], 'required'],
            [['region_id', 'wine_id'], 'integer'],
            [['region_id', 'wine_id'], 'unique', 'targetAttribute' => ['region_id', 'wine_id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['wine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wine::className(), 'targetAttribute' => ['wine_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_id' => Yii::t('app', 'Region ID'),
            'wine_id' => Yii::t('app', 'Wine ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWine()
    {
        return $this->hasOne(Wine::className(), ['id' => 'wine_id']);
    }
}
