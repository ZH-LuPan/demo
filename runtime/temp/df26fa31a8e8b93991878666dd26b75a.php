<?php /*a:7:{s:76:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\index\editSkill.html";i:1569726662;s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\base.html";i:1566305556;s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\meta.html";i:1566308938;s:80:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\admin-header.html";i:1569305954;s:78:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\widget\admin-left.html";i:1566221962;s:80:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\admin-footer.html";i:1566219026;s:74:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\footer.html";i:1566305884;}*/ ?>
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
                <label class="layui-form-label">项目负责人</label>
                <div class="layui-input-block">
                    <input type="text" name="leader" required value="<?php echo htmlentities($info['leader']); ?>"  placeholder="请输入姓名" autocomplete="off" class="layui-input" style="width: 300px">
                </div><br />
                <label class="layui-form-label">所属学校</label>
                <div class="layui-input-block">
                    <input type="text" name="school_name" required value="<?php echo htmlentities($info['school_name']); ?>" placeholder="请输入所属学校" autocomplete="off" class="layui-input" style="width: 300px">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">一级目录</label>
                <div class="layui-input-block">
                    <input type="text" name="first_cate" required value="<?php echo htmlentities($info['first_cate']); ?>" placeholder="请输入一级目录" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">二级目录</label>
                <div class="layui-input-block">
                    <input type="text" name="second_cate" required value="<?php echo htmlentities($info['second_cate']); ?>" placeholder="请输入二级目录" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">三级目录</label>
                <div class="layui-input-block">
                    <input type="text" name="third_cate" required value="<?php echo htmlentities($info['third_cate']); ?>"  placeholder="请输入三级目录" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">技术名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required value="<?php echo htmlentities($info['name']); ?>" placeholder="请输入技术名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">合作形式</label>
                <div class="layui-input-block">
                    <input type="text" name="type" required value="<?php echo htmlentities($info['type']); ?>" placeholder="请输入合作形式" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">技术介绍</label>
                <div class="layui-input-block">
                    <textarea style="height: 250px" name="description" placeholder="请输入技术介绍" class="layui-textarea"><?php echo htmlentities($info['description']); ?></textarea>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn">立即提交</button>
                <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                <input type="hidden" id="editUrl" value="<?php echo htmlentities($editUrl); ?>">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.layui-btn').on('click',function () {
        var sendData = {
            'id':$('input[name="id"]').val(),
            'name': $('input[name="name"]').val(),
            'school_name': $('input[name="school_name"]').val(),
            'leader':$('input[name="leader"]').val(),
            'first_cate':$('input[name="first_cate"]').val(),
            'second_cate':$('input[name="second_cate"]').val(),
            'third_cate':$('input[name="third_cate"]').val(),
            'type':$('input[name="type"]').val(),
            'description':$('textarea[name="description"]').val()
        }
        var url = $('#editUrl').val()
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