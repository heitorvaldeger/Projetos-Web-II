<?php

namespace app\controllers;

use Yii;
use app\models\Membro;
use app\models\MembroSearch;
use app\models\MembroEquipe;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MembroController implements the CRUD actions for Membro model.
 */
class MembroController extends Controller
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
            'membro' => [
                'class' => \app\components\filters\MembroFilter::className(),
            ],
        ];
    }

    /**
     * Lists all Membro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MembroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Membro model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Membro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Membro();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }  
    
    /**
     * Updates an existing Membro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'foto');
            if ($model->imageFile != null) {                
                $model->upload();
                $model->imageFile = '';
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                $model->foto = self::getFotos($id);
                $model->imageFile = '';
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->nome = '';
        $model->email = '';
        $model->senha = '';
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    
    /**
     * Deletes an existing Membro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        MembroEquipe::find();
        $this->findModel($id)->delete();

        return $this->redirect(['site/index']);
    }

    /**
     * Ação para remover um membro da equipe
     */
    //Mudar o nome da ação
    public function actionTeste($idMembro, $idEquipe)
    {
        $model = MembroEquipe::searchMembroEquipe($idMembro, $idEquipe);
        $auth = Yii::$app->authManager;
        $auth->revokeAll('user'.$model->Membro_id.'equipe'.$model->Equipe_idEquipe);
        MembroEquipe::deleteMembro($idMembro, $idEquipe);
        return $this->redirect(['equipe/index']);
    }

    /**
     * Ação de promover ou rebaixar membros
     */
    public function actionPromoteDemote($idMembro, $idEquipe, $var)
    {
        $model = MembroEquipe::searchMembroEquipe($idMembro, $idEquipe);
        switch($var)
        {
            case 1:
                self::Demote($model);
                break;
            case 0:
                self::Promote($model);
                break;
            default:
                break;
        }
        return $this->redirect(['equipe/view', 'idEquipe' => $idEquipe]);
    }    

    /**
     * Finds the Membro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Membro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Membro::findOne($id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Método para promover membro
     */
    protected static function Promote($model)
    {
        // $auth = Yii::$app->authManager;
        // $membroRole = $auth->getRole('membroadmin');
        // $auth->assign($membroRole, $idMembro);
        // $model->role = $membroRole;
        $auth = Yii::$app->authManager;
        $membro = $auth->getRole('membro');
        $auth->revoke($membro, 'user'.$model->Membro_id.'equipe'.$model->Equipe_idEquipe);

        $role = $auth->getRole('membroadmin');
        $auth->assign($role, 'user'.$model->Membro_id.'equipe'.$model->Equipe_idEquipe);
        $model->Membro_administrador = 1;
        $model->save();
    }

    /**
     * Método para rebaixar membro
     */
    protected static function Demote($model)
    {
        // $auth = Yii::$app->authManager;
        // $membroRole = $auth->getRole('membro');
        // $auth->assign($membroRole, $idMembro);
        //$model->role = $membroRole;
        $auth = Yii::$app->authManager;
        $membroadmin = $auth->getRole('membroadmin');
        $auth->revoke($membroadmin, 'user'.$model->Membro_id.'equipe'.$model->Equipe_idEquipe);

        $role = $auth->getRole('membro');
        $auth->assign($role, 'user'.$model->Membro_id.'equipe'.$model->Equipe_idEquipe);
        $model->Membro_administrador = 0;
        $model->save();
    }

    /**
     * Obtém foto do perfil do usuário
     */
    public static function getFotos($id)
    {
        $model = Membro::find('foto')
        ->where('Membro.id=:id', [':id' => $id])
        ->one();

        return $model;
    }
}
