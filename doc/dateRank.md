

# DateRank


DateRank其实和CounterRank功能差不多，继承了`CounterRank`,不过在`DateRank`是以时间维度来进行的排名，比如游戏里比较火的今日排名，昨日排名之类的就可以用`DateRank`来实现。主要对DateRank使用的`namespcae`和`groupName`做了特殊处理。方便使用。


[本文档也发布在了我的博客，支持吐槽哦](http://masixun.win/2017/03/30/JRank-CounterRank)


#### 想快速浏览通过下面的锚吧,推荐一个个看（流程更详细）

* [getRankKey](#getrankkey) 
* [getNamespace](#getnamespace) 
* [getGroupName](#getgroupname) 
* [getDateNamespace](#getdatenamespace)
* [getDateGroupName](#getdategroupname)
* [getDate](#getdate)



### *实例*(以下例子使用的都是Carbon库来处理时间)

```php
$rank = new DateRank($redis,'activity','test', Carbon::now());
```


getRankKey
-----
##### 获取当前rank使用的key值 ☺️

```php
var_dump("rankKey:".$rank->getRankKey());

//结果:	
activity:test:2017-03-31
```


getNamespace
-----

##### 获取命名空间| :smirk:

```php
var_dump($rank->getNamespace());

//结果:
activity:test
```


getGroupName
------
##### 获取分组名| :kissing_closed_eyes:

```php
var_dump($rank->getGroupName());
//结果:	
2017-03-31
```


getDateNamespace
----
##### 获取date使用的命名空间| :satisfied:

```php
var_dump($rank->getDateNamespace());
//结果:
activity
```


getDateGroupName
------
##### 获取date使用的分组名 | :stuck_out_tongue_winking_eye:

```php
var_dump($rank->getDateGroupName());

//结果:
test
```


getDate
------
#####  获取日期 (特殊处理，返回一个Carbon对象) | :kissing:

```php
var_dump($rank->getDate());

//结果:
class Carbon\Carbon#5 (3) {
  public $date =>
  string(26) "2017-03-31 21:36:13.000000"
  public $timezone_type =>
  int(3)
  public $timezone =>
  string(13) "Asia/Shanghai"
}
```

