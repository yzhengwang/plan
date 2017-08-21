<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>MyLifePlan</title>
	<meta charset="utf-8">
	<style type="text/css">
		#container{width: 800px;min-height: 400px;margin: 0 auto;margin-top: 50px;text-align: center;}
		#date{width: 100%;height: 30px;text-align: left;color: green;}
		#time_01,#time_02,#time_03{width: 20%;min-height: 130px;float: left;color: green;}
		#content_01,#content_02,#content_03{width: 80%;min-height: 130px;float: left;text-align: left;}
		#url{width: 100%;min-height: 50px;text-align: left;}
		#url a{color: #bababa;display: block;}
		#copyright{width: 100%;height: 30px;text-align: right;}
	</style>
</head>
<body>
	<div id="container">
		<!-- <h2>TO SAY AND TO DO AND IT WILL CHANGE.</h2> -->
		<h2>MY DREAM —— After work, I can cook with my family!</h2>
		<br>
		<div id="date">2017.08.14</div>
		<hr>
		<div id="time_01">9:00-12:00</div>
		<div id="content_01">后台客服原理分析及各接口的实现。</div>
		<hr>
		<div id="time_02">14:00-16:00</div>
		<div id="content_02">后台客服原理分析及各接口的实现。</div>
		<hr>
		<div id="time_03">22:00-00:00</div>
		<div id="content_03">基于thinkPHP3.2.3+gatewayworker+vue.js+bootstrap的聊天系统。</div>
		<div id="url">
			<a href="">添加收藏</a>
			<a v-for="u in urlist" href="{{u.url}}"  >{{u.name}}</a>
		</div>
		<div id="">
			<form method="post" action="<?php echo U('add');?>">
				url:<input type="text" name="url"><br>
				name:<input type="text" name="name">
				<input type="submit" name="提交">
			</form>
		</div>
		<div id="copyright">Copyright@yzhengwang<br>Version:1.0.0</div>
	</div>
</body>
<script type="text/javascript" src="/Public/jquery/jquery-3.2.1.js"></script>
<script type="text/javascript" src="/Public/vue/vue.min.js"></script>
<script type="text/javascript">
$('#content_03').click = function () {
	alert();
}
var v = new Vue({
	el:'#container',
	data:{
		urlist:[
			{href:'www.baidu.com',name:'百度一下！'},
			{href:'www.baidu.com',name:'百度一下！'},
			{href:'www.baidu.com',name:'百度一下！'},
			{href:'www.baidu.com',name:'百度一下！'}
		]
	},
	
	methods:{

	}
});
</script>
</html>