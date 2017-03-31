<?php

namespace Jue\Rank\Test;

use Carbon\Carbon;
use Jue\Rank\Achieves\CounterRank\CounterRank;
use Jue\Rank\Achieves\CounterRank\Types\SortType;
use Jue\Rank\Achieves\DateRank\DateRank;
use Jue\Rank\Achieves\MutliCounterRank\MutliCounterRank;
use Jue\Rank\Achieves\PagerRank\PagerRank;

require_once __DIR__.'/../../vendor/autoload.php';


$redis = new \Redis();
$redis->connect('127.0.0.1','6379');

$rank = new CounterRank($redis, 'activity', 'pager');

$rank->batchAddRankField([
    1 => 2,
    2 => 4,
    3 => 3,
    4 => 20,
    5 => 7,
    6 => 13,
    7 => 10,
    8 => 13,
    9 => 9
]);

$pager = new PagerRank($rank,0,2);

var_dump($pager->getItem());
var_dump($pager->getItem(SortType::ASC));

var_dump($pager->toArray());

