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
     * 品类管理页面
     * @return mixed
     */
    public function index()
    {
    	$name = $this->request->param('name');
    	$where = array('status' => 0);
    	 
    	if($name){
    		$where['title']=array('like',$name);
    	}
    	
    	$list = Db::name("CategoryManagement")->where($where)->order('id desc')->paginate(10);
    	
    	$count = Db::name("CategoryManagement")->where($where)->count();
    	 
    	$this->view->assign('list', $list);
    	 
    	$this->view->assign('page', '');
    	 
        $this->view->assign('count', $count); 
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
   		$list = Db::name("CategoryManagement")->field('id')->where(array('id' => array('in',$data['id']),'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('删除异常', '');
   		}
   		// 更新数据表
   
   		$log['status'] = 1;
   		$log['admin_id'] = UID;
   		$log['update_time'] = time();
   		$id = Db::name("CategoryManagement")->where(array('id' => array('in',$data['id'])))->update($log);
   		if($id){
   			return ajax_return_adv('删除成功', 'parent');
   		}else{
   			return ajax_return_adv('删除失败，请重试', '');
   
   		}
   
   	}else{
   		return $this->view->fetch();
   
   	}
   }
   
}
