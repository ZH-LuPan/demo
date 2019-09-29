<?php /*a:7:{s:74:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\index\addUser.html";i:1569726425;s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\base.html";i:1566305556;s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\meta.html";i:1566308938;s:80:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\admin-header.html";i:1569305954;s:78:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\widget\admin-left.html";i:1566221962;s:80:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\admin-footer.html";i:1566219026;s:74:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\footer.html";i:1566305884;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>L-Admin</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--<link rel="icon" type="image/png" href="/.././public/static/admin/img/favicon.png">-->
<!--<link rel="stylesheet" href="/.././public/static/admin/css/amazeui.min.css" />-->
<!--<link rel="stylesheet" href="/.././public/static/admin/css/amazeui.datetimepicker.css" />-->
<link rel="stylesheet" href="/public/assets/layui/css/layui.css">
<link rel="stylesheet" href="/.././public/static/admin/css/app.css">
<link rel="stylesheet" href="/.././public/static/admin/css/admin.css">

<script src="/.././public/static/admin/js/jquery.min.js"></script>
<!--<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>-->
<script src="/public/assets/layui/layui.all.js"></script>
<script type="text/javascript">
var adminApp = {
    path: {
        assets: "/.././public/static/admin",
    },
};
</script>
</head>
<body data-type="index">
    <div class="am-g tpl-g">
        <!-- 头部 -->
        <div class="layui-header">
    <div class="layui-logo"></div>
    <ul class="layui-nav">
        <li class="layui-nav-item">
            <a href=""></a>
        </li>
        <li class="layui-nav-item">
            <a href=""></a>
        </li>
        <li class="layui-nav-item">
            <a href=""><img src="//t.cn/RCzsdCq" class="layui-nav-img"><?php echo htmlentities(app('cookie')->get('name')); ?></a>
            <dl class="layui-nav-child">
                <dd><a href="/admin.php/User/logout">注   销</a></dd>
            </dl>
        </li>
    </ul>
</div>

        <!-- 侧边导航栏 -->
<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
    <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <!-- 侧边导航: <ul class="layui-nav layui-nav-tree layui-nav-side"> -->
        <?php foreach($menus as $menu): ?>
        <li class="layui-nav-item layui-nav-itemed">
            <a href="<?php echo htmlentities($menu['url']); ?>"><?php echo htmlentities($menu['name']); ?></a>
            <?php if(isset($menu['children'])): ?>
            <dl class="layui-nav-child">
                <?php foreach($menu['children'] as $children): ?>
                <dd><a href="<?php echo htmlentities($children['url']); ?>"><?php echo htmlentities($children['name']); ?></a></dd>
                <?php endforeach; ?>
            </dl>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    </div>
</div>
        <div class="layui-layout layui-layout-admin">
            

<div class="layui-body">
    <div style="padding: 15px;">
        <div class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required value=""  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input type="text" name="password" required value=""  lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                    <input type="text" name="description" required value=""  lay-verify="required" placeholder="请输入备注信息" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn">立即提交</button>
                <input type="hidden" value="<?php echo htmlentities($addUserUrl); ?>" id="addUserUrl">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.layui-btn').on('click',function () {
        var sendData = {
            'account': $('input[name="name"]').val(),
            'password':$('input[name="password"]').val(),
            'description':$('input[name="description"]').val()
        }
        var url = $('#addUserUrl').val()
        $.post(url,sendData,function(res){
            layer.msg(res.msg)
            history.go(-1)
        });
    })
</script>


            <div class="admin-footer">
	<footer data-am-widget="footer" class="am-footer am-footer-default" data-am-footer="{  }">
	    <div class="am-footer-miscs ">

	    </div>
	</footer>
</div>

        </div>
    </div>
<!--<script src="/.././public/static/admin/js/amazeui.min.js"></script>-->
<!--<script src="/.././public/static/admin/js/amazeui.datetimepicker.min.js"></script>-->
<script src="/public/assets/layui/layui.all.js"></script>
<!--<script src="/.././public/static/admin/js/app.js"></script>-->



</body>
</html>