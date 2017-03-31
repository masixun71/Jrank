# Jrank

### 基于php开发的排名组件（php rank）

*提供*

* [CounterRank](#counterrank) 基础完备的排名功能 | functions rank 
* [DateRank](#daterank) 时间纬度排名功能 | date rank 
* [MutliRank](#mutlirank) 多排名交并功能 | rank union
* [PagerRank](#pagerrank)分页排名功能 | pager rank

------



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

#### [更多counterRank的使用哦(博客路径，可以留言吐槽)](http://masixun.win/2017/03/30/JRank-CounterRank/)

#### [更多counterRank的使用哦,(gitHub路径)](./doc/counterRank.md)






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

#### [更多counterRank的使用哦(博客路径，可以留言吐槽)](http://masixun.win/2017/03/30/JRank-CounterRank/)

#### [更多counterRank的使用哦,(gitHub路径)](./doc/dateRank.md)


MutliRank
-----


PagerRank
-----















[回到顶部](#JRank)