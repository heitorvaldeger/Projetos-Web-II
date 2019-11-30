<?php

namespace app\controllers;

use Yii;
use app\models\Equipe;
use app\models\EquipeSearch;
use app\models\Membro;
use app\models\MembroSearch;
use app\models\MembroEquipe;
use app\models\Projeto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\filters\AuthFilter;
/**
 * EquipeController implements the CRUD actions for Equipe model.
 */
class EquipeController extends Controller
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
            // 'login' => [
            //     'class' => 
            //LoginFilter::className(),                
            // ],
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
                'except' => ['create'],
            ],     
        ];
    }

    /**
     * Lists all Equipe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EquipeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);
    }

    /**
     * Displays a single Equipe model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idEquipe)
    {
        $modelMembro = new Membro();
        $listaDeMembros = MembroSearch::listarMembros($idEquipe);
        
        if ($modelMembro->load(Yii::$app->request->post())) {
            if($modelMembro = $this->findMember($modelMembro->email))
            {
                if(!MembroEquipe::searchMembroEquipe($modelMembro->id, $idEquipe))
                {
                    $me = new MembroEquipe();
                    $me->addMembroEquipe($modelMembro->id, $idEquipe);
                    return $this->refresh();
                }
                else
                {
                    throw new NotFoundHttpException(Yii::t('app', 'Membro já está associado a essa equipe!'));
                }
            }
        }

        return $this->render('view', [
            'model' => $this->findModel($idEquipe),
            'modelMembro' => $modelMembro,
            'listaDeMembros' => $listaDeMembros,
        ]);
    }

    /**
     * Creates a new Equipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Equipe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $auth = Yii::$app->authManager;
            $membroRole = $auth->getRole('membroadmin');
            $auth->assign($membroRole, 'user'.Yii::$app->user->identity->id.'equipe'.$model->id);
            return $this->redirect(['view', 'idEquipe' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Equipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idEquipe)
    {
        $model = $this->findModel($idEquipe);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idEquipe' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Equipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idEquipe)
    {
        MembroEquipe::deleteEquipe($idEquipe);
        Projeto::deleteAllProjects($idEquipe);
        $this->findModel($idEquipe)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Equipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Equipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findMember($id)
    {
        if(($modelMembro = Membro::findByEmail($id)) !== null)
        {
            return $modelMembro;
        }
        throw new NotFoundHttpException(Yii::t('app', 'Membro não encontrado!'));
    }

    // protected function listMember($id)
    // {
    //     if(($model = MembroSearch::listMembros($id)) !== null)
    //     {
    //         return $model;
    //     }
    //     throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    // }

    protected function findMembroEquipe($id)
    {
        return $membroEquipe = MembroEquipe::listarMembroEquipe($id);
    }
}
