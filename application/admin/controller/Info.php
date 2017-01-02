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

class Info
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
     * 员工信息页面
     * @return mixed
     */
    public function index()
    {
    	$name = $this->request->param('username');
    	$where = array('status' => 0);
    	
    	if($name){
    		$where['username']=array('like',$name);
    	}
    	
    	$list = Db::name("AdminMember")->where($where)->order('id desc')->paginate(10);
    	$count = Db::name("AdminMember")->where($where)->count();
    	$this->view->assign('list', $list);
    	
    	
    	$this->view->assign('count', $count);
        return $this->view->fetch();
        
    }
    
        
    /**
     * 查看信息
     */
    public function info(){
        $id = $this->request->param('id');
        $list = Db::name("AdminMember")->where(array('id' => $id))->find();
        
        $Curricum  = Db::name("AdminMemberCurricum")->where(array('mid' => $id))->select();
        $Education = Db::name("AdminMemberEducation")->where(array('mid' => $id))->select();
        $Family    = Db::name("AdminMemberFamily")->where(array('mid' => $id))->select();
        
        $this->view->assign('vo', $list);
        $this->view->assign('curricum', $Curricum);
        $this->view->assign('education', $Education);
        $this->view->assign('family', $Family);
        return $this->view->fetch();
    }
    
    /**
     * 查看信息
     */
    public function edit(){
        if ($this->request->isAjax() && $this->request->isPost()) {
            $data = $post =  $this->request->post();
            $id = $data['id'];
            unset($data['id']);
            $list = Db::name("AdminMember")->field('id')->where(array('id'=>$id, 'status'=>0))->find();
            if(!$list){
            	return ajax_return_adv('数据不存在，请联系管理员核实', '');
            }
            
            // 写入数据表
            
            
            $data['admin_id'] = UID;
            $data['update_time'] = time();
            unset($data['rz_time']);
            unset($data['corporate_name']);
            unset($data['money']);
            unset($data['reasons']);
            unset($data['sposition']);
            unset($data['zm_name']);
             
            unset($data['etime']);
            unset($data['ename']);
            unset($data['zhuanye']);
            unset($data['type']);
            unset($data['is_biye']);
            unset($data['xuewei']);
             
            unset($data['fname']);
            unset($data['guanxi']);
            unset($data['fsex']);
            unset($data['fage']);
            unset($data['fmobile']);
            unset($data['e_ids']);
            unset($data['rz_ids']);
            unset($data['f_ids']);
            
            $id = Db::name("AdminMember")->where(array('id'=>$id))->update($data);
           
            if($id){
            	for ($i=0;$i<3;$i++){
            		$curricum['rz_time']        = $post['rz_time'][$i];
            		$curricum['corporate_name'] = $post['corporate_name'][$i];
            		$curricum['money']          = $post['money'][$i];
            		$curricum['reasons']        = $post['reasons'][$i];
            		$curricum['zm_name']        = $post['zm_name'][$i];
            		$curricum['sposition']       = $post['sposition'][$i];
            		$id_c = Db::name("AdminMemberCurricum")->where(array('id' => $post['rz_ids'][$i]))->update($curricum);
            	}
            		
            	for ($i=0;$i<2;$i++){
            		$education['etime']        = $post['etime'][$i];
            		$education['ename']        = $post['ename'][$i];
            		$education['zhuanye']      = $post['zhuanye'][$i];
            		$education['type']         = $post['type'][$i];
            		$education['is_biye']      = $post['is_biye'][$i];
            		$education['xuewei']       = $post['xuewei'][$i];
            		$id_e = Db::name("AdminMemberEducation")->where(array('id' => $post['e_ids'][$i]))->update($education);
            		
            	}
            
            	for ($i=0;$i<2;$i++){
            		$family['fname']        = $post['fname'][$i];
            		$family['guanxi']       = $post['guanxi'][$i];
            		$family['fsex']         = $post['fsex'][$i];
            		$family['fage']         = $post['fage'][$i];
            		$family['fmobile']      = $post['fmobile'][$i];
            		$id_f = Db::name("AdminMemberFamily")->where(array('id' => $post['f_ids'][$i]))->update($family);
            		
            	}
            	return ajax_return_adv('修改成功', 'parent');
            }else{
            	return ajax_return_adv('修改失败，请重试', '');
            }
        }else{
            $id = $this->request->param('id');
            $list = Db::name("AdminMember")->where(array('id' => $id))->find();
            
            $Curricum  = Db::name("AdminMemberCurricum")->where(array('mid' => $id))->select();
            $Education = Db::name("AdminMemberEducation")->where(array('mid' => $id))->select();
            $Family    = Db::name("AdminMemberFamily")->where(array('mid' => $id))->select();
            
            $this->view->assign('vo', $list);
            $this->view->assign('curricum', $Curricum);
            $this->view->assign('education', $Education);
            $this->view->assign('family', $Family);
            return $this->view->fetch();
        }
    	
    }
    
    /**
     * 增加员工
     */
   public function add()
   {
       
   if ($this->request->isAjax() && $this->request->isPost()) {
	   		 $data = $post =  $this->request->post();
	   		
	   		 $list = Db::name("AdminMember")->field('id')->where(array('mobile'=>$data['mobile'],'status'=>0))->find();
	   		 if($list){
	   		 	return ajax_return_adv('手机号已存在，请不要重复添加', '');
	   		 }
	   		
	   		 // 写入数据表
	   		
	   		
	   		 $data['admin_id'] = UID;
	   		 $data['add_time'] = time();
	   		 unset($data['rz_time']);
	   		 unset($data['corporate_name']);
	   		 unset($data['money']);
	   		 unset($data['reasons']);
	   		 unset($data['sposition']);
	   		 unset($data['zm_name']);
	   		 
	   		 unset($data['etime']);
	   		 unset($data['ename']);
	   		 unset($data['zhuanye']);
	   		 unset($data['type']);
	   		 unset($data['is_biye']);
	   		 unset($data['xuewei']);
	   		 
	   		 unset($data['fname']);
	   		 unset($data['guanxi']);
	   		 unset($data['fsex']);
	   		 unset($data['fage']);
	   		 unset($data['fmobile']);
	   		  
	   		 
	   		 Db::name("AdminMember")->insert($data);
	   		 $id = Db::name('AdminMember')->getLastInsID();
	   		 if($id){
	   		     for ($i=0;$i<3;$i++){
	   		     	$curricum[$i]['rz_time']        = $post['rz_time'][$i];
	   		     	$curricum[$i]['corporate_name'] = $post['corporate_name'][$i];
	   		     	$curricum[$i]['money']          = $post['money'][$i];
	   		     	$curricum[$i]['reasons']        = $post['reasons'][$i];
	   		     	$curricum[$i]['zm_name']        = $post['zm_name'][$i];
	   		     	$curricum[$i]['sposition']       = $post['sposition'][$i];
	   		     	$curricum[$i]['add_time']       = time();
	   		     	$curricum[$i]['mid']            = $id;
	   		     	
	   		     }
	   		     
	   		     for ($i=0;$i<2;$i++){
	   		     	$education[$i]['etime']        = $post['etime'][$i];
	   		     	$education[$i]['ename']        = $post['ename'][$i];
	   		     	$education[$i]['zhuanye']      = $post['zhuanye'][$i];
	   		     	$education[$i]['type']         = $post['type'][$i];
	   		     	$education[$i]['is_biye']      = $post['is_biye'][$i];
	   		     	$education[$i]['xuewei']       = $post['xuewei'][$i];
	   		     	$education[$i]['add_time']     = time();
	   		     	$education[$i]['mid']          = $id;
	   		     }
	   		      
	   		     for ($i=0;$i<2;$i++){
	   		     	$family[$i]['fname']        = $post['fname'][$i];
	   		     	$family[$i]['guanxi']       = $post['guanxi'][$i];
	   		     	$family[$i]['fsex']         = $post['fsex'][$i];
	   		     	$family[$i]['fage']         = $post['fage'][$i];
	   		     	$family[$i]['fmobile']      = $post['fmobile'][$i];
	   		     	$family[$i]['add_time']     = time();
	   		     	$family[$i]['mid']          = $id;
	   		     }
	   		     $id_c = Db::name("AdminMemberCurricum")->insertAll($curricum);
	   		     $id_c = Db::name("AdminMemberEducation")->insertAll($education);
	   		     $id_f = Db::name("AdminMemberFamily")->insertAll($family);
	   		 	return ajax_return_adv('增加成功', 'parent');
	   		 }else{
	   		 	return ajax_return_adv('增加失败，请重试', '');	   		 	
	   		 }
	   		 
	   	}else{
	   		$member = Db::name('AdminMember')->where(array('id'=>0))->select();
	   		return $this->view->fetch();
	   		 
	   	}
   }

   public function delete()
   {
   	if ($this->request->isAjax() && $this->request->isPost()) {
   		$data = $this->request->post();
   		$list = Db::name("AdminMember")->field('id')->where(array('id' => array('in',$data['id']),'status' => 0))->find();
   		if(!$list){
   			return ajax_return_adv('删除异常', '');
   		}
   		// 更新数据表
   		 
   		$log['status'] = 1;
   		$log['admin_id'] = UID;
   		$log['update_time'] = time();
   		$id = Db::name("AdminMember")->where(array('id' => array('in',$data['id'])))->update($log);
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
