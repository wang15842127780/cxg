<?php



//获取分页信息
function getPage($count=1,$limit=10,$page=1)
{
	if(ceil($count/$limit) > 1)
	{
		$pagea = ceil($count/$limit);
		$page_info = "<span><a href='javascript:void(0);' id='prev'>上一页</a>&nbsp;&nbsp;";
		$c = "style='color:#262629;'";
		for($i=1;$i<=$pagea;$i++)
		{
			if($page == $i)
			{
				$page_info .= "<a href='javascript:void(0);' class='page' p=".$i." {$c}>".$i."</a>&nbsp;&nbsp;";
			}
			else
			{
				$page_info .= "<a href='javascript:void(0);' class='page' p=".$i.">".$i."</a>&nbsp;&nbsp;";
			}
			
		}
		$page_info .= "<a href='javascript:void(0);' id='next'>下一页</a>";
	}
	else
	{
		$page_info = 1;
	}
	$p = $page_info."&nbsp;&nbsp;共{$count}条记录&nbsp;&nbsp;每页{$limit}条&nbsp;&nbsp;第<i id='dangye'>{$page}</i>页/共<i id='zuida'>".ceil($count/$limit)."</i>页</span>";
	return $p;
}





















?>