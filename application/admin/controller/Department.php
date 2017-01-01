<?php
/**
 * tpAdmin [a web admin based ThinkPHP5]
 *
 * @author yuan1994 <tianpian0805@gmail.com>
 * @link http://tpadmin.yuan1994.com/
 * @copyright 2016 yuan1994 all rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

//------------------------
// 公开不授权控制器
//-------------------------

namespace app\admin\controller;

\think\Loader::import('controller/Jump', TRAIT_PATH, EXT);

use think\Loader;
use think\Session;
use think\Db;
use think\Config;
use think\Exception;
use think\View;
use think\Request;

class Department
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
    	
    	$where = array('status' => 0, 'pid'=>0);
    	$list = Db::name("ViewAdminDepartment")->where($where)->order('id desc')->select();
    	if($list){
    		foreach ($list as &$val){

    			$where = array('status' => 0, 'pid'=>$val['id']);
    			$lists = Db::name("ViewAdminDepartment")->where($where)->order('id desc')->select();
    			if($lists){
    				$val['erji'] = $lists;
    			}
    		}
    	}
    	
    	$this->view->assign('list', $list);
    	$this->view->assign('count', 0);
    	$this->view->assign('page', '');
        return $this->view->fetch();
        
    }

    /**
     * 增加部门
     */
   public function add()
   {
   	
   	
      if ($this->request->isAjax() && $this->request->isPost()) {
	   		 $data = $this->request->post();
	   		 
	   		 $list = Db::name("ViewAdminDepartment")->field('id')->where(array('title'=>$data['title'],'status'=>0))->find();
	   		 if($list){
	   		 	return ajax_return_adv('已存在，请不要重复添加', '');
	   		 }
	   		
	   		 // 写入数据表
	   		
	   	
	   		 $data['admin_id'] = UID;
	   		 $data['add_time'] = time();
	   		 $id = Db::name("ViewAdminDepartment")->insert($data);
	   		 if($id){
	   		 	return ajax_return_adv('增加成功', 'parent');
	   		 }else{
	   		 	return ajax_return_adv('增加失败，请重试', '');
	   		 	
	   		 }
	   		 
	   	}else{
	   		$id = $this->request->param('id');
	   		$this->view->assign('pid', $id);
	   		return $this->view->fetch();
	   		 
	   	}
   }
   /**
    * 删除用户
    */
   public function delete()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		$list = Db::name("ViewAdminDepartment")->field('id')->where(array('id' => array('in',$data['id']),'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('删除异常', '');
   		}
   		// 更新数据表
   
   		$log['status'] = 1;
   		$log['admin_id'] = UID;
   		$log['update_time'] = time();
   		$id = Db::name("ViewAdminDepartment")->where(array('id' => array('in',$data['id'])))->update($log);
   		$ids= explode(',', $data['id']);
   		
   		foreach ($ids as $val){
   			if($val>0){
   				$list = Db::name("ViewAdminDepartment")->field('id,pid')->where(array('id' => $val))->find();
   					if($list['pid'] == 0){
   						$id = Db::name("ViewAdminDepartment")->where(array('pid' => $list['id']))->update($log);
   							
   					}
   			}
   			
   		}
   		
   		if($id){
   			return ajax_return_adv('删除成功', 'parent','','','/admin/department/index');
   		}else{
   			return ajax_return_adv('删除失败，请重试', '');
   				
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
   
   		$id = $data['id'];
   		$list = Db::name("ViewAdminDepartment")->field('id')->where(array('id' => $id, 'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('修改异常', '');
   		}
   		// 更新数据表
   
   		 
   		$data['admin_id'] = UID;
   		$data['update_time'] = time();
   		unset($data['id']);
   		$id = Db::name("ViewAdminDepartment")->where(array('id' => $id))->update($data);
   		if($id){
   			return ajax_return_adv('修改成功', 'parent');
   		}else{
   			return ajax_return_adv('修改失败，请重试', '');
   				
   		}
   		 
   	}else{
   		$id = $this->request->param('id');
   
   		$list = Db::name("ViewAdminDepartment")->where(array('id' => $id))->find();
   		$this->view->assign('vo', $list);
   		 
   		return $this->view->fetch();
   		 
   	}
   }

   
}
