$('#deptSelect').tap(function () {
    var deptName = $('#deptTitle').html();
    var deptId = $('#deptTitle').attr('data-dept');
    var cityName = $('#cityTitle').html();
    var cityId = $('#cityTitle').attr('data-city');
    var innerPage = '<div id="findDoc_section">' +
            '<header class="bg-green">' +
            '<nav class="left">' +
            '<a href="#" data-icon="previous" data-target="back"></a>' +
            '</nav>' +
            '<h1 class="title">找医生</h1>' +
            '</header>' +
            '<nav id="findDoc_nav" class="header-secondary bg-white">' +
            '<div class="grid w100 color-black font-s16 color-black6">' +
            '<div id="deptSelect" data-target="closePopup" class="col-1 w33 br-gray bb-gray grid middle grayImg">' +
            '<span id="deptTitle" data-dept="' + deptId + '">' + deptName + '</span><img src="../../themes/m5/images/gray.png">' +
            '</div>' +
            '<div id="diseaseSelect" data-target="closePopup" class="col-1 w33 br-gray bb-gray grid middle grayImg">' +
            '<span id="diseaseTitle" data-disease="">疾病</span><img src="../../themes/m5/images/gray.png">' +
            '</div>' +
            '<div id="citySelect" data-target="closePopup" class="col-1 w33 bb-gray grid middle grayImg">' +
            '<span id="cityTitle" data-city="' + cityId + '">' + cityName + '</span><img src="../../themes/m5/images/gray.png">' +
            '</div>' +
            '</div>' +
            '</nav>' +
            '<article id="findDoc_article" class="active" style="position:static;">' + $deptHtml +
            '</article>' +
            '</div>';

    J.popup({
        html: innerPage,
        pos: 'top',
        showCloseBtn: false
    });

    $('.aDept').tap(function () {
        var dataDept = $(this).attr('data-dept');
        $('.aDept').each(function () {
            if (dataDept == $(this).attr('data-dept')) {
                $(this).addClass('bg-white');
            } else {
                $(this).removeClass('bg-white');
            }
        });
        $('.bDept').each(function () {
            if (dataDept == $(this).attr('data-dept')) {
                $(this).removeClass('hide');
            } else {
                $(this).addClass('hide');
            }
        });
    });

    $('.cDept').tap(function (e) {
        e.preventDefault();
        $deptId = $(this).attr('data-dept');
        $deptName = $(this).html();
        $condition["disease_sub_category"] = $deptId;
        $condition["disease"] = '';
        $condition["disease_name"] = '';
        $condition["city"] = '';
        $condition["page"] = 1;
        setTimeout(function () {
            J.closePopup();
        }, 100);
        var requestUrl = $requestDoc + setUrlCondition() + '&getcount=1';
        //alert(requestUrl);
        J.showMask();
        $.ajax({
            url: requestUrl,
            success: function (data) {
                console.log(data);
                readyDoc(data);
                $deptName = $deptName.length > 4 ? $deptName.substr(0, 3) + '...' : $deptName;
                $('#deptTitle').html($deptName);
                $('#deptTitle').attr('data-dept', $deptId);
                $('#diseaseTitle').html('疾病');
                $('#diseaseTitle').attr('data-disease', '');
                $('#cityTitle').html('地区');
                $('#cityTitle').attr('data-disease', '');
                setLocationUrl();
            }
        });
    });

});
$('#diseaseSelect').tap(function () {
    var deptName = $('#deptTitle').html();
    var deptId = $('#deptTitle').attr('data-dept');
    var diseaseName = $('#diseaseTitle').html();
    var diseaseId = $('#diseaseTitle').attr('data-disease');
    var cityName = $('#cityTitle').html();
    var cityId = $('#cityTitle').attr('data-city');
    var diseaseHtml = '';

    //是否选择科室
    if (deptId == '') {
        J.showToast('请先选择科室', '', 1000);
        return;
    }

    //ajax异步请求疾病
    $.ajax({
        url: $requestDisease + '/' + deptId,
        success: function (data) {
            console.log(data);
            diseaseHtml = readyDisease(data);
            ajaxPage(diseaseHtml);
        }
    });

    function readyDisease(data) {
        var results = data.results;
        var innerHtml = '<div class="grid color-black" data-scroll="true" style="margin-top:83px;height:315px;">' +
                '<ul class="list w100">';
        if (results) {
            var disease = results.disease;
            if (disease.length > 0) {
                for (var i = 0; i < disease.length; i++) {
                    innerHtml += '<li class="aDisease" data-disease="' + disease[i].id + '">' + disease[i].name + '</li>';
                }
            }
        }
        innerHtml += '</ul></div>';
        return innerHtml;
    }

    function ajaxPage(diseaseHtml) {
        var innerPage = '<div id="findDoc_section">' +
                '<header class="bg-green">' +
                '<nav class="left">' +
                '<a href="#" data-icon="previous" data-target="back"></a>' +
                '</nav>' +
                '<h1 class="title">找医生</h1>' +
                '</header>' +
                '<nav id="findDoc_nav" class="header-secondary bg-white">' +
                '<div class="grid w100 color-black font-s16 color-black6">' +
                '<div id="deptSelect" data-target="closePopup" class="col-1 w33 br-gray bb-gray grid middle grayImg">' +
                '<span id="deptTitle" data-dept="' + deptId + '">' + deptName + '</span><img src="../../themes/m5/images/gray.png">' +
                '</div>' +
                '<div id="diseaseSelect" data-target="closePopup" class="col-1 w33 br-gray bb-gray grid middle grayImg">' +
                '<span id="diseaseTitle" data-disease="' + diseaseId + '">' + diseaseName + '</span><img src="../../themes/m5/images/gray.png">' +
                '</div>' +
                '<div id="citySelect" data-target="closePopup" class="col-1 w33 bb-gray grid middle grayImg">' +
                '<span id="cityTitle" data-city="' + cityId + '">' + cityName + '</span><img src="../../themes/m5/images/gray.png">' +
                '</div>' +
                '</div>' +
                '</nav>' +
                '<article id="findDoc_article" class="active" style="position:static;">' + diseaseHtml +
                '</article>' +
                '</div>';
        J.popup({
            html: innerPage,
            pos: 'top',
            showCloseBtn: false
        });

        $('.aDisease').tap(function () {
            $diseaseNameB = $(this).html();
            $diseaseIdB = $(this).attr('data-disease');
            $condition["disease_sub_category"] = '';
            $condition["disease_name"] = '';
            $condition["city"] = '';
            $condition["disease"] = $diseaseIdB;
            $condition["page"] = 1;
            setTimeout(function () {
                J.closePopup();
            }, 100);
            var requestUrl = $requestDoc + setUrlCondition() + '&getcount=1';
            //alert(requestUrl);
            J.showMask();
            $.ajax({
                url: requestUrl,
                success: function (data) {
                    console.log(data);
                    readyDoc(data);
                    $diseaseNameB = $diseaseNameB.length > 4 ? $diseaseNameB.substr(0, 3) + '...' : $deptName;
                    $('#deptTitle').html($deptName);
                    $('#diseaseTitle').html($diseaseNameB);
                    $('#diseaseTitle').attr('data-disease', $diseaseIdB);
                    $('#cityTitle').html('地区');
                    $('#cityTitle').attr('data-city', '');
                    setLocationUrl();
                }
            });
        });
    }
});
$('#citySelect').tap(function () {
    var deptName = $('#deptTitle').html();
    var deptId = $('#deptTitle').attr('data-dept');
    var diseaseName = $('#diseaseTitle').html();
    var diseaseId = $('#diseaseTitle').attr('data-disease');
    var cityName = $('#cityTitle').html();
    var cityId = $('#cityTitle').attr('data-city');
    var innerPage = '<div id="findDoc_section">' +
            '<header class="bg-green">' +
            '<nav class="left">' +
            '<a href="#" data-icon="previous" data-target="back"></a>' +
            '</nav>' +
            '<h1 class="title">找医生</h1>' +
            '</header>' +
            '<nav id="findDoc_nav" class="header-secondary bg-white">' +
            '<div class="grid w100 color-black font-s16 color-black6">' +
            '<div id="deptSelect" data-target="closePopup" class="col-1 w33 br-gray bb-gray grid middle grayImg">' +
            '<span id="deptTitle" data-dept="' + deptId + '">' + deptName + '</span><img src="../../themes/m5/images/gray.png">' +
            '</div>' +
            '<div id="diseaseSelect" data-target="closePopup" class="col-1 w33 br-gray bb-gray grid middle grayImg">' +
            '<span id="diseaseTitle" data-disease="' + diseaseId + '">' + diseaseName + '</span><img src="../../themes/m5/images/gray.png">' +
            '</div>' +
            '<div id="citySelect" data-target="closePopup" class="col-1 w33 bb-gray grid middle grayImg">' +
            '<span id="cityTitle" data-city="' + cityId + '">' + cityName + '</span><img src="../../themes/m5/images/gray.png">' +
            '</div>' +
            '</div>' +
            '</nav>' +
            '<article id="findDoc_article" class="active" style="position:static;">' + $cityHtml +
            '</article>' +
            '</div>';

    J.popup({
        html: innerPage,
        pos: 'top',
        showCloseBtn: false
    });

    $('.aCity').tap(function () {
        var dataCity = $(this).attr('data-city');
        $('.aCity').each(function () {
            if (dataCity == $(this).attr('data-city')) {
                $(this).addClass('bg-white');
            } else {
                $(this).removeClass('bg-white');
            }
        });
        $('.bCity').each(function () {
            if (dataCity == $(this).attr('data-city')) {
                $(this).removeClass('hide');
            } else {
                $(this).addClass('hide');
            }
        });
    });

    $('.cCity').tap(function (e) {
        e.preventDefault();
        $deptId = $('#deptTitle').attr('data-dept');
        $diseaseId = $('#diseaseTitle').attr('data-disease');
        $cityId = $(this).attr('data-city');
        $cityName = $(this).html();
        $condition["disease_sub_category"] = '';
        $condition["disease"] = $diseaseId;
        $condition["disease_name"] = '';
        $condition["city"] = $cityId;
        $condition["page"] = 1;
        setTimeout(function () {
            J.closePopup();
        }, 100);
        var requestUrl = $requestDoc + setUrlCondition() + '&getcount=1';
        //alert(requestUrl);
        J.showMask();
        $.ajax({
            url: requestUrl,
            success: function (data) {
                console.log(data);
                readyDoc(data);
                $('#cityTitle').html($cityName);
                $('#cityTitle').attr('data-city', $cityId);
                setLocationUrl();
            }
        });
    });
});

