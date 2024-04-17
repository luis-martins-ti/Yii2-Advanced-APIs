<?php

namespace backend\controllers;

use Yii;
use yii\rest\Controller;
use backend\models\LoginForm;

class LoginController extends Controller
{
  public function actionIndex()
  {
    $bodyParams = json_decode(Yii::$app->request->getRawBody(), true);
    $model = new LoginForm();

    if ($model->load($bodyParams, '') && $model->login()) {
      $token = Yii::$app->jwt->getBuilder()
        ->setIssuer('https://www.coalize.com.br/') // Configurações adicionais JWT
        ->setAudience('https://www.coalize.com.br/')
        ->setIssuedAt(time())
        ->setExpiration(time() + 3600) // Tempo de expiração do token (por exemplo, 1 Hora)
        ->set('uid', Yii::$app->user->identity->id)
        ->getToken(); // Constrói o token JWT
      return ['token' => (string) $token];
    } else {
      Yii::$app->response->statusCode = 401;
      return ['error' => 'Unauthorized', 'msg' => $model->login()];
    }
  }
}
