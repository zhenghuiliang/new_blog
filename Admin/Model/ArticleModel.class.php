<?php
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model{
    //array(验证字段1，验证规则，错误提示，[验证条件，附加规则，验证时间]),
    public $_validate = array(
        array('title','','输入的标题不能为空','1','notequal','3'),
        array('image','','上传的文件不能为空','1','notequal','3'),
        array('cid','','您会没有选择文章分类','1','notequal',3),
        array('desc','','描述不能为空','1','notequal',3),
        array('keyword','','关键字不能为空','1','notequal',3),
        array('admin_name','','发布人不能为空','1','notequal',3),
        array('content','','内容不能为空','1','notequal',3),
        array('check_count',"/\d+/",'点击量必须是一个数字','1','regex',3)
    );
}