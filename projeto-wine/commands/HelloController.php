<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use app\models\Country;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionPermissoes()
    {        
        $auth = Yii::$app->authManager;

        //Remove todas as permissoes
        $auth->removeAll();

        //Criar os papéis  
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $root = $auth->createRole('root');
        $auth->add($root);
        $usuario = $auth->createRole('usuario');
        $auth->add($usuario);

        $tables = ['variety', 'country', 'province', 'winery', 'region'];

        foreach ($tables as $table) 
        {
            //Cria o objeto que representa a permissão
            $permRW = $auth->createPermission($table.'RW');
            $permR = $auth->createPermission($table.'R');

            //Informa ao gerenciador de autenticação/autorização
            //que estas permissões existem
            $auth->add($permRW);
            $auth->add($permR);           

            //Informa que o admin pode executar a permissão RW
            $auth->addChild($admin, $permRW);
            //Informa que o usuario pode executar a permissão R
            $auth->addChild($usuario, $permR);
        }

        //Cria o objeto de permissão RW para a tabela wine
        $wineRW = $auth->createPermission('wineRW');
        $wineR = $auth->createPermission('wineR');        
        $auth->add($wineRW);
        $auth->add($wineR);
        //Informa que o usuário pode ler e escrever na tabela wine
        $auth->addChild($usuario, $wineR);
        $auth->addChild($usuario, $wineRW);

        //Cria o objeto de permissão RW para a tabela user
        $userRW = $auth->createPermission('userRW');
        $userR = $auth->createPermission('userR');
        $auth->add($userRW);
        $auth->add($userR);
        //Informa que o root pode ler e escrever na tabela user
        $auth->addChild($root, $userR);
        $auth->addChild($root, $userRW);

        //Informa que o admin possui todas as características que o usuário tem
        $auth->addChild($admin, $usuario);        
        //Informa que o root possui todas as características que o admin tem
        $auth->addChild($root, $admin);

        //Busca por usuário root
        $obj = User::findOne(['username' => 'root']);
        if(!$obj)
        {
            $obj = new User();
            $obj->username = 'root';
            $obj->password = '12345';   
            $obj->save();   
        }
     
        //associa a permissão de root ao id do usuario root
        $auth->assign($root, $obj->id);

    }

}