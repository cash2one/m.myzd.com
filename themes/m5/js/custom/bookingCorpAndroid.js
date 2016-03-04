$(function () {
    $.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请填写正确的手机号码");

    var domForm = $("#booking-form"),
            urlUploadFile = domForm.attr("data-url-uploadFile"),
            urlUploadCorpFile = domForm.attr("data-url-uploadCorpFile"),
            urlReturn = domForm.attr("data-url-return"),
            btnSubmit = $("#btnSubmit"),
            uploadSuccessCount = 0;

    
    var validator = domForm.validate({
        rules: {
            'booking[corporate_name]': {
                required: true,
                maxlength: 50
            },
            'booking[corp_staff_rel]': {
                required: true
            },
            'booking[doctor_name]': {
                //  required: true,
                maxlength: 50
            },
            'booking[hospital_name]': {
                //  required: true,
                maxlength: 50
            },
            'booking[hp_dept_name]': {
                //  required: true,
                maxlength: 50
            },
            'booking[contact_name]': {
                required: true,
                maxlength: 50
            },
            'booking[mobile]': {
                required: true,
                isMobile: true
            },
            'booking[verify_code]': {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            'booking[disease_name]': {
                required: true,
                maxlength: 50
            },
            'booking[disease_detail]': {
                required: true,
                minlength: 10,
                maxlength: 1000
            },
            'booking[remark]': {
                required: true,
                maxlength: 500
            }
        },
        messages: {
            'booking[corporate_name]': {
                required: '请填写医生企业名称',
                maxlength: '企业名称太长'
            },
            'booking[corp_staff_rel]': {
                required: '请选择与患者的关系'
            },
            'booking[doctor_name]': {
                //    required: '请填写医生姓名',
                maxlength: '姓名太长'
            },
            'booking[hospital_name]': {
                //    required: '请填写医院名称',
                maxlength: '医院名称太长'
            },
            'booking[hp_dept_name]': {
                //    required: '请填写科室名称',
                maxlength: '科室名称太长'
            },
            'booking[contact_name]': {
                required: '请填写患者姓名',
                maxlength: '患者姓名太长'
            },
            'booking[mobile]': {
                required: "请填写手机号码",
                isMobile: '请输入正确的中国手机号码'
            },
            'booking[verify_code]': {
                required: '请输入验证码',
                digits: '验证码不正确',
                maxlength: '验证码不正确',
                minlength: '验证码不正确'
            },
            'booking[disease_name]': {
                required: '请填写疾病诊断',
                maxlength: '请将字数控制在50以内'
            },
            'booking[disease_detail]': {
                required: '请填写病情',
                minlength: '请至少填写10个字',
                maxlength: '请将字数控制在1000以内'
            }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {                             //错误信息位置设置方法  
            element.parents(".ui-field-contain").find("div.error").remove();
            error.appendTo(element.parents(".ui-field-contain")); //这里的element是录入数据的对象  
        },
        submitHandler: function () {
            disabledBtnAndriod(btnSubmit);
            //form插件的异步无刷新提交
            actionUrl = domForm.attr('data-actionurl');
            //returnUrl = domForm.attr("data-url-return");
            domForm.ajaxSubmit({
                type: 'post',
                url: actionUrl,
                success: function (data) {
                    if (data.status == 'ok') {
                        var patientInputCount = $(".patient .MultiFile-applied").length - 1;
                        ajaxCorpFileupload(data);
                        if (patientInputCount != 0) {
                            ajaxFileupload(data);
                        }
                    } else {
                        domForm.find("div.error").remove();
                        $(".form-wrapper").find("div.error").remove();
                        //append errorMsg
                        isfocus = true;
                        for (error in data.errors) {
                            inputKey = '#booking_' + error;
                            if (error == 'corporate_name') {
                                inputKey = '#booking_' + error + "_show";
                            }
                            errerMsg = data.errors[error];
                            $(inputKey).focus();
                            $(inputKey).after("<div class='error'>" + errerMsg + "</div> ");
                        }
                        enableBtnAndriod(btnSubmit);
                    }
                },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    enableBtnAndriod(btnSubmit);
                    console.log(XmlHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);
                },
                complete: function () {
                    //    btnSubmit.button("enable");
                }
            });
        }
    });
    btnSubmit.click(function () {
        var patientInputCount = $(".patient .MultiFile-applied").length - 1;
        var corpInputCount = $(".corp .MultiFile-applied").length - 1;
        var corporate_name = domForm.find("#booking_corporate_name").val();
        if (corpInputCount == 0) {
            $(".corpTip").show();
            setTimeout(function () {
                $(".corpTip").hide();
            }, 1000);
        } else if (!corporate_name) {
            $("#booking_corporate_name_show").parents("li").find("div.error").remove();
            $("#booking_corporate_name_show").after("<div class='error'>请填写医生企业名称</div> ");
            $("#booking_corporate_name_show").focus();
            validator.form();
        } else {
            domForm.submit();
        }
    });
    //异步上传病历
    function ajaxFileupload(data) {
        disabledBtnAndriod(btnSubmit);
        $(".MultiFile-applied").attr("name", 'file');
        var successCount = 0, inputCount = 0, backCount = 0;
        inputCount = $(".patient .MultiFile-applied").length - 1;
        corpinputCount = $(".corp .MultiFile-applied").length - 1;
        var fileParam = {"booking[id]": data.booking.id, 'plugin': 'ajaxFileUpload'};
        $(".patient .MultiFile-applied").each(function () {
            if ($(this).val()) {
                var fileId = $(this).attr("id");
                $.ajaxFileUpload({
                    url: urlUploadFile,
                    secureuri: false, //是否安全提交
                    data: fileParam, //提交时带上的参数
                    fileElementId: fileId, //input file 的id
                    type: 'post',
                    dataType: 'json',
                    success: function (fdata, status) {
                        if (fdata.status == 'ok') {
                            successCount++;
                        }
                    },
                    error: function (fdata, status, e) {
                        //错误处理
                        console.log(fdata);
                        enableBtnAndriod(btnSubmit);
                        alert('文件过大,病历上传失败');
                    },
                    complete: function () {
                        backCount++;
                        if (inputCount == backCount) {
                            if (successCount == inputCount) {
                                //alert("恭喜 上传成功!");
                                uploadSuccessCount++;
                                if (uploadSuccessCount == 2) {
                                    $('#jingle_popup').show();
                                    $('#jingle_popup_mask').show();
                                    //location.href = urlReturn;
                                    enableBtnAndriod(btnSubmit);
                                } else if (inputCount == 0 && uploadSuccessCount == 1) {
                                    $('#jingle_popup').show();
                                    $('#jingle_popup_mask').show();
                                    //location.href = urlReturn;
                                    enableBtnAndriod(btnSubmit);
                                }
                                //enableBtn(btnSubmit);
                            } else {
                                //$失败操作
                            }
                        }
                    }
                });
            }
        });
    }
    //异步上传企业证件
    function ajaxCorpFileupload(data) {
        disabledBtnAndriod(btnSubmit);
        $(".MultiFile-applied").attr("name", 'file');
        var successCount = 0, inputCount = 0, backCount = 0;
        mrinputCount = $(".patient .MultiFile-applied").length - 1;
        inputCount = $(".corp .MultiFile-applied").length - 1;
        var fileParam = {"booking[id]": data.booking.id, 'plugin': 'ajaxFileUpload'};
        $(".corp .MultiFile-applied").each(function () {
            if ($(this).val()) {
                var fileId = $(this).attr("id");
                $.ajaxFileUpload({
                    url: urlUploadCorpFile,
                    secureuri: false, //是否安全提交
                    data: fileParam, //提交时带上的参数
                    fileElementId: fileId, //input file 的id
                    type: 'post',
                    dataType: 'json',
                    success: function (fdata, status) {
                        if (fdata.status == 'ok') {
                            successCount++;
                        }
                    },
                    error: function (fdata, status, e) {
                        //错误处理
                        enableBtnAndriod(btnSubmit);
                        alert('文件过大,企业工牌照片上传失败');
                    },
                    complete: function () {
                        backCount++;
                        if (inputCount == backCount) {
                            if (successCount == inputCount) {
                                //alert("恭喜 上传成功!");
                                uploadSuccessCount++;
                                if (uploadSuccessCount == 2) {
                                    $('#jingle_popup').show();
                                    $('#jingle_popup_mask').show();
                                    //location.href = urlReturn;
                                    enableBtnAndriod(btnSubmit);
                                } else if (mrinputCount == 0 && uploadSuccessCount == 1) {
                                    $('#jingle_popup').show();
                                    $('#jingle_popup_mask').show();
                                    //location.href = urlReturn;
                                    enableBtnAndriod(btnSubmit);
                                }
                                
                            } else {
                                //$失败操作
                            }
                        }
                    }
                });
            }
        });
    }
});