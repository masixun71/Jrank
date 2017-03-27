<?php

namespace Jue\Rank\Achieves\CounterRank\GSetters;


use Jue\Rank\Interfaces\IRedis;

trait Setters
{
    /**
     * @param IRedis $redis
     * @return $this
     */
    public function setRedis($redis)
    {
        $this->redis = $redis;
        return $this;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @param boolean $useFloat
     * @return $this
     */
    public function setUseFloat($useFloat)
    {
        $this->useFloat = $useFloat;
        return $this;
    }

    /**
     * 设置分组名
     * @param $groupName
     * @return $this
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
        return $this;
    }


    /**
     * @param string $groupConnector
     * @return $this
     */
    public function setGroupConnector($groupConnector)
    {
        $this->groupConnector = $groupConnector;
        return $this;
    }


}