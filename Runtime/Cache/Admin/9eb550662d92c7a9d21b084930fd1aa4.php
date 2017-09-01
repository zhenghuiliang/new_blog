<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/Public/admin/css/pintuer.css">
<link rel="stylesheet" href="/Public/admin/css/admin.css">
<script src="/Public/admin/js/jquery.js"></script>
<script src="/Public/admin/js/pintuer.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/demo/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/demo/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/demo/lang/zh-cn/zh-cn.js"></script>
</head>
<style>
.filei{position:absolute;top:0;right:80px; height:40px; filter:alpha(opacity:0);opacity: 0;}
.file-box{ position:relative;width:340px}
</style>
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加内容</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('Admin/article/artedit',array('id'=>$artinfo[id]));?>" enctype="multipart/form-data">  
      <div class="form-group">
        <div class="label">
          <label>标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php echo ($artinfo[title]); ?>" name="title" data-validate="required:请输入标题" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>图片：</label>
        </div>
        <div class="field">
        <div class="file-box">
          <input type="text" id="url1" name="image" class="input tips" style="width:25%; float:left;"  value="<?php echo ($artinfo[image]); ?>"  data-toggle="hover" data-place="right" data-image="" />
          <input type="button" class="button bg-blue margin-left" id="image1" value="+ 浏览上传"  style="float:left;">
          <input type="file" name="image" class="filei" onchange="document.getElementById('url1').value=this.value"/>
          <div class="tipss">图片尺寸：500*500</div>
        </div>
        </div>
      </div>     
      
        <div class="form-group">
          <div class="label">
            <label>分类标题：</label>
          </div>
          <div class="field">
            <select name="cid" class="input w50">
              <option value="">请选择分类</option>
			  <?php if(is_array($catelist)): foreach($catelist as $key=>$cateinfo): ?><option  value="<?php echo ($cateinfo[id]); ?>" <?php echo ($cateinfo[select]); ?>><?php echo ($cateinfo[mname]); ?></option><?php endforeach; endif; ?>
            </select>
            <div class="tips"></div>
          </div>
        </div>
      <div class="form-group">
        <div class="label">
          <label>描述：</label>
        </div>
        <div class="field">
          <textarea class="input" name="desc" style=" height:90px;"><?php echo ($artinfo[desc]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>内容：</label>
        </div>
        <div class="field">
          <!--  <textarea name="content"  class="input" style="height:450px; border:1px solid #ddd;"></textarea>-->
          <script id="editor" type="text/plain" name="content" style="width:900px;height:400px;"><?php echo ($artinfo[content]); ?></script>
          <div class="tips"></div>
        </div>
      </div>
     
      <div class="clear"></div>
      <div class="form-group">
        <div class="label">
          <label>关键字：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="keyword" value="<?php echo ($artinfo[keyword]); ?>" />
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>发布人：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="admin_name" value="<?php echo ($artinfo[admin_name]); ?>"  />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>浏览次数：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="check_count" value="<?php echo ($artinfo[check_count]); ?>" data-validate="member:只能为数字"  />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
</script>
</body></html>