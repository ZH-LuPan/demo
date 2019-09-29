<?php /*a:7:{s:76:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\index\skillList.html";i:1569727323;s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\base.html";i:1566305556;s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\meta.html";i:1566308938;s:80:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\admin-header.html";i:1569305954;s:78:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\widget\admin-left.html";i:1566221962;s:80:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\admin-footer.html";i:1566219026;s:74:"D:\phpStudy\PHPTutorial\WWW\demo\application\admin\view\layout\footer.html";i:1566305884;}*/ ?>
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
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <form class="layui-form" action="" style="width: 100px;float: left;">
            <select class="layui-form" name="searchType" lay-verify="">
                <option value="1">技术名称</option>
                <option value="2">技术介绍</option>
            </select>
        </form>
        <div class="layui-inline">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
                <input id="keyword" type="text" autocomplete="off" name="keyword" placeholder="请输入关键字"
                       class="layui-input">
            </div>
        </div>
        <a id="searchBtn" class="layui-btn layui-btn-warm">搜索</a>
        <button type="button" class="layui-btn" id="test1" style="float: right">
            <i class="layui-icon">&#xe67c;</i>导入技术库
        </button>
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th width="5%">序号</th>
                <th width="6%">一级目录</th>
                <th width="6%">二级目录</th>
                <th width="6%">三级目录</th>
                <th width="6%">技术名称</th>
                <th>技术介绍</th>
                <th width="6%">项目负责人</th>
                <th width="6%">所属学校</th>
                <th width="6%">合作形式</th>
                <th width="11%">操作</th>
            </tr>
            </thead>
            <tbody id="phoneList">
            </tbody>
        </table>
        <div id="pages"></div>
        <input type="hidden" id="exportUrl" value="<?php echo htmlentities($exportUrl); ?>">
        <input type="hidden" id="getUrl" value="<?php echo htmlentities($getUrl); ?>">
        <input type="hidden" id="delUrl" value="<?php echo htmlentities($delUrl); ?>">
    </div>
</div>
<script>
    layui.use('upload', function () {
        var upload = layui.upload;

        //执行实例
        var url = $('#exportUrl').val()
        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            , url: url //上传接口
            , done: function (res) {
                if(res.code === 200){
                    layer.msg(res.msg,{'icon':1})
                    window.location.reload()
                }else{
                    layer.msg(res.msg,{'icon':2})
                }
            }
            , error: function () {
            }
            , accept: 'file'
        });
    });
</script>
<script>

    filePage = 1;
    fileSize = 10;
    count = <?php echo htmlentities($count); ?>;

    $(function () {
        getList()
        layui.use(['laypage', 'layer'], function () {
            var laypage = layui.laypage
            laypage.render({
                elem: 'pages',
                count: count,
                limit: fileSize,
                curr: filePage,
                jump: function (obj, first) {
                    filePage = obj.curr;
                    fileSize = obj.limit;
                    if (!first) {
                        getList()
                    }
                }
            });
        })
    })

    $("#searchBtn").on('click', function () {
        var sendData = {
            'keyword': keyword = $("#keyword").val(),
            'searchType':$("select[name='searchType']").val(),
            'page':filePage,
            'size':fileSize
        }
        var url = $('#getUrl').val()
        $.post(url, sendData , function (res) {
            if(res.code){
                layer.msg(res.msg,{'icon':2})
                return false;
            }
            if (res) {
                randerList(res)
            }
        })
    })

    function getList() {
        var sendData = {
            'keyword': keyword = $("#keyword").val(),
            'searchType':$("select[name='searchType']").val(),
            'page':filePage,
            'size':fileSize
        }
        var url = $('#getUrl').val()
        $.post(url, sendData, function (dataList) {
            if (dataList) {
                randerList(dataList)
                count = dataList.total;
            }
        })
    }

    function randerList(dataList) {
        if (dataList.data && dataList.data.length > 0) {
            var temple = ''
            $.each(dataList.data, function (i, data) {
                temple += '' +
                    '<tr>' +
                    '<td width="5%" class="phone_id">' + data.id + '</td>' +
                    '<td width="8%"> ' + data.first_cate + '</td>' +
                    '<td width="8%"> ' + data.second_cate + '</td>' +
                    '<td width="8%"> ' + data.third_cate + '</td>' +
                    '<td> ' + data.name + '</td>' +
                    '<td>' + data.description + '</td>' +
                    '<td>' + data.leader + '</td>' +
                    '<td>' + data.school_name + '</td>' +
                    '<td>' + data.type + '</td>' +
                    '<td> ' +
                    '<div>' +
                    '<a href="/admin.php/Skill/edit?id='+data.id+'" class="layui-btn editBtn">修改</a>' +
                    '<a onclick="doDelete('+data.id+')"   class="layui-btn layui-btn-danger delBtn">删除</a>' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
            })
            $('#phoneList').html(temple)
        }
    }

    // function doEdit(obj) {
    //     var This = obj;
    //     var sendData = {
    //         'id': This.parents('tr').find('.phone_id').html()
    //     }
    //     $.post('/admin.php/Skill/edit', sendData, function (res) {
    //         layer.msg(res.msg);
    //     })
    // }

    function doDelete(id) {
        var url = $('#delUrl').val()
        $.post(url, {'id': id}, function (res) {
            layer.msg(res.msg);
            getList();
        })
    }

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