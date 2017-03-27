<?php

namespace Jue\Rank\Achieves\PagerRank\GSetters;


use Jue\Rank\Interfaces\ICounterRank;

trait Getters
{
    /**
     * @return ICounterRank
     */
    public function getCounterRank()
    {
        return $this->counterRank;
    }


    public function getHasMore()
    {
        return $this->hasMore;
    }

    public function getNextPage()
    {
        return $this->nextPage;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}