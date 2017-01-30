<?php

namespace common\models;

use common\models\Producto;
use common\models\Proveedor;
use common\models\Almacen;
//use common\models\Cardexpatalogo;
use Yii;

/**
 * This is the model class for table "cardexp".
 *
 * @property integer $id
 * @property integer $inventario_id
 * @property integer $proveedor_id
 * @property integer $razon_id
 * @property boolean $tipo
 * @property integer $cantidad
 * @property string $costo
 * @property string $create_on
 * @property string $update_on
 * @property integer $create_id
 * @property integer $update_id
 *
 * @property Inventario $inventario
 * @property Proveedor $proveedor
 * @property Razon $razon
 * @property Usuario $create
 * @property Usuario $update
 */
class Cardexp extends \yii\db\ActiveRecord {

    public $nombre_cardexp;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cardexp';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cantidad'], 'required', 'message' => '{attribute} No puede estar vacío.'],
            [['inventario_id', 'proveedor_id', 'cantidad', 'create_id', 'update_id', 'razon_id'], 'integer'],
            [['costo'], 'number'],
            [['create_on', 'update_on'], 'safe'],
            [['inventario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventario::className(), 'targetAttribute' => ['inventario_id' => 'id']],
            [['razon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Razon::className(), 'targetAttribute' => ['razon_id' => 'id']],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['create_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['create_id' => 'id']],
            [['update_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['update_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Id',
            'inventario_id' => 'Inventario',
            'proveedor_id' => 'Proveedor',
            'almacen_id' => 'Almacen',
            'producto_id' => 'Producto',
            'razon_id' => 'Razon',
            'cantidad' => 'Cantidad',
            'costo' => 'Costo',
            'create_on' => 'Fecha de Creacion',
            'update_on' => 'Fecha de Actualizacion',
            'create_id' => 'Creado Por',
            'update_id' => 'Actualizado Por',
            'fecha' => 'Busqueda de Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventario() {
        return $this->hasOne(Inventario::className(), ['id' => 'inventario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor() {
        return $this->hasOne(Proveedor::className(), ['id' => 'proveedor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreate() {
        return $this->hasOne(Usuario::className(), ['id' => 'create_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdate() {
        return $this->hasOne(Usuario::className(), ['id' => 'update_id']);
    }

    public function getAlmacen() {
        return $this->hasOne(Almacen::className(), ['id' => 'almacen_id'])->via('inventario');
    }
    
    public function getProducto(){
        return $this->hasOne(Producto::className(), ['id' => 'producto_id'])->via('inventario');
    }

    public function getTotal() {
        if ($nombre = $nombre) {
            return Cardexp::find()->sum('cantidad');
        }
    }

    public function relationsInventarios() {
        return array(
            'Inventario' => array(self::BELONGS_TO, 'Inventario', 'inventario.id'),
        );
    }

    public function getRazon() {
        return $this->hasOne(Razon::className(), ['id' => 'razon_id']);
    }

}
