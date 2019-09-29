<?php /*a:1:{s:72:"D:\phpStudy\PHPTutorial\WWW\demo\application\index\view\index\index.html";i:1569719270;}*/ ?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <link rel="stylesheet" href="/public/static/index/css/bootstrap.css">
    <link rel="stylesheet" href="/public/assets/layui/css/layui.css">
    <link rel="stylesheet" href="/public/static/index/css/style.css" type="text/css" media="all"/>
    <link href="/public/static/index/css/font-awesome.css" rel="stylesheet">
</head>

<body>
<section class="about py-5" id="about">
    <div class="container">
        <div class="inner-sec-w3ls-pyt py-lg-5 py-3">
            <div class="input-group">
                <div id="searchType">
                    <select name="searchType" class="form-control" style="width: 150px">
                        <option value="1">技术名称</option>
                        <option value="3">技术介绍</option>
                        <option value="2">专家名称</option>
                    </select>
                </div>&nbsp;
                <input type="text" id="keyword" name="keyword" autocomplete="off" class="form-control"
                       placeholder="请输入关键字" oninput="if(this.value==''){this.type='text'}">
            </div>
            <div class="feature-grids row mt-3 mb-lg-5 mb-3 text-center">
                <div class="col-lg-4" id="skill">
                    <a>
                    <div class="bottom-gd px-3">
                        <span class="fa fa-building-o" aria-hidden="true"></span>
                        <h3 class="my-4">技术库</h3>
                    </div>
                    </a>
                </div>
                <div class="col-lg-4" id="talent">
                    <div class="bottom-gd2-active px-3">
                        <span class="fa fa-cogs" aria-hidden="true"></span>
                        <h3 class="my-4">专家库</h3>
                    </div>
                </div>
                <div class="col-lg-4" id="aboutUs">
                    <div class="bottom-gd px-3">
                        <span class="fa fa-cogs" aria-hidden="true"></span>
                        <h3 class="my-4">联系我们</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="contact py-5" id="contact" style="background-color: white;margin-top: -170px">
    <div class="container py-lg-5">
        <table class="table table-hover">
            <thead id="tableHead">
            <div class="layui-carousel" id="bannerBox" style="float: left;">
                <div carousel-item>
                    <div><img src="/public/static/index/images/banner1.jpg" style="width: 100%;height: 100%"/></div>
                    <div><img src="/public/static/index/images/timg.jpg" style="width: 100%;height: 100%"/></div>
                </div>
            </div>
            <div id="loginBox">
                <div style="width: 49%;height: 350px;background-color: #e2e2e2; float: right; ">
                    <div style="margin:0 auto; width:300px;height:100px;vertical-align:middle;margin-top: 60px">
                        <input type="text" name="username" style="width: 200px" required lay-verify="required"
                               placeholder="请输入密码" autocomplete="off" class="layui-input"><br />
                        <input type="password" name="password" style="width: 200px" required lay-verify="required" placeholder="请输入密码"
                               autocomplete="off" class="layui-input"><br />
                        <button class="layui-btn" id="loginBtn" lay-submit lay-filter="formDemo">登录</button>
                    </div>
                </div>
            </div>
            </thead>
            <tbody id="list">

            </tbody>
        </table>
        <div id="pages"></div>
    </div>
</section>
<script src="/public/assets/layui/layui.all.js"></script>
<script src="/public/static/admin/js/jquery.min.js"></script>
<script src="/public/static/index/js/list.js"></script>
<script>
    layui.use('carousel', function () {
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#bannerBox'
            , width: '49%' //设置容器宽度,
            , height: '350px'
            , arrow: 'always' //始终显示箭头
        });
    });
    
    $('#loginBtn').on('click',function () {
        var sendData = {
            'account' : $('input[name="username"]').val(),
            'password' : $('input[name="password"]').val()
        }
        $.post('/admin.php/User/login',sendData,function (res) {
            if(res.code == 200){
                window.location.href = res.data;
            }else{
                layer.msg(res.msg,{icon: 2, time: 1000});
            }
        })
    })

</script>
</body>
</html>
