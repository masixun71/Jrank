<?php

namespace Jue\Rank\Achieves\PagerRank;


use Jue\Rank\Achieves\CounterRank\Types\SortType;
use Jue\Rank\Achieves\PagerRank\GSetters\Getters;
use Jue\Rank\Interfaces\ICounterRank;
use Jue\Rank\Interfaces\IPagerRank;

class PagerRank implements IPagerRank
{

    use Getters;

    protected $counterRank;
    protected $perPage;
    protected $total;
    protected $currentPage;
    protected $hasMore;
    protected $nextPage;

    public function __construct(ICounterRank $counterRank, $currentPage, $perPage = 10)
    {
        $this->counterRank = $counterRank;
        $this->perPage = $perPage;
        $this->resolveCurrentPage($currentPage);
        $this->resolveTotal();
        $this->resolveNextPage();
        $this->resolveHasMore();
    }


    /**
     * 解析当前页码
     */
    private function resolveCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage > 0 ? $currentPage : 1;
    }

    /**
     * 解析总数
     */
    private function resolveTotal()
    {
        $this->total = $this->getCounterRank()->count();
    }

    /**
     * 解析下一页
     */
    private function resolveNextPage()
    {
        $this->nextPage = $this->getCurrentPage() + 1;
    }


    /**
     * 解析是否还有更多内容标签.
     */
    private function resolveHasMore()
    {
        $this->hasMore = $this->getTotal() > ($this->getCurrentPage() * $this->getPerPage()) ? 1 : 0;
    }

    /**
     * 获取页属性
     * @return array
     */
    public function toArray()
    {
        return [
            'has_more' => (bool) $this->getHasMore(),
            'next_page' => $this->getNextPage(),
            'current_page' => $this->getCurrentPage(),
            'total' => $this->getTotal(),
            'per_page' => $this->getPerPage(),
        ];
    }


    /**
     * 依据排序规则获取排序内容
     *
     * @param $type
     * @return array
     */
    public function getItem($type = SortType::DESC)
    {
        $page = ($this->getCurrentPage() - 1) * $this->getPerPage();
        $limit = $page + $this->getPerPage();
        return $this->getCounterRank()->rank($limit, $page, $type);
    }

}