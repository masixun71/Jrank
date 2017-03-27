<?php

namespace Jue\Rank\Achieves\MutliCounterRank\GSetters;


use Jue\Rank\Achieves\CounterRank\CounterRank;
use Jue\Rank\Interfaces\IRedis;

trait Getters
{
    /**
     * @return IRedis|\Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }


    /**
     * @return array|CounterRank|\Jue\Rank\Achieves\CounterRank\CounterRank[]|string|\string[]
     */
    public function getRanks()
    {
        return $this->ranks;
    }

}