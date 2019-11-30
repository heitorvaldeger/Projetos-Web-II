<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projeto".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property int $Cliente_idCliente
 * @property int $Equipe_idEquipe
 *
 * @property Cliente $clienteIdCliente
 * @property Equipe $equipeIdEquipe
 * @property Requisitos[] $requisitos
 * @property Subprojetos[] $subprojetos
 */
class Projeto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projeto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'Equipe_idEquipe'], 'required'],
            [['nome'], 'string'],
            [['Cliente_idCliente', 'Equipe_idEquipe'], 'integer'],
            [['descricao'], 'string', 'max' => 45],
            [['Cliente_idCliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['Cliente_idCliente' => 'id']],
            [['Equipe_idEquipe'], 'exist', 'skipOnError' => true, 'targetClass' => Equipe::className(), 'targetAttribute' => ['Equipe_idEquipe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'descricao' => Yii::t('app', 'Descricao'),
            'Cliente_idCliente' => Yii::t('app', 'Cliente Id Cliente'),
            'Equipe_idEquipe' => Yii::t('app', 'Equipe Id Equipe'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::className(), ['id' => 'Cliente_idCliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipe()
    {        
        return $this->hasOne(Equipe::className(), ['id' => 'Equipe_idEquipe']);;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitos()
    {
        return $this->hasMany(Requisitos::className(), ['Projeto_idProjeto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubprojetos()
    {
        return $this->hasMany(Subprojetos::className(), ['projeto_id' => 'id']);
    }

    public static function deleteAllProjects($id)
    {
        $models = Projeto::find()->where('Equipe_idEquipe=:id', [':id' => $id])->all();        
        foreach($models as $model)
        {
            $model->delete();
        }
    }
}
