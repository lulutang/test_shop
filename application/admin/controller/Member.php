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

class Member
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
     * 用户管理页面
     * @return mixed
     */
    public function index()
    {
    	$name = $this->request->param('username');
    	$where = array('status' => 0);
    	 
    	if($name){
    		$where['username']=array('like',$name);
    	}
    	
    	$list = Db::name("Member")->where($where)->order('id desc')->paginate(10);
    	$count = Db::name("Member")->where($where)->count();
    	 
    	$this->view->assign('list', $list);
    	 
    	$this->view->assign('page', '');
    	 
        $this->view->assign('count', $count); 
        return $this->view->fetch();
        
    }

    /**
     * 增加用户
     */
   public function add()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
	   		 $data = $this->request->post();
	   		 
	   		 $list = Db::name("Member")->field('id')->where(array('mobile'=>$data['mobile'],'status'=>0))->find();
	   		 if($list){
	   		 	return ajax_return_adv('手机号已存在，请不要重复添加', '');
	   		 }
	   		 $list = Db::name("Member")->field('id')->where(array('username' => $data['username'],'status'=>0))->find();
	   		 if($list){
	   		 	return ajax_return_adv('昵称已存在，请不要重复添加', '');
	   		 }
	   		 // 写入数据表
	   		
	   		
	   		 $data['admin_id'] = UID;
	   		 $data['add_time'] = time();
	   		 $id = Db::name("Member")->insert($data);
	   		 if($id){
	   		 	return ajax_return_adv('增加成功', 'parent');
	   		 }else{
	   		 	return ajax_return_adv('增加失败，请重试', '');
	   		 	
	   		 }
	   		 
	   	}else{
	   		$member = Db::name('AdminMember')->where(array('id'=>0))->select();
	   		return $this->view->fetch();
	   		 
	   	}
   }
   
   /**
    *  用户充值
    */
   public function pay()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		 
   		// 写入数据表
   
   		$data['admin_id'] = UID;
   		$data['update_time'] = time();
   		$data['money'] = array('exp','money+'.$data['money']);
   		$id = Db::name("Member")->where(array('id'=>$data['id']))->update($data);
   		if($id){
   			return ajax_return_adv('充值成功', 'parent');
   		}else{
   			return ajax_return_adv('充值失败，请重试', '');
   
   		}
   		 
   	}else{
   		$id = $this->request->param('id');
   		$this->view->assign('id', $id);
   		 
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
   		$list = Db::name("Member")->field('id')->where(array('id' => array('in',$data['id']),'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('删除异常', '');
   		}
   		// 更新数据表
   		 
   		$log['status'] = 1;
   		$log['admin_id'] = UID;
   		$log['update_time'] = time();
   		$id = Db::name("Member")->where(array('id' => array('in',$data['id'])))->update($log);
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
    * 修改品类
    */
   public function edit()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		 
   		$id = $data['id'];
   		$list = Db::name("Member")->field('id')->where(array('id' => $id, 'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('修改异常', '');
   		}
   		// 更新数据表
   		 
   		
   		$data['admin_id'] = UID;
   		$data['update_time'] = time();
   		unset($data['id']);
   		$id = Db::name("Member")->where(array('id' => $id))->update($data);
   		if($id){
   			return ajax_return_adv('修改成功', 'parent');
   		}else{
   			return ajax_return_adv('修改失败，请重试', '');
   			 
   		}
   
   	}else{
   		$id = $this->request->param('id');
   		 
   		$list = Db::name("Member")->where(array('id' => $id))->find();
   		$this->view->assign('vo', $list);
   
   		return $this->view->fetch();
   
   	}
   }
    
   /**
    * 导出
    */
   public function export(){
   
   	$header = ['会员编号', '会员姓名', '性别', '手机号', '销售人', '当前余额'];
   	$data = Db::name("Member")->field('id,username,sex,mobile,salesman_id,money')->order("id desc")->select();
    foreach ($data as &$val){
    	if($val['sex']==1){
    		$val['sex'] = "男";
    	}else{
    		$val['sex'] = "女";
    	}
    }
   	
   	if ($error = \Excel::export($header, $data, "会员信息导出-".date('YmdHis'), '2003')) {
   		throw new Exception($error);
   	}
   }
    
   
   /**
    * 导入
    */
   public function import(){
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		$file = TMP_PATH.$data['file'];
   		$header = ['A'=>'id', 'B'=>'username', 'C'=>'sex', 'D'=>'mobile', 'E'=>'salesman_id', 'F'=>'money'];
   		 
   		if ($error = \Excel::parse($file, $header, "10000", 'import_member')) {
   			//throw new Exception($error);
   			return ajax_return_adv('导入成功'.$error.'条数据', 'parent');
   		}
   		 
   
   		 
   
   	}else{
   		return $this->view->fetch();
   
   	}
   }
   
}
