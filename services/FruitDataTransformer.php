<?php

namespace app\services;

class FruitDataTransformer
{
    // Default sort field (name of the fruit)
    private $defaultSort = 'name';

    // Default sort order (ascending)
    private $defaultOrder = SORT_ASC;

    // List of available appendable data fields (rating and comments)
    private $availableAppends = ['rating', 'comments'];

    function __construct(private FruitService $fruitService) {}

    /**
     * Sorts the fruit data array by a specified field and order.
     *
     * @param array $data The fruit data to sort.
     * @param string|null $sortBy The field to sort by (defaults to 'name' if null).
     * @param int|string|null $order The sort order, either 'asc'/'desc' or SORT_ASC/SORT_DESC (defaults to SORT_ASC if null).
     * @return array The sorted fruit data.
     */
    public function sortFruitData(array $data, string $sortBy = null, int|string $order = null): array
    {
        $sortBy = $sortBy ?? $this->defaultSort;
        $order = $order ?? $this->defaultOrder;

        usort($data, function ($a, $b) use ($sortBy, $order) {
            if ($order === 'asc' || $order === SORT_ASC) {
                return strcmp($a[$sortBy], $b[$sortBy]);
            }

            return strcmp($b[$sortBy], $a[$sortBy]);
        });

        return $data;
    }

    /**
     * Appends additional data (like rating or comments) to the fruit data array.
     *
     * @param array $appends Array of associations to be appended.
     * @param array $data The fruit data to modify.
     * @return array The modified fruit data with appended information.
     * @throws \Exception If a method to append the data does not exist.
     */
    public function appendToFruits(array $appends, array $data): array
    {
        $filteredAppends = $this->validateAppends($appends);

        foreach ($filteredAppends as $append) {
            $methodName = 'append' . ucfirst($append);

            if (method_exists($this, $methodName)) {
                $data = $this->$methodName($data);
            } else {
                throw new \Exception("Method $methodName does not exist in the Fruit Data Transformer class.");
            }
        }

        return $data;
    }

    /**
     * Validates the requested append types against the available ones.
     *
     * @param array $appends The append types requested by the user.
     * @return array The filtered and valid append types.
     * @throws \InvalidArgumentException If no valid append types are provided.
     */
    private function validateAppends(array $appends): array
    {
        $filteredAppends = [];

        foreach ($appends as $append) {
            if (in_array($append, $this->availableAppends)) {
                $filteredAppends[] = $append;
            }
        }

        if (empty($filteredAppends)) {
            throw new \InvalidArgumentException('No valid append types provided.');
        }

        return $filteredAppends;
    }

    /**
     * Appends the 'rating' data to each fruit in the data array.
     *
     * @param array $data The fruit data to modify.
     * @return array The modified fruit data with appended ratings.
     */
    private function appendRating(array $data): array
    {
        foreach ($data as &$fruit) {
            $fruit['rating'] = $this->fruitService->getFruitRating($fruit['id']);
        }

        return $data;
    }

    /**
     * Appends the 'comments' data to each fruit in the data array.
     *
     * @param array $data The fruit data to modify.
     * @return array The modified fruit data with appended comments.
     */
    private function appendComments(array $data): array
    {
        foreach ($data as &$fruit) {
            $fruit['comments'] = $this->fruitService->getFruitReviews($fruit['id']);
        }

        return $data;
    }
}
