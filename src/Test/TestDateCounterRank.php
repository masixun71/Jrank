<?php

namespace Jue\Rank\Test;

use Carbon\Carbon;
use Jue\Rank\Achieves\CounterRank\CounterRank;
use Jue\Rank\Achieves\CounterRank\Types\SortType;
use Jue\Rank\Achieves\DateRank\DateRank;

require_once __DIR__.'/../../vendor/autoload.php';


$redis = new \Redis();
$redis->connect('127.0.0.1','6379');

$rank = new DateRank($redis,'activity','test', Carbon::now());


var_dump("rankKey:".$rank->getRankKey());
var_dump($rank->getGroupName());
var_dump($rank->getNamespace());
var_dump($rank->getDateNamespace());
var_dump($rank->getDateGroupName());
var_dump($rank->getDate());


