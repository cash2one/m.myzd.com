<?php
$this->setPageID('pMobile');
$this->setPageTitle('关于平台');
$showHeader = Yii::app()->request->getQuery('header', 1);
// $urlUserIndex = $this->createUrl('user/index').'/pages';
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
?>

<?php if ($showHeader == 1) {
    ?>
    <header class="bg-green">
        <nav class="left">
            <a href="" data-target="back">
                <div class="pl5">
                    <img src="http://static.mingyizhudao.com/146975795218858" class="w11p">
                </div>
            </a>
        </nav>
        <h1 class="title">关于平台</h1>
        <nav class="right">
            <a onclick="javascript:location.reload()">
                <img src="http://static.mingyizhudao.com/146975853464574"  class="w24p">
            </a>
        </nav>
    </header>
<?php }
?>
<article class="active" data-scroll="true">
    <div class="pl15 pr15 text-justify">
        <div class="pt25 font-s16">
            1.名医主刀网站的医生都是真实医生吗，如何确认医生身份？
        </div>
        <div class="pt10 color-black6">
            是医生本人；名医主刀医生收录的医生均为正规医院，有合法行医资质的医生。名医主刀对于收录展示的医生均有严格资质审核。
        </div>
        <div class="pt25 font-s16">
            2.你们如何审核医生资质？
        </div>
        <div class="pt10 color-black6">
            申请者注册后，我们会到医院、科室核实注册医生信息；后期会有专人到医院索取申请者相关证件信息等。
        </div>
        <div class="pt25 font-s16">
            3.什么是名医助手？
        </div>
        <div class="pt10 color-black6">
            名医助手是名医主刀的工作人员，100%具备医学专业背景，长期接受三甲医院医生以及内部的培训、考核、筛选。医疗助手根据患者提交病情审核，仅提供疾病方向的医生匹配，不进行诊疗。
        </div>
        <div class="pt25 font-s16">
            4.医生是否知晓和你们的合作？
        </div>
        <div class="pt10 color-black6">
            知晓；如去找医生面诊，可与医生本人当面核实。
        </div>
        <div class="pt25 font-s16">
            5.网站是否真实？
        </div>
        <div class="pt10 color-black6">
            网站已经备案，可在网站首页最下方看到备案号。
        </div>
        <div class="pt25 font-s16">
            6.名医主刀能挂到专家号？收费吗？
        </div>
        <div class="pt10 color-black6">
            名医主刀不提供预约挂号业务。
        </div>
        <div class="pt25 font-s16">
            7.名医主刀是医疗机构吗？医生通过名医主刀去异地飞刀，属于多点执业吗？
        </div>
        <div class="pt10 color-black6">
            名医主刀不属于医疗机构，根据《执业医师法》，医生只有在医疗机构开展诊疗相关工作才算行医行为。名医主刀汇集了国内外顶级名医资源和闲置床位资源，并利用互联网技术实现医患精准匹配，医疗资源优化配置，帮助患者解决“好看病，看好病”的切实需求。医生会在有资质的医疗单位进行诊疗行为，符合卫计委规定。
        </div>
        <div class="pt25 font-s16">
            8.患者的病情提交至名医主刀，如何保护其隐私？
        </div>
        <div class="pt10 color-black6">
            名医主刀对于注册用户的真实信息予以保护，不向任何第三方透露。患者提交咨询的病情，仅患者本人和提供服务的医生能看到。网站首页也有信息保护措施的公示。
        </div>
        <div class="pt25 font-s16">
            9.拨打400-6277-120是免费的吗？
        </div>
        <div class="pt10 color-black6 pb30">
            拨打400-6277-120是免长途费的，您在国内任何地区拨打该电话，只需承担本地市话费，长途费由名医主刀承担。
        </div>
    </div>
</article>