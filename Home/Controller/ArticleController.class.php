<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller{
    //显示文章
    public function Artlist(){
        $id = I('id');
        $Art = D('Article');
        $artInfo = $Art->find($id);
        //记录浏览次数
        $Art->check_count = $Art->check_count + 1;
        $Art->where('id='.$id)->save();
        
        $this->assign('artinfo',$artInfo);
        $this->display();
    }
    
}