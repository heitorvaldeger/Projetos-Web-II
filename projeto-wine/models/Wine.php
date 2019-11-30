<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wine".
 *
 * @property int $id
 * @property string $description
 * @property string $designation
 * @property int $points
 * @property double $price
 * @property int $country_id
 * @property int $province_id
 * @property int $variety_id
 * @property int $winery_id
 *
 * @property Country $country
 * @property Province $province
 * @property Variety $variety
 * @property Winery $winery
 * @property WineRegion[] $wineRegions
 * @property Region[] $regions
 */
class Wine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['points', 'country_id', 'province_id', 'variety_id', 'winery_id'], 'integer'],
            [['price'], 'number'],
            [['designation'], 'string', 'max' => 100],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['variety_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variety::className(), 'targetAttribute' => ['variety_id' => 'id']],
            [['winery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Winery::className(), 'targetAttribute' => ['winery_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'designation' => Yii::t('app', 'Designation'),
            'points' => Yii::t('app', 'Points'),
            'price' => Yii::t('app', 'Price'),
            'country_id' => Yii::t('app', 'Country ID'),
            'province_id' => Yii::t('app', 'Province ID'),
            'variety_id' => Yii::t('app', 'Variety ID'),
            'winery_id' => Yii::t('app', 'Winery ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariety()
    {
        return $this->hasOne(Variety::className(), ['id' => 'variety_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWinery()
    {
        return $this->hasOne(Winery::className(), ['id' => 'winery_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWineRegions()
    {
        return $this->hasMany(WineRegion::className(), ['wine_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['id' => 'region_id'])->viaTable('wine_region', ['wine_id' => 'id']);
    }
}
