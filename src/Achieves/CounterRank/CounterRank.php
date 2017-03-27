<?php

namespace Jue\Rank\Achieves\CounterRank;
use Jue\Rank\Achieves\CounterRank\GSetters\Getters;
use Jue\Rank\Achieves\CounterRank\GSetters\Setters;
use Jue\Rank\Achieves\CounterRank\Types\NumericType;
use Jue\Rank\Achieves\CounterRank\Types\SortType;
use Jue\Rank\Achieves\CounterRank\Values\RankValue;
use Jue\Rank\Interfaces\ICounterRank;
use Jue\Rank\Interfaces\IRedis;


/**
 * 依据命名空间分组名设定Redis的key
 *
 *
 * Class CounterRank
 * @package Jue\Rank
 */
class CounterRank implements ICounterRank
{

    use Getters;
    use Setters;


    /**
     * @var \Redis|IRedis Redis实例
     */
    protected $redis;

    /**
     * @var string 命名空间
     */
    protected $namespace;

    /**
     * @var string 分组名
     */
    protected $groupName;

    /**
     * @var bool score是否使用浮点数
     */
    protected $useFloat;

    /**
     * @var string 分组连接符
     */
    protected $groupConnector;


    /**
     * CountRank constructor.
     * @param $redis
     * @param $namespace
     * @param $groupName
     * @param bool $useFloat
     */
    public function __construct($redis, $namespace, $groupName, $useFloat = NumericType::USE_NUM, $groupConnector = RankValue::DEFAULT_GROUPCONNECTOR)
    {
        $this->redis = $redis;
        $this->namespace = $namespace;
        $this->groupName = $groupName;
        $this->useFloat = $useFloat;
        $this->groupConnector = $groupConnector;
    }

    /**
     * @param $redis
     * @param $namespace
     * @param $groupName
     * @param bool $useFloat
     * @param string $groupConnector
     * @return CounterRank
     */
    public static function buildRank($redis, $namespace, $groupName, $useFloat = NumericType::USE_NUM, $groupConnector = RankValue::DEFAULT_GROUPCONNECTOR)
    {
        return new CounterRank($redis, $namespace, $groupName, $useFloat, $groupConnector);
    }



    /**
     * 获取命名空间与分组名组成的redis使用的key
     * @return string
     */
    public function getRankKey()
    {
        return $this->getNamespace() . $this->getGroupConnector() . $this->getGroupName();
    }


    /**
     * 重置key
     * @param $namespace
     * @param $groupName
     * @param bool $useFloat
     * @param string $groupConnector
     * @return $this
     */
    public function resetRankKey($namespace, $groupName, $useFloat = NumericType::USE_NUM, $groupConnector = RankValue::DEFAULT_GROUPCONNECTOR)
    {
        return $this->setNamespace($namespace)
                ->setGroupName($groupName)
                ->setUseFloat($useFloat)
                ->setGroupConnector($groupConnector);
    }


    /**
     * 依据field在对应的key中获取单个field的score
     * @param $field
     * @return float|int
     */
    public function getRankScore($field)
    {
        $score = $this->getRedis()->zScore($this->getRankKey(), $field);
        if($this->getUseFloat())
        {
            return $score;
        }

        return intval($score);
    }

    /**
     * 批量获取items的值
     * @param array $fields
     * @return array
     */
    public function batchGetRankScore(array $fields)
    {
        $scores = array_map(function ($value) {
            return $this->getRankScore($value);
        }, $fields);

        return array_combine($fields, $scores);
    }

    /**
     * 添加一个field
     * @param $field
     * @param int $score
     * @return int
     */
    public function addRankField($field, $score = RankValue::DEFAULT_VALUE)
    {
        return $this->getRedis()->zAdd($this->getRankKey(), $score, $field);
    }

