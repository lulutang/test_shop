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

class Menu
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
    	
    	$name = $this->request->param('name');
    	$where = array('status' => 0);
    	
    	if($name){
    		$where['title']=array('like',$name);
    	}
    	
    	$list = Db::name("product")->where($where)->order('id desc')->paginate(10);
    	$count = Db::name("product")->where($where)->count();
    	$this->view->assign('list', $list);
    	
    	
    	$this->view->assign('count', $count);
        return $this->view->fetch();
        
    }

    /**
     * 增加菜单
     */
   public function add()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$post = $this->request->Post();
   		if(!$post){
   			return ajax_return_adv('操作异常');
   		}
   		
   		$post['product_code'] = date('YmdHis');
   		
		foreach ( $post ['img_src'] as $key => $pic ) {
			switch ($key) {
				case 0 :
					$post['frist_img']=$pic;
					break;
				case 1 :
					$post['two_img']=$pic;
					break;
				case 2 :
					$post['three_img']=$pic;
					break;
				case 3 :
					$post['four_img']=$pic;
					break;
				case 4 :
					$post['five_img']=$pic;
					break;
			}
   		}
   		unset($post['img_src']);
   		$res = Db::name("product")->insert ($post);
   		if($res){
   			return ajax_return_adv('操作成功', 'parent');
   		}else{
   			return ajax_return_adv('数据库操作异常');
   		}
   		
   	}else{
   		$where = array('status' => 0);
   		 
   		$list = Db::name("CategoryManagement")->where($where)->order('id desc')->select ();
   		$this->view->assign('list', $list);
   		return $this->view->fetch();
   	}
   	  
   }
   
	/**
	 * 获取品类
	 */
   public function getpinlei(){
   	$data = $this->request->post();
   	$id = $data ['id'];
   	$list = Db::name("SpecificationManagement")->field('id,title')->where(array('cid' => $id, 'status' => 0))->select();
   	return ajax_return($list);
   	
   	
   }
}
