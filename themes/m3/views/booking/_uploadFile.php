<?php
Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/webuploader/css/webuploader.custom.css');
//Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/bootstrap.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
?>
<style>
    .ui-field-contain a.ui-link{position: absolute;margin: 20px 0 0 141px;z-index: 99;font-size: 16px;}
    #tipPage-popup.ui-popup-container{max-width: 375px;width: 100%;bottom:16em!important;top:auto!important;}
    .ui-popup-container{max-width: 375px;width: 100%;bottom:16em!important;top:auto!important;position: fixed;}
</style>
<div id="uploader" class="uploader">
    <div class="queueList">
        <div id="dndArea" class="placeholder">
            <!-- btn 选择图片 -->
            <div id="filePicker"></div>
        <!-- <p>或将照片拖到这里，单次最多可选10张</p>-->
        </div>
        <ul class="filelist"></ul>
    </div>
    <div class="statusBar clearfix" style="display:none;">
        <div class="progress" style="display: none;">
            <span class="text">0%</span>
            <span class="percentage" style="width: 0%;"></span>
        </div>
        <div class="info">共0张（0B），已上传0张</div>
        <div class="">
            <!-- btn 继续添加 -->
            <div id="filePicker2" class="pull-right"></div>                          

        </div>
    </div>
    <!--一开始就显示提交按钮就注释上面的提交 取消下面的注释 -->
    <!-- <div class="statusBar uploadBtn">提交</div>-->
</div>
<div>

                </div>
<a id="toTip" class="hide" href="#tipPage" data-rel="popup">提示页</a>
<div data-role="popup" id="tipPage" class="" data-title="错误提示">
    <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
    <div data-role="header">
        <h1>错误提示</h1>
    </div>

    <div data-role="content" class="tipcontent">
        <p>文件添加失败</p>
        <a class="mt20" href="javascript:;" data-role="button" data-rel="back" >确 定</a> 
    </div>
</div> 