//医生页面
function readyDoc(data) {
    var results = data.results;
    var innerHtml = '<div class="pt10"></div>';
    if (results) {
        if (results.length > 0) {
            for (var i = 0; i < results.length; i++) {
                var btGray = i == 0 ? '' : 'bt-gray2';
                var hp_dept_desc = (results[i].desc == '' || results[i].desc == null) ? '暂无信息' : results[i].desc;
                hp_dept_desc = hp_dept_desc.length > 40 ? hp_dept_desc.substr(0, 40) + '...' : hp_dept_desc;
                innerHtml += '<div>' +
                        '<a href="' + $requestDoctorView + '/' + results[i].id + '" data-target="link">' +
                        '<div class="grid pl15 pr15 pt10 pb10 bb-gray3 ' + btGray + '">' +
                        '<div class="col-1 w25">' +
                        '<div class="w80p h80p" style="overflow:hidden;border-radius:5px;"><img class="imgDoc" src="' + results[i].imageUrl + '"></div>';
                if (results[i].isContracted == 1) {
                    innerHtml += '<div class="sign w80p">签约专家</div>'
                }
                innerHtml += '</div>' +
                        '<div class="ml10 col-1 w75">' +
                        '<div class="mt10 color-black2 font-s16">' + results[i].name + '<span class="ml5">' + results[i].aTitle + '</span></div>' +
                        '<div class="mt5 color-black6">' + results[i].hpDeptName + '<span class="ml5">' + results[i].mTitle + '</span></div>' +
                        '<div class="mt5 color-black6">' + results[i].hpName + '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<div class="pl15 pr15 pt5 pb10 font-s12 color-black bb-gray2">' +
                        '擅长:' + hp_dept_desc +
                        '</div>' +
                        '<div class="bb5-gray "></div>' +
                        '</div>';
            }
        }
    } else {
        innerHtml += '<div class="grid pl15 pr15 pt10 pb10 bb-gray2">暂无信息</div>';
    }
    if (data.dataNum != null) {
        var dataPage = Math.ceil(data.dataNum / 10);
        if (dataPage > 1) {
            innerHtml += '<div class="grid pl15 pr15 pt10 pb10 bb-gray3 bt-gray2"><div class="grid w100">' +
                    '<div class="col-1 w40">' +
                    '<button id="previousPage" type="button" class="button btn-yellow">上一页</button>' +
                    '</div><div class="col-1 w20">' +
                    '<select id="selectPage" onchange="changePage()">';
            var nowPage = $condition["page"];
            for (var i = 1; i <= dataPage; i++) {
                if (nowPage == i) {
                    innerHtml += '<option id="quickPage" value="' + i + '" selected = "selected">' + i + '</option>';
                } else {
                    innerHtml += '<option id="quickPage" value="' + i + '">' + i + '</option>';
                }
            }
            innerHtml += '</select>' +
                    '</div>' +
                    '<div class="col-1 w40">' +
                    '<button id="nextPage" type="button" class="button btn-yellow">下一页</button>' +
                    '</div>' +
                    '</div></div>';
        }
    }
    $('#docPage').html(innerHtml);
    initPage(dataPage);
    J.hideMask();
}

