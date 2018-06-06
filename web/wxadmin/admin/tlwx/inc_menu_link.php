<?php

/* 菜单分类部分 */
/*
在admin/uncludes/inc_menu.php 引用
*/
 


$modules['01_weixin']['01_weixin_wxconfig']       = 'tlwx.php?m=Config&a=index'; 
$modules['01_weixin']['02_weixin_wxsetting']       = 'tlwx.php?m=Config&a=setting';         
$modules['01_weixin']['02_weixin_quanfa']        = 'tlwx.php?action=weixin_auto';          
$modules['01_weixin']['03_weixin_menu']    = 'tlwx.php?m=Menu&a=lists';
$modules['01_weixin']['04_weixin_reply']   = 'tlwx.php?m=Keyword&a=auto_all&keyword_cata=auto';
$modules['01_weixin']['05_weixin_msg']   = 'tlwx.php?m=Msg&a=manage';
$modules['01_weixin']['06_weixin_market']   = '../market/index.php?g=User&m=Lottery&a=index';
$modules['01_weixin']['07_feedback']   = 'tlwx.php?m=Feedback&a=lists';
 

