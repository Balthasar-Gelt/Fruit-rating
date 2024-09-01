<?php

namespace app\services;

use yii\db\Query;
use yii\base\Component;

class RatingService extends Component
{
    function __construct(private FruitService $fruitService, private FruitDataTransformer $transformer) {}

    /**
     * Retrieves the top-rated fruits, optionally limited by a specified number.
     *
     * @param int|null $limit The maximum number of top-rated fruits to retrieve (null means no limit).
     * @return array The top-rated fruits with their ratings appended.
     */
    public function getTopRatedFruits(?int $limit = null): array
    {
        $topFruits = [];

        foreach ($this->getTopRatings($limit) as $rating) {
            $topFruits[] = $this->fruitService->getFruitData($rating['api_fruit_id']);
        }

        return $this->transformer->appendToFruits(['rating'], $topFruits);
    }

    /**
     * Retrieves the top fruit ratings, optionally limited by a specified number and ordered.
     *
     * @param int|null $limit The maximum number of top ratings to retrieve (null means no limit).
     * @param int|string $order The order of the ratings (default is descending).
     * @return array The top fruit ratings.
     */
    public function getTopRatings(?int $limit = null, int|string $order = SORT_DESC): array
    {
        return (new Query())
            ->select(['api_fruit_id', 'ROUND(AVG(rating), 1) AS average_rating'])
            ->from('comments')
            ->groupBy('api_fruit_id')
            ->orderBy(['average_rating' => $order])
            ->limit($limit)
            ->all();
    }
}
