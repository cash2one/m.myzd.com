<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/myyzDoctor.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
$urlApiDiagnosisdoctors = $this->createAbsoluteUrl('/api/diagnosisdoctors', array('api' => 9));
$urlDoctorView = $this->createUrl('doctor/view', array('id' => ''));
$urlRootPath = $this->createAbsoluteUrl('/themes/');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
?>
<style>
    #myyzDoctor_header #cityTitle{
        line-height: 1em;
    }
    #myyzDoctor_header .cityImg{
        background: url('<?php echo $urlResImage; ?>/cityLogo.png') no-repeat;
        background-size: 15px 8px;
        width:15px;
        background-position-y: 5px;
    }

    #myyzDoctor_article .imgDiv {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 1px solid #cccccc;
        overflow: hidden;
    }
    #myyzDoctor_article ul.list>li {
        border-bottom: 1px solid #efefef;
    }
</style>
<header id="myyzDoctor_header" class="bg-green" data-path="<?php echo $urlRootPath; ?>">
    <nav class="left">
        <a href="" data-target="back">
            <div class="pl5">
                <img src="<?php echo $urlResImage; ?>back.png" class="w11p">
            </div>
        </a>
    </nav>
    <h1 class="title">
        <span id="selectDept">
            <span id="deptTitle" class="" data-dept="1">外科</span>
            <span class=""><img class="w10p" src="<?php echo $urlResImage; ?>triangleWhite.png"></span>
        </span>
    </h1>
    <nav id="selectCity" class="right">
        <div class="grid mt17">
            <div class="font-s16 col-0" id="cityTitle" data-city="73">
                上海
            </div>
            <div class="col-0 cityImg"></div>
        </div>
    </nav>
</header>
<article id="myyzDoctor_article" class="active" data-scroll="true" data-api="<?php echo $urlApiDiagnosisdoctors; ?>" data-doctorView="<?php echo $urlDoctorView; ?>">
    <div>
    </div>
</article>
<script>
    $(document).ready(function () {
        J.showMask();
        $.ajax({
            url: '<?php echo $urlApiDiagnosisdoctors; ?>' + '&citys=73&disease_category=1',
            success: function (data) {
                //console.log(data);
                readyPage(data);
            },
            error: function (data) {
                J.hideMask();
                console.log(data);
            }
        });
    });
</script>