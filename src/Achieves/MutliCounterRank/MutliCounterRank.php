<?php

namespace Jue\Rank\Achieves\MutliCounterRank;

use Jue\Rank\Achieves\MutliCounterRank\GSetters\Getters;
use Jue\Rank\Interfaces\ICounterRank;
use Jue\Rank\Interfaces\IRedis;

class MutliCounterRank
{

    use Getters;


    protected $ranks = [];
    protected $redis;

    /**
     * MutliCounterRank constructor.
     * @param ICounterRank[]|ICounterRank|string[]|string $counterRanks
     * @param \Redis|IRedis $redis
     */
    public function __construct($counterRanks, $redis)
    {
        if(is_array($counterRanks))
        {
            $this->ranks = $counterRanks;
        }
        else
        {
            $this->ranks[] = $counterRanks;
        }
        $this->redis = $redis;
    }

    /**
     * @param ICounterRank $counterRank
     * @param null $Weights
     * @param string $aggregateFunction
     * @return ICounterRank
     */
    public function union(ICounterRank $counterRank, $Weights = null, $aggregateFunction = "SUM")
    {
        $keys = array_map(function ($rank) {
            if($rank instanceof ICounterRank)
            {
                return $rank->getRankKey();
            }
            else
            {
                return $rank;
            }

        }, $this->getRanks());
        
        $this->getRedis()->zUnion($counterRank->getRankKey(), $keys, $Weights, $aggregateFunction);

        return $counterRank;
    }

    /**
     * 生成keys组成的交集  ($namespace,$groupName,$groupConnector)组成想要的交集的key
     *
     *
     * @param ICounterRank $counterRank
     * @param null $Weights
     * @param string $aggregateFunction
     * @return ICounterRank
     */
    public function inter(ICounterRank $counterRank, $Weights = null, $aggregateFunction = "SUM")
    {
        $keys = array_map(function ($rank) {
            if($rank instanceof ICounterRank)
            {
                return $rank->getRankKey();
            }
            else
            {
                return $rank;
            }

        }, $this->getRanks());

        $this->getRedis()->zInter($counterRank->getRankKey(), $keys, $Weights, $aggregateFunction);

        return $counterRank;
    }

}