<?php

namespace app\components\filters;

use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;

class AuthFilters extends ActionFilter
{
	//Views que pertencem a permissão R (index, view)
	//Todo o restante pertence a permissão RW (create, update, delete)
	public static $permsR = ['index', 'view'];

	public function beforeAction ($action)
	{
		//Captura o nome do controlador
		$controlador = strtolower($action->controller->id);

		//Verifica dentro do array $permsR se o nome da ação existe.
		$terminacao = (in_array(strtolower($action->id), self::$permsR)) ? 'R' : 'RW';
		
		//Concatena o nome do controlador com a terminação referente a sua permissão
		$permissao = $controlador.$terminacao;
		if(!\Yii::$app->user->can($permissao))
		{
			throw new \yii\web\UnauthorizedHttpException("Você não está autorizado para acessar essa página");
		}
        return parent::beforeAction($action);
	}
}