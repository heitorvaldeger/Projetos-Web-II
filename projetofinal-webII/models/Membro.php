<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "membro".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string $access_token
 * @property string $auth_key
 * @property string $foto
 *
 * @property MembroEquipe[] $membroEquipes
 * @property Equipe[] $equipeIdEquipes
 */
class Membro extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'membro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nome', 'email', 'senha'], 'required'],
            [['id'], 'integer'],
            [['nome'], 'string'],
            [['email', 'access_token', 'auth_key', 'foto'], 'string', 'max' => 45],
            [['senha'], 'string', 'max' => 100],
            [['email'], 'unique'],
            [['id'], 'unique'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

     /**
     * Validates the email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'email' => Yii::t('app', 'Email'),
            'senha' => Yii::t('app', 'Senha'),
            'access_token' => Yii::t('app', 'Access Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'foto' => Yii::t('app', 'Foto'),
        ];
    }

    public function beforeSave( $insert )
    {
        //Ação disparada no insert ou update.
        //Fazer a mágica aqui - atributos sujos (valores alterados).
        if (array_key_exists('senha', $this->dirtyAttributes)) {
            $this->senha = Yii:: $app->getSecurity()->generatePasswordHash($this->senha);
            Yii::trace($this->senha);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembroEquipes()
    {
        return $this->hasMany(MembroEquipe::className(), ['Membro_idMembro' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipeIdEquipes()
    {
        return $this->hasMany(Equipe::className(), ['id' => 'Equipe_idEquipe'])->viaTable('membro_equipe', ['Membro_idMembro' => 'id']);
    }    

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);        
    }

    // public static function findByUsername($id)
    // {
    //     return Membro::findOne(['nome' => $id]);
    // }

    public static function findByEmail($id)
    {
        return Membro::findOne(['email' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password){
        return Yii::$app->getSecurity()->validatePassword($password, $this->senha);
    }    

    public function upload()
    {
        Yii::trace($this->dirtyAttributes);
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . Yii::$app->user->identity->id . '.' . $this->imageFile->extension);
            $this->foto = 'uploads/' . Yii::$app->user->identity->id . '.' . $this->imageFile->extension;
            return true;
        } else {
            return false;
        }
    }
}
