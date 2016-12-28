<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/menu/add.html";i:1482924935;s:94:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/template/base.html";i:1482488954;s:105:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/template/javascript_vars.html";i:1482488954;}*/ ?>
﻿<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title><?php echo \think\Config::get('site.title'); ?></title>
    <link rel="Bookmark" href="__ROOT__/favicon.ico" >
    <link rel="Shortcut Icon" href="__ROOT__/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__LIB__/html5.js"></script>
    <script type="text/javascript" src="__LIB__/respond.min.js"></script>
    <script type="text/javascript" src="__LIB__/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="__STATIC__/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="__LIB__/Hui-iconfont/1.0.7/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="__LIB__/icheck/icheck.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/app.css"/>
    <link rel="stylesheet" type="text/css" href="__LIB__/icheck/icheck.css"/>
    
    <!--[if IE 6]>
    <script type="text/javascript" src="__LIB__/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--定义JavaScript常量-->
<script>
    window.THINK_ROOT = '<?php echo \think\Request::instance()->root(); ?>';
    window.THINK_MODULE = '<?php echo \think\Url::build("/" . \think\Request::instance()->module(), "", false); ?>';
    window.THINK_CONTROLLER = '<?php echo \think\Url::build("___", "", false); ?>'.replace('/___', '');
</script>
</head>
<body>

<nav class="breadcrumb">
    <div id="nav-title"></div>
    <a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:;" title="刷新"><i class="Hui-iconfont"></i></a>
</nav>


<div class="page-container">
    <form class="form form-horizontal" id="form" method="post" action="<?php echo \think\Request::instance()->baseUrl(); ?>">
        <input type="hidden" name="id" value="<?php echo isset($vo['id']) ? $vo['id'] :  ''; ?>">
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>商品名称（中文）：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="<?php echo isset($vo['name']) ? $vo['name'] :  ''; ?>" placeholder="" name="name"
                       datatype="*" nullmsg="请填写商品名称（中文）">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        
          <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>商品名称（英文）：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="<?php echo isset($vo['name']) ? $vo['name'] :  ''; ?>" placeholder="" name="name_en"
                       datatype="*" nullmsg="请填写商品名称（英文）">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>商品价格：</label>
            <div class="formControls col-xs-6 col-sm-6 skin-minimal">
                <div class="radio-box">
                     <label class="form-label col-xs-3 col-sm-6"><span class="c-red">*</span>标准价格：</label>
		            <div class="formControls col-xs-6 col-sm-6">
		                <input type="text" class="input-text" value="<?php echo isset($vo['price']) ? $vo['price'] :  ''; ?>" placeholder="" name="price"
		                       datatype="*" nullmsg="请填写标准价格">
		            </div>
                </div>
                <div class="col-xs-3 col-sm-3"></div>
                
                <div class="radio-box">
                    <label class="form-label col-xs-3 col-sm-6"><span class="c-red">*</span>会员价格：</label>
		            <div class="formControls col-xs-6 col-sm-6">
		                <input type="text" class="input-text" value="<?php echo isset($vo['member_price']) ? $vo['member_price'] :  ''; ?>" placeholder="" name="member_price"
		                       datatype="*" nullmsg="请填写会员价格">
		            </div>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
                    <div class="col-xs-3 col-sm-3"></div>
        
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>商品图片：</label>
            <div class="formControls col-xs-3 col-sm-9">
            <table style="width:726px;margin-left: 0 auto;">
            <tr >
                <td><img id= "img_src_1"  style="width:133px;height:168px;" src="http://s.mysipo.com/manage/Uploads/Picture/2016-10-21/5809beb8477e8.png"></td>
                <td><img id= "img_src_2" style="width:133px;height:168px;" src="http://s.mysipo.com/manage/Uploads/Picture/2016-10-21/5809beb8477e8.png"></td>
                <td><img id= "img_src_3" style="width:133px;height:168px;" src="http://s.mysipo.com/manage/Uploads/Picture/2016-10-21/5809beb8477e8.png"></td>
                <td><img id= "img_src_4" style="width:133px;height:168px;" src="http://s.mysipo.com/manage/Uploads/Picture/2016-10-21/5809beb8477e8.png"></td>
                <td><img id= "img_src_5" style="width:133px;height:168px;" src="http://s.mysipo.com/manage/Uploads/Picture/2016-10-21/5809beb8477e8.png"></td>
            </tr>
            
            <input type="hidden" id="upload_1" name="img_src[]" value="" >
            <input type="hidden" id="upload_2" name="img_src[]" value="" >
            <input type="hidden" id="upload_3" name="img_src[]" value="" >
            <input type="hidden" id="upload_4" name="img_src[]" value="" >
            <input type="hidden" id="upload_5" name="img_src[]" value="" >
            
            <tr class="col-xs-3 col-sm-3"></tr>
            <tr  class="text-c">
                <td><button type="button" class="btn btn-primary radius " onclick="layer_open('文件上传','/admin/upload/index/id/img_src_1.html')">图片上传</button></td>
                <td><button type="button" class="btn btn-primary radius " onclick="layer_open('文件上传','/admin/upload/index/id/img_src_2.html')">图片上传</button></td>
                <td><button type="button" class="btn btn-primary radius " onclick="layer_open('文件上传','/admin/upload/index/id/img_src_3.html')">图片上传</button></td>
                <td><button type="button" class="btn btn-primary radius " onclick="layer_open('文件上传','/admin/upload/index/id/img_src_4.html')">图片上传</button></td>
                <td><button type="button" class="btn btn-primary radius " onclick="layer_open('文件上传','/admin/upload/index/id/img_src_5.html')">图片上传</button></td>
            </tr>
             <tr class="col-xs-3 col-sm-3"></tr>
            <tr  class="text-c">
                <td><button type="button" class="btn btn-danger radius " onclick="del_path(1)">清理图片</button></td>
                <td><button type="button" class="btn btn-danger radius " onclick="del_path(2)">清理图片</button></td>
                <td><button type="button" class="btn btn-danger radius " onclick="del_path(3)">清理图片</button></td>
                <td><button type="button" class="btn btn-danger radius " onclick="del_path(4)">清理图片</button></td>
                <td><button type="button" class="btn btn-danger radius " onclick="del_path(5)">清理图片</button></td>
            </tr>
            
            </table>
         
            
            
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"></label>
            <div class="formControls col-xs-6 col-sm-6">
                小提示：第一张图片为主图片
