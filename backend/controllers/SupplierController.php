<?php

namespace backend\controllers;

use backend\models\Supplier;
use backend\models\SupplierSearch;
use backend\services\SupplierService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Supplier models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // 状态选项
        $statusOptions = (new SupplierService())->getStatusOptionsForGridView();

        // id范围标识选项
        $idRangeTags = (new SupplierService())->getIdRangeTags();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusOptions' => $statusOptions,
            'idRangeTags' => $idRangeTags
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        // 状态选项
        $statusOptions = (new SupplierService())->getStatusOptionsForGridView();

        return $this->render('create', [
            'model' => $model,
            'statusOptions' => $statusOptions,
        ]);
    }

    /**
     * 导出
     * @return false|string
     */
    public function actionExport()
    {
        if ($this->request->isPost) {
            $this->enableCsrfValidation = false;
            // 请求参数
            $params = $this->request->post();

            try{
                $url = (new SupplierService())->export($params);
                return json_encode(['code' => 200, 'message' => 'success', 'data' => ['url' => $url]]);
            }catch (\Exception $exception){
                return json_encode(['code' => 500, 'message' => $exception->getMessage(), 'data' => []]);
            }
        }
        return json_encode(['code' => 500, 'message' => '非法调用', 'data' => []]);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
