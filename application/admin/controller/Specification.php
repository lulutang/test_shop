<?php
/**
 * 规格管理
 *
 * @author tanglulu
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

class Specification
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
     * 规格首页
     * @return mixed
     */
    public function index()
    {
    	
    	$name = $this->request->param('name');
    	$where = array('status' => 0);
    	
    	if($name){
    		$where['title']=array('like',$name);
    	}
    	
    	$list = Db::name("SpecificationManagement")->where($where)->order('id desc')->paginate(10);
    	$count = Db::name("SpecificationManagement")->where($where)->count();
    	$this->view->assign('list', $list);
    	
    	$this->view->assign('page', '');
    	
    	$this->view->assign('count', $count);
    
        return $this->view->fetch();
        
    }

    /**
     * 增加规格
     */
   public function add()
   {
   	
	   	if ($this->request->isAjax() && $this->request->isPost()) {
	   		$data = $this->request->post ();
			$name = $data ['name'];
			$group_id = $data ['group_id'];
			
			$list = Db::name ( "SpecificationManagement" )->field ( 'id' )->where ( array (
					'status' => 0,
					'title' => $name,
					'cid' => $group_id
			) )->find ();
			if ($list) {
				return ajax_return_adv ( '请不要重复添加', '' );
			}
			
			// 写入数据表
			
			$log ['title'] = $name;
			$log ['cid'] = $group_id;
			$log ['admin_id'] = UID;
			$log ['add_time'] = time ();
			$id = Db::name ( "SpecificationManagement" )->insert ( $log );
			if ($id) {
				return ajax_return_adv('增加成功', 'parent');
	   		 }else{
	   		 	return ajax_return_adv('增加失败，请重试', '');
	   		 	
	   		 }
	   		
	   	}else{
	   		$where = array('status' => 0);
	   		 
	   		$list = Db::name("CategoryManagement")->where($where)->order('id desc')->select();
	   		$this->view->assign('list', $list);
	   		
	   		return $this->view->fetch();
	   	}
	   	
	 
   }

   /**
    * 修改规格
    */
   public function edit()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		$name = $data ['name'];
   		$group_id = $data ['group_id'];
   		$id = $data['id'];
   		$list = Db::name("SpecificationManagement")->field('id')->where(array('id' => $id, 'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('修改异常', '');
   		}
   		// 更新数据表
   		 
   		$log['title'] = $name;
   		$log['admin_id'] = UID;
   		$log['cid'] = $group_id;
   		$log['update_time'] = time();
   		$id = Db::name("SpecificationManagement")->where(array('id' => $data['id']))->update($log);
   		if($id){
   			return ajax_return_adv('修改成功', 'parent');
   		}else{
   			return ajax_return_adv('修改失败，请重试', '');
   			 
   		}
   
   	}else{
   		

   		$id = $this->request->param('id');
   		
   		$list = Db::name("SpecificationManagement")->field('id,title,cid')->where(array('id' => $id))->find();
   		$this->view->assign('vo', $list);
   		
   		$list = Db::name("CategoryManagement")->field('id,title')->order('id desc')->select();
   		$this->view->assign('list', $list);
   
   		
   		
   		
   		return $this->view->fetch();
   
   	}
   }
    
    
   
   /**
    * 删除规格
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
    * 导出规格
    */
   public function export(){
   	
	   $header = ['ID', '规格名称', '所属品类'];
	   $data = Db::name("SpecificationManagement")
	   ->alias('a')
	   ->field('a.id,a.title,c.title as ctitle')
	   ->join('Category_Management c ', 'a.cid=c.id')
	   ->order("a.id desc")->select();
	   
	   if ($error = \Excel::export($header, $data, "规格文件导出", '2003')) {
	   	   throw new Exception($error);
	   }
   }
   

   /**
    * 导入规格
    */
   public function import(){
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		$file = TMP_PATH.$data['file'];
   		$header = ['规格名称', '所属品类'];
   		
   		if ($error = \Excel::parse($file, $header, "10000", 'import_data')) {
   			throw new Exception($error);
   		}
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
  
}
