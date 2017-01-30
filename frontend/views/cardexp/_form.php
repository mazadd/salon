<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Razon;
use common\models\Producto;
use common\models\Almacen;
use common\models\inventario;
use common\models\Cardexp;
use common\models\form\CardexForm;
/* @var $this yii\web\View */
/* @var $model common\models\Cardexp */
/* @var $modelInventario common\models\Inventario */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="cardexform-form">

 <?php $form = ActiveForm::begin(); ?>
  <?= $form->errorSummary($model,array('header'=>'Corrija los siguientes errores en cardex:')); ?>
  <?= $form->errorSummary($modelInventario,array('header'=>'Corrija los siguientes errores en inventario:')); ?>
    <div class="row">
        <?php //<?= $form->field($modelInventario->producto, 'linea_id')->dropDownList(common\models\Linea::getLineaDropBoxList()) ?> 
        <?php //<?= Html::dropDownList('Linea',null,common\models\Linea::getLineaDropBoxList(),['prompt'=>'Todos']) ?> 
        <div class="col-md-4">
        <?= $form->field($modelInventario, 'producto_id')->dropDownList(common\models\Producto::getProductoDropBoxList(),['prompt'=>'Seleccionar Producto']) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($modelInventario, 'almacen_id')->dropDownList(common\models\Almacen::getAlmacenDropBoxList(),['prompt'=>'Seleccionar Almacen']) ?>
        </div>
    </div>
       <div class="row">
    
        <div class="col-md-4">
    <?= $form->field($model, 'proveedor_id')->dropdownList(common\models\Proveedor::getProveedorDropBoxList()) ?>
    </div>
        
        <div class="col-md-3">
    <?= $form->field($model, 'cantidad')->textInput() ?>
    </div>
   
     <div class="col-md-3">
    <?= $form->field($model, 'razon_id')->dropDownList(common\models\Razon::getRazonDropBoxList()) ?>
    </div>
               <div class="col-lg-4">
    <?= $form->field($model, 'costo')->textInput() ?>
    <div class="form-group">    
        <?= Html::submitButton($model->isNewRecord ? 'Afectar' : 'Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
