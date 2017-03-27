<?php

namespace Jue\Rank\Interfaces;


interface IPagerRank
{

    /**
     * 获取页属性
     *
     *'has_more' => true,是否还有下一页
     *'next_page' => 2,下一页页码
     *'current_page' => 1,当前页码
     *'total' => 213,排名总数
     *'per_page' => 10,每页数量
     *
     * @return array
     */
    public function toArray();

    /**
     * 依据排序规则获取排序内容
     *
     * @param $type
     * @return array
     */
    public function getItem($type);
}