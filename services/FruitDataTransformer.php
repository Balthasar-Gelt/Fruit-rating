<?php

namespace app\services;

class FruitDataTransformer
{
    private $defaultSort = 'name';
    private $defaultOrder = SORT_ASC;
    private $availableAppends = ['rating', 'comments'];

    function __construct(private FruitService $fruitService) {}

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
     * Appends to provided fruits their given associations.
     *
     * @param array $appends Array of associations to be appended.
     * @param string $data Fruit data.
     * @return array Modified fruit data with appends.
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

    private function appendRating(array $data): array
    {
        foreach ($data as &$fruit) {
            $fruit['rating'] = $this->fruitService->getFruitRating($fruit['id']);
        }

        return $data;
    }

    private function appendComments(array $data): array
    {
        foreach ($data as &$fruit) {
            $fruit['comments'] = $this->fruitService->getFruitReviews($fruit['id']);
        }

        return $data;
    }
}
