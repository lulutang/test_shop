<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:97:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/department/index.html";i:1483261653;s:94:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/template/base.html";i:1482488954;s:105:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/template/javascript_vars.html";i:1482488954;s:96:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/department/form.html";i:1482897600;s:102:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/department/table_menu.html";i:1483255039;s:94:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/department/th.html";i:1483262958;s:94:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/department/td.html";i:1483261663;s:96:"/Applications/XAMPP/xamppfiles/htdocs/shop/public/../application/admin/view/department/tder.html";i:1483261661;}*/ ?>
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
    <!-- <form class="mb-20" method="get" action="<?php echo \think\Url::build(\think\Request::instance()->action()); ?>">
    <input type="text" class="input-text" style="width:250px" placeholder="输入菜单名称" name="name"
           value="<?php echo \think\Request::instance()->param('name'); ?>">
    <button type="submit" class="btn btn-success"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
</form> -->
     <div class="cl pd-5 bg-1 bk-gray">
        <span class="l">
            <?php if (\Rbac::AccessCheck('add', 'Department', 'admin')) : ?>
<a class="btn btn-primary radius" href="javascript:;" onclick="layer_open('添加一级分类','<?php echo \think\Url::build('add'); ?>')"><i class="Hui-iconfont">&#xe600;</i> 添加一级分类</a>
<?php endif; if (\Rbac::AccessCheck('delete', 'Department', 'admin')) : ?>
<a href="javascript:;" onclick="del_all('<?php echo \think\Url::build('delete'); ?>')" class="btn btn-danger radius ml-5"><i class="Hui-iconfont">&#xe6e2;</i> 删除</a>
<?php endif; ?>

        </span>
       <!--  <span class="r pt-5 pr-5">
            共有数据 ：<strong><?php echo $count; ?></strong> 条
        </span> -->
    </div> 
    <table class="table table-border table-bordered table-hover table-bg mt-20">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" value="" name=""></th>
<th width="40">归属</th>
<th width="200">分类名称</th>
<th width="60">排序</th>

            <th width="70">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><input type="checkbox" name="id[]" value="<?php echo $vo['id']; ?>"></td>
<td class="sub-menu-title dingji_<?php echo $vo['id']; ?>"><a  data-title="一级菜单" href="javascript:dingji(<?php echo $vo['id']; ?>);"><b class="dingji_<?php echo $vo['id']; ?>">+</b></a></td>
<td><?php echo $vo['title']; ?></td>
<td><?php echo $vo['sort']; ?></td>
  <td class="f-14">
                <?php if (\Rbac::AccessCheck('add')) : ?> <a title="增加" href="javascript:;" onclick="layer_open('增加','<?php echo \think\Url::build('add', ['id' => $vo["id"], ]); ?>')" class="label radius ml-5 label-primary">增加</a><?php endif; if (\Rbac::AccessCheck('edit')) : ?> <a title="编辑" href="javascript:;" onclick="layer_open('编辑','<?php echo \think\Url::build('edit', ['id' => $vo["id"], ]); ?>')" style="text-decoration:none" class="ml-5"><i class="Hui-iconfont">&#xe6df;</i></a><?php endif; if (\Rbac::AccessCheck('delete')) : ?> <a title="删除" href="javascript:;" onclick="del(this,'<?php echo $vo['id']; ?>','<?php echo \think\Url::build('delete', []); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a><?php endif; ?>
            </td>
          
        </tr>
        <?php if(isset($vo['erji'])){if(is_array($vo['erji']) || $vo['erji'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo['erji'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr class="text-c dingji_<?php echo $vo['id']; ?>_<?php echo $vo['id']; ?>">
            <td><input type="checkbox" name="id[]" value="<?php echo $v['id']; ?>"></td>
<td class="sub-menu-title"><a  data-title="二级菜单" href="javascript:;"><b>L</b></a></td>
<td ><?php echo $v['title']; ?></td>
<td><?php echo $v['sort']; ?></td>
  <td class="f-14">
                <?php if (\Rbac::AccessCheck('add')) : ?> <a title="增加" href="javascript:;" onclick="layer_open('增加','<?php echo \think\Url::build('add', ['id' => $vo["id"], ]); ?>')" class="label radius ml-5 label-primary">增加</a><?php endif; if (\Rbac::AccessCheck('edit')) : ?> <a title="编辑" href="javascript:;" onclick="layer_open('编辑','<?php echo \think\Url::build('edit', ['id' => $vo["id"], ]); ?>')" style="text-decoration:none" class="ml-5"><i class="Hui-iconfont">&#xe6df;</i></a><?php endif; if (\Rbac::AccessCheck('delete')) : ?> <a title="删除" href="javascript:;" onclick="del(this,'<?php echo $vo['id']; ?>','<?php echo \think\Url::build('delete', []); ?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a><?php endif; ?>
            </td>
          
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; }endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div class="page-bootstrap"><?php echo $page; ?></div>
</div>

<script type="text/javascript" src="__LIB__/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__LIB__/layer/2.4/layer.js"></script>
<script type="text/javascript" src="__STATIC__/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="__STATIC__/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="__STATIC__/js/app.js"></script>
<script type="text/javascript" src="__LIB__/icheck/jquery.icheck.min.js"></script>
}
<script>
function dingji(id){
	$('.dingji_'+id).html('<a  data-title="一级菜单" href="javascript:zhankai(<?php echo $vo['id']; ?>);"><b class="dingji_'+id+'">-</b></a>');
	$('.dingji_'+id+'_'+id).hide();
}

function zhankai(id){
	$('.dingji_'+id).html('<a  data-title="一级菜单" href="javascript:dingji(<?php echo $vo['id']; ?>);"><b class="dingji_'+id+'">+</b></a>');
	$('.dingji_'+id+'_'+id).show();
}
</script>

</body>
</html>