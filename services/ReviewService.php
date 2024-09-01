<?php

namespace app\services;

use app\models\Comment;
use yii\base\Component;

class ReviewService extends Component
{
    function __construct(private FruitService $fruitService) {}

    /**
     * Retrieves the latest reviews, optionally limited by a specified number.
     *
     * @param int|null $limit The maximum number of reviews to retrieve (null means no limit).
     * @return array The latest reviews with associated fruit data.
     */
    public function getLatestReviews(?int $limit = null): array
    {
        $latestReviews = $this->getReviews($limit, ['created_at' => SORT_DESC], 'asArray');

        foreach ($latestReviews as &$review) {
            $review['fruit'] = $this->fruitService->getFruitData($review['api_fruit_id']);
        }

        return $latestReviews;
    }

    /**
     * Retrieves reviews based on optional parameters such as limit, order, and format.
     *
     * @param int|null $limit The maximum number of reviews to retrieve (null means no limit).
     * @param array|null $orderBy The sorting order for the reviews.
     * @param string|null $format The format in which to return the reviews (e.g., 'asArray').
     * @return array The retrieved reviews in the specified format.
     */
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
