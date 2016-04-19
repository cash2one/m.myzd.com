<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/ajaxfileupload.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/bookingCorpAndroid.js?ts=' . time(), CClientScript::POS_END);
/*
 * $model BookQuickForm.
 */
$this->setPageID('pcreateCorpAndroid');
$this->setPageTitle('企业员工快速预约');
$urlGetSmsVerifyCode = $this->createAbsoluteUrl('/auth/sendSmsVerifyCode');
$authActionType = AuthSmsVerify::ACTION_BOOKING;
$urlSubmitForm = $this->createUrl("booking/ajaxCreateCorp");
$urlUploadFile = $this->createUrl("booking/ajaxUploadFile");
$urlUplaodCorpFile = $this->createUrl('booking/ajaxUploadCorp');
$urlUserValiCaptcha = $this->createUrl("user/valiCaptcha");
$urlReturn = $this->createUrl('home/view');
$this->show_footer = false;
?>
<header class="bg-green">
    <h1 class="title"><?php echo $this->pageTitle; ?></h1>
</header>
<article id="createCopAndroid_article" class="active" data-scroll="true">
    <div class="ml10 mr10">
        <div id="<?php echo $this->getPageID(); ?>" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>">
            <div data-role="content">
                <style>
                    .btn {display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 4px;}
                    .btn-primary {color: #fff!important;background-color: #428bca;border-color: #357ebd;}
                    .uploadfile .ui-input-text{border: 0;box-shadow: 0 0 0 #fff;}
                    .uploadfile .ui-body-inherit{border-color: #fff;}
                    .uploadfile .ui-focus{box-shadow: 0 0 0 #fff;}
                    .uploadfile{padding-top: 20px;}
                    .uploadfile:before{content: '选择文件';padding: 10px 15px;font-size: 14px;background-color: #428bca;color: #fff;border-radius: 5px;}
                    .uploadfile{position:relative;}
                    .uploadfile input[type="file"]{position:absolute;top:5px;right:35%;width:30%;line-height:36px;opacity:0;}
                    .uploadfile .btn:hover, #btn-addfiles:hover{cursor:pointer;}
                    .MultiFile-list{margin: 10px;}
                    .MultiFile-list .MultiFile-label{margin: 3px 0;}
                    .MultiFile-list .MultiFile-label .MultiFile-remove{color: #f00;font-size: 16px;padding-right: 10px;text-decoration: initial;}
                    .optional{display:none;padding-bottom: 10px;}
                    .optional input{background-color: #f6e5a0;}
                    .optional-btn{background-color: #48aeab;color: #fff;font-size: 18px;margin-top: 10px;}
                    .error {color: #E21E1A;}
                </style>
                <div class="form-wrapper">
                    <div class="ui-field-contain pt5 pb5 bb-gray">
                        <label for="BookCorpForm_corporate_name">企业名称</label>                                           
                        <select name="booking[corporate_name]" id="booking_corporate_name_show">
                            <option value>选择企业名称</option>
                            <option value="滴滴出行">滴滴出行</option>
                            <option value="阿里健康">阿里健康</option>
                            <option value="其他">其他</option>
                        </select>
                    </div>
                    <div class="mt20 pt5 pb5 bb-gray">
                        <label for="uploaderCorp">请上传一张企业工牌照片</label>
                        <div class="corp uploadfile mt10 text-center">
                            <?php
                            $this->widget('CMultiFileUpload', array(
                                //'model' => $model,
                                'attribute' => 'file',
                                'id' => "btn-addcorpfiles",
                                'name' => 'file', //$_FILES['BookingFiles'].
                                'accept' => 'jpeg|jpg|png',
                                'options' => array(),
                                'denied' => '请上传jpg、png格式',
                                'duplicate' => '该文件已被选择',
                                'max' => 1, // max 1 files
                                //'htmlOptions' => array(),
                                'value' => '上传病历',
                                'selected' => '已选文件',
                                    //'file'=>'文件'
                            ));
                            ?>
                        </div>
                    </div>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'booking-form',
                        'htmlOptions' => array("enctype" => "multipart/form-data", 'data-actionUrl' => $urlSubmitForm, 'data-url-uploadFile' => $urlUploadFile, 'data-url-return' => $urlReturn, 'data-url-uploadCorpFile' => $urlUplaodCorpFile, 'data-checkCode' => $urlUserValiCaptcha),
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
                        <?php echo $form->hiddenField($model, 'corporate_name', array('name' => 'booking[corporate_name]', 'placeholder' => '请输入企业名称')); ?>
                        <?php echo $form->error($model, 'corporate_name'); ?> 
                    </div>
                    <div class="ui-field-contain pt5 pb5 bb-gray">   
                        <?php echo CHtml::activeLabel($model, 'corp_staff_rel'); ?>  
                        <select name="booking[corp_staff_rel]" id="booking_corp_staff_rel">
                            <option value>选择与患者的关系</option>
                            <option value="本人">本人</option>
                            <option value="父母">父母</option>
                            <option value="妻子/丈夫">妻子/丈夫</option>
                            <option value="子女">子女</option>
                            <option value="其他直系亲属">其他直系亲属</option>
                        </select>
                        <?php echo $form->error($model, 'gender'); ?>
                    </div>
                    <div class="ui-field-contain pt5 pb5 bb-gray">
                        <?php echo CHtml::activeLabel($model, 'contact_name'); ?>                                           
                        <?php echo $form->textField($model, 'contact_name', array('name' => 'booking[contact_name]', 'placeholder' => '请输入患者姓名')); ?>
                        <?php echo $form->error($model, 'contact_name'); ?> 
                    </div>
                    <div class="ui-field-contain pt5 pb5 bb-gray">
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
                    <div class="ui-field-contain pt5 pb5 bb-gray">
                        <?php echo CHtml::activeLabel($model, 'mobile'); ?>                                           
                        <?php echo $form->numberField($model, 'mobile', array('name' => 'booking[mobile]', 'placeholder' => '请输入手机号')); ?>
                        <?php echo $form->error($model, 'mobile'); ?> 
                        <button id="btn-sendSmsCode" type="button" class="w100">获取验证码</button>
                    </div>
                    <div class="ui-field-contain pt5 pb5 bb-gray">
                        <?php echo CHtml::activeLabel($model, 'verify_code'); ?>                                           
                        <?php echo $form->numberField($model, 'verify_code', array('name' => 'booking[verify_code]', 'placeholder' => '请输入验证码')); ?>
                        <?php echo $form->error($model, 'verify_code'); ?> 
                    </div>
                    <div class="ui-field-contain text-center optional-btn pt5 pb5 bb-gray">
                        <div class="ui-icon-carat-d ui-btn-icon-right">填写医院信息（可选填）</div>
                    </div>
                    <div class="optional">
                        <div class="ui-field-contain pt5 pb5 bb-gray">
                            <?php echo CHtml::activeLabel($model, 'hospital_name'); ?>                                           
                            <?php echo $form->textField($model, 'hospital_name', array('name' => 'booking[hospital_name]', 'placeholder' => '请输入医院名称，可不填')); ?>
                            <?php echo $form->error($model, 'hospital_name'); ?> 
                        </div>
                        <div class="ui-field-contain pt5 pb5 bb-gray">
                            <?php echo CHtml::activeLabel($model, 'hp_dept_name'); ?>                                           
                            <?php echo $form->textField($model, 'hp_dept_name', array('name' => 'booking[hp_dept_name]', 'placeholder' => '请输入科室名称，可不填')); ?>
                            <?php echo $form->error($model, 'hp_dept_name'); ?> 
                        </div>
                        <div class="ui-field-contain pt5 pb5 bb-gray">
                            <?php echo CHtml::activeLabel($model, 'doctor_name'); ?>                                           
                            <?php echo $form->textField($model, 'doctor_name', array('name' => 'booking[doctor_name]', 'placeholder' => '请输入医生姓名，可不填')); ?>
                            <?php echo $form->error($model, 'doctor_name'); ?> 
                        </div>
                    </div>
                    <div class="ui-field-contain pt5 pb5 bb-gray">
                        <?php echo CHtml::activeLabel($model, 'disease_name'); ?>                                           
                        <?php echo $form->textField($model, 'disease_name', array('name' => 'booking[disease_name]', 'placeholder' => '请填写确诊疾病')); ?>
                        <?php echo $form->error($model, 'disease_name'); ?> 
                    </div>
                    <div class="ui-field-contain pt5 pb5 bb-gray">
                        <?php echo CHtml::activeLabel($model, 'disease_detail'); ?>                                           
                        <?php echo $form->textArea($model, 'disease_detail', array('name' => 'booking[disease_detail]', 'placeholder' => '请尽可能详细的描述患者的病情', 'maxlength' => 1000)); ?>
                        <?php echo $form->error($model, 'disease_detail'); ?> 
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                    <div class=" mt20 patient">
                        <label for="uploaderCorp">请选择病历</label>
                        <div class="uploadfile text-center mt10">
                            <?php
                            $this->widget('CMultiFileUpload', array(
                                //'model' => $model,
                                'attribute' => 'file',
                                'id' => "btn-addfiles",
                                'name' => 'file', //$_FILES['BookingFiles'].
                                'accept' => 'jpeg|jpg|png',
                                'options' => array(),
                                'denied' => '请上传jpg、png格式',
                                'duplicate' => '该文件已被选择',
                                'max' => 8, // max 8 files
                                //'htmlOptions' => array(),
                                'value' => '上传病历',
                                'selected' => '已选文件',
                                    //'file'=>'文件'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="ui-field-contain mt20 mb30">                
                        <button id="btnSubmit" class="btn btn-yes block" type="button" name="yt0" class="w100">提交</button>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</article>
<div id="jingle_toast" class="corpTip toast"><a href="#">请选择企业工牌照片</a></div>
<div id="jingle_toast" class="mobileTip toast"><a href="#">请填写手机号</a></div>
<div id="jingle_popup" style="top: 50%; left: 5%; right: 5%; border-radius: 3px; margin-top: -75px;" class="">
    <div>
        <div class="popup-title">提示</div>
        <div class="popup-content">
            <h4>提交成功！</h4>
            <div class="mt20">
                <a data-target="link" href="<?php echo $urlReturn; ?>" class="btn btn-yes btn-block">确定</a>
            </div>
        </div>
    </div>
    <div id="tag_close_popup" data-target="closePopup" class="icon cancel-circle"></div>
</div>
<div id="loading_popup" style="" class="loading">
    <i class="icon spinner"></i>
    <p>加载中...</p>
</div>
<div id="jingle_popup_mask" style="opacity: 0.3;"></div>
<script type="text/javascript">
    $(document).ready(function () {
        vailcode();
        $("#btn-sendSmsCode").click(function (e) {
            e.preventDefault();
            checkCaptchaCode($(this));
        });
        $(".confirmPage .cancel").click(function () {
            $(".confirmPage").hide();
        });
        $(".optional-btn").click(function () {
            var state = $(".optional").is(':visible');
            if (state) {
                $(".optional-btn .ui-btn-icon-right").removeClass("ui-icon-carat-u").addClass("ui-icon-carat-d");
            } else {
                $(".optional-btn .ui-btn-icon-right").removeClass("ui-icon-carat-d").addClass("ui-icon-carat-u");
            }
            $(".optional").slideToggle();
        });
        $("#booking_corporate_name_show").change(function () {
            corporate_name = $(this).val();
            if (corporate_name) {
                $("#booking_corporate_name").val(corporate_name);
                $(this).parents(".ui-field-contain").find("div.error").text("");
            } else {
                $("#booking_corporate_name").val("");
                $("#booking_corporate_name_show").parents(".ui-field-contain").nextAll("div.error").remove();
                $(this).parent().after("<div class='error'>请填写医生企业名称</div> ");
            }
        });
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
            $(".mobileTip").show();
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
                if (data.status === true) {
                    buttonTimerStart(domBtn, 60000);
                    //domForm[0].reset();
                }
                else {
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
