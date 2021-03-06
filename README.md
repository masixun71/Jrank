# Jrank

### 一个基于php开发的排名组件（php rank）

[![](/img/Jrank.png "我的博客，欢迎关注")][Jrank]

#### 	Jrank正式发布了，他是一个能够给你提供排名功能所必需的要素，文档完善，功能齐全，低耦合，composer引入，二次开发.

#### 	假如公司需要做排名活动，统计排名，等等和排名相关的东西，就交给`JRank`吧。

----



*提供*

* [CounterRank](#counterrank) 基础完备的排名功能 | functions rank 
* [DateRank](#daterank) 时间纬度排名功能 | date rank 
* [MutliRank](#mutlirank) 多排名交并功能 | rank union
* [PagerRank](#pagerrank)分页排名功能 | pager rank

------



#### 目前稳定版本为1.0.0.3版本

#### 版本迭代：

v1.0.0.3

- 更新`carbon`包

v1.0.0.2

- 提供分页排名功能排名功能
- 完善文档

v1.0.0.1

- 提供多排名交并功能
- 重构代码

v1.0.0.0

- 提供时间维度排名功能
- 修复遗留bug



## 安装   |    Install

```Bash
composer require jue/rank
```

-------



## 例子   |    Example

**CounterRank** : [testExample](/src/Test/TestCounterRank.php)

**DateRank**: [testExample](/src/Test/TestDateCounterRank.php)

**MutliRank**:[testExample](/src/Test/TestMutliCounterRank.php)

**PagerRank**:[testExample](/src/Test/TestPagerRank.php)

--------




CounterRank
-----

所有其他排名组件都基于CounterRank,Counter提供最完备的排名功能，任何Cache只要实现`IRedis`的方法即可使用CounterRank,默认使用`\Redis`.<br>

### *实例*

```php
$rank = new CounterRank($redis,'activity','test');//新建一个counterRank
```

##### getRankKey ：获取当前rank使用的key值 ☺️

```php
var_dump($rank->getRankKey());

//结果:	activity:test
```

##### addRankField : 给rank添加一个field（类似于我给排名加一个游戏玩家的id和他拿了多少分）:smirk:

```php
$rank->addRankField(1, 2);
```

##### getRankScore: 获取想要的field的score（类似于我想知道某个游戏玩家的分数）:kissing_closed_eyes:

```php
var_dump($rank->getRankScore(1));
//结果:	2	
```

#### [CounterRank的详细介绍和使用哦(博客路径，可以留言吐槽)](http://masixun.win/2017/03/30/JRank-CounterRank/)

#### [CounterRank的详细介绍和使用哦,(gitHub路径)](./doc/counterRank.md)






DateRank
-----

### *实例*(以下例子使用的都是Carbon库来处理时间)

```php
$rank = new DateRank($redis,'activity','test', Carbon::now());
```



#### getRankKey:获取当前rank使用的key值 ☺️
```php
var_dump("rankKey:".$rank->getRankKey());

//结果:	
activity:test:2017-03-31
```

#### [DateRank的详细介绍和使用哦(博客路径，可以留言吐槽)](http://masixun.win/2017/03/30/JRank-CounterRank/)

#### [DateRank的详细介绍和使用哦,(gitHub路径)](./doc/dateRank.md)


MutliRank
-----

### *实例*(以下例子使用的都是Carbon库来处理时间)

```php
$rank1 = new DateRank($redis,'activity','test', Carbon::now());
$rank2 = new DateRank($redis,'activity','test', Carbon::tomorrow());
$rank1->addRankField(1,2);
$rank1->addRankField(2,4);
$rank2->addRankField(1,2);

$mutliRank = new MutliCounterRank([$rank1,$rank2], $redis);
```

#### [MutliRank的详细介绍和使用哦(博客路径，可以留言吐槽)](http://masixun.win/2017/03/30/JRank-CounterRank/)

#### [MutliRank的详细介绍和使用哦,(gitHub路径)](./doc/mutliRank.md)


PagerRank
-----



### *实例*(以下例子使用的都是Carbon库来处理时间)

```php
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

$pager = new PagerRank($rank,5,2);
```

#### [PagerRank的详细介绍和使用哦(博客路径，可以留言吐槽)](http://masixun.win/2017/03/30/JRank-CounterRank/)

#### [Pager的详细介绍和使用哦,(gitHub路径)](./doc/pagerRank.md)




[回到顶部](#Jrank)



[Jrank]: https://masixun.win	"我的博客，欢迎关注"