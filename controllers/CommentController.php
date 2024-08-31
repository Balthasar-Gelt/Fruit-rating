<?php

namespace app\controllers;

use app\models\Comment;
use Yii;

class CommentController extends \yii\web\Controller
{
    public function actionStore()
    {
        $fruitId = explode('=', parse_url(Yii::$app->request->referrer, PHP_URL_QUERY))[1];

        if (Yii::$app->request->isPost && $fruitId) {
            $comment = new Comment();
            $comment->attributes = Yii::$app->request->post();

            if ($comment->validate() && $comment->save()) {
                Yii::$app->session->setFlash('successMessages', ['Comment added']);
            } else {
                Yii::$app->session->setFlash('errorMessages', 'Comment was not added. Try again later.');
            }
        } else {
            Yii::$app->session->setFlash('errorMessages', 'Invalid request method.');
        }

        return $this->redirect(['fruit/show', 'id' => $fruitId]);
    }
}
