<?php

namespace app\controllers;

use Yii;
use app\models\User;

class UserController extends \yii\web\Controller
{
    public function actionStore()
    {
        $user = new User();

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);

            if ($user->save()) {
                Yii::$app->user->login($user);
                Yii::$app->session->setFlash('successMessages', ['Registration successful']);
                return $this->redirect(['site/index']);
            }
        }

        Yii::$app->session->setFlash('errorMessages', $user->getErrors());

        return $this->redirect(['site/register']);
    }
}
