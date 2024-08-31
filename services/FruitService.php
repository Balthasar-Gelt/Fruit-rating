<?php

namespace app\services;

use app\models\Comment;
use Yii;
use yii\db\Query;

class FruitService
{
    private $apiUrl = 'https://fruityvice.com/api/fruit/';

    public function getFruitData(string $query): array
    {
        $url = $this->apiUrl . "$query";
        $response = Yii::$app->httpClient->get($url)->send();

        if ($response->isOk) {
            return $response->data;
        } else {
            throw new \Exception('Failed to fetch fruit data.');
        }
    }

    public function getFruitRating(int $id): string|int
    {
        return (new Query())
            ->select(['ROUND(AVG(rating), 1) AS average_rating'])
            ->from('comments')
            ->where(['api_fruit_id' => $id])
            ->scalar() ?: 0;
    }

    public function getFruitReviews(int $id): array
    {
        return Comment::find()
            ->with(['user' => function ($query) {
                $query->select(['id', 'name']);
            }])
            ->where(['api_fruit_id' => $id])
            ->asArray()
            ->all();
    }
}
