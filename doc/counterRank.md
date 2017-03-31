

# CounterRank


所有其他排名组件都基于CounterRank,Counter提供最完备的排名功能，任何Cache只要实现`IRedis`的方法即可使用CounterRank,默认使用`\Redis`.<br>





#### 想快速浏览通过下面的锚吧,推荐一个个看（流程更详细）

* [getRankKey](#getrankkey) 
* [addRankField](#addrankfield) 
* [getRankScore](#getrankscore) 
* [batchAddRankField](#batchaddrankfield)
* [batchGetRankScore](#batchgetRankscore)
* [rmRankField](#rmrankfield)
* [deleteSelf](#deleteself)
* [isExistRankField](#isexistrankfield)
* [increaseRankField](#increaserankfield)
* [batchIncreaseRankField](#batchincreaserankfield)
* [rank](#rank)
* [rankByScore](#rankbyscore)
* [countRankByScore](#countrankbyscore)
* [count](#count)
* [exists](#exists)
* [currentRank](#currentrank)



### *实例*

```php
$rank = new CounterRank($redis,'activity','test');//新建一个counterRank
```


getRankKey
-----
##### 获取当前rank使用的key值 ☺️

```php
var_dump($rank->getRankKey());

//结果:	activity:test
```


addRankField 
-----

##### 给rank添加一个field（类似于我给排名加一个游戏玩家的id和他拿了多少分）| :smirk:

```php
$rank->addRankField(1, 2);
```


getRankScore
------
##### 获取想要的field的score（类似于我想知道某个游戏玩家的分数）| :kissing_closed_eyes:

```php
var_dump($rank->getRankScore(1));
//结果:	2	
```


batchAddRankField
----
##### 批量添加field （批量添加field，效率更高）| :satisfied:

```php
$rank->batchAddRankField([
    '6' => 20,
    '7' => 15
]);
//结果:
//array(5) {
//  [1] =>
//  int(2)
//  [2] =>
//  int(6)
//  [3] =>
//  int(6)
//  [6] =>
//  int(20)
//  [7] =>
//  int(15)
//}
```


batchGetRankScore
------
##### 批量获取多个field的score（key => value）的形式 | :stuck_out_tongue_winking_eye:

```php
$rank->batchGetRankScore([1,2,3]);

//结果:
//array(3) {
//  [1] =>
//  int(2)
//  [2] =>
//  int(6)
//  [3] =>
//  int(6)
//}
```


rmRankField
------
#####  删除一个field  | :kissing:

```php
$rank->rmRankField(6);
```


deleteSelf
-------
##### 删除自己本身所存储在IRedis层的数据  | :sleeping:

```php
$rank->deleteSelf()
```


isExistRankField
------
##### 查找对应的field存不存在 | :anguished:

```php
var_dump($rank->isExistRankField(2));
//结果：bool(true)
```


increaseRankField
------
##### 给对应的field增加相应的score | :unamused:

```php
$rank->increaseRankField(2,3);
//结果:
//array(1) {
//  [2] =>
//  int(9)
//}
```


batchIncreaseRankField
-----
##### 批量给fields增加指定的score  |  :disappointed_relieved:

```php
$rank->batchIncreaseRankField([1,2], 2);
//结果:
//array(2) {
//  [1] =>
//  int(2)
//  [2] =>
//  int(9)
//}
```


rank
------
##### 最重要的函数，获取排名函数

```php
public function rank($limit, $start = 0, $type = SortType::DESC)
```

- `limit`    获取排名的个数，（当limit为0时，全部展示）
- `start`   从第几位开始截取，默认0
- `type` 分为正序或者倒序排列，默认倒序



```php
var_dump($rank->rank(0));

//结果:
array(4) {
  [2] =>
  double(11)
  [5] =>
  double(10)
  [1] =>
  double(4)
  [4] =>
  double(0)
}
```



```php
var_dump($rank->rank(2,1,SortType::ASC));

//结果:
array(1) {
  [1] =>
  double(4)
}
```


rankByScore
-------
#####  获取score在指定范围内的排名(正序)  |  :cold_sweat:

```php
var_dump($rank->rankByScore(0,20));

//结果:

array(4) {
  [4] =>
  double(0)
  [1] =>
  double(4)
  [5] =>
  double(10)
  [2] =>
  double(11)
}
```


countRankByScore
-----
##### 获取score在指定范围内的数量 :sob:

```php
var_dump($rank->countRankByScore(0,20));

//结果：
int(4)
```




count
------
##### 获取排名总数量  :scream:

```php
var_dump($rank->count());

//结果：
int(4)
```




exists
------
##### 获取当前排名是否存在  :angry:

```php
var_dump($rank->exists());

//结果：
bool(true)
```


currentRank
-----
##### 获取当前field排名   |  （可能是第二重要的方法）

```php
public function currentRank($field, $type = SortType::DESC)
```

- `field`    field名
- `type` 分为正序或者倒序排列，默认倒序


`若某个field在该排名不存在，就会返回false`

```php
var_dump($rank->currentRank(6));
//结果：bool(false)
var_dump($rank->currentRank(2));
//结果：int(0)
var_dump($rank->currentRank(2,SortType::ASC));
//结果:int(3)
```






