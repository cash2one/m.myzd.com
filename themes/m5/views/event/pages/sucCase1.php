
<?php
$this->setPageTitle('我代表“国务院”感谢你');
$showHeader = Yii::app()->request->getQuery('header', 1);
$this->show_footer = false;
?>

<?php if ($showHeader == 1) { ?>
    <header class="bg-green">
        <nav class="left">
            <a href="" data-target="back">
                <div class="pl5">
                    <img src="http://static.mingyizhudao.com/146975795218858" class="w11p">
                </div>
            </a>
        </nav>
        <div class="title">我代表“国务院”感谢你</div>
        <nav class="right">
        </nav>
    </header>
<?php } ?>
<article id="operation_article" class="active story_article" data-scroll="true">
    <div class="color-black">
        <div>
            <img src="http://static.mingyizhudao.com/14732499096502" class="w100">
        </div>
        <div class="pl10 pr10">
            <div class="font-s12 pt10 color-gray8">
                名医主刀<span class="ml7">2016-09-08</span>
            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                据调查显示，超过9成的人在面临手术的时候，都会产生抑郁情绪，而其中的20%，抑郁症状更严重，甚至直接会影响手术效果。
            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                来自安徽的小伙子小马，确是一个大大的特例。21岁的年纪，却不幸患上Coats病（外层渗出性视网膜病变），双眼近视屈光不正，突遭这样的疾病，相信大多数人都难以接受，可阳光开朗的小马没有从此一蹶不振，而是积极寻找治疗方案，甚至还在手术前跟名医主刀客服专员开起玩笑来。

            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                小马在平时的生活中是个乐观开朗的男孩。虽然，视力问题一直困扰着他，可他怎么也没想到自己的眼睛会严重到这个地步，到医院确诊为右眼患外层渗出性视网膜病变，双眼近视屈光不正，由于右眼的病情严重，在之前去过的多家当地医院里，小马不止一次被告知只能采用保守治疗的方法，开朗的小马也开始担心起来。

            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                噩耗像霹雳般让小马清晰认识到自己眼睛病情的严重性，从此之后妈妈和小马走上了治疗眼睛的漫漫长路。由于眼底视网膜出血，做了三次激光治疗，可谁知之后恶化成了视网膜水肿，当地医院医生水平有限，不敢擅自进行手术，只是建议小马采取保守治疗的方法，就这一来二去，病情得不到好转，小马妈妈对当地医院提供的治疗建议渐渐失去了信心。

            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                看到这里，如果你是小马，相信大多数人已经心灰意冷了，可是乐观的小马却没有，他积极的配合医院检查，还会安慰妈妈让她不要太难过，这么懂事的小马却让妈妈更加心疼。

            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                小马妈妈没有放弃，为了寻找更好的治疗方法，开始辗转各地为小马找专业医院的医生。2016年农历新年期间，小马妈妈通过朋友介绍，知道了名医主刀这个平台，上面签约了全国各个科室的顶尖医生，让小马妈妈又看到了希望。年假一过，在2月14日这天，便在名医主刀上提交了预约单，名医主刀的专业客服给小马匹配了全国顶尖的眼科科室——首都医科大学附属北京同仁医院眼科中心，并为其匹配到眼底病科主任医师朱晓青教授主刀。

            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                3天后，小马和妈妈根据名医主刀客服安排来到北京同仁医院面诊，当天就安排了眼部检查项目，检查结果在一周以后出来，期间，名医主刀专业客服一直和小马保持联系，让小马和妈妈感受到了来自名医主刀的关心。一周后，小马和妈妈带着检查报告找到朱晓青主任，主任确认了进行手术的必要性，并迅速安排下来，小马第二天就办理入院，等待3月1号的眼部手术。

            </div>
            <div class="font-s12 mt10 grayBg text-justify text-indent-2">
                手术进行的很顺利，小马的眼睛在朱主任的柳叶刀下得到了彻底的改善，小马妈妈也一扫往日的阴霾，渐渐放宽了心。在我们的专业客服进行术后回访时，小马还跟她开玩笑称：“我代表‘国务院’向姐姐表示衷心的感谢。” 他开朗乐观的心态也感染了我们的工作人员，向身边的人传递着微笑与希望。

            </div>
            
        </div>
    </div>
    <div id="freePhone" href="javascript:;" data-track="wifi点击免费咨询">
        免费咨询
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {
        var _prevUrl = document.referrer;
        if (_prevUrl.indexOf('consultative') != -1) {
            $('#freePhone').css('display','block');
            console.log('come form wifi');
        }
        $('#freePhone').click(function () {
            location.href = 'http://dct.zoosnet.net/LR/Chatpre.aspx?id=DCT73779034&lng=cn';
        });
    });
</script>