//分页
function initPage(dataPage) {
    $('#previousPage').tap(function () {
        if ($condition["page"] > 1) {
            $condition["page"] = parseInt($condition["page"]) - 1;
            J.showMask();
            $.ajax({
                url: $requestDoc + setUrlCondition() + '&getcount=1',
                success: function (data) {
                    console.log(data);
                    readyDoc(data);
                    setLocationUrl();
                }
            });
        } else {
            J.showToast('已是第一页', '', '1000');
        }
    });
    $('#nextPage').tap(function () {
        if ($condition["page"] < dataPage) {
            $condition["page"] = parseInt($condition["page"]) + 1;
            J.showMask();
            $.ajax({
                url: $requestDoc + setUrlCondition() + '&getcount=1',
                success: function (data) {
                    console.log(data);
                    readyDoc(data);
                    setLocationUrl();
                }
            });
        } else {
            J.showToast('已是最后一页', '', '1000');
        }
    });
}

//跳页
function changePage() {
    $condition["page"] = $('#selectPage').val();
    $.ajax({
        url: $requestDoc + setUrlCondition() + '&getcount=1',
        success: function (data) {
            console.log(data);
            readyDoc(data);
            setLocationUrl();
        }
    });
}

function setUrlCondition() {
    var urlCondition = "";
    for ($key in $condition) {
        if ($condition[$key] && $condition[$key] !== "") {
            urlCondition += "&" + $key + "=" + $condition[$key];
        }
    }
    return urlCondition;
}

//更新url
function setLocationUrl() {
    var stateObject = {};
    var title = "";
    var urlCondition = '';
    for ($key in $condition) {
        if ($condition[$key] && $condition[$key] !== "") {
            urlCondition += "&" + $key + "=" + $condition[$key];
        }
    }
    urlCondition = urlCondition.substring(1);
    urlCondition = "?" + urlCondition;
    var newUrl = $requestDoctorSearch + urlCondition;
    history.pushState(stateObject, title, newUrl);
}