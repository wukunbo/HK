<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\xampp\htdocs\HK\web/application/shop\view\index\cate_tpl.html";i:1526443139;}*/ ?>


<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<div class="col_con" onclick="to_href('<?php echo url('goods_lists'); ?>?&cate_id=<?php echo $vo['cate_id']; ?>')">
    <img src="<?php echo $vo['img_thumb']; ?>">
    <p><?php echo $vo['cat_name']; ?></p>
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>

<div class="clear"></div>


