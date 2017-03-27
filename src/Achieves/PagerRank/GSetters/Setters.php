<?php

namespace Jue\Rank\Achieves\PagerRank\GSetters;


use Jue\Rank\Interfaces\ICounterRank;

trait Setters
{
    /**
     * @param ICounterRank $counterRank
     * @return $this
     */
    private function setCounterRank($counterRank)
    {
        $this->counterRank = $counterRank;
        return $this;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    private function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @param mixed $total
     * @return $this
     */
    private function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @param mixed $currentPage
     * @return $this
     */
    private function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * @param mixed $hasMore
     * @return $this
     */
    private function setHasMore($hasMore)
    {
        $this->hasMore = $hasMore;
        return $this;
    }

    /**
     * @param mixed $nextPage
     * @return $this
     */
    private function setNextPage($nextPage)
    {
        $this->nextPage = $nextPage;
        return $this;
    }
}