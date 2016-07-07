<?php
$this->setPageTitle('疾病信息');
$urlQuestionnaire = $this->createUrl('/api/questionnaire');
$urlDoctorSearch = $this->createUrl('doctor/search');
$urlQuestionnaireView = $this->createUrl('questionnaire/view', array('id' => 1));
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
?>
<style>
    article{
        background: url('http://7xsq2z.com2.z0.glb.qiniucdn.com/146761944631242') no-repeat;
        background-size: 125px 37px;
        background-position-x: 50%;
        background-position-y: 97%;
    }
</style>
<header class="bg-green">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title">疾病信息</h1>
</header>
<article id="questionnairefive_article" class="active" data-scroll="true">
    <div class="pad20">
        <div class="w100 color-green text18">
            为了更好地给您提供诊疗意见，我们需要了解一下信息：
        </div>
        <div class="w100 mt30 font-s16">
            <div>5/5：医生建议怎么治疗？</div>
            <div class="border-gray border-r3 mt20">
                <div class="pad10 border-bottom"><input type="radio" name="questionnaire[answer]" value="1"/> 建议手术</div>
                <div class="pad10 border-bottom"><input type="radio" name="questionnaire[answer]" value="2" /> 建议观察</div>
                <div class="pad10 border-bottom"><input type="radio" name="questionnaire[answer]" value="3" /> 还需检查，必要时手术</div>
            </div>
            <div class="questionnaire-error"></div>
        </div>
        <div>
            <button id="QuestionnairefiveSubmit" class="btn btn-abs font-s16 bg-green mt40">
                去选择专家
            </button>
        </div>
    </div>
</article>
<script>
    $(document).ready(function () {
        var btnSubmit = $("#QuestionnairefiveSubmit");
        var requestUrl = '<?php echo $urlQuestionnaire; ?>';
        var answer = '';
        $("input[name='questionnaire[answer]']").click(function () {
            $("input[name='questionnaire[answer]']").removeClass('active');
            $(this).addClass('active');
            $("input[name='questionnaire[answer]']").each(function () {
                if ($(this).hasClass("active")) {
                    answer = $(this).val();
                }
            });
        });
        btnSubmit.click(function () {
            if (answer == '') {
                $('.questionnaire-error').html('<div>请您先选择</div>');
            } else {
                $('.questionnaire-error').hide();
                $.ajax({
                    type: 'post',
                    url: requestUrl,
                    data: {"questionnaire[questionnaireNumber]": 5, "questionnaire[answer]": answer},
                    success: function (data) {
                        if (data.status == 'ok') {
                            actionAjaxFinishQuestionnaire();
                        } else {
                            if (data.errorMsg == 'faile answer') {
                                location.href = '<?php echo $urlQuestionnaireView; ?>';
                            }
                        }
                    },
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        console.log(XmlHttpRequest);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        });
    });
    function actionAjaxFinishQuestionnaire() {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('questionnaire/ajaxFinishQuestionnaire'); ?>',
            success: function (data) {
                if (data.status == 'ok') {
                    location.href = '<?php echo $urlDoctorSearch; ?>?source=1&disease_sub_category=2';
                }
            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                console.log(XmlHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
</script>