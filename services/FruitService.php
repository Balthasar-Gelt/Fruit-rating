<?php

namespace app\services;

use app\models\Comment;
use Yii;
use yii\db\Query;

class FruitService
{
    // API URL for fetching fruit data
    private $apiUrl = 'https://fruityvice.com/api/fruit/';

    /**
     * Fetches fruit data from the API based on the provided query.
     *
     * @param string $query The query parameter for the API request.
     * @return array The fruit data returned by the API.
     * @throws \Exception If the API request fails.
     */
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

    /**
     * Retrieves the average rating for a fruit by its ID.
     *
     * @param int $id The ID of the fruit.
     * @return string|int The average rating, or 0 if no ratings are found.
     */
    public function getFruitRating(int $id): string|int
    {
        return (new Query())
            ->select(['ROUND(AVG(rating), 1) AS average_rating'])
            ->from('comments')
            ->where(['api_fruit_id' => $id])
            ->scalar() ?: 0;
    }

    /**
     * Retrieves the reviews for a fruit by its ID.
     *
     * @param int $id The ID of the fruit.
     * @return array The list of reviews for the fruit.
     */
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
