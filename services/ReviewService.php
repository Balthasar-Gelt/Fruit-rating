<?php

namespace app\services;

use app\models\Comment;
use yii\base\Component;

class ReviewService extends Component
{
    function __construct(private FruitService $fruitService) {}

    public function getLatestReviews(?int $limit = null): array
    {
        $latestReviews = $this->getReviews(2, ['created_at' => SORT_DESC], 'asArray');

        foreach ($latestReviews as &$review) {
            $review['fruit'] = $this->fruitService->getFruitData($review['api_fruit_id']);
        }

        return $latestReviews;
    }

    public function getReviews(?int $limit = null, ?array $orderBy = null, ?string $format = null): array
    {
        $query = Comment::find()
            ->select(['text', 'rating', 'user_id', 'api_fruit_id'])
            ->with(['user' => function ($query) {
                $query->select(['id', 'name']);
            }])
            ->limit($limit);

        if ($orderBy) {
            $query->orderBy($orderBy);
        }

        if ($format && method_exists($query, $format)) {
            $query->$format();
        }

        return $query->all();
    }
}
