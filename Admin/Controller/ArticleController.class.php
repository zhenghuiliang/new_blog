<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
use Think\Think;
class ArticleController extends Controller{
	//显示文章
    public function artlist(){
	    $Art   = D('Article');
	    $Cate  = D('Cate');
	    $p = isset($_GET['p']) ? $_GET['p'] : 1; 
	    $cateList = $Cate->select();
	    $artList = $Art->order('new_time')->page($p.',1')->select();
	    $count      = $Art->count();// 查询满足要求的总记录数
	    $Page       = new \Think\Page($count,1);// 实例化分页类 传入总记录数和每页显示的记录数
	    $show       = $Page->show();// 分页显示输出
// 	    echo strip_tags(html_entity_decode($show));exit;
	    $i = 0;
	    foreach ($artList as $artinfo){
	        //将时间戳转化日期类型 
	        $artList[$i]['new_time'] = date("Y-m-d",$artinfo['new_time']);
	        //查找它属于那个分类
	        $artList[$i]['cid'] = $Cate->field('mname')->where('id='.$artinfo['cid'])->find()['mname'];
	        //将过滤html标签
	        $artList[$i]['content'] = strip_tags(html_entity_decode($artinfo['content']));
	        $i++;
	    }
	    if(IS_POST){
	        //搜索框
	        $suo = I('post.keyword');
	        $arts = $Art->where("desc like %$suo%")->select();
	        if($arts!=null){
	            echo json_encode($arts);
	        }else{
	            echo '没有搜索到符合的内容';
	        }
	        
	    }
	    $this->assign('page',$show);
	    $this->assign('catelist',$cateList);
	    $this->assign('artlist',$artList);
	    $this->display();
	}
	
	//添加文章
	public function artadd(){
	    $Cate = D('Cate');
	    //获取分类信息
	    $catelist = $Cate->select();
	    
	    if(IS_POST){
	       $formInfo = I('post.');//表单信息
	       $Art = D('Article');
	       if(!$Art->create()){
	           $this->error($Art->getError());
	       }
	       //图片上传
	       is_dir('./Public/Uploads/') ? '' : mkdir('./Public/Uploads/');//创建文件夹
	       $upload = new \Think\Upload();// 实例化上传类
	       $upload->maxSize   =     3145728 ;// 设置附件上传大小
	       $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	       $upload->rootPath  =     './Public/Uploads/'; 
	       $upload->savePath  =     ''; // 设置附件上传目录
	       $info = $upload->upload();
	       if(!$info){
	           $this->error($upload->getError());
	       }
	       //生成上传之后的图片路径
	       $image_path = './Public/Uploads/'.$info['image']['savepath'];
	       $image_name = $info['image']['savename'];
	       $Art->image = $image_path.$image_name;
	       //缩略图
	       $thumb = new \Think\Image();
	       $thumb->open($image_path.$image_name);
	       //生成文件夹
	       is_dir($image_path.'thumb/') ? '' : mkdir($image_path.'thumb/');
	       //保存缩略图路径
	       $thumb->thumb(150, 150)->save($image_path.'thumb/'.$image_name);
	       $Art->thumb_image = $image_path.'thumb/'.$image_name;
	       $Art->new_time = time();//发布时间
	       //判断是否添加成功
	       if(!$Art->add()){
	           $errInfo = errorInfo(U('Admin/Article/artadd'),0,'发布失败');
	           $this->redirect('Admin/Error/tips',$errInfo);
	       }
	       $errInfo = errorInfo(U('Admin/Article/artlist'),1);
	       $this->redirect('Admin/Error/tips',$errInfo);
	    }
	    $this->assign('catelist',$catelist);
		$this->display();
	}
	//文章修改
	public function artedit(){
	    $id = I('get.id');
	    $Art = D('Article');
	    $Cate = D('Cate');
	    $artInfo = $Art->find($id);
	    $cateList = $Cate->select();
	    $i = 0;
	    //将过滤html标签
	    $artInfo['content'] = strip_tags(html_entity_decode($artInfo['content']));
	    //判断属于那个分类
	    foreach ($cateList as $cateinfo){
	        if($artInfo['cid']==$cateinfo['id']){
	           $cateList[$i]['select'] = 'selected';
	        }
	    }
	    
	    if(IS_POST){
	        $NewArtInfo = I('post.');//获取表单信息
	        if(!$Art->create()){
	            $this->error($Art->getError());
	        }
	        //判断图片是否更改
	        if($artInfo['image']!=$NewArtInfo['image']){
    	        //图片上传
    	        is_dir('./Public/Uploads/') ? '' : mkdir('./Public/Uploads/');//创建文件夹
    	        $upload = new \Think\Upload();// 实例化上传类
    	        $upload->maxSize   =     3145728 ;// 设置附件上传大小
    	        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    	        $upload->rootPath  =     './Public/Uploads/';
    	        $upload->savePath  =     ''; // 设置附件上传目录
    	        $info = $upload->upload();
    	        if(!$info){
    	            $this->error($upload->getError());
    	        }
    	        //生成上传之后的图片路径
    	        $image_path = './Public/Uploads/'.$info['image']['savepath'];
    	        $image_name = $info['image']['savename'];
    	        $NewArtInfo['image'] = $image_path.$image_name;
    	        //缩略图
    	        $thumb = new \Think\Image();
    	        $thumb->open($image_path.$image_name);
    	        //生成文件夹
    	        is_dir($image_path.'thumb/') ? '' : mkdir($image_path.'thumb/');
    	        //保存缩略图路径
    	        $thumb->thumb(150, 150)->save($image_path.'thumb/'.$image_name);
    	        $NewArtInfo['thumb_image'] = $image_path.'thumb/'.$image_name;
	        }
	        //判断是否修改成功
	        if($Art->where('id='.$id)->save($NewArtInfo)===false){
	            $errInfo = errorInfo(U('Admin/Article/artadd'),0,'操作失败');
	            $this->redirect('Admin/Error/tips',$errInfo);
	        }
	        $errInfo = errorInfo(U('Admin/Article/artlist'),1);
	        $this->redirect('Admin/Error/tips',$errInfo);
	        
	    }
	    
	    $this->assign('catelist',$cateList);
	    $this->assign('artinfo',$artInfo);
	    $this->display();
	}
	
	public function artDel(){
	    $id = I('get.id');
	    $Art = D('Article');
	    $Comm = D('Comment');
	    //删除评论
	    $commIds = $Comm->field('id')->where('aid='.$id)->select(); //该文章的评论id
	    //如果没有评论直接删除文章(还没实现)
	    if($commIds!=null){
	        $commList = $Comm->select();//所有的评论
	        $removeIds = $this->artComm($commIds, $commList);
	        	
	        if($Comm->delete()&&$Art->delete()){
	            echo 'success';
	        }else{
	            echo 'error';
	        }
	    }else{
    	    if($Art->where('id='.$id)->delete()){
    	        echo 'success';
    	    }else{
    	        echo 'error';
    	    }
	    }
	    
	}
	//获取文章评论
	//$commIds该文章的评论id
	//$commList所有评论信息
	public function artComm($commIds,$commList){
	    $ids = array();//文章下评论的子评论id数组
	    $cids = array();//获取文章评论id数组
	    foreach ($commIds as $commid){
	         
	        foreach($commList as $comm){
    	        if($commid['id']==$comm['pid']){
    	            $ids[] = $comm['id'];
    	        }
	        }
	        $cids[] = $commid['id'];
	    }
	    return array_merge($ids,$cids);
	}
}
