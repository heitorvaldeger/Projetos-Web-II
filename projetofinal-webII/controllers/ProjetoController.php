<?php

namespace app\controllers;

use Yii;
use app\models\Projeto;
use app\models\ProjetoSearch;
use app\models\RequisitosSearch;
use app\models\Requisitos;
use app\models\Equipe;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\components\filters\AuthFilter;

/**
 * ProjetoController implements the CRUD actions for Projeto model.
 */
class ProjetoController extends Controller
{
    public $layout = 'dashboard';
    public $idEquipe;

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
            'auth' => [
                'class' => AuthFilter::className(),
            ],         
        ];
    }

    /**
     * Lists all Projeto models.
     * @return mixed
     */
    //Perguntar viabilidade do parâmetro $idEquipe
    public function actionIndex($idEquipe)
    {
        // $equipe = Equipe::findOne($idEquipe);
        // if ($equipe) {}
        $searchModel = new ProjetoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idEquipe);
        //$this->idEquipe = $idEquipe;
        //Passar idEquipe no return
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'idEquipe' => $idEquipe,
        ]);
    }

    /**
     * Displays a single Projeto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idEquipe, $idProjeto)
    {
        return $this->render('view', [
            'model' => $this->findModel($idProjeto),
            'listaRequisitos' => $this->findRequisitos($idProjeto),
        ]);
    }

    /**
     * Creates a new Projeto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idEquipe)
    {
        $model = new Projeto();
        $model->Equipe_idEquipe = $idEquipe;
        $model->Cliente_idCliente = null;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idEquipe' => $idEquipe, 'idProjeto' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Projeto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idEquipe, $idProjeto)
    {
        $model = $this->findModel($idProjeto);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Projeto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    //PROBLEMA DA PASSAGEM DE PARÂMETROS NO REDIRECT, O ID DEVE SER DA EQUIPE
    public function actionDelete($idEquipe, $idProjeto )
    {
        Requisitos::deleteAll('Requisitos.Projeto_idProjeto=:id', [':id' => $idProjeto]);
        $this->findModel($idProjeto)->delete();

        return $this->redirect(['index',
            'idEquipe' => $idEquipe,
        ]);
    }

    /**
     * Finds the Projeto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Projeto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projeto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findRequisitos($id)
    {
        if(($model = RequisitosSearch::listarRequisitos($id)) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'Não foi possível listar os requisitos'));

    }
}
