<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string $nome
 * @property string $telefone
 * @property string $email
 * @property string $senha
 *
 * @property Projeto[] $projetos
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'telefone', 'email', 'senha'], 'required'],
            [['nome', 'email', 'senha'], 'string', 'max' => 100],
            [['telefone'], 'string', 'max' => 12],
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
            'telefone' => Yii::t('app', 'Telefone'),
            'email' => Yii::t('app', 'Email'),
            'senha' => Yii::t('app', 'Senha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjetos()
    {
        return $this->hasMany(Projeto::className(), ['Cliente_idCliente' => 'id']);
    }
}
