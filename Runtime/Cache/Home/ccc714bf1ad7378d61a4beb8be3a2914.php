<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>MyLifePlan</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="/Public/js/jquery-3.2.1.js"></script>
	<script type="text/javascript" src="/Public/vue/vue.min.js"></script>
	<script type="text/javascript" src="/Public/js/main.js"></script>
	<script src="/Public/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/Public/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Public/css/main.css">
</head>
<body>
	<div id="container">
		<div class="row">
			<div class="col-lg-12">
				<!--时间安排板块start-->
				<h2>TO SAY AND TO DO AND IT WILL CHANGE.</h2>
				<!--<h2>MY DREAM —— After work, I can cook with my family!</h2>-->
				<br>
				<div class="panel panel-info text-left">
					<div class="panel-heading">
						<h3 class="panel-title">{{today}}</h3>
					</div>
					<div class="panel-body">
						<div class="panel text-left">
							<div class="panel-heading">
								<h3 class="panel-title">9:00-12:00</h3>
							</div>
							<div class="panel-body">
								后台客服原理分析及各接口的实现。
							</div>
						</div>
						<div class="panel text-left">
							<div class="panel-heading">
								<h3 class="panel-title">14:00-16:00</h3>
							</div>
							<div class="panel-body">
								后台客服原理分析及各接口的实现。
							</div>
						</div>
						<div class="panel text-left">
							<div class="panel-heading">
								<h3 class="panel-title">22:00-00:00</h3>
							</div>
							<div class="panel-body">
								基于thinkPHP3.2.3+gatewayworker+vue.js+bootstrap的聊天系统。
							</div>
						</div>
					</div>
				</div>
				<!--网址收藏板块start-->
				<div class="panel panel-info text-left">
					<div class="panel-heading">
						<h3 class="panel-title">常用网址</h3>
					</div>
					<div class="panel-body">
						<a class="btn btn-link" href="http://www.baidu.com">百度一下</a>
						<a v-for="url in urlist" class="btn btn-link" v-bind:href="url.url">{{url.name}}</a>
					</div>
				</div>
				<div class="text-left">
					<a href="#addPlan" tabindex="-1" data-toggle="tab" class="btn btn-default">添加时间安排</a>
					<a href="#addCollect" tabindex="-1" data-toggle="tab" class="btn btn-default">添加收藏</a>
				</div>
				 <!--添加时间安排板块start-->
				<form action="<?php echo U('add');?>" method="post" role="form">
					<div class="tab-content">
						<div id="addPlan" class="tab-pane fade">
							<div class="form-group">
								<label for="morning"></label>
								<input v-model="morning" type="text" class="form-control" name="morning" id="morning" placeholder="上午时间安排：">
							</div>
							<div class="form-group">
								<label for="afternoon"></label>
								<input v-model="afternoon" type="text" class="form-control" name="afternoon" id="afternoon" placeholder="下午时间安排：">
							</div>
							<div class="form-group">
								<label for="night"></label>
								<input v-model="night" type="text" class="form-control" name="night" id="night" placeholder="晚上时间安排：">
							</div>
							<!-- <button @click="addPlan()" class="btn btn-default">提交</button> -->
							<div class="form_actions">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</div>
						<!--添加网址板块start-->
						<div id="addCollect" class="tab-pane fade">
							<div class="form-group">
								<label for="urlcol"></label>
								<input v-model="urlcol" type="text" class="form-control" id="urlcol" placeholder="请输入要收藏的网址：">
							</div>
							<div class="form-group">
								<label for="urlname"></label>
								<input v-model="urlname" type="text" class="form-control" id="urlname" placeholder="请输入网址名：">
							</div>
							<button @click="addCollect()" class="btn btn-default">提交</button>
						</div>
					</div>
				</form>
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
			<div id="copyright" class="col-lg-12">Copyright@yzhengwang<br>Version:1.0.0</div>
		</div>
	</div>
</body>
<script type="text/javascript">

	$(function () {
        var today = new Date();
        v.today = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    });


    var v = new Vue({
        el:'#container',
        data:{
            today:'123',
            morning:'',
			afternoon:'',
			night:'',
			urlcol:'',
			urlname:'',
            urlist:[]
        },

        methods:{
			addPlan:function () {
			    let api = U('add');
				let param = {
				    morning_data:this.morning,
				    afternoon_data:this.afternoon,
					night_data:this.night
				}
				$.post(api,param,function (data) {
					console.log();
                });

            },
			addCollect:function () {
				this.urlist.push({url:this.urlcol,name:this.urlname});
            }

        }
    });
</script>
</html>