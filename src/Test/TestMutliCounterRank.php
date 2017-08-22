<?php

namespace Jue\Rank\Test;

use Carbon\Carbon;
use Jue\Rank\Achieves\CounterRank\CounterRank;
use Jue\Rank\Achieves\CounterRank\Types\SortType;
use Jue\Rank\Achieves\DateRank\DateRank;
use Jue\Rank\Achieves\MutliCounterRank\MutliCounterRank;

require_once __DIR__.'/../../vendor/autoload.php';


$redis = new \Redis();
$redis->connect('127.0.0.1','6379');

$rank1 = new DateRank($redis,'activity','test', Carbon::now());
$rank2 = new DateRank($redis,'activity','test', Carbon::tomorrow());
$rank1->addRankField(1,2);
$rank1->addRankField(2,4);
$rank2->addRankField(1,2);

$mutliRank = new MutliCounterRank([$rank1,$rank2], $redis);
$rank3 = new CounterRank($redis,'activity','all');
$mutliRank->union($rank3);

var_dump($rank3->rank(0));

$rank4 = new CounterRank($redis,'activity','all');
$mutliRank->inter($rank4);

var_dump($rank4->rank(0));

