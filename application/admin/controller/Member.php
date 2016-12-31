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
    	$name = $this->request->param('name');
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
	   		 
	   		 $list = Db::name("Member")->field('id')->where(array('mobile'=>$data['mobile']))->find();
	   		 if($list){
	   		 	return ajax_return_adv('手机号已存在，请不要重复添加', '');
	   		 }
	   		 $list = Db::name("Member")->field('id')->where(array('username' => $data['username']))->find();
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


   
}
