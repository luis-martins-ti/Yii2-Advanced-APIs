<?php

namespace common\components;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class JwtAuth extends ActionFilter
{
  public function beforeAction($action)
  {
    $authHeader = Yii::$app->request->headers->get('Authorization');

    if ($authHeader && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
      $token = $matches[1];

      try {
        $decodedToken = Yii::$app->jwt->getParser()->parse((string) $token);

        // Verificar a validade do token
        if ($decodedToken->isExpired()) {
          throw new \Exception('Token expired');
        }

        // Adicione verificação adicional, se necessário

        return true; // Acesso autorizado
      } catch (\Throwable $e) {
        $this->sendError('Autentication Failed. Invalid token');
      }
    }

    $this->sendError('Autentication Failed. Token not provided');
  }

  private function sendError($message)
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->response->data = [
      'error' => $message,
    ];
    Yii::$app->response->setStatusCode(401);
    Yii::$app->end();
  }
}
