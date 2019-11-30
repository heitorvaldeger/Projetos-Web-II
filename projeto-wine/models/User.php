<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $access_token
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    //Atributo que não vai para o banco de dados
    public $password_repeat;
    const SCENARIO_CADASTRO = 'cadastro';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
    public function beforeSave( $insert )
    {
        //Ação disparada no insert ou update.
        //Fazer a mágica aqui - atributos sujos (valores alterados).
        Yii::trace("Antes de criptografar");
        if (array_key_exists('password', $this->dirtyAttributes)) {
            $this->password = Yii:: $app->getSecurity()->generatePasswordHash($this->password);
            Yii::trace("Depois de criptografar");
        }
        return parent::beforeSave($insert);
    }
    public function afterSave( $insert, $changedAttributes ) {
        Yii::trace('VALORES MODIFICADOS');
        Yii::trace($changedAttributes);
        if (isset($changedAttributes['type']) || $insert) {
            Yii::trace('Entrou no IF do isset');
            $auth = Yii::$app->authManager;
            //Alterar, revogar papel e depois associar papel
            if(!$insert) {
                $auth->revokeAll($this->getId());
            }
            //Inserir, somente associar papel
            $novoPapel = $auth->getRole($this->type);
            $auth->assign($novoPapel,$this->getId());
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    public function afterDelete() {
        /*$auth = Yii::$app->authManager;        
        $auth->revokeAll($this->id);*/
        Yii::$app->authManager->revokeAll($this->getId());
    }
    public static function getTypes() {
        return [
            'admin'=>Yii::t('app','Admin'),
            'root'=>Yii::t('app','Root'),
            'usuario'=>Yii::t('app','User')
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'],'required'],
            [['password_repeat','type'],'required', 'on'=> [self::SCENARIO_CADASTRO]],
            //[['password'], 'compare'],
            [['password_repeat'], 'compare', 'compareAttribute'=>'password'],
            [['username'], 'string', 'max' => 45],
            //Tipo de usuario
            [['type'],'string'],
            //Enum
            [['type'],'in','range'=>['admin','root','usuario']],
            [['password', 'access_token', 'auth_key'], 'string', 'max' => 100],
            [['username'], 'unique'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'access_token' => Yii::t('app', 'Access Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
        ];
    }
    
    public static function findIdentity($id)
    {
        return User::findOne(['username'=>$id]);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    public function getId()
    {
        return $this->username;
    }
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    public function validatePassword($password){
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
}