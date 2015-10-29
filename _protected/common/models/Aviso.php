<?php
namespace common\models;

//use common\models\base\Solicituddepago;
use common\models\User;
use common\models\Color;
use common\models\Marca;
use common\models\Modelo;
use common\models\Pago;

use Faker\Provider\tr_TR\DateTime;
use frontend\models\base\Seguridad;
use frontend\models\base\Confort;
use frontend\models\base\Multimedia;
use frontend\models\base\Exterior;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

use common\models\base\Version;
use common\models\Publicacion;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $titulo
 * @property string $descripcion
 * @property string $content
 * @property integer $estado
 * @property integer $categoria
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Aviso extends ActiveRecord
{
    const STATUS_PENDIENTE = 1;
    const STATUS_PUBLICADO = 2;

    const CATEGORIA_NUEVO = 1;
    const CATEGORIA_USADO = 2;

    //Combustible
    const COMB_NAFTA = 1;
    const COMB_DIESEL = 2;
    const COMB_NAFTAGNC = 3;
    const COMB_ELECTRICO = 4;
    const COMB_OTRO =5;

    //Transmision
    const TRANS_AUTO = 1;
    const TRANS_MAN = 2;

    //Direccion
    const DIR_MEC = 1;
    const DIR_HID = 2;
    const DIR_ASI = 3;

    //Puertas
    const PUE_2 = 1;
    const PUE_3 = 2;
    const PUE_4 = 3;
    const PUE_5 = 4;

    //Moneda
    const MON_PES = 1;
    const MON_USD = 2;
    const MON_EUR = 3;

    //Tipomotor
    const MOT_DOS = 1;
    const MOT_CUATRO = 2;

    public $captcha;

    //Tipo
    const AUTO = 1;
    const CAMION = 2;
    const CASARODANTE = 3;
    const MOTO = 4;

    const SCENARIO_ADVVIEW = 'advview';
    const SCENARIO_CARGA = 'carga';
    const SCENARIO_AUTO = 'cargaauto';
    const SCENARIO_CAMION = 'cargacamion';
    const SCENARIO_CRODANTE = 'cargacrodante';
    const SCENARIO_MOTO = 'cargamoto';

    //Cantidad de avisos destacados
    const CANTAVISOSDEST = 10;
    /**
     * Declares the name of the database table associated with this AR class.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%aviso}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADVVIEW] = ['id', 'titulo'];
        $scenarios[self::SCENARIO_CARGA] = ['tipo'];
        $scenarios[self::SCENARIO_AUTO] = [
            'user_id', 'titulo','descripcion',
            'version_idversion','categoria','puertas','publicacion_id','direccion','transmision',
            'combustible','marca_idmarca','modelo_idmodelo','anio','color_idcolor','kilometros','precio','moneda','captcha'
        ];
        $scenarios[self::SCENARIO_CAMION] = [
                'user_id', 'titulo','descripcion',
                'categoria','publicacion_id','direccion','transmision',
                'combustible','marca_idmarca','anio','color_idcolor','kilometros','precio','moneda','captcha','modelo',
                'motor','marchas','potmaxima','largototal','capacidadtanque'
            ];

        $scenarios[self::SCENARIO_CRODANTE] = [
            'user_id', 'titulo','descripcion',
            'categoria','publicacion_id','direccion','transmision',
            'combustible','marca_idmarca','modelo','version','anio','color_idcolor','kilometros','precio','moneda','captcha',
            'motor','marchas','potmaxima','largototal','capacidadtanque','cpersonas'
        ];

        $scenarios[self::SCENARIO_MOTO] = [
            'user_id', 'titulo','descripcion',
            'categoria','publicacion_id','marca_idmarca','modelo','anio','kilometros','precio','moneda','captcha',
            'tipomotor','cilindrada'
        ];


        return $scenarios;
    }

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'titulo','descripcion',
                'version_idversion','categoria','puertas','publicacion_id','direccion','transmision',
                'combustible','marca_idmarca','modelo_idmodelo','anio','color_idcolor','kilometros','precio','moneda','captcha','modelo',
                'version','cpersonas','tipomotor','cilindrada'
            ], 'required'],
            ['captcha', 'captcha'],
            [['user_id', 'estado', 'categoria','combustible','transmision',
                'direccion','puertas','publicacion_id','color_idcolor','anio','eliminado','tipo','tipomotor'
            ], 'integer'],
            [['largototal','capacidadtanque','cpersonas','cilindrada'],'number'],
            [['descripcion'], 'string', 'max' => 500],
            [['titulo','modelo','modelo','version','motor','marchas','potmaxima'], 'string', 'max' => 255],

        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'fileBehavior' => [
                'class' => \nemmo\attachments\behaviors\FileBehavior::className()
            ],
            'hit' => [
                'class' => \usualdesigner\yii2\behavior\HitableBehavior::className(),
                'attribute' => 'visitas',    //attribute which should contain uniquie hits value
                'group' => false,               //group name of the model (class name by default)
                'delay' => 60 * 60,             //register the same visitor every hour
                'table_name' => '{{%hits}}'     //table with hits data
            ]

        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Author'),
            'titulo' => Yii::t('app', 'Titulo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'estado' => Yii::t('app', 'Estado'),
            'categoria' => Yii::t('app', 'Categoria'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'marca_idmarca'=> Yii::t('app','Marca'),
            'modelo_idmodelo'=> Yii::t('app','Modelo'),
            'version_idversion'=> Yii::t('app','Version'),
            'color_idcolor'=> Yii::t('app','Color'),
            'anio'=> Yii::t('app','Año'),
            'combustible' => Yii::t('app','Combustible'),
            'direccion' => Yii::t('app','Direccion'),
            'transmision' => Yii::t('app','Transmision'),
            'publicacion_id' => Yii::t('app','Tipo de publicacion'),
            'tipo' => Yii::t('app','Tipo de vehiculo'),
            'motor' => Yii::t('app','Motor'),
            'potmaxima' => Yii::t('app','Potencia max.'),
            'capacidadtanque' => Yii::t('app','Tanque comb. (ltrs.)'),
            'largototal' => Yii::t('app','Largo total (mts.)'),
            'cpersonas' => Yii::t('app','Capacidad personas'),
            'tipomotor' => Yii::t('app','Tipo de motor'),
            'cilindrada' => Yii::t('app','Cilindrada'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColorIdcolor()
    {
        return $this->hasOne(Color::className(), ['idcolor' => 'color_idcolor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcaIdmarca()
    {
        return $this->hasOne(Marca::className(), ['idmarca' => 'marca_idmarca']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeloIdmodelo()
    {
        return $this->hasOne(Modelo::className(), ['idmodelo' => 'modelo_idmodelo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicacion()
    {
        return $this->hasOne(Publicacion::className(), ['idpublicacion' => 'publicacion_id']);
    }

    public function getSolicitudepago()
    {
        return $this->hasOne(Solicituddepago::className(), ['aviso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersionIdversion()
    {
        return $this->hasOne(Version::className(), ['idversion' => 'version_idversion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConforts()
    {
        return $this->hasMany(Confort::className(), ['aviso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExteriors()
    {
        return $this->hasMany(Exterior::className(), ['aviso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMultimedia()
    {
        return $this->hasMany(Multimedia::className(), ['aviso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagos()
    {
        return $this->hasMany(Pago::className(), ['aviso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguridads()
    {
        return $this->hasMany(Seguridad::className(), ['aviso_id' => 'id']);
    }

    /**
     * Gets the id of the article creator.
     * NOTE: needed for RBAC Author rule.
     * 
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->user_id;
    }

    /**
     * Gets the author name from the related User table.
     * 
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->user->username;
    }

    public function getNombrePublicacion()
    {
        return $this->publicacion->nombre;
    }


    /**
     * Returns the article estado in nice format.
     *
     * @param  null|integer $estado estado integer value if sent to method.
     * @return string               Nicely formatted estado.
     */
    public function getStatusName($estado = null)
    {
        $estado = (empty($estado)) ? $this->estado : $estado ;

        if ($estado === self::STATUS_PENDIENTE)
        {
            return Yii::t('app', 'Pendiente');
        }
        else
        {
            return Yii::t('app', 'Publicado');
        }
    }

    /**
     * Returns the array of possible article estado values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_PENDIENTE     => Yii::t('app', 'Pendiente'),
            self::STATUS_PUBLICADO => Yii::t('app', 'Publicado'),
        ];

        return $statusArray;
    }

    /**
     * Returns the article categoria in nice format.
     *
     * @param  null|integer $categoria categoria integer value if sent to method.
     * @return string                 Nicely formatted categoria.
     */
    public function getCategoryName($categoria = null)
    {
        $categoria = (empty($categoria)) ? $this->categoria : $categoria ;

        if ($categoria === self::CATEGORIA_NUEVO)
        {
            return Yii::t('app', 'Nuevo');
        }
        else
        {
            return Yii::t('app', 'Usado');
        }
    }

    /**
     * Returns the array of possible article categoria values.
     *
     * @return array
     */
    public function getCategoryList()
    {
        $statusArray = [
            self::CATEGORIA_NUEVO => Yii::t('app', 'Nuevo'),
            self::CATEGORIA_USADO => Yii::t('app', 'Usado'),
        ];

        return $statusArray;
    }
    public function getSubCatList($id)
    {
        $resultado=[];
        $countModelos = \common\models\base\Modelo::find()
            ->where(['marca_idmarca' => $id])
            ->count();

        $modelos = \common\models\base\Modelo::find()
            ->where(['marca_idmarca' => $id])
            ->orderBy('nombre DESC')
            ->all();

        if($countModelos>0){
            foreach($modelos as $modelo){
                $resultado[]=['id'=>$modelo->idmodelo, 'name'=>$modelo->nombre];
            }
        }
        return $resultado;
    }

    public function getProdList($cat_id, $subcat_id)
    {
        $resultado=[];
        $outV=[];
        $countVersiones = \common\models\base\Version::find()
            ->where(['modelo_idmodelo' => $subcat_id])
            ->count();

        $versiones = \common\models\base\Version::find()
            ->where(['modelo_idmodelo' => $subcat_id])
            ->orderBy('nombre DESC')
            ->all();

        if($countVersiones>0){
            foreach($versiones as $version){
                $outV[]=['id'=>$version->idversion, 'name'=>$version->nombre];
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

    //COMBUSTIBLE
    public function getCombustibleName($combustible = null)
    {
        $combustible = (empty($combustible)) ? $this->combustible : $combustible ;

        if ($combustible === self::COMB_DIESEL)
        {
            return Yii::t('app', 'Diesel');
        }
        elseif ($combustible === self::COMB_ELECTRICO)
        {
            return Yii::t('app', 'Electrico');
        }
        elseif ($combustible === self::COMB_NAFTA)
        {
            return Yii::t('app', 'Nafta');
        }
        elseif ($combustible === self::COMB_NAFTAGNC)
        {
            return Yii::t('app', 'Nafta/GNC');
        }
        else
        {
            return Yii::t('app', 'Otro');
        }
    }
    public function getCombustibleList()
    {
        $statusArray = [
            self::COMB_DIESEL     => Yii::t('app', 'Diesel'),
            self::COMB_ELECTRICO     => Yii::t('app', 'Electrico'),
            self::COMB_NAFTA     => Yii::t('app', 'Nafta'),
            self::COMB_NAFTAGNC     => Yii::t('app', 'Nafta/GNC'),
            self::COMB_OTRO     => Yii::t('app', 'Otro'),
        ];

        return $statusArray;
    }

    //TRANSMISION
    public function getTransmisionName($transmision = null)
    {
        $transmision = (empty($transmision)) ? $this->transmision : $transmision ;

        if ($transmision === self::TRANS_AUTO)
        {
            return Yii::t('app', 'Automatica');
        }
       else
        {
            return Yii::t('app', 'Manual');
        }
    }
    public function getTransmisionList()
    {
        $statusArray = [
            self::TRANS_AUTO     => Yii::t('app', 'Automatica'),
            self::TRANS_MAN     => Yii::t('app', 'Manual'),
        ];
        return $statusArray;
    }



    //DIRECCION
    public function getDireccionName($direccion = null)
    {
        $direccion = (empty($direccion)) ? $this->direccion : $direccion ;

        if ($direccion === self::DIR_ASI)
        {
            return Yii::t('app', 'Asistida');
        }
        elseif ($direccion === self::DIR_HID)
        {
            return Yii::t('app', 'Hidráulica');
        }
        else
        {
            return Yii::t('app', 'Mecánica');
        }
    }
    public function getDireccionList()
    {
        $statusArray = [
            self::DIR_ASI     => Yii::t('app', 'Asistida'),
            self::DIR_HID     => Yii::t('app', 'Hidráulica'),
            self::DIR_MEC     => Yii::t('app', 'Mecánica'),
        ];
        return $statusArray;
    }


    //PUERTAS
    public function getPuertaName($puertas = null)
    {
        $puertas = (empty($puertas)) ? $this->puertas : $puertas ;

        if ($puertas === self::PUE_2)
        {
            return Yii::t('app', '2');
        }
        elseif ($puertas === self::PUE_3)
        {
            return Yii::t('app', '3');
        }
        elseif ($puertas === self::PUE_4)
        {
            return Yii::t('app', '4');
        }
        else
        {
            return Yii::t('app', '5 o más');
        }
    }
    public function getPuertaList()
    {
        $statusArray = [
            self::PUE_2     => Yii::t('app', '2'),
            self::PUE_3     => Yii::t('app', '3'),
            self::PUE_4     => Yii::t('app', '4'),
            self::PUE_5     => Yii::t('app', '5 o más'),
        ];
        return $statusArray;
    }

    //MONEDA
    public function getMonedaName($moneda = null)
    {
        $moneda = (empty($moneda)) ? $this->moneda : $moneda ;

        if ($moneda === self::MON_PES)
        {
            return Yii::t('app', 'Pesos');
        }
        elseif ($moneda === self::MON_USD)
        {
            return Yii::t('app', 'Dolares');
        }
        else
        {
            return Yii::t('app', 'Euros');
        }
    }

    //MONEDA
    public function getMonedaNameAbrv($moneda = null)
    {
        $moneda = (empty($moneda)) ? $this->moneda : $moneda ;

        if ($moneda === self::MON_PES)
        {
            return Yii::t('app', 'ARS');
        }
        elseif ($moneda === self::MON_USD)
        {
            return Yii::t('app', 'USD');
        }
        else
        {
            return Yii::t('app', 'EUR');
        }
    }

    public function getMonedaList()
    {
        $statusArray = [
            self::MON_PES => Yii::t('app', 'Pesos'),
            self::MON_USD => Yii::t('app', 'Dolares'),
            self::MON_EUR => Yii::t('app', 'Euros'),
        ];
        return $statusArray;
    }

    public function getExpira($creado = null,$duracion = null)
    {
        $creado = (empty($creado)) ? $this->created_at : $creado ;
        $duracion = (empty($duracion)) ? $this->publicacion->duracion : $duracion ;

        $creado=Yii::$app->formatter->asDate($creado,'php:d-m-Y');
        $fechaExpira = date('d/m/Y', strtotime($creado. ' + '.$duracion.' days'));
        return $fechaExpira;
    }

    //TIPO DE VEHICULO - auto/camioneta, camion, casarodante, moto
    public function getTipo($tipo = null)
    {
        $tipo = (empty($tipo)) ? $this->tipo : $tipo ;

        if ($tipo === self::AUTO)
        {
            return Yii::t('app', 'Auto/Camioneta');
        }
        elseif ($tipo === self::CAMION)
        {
            return Yii::t('app', 'Camion');
        }
        elseif ($tipo === self::CASARODANTE)
        {
            return Yii::t('app', 'Casilla Rodante');
        }
        else
        {
            return Yii::t('app', 'Moto');
        }
    }
    public function getTipoList()
    {
        $statusArray = [
            self::AUTO     => Yii::t('app', 'Auto/Camioneta'),
            self::CAMION     => Yii::t('app', 'Camion'),
            self::CASARODANTE     => Yii::t('app', 'Casilla Rodante'),
            self::MOTO     => Yii::t('app', 'Moto'),
        ];

        return $statusArray;
    }

    //Tipo de motor
    public function getTipoMotor($tipomotor = null)
    {
        $tipomotor = (empty($tipomotor)) ? $this->tipomotor : $tipomotor ;

        if ($tipomotor === self::MOT_DOS)
        {
            return Yii::t('app', '2 tiempos');
        }
        else
        {
            return Yii::t('app', '4 tiempos');
        }
    }

    /**
     * Returns the array of possible article estado values.
     *
     * @return array
     */
    public function getTipoMotorList()
    {
        $statusArray = [
            self::MOT_DOS     => Yii::t('app', '2 tiempos'),
            self::MOT_CUATRO => Yii::t('app', '4 tiempos'),
        ];

        return $statusArray;
    }

}
