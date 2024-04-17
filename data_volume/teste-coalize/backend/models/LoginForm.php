<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class LoginForm extends Model
{
  public $username;
  public $password;
  public $rememberMe = true;

  public function rules()
  {
    return [
      [['username', 'password'], 'required'],
      ['rememberMe', 'boolean'],
      ['password', 'validatePassword'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'username' => 'Username',
      'password' => 'Password',
      'rememberMe' => 'Remember Me',
    ];
  }

  public function validatePassword($attribute, $params)
  {
    if (!$this->hasErrors()) {
      $user = $this->getUser();
      if (!$user || !$user->validatePassword($this->password)) {
        $this->addError($attribute, 'username ou password incorretos.');
      }
    }
  }

  public function login()
  {
    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
    return false;
  }

  public function getUser()
  {
    return User::findByEmail($this->username);
  }
}
