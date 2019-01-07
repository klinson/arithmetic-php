<?php

// 猴子选大王
// 一群猴子排成一圈，按1，2，...，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，再数到第m只，在把它踢出去...，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n,输出最后那个大王的编号

// 官方参考答案
function select_monkey_king_official(array $monkeys, int $select_num) {
  $i = 0;
  while(count($monkeys)>1){
    if(($i+1)%$select_num==0){
      unset($monkeys[$i]);
    }else{
      // 非整除，不是该删这个，往后排
      $monkeys[]=$monkeys[$i];
      unset($monkeys[$i]);
    }
    $i++;
  }
  return $monkeys[$i];
}

// 个人实现
function select_monkey_king(array $monkeys, int $select_num) {
  $now_num = 0;
  $now_all = count($monkeys);

  while (1) {
    // 剩下最后一个返回
    if (count($monkeys) === 1) {
      return array_pop($monkeys);
    }
    // 计算下个要剔除的编号
    $cut_num = $now_num + $select_num - 1;
    // 超过当前数组总数，减去当前数组总数
    if ($cut_num >= $now_all) {
      $cut_num -= $now_all;
      // 数组编号重新生成
      $monkeys = array_values($monkeys);
      // 数组当前总数重新计算
      $now_all = count($monkeys);
      // 已经被删的别原数值小，取模
      if ($cut_num >= $now_all) {
        $cut_num %= $now_all;
      }
      unset($monkeys[$cut_num]);
    } else {
      // 剔除号码在当前数组内，直接剔除
      unset($monkeys[$cut_num]);
    }

    //var_dump($monkeys);
    // 下一个开始排序的编号
    $now_num = $cut_num + 1;
  }
}

// 测试数据
$array = range(1, 10);;
$num = 3;

// 知行结果
var_dump($array);
echo '个人算法结果：'.select_monkey_king($array, $num);
echo PHP_EOL;
echo '官方算法结果：'.select_monkey_king_official($array, $num);