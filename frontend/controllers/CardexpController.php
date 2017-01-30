<?php

namespace frontend\controllers;

use Yii;
use common\models\Cardexp;
use common\models\CardexpSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Inventario;
use yii\base\Model;

/**
 * CardexpController implements the CRUD actions for Cardexp model.
 */
class CardexpController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cardexp models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CardexpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cardexp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new Cardexp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Cardexp();

        //
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Entrada a new Cardexp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionEntrada() {
        $model = new Cardexp();
        $modelInventario = new Inventario();
        
        //$model->link('inventario', new Inventario());
        if ($model->load(Yii::$app->request->post()) && $modelInventario->load(Yii::$app->request->post())) {
            Yii::info("Inventario producto_id: {$modelInventario->producto_id} almacen_id: {$modelInventario->almacen_id}");
            $modelInventario->cantidad = $model->cantidad;
            if(Model::validateMultiple([$model,$modelInventario])) {
                $inventario = Inventario::find()->where('producto_id=:p and almacen_id=:a',[':p'=>$modelInventario->producto_id,':a'=>$modelInventario->almacen_id])->one();
                if($inventario !== null){//El inventario ya esta dado de alta se hace update
                    $inventario->cantidad = $inventario->cantidad + $model->cantidad;
                    $model->inventario_id = $inventario->id;
                    $inventario->update();
                } else {//primera vez, hay que insertar el registro de inventario
                    $modelInventario->cantidad = $model->cantidad;
                    $modelInventario->save();
                    $model->inventario_id = $modelInventario->id;
                }
                if($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::info("No se validaron los modelos");
            }
        } else {
            //$inventario = new Inventario;
            //$inventario->link('producto',\common\models\Producto::find()->one());
            //$inventario->link('almacen',\common\models\Almacen::find()->one());
            //$model->link('inventario',$inventario);
        }
        return $this->render('entrada', ['model' => $model, 'modelInventario' => $modelInventario]);
    }

    public function actionSalida() {
        $model = new Cardexp();
        //
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model1->id]);
        }
        return $this->render('salida', ['model' => $model]);
    }

    /**
     * Updates an existing Cardexp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = new Cardexp();
        //
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Finds the Cardexp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardexp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Cardexp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No se Encuentra la pagina que estas buscando.');
        }
    }

}
