<?php

namespace Jue\Rank\Interfaces;


interface IRedis
{
    /**
     * Returns the elements of the sorted set stored at the specified key which have scores in the
     * range [start,end]. Adding a parenthesis before start or end excludes it from the range.
     * +inf and -inf are also valid limits.
     *
     * zRevRangeByScore returns the same items in reverse order, when the start and end parameters are swapped.
     *
     * @param   string  $key
     * @param   int     $start
     * @param   int     $end
     * @param   array   $options Two options are available:
     *                      - withscores => TRUE,
     *                      - and limit => array($offset, $count)
     * @return  array   Array containing the values in specified range.
     * @link    http://redis.io/commands/zrangebyscore
     * @example
     * <pre>
     * $redis->zAdd('key', 0, 'val0');
     * $redis->zAdd('key', 2, 'val2');
     * $redis->zAdd('key', 10, 'val10');
     * $redis->zRangeByScore('key', 0, 3);                                          // array('val0', 'val2')
     * $redis->zRangeByScore('key', 0, 3, array('withscores' => TRUE);              // array('val0' => 0, 'val2' => 2)
     * $redis->zRangeByScore('key', 0, 3, array('limit' => array(1, 1));                        // array('val2' => 2)
     * $redis->zRangeByScore('key', 0, 3, array('limit' => array(1, 1));                        // array('val2')
     * $redis->zRangeByScore('key', 0, 3, array('withscores' => TRUE, 'limit' => array(1, 1));  // array('val2' => 2)
     * </pre>
     */
    public function zRangeByScore( $key, $start, $end, array $options = array() );



    /**
     * Returns the score of a given member in the specified sorted set.
     *
     * @param   string  $key
     * @param   string  $member
     * @return  float
     * @link    http://redis.io/commands/zscore
     * @example
     * <pre>
     * $redis->zAdd('key', 2.5, 'val2');
     * $redis->zScore('key', 'val2'); // 2.5
     * </pre>
     */
    public function zScore( $key, $member );




    /**
     * Adds the specified member with a given score to the sorted set stored at key.
     *
     * @param   string  $key    Required key
     * @param   float   $score1 Required score
     * @param   string  $value1 Required value
     * @param   float   $score2 Optional score
     * @param   string  $value2 Optional value
     * @param   float   $scoreN Optional score
     * @param   string  $valueN Optional value
     * @return  int     Number of values added
     * @link    http://redis.io/commands/zadd
     * @example
     * <pre>
     * <pre>
     * $redis->zAdd('z', 1, 'v2', 2, 'v2', 3, 'v3', 4, 'v4' );  // int(2)
     * $redis->zRem('z', 'v2', 'v3');                           // int(2)
     * var_dump( $redis->zRange('z', 0, -1) );
     * //// Output:
     * // array(2) {
     * //   [0]=> string(2) "v1"
     * //   [1]=> string(2) "v4"
     * // }
     * </pre>
     * </pre>
     */
    public function zAdd( $key, $score1, $value1, $score2 = null, $value2 = null, $scoreN = null, $valueN = null );



    /**
     * Deletes a specified member from the ordered set.
     *
     * @param   string  $key
     * @param   string  $member1
     * @param   string  $member2
     * @param   string  $memberN
     * @return  int     Number of deleted values
     * @link    http://redis.io/commands/zrem
     * @example
     * <pre>
     * $redis->zAdd('z', 1, 'v2', 2, 'v2', 3, 'v3', 4, 'v4' );  // int(2)
     * $redis->zRem('z', 'v2', 'v3');                           // int(2)
     * var_dump( $redis->zRange('z', 0, -1) );
     * //// Output:
     * // array(2) {
     * //   [0]=> string(2) "v1"
     * //   [1]=> string(2) "v4"
     * // }
     * </pre>
     */
    public function zRem( $key, $member1, $member2 = null, $memberN = null );



    /**
     * @see del()
     * @param $key1
     * @param null $key2
     * @param null $key3
     */
    public function delete( $key1, $key2 = null, $key3 = null );


    /**
     * Increments the score of a member from a sorted set by a given amount.
     *
     * @param   string  $key
     * @param   float   $value (double) value that will be added to the member's score
     * @param   string  $member
     * @return  float   the new value
     * @link    http://redis.io/commands/zincrby
     * @example
     * <pre>
     * $redis->delete('key');
     * $redis->zIncrBy('key', 2.5, 'member1');  // key or member1 didn't exist, so member1's score is to 0
     *                                          // before the increment and now has the value 2.5
     * $redis->zIncrBy('key', 1, 'member1');    // 3.5
     * </pre>
     */
    public function zIncrBy( $key, $value, $member );


    /**
     * Returns the elements of the sorted set stored at the specified key in the range [start, end]
     * in reverse order. start and stop are interpretated as zero-based indices:
     * 0 the first element,
     * 1 the second ...
     * -1 the last element,
     * -2 the penultimate ...
     *
     * @param   string  $key
     * @param   int     $start
     * @param   int     $end
     * @param   bool    $withscore
     * @return  array   Array containing the values in specified range.
     * @link    http://redis.io/commands/zrevrange
     * @example
     * <pre>
     * $redis->zAdd('key', 0, 'val0');
     * $redis->zAdd('key', 2, 'val2');
     * $redis->zAdd('key', 10, 'val10');
     * $redis->zRevRange('key', 0, -1); // array('val10', 'val2', 'val0')
     *
     * // with scores
     * $redis->zRevRange('key', 0, -1, true); // array('val10' => 10, 'val2' => 2, 'val0' => 0)
     * </pre>
     */
    public function zRevRange( $key, $start, $end, $withscore = null );



