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
composer install jue/rank
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

##### getRankKey ：获取当前rank使用的key值

```php
var_dump($rank->getRankKey());

//结果:	activity:test
```








DateRank
-----


MutliRank
-----


PagerRank
-----















[回到顶部](#JRank)