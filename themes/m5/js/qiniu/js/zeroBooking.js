/*global Qiniu */
/*global plupload */
/*global FileProgress */
/*global hljs */
$(function () {
    var num = 0;
    var btnSubmit = $('#btnSubmit'),
            returnResult = true,
            num = 0,
            fileData = '';
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles',
        container: 'container',
        drop_element: 'container',
        max_file_size: '1000mb',
        flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: $('#uptoken_url').val(),
        domain: $('#domain').val(),
        get_new_uptoken: false,
        // downtoken_url: '/downtoken',
        // unique_names: true,
        // save_key: true,
        // x_vars: {
        //     'id': '1234',
        //     'time': function(up, file) {
        //         var time = (new Date()).getTime();
        //         // do something with 'time'
        //         return time;
        //     },
        // },
        auto_start: true,
        log_level: 5,
        init: {
            'FilesAdded': function (up, files) {
                btnSubmit.attr("disabled", true);
                $('#loading_popup_mask').show();
                $('#loading_popup').show();
                for (var i = 0; i < files.length; i++) {
                    var uploadFile = true;
                    if (($('.progressContainer').length) >= 9) {
                        $('#jingle_toast').find('a').text('影像资料不能超过9张');
                        $('#jingle_toast').show();
                        setTimeout(function () {
                            $('#jingle_toast').hide();
                        }, 1000);
                        uploadFile = false;
                    }
                    $('.progressName').each(function () {
                        if (($(this).html() == files[i].name) && ($(this).next('.progressFileSize').html() == plupload.formatSize(files[i].size).toUpperCase())) {
                            $('#jingle_toast').find('a').text('该文件已被选择');
                            $('#jingle_toast').show();
                            setTimeout(function () {
                                $('#jingle_toast').hide();
                            }, 1000);
                            uploadFile = false;
                        }
                    });
                    if (uploadFile) {
                        $('table').show();
                        $('#success').hide();
                        plupload.each(files, function (file) {
                            var progress = new FileProgress(file, 'fsUploadProgress');
                            progress.setStatus("等待...");
                            progress.bindUploadCancel(up);
                        });
                    }
                }
                if ($('article').hasClass('logoBackground')) {
                    $('article').removeClass('logoBackground');
                    var articleHeight = $('article').height();
                    var height = $('#outline').height();
                    if (articleHeight - height - 98 > 0) {
                        $('article').addClass('logoBackground');
                    } else {
                        $('#logoImg').removeClass('hide');
                    }
                }
            },
            'BeforeUpload': function (up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            'UploadProgress': function (up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", file.speed, chunk_size);
            },
            'UploadComplete': function () {
                btnSubmit.removeAttr("disabled");
                $('#loading_popup_mask').hide();
                $('#loading_popup').hide();
            },
            'FileUploaded': function (up, file, info) {
                //单个文件上传成功所做的事情 
                // 其中 info 是文件上传成功后，服务端返回的json，形式如
                // {
                //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //    "key": "gogopher.jpg"
                //  }
                // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                // var domain = up.getOption('domain');
                // var res = parseJSON(info);
                // var sourceLink = domain + res.key; 获取上传成功后的文件的Url
                var progress = new FileProgress(file, 'fsUploadProgress');
                var formdata = new FormData();
                var infoJson = eval('(' + info + ')');
                progress.setComplete(up, info);
                var fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);
                num++;
                var formdata = new FormData();
                formdata.append('questionnaireFile[questionnaireNumber]', 4);
                formdata.append('questionnaireFile[file_num]', num);
                formdata.append('questionnaireFile[file_name]', file.name);
                formdata.append('questionnaireFile[file_url]', file.name);
                formdata.append('questionnaireFile[file_size]', file.size);
                formdata.append('questionnaireFile[mime_type]', file.type);
                formdata.append('questionnaireFile[file_ext]', fileExtension);
                formdata.append('questionnaireFile[remote_domain]', $('#domain').val());
                formdata.append('questionnaireFile[remote_file_key]', infoJson.key);
                $.ajax({
                    type: 'post',
                    url: $('#fileAction').attr('data-action'),
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.status == 'no' && data.errorMsg == 'faile answer') {
                            $('#loading_popup_mask').hide();
                            $('#loading_popup').hide();
                            location.href = $('article').attr('data-return-url') + '/1';
                        } else if (data.status == 'ok') {
                            btnSubmit.removeAttr("disabled");
                            $('#loading_popup_mask').hide();
                            $('#loading_popup').hide();
                        }
                    },
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        btnSubmit.removeAttr("disabled");
                        $('#loading_popup_mask').hide();
                        $('#loading_popup').hide();
                        console.log(XmlHttpRequest);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            },
            'Error': function (up, err, errTip) {
                returnResult = false;
                console.log('错误信息' + errTip);
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgress');
                progress.setError();
                progress.setStatus(errTip);
            }
            ,
            'Key': function (up, file) {
                var fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);
                var key = (new Date()).getTime() + '' + Math.floor(Math.random() * 100) + '.' + fileExtension;
                // do something with key
                return key;
            }
        }
    });

    $('#skip').click(function () {
        J.showMask();
        skip('');
    });

    function skip(type) {
        var answer = '';
        if (type == 'picture' && num > 0) {
            answer = 'picture';
        }
        $.ajax({
            type: 'post',
            url: $('article').attr('data-action-url'),
            data: {"questionnaire[questionnaireNumber]": 4, "questionnaire[answer]": answer},
            success: function (data) {
                if (data.status == 'ok') {
                    $('#loading_popup_mask').hide();
                    $('#loading_popup').hide();
                    location.href = $('article').attr('data-return-url') + '/5';
                } else {
                    if (data.errorMsg == 'faile answer') {
                        $('#loading_popup_mask').hide();
                        $('#loading_popup').hide();
                        location.href = $('article').attr('data-return-url') + '/1';
                    }
                }
            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                $('#loading_popup_mask').hide();
                $('#loading_popup').hide();
                console.log(XmlHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    uploader.bind('FileUploaded', function () {
        //console.log('hello man,a file is uploaded');
    });

    btnSubmit.click(function () {
        if (num == 0) {
            $('#jingle_toast').find('a').text('请先上传病历资料');
            $('#jingle_toast').show();
            setTimeout(function () {
                $('#jingle_toast').hide();
            }, 1000);
            return;
        }
        disabledBtn(btnSubmit);
        skip('picture');
    });

    $('#container').on(
            'dragenter',
            function (e) {
                e.preventDefault();
                $('#container').addClass('draging');
                e.stopPropagation();
            }
    ).on('drop', function (e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragleave', function (e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragover', function (e) {
        e.preventDefault();
        $('#container').addClass('draging');
        e.stopPropagation();
    });

    $('#show_code').on('click', function () {
        $('#myModal-code').modal();
        $('pre code').each(function (i, e) {
            hljs.highlightBlock(e);
        });
    });

    $('body').on('click', 'table button.btn', function () {
        $(this).parents('tr').next().toggle();
    });

    $('#up_load').on('click', function () {
        uploader.start();
    });

    var getRotate = function (url) {
        if (!url) {
            return 0;
        }
        var arr = url.split('/');
        for (var i = 0, len = arr.length; i < len; i++) {
            if (arr[i] === 'rotate') {
                return parseInt(arr[i + 1], 10);
            }
        }
        return 0;
    };

    $('#myModal-img .modal-body-footer').find('a').on('click', function () {
        var img = $('#myModal-img').find('.modal-body img');
        var key = img.data('key');
        var oldUrl = img.attr('src');
        var originHeight = parseInt(img.data('h'), 10);
        var fopArr = [];
        var rotate = getRotate(oldUrl);
        if (!$(this).hasClass('no-disable-click')) {
            $(this).addClass('disabled').siblings().removeClass('disabled');
            if ($(this).data('imagemogr') !== 'no-rotate') {
                fopArr.push({
                    'fop': 'imageMogr2',
                    'auto-orient': true,
                    'strip': true,
                    'rotate': rotate,
                    'format': 'png'
                });
            }
        } else {
            $(this).siblings().removeClass('disabled');
            var imageMogr = $(this).data('imagemogr');
            if (imageMogr === 'left') {
                rotate = rotate - 90 < 0 ? rotate + 270 : rotate - 90;
            } else if (imageMogr === 'right') {
                rotate = rotate + 90 > 360 ? rotate - 270 : rotate + 90;
            }
            fopArr.push({
                'fop': 'imageMogr2',
                'auto-orient': true,
                'strip': true,
                'rotate': rotate,
                'format': 'png'
            });
        }

        $('#myModal-img .modal-body-footer').find('a.disabled').each(function () {

            var watermark = $(this).data('watermark');
            var imageView = $(this).data('imageview');
            var imageMogr = $(this).data('imagemogr');

            if (watermark) {
                fopArr.push({
                    fop: 'watermark',
                    mode: 1,
                    image: 'http://www.b1.qiniudn.com/images/logo-2.png',
                    dissolve: 100,
                    gravity: watermark,
                    dx: 100,
                    dy: 100
                });
            }

            if (imageView) {
                var height;
                switch (imageView) {
                    case 'large':
                        height = originHeight;
                        break;
                    case 'middle':
                        height = originHeight * 0.5;
                        break;
                    case 'small':
                        height = originHeight * 0.1;
                        break;
                    default:
                        height = originHeight;
                        break;
                }
                fopArr.push({
                    fop: 'imageView2',
                    mode: 3,
                    h: parseInt(height, 10),
                    q: 100,
                    format: 'png'
                });
            }

            if (imageMogr === 'no-rotate') {
                fopArr.push({
                    'fop': 'imageMogr2',
                    'auto-orient': true,
                    'strip': true,
                    'rotate': 0,
                    'format': 'png'
                });
            }
        });

        var newUrl = Qiniu.pipeline(fopArr, key);

        var newImg = new Image();
        img.attr('src', 'images/loading.gif');
        newImg.onload = function () {
            img.attr('src', newUrl);
            img.parent('a').attr('href', newUrl);
        };
        newImg.src = newUrl;
        return false;
    });

});
