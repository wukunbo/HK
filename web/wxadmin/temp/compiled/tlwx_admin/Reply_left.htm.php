		
		
 
		 
		<a href="tlwx.php?m=Keyword&a=auto_all&keyword_cata=auto" <?php if ($this->_var['comm'] [ m ] == "Keyword" && $this->_var['comm'] [ a ] == "auto_all" && ( $this->_var['comm'] [ keyword_cata ] == "auto" || $this->_var['comm'] [ keyword_cata ] == "" )): ?> class="cur" <?php endif; ?> >关注时自动回复</a>
		<a href="tlwx.php?m=Keyword&&a=auto_all&keyword_cata=all" <?php if ($this->_var['comm'] [ m ] == "Keyword" && $this->_var['comm'] [ a ] == "auto_all" && $this->_var['comm'] [ keyword_cata ] == "all"): ?> class="cur" <?php endif; ?>>默认自动回复</a>
		<a href="tlwx.php?m=Keyword&a=lists" <?php if ($this->_var['comm'] [ m ] == "Keyword" && $this->_var['comm'] [ a ] != "auto_all" && $this->_var['comm'] [ keyword_cata ] != "auto"): ?> class="cur" <?php endif; ?>>关键词自动回复</a>
		
	
		<a href="tlwx.php?m=Reply&a=lists" <?php if ($this->_var['comm'] [ m ] == "Reply"): ?> class="cur" <?php endif; ?>>图文列表</a>
		<a href="tlwx.php?m=Material&a=lists" <?php if ($this->_var['comm'] [ m ] == "Material"): ?> class="cur" <?php endif; ?>>素材列表</a>
		
 