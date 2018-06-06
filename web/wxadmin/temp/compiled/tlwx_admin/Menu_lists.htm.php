 
<?php echo $this->fetch('pageheader.htm'); ?>
 
 



<div id="weixin_content">
 	 
	<div class="right wide">
		 
		<div class="head">自定义菜单</div>
		 
  
 
		<?php echo $this->fetch('tlwx_sysmsg.htm'); ?>
		 <div class="lists_content">
		 	<div class="btn">
				<a href="tlwx.php?m=Menu&a=add" >填加菜单</a>
				<a href="tlwx.php?m=Menu&a=create">生成菜单</a>
				<div class="clear"></div>
			</div>
			 
		 	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lists"> 
				<thead>
				<tr>
					<th style=" width:60px;">显示顺序</th>
					<th style=" width:220px;">主菜单名称</th>
					<th style=" width:170px;">关联关键词</th>
					 
					<th style=" width:170px;">状态</th>
					<th>外链URL</th>
					<th style=" width:160px;" class="norightborder">操作</th>
				</tr>
				</thead>
			   <tbody>
			   <?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_61829500_1524793595');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_61829500_1524793595']):
?>
			   
				   <tr class="hover">
					<td class="td25"><?php echo $this->_var['lists_0_61829500_1524793595']['listorder']; ?></td>
					<td><?php echo $this->_var['lists_0_61829500_1524793595']['title']; ?></td>
					<td><?php echo $this->_var['lists_0_61829500_1524793595']['keywords']; ?></td>
				 
					<td><?php if ($this->_var['lists_0_61829500_1524793595']['is_show'] == 1): ?>显示<?php else: ?>不显示<?php endif; ?></td>
					<td><?php echo $this->_var['lists_0_61829500_1524793595']['link']; ?></td>
					<td>
						<a title="修改主菜单" href="tlwx.php?m=Menu&a=add&id=<?php echo $this->_var['lists_0_61829500_1524793595']['id']; ?>" class="ajax btnGreen  cboxElement">修改</a>
							<a href="javascript:drop_confirm('您确定要删除吗?', 'tlwx.php?m=Menu&a=del&id=<?php echo $this->_var['lists_0_61829500_1524793595']['id']; ?>');" class=" btnGreen ">删除</a>
					</td>	
					<?php $_from = $this->_var['lists_0_61829500_1524793595']['lists_sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sub_lists');if (count($_from)):
    foreach ($_from AS $this->_var['sub_lists']):
?>
					</tr>
					<tr class="hover">
						<td class="td25"><?php echo $this->_var['sub_lists']['listsorder']; ?></td>
						<td>  |---- <?php echo $this->_var['sub_lists']['title']; ?></td>
						<td><?php echo $this->_var['sub_lists']['keywords']; ?></td>
				 
						<td><?php if ($this->_var['lists_0_61829500_1524793595']['is_show'] == 1): ?>显示<?php else: ?>不显示<?php endif; ?></td>
						<td><?php echo $this->_var['sub_lists']['link']; ?></td>
						<td>
							<a title="修改主菜单" href="tlwx.php?m=Menu&a=add&id=<?php echo $this->_var['sub_lists']['id']; ?>" class="ajax btnGreen  cboxElement">修改</a>
							<a href="javascript:drop_confirm('您确定要删除吗?', 'tlwx.php?m=Menu&a=del&id=<?php echo $this->_var['sub_lists']['id']; ?>');" class=" btnGreen ">删除</a>
						</td>	
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>		
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>			
				  </tr>
					<tr class="hover">
					<td colspan="7" class="td25">
							 
					 
					注：<br>
					(使用前提是已经拥有了自定义菜单的用户才能够使用，)<br>
					第一步:必须先填写【AppId】【 AppSecret】！<br>
					第二步:添加菜单，<br>
					第三步:点击生成!<br>
					注意：1级菜单最多只能开启3个，2级子菜单最多开启5个<br>
					官方说明：修改后，需要重新关注，或者最迟隔天才会看到修改后的效果！<br>
					 
					</td>				
				  </tr>
				 	  
				</tbody>
			</table>
			 
		 </div>
		 
	 
	</div>
	<div class="clear"></div>
</div>
 
<?php echo $this->fetch('tlwx_pagefooter.htm'); ?>
 


 