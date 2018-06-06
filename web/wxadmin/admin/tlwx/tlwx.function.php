<?php

/**
 * ECSHOP 管理中心公用函数库
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: lib_main.php 17217 2011-01-19 06:29:08Z liubo $
*/

//新增加一条记录 
 

/**
 * 生成随机token 
 *
 */
 
function token_rand($total=15) {
	$code="";
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
	for ($i = 0; $i < $total; $i++) {
			$code .= $pattern{mt_rand(0, 61)};
		 
	}
	return $code;
 
}
/**
   write_static_cache('shop_config', $arr);
  $data = read_static_cache('shop_config');
 * 读结果缓存文件
 *
 * @params  string  $cache_name
 *
 * @return  array   $data
 */
 
 
?>