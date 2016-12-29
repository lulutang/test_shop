<?php
/**
 * 品类管理
 *
 * @author tanglulu
 */

namespace app\admin\controller;

\think\Loader::import('controller/Jump', TRAIT_PATH, EXT);

use think\Loader;
use think\Session;
use think\Db;
use think\Config;
use think\Exception;
use think\View;
use think\Request;

class Category
{
    use \traits\controller\Jump;

    // 视图类实例
    protected $view;
    // Request实例
    protected $request;

    public function __construct()
    {
        if (null === $this->view) {
            $this->view = View::instance(Config::get('template'), Config::get('view_replace_str'));
        }
        if (null === $this->request) {
            $this->request = Request::instance();
        }

        // 用户ID
        defined('UID') or define('UID', Session::get(Config::get('rbac.user_auth_key')));
    }

    /**
     * 用户登录页面
     * @return mixed
     */
    public function index()
    {
    	
    	$list = Db::name("CategoryManagement")->where(array('status' => 0))->select();
    	$this->view->assign('list', $list);
    	 
    	$this->view->assign('page', '');
    	 
        $this->view->assign('count', 0); 
        return $this->view->fetch();
        
    }

    /**
     * 增加品类
     */
   public function add()
   {
	   	if ($this->request->isAjax() && $this->request->isPost()) {
	   		 $data = $this->request->post();
	   		 
	   		 $list = Db::name("CategoryManagement")->field('id')->where(array('status' => 0,'title'=>$data['name']))->find();
	   		 if($list){
	   		 	return ajax_return_adv('请不要重复添加', '');
	   		 }
	   		 // 写入数据表
	   		
	   		 $log['title'] = $data['name'];
	   		 $log['admin_id'] = UID;
	   		 $log['add_time'] = time();
	   		 $id = Db::name("CategoryManagement")->insert($log);
	   		 if($id){
	   		 	return ajax_return_adv('增加成功', 'parent');
	   		 }else{
	   		 	return ajax_return_adv('增加失败，请重试', '');
	   		 	
	   		 }
	   		 
	   	}else{
	   		return $this->view->fetch();
	   		 
	   	}
   }

   /**
    * 修改品类
    */
   public function edit()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		
   		
   		$list = Db::name("CategoryManagement")->field('id')->where(array('id' => $data['id'], 'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('修改异常', '');
   		}
   		// 更新数据表
   
   		$log['title'] = $data['name'];
   		$log['admin_id'] = UID;
   		$log['update_time'] = time();
   		$id = Db::name("CategoryManagement")->where(array('id' => $data['id']))->update($log);
   		if($id){
   			return ajax_return_adv('修改成功', 'parent','','','/admin/category/index');
   		}else{
   			return ajax_return_adv('修改失败，请重试', '');
   
   		}
   		 
   	}else{
   		$id = $this->request->param('id');
   		
   		$list = Db::name("CategoryManagement")->field('id,title')->where(array('id' => $id))->find();
   		$this->view->assign('vo', $list);
   		 
   		return $this->view->fetch();
   		 
   	}
   }  
   
   

   /**
    * 删除品类
    */
   public function delete()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   	    $data = $this->request->post();
   		$list = Db::name("CategoryManagement")->field('id')->where(array('id' => $data['id'],'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('删除异常', '');
   		}
   		// 更新数据表
   
   		$log['status'] = 1;
   		$log['admin_id'] = UID;
   		$log['update_time'] = time();
   		$id = Db::name("CategoryManagement")->where(array('id' => $data['id']))->update($log);
   		if($id){
   			return ajax_return_adv('删除成功', 'parent');
   		}else{
   			return ajax_return_adv('删除失败，请重试', '');
   
   		}
   
   	}else{
   		return $this->view->fetch();
   
   	}
   }
    /**
     * 登录检测
     * @return \think\response\Json
     */
    public function checkLogin()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {
            $data = $this->request->post();
            $validate = Loader::validate('Pub');
            if (!$validate->scene('login')->check($data)) {
                return ajax_return_adv_error($validate->getError());
            }

            $map['account'] = $data['account'];
            $map['status'] = 1;
            $auth_info = \Rbac::authenticate($map);

            // 使用用户名、密码和状态的方式进行认证
            if (null === $auth_info) {
                return ajax_return_adv_error('帐号不存在或已禁用！');
            } else {
                if ($auth_info['password'] != password_hash_tp($data['password'])) {
                    return ajax_return_adv_error('密码错误！');
                }

                // 生成session信息
                Session::set(Config::get('rbac.user_auth_key'), $auth_info['id']);
                Session::set('user_name', $auth_info['account']);
                Session::set('real_name', $auth_info['realname']);
                Session::set('last_login_ip', $auth_info['last_login_ip']);
                Session::set('last_login_time', $auth_info['last_login_time']);

                // 超级管理员标记
                if ($auth_info['id'] == 1) {
                    Session::set(Config::get('rbac.admin_auth_key'), true);
                }

                // 保存登录信息
                $update['last_login_time'] = time();
                $update['login_count'] = ['exp', 'login_count+1'];
                $update['last_login_ip'] = $this->request->ip();
                Db::name("AdminUser")->where('id', $auth_info['id'])->update($update);

                // 记录登录日志
                $log['uid'] = $auth_info['id'];
                $log['login_ip'] = $this->request->ip();
                $log['login_location'] = implode(" ", \Ip::find($log['login_ip']));
                $log['login_browser'] = \Agent::getBroswer();
                $log['login_os'] = \Agent::getOs();
                Db::name("LoginLog")->insert($log);

                // 缓存访问权限
                \Rbac::saveAccessList();

                return ajax_return_adv('登录成功！', '');
            }
        } else {
            throw new Exception("非法请求");
        }
    }

    /**
     * 修改密码
     */
    public function password()
    {
        $this->checkUser();
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 数据校验
            $validate = Loader::validate('Pub');
            if (!$validate->scene('password')->check($data)) {
                return ajax_return_adv_error($validate->getError());
            }

            // 查询旧密码进行比对
            $info = Db::name("AdminUser")->where("id", UID)->field("password")->find();
            if ($info['password'] != password_hash_tp($data['oldpassword'])) {
                return ajax_return_adv_error("旧密码错误");
            }

            // 写入新密码
            if (false === Loader::model('AdminUser')->updatePassword(UID, $data['password'])) {
                return ajax_return_adv_error("密码修改失败");
            }

            return ajax_return_adv("密码修改成功", '');
        } else {
            return $this->view->fetch();
        }
    }

    /**
     * 查看用户信息|修改资料
     */
    public function profile()
    {
        $this->checkUser();
        if ($this->request->isPost()) {
            // 修改资料
            $data = $this->request->only(['realname', 'email', 'mobile', 'remark'], 'post');
            if (Db::name("AdminUser")->where("id", UID)->update($data) === false) {
                return ajax_return_adv_error("信息修改失败");
            }

            return ajax_return_adv("信息修改成功", '');
        } else {
            // 查看用户信息
            $vo = Db::name("AdminUser")->field('realname,email,mobile,remark')->where("id", UID)->find();
            $this->view->assign('vo', $vo);

            return $this->view->fetch();
        }
    }
}
