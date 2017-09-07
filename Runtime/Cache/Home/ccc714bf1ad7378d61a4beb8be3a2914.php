<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>MyLifePlan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="/Public/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Public/css/main.css">
	<style type="text/css">
		.index-username{display:inline-block;color: cornflowerblue;float: right;font-size: 15px;}
		.index-urlink{font-size: 15px;}
	</style>
</head>
<body>
	<div class="container" id="app">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 text-center">
				<!--时间安排板块start-->
				<!--<h3>TO SAY AND TO DO AND IT WILL CHANGE</h3>-->
				<h3>MY DREAM —— After work, I can cook with my family!</h3>
				<div class="panel panel-info text-left">
					<div class="panel-heading">
						<h3 class="panel-title">{{today}}&nbsp;&nbsp;&nbsp;<span class="index-username">亲爱的：<?php echo ($info["name"]); ?>，欢迎您！</span></h3>
					</div>
					<div class="panel-body">
						<div class="panel text-left">
							<div class="panel-heading">
								<h3 class="panel-title">9:00-12:00</h3>
							</div>
							<div class="panel-body">
								<?php echo ($list["morning"]); ?>
							</div>
						</div>
						<div class="panel text-left">
							<div class="panel-heading">
								<h3 class="panel-title">14:00-16:00</h3>
							</div>
							<div class="panel-body">
								<?php echo ($list["afternoon"]); ?>
							</div>
						</div>
						<div class="panel text-left">
							<div class="panel-heading">
								<h3 class="panel-title">22:00-00:00</h3>
							</div>
							<div class="panel-body">
								<?php echo ($list["night"]); ?>
							</div>
						</div>
					</div>
				</div>
				<!--网址收藏板块start-->
				<div class="panel panel-info text-left">
					<div class="panel-heading">
						<h3 class="panel-title">常用网址</h3>
					</div>
					<div class="panel-body text-center">
						<?php if(is_array($url_list)): foreach($url_list as $key=>$vo): ?><a class="btn btn-link index-urlink" href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["url_name"]); ?></a><?php endforeach; endif; ?>
					</div>
				</div>
				<div class="text-left">
					<a href="#addPlan" tabindex="-1" data-toggle="tab" class="btn btn-default">添加时间安排</a>
					<a href="#addCollect" tabindex="-1" data-toggle="tab" class="btn btn-default">添加收藏</a>
				</div>
				 <!--添加时间安排板块start-->
				<div class="tab-content">
					<div id="addPlan" class="tab-pane fade">
						<form action="<?php echo U('addPlan');?>" method="post" role="form">
							<div class="form-group">
								<label for="morning"></label>
								<input type="text" class="form-control" name="morning" id="morning" placeholder="上午时间安排：">
							</div>
							<div class="form-group">
								<label for="afternoon"></label>
								<input type="text" class="form-control" name="afternoon" id="afternoon" placeholder="下午时间安排：">
							</div>
							<div class="form-group">
								<label for="night"></label>
								<input type="text" class="form-control" name="night" id="night" placeholder="晚上时间安排：">
							</div>
							<!-- <button @click="addPlan()" class="btn btn-default">提交</button> -->
							<div class="form_actions">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</form>
					</div>
					<!--添加网址板块start-->
					<div id="addCollect" class="tab-pane fade">
						<form action="<?php echo U('addCollect');?>" method="post" role="form">
							<div class="form-group">
								<label for="url"></label>
								<input type="text" class="form-control" id="url" name="url" placeholder="请输入要收藏的网址：">
							</div>
							<div class="form-group">
								<label for="url_name"></label>
								<input type="text" class="form-control" id="url_name" name="url_name" placeholder="请输入网址名：">
							</div>
							<!--<button @click="addCollect()" class="btn btn-default">提交</button>-->
							<div class="form_actions">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</form>
					</div>
				</div>
				<br>
				<div class="list-group">
					<li class="list-group-item text-right">Copyright@yzhengwang&nbsp;Version:1.0.0</li>
				</div>
			</div>
			<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			   <div class="modal-dialog">
			      <div class="modal-content">
			         <div class="modal-header">
			            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			                  &times;
			            </button>
			            <h4 class="modal-title" id="myModalLabel">
			               模态框（Modal）标题
			            </h4>
			         </div>
			         <div class="modal-body">
			            在这里添加一些文本
			         </div>
			         <div class="modal-footer">
			            <button type="button" class="btn btn-default" data-dismiss="modal">
							关闭
			            </button>
			            <button type="button" class="btn btn-primary">
			               提交更改
			            </button>
						 <button class="btn"></button>
			         </div>
			      </div><!-- /.modal-content -->
				</div><!-- /.modal -->
			</div>


		</div>

	</div>
</body>
<script type="text/javascript" src="/Public/js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="/Public/vue/vue.min.js"></script>
<script type="text/javascript" src="/Public/js/main.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript">

	$(function () {
        var today = new Date();
        v.today = today.getFullYear()+'.'+(today.getMonth()+1)+'.'+today.getDate();
    });


    var v = new Vue({
        el:'#app',
        data:{
            today:''
        },
    });
</script>
</html>