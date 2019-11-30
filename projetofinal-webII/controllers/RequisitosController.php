<?php

namespace app\controllers;

use Yii;
use app\models\Requisitos;
use app\models\RequisitosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Dependentes;
/**
 * RequisitosController implements the CRUD actions for Requisitos model.
 */
class RequisitosController extends Controller
{
    public $layout = 'dashboard';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Requisitos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequisitosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Requisitos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idEquipe, $idProjeto, $idRequisito)
    {
        $searchModel = new RequisitosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($idRequisito),
            'requirements' => $this->listAllRequirements($idProjeto),
            'requisito' => $idRequisito,
            'dataProvider' => $dataProvider,
            'idEquipe' => $idEquipe, 
        ]);
    }

    /**
     * Creates a new Requisitos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idEquipe, $idProjeto)
    {
        $model = new Requisitos();

        $model->setIdProjeto($idProjeto);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['projeto/view', 'idEquipe' => $idEquipe, 'idProjeto' => $idProjeto]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Requisitos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idEquipe, $idProjeto, $idRequisito)
    {
        $model = $this->findModel($idRequisito);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idEquipe' => $idEquipe, 'idProjeto' => $idProjeto, 'idRequisito' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Requisitos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteRequisito($idEquipe, $idProjeto, $idRequisito)
    {
        $models = Dependentes::find()->where('Dependentes.Requisitos_idRequisitos=:id', [':id' => $idRequisito])->all();
        foreach ($models as $model) {
            $model->delete();
        }
        $this->findModel($idRequisito)->delete();

        return $this->redirect(['projeto/view', 'idEquipe' => $idEquipe, 'idProjeto' => $idProjeto]);
    }

    public function actionDeleteDependente($idEquipe, $idRequisito, $idDependente, $idProjeto)
    {
        $model = Dependentes::find()->where(['Dependentes.Requisitos_idRequisitos' => $idRequisito, 
                                            'Dependentes.Requisitos_idRequisitos_dep' => $idDependente])->one();
        if($model->delete())
        {
            return $this->redirect(['requisitos/view', 'idEquipe' => $idEquipe, 'idRequisito' => $idRequisito, 'idProjeto' => $idProjeto]);
        }
    }

    public function actionAddDependente($idEquipe, $idRequisito, $idDependente, $idProjeto)
    {
        $searchModel = new RequisitosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Dependentes();
        $model->addDependente($idRequisito, $idDependente);
        if($model->save())
        {            
            return Yii::$app->runAction('requisitos/view', ['idEquipe' => $idEquipe,'idRequisito' => $idRequisito, 'idProjeto' => $idProjeto]);
        }
    }

    /**
     * Finds the Requisitos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Requisitos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requisitos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function listAllRequirements($idProjeto)
    {
        $model = Requisitos::find('id, nome, descricao')
        ->where('Requisitos.Projeto_idProjeto=:id', [':id' => $idProjeto])
        ->all();
        if($model !== null)
        {
            return $model;
        }

        return false;
    }
    
}
