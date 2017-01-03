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
            
            $res = Db::name("AdminMember")->where(array('id'=>$id))->update($data);
           
            if($res){
                $flag = Db::name("AdminMemberCurricum")->where(array('mid' => $id))->find();
                
                
            	for ($i=0;$i<3;$i++){
            		$curricum['rz_time']        = $post['rz_time'][$i];
            		$curricum['corporate_name'] = $post['corporate_name'][$i];
            		$curricum['money']          = $post['money'][$i];
            		$curricum['reasons']        = $post['reasons'][$i];
            		$curricum['zm_name']        = $post['zm_name'][$i];
            		$curricum['sposition']       = $post['sposition'][$i];
            		if($flag){
            		    $id_c = Db::name("AdminMemberCurricum")->where(array('id' => $post['rz_ids'][$i]))->update($curricum);
            		    
            		}else{
            		    $curricum['mid'] = $id;
            		    $id_c = Db::name("AdminMemberCurricum")->insert($curricum);
            		    
            		}
            	}
            	$flag = Db::name("AdminMemberEducation")->where(array('mid' => $id))->find();
            	 
            	for ($i=0;$i<2;$i++){
            		$education['etime']        = $post['etime'][$i];
            		$education['ename']        = $post['ename'][$i];
            		$education['zhuanye']      = $post['zhuanye'][$i];
            		$education['type']         = $post['type'][$i];
            		$education['is_biye']      = $post['is_biye'][$i];
            		$education['xuewei']       = $post['xuewei'][$i];
            		
            		if($flag){
            		    $id_e = Db::name("AdminMemberEducation")->where(array('id' => $post['e_ids'][$i]))->update($education);
            		}else{
            			$education['mid'] = $id;
            			$id_c = Db::name("AdminMemberEducation")->insert($education);
            		
            		}
            	}
            	$flag = Db::name("AdminMemberFamily")->where(array('mid' => $id))->find();
            	 
            	for ($i=0;$i<2;$i++){
            		$family['fname']        = $post['fname'][$i];
            		$family['guanxi']       = $post['guanxi'][$i];
            		$family['fsex']         = $post['fsex'][$i];
            		$family['fage']         = $post['fage'][$i];
            		$family['fmobile']      = $post['fmobile'][$i];
            		
            		if($flag){
            		    $id_f = Db::name("AdminMemberFamily")->where(array('id' => $post['f_ids'][$i]))->update($family);
            		}else{
            			$family['mid'] = $id;
            			$id_c = Db::name("AdminMemberFamily")->insert($family);
            		
            		}
            		
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
            if(!$Curricum){
                $Curricum[]= array();
                $Curricum[]= array();
                $Curricum[]= array();
            }
            
            if(!$Education){
            	$Education[]= array();
            	$Education[]= array();
            }
            
            if(!$Family){
            	$Family[]= array();
            	$Family[]= array();
            }
            
            $dep = Db::name("ViewAdminDepartment")->field('title,id')->where('pid=0')->order("id desc")->select();
            $this->view->assign('dep', $dep);
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
	   	    
	   	    $dep = Db::name("ViewAdminDepartment")->field('title,id')->where('pid=0')->order("id desc")->select();
	   	    $this->view->assign('dep', $dep);
	   	 
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
   
   
   /**
    * 导出
    */
   public function export(){
   	 
   	$header = ['员工编号', '员工姓名', '性别', '手机号', '所属部门', '职位', '个人业绩', '籍贯', '家庭住址', '户籍地址', '身份证', '民族', '血型','学历','婚姻状况'];
   	$data = Db::name("AdminMember")->field('id,username,sex,mobile,department_id,position,achievement,place_origin,address,registry,idcard,nation,blood_type,highest_degree,marital_status')->order("id desc")->select();

   	
   	$dep = Db::name("ViewAdminDepartment")->field('title,id')->where('pid=0')->order("id desc")->select();
   	$department =  array();
   	foreach ($dep as $d){
   	    $department[$d['id']] = $d['title'];
   	}
   	
   	foreach ($data as &$val){
   		if($val['sex']==1){
   			$val['sex'] = "男";
   		}else{
   			$val['sex'] = "女";
   		}
   		if($val['marital_status']==1){
   			$val['marital_status'] = "已婚";
   		}else{
   			$val['marital_status'] = "单身";
   		}
   		if ($val['department_id']){
   		   $val['department_id'] = $department[$val['department_id']];
   		}
   	}
   
   	if ($error = \Excel::export($header, $data, "员工信息导出-".date('YmdHis'), '2003')) {
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
   		$header = ['A'=>'id', 'B'=>'username', 'C'=>'sex', 'D'=>'mobile', 'E'=>'department_id', 'F'=>'position', 'G'=>'achievement', 'H'=>'place_origin', 'I'=>'address', 'J'=>'registry', 'K'=>'idcard', 'L'=>'nation', 'M'=>'blood_type', 'N'=>'highest_degree', 'O'=>'marital_status'];
   
   		if ($error = \Excel::parse($file, $header, "10000", 'import_admin_member')) {
   			//throw new Exception($error);
   			return ajax_return_adv('导入成功'.$error.'条数据', 'parent');
   		}
   
   		 
   
   		 
   	}else{
   		return $this->view->fetch();
   		 
   	}
   }
   
}
