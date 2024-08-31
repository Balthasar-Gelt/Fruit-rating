<?php

namespace app\services;

use yii\db\Query;
use yii\base\Component;

class RatingService extends Component
{
    function __construct(private FruitService $fruitService, private FruitDataTransformer $transformer) {}

    public function getTopRatedFruits(?int $limit = null): array
    {
        $topFruits = [];

        foreach ($this->getTopRatings($limit) as $rating) {
            $topFruits[] = $this->fruitService->getFruitData($rating['api_fruit_id']);
        }

        return $this->transformer->appendToFruits(['rating'], $topFruits);
    }

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
