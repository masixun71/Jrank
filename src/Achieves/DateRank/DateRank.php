<?php

namespace Jue\Rank\Achieves\DateRank;


use Carbon\Carbon;
use Jue\Rank\Achieves\CounterRank\CounterRank;
use Jue\Rank\Achieves\CounterRank\Types\NumericType;
use Jue\Rank\Achieves\CounterRank\Values\RankValue;
use Symfony\Component\Translation\Exception\LogicException;

class DateRank extends CounterRank
{

    /**
     * DateRank constructor.
     * @param $redis
     * @param $namespace
     * @param $groupName
     * @param string|int|Carbon $date
     * @param string $useFloat
     * @param $groupConnector
     */
    public function __construct($redis, $namespace, $groupName, $date, $useFloat = NumericType::USE_NUM, $groupConnector = RankValue::DEFAULT_GROUPCONNECTOR)
    {
        $carbon = $this->toCarbon($date);
        parent::__construct($redis, $this->mergeNameSpaceGroup($namespace, $groupName, $groupConnector), $carbon->format('Y-m-d'), $useFloat, $groupConnector);
    }

    /**
     * @return string
     */
    public function getDateNamespace()
    {
        $arr = explode($this->getGroupConnector(), parent::getNamespace());
        return $arr[0];
    }

    /**
     * @return string
     */
    public function getDateGroupName()
    {
        $arr = explode($this->getGroupConnector(), parent::getNamespace());
        return $arr[1];
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return Carbon::createFromFormat("Y-m-d", parent::getGroupName());
    }


    /**
     * @param $namespace
     * @param $groupName
     * @param $groupConnector
     * @return string
     */
    private function mergeNameSpaceGroup($namespace, $groupName, $groupConnector)
    {
        return $namespace . $groupConnector . $groupName;
    }


    /**
     * @param $date
     * @return Carbon
     */
    private function toCarbon($date)
    {
        if(is_string($date))
        {
            $time = strtotime($date);

        }
        elseif (is_int($date))
        {
            $time = $date;
        }
        elseif ($date instanceof Carbon)
        {
            return $date;
        }
        else
        {
            throw new LogicException("找不到该时间类型");
        }

        return Carbon::createFromTimestamp($time);
    }


}