<!--                 <span class="label label-success f-16">请务必上传一张</span>
 -->            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>品类：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <div class="select-box">
                    <select name="group_id" class="select">
                        <option value="0" selected="selected">请选择</option>
                        <option value="1">系统管理</option>
                        <option value="2">工具</option>
                        <option value="3">菜单管理</option>
                        <option value="4">规格管理</option>
                   </select>
                </div>
                      
                
                  <ul style="margin-top:10px">
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                  <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">500ml</span></li>
                      <li style="margin-top:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">300ml</span></li>
                 
                 </ul>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>规格：</label>
            <div class="formControls col-xs-6 col-sm-9">
                <span style="width: 641px;">
                 <ul id="min_title_list" class="acrossTab cl" style="background-image:url(); width: 482px; left: 0px;">
                    <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                    <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                    <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                    <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                                     <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">啤酒</span><i></i></li>
                                     <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                                     <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                                     <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                                     <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                                     <li style="margin-top:10px;margin-right:10px" class="btn btn-secondary radius" ><span data-href="/admin/menu/index.html">菜单列表</span><i></i></li>
                 
                 </ul>
             
                 </span>
        
            </div>
            
            
            
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        

        
       
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-6 col-sm-6 skin-minimal">
                <div class="radio-box">
                    <input type="radio" name="status" id="radio-0" value="1">
                    <label for="radio-0">上架</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="status" id="radio-1" value="0">
                    <label for="radio-1">下架</label>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
       <!--  <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">备注：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <textarea class="textarea" placeholder="备注" name="remark" onKeyUp="textarealength(this, 100)"><?php echo isset($vo['remark']) ? $vo['remark'] :  ''; ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div> -->
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-primary radius">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>
                <button type="button" class="btn btn-default radius ml-20" onClick="layer_close();">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="__LIB__/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__LIB__/layer/2.4/layer.js"></script>
<script type="text/javascript" src="__STATIC__/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="__STATIC__/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="__STATIC__/js/app.js"></script>
<script type="text/javascript" src="__LIB__/icheck/jquery.icheck.min.js"></script>

<script type="text/javascript" src="__LIB__/Validform/5.3.2/Validform.min.js"></script>
<script>
    $(function () {
        $("[name='status'][value='<?php echo isset($vo['status']) ? $vo['status'] :  '1'; ?>']").attr("checked", true);

        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form").Validform({
            tiptype: 2,
            ajaxPost: true,
            showAllError: true,
            callback: function (ret) {
                ajax_progress(ret);
            }
        });
    })
    
    function del_path(id){
    	$('#img_src_'+id).attr('src','http://s.mysipo.com/manage/Uploads/Picture/2016-10-21/5809beb8477e8.png');
    	$('#upload_'+id).attr('value','');

    }
</script>

</body>
</html>