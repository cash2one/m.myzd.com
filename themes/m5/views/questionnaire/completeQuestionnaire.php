<?php
$this->setPageTitle('提交成功');
$source = Yii::app()->request->getQuery('app', 0);
$this->show_footer = false;
//modify by wanglei 
$urlStat = $this->createAbsoluteUrl('/api/stat');
//成功到达预约单页面
$SITE_10 = PatientStatLog::SITE_10;
?>
<?php
if ($source == 0) {
    ?>
    <header class="bg-green">
        <h1 class="title">提交成功</h1>
    </header>
    <?php
}
?>
<article class="active" data-scroll="true">
    <div class="font-s15">
        <div class="text-center pt40">
            <img src="http://static.mingyizhudao.com/146762360916046" class="w125p">
        </div>
        <div class="text-center color-green pt10 pb20">
            感谢您的信任！
        </div>
        <div class="text-justify pl30 pr30 pt10 pb10 line-h18e">
            名医助手会对您提交的资料进行审核。如有手术指征，我们会在工作时间的2小时内与您电话确认，并安排后续面诊服务。
        </div>
        <div class="text-center pt50 pb10">
            <img src="http://static.mingyizhudao.com/146762537877061" class="w140p">
        </div>
        <div class="text-center pad10 c-black2 pb50">
            关注名医主刀微信公众号，查看预约进度。
        </div>
    </div>
</article>
<script>
    $(document).ready(function () {
        /* function bookStat(keyword){
              $.ajax({
                type: 'post',
                url: '<?php echo $urlStat; ?>',
                data: {'stat[site]': '<?php echo $SITE_10; ?>', 'stat[key_word]':keyword},
                success: function (data) {

                }
            });
         }*/
         //bookStat('提交成功');
      });
 </script>     