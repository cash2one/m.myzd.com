<?php
Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
Yii::app()->clientScript->registerCssFile('http://static.mingyizhudao.com/vendor/webuploader.custom.1.0.css');
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://static.mingyizhudao.com/vendor/uploadMRFile.min.1.0.js', CClientScript::POS_END);
?>
<?php
/**
 * $data.
 */
$this->setPageTitle('预约详情');

$urlApiAppNav1 = $this->createAbsoluteUrl('/api/list', array('model' => 'appnav1'));

$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$results = $data->results;
$urlSubmitForm = $this->createUrl("booking/ajaxCreate");
$urlUploadFile = 'http://file.mingyizhudao.com/api/uploadbookingfile';
$urlReturn = $this->createUrl('booking/patientBookingList', array('status' => 0));
$userId = Yii::app()->session['userId'];
//$urlBookingFiles = 'http://file.mingyizhudao.com/api/loadbookingmr?userId=' . $user->id . '&bookingId=' . $results->id;
$urlBookingFiles = 'http://file.mingyizhudao.com/api/loadbookingmr?userId=' . $userId . '&bookingId=' . $results->id;
$this->show_footer = false;
?>
<header class="bg-green" >
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="http://static.mingyizhudao.com/146975795218858" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title"><?php echo $this->pageTitle; ?></h1>
    <nav class="right">
        <a onclick="javascript:history.go(0)">
            <img src="http://static.mingyizhudao.com/146975853464574"  class="w24p">
        </a>
    </nav>
</header>
<article id="expert_list_article" class="active"  data-scroll="true">
    <ul class="list">
        <li class="color-green">预约号:<?php echo $results->refNo; ?></li>
        <li>
            <div class="grid">
                <div class="col-0 w100p">患者姓名:</div>
                <div class="col-1 w-div"><?php echo $results->patientName; ?></div>
            </div>
        </li>
        <li>
            <div class="grid">
                <div class="col-0 w100p">联系方式:</div>
                <div class="col-1 w-div"><?php echo $results->mobile; ?></div>
            </div>
        </li>
        <li>
            <div class="grid">
                <div class="col-0 w100p">就诊医院:</div>
                <div class="col-1 w-div"><?php echo $results->hospitalName == '' ? '未填写' : $results->hospitalName; ?></div>
            </div>
        </li>
        <li class="nopadding h15p"></li>
        <li>
            <div class="grid">
                <div class="col-0 w100p">就诊科室:</div>
                <div class="col-1 w-div"><?php echo $results->hpDeptName == '' ? '未填写' : $results->hpDeptName; ?></div>
            </div>
        </li>
        <li>
            <div class="grid">
                <div class="col-0 w100p">就诊专家:</div>
                <div class="col-1 w-div"><?php echo $results->expertName == '' ? '未填写' : $results->expertName; ?></div>
            </div>
        </li>
        <li class="nopadding h15p"></li>
        <li>
            <div class="grid">
                <div class="col-0 w100p">病例名称:</div>
                <div class="col-1 w-div"><?php echo $results->diseaseName; ?></div>
            </div>
        </li>
        <li class="bb-none mb10">
            <div class="grid">
                <div class="col-0 w100p">病例描述:</div>
                <div class="col-1 w-div"><?php echo $results->diseaseDetail; ?></div>
            </div>
            <div class="grid mt15">
                <div class="col-0 w100p">影像资料:</div>
                <div class="col-1">
                </div>
            </div>
            <div id="imglist" class="mt10">

            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'booking-form',
                'htmlOptions' => array("enctype" => "multipart/form-data", 'data-actionUrl' => $urlSubmitForm, 'data-url-uploadFile' => $urlUploadFile, 'data-url-return' => $urlReturn),
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnType' => true,
                    'validateOnDelay' => 500,
                    'errorCssClass' => 'error',
                ),
                'enableAjaxValidation' => false,
            ));
            ?>
            <input id="booking_id" type="hidden" name="booking[booking_id]" value="<?php echo $results->id; ?>" />
            <div class="mt30">
                <!--图片上传区域 -->
                <div id="uploader" class="uploader wu-example">
                    <div class="imglist">
                        <ul class="filelist"></ul>
                    </div>
                    <div class="queueList nomargin">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker"></div>
                            <!-- <p>或将照片拖到这里，单次最多可选10张</p>-->
                        </div>
                    </div>
                    <div class="statusBar" style="display:none; padding-bottom: 40px;">
                        <div class="progress">
                            <span class="text">0%</span>
                            <span class="percentage"></span>
                        </div>
                        <div class="info display-block"></div>
                        <div class="display-block pull-right">
                            <!-- btn 继续添加 -->
                            <div id="filePicker2" class=""></div>
                        </div>
                        <div class="ui-field-contain display-block mt50 clearfix">
                            <button id="btnSubmit" type="button" name="yt0" class="button yy-btn block mt10 btn-yes uploadBtn state-pedding font-s16">提交</button>
                        </div>
                    </div>
                    <!--一开始就显示提交按钮就注释上面的提交 取消下面的注释 -->
                    <!--                         <div class="statusBar uploadBtn">提交</div>-->
                </div>
            </div>
            <?php
            $this->endWidget();
            ?>
        </li>
    </ul>
</article>
<script>
    $(document).ready(function () {
        //加载病人病历图片
        var urlBookingFiles = "<?php echo $urlBookingFiles; ?>";
        $.ajax({
            url: urlBookingFiles,
            success: function (data) {
                setImgHtml(data.results.files);
            }
        });
    });

    function setImgHtml(imgfiles) {
        var innerHtml = '';
        if (imgfiles && imgfiles.length > 0) {
            var n = Math.ceil((imgfiles.length) / 3);
            for (var i = 0; i < n; i++) {
                innerHtml += '<div class="grid">';
                for (var j = 0; j < 3; j++) {
                    var num = i * 3 + j;
                    if (num < (imgfiles.length)) {
                        innerHtml += '<div class="col-0 w33 text-center mt5">' +
                                '<img class="btn-img" src="' + imgfiles[num].absFileUrl + '" data-img="' + imgfiles[num].thumbnailUrl + '">' +
                                '</div>';
                    }
                }
                innerHtml += '</div>';
            }
        } else {
            innerHtml += '';
        }
        $("#imglist").html(innerHtml);
        $('.btn-img').click(function () {
            var imgUrl = $(this).attr("data-img");
            J.popup({
                html: '<div class="imgpopup"><img src="' + imgUrl + '"></div>',
                pos: 'top-second',
                showCloseBtn: true
            });
        });
    }
</script>