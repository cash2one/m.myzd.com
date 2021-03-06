<?php

//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/quickBooking.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://static.mingyizhudao.com/m/jquery.formvalidate.min.1.0.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://static.mingyizhudao.com/m/quickBooking.min.1.0.js', CClientScript::POS_END);
/*
 * $model BookQuickForm.
 */
$this->setPageTitle('手术直通车快速预约_名医主刀网移动版');
$this->setPageKeywords('手术直通车快速预约');
$this->setPageDescription('名医主刀手术直通车让您快速预约专家医师，切实解决看病难的问题，让患者得到最快的治疗。');
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$authActionType = AuthSmsVerify::ACTION_BOOKING;
$urlSubmitForm = $this->createUrl("booking/ajaxQuickbook");
//$urlUploadFile = $this->createUrl("booking/ajaxUploadFile");
$urlUploadFile = 'http://file.mingyizhudao.com/api/uploadbookingfile';
$urlUserValiCaptcha = $this->createUrl("user/valiCaptcha");
$urlReturn = $this->createUrl('order/view');
$urlHomeView = Yii::app()->request->hostInfo;
$urlBackBtn = Yii::app()->request->getQuery('backBtn', '1');
$urlAgreement = $this->createUrl('user/index', array('page' => 'aboutAgreement'));
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
$user = $this->getCurrentUser();
//modify by wanglei 
$urlStat = $this->createAbsoluteUrl('/api/stat');
//成功到达预约单页面
$SITE_8 = PatientStatLog::SITE_8;
$SITE_9 = PatientStatLog::SITE_9;
?>

<style>
    .btn {display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 4px;}
</style>
<header class="bg-green">
    <?php if ($urlBackBtn == 1) {
        ?>
        <nav class="left">
            <a href="" data-target="back">
                <div class="pl5">
                    <img src="http://static.mingyizhudao.com/146975795218858" class="w11p">
                </div>
            </a>
        </nav>
    <?php }
    ?>
    <h1 class="title">快速预约</h1>
    <nav class="right">
        <a onclick="javascript:location.reload()">
            <img src="http://static.mingyizhudao.com/146975853464574"  class="w24p">
        </a>
    </nav>
</header>
<footer class="agreement_footer">
    <div class="w100">
        <div class="text-center pt5">
            <label for="agreement">
                <input id="agreement" type="checkbox" class="h14p">
                <span class="pl5">我已同意</span>
            </label>
            <a href="<?php echo $urlAgreement; ?>" class="color-green">名医主刀服务协议</a>
        </div>
        <button id="btnSubmit" type="button" class="button buttonSubmit font-s16" disabled="true" >预约</button>
    </div>
