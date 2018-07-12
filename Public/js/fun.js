$(function()
{
	window.ajax = function(url,data)
	{
		$.ajax({
			url:url,
			data:data,
			type:'post',
			dataType:'json',
			async:false,
			success:function(res)
			{
				re = res;
			},
			error:function()
			{
				alert("系统繁忙，请稍后重试");
			}
		})
		return re;
	}

	window.ajaxFalse = function(url,data)
	{
		$.ajax({
			url:url,
			data:data,
			type:'post',
			dataType:'json',
			async:true,
			success:function(res)
			{
				rea = res;
				return rea;
			},
			error:function()
			{
				alert("系统繁忙，请稍后重试");
			}
		})
	}
	
	window.tips = function(con,type)
	{
		if(type == 1)
		{
			var str = "<span style='position:absolute;width:100%;top:70px;text-align:center;' class='tips'><span style='background:#4fe403;display:inline-block;height:20px;padding:3px;font-size:15px;border-radius:7px;'>"+con+"<span></span>";
			$("#body").append(str);
		}
		else
		{
			var str = "<span style='position:absolute;width:100%;top:70px;text-align:center;' class='tips'><span style='background:#ffb329;display:inline-block;height:20px;padding:3px;font-size:15px;border-radius:7px;'>"+con+"<span></span>";
			$("#body").append(str);
		}
		setTimeout("$('.tips').remove();",2000);
	}

	window.listPage = function(data,page,limit,field,act)
	{
		var page = page ? page : 1;
		var limit = limit ? limit : 30;
		tt = data; //声明全局变量
		var totalPage = Math.ceil(data.length/limit);  //总页数
		//将数组变成索引数组
		var newData = Array();
		var n = 0;
		for(var m in data)
		{
			newData[n] = data[m];
			n++;
		}
		//将data变成一个新数组
		var newArray = Array();
		if(page == totalPage)
		{
			var st = (Number(page)-1)*limit;
			var ss = 0;
			for(var i=st;i<data.length;i++)
			{
				newArray[ss] = newData[i];
				ss++;
			}
		}
		else
		{
			var st = (Number(page)-1)*limit;
			var en = Number(page)*limit;
			var ss = 0;
			for(var m=st;m<en;m++)
			{
				newArray[ss] = newData[m];
				ss++;
			}
		}

		//根据字段获取每页的内容
		var str = String();
		if(field && act)
		{
			var len = field.length;
			for(var i=0;i<newArray.length;i++)
			{
				str += "<tr class='addtable tb_tr_td'>";
				for(var j in field)
				{
					var ff = field[j];
					str += "<td style='text-align:center;'>"+newArray[i][ff]+"</td>";
				}
				str += "<td><a href='javascript:void(0);' class='edit-btn' sign='"+newArray[i].id+"' style='font-size:16px;'><i class='edit-btn-img'></i>编辑</a>&nbsp;&nbsp;<a href='javascript:void(0);' class='del-btn' sign='"+newArray[i].id+"' style='font-size:16px;'><i class='del-btn-img'></i>删除</a></td>";
				str += "</tr>";
			}
		}
		else if(field)
		{
			var len = field.length;
			for(var i=0;i<newArray.length;i++)
			{
				str += "<tr class='addtable tb_tr_td'>";
				for(var j in field)
				{
					var ff = field[j];
					str += "<td style='text-align:center;'>"+newArray[i][ff]+"</td>";
				}
				str += "</tr>";
			}
		}
		else
		{
			for(var i=0;i<newArray.length;i++)
			{
				str += "<tr class='addtable tb_tr_td'>";
				var len = 0;
				for(var j in newArray[i])
				{
					str += "<td style='text-align:center;'>"+newArray[i][j]+"</td>";
					len++;
				}
				str += "</tr>";
			}
		}


		//获取页码
		next = "undefined";
		prev = "undefined";
		if(Number(totalPage)>1)
		{
			var span = len;
			if(act)
			{
				span = parseInt(span)+1;
				str += "<tr class='addtable tb_tr_td'><td style='text-align:center;' colspan='"+span+"'>";
			}
			else
			{
				str += "<tr class='addtable tb_tr_td'><td style='text-align:center;' colspan='"+span+"'>";
			}
			
			str += "<a href='javascript:void(0);' id='first' style='display:inline-block;margin:4px;background:#fff;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>第一页</a>";
			for(var i=1;i<=totalPage;i++)
			{
				if(Number(page) <= 4)
				{
					if(i <= 7)
					{
						if(i == page)
						{
							str += "<a href='javascript:void(0);' class='page' style='display:inline-block;margin:4px;background:#3160a1;width:24.6px;height:21px;color:#fff;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;background: -webkit-radial-gradient(#3160a1, #348bed);background: -o-radial-gradient(#3160a1, #348bed);background: -moz-radial-gradient(#3160a1, #348bed);background: radial-gradient(#3160a1, #348bed);'>"+i+"</a>";
						}
						else
						{
							str += "<a href='javascript:void(0);' class='page' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+i+"</a>";
						}
					}
					else if(next == "undefined")
					{
						str += "<a href='javascript:void(0);' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+'...'+"</a>";
						next = 1;
					}
				}
				else if(Number(page) <= Number(totalPage)-3)
				{
					if(i < Number(page)-3)
					{
						if(prev == "undefined")
						{
							str += "<a href='javascript:void(0);' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+'...'+"</a>";
							prev = 1;
						}
					}
					else if(i > Number(page)+3)
					{
						if(next=="undefined")
						{
							str += "<a href='javascript:void(0);' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+'...'+"</a>";
							next = 1;
						}
						
					}
					else
					{
						if(i == page)
						{
							str += "<a href='javascript:void(0);' class='page' style='display:inline-block;margin:4px;background:#3160a1;width:24.6px;height:21px;color:#fff;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;background: -webkit-radial-gradient(#3160a1, #348bed);background: -o-radial-gradient(#3160a1, #348bed);background: -moz-radial-gradient(#3160a1, #348bed);background: radial-gradient(#3160a1, #348bed);'>"+i+"</a>";
						}
						else
						{
							str += "<a href='javascript:void(0);' class='page' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+i+"</a>";
						}
					}
				}
				else
				{
					if(i <= Number(totalPage)-7)
					{
						if(prev == "undefined")
						{
							str += "<a href='javascript:void(0);' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+'...'+"</a>";
							prev = 1;
						}
					}
					else
					{
						if(i == page)
						{
							str += "<a href='javascript:void(0);' class='page' style='display:inline-block;margin:4px;background:#3160a1;width:24.6px;height:21px;color:#fff;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;background: -webkit-radial-gradient(#3160a1, #348bed);background: -o-radial-gradient(#3160a1, #348bed);background: -moz-radial-gradient(#3160a1, #348bed);background: radial-gradient(#3160a1, #348bed);'>"+i+"</a>";
						}
						else
						{
							str += "<a href='javascript:void(0);' class='page' style='display:inline-block;margin:4px;background:#fff;width:24.6px;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;'>"+i+"</a>";
						}
					}
				}
			}
			str += "<a href='javascript:void(0);' id='last' style='display:inline-block;margin:4px;background:#fff;height:21px;color:#12396b;box-shadow:3px 3px 1px rgba(200,200,200,0.4);text-decoration:none;font-family:Adobe黑体;'>尾页</a>";
			str += "</td></tr>";
		}

		//写入数据
		$(".addtable").remove();
		$("#table").append(str);


		//分页功能
		$("#first").click(function()
		{
			var ppp = 1;
			listPage(data,ppp,limit,field,act);
		})
		$(".page").click(function()
		{
			var ppp = $(this).html();
			listPage(data,ppp,limit,field,act);
		})
		$("#last").click(function()
		{
			var ppp = totalPage;
			listPage(data,ppp,limit,field,act);
		})
	}

	//获取cookie值
	window.getCookie = function(name)
	{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
	}
})
