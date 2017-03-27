<?php

namespace Jue\Rank\Interfaces;


interface ICounterRank
{
    /**
     * 获取命名空间与分组名组成的redis使用的key
     * @return string
     */
    public function getRankKey();


    /**
     * 重置key
     * @param $namespace
     * @param $groupName
     * @param bool $useFloat
     * @param string $groupConnector
     * @return $this
     */
    public function resetRankKey($namespace, $groupName, $useFloat, $groupConnector);


    /**
     * 依据field在对应的key中获取单个field的score
     * @param $field
     * @return float|int
     */
    public function getRankScore($field);

    /**
     * 批量获取items的值
     * @param array $fields
     * @return array
     */
    public function batchGetRankScore(array $fields);

    /**
     * 添加一个field
     * @param $field
     * @param int $score
     * @return int
     */
    public function addRankField($field, $score);

    /**
     * 批量添加field
     * @param array $values
     * @return bool
     */
    public function batchAddRankField(array $values);

    /**
     * 删除指定的field
     * @param $field
     * @return int
     */
    public function rmRankField($field);

    /**
     * 批量删除指定的key对应的item
     * @param array $fields
     * @return bool
     */
    public function batchRmRankField(array $fields);

    /**
     * 删除自己的key
     * @return bool
     */
    public function deleteSelf();


    /**
     * 检测对应的field是否存在
     * @param $field
     * @return bool
     */
    public function isExistRankField($field);

    /**
     * 给对应的field增加score
     * @param $field
     * @param $score
     * @return float
     */
    public function increaseRankField($field, $score);

    /**
     * 给对应的fields增加score
     * @param array $fields
     * @param $score
     * @return array
     */
    public function batchIncreaseRankField(array $fields, $score);

    /**
     * 排名方法 top排名,可根据type进行正序逆序
     *
     * @param $limit
     * @param $key
     * @param int $page
     * @param $type
     * @return array
     */
    public function getRank($limit, $key, $page = 0, $type);

    /**
     * 排名方法 top排名,可根据type进行正序逆序,使用类的rankKey属性
     *
     * @param $limit
     * @param $page
     * @param $type
     * @return array
     */
    public function rank($limit, $page = 0, $type);

    /**
     * 根据score的限制获取排名
     * @param $start
     * @param $end
     * @param array $options
     * @return array
     */
    public function rankByScore($start, $end, array $options);

    /**
     * 根据score的限制获取排名数量
     * @param $start
     * @param $end
     * @return int
     */
    public function countRankByScore($start, $end);

    /**
     * 设置key的过期时间
     * @param $key
     * @param $ttl
     * @return bool
     */
    public function expire($ttl);


    /**
     * 获取field总数
     *
     * @return int
     */
    public function count();

    /**
     * 检查当前定义的key是否存在
     * @return bool
     */
    public function exists();

    /**
     * 返回指定field的当前排名
     * @param $key
     * @param int $type
     * @return int
     */
    public function currentRank($key, $type);
}