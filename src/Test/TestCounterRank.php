<?php

namespace Jue\Rank\Test;

use Jue\Rank\Achieves\CounterRank\CounterRank;
use Jue\Rank\Achieves\CounterRank\Types\SortType;

require_once __DIR__.'/../../vendor/autoload.php';


$redis = new \Redis();
$redis->connect('127.0.0.1','6379');

$rank = new CounterRank($redis,'activity','test');

var_dump("rankKey:".$rank->getRankKey());

$rank->addRankField(1, 2);
$rank->addRankField(2, 6);
$rank->addRankField(3, 6);
$rank->addRankField(4, 0);
$rank->addRankField(5, 10);

var_dump($rank->getRankScore(1));
var_dump($rank->getRankScore(2));

var_dump($rank->batchGetRankScore([1,2,3]));


$rank->batchAddRankField([
    '6' => 20,
    '7' => 15
]);

var_dump($rank->batchGetRankScore([1,2,3,6,7]));

$rank->rmRankField(6);

var_dump($rank->batchGetRankScore([1,2,3,6,7]));

$rank->batchRmRankField([3,7]);

var_dump($rank->batchGetRankScore([1,2,3,6,7]));

//var_dump($rank->deleteSelf());


var_dump($rank->batchGetRankScore([2]));
var_dump($rank->isExistRankField(2));

$rank->increaseRankField(2,3);
var_dump($rank->batchGetRankScore([2]));

var_dump($rank->batchGetRankScore([1,2]));
$rank->batchIncreaseRankField([1,2],2);
var_dump($rank->batchGetRankScore([1,2]));

var_dump($rank->rank(2,1));
var_dump($rank->rank(2,1,SortType::ASC));

var_dump($rank->rankByScore(0,20));
var_dump($rank->countRankByScore(0,20));

var_dump($rank->count());

var_dump($rank->exists());

var_dump($rank->currentRank(6));
var_dump($rank->currentRank(2));
var_dump($rank->currentRank(2,SortType::ASC));

