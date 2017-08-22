

# MutliRank

`MutliRank`，顾名思义，就是多组合的Rank，可以把多个`CounterRank`合并成一个`CounterRank`,支持并集和交集。

- 并集 （可用于统计本月总排名或本年总排名）
- 交集   （可用于统计上月和本月同时上榜的人员）


[本文档也发布在了我的博客，支持吐槽哦](http://masixun.win/2017/03/30/JRank-CounterRank)


#### 想快速浏览通过下面的锚吧,推荐一个个看（流程更详细）

* [union](#union) 
* [inter](#inter) 




### *实例*(以下例子使用的都是Carbon库来处理时间)

```php
$rank1 = new DateRank($redis,'activity','test', Carbon::now());
$rank2 = new DateRank($redis,'activity','test', Carbon::tomorrow());
$rank1->addRankField(1,2);
$rank1->addRankField(2,4);
$rank2->addRankField(1,2);

$mutliRank = new MutliCounterRank([$rank1,$rank2], $redis);
```


union
-----
##### 指定CounterRank并且获取并集 | ☺️

```php
$rank3 = new CounterRank($redis,'activity','all');
$mutliRank->union($rank3);

var_dump($rank3->rank(0));

//结果:

array(2) {
  [2] =>
  double(4)
  [1] =>
  double(4)
}

```


inter
-----

##### 指定CounterRank并且获取交集| :smirk:

```php
$rank4 = new CounterRank($redis,'activity','all');
$mutliRank->inter($rank4);

var_dump($rank4->rank(0));

//结果:

/apps/webroot/production/Jrank/src/Test/TestMutliCounterRank.php:32:
array(1) {
  [1] =>
  double(4)
}

```

