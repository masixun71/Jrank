<?php

namespace Jue\Rank\Achieves\CounterRank\GSetters;


trait Getters
{
    /**
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @return int
     */
    public function getUseFloat()
    {
        return $this->useFloat;
    }


    /**
     * @return string
     */
    public function getGroupConnector()
    {
        return $this->groupConnector;
    }
}