</footer>
<article id="quickBookIos_article" class="active" data-scroll="true">
    <div class="ml10 mr10 mt10">
        <div id="<?php echo $this->getPageID(); ?>" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>">
            <div data-role="content">
                <div class="form-wrapper">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'booking-form',
                        'htmlOptions' => array("enctype" => "multipart/form-data", 'data-actionUrl' => $urlSubmitForm, 'data-url-uploadFile' => $urlUploadFile, 'data-url-return' => $urlReturn, 'data-checkCode' => $urlUserValiCaptcha),
                        'enableClientValidation' => false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'validateOnType' => true,
                            'validateOnDelay' => 500,
                            'errorCssClass' => 'error',
                        ),
                        'enableAjaxValidation' => false,
                    ));

                    echo CHtml::hiddenField("smsverify[actionUrl]", $urlGetSmsVerifyCode);
                    echo CHtml::hiddenField("smsverify[actionType]", $authActionType);
                    echo $form->hiddenField($model, 'bk_type', array('name' => 'booking[bk_type]'));
                    echo $form->hiddenField($model, 'bk_status', array('name' => 'booking[bk_status]'));
                    ?>            
                    <div class="ui-field-contain">
                        <?php echo CHtml::activeLabel($model, 'hospital_name'); ?>                                           
                        <?php echo $form->textField($model, 'hospital_name', array('name' => 'booking[hospital_name]', 'placeholder' => '请输入医院名称，可不填')); ?>
                        <?php echo $form->error($model, 'hospital_name'); ?> 
                    </div>
                    <div class="ui-field-contain">
                        <?php echo CHtml::activeLabel($model, 'hp_dept_name'); ?>                                           
                        <?php echo $form->textField($model, 'hp_dept_name', array('name' => 'booking[hp_dept_name]', 'placeholder' => '请输入科室名称，可不填')); ?>
                        <?php echo $form->error($model, 'hp_dept_name'); ?> 
                    </div>
                    <div class="ui-field-contain">
                        <?php echo CHtml::activeLabel($model, 'doctor_name'); ?>                                           
                        <?php echo $form->textField($model, 'doctor_name', array('name' => 'booking[doctor_name]', 'placeholder' => '请输入医生姓名，可不填')); ?>
                        <?php echo $form->error($model, 'doctor_name'); ?> 
                    </div>
                    <div class="ui-field-contain">
                        <?php echo CHtml::activeLabel($model, 'contact_name'); ?>                                           
                        <?php echo $form->textField($model, 'contact_name', array('name' => 'booking[contact_name]', 'placeholder' => '请输入患者姓名')); ?>
                        <?php echo $form->error($model, 'contact_name'); ?> 
                    </div>
                    <div id="checkUser" class="hide" value="<?php echo isset($user); ?>"></div>
                    <?php if (!isset($user)) { ?>
                        <div class="ui-field-contain">
                            <?php echo CHtml::activeLabel($model, 'mobile'); ?>                                           
                            <?php echo $form->numberField($model, 'mobile', array('name' => 'booking[mobile]', 'placeholder' => '请输入手机号')); ?>
                            <div class="color-red font-s12">*若您尚未注册，此号码将作为您后期的登录账号</div>
                            <?php echo $form->error($model, 'mobile'); ?>
                        </div>
                        <div class="ui-field-contain mt5">
                            <div id="captchaCode" class="grid">
                                <div class="col-1 w50">
                                    <div>请输入图形验证码</div>
                                    <input type="text" id="booking_captcha_code" name="booking[captcha_code]" placeholder="请输入图形验证码">
                                </div>
                                <div class="col-1 w50 pt20">
                                    <!--<button id="btn-sendSmsCode" type="button" class="w100 bg-green border-r3">获取验证码</button>-->
                                    <a href="javascript:void(0);"><img id="vailcode" class="h40p" src="" onclick="this.src = '<?php echo $this->createUrl('user/getCaptcha'); ?>/' + Math.random()"></a>
                                </div>
                            </div>
                        </div>
                        <div class="ui-field-contain mt5">
                            <div class="grid">
                                <div class="col-1 w50">
                                    <?php echo CHtml::activeLabel($model, 'verify_code'); ?>                                           
                                    <?php echo $form->numberField($model, 'verify_code', array('name' => 'booking[verify_code]', 'placeholder' => '请输入验证码')); ?>
                                    <?php echo $form->error($model, 'verify_code'); ?>
                                </div>
                                <div class="col-1 w50 pt20">
                                    <button id="btn-sendSmsCode" type="button" class="w100 bg-green border-r3">获取验证码</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="ui-field-contain">
                        <?php echo CHtml::activeLabel($model, 'disease_name'); ?>                                           
                        <?php echo $form->textField($model, 'disease_name', array('name' => 'booking[disease_name]', 'placeholder' => '请填写确诊疾病')); ?>
                        <?php echo $form->error($model, 'disease_name'); ?> 
                    </div>

                    <div class="ui-field-contain">
                        <?php echo CHtml::activeLabel($model, 'disease_detail'); ?>                                           
                        <?php echo $form->textArea($model, 'disease_detail', array('name' => 'booking[disease_detail]', 'placeholder' => '请尽可能详细的描述患者的病情', 'maxlength' => 1000)); ?>
                        <?php echo $form->error($model, 'disease_detail'); ?> 
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                    <div>
                        上传病例或影像资料
                    </div>
                    <div class="ui-field-contain pb30">
                        <?php echo $this->renderPartial('//booking/_uploadFile'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
<div id="jingle_toast" class="mobileTip toast"><a href="#">请填写手机号</a></div>
<script type="text/javascript">
     function bookStat(keyword){
              $.ajax({
                type: 'post',
                url: '<?php echo $urlStat; ?>',
                data: {'stat[site]': '<?php echo $SITE_8; ?>', 'stat[key_word]':keyword},
                success: function (data) {

                }
            });
    }

    
    $(document).ready(function () {
        $('input[type="checkbox"]').click(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('#btnSubmit').attr('disabled', 'true');
            } else {
                $(this).addClass('active');
                $('#btnSubmit').removeAttr('disabled');
            }
        });
        
        vailcode();
        $("#btn-sendSmsCode").click(function (e) {
            e.preventDefault();
            checkCaptchaCode($(this));
        });
  
        bookStat('快速预约页面');
    });

    function vailcode() {
        $("#vailcode").attr("src", "<?php echo $this->createUrl('user/getCaptcha'); ?>/" + Math.random());
    }

    function checkCaptchaCode(domBtn) {
        var domMobile = $("#booking_mobile");
        var mobile = domMobile.val();
        var captchaCode = $('#booking_captcha_code').val();
        if (mobile.length === 0) {
            //$("#booking_mobile_em_").text("请输入手机号码").show();
            //domMobile.parent().addClass("error");
            //showErrorPopup('请输入手机号码', '#popupError', '#triggerPopupError');
            $('.mobileTip').show();
            setTimeout(function () {
                $(".mobileTip").hide();
            }, 1000);
        } else if (domMobile.hasClass("error")) {

            // mobile input field as error, so do nothing.
        } else if (captchaCode == '') {
            $('#booking_captcha_code-error').remove();
            $('#captchaCode').after('<div id="booking_captcha_code-error" class="error">请填写图形验证码</div>');
        } else {
            $('#booking_captcha_code-error').remove();
            var domForm = $('#booking-form');
            var formdata = domForm.serializeArray();
            //check图形验证码
            $.ajax({
                type: 'post',
                url: '<?php echo $urlUserValiCaptcha; ?>?co_code=' + captchaCode,
                data: formdata,
                success: function (data) {
                    //console.log(data);
                    if (data.status == 'ok') {
                        sendSmsVerifyCode(domBtn, mobile, captchaCode);
                    } else {
                        $('#captchaCode').after('<div id="booking_captcha_code-error" class="error">' + data.error + '</div>');
                    }
                }
            });
        }
    }

    function sendSmsVerifyCode(domBtn, mobile, captchaCode) {
        $domForm = $("#booking-form");
        var actionUrl = $domForm.find("input[name='smsverify[actionUrl]']").val();
        var actionType = $domForm.find("input[name='smsverify[actionType]']").val();
        var formData = new FormData();
        formData.append("AuthSmsVerify[mobile]", mobile);
        formData.append("AuthSmsVerify[actionType]", actionType);

        $.ajax({
            type: 'post',
            url: actionUrl + '?captcha_code=' + captchaCode,
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            'success': function (data) {
                //console.log(data);
                if (data.status === true) {
                    buttonTimerStart(domBtn, 60000);
                } else {
                    console.log(data);
                    if (data.errors.captcha_code != undefined) {
                        $('#captchaCode').after('<div id="booking_captcha_code-error" class="error">' + data.errors.captcha_code + '</div>');
                    }
                }
            },
            'error': function (data) {
                console.log(data);
            },
            'complete': function () {
            }
        });

    }
</script>
