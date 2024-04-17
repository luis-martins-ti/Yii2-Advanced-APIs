<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;

class CreateUserController extends Controller
{
  public function actionCreate($email, $password, $username)
  {
    $user = new User();
    $user->email = $email;
    $user->setPassword($password);
    $user->username = $username;
    $user->generateAuthKey();

    if ($user->save()) {
      echo "Usuário criado com sucesso!\n";
    } else {
      echo "Erro ao criar o usuário:\n";
      print_r($user->getErrors());
    }
  }
}
