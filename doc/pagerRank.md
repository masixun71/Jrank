

# PagerRank

当某个排名类所存数据量过大或者你想要将排名分页以获得更好的展示时，很抱歉，这个功能我们也提供了。`PagerRank`支持设置每页的数量，并且支持获取分页的相关属性(包括是否有下一页，总数，当前页码等)。

[本文档也发布在了我的博客，支持吐槽哦](http://masixun.win/2017/03/30/JRank-CounterRank)


#### 想快速浏览通过下面的锚吧,推荐一个个看（流程更详细）

* [getItem](#getitem) 
* [toArray](#toarray) 




```php
public function __construct(ICounterRank $counterRank, $currentPage = self::CURRENTPAGE, $perPage = self::PERPAGE)
```

- $counterRank 这个应该不用介绍了
- $currentPage  当前页码（默认0）
- $perPage         每页数量(默认10)





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


getItem
-----
##### 获取分页后的数据 | ☺️

```php
var_dump($pager->getItem());
var_dump($pager->getItem(SortType::ASC));

//结果1：

array(2) {
  [4] =>
  double(20)
  [8] =>
  double(13)
}
//结果:
array(2) {
  [1] =>
  double(2)
  [3] =>
  double(3)
}

```


toArray
-----

##### 获取分页的属性(如果你对返回的数组key不满意，可以继承`PagerRank`，覆盖`toArray`方法哦)| :smirk:

```php
var_dump($pager->toArray());


//结果：
array(5) {
  'has_more' =>      //是否有下一页
  bool(true)
  'next_page' =>     //下一页
  int(2)
  'current_page' =>  //当前页码
  int(1)
  'total' =>        //总数
  int(9)
  'per_page' =>     //每页数量
  int(2)
}


```

