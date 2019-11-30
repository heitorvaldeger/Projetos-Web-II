<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisitos".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property int $nivelPrioridade
 * @property string $estado
 * @property int $Projeto_idProjeto
 *
 * @property Commits[] $commits
 * @property Dependentes[] $dependentes
 * @property Dependentes[] $dependentes0
 * @property Requisitos[] $requisitosIdRequisitosDeps
 * @property Requisitos[] $requisitosIdRequisitos
 * @property Historico[] $historicos
 * @property Projeto $projetoIdProjeto
 */
class Requisitos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisitos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'nivelPrioridade', 'estado', 'Projeto_idProjeto'], 'required'],
            [['descricao', 'estado'], 'string'],
            [['nivelPrioridade', 'Projeto_idProjeto'], 'integer'],
            [['nome'], 'string', 'max' => 40],
            [['Projeto_idProjeto'], 'exist', 'skipOnError' => true, 'targetClass' => Projeto::className(), 'targetAttribute' => ['Projeto_idProjeto' => 'id']],
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
            'nivelPrioridade' => Yii::t('app', 'Nivel Prioridade'),
            'estado' => Yii::t('app', 'Estado'),
            'Projeto_idProjeto' => Yii::t('app', 'Projeto Id Projeto'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommits()
    {
        return $this->hasMany(Commits::className(), ['Requisitos_idRequisitos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependentes()
    {
        return $this->hasMany(Dependentes::className(), ['Requisitos_idRequisitos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependentes0()
    {
        return $this->hasMany(Dependentes::className(), ['Requisitos_idRequisitos_dep' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitosIdRequisitosDeps()
    {
        return $this->hasMany(Requisitos::className(), ['id' => 'Requisitos_idRequisitos_dep'])->viaTable('dependentes', ['Requisitos_idRequisitos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisitosIdRequisitos()
    {
        return $this->hasMany(Requisitos::className(), ['id' => 'Requisitos_idRequisitos'])->viaTable('dependentes', ['Requisitos_idRequisitos_dep' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricos()
    {
        return $this->hasMany(Historico::className(), ['Requisitos_idRequisitos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjetoIdProjeto()
    {
        return $this->hasOne(Projeto::className(), ['id' => 'Projeto_idProjeto']);
    }

    public function setIdProjeto($id)
    {
        $this->Projeto_idProjeto = $id;
    }

    // public static function deleteAllRequisitos($id)
    // {
    //     $models = Requisitos::find()
    //     ->where(['Requisitos.Projeto_idProjeto=:id', ':id' => $id])
    //     ->all();

    //     foreach($models as $model)
    //     {
    //         $model->delete();
    //     }
    // }
}