    /**
     * 批量添加field
     * @param array $values
     * @return bool
     */
    public function batchAddRankField(array $values)
    {
        $data = [ $this->getRankKey() ];
        foreach ($values as $field => $score)
        {
            $data[] = $score;
            $data[] = $field;
        }

        return call_user_func_array([$this->getRedis(), 'zAdd'], $data);
    }

    /**
     * 删除指定的field
     * @param $field
     * @return int
     */
    public function rmRankField($field)
    {
        return $this->getRedis()->zRem($this->getRankKey(), $field);
    }

    /**
     * 批量删除指定的key对应的item
     * @param array $fields
     * @return bool
     */
    public function batchRmRankField(array $fields)
    {
        return call_user_func_array([$this->getRedis(), 'zRem'], array_merge([ $this->getRankKey() ],$fields));
    }

    /**
     * 删除自己的key
     * @return bool
     */
    public function deleteSelf()
    {
        return $this->getRedis()->delete($this->getRankKey()) == 1;
    }


    /**
     * 检测对应的field是否存在
     * @param $field
     * @return bool
     */
    public function isExistRankField($field)
    {
        $res = $this->getRedis()->zScore($this->getRankKey(),  $field);
        if($res === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 给对应的field增加score
     * @param $field
     * @param $score
     * @return float
     */
    public function increaseRankField($field, $score)
    {
        return $this->redis->zIncrBy($this->getRankKey(), $score, $field);
    }

    /**
     * 给对应的fields增加score
     * @param array $fields
     * @param $score
     * @return array
     */
    public function batchIncreaseRankField(array $fields, $score)
    {
        foreach ($fields as $field)
        {
            $this->increaseRankField($field, $score);
        }

        return true;
    }

    /**
     * 排名方法 top排名,可根据type进行正序逆序
     *
     * @param $limit
     * @param $key
     * @param int $start
     * @param $type
     * @return array
     */
    public function getRank($limit, $key, $start = 0, $type = SortType::DESC)
    {
        if($type == SortType::DESC)
        {
            return $this->getRedis()->zRevRange($key, $start, $limit - 1, true);
        }
        else
        {
            return $this->getRedis()->zRange($key, $start, $limit - 1, true);
        }
    }

    /**
     * 排名方法 top排名,可根据type进行正序逆序,使用类的rankKey属性
     *
     * @param $limit //当limit为0时，获取所有排名
     * @param $start
     * @param $type
     * @return array
     */
    public function rank($limit, $start = 0, $type = SortType::DESC)
    {
        return $this->getRank($limit, $this->getRankKey(), $start, $type);
    }

    /**
     * 根据score的限制获取排名
     * @param $start
     * @param $end
     * @param array $options
     * @return array
     */
    public function rankByScore($start, $end, array $options = array('withscores' => TRUE))
    {
        return $this->getRedis()->zRangeByScore($this->getRankKey(), $start, $end, $options);
    }

    /**
     * 根据score的限制获取排名数量
     * @param $start
     * @param $end
     * @return int
     */
    public function countRankByScore($start, $end)
    {
        return $this->getRedis()->zCount($this->getRankKey(), $start, $end);
    }

    /**
     * 设置key的过期时间
     * @param $key
     * @param $ttl
     * @return bool
     */
    public function expire($ttl)
    {
        return $this->getRedis()->expire($this->getRankKey(), $ttl);
    }


    /**
     * 获取field总数
     *
     * @return int
     */
    public function count()
    {
        return $this->getRedis()->zCard($this->getRankKey());
    }

    /**
     * 检查当前定义的key是否存在
     * @return bool
     */
    public function exists()
    {
        return $this->getRedis()->exists($this->getRankKey());
    }

    /**
     * 返回指定field的当前排名
     * @param $key
     * @param int $type
     * @return int
     */
    public function currentRank($key, $type = SortType::DESC)
    {
        if($type)
        {
            return $this->getRedis()->zRevRank($this->getRankKey(), $key);
        }
        else
        {
            return $this->getRedis()->zRank($this->getRankKey(), $key);
        }
    }

}