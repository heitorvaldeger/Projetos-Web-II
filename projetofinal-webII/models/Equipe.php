<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipe".
 *
 * @property int $id
 * @property string $nomeOrganizacao
 *
 * @property MembroEquipe[] $membroEquipes
 * @property Membro[] $membroIdMembros
 * @property Projeto[] $projetos
 */
class Equipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomeOrganizacao'], 'required'],
            [['nomeOrganizacao'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nomeOrganizacao' => Yii::t('app', 'Nome Organizacao'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembroEquipes()
    {
        return $this->hasMany(MembroEquipe::className(), ['Equipe_idEquipe' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembroIdMembros()
    {
        return $this->hasMany(Membro::className(), ['id' => 'Membro_idMembro'])->viaTable('membro_equipe', ['Equipe_idEquipe' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjetos()
    {
        return $this->hasMany(Projeto::className(), ['Equipe_idEquipe' => 'id']);
    }

    public function afterSave($insert, $changedAtributtes)
    {
        if($insert)
        {
            Yii::trace("Entrou no if do afterSave");
            $mb = new MembroEquipe();
            $mb->Membro_administrador = 1;
            $mb->Equipe_idEquipe = $this->id;
            $mb->Membro_id = Yii::$app->user->identity->id;
            $mb->save();

            // $auth = Yii::$app->authManager;
            // $auth->revokeAll(Yii::$app->user->identity->id);
            // $membroadminRole = $auth->getRole('membroadmin');
            // $auth->assign($membroadminRole, Yii::$app->user->identity->id);
        }
    }
}
