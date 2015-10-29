<?php
namespace frontend\models;

use common\models\base\Pais;
use common\models\base\Provincia;
use common\models\base\Localidad;

use common\models\User;
use common\rbac\helpers\RbacHelper;
use nenad\passwordStrength\StrengthValidator;
use yii\base\Model;
use Yii;

/**
 * Model representing  Signup Form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    
    public $repeat_password;

    public $pais;
    public $pais_idpais;
    public $provincia_idprovincia;
    public $localidad_idlocalidad;
    public $captcha;
    public $telefono;
    public $telefonoalt;
    public $verifyCode;
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['localidad_idlocalidad', 'required'],
            ['telefono', 'required'],
            ['telefonoalt', 'string'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 
                'message' => 'This username has already been taken.'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 
                'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['repeat_password', 'required'],
            ['repeat_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Las contraseñas no coinciden" ],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),

            // on default scenario, user status is set to active
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            // status is set to not active on rna (registration needs activation) scenario
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE, 'on' => 'rna'],
            // status has to be integer value in the given range. Check User model.
            ['status', 'in', 'range' => [User::STATUS_NOT_ACTIVE, User::STATUS_ACTIVE]]
        ];
    }

    /**
     * Set password rule based on our setting value (Force Strong Password).
     *
     * @return array Password strength rule
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['fsp'];

        // password strength rule is determined by StrengthValidator 
        // presets are located in: vendor/nenad/yii2-password-strength/presets.php
        $strong = [['password'], StrengthValidator::className(), 'preset'=>'normal'];

        // use normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
    }    

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'telefono' => Yii::t('app', 'Telefono'),
            'telefonoalt' => Yii::t('app', 'Telefono Alternativo'),
            'pais_idpais' => Yii::t('app', 'País'),
            'provincia_idprovincia' => Yii::t('app', 'Provincia'),
            'localidad_idlocalidad' => Yii::t('app', 'Localidad'),
            'verifyCode' => Yii::t('app', 'Captcha'),
            'repeat_password' => Yii::t('app', 'Confirmar Contraseña'),
        ];
    }

    /**
     * Signs up the user.
     * If scenario is set to "rna" (registration needs activation), this means
     * that user need to activate his account using email confirmation method.
     *
     * @return User|null The saved model or null if saving fails.
     */
    public function signup()
    {
        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = $this->status;
        $user->telefono = $this->telefono;
        $user->telefonoalt = $this->telefonoalt;
        $user->localidad_idlocalidad = $this->localidad_idlocalidad;
        // if scenario is "rna" we will generate account activation token
        if ($this->scenario === 'rna')
        {
            $user->generateAccountActivationToken();
        }

        // if user is saved and role is assigned return user object
        return $user->save() && RbacHelper::assignRole($user->getId()) ? $user : null;
    }

    /**
     * Sends email to registered user with account activation link.
     *
     * @param  object $user Registered user.
     * @return bool         Whether the message has been sent successfully.
     */
    public function sendAccountActivationEmail($user)
    {
        return Yii::$app->mailer->compose('accountActivationToken', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' AutBook'])
            ->setTo($this->email)
            ->setSubject('Activacion de cuenta para  ' . Yii::$app->name)
            ->send();
    }
    public function getSubCatList($id)
    {
        $resultado=[];
        $countProvincias = \common\models\base\Provincia::find()
            ->where(['pais_idpais' => $id])
            ->count();

        $provincias = \common\models\base\Provincia::find()
            ->where(['pais_idpais' => $id])
            ->orderBy('nombre DESC')
            ->all();

        if($countProvincias>0){
            foreach($provincias as $provincia){
                $resultado[]=['id'=>$provincia->idprovincia, 'name'=>$provincia->nombre];
            }
        }
        return $resultado;
    }

    public function getProdList($cat_id, $subcat_id)
    {
        $resultado=[];
        $outV=[];
        $countLocalidades = \common\models\base\Localidad::find()
            ->where(['provincia_idprovincia' => $subcat_id])
            ->count();

        $localidades = \common\models\base\Localidad::find()
            ->where(['provincia_idprovincia' => $subcat_id])
            ->orderBy('nombre DESC')
            ->all();

        if($countLocalidades>0){
            foreach($localidades as $localidad){
                $outV[]=['id'=>$localidad->idlocalidad, 'name'=>$localidad->nombre];
            }
            $resultado=['out'=>$outV,'selected'=>$outV[0]['name']];
        }else{
            $resultado=[
                'out'=>[
                    //['id'=>'', 'name'=>'']
                ],
                'selected'=>''
            ];
        }


        //print_r($resultado);
        return $resultado;
    }
}
