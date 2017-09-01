<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if(!session('?name')){
            $this->redirect('Admin/admin/login');
        }
        $this->display();
    }
}
