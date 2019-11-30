<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dependentes".
 *
 * @property int $Requisitos_idRequisitos
 * @property int $Requisitos_idRequisitos_dep
 *
 * @property Requisitos $requisitosIdRequisitos
 * @property Requisitos $requisitosIdRequisitosDep
 */
class Dependentes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dependentes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Requisitos_idRequisitos', 'Requisitos_idRequisitos_dep'], 'required'],
            [['Requisitos_idRequisitos', 'Requisitos_idRequisitos_dep'], 'integer'],
            [['Requisitos_idRequisitos', 'Requisitos_idRequisitos_dep'], 'unique', 'targetAttribute' => ['Requisitos_idRequisitos', 'Requisitos_idRequisitos_dep']],
            [['Requisitos_idRequisitos'], 'exist', 'skipOnError' => true, 'targetClass' => Requisitos::className(), 'targetAttribute' => ['Requisitos_idRequisitos' => 'id']],
            [['Requisitos_idRequisitos_dep'], 'exist', 'skipOnError' => true, 'targetClass' => Requisitos::className(), 'targetAttribute' => ['Requisitos_idRequisitos_dep' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Requisitos_idRequisitos' => Yii::t('app', 'Requisitos Id Requisitos'),
            'Requisitos_idRequisitos_dep' => Yii::t('app', 'Requisitos Id Requisitos Dep'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitosIdRequisitos()
    {
        return $this->hasOne(Requisitos::className(), ['id' => 'Requisitos_idRequisitos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitosIdRequisitosDep()
    {
        return $this->hasOne(Requisitos::className(), ['id' => 'Requisitos_idRequisitos_dep']);
    }

    public function addDependente($idOrigem, $idDependente)
    {
        $this->Requisitos_idRequisitos = $idOrigem;
        $this->Requisitos_idRequisitos_dep = $idDependente;
    }
}
