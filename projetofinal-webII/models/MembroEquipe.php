<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "membro_equipe".
 *
 * @property int $Membro_administrador
 * @property int $Equipe_idEquipe
 * @property int $Membro_id
 *
 * @property Membro $membro
 * @property Equipe $equipeIdEquipe
 */
class MembroEquipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'membro_equipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Membro_administrador', 'Equipe_idEquipe', 'Membro_id'], 'integer'],
            [['Equipe_idEquipe', 'Membro_id'], 'required'],
            [['Equipe_idEquipe', 'Membro_id'], 'unique', 'targetAttribute' => ['Equipe_idEquipe', 'Membro_id']],
            [['Membro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Membro::className(), 'targetAttribute' => ['Membro_id' => 'id']],
            [['Equipe_idEquipe'], 'exist', 'skipOnError' => true, 'targetClass' => Equipe::className(), 'targetAttribute' => ['Equipe_idEquipe' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Membro_administrador' => Yii::t('app', 'Membro Administrador'),
            'Equipe_idEquipe' => Yii::t('app', 'Equipe Id Equipe'),
            'Membro_id' => Yii::t('app', 'Membro ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembro()
    {
        return $this->hasOne(Membro::className(), ['id' => 'Membro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipeIdEquipe()
    {
        return $this->hasOne(Equipe::className(), ['id' => 'Equipe_idEquipe']);
    }

    public function addMembroEquipe($idMembro, $idEquipe)
    {
        $this->Membro_id = $idMembro;
        $this->Equipe_idEquipe = $idEquipe;
        $this->Membro_administrador = 0;

        $auth = Yii::$app->authManager;
        $membroRole = $auth->getRole('membro');
        $auth->assign($membroRole, 'user'.$idMembro.'equipe'.$idEquipe);
        $this->save();
    }

    public static function searchMembroEquipe($idMembro, $idEquipe)
    {
        return MembroEquipe::findOne(['Equipe_idEquipe' => $idEquipe, 'Membro_id' => $idMembro]);
    }

    public static function deleteEquipe($id)
    {
        $models = MembroEquipe::find()->where(['Equipe_idEquipe' => $id])->all();        
        foreach($models as $model)
        {
            $model->delete();
        }
    }

    public static function deleteMembro($idMembro, $idEquipe)
    {
        $mb = MembroEquipe::find()->where(['Equipe_idEquipe' => $idEquipe, 'Membro_id' => $idMembro])->one();
        $mb->delete();
    }

    public static function listarMembroEquipe($idEquipe)
    {
        return MembroEquipe::find()->where(['Equipe_idEquipe' => $idEquipe])->all();
    }
}