    /**
     * Returns a range of elements from the ordered set stored at the specified key,
     * with values in the range [start, end]. start and stop are interpreted as zero-based indices:
     * 0 the first element,
     * 1 the second ...
     * -1 the last element,
     * -2 the penultimate ...
     *
     * @param   string  $key
     * @param   int     $start
     * @param   int     $end
     * @param   bool    $withscores
     * @return  array   Array containing the values in specified range.
     * @link    http://redis.io/commands/zrange
     * @example
     * <pre>
     * $redis->zAdd('key1', 0, 'val0');
     * $redis->zAdd('key1', 2, 'val2');
     * $redis->zAdd('key1', 10, 'val10');
     * $redis->zRange('key1', 0, -1); // array('val0', 'val2', 'val10')
     * // with scores
     * $redis->zRange('key1', 0, -1, true); // array('val0' => 0, 'val2' => 2, 'val10' => 10)
     * </pre>
     */
    public function zRange( $key, $start, $end, $withscores = null );



    /**
     * Returns the number of elements of the sorted set stored at the specified key which have
     * scores in the range [start,end]. Adding a parenthesis before start or end excludes it
     * from the range. +inf and -inf are also valid limits.
     *
     * @param   string  $key
     * @param   string  $start
     * @param   string  $end
     * @return  int     the size of a corresponding zRangeByScore.
     * @link    http://redis.io/commands/zcount
     * @example
     * <pre>
     * $redis->zAdd('key', 0, 'val0');
     * $redis->zAdd('key', 2, 'val2');
     * $redis->zAdd('key', 10, 'val10');
     * $redis->zCount('key', 0, 3); // 2, corresponding to array('val0', 'val2')
     * </pre>
     */
    public function zCount( $key, $start, $end );




    /**
     * Creates an union of sorted sets given in second argument.
     * The result of the union will be stored in the sorted set defined by the first argument.
     * The third optionnel argument defines weights to apply to the sorted sets in input.
     * In this case, the weights will be multiplied by the score of each element in the sorted set
     * before applying the aggregation. The forth argument defines the AGGREGATE option which
     * specify how the results of the union are aggregated.
     *
     * @param string    $Output
     * @param array     $ZSetKeys
     * @param array     $Weights
     * @param string    $aggregateFunction  Either "SUM", "MIN", or "MAX": defines the behaviour to use on
     * duplicate entries during the zUnion.
     * @return int The number of values in the new sorted set.
     * @link    http://redis.io/commands/zunionstore
     * @example
     * <pre>
     * $redis->delete('k1');
     * $redis->delete('k2');
     * $redis->delete('k3');
     * $redis->delete('ko1');
     * $redis->delete('ko2');
     * $redis->delete('ko3');
     *
     * $redis->zAdd('k1', 0, 'val0');
     * $redis->zAdd('k1', 1, 'val1');
     *
     * $redis->zAdd('k2', 2, 'val2');
     * $redis->zAdd('k2', 3, 'val3');
     *
     * $redis->zUnion('ko1', array('k1', 'k2')); // 4, 'ko1' => array('val0', 'val1', 'val2', 'val3')
     *
     * // Weighted zUnion
     * $redis->zUnion('ko2', array('k1', 'k2'), array(1, 1)); // 4, 'ko2' => array('val0', 'val1', 'val2', 'val3')
     * $redis->zUnion('ko3', array('k1', 'k2'), array(5, 1)); // 4, 'ko3' => array('val0', 'val2', 'val3', 'val1')
     * </pre>
     */
    public function zUnion($Output, $ZSetKeys, array $Weights = null, $aggregateFunction = 'SUM');





    /**
     * Sets an expiration date (a timeout) on an item.
     *
     * @param   string  $key    The key that will disappear.
     * @param   int     $ttl    The key's remaining Time To Live, in seconds.
     * @return  bool:   TRUE in case of success, FALSE in case of failure.
     * @link    http://redis.io/commands/expire
     * @example
     * <pre>
     * $redis->set('x', '42');
     * $redis->setTimeout('x', 3);  // x will disappear in 3 seconds.
     * sleep(5);                    // wait 5 seconds
     * $redis->get('x');            // will return `FALSE`, as 'x' has expired.
     * </pre>
     */
    public function expire( $key, $ttl );



    /**
     * Remove specified keys.
     *
     * @param   int|array   $key1 An array of keys, or an undefined number of parameters, each a key: key1 key2 key3 ... keyN
     * @param   string      $key2 ...
     * @param   string      $key3 ...
     * @return int Number of keys deleted.
     * @link    http://redis.io/commands/del
     * @example
     * <pre>
     * $redis->set('key1', 'val1');
     * $redis->set('key2', 'val2');
     * $redis->set('key3', 'val3');
     * $redis->set('key4', 'val4');
     * $redis->delete('key1', 'key2');          // return 2
     * $redis->delete(array('key3', 'key4'));   // return 2
     * </pre>
     */
    public function del( $key1, $key2 = null, $key3 = null );



    /**
     * Returns the cardinality of an ordered set.
     *
     * @param   string  $key
     * @return  int     the set's cardinality
     * @link    http://redis.io/commands/zsize
     * @example
     * <pre>
     * $redis->zAdd('key', 0, 'val0');
     * $redis->zAdd('key', 2, 'val2');
     * $redis->zAdd('key', 10, 'val10');
     * $redis->zCard('key');            // 3
     * </pre>
     */
    public function zCard( $key );



    /**
     * Verify if the specified key exists.
     *
     * @param   string $key
     * @return  bool: If the key exists, return TRUE, otherwise return FALSE.
     * @link    http://redis.io/commands/exists
     * @example
     * <pre>
     * $redis->set('key', 'value');
     * $redis->exists('key');               //  TRUE
     * $redis->exists('NonExistingKey');    // FALSE
     * </pre>
     */
    public function exists( $key );

}