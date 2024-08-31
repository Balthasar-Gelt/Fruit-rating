<?php

namespace app\controllers;

use app\models\Comment;
use app\services\FruitService;
use app\services\FruitDataTransformer;
use Yii;
use yii\web\NotFoundHttpException;

class FruitController extends \yii\web\Controller
{
    public function actionSearch()
    {
        if (Yii::$app->request->queryParams['query'] !== 'all') {
            return $this->redirect(['fruit/show', 'id' => Yii::$app->request->queryParams['query']]);
        }

        return $this->redirect('index');
    }

    public function actionIndex(FruitService $fruitService, FruitDataTransformer $transformer)
    {
        try {
            $fruitData = $fruitService->getFruitData('all');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['site/index']);
        }

        $fruitData = $transformer->appendToFruits(['rating'], $fruitData);
        $fruitData = $transformer->sortFruitData($fruitData, Yii::$app->request->get('sort'), Yii::$app->request->get('order'));

        return $this->render('index', ['fruits' => $fruitData]);
    }

    public function actionShow($id, FruitService $fruitService, FruitDataTransformer $transformer)
    {
        try {
            $fruitData[] = $fruitService->getFruitData($id);
        } catch (\Exception $e) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $fruitData = $transformer->appendToFruits(['rating', 'comments'], $fruitData);

        return $this->render('show', ['fruit' => $fruitData[0]]);
    }
}
