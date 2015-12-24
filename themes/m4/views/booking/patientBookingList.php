<?php
/**
 * $data.
 */
$this->setPageTitle('预约单');

$urlApiAppNav1 = $this->createAbsoluteUrl('/api/list', array('model' => 'appnav1'));

$urlPatientBooking = $this->createUrl('booking/patientBooking');
$this->show_footer = false;
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlUserAccount = $this->createUrl('user/view');
?>
<div id="section_container">
    <section id="order_section" data-init="true" class="active">
        <header class="head-title1" >
            <nav class="left">
                <a href="<?php echo $urlUserAccount; ?>" data-icon="previous" data-target="link"></a>
            </nav>
            <div class="title1">
                <span><?php echo $this->pageTitle; ?></span>
            </div>
        </header>

        <article id="expert_list_article" class="active"  data-scroll="true">
            <ul class="list">
                <?php
                $results = $data->results;
                if (count($results) > 0) {
                    for ($i = 0; $i < count($results); $i++) {
                        ?>
                        <li>
                            <a href="<?php echo $urlPatientBooking; ?>?id=<?php echo $results[$i]->id; ?>" data-target="link">
                                <div class="color-black order_title pl5">订单号:<?php echo $results[$i]->refNo; ?></div >
                                <div class="order_list grid">
                                    <div class="col-0">
                                        预约医生:
                                    </div>
                                    <div class="col-1">
                                        <?php echo $results[$i]->expertName == '' ? '未填写' : $results[$i]->expertName; ?>
                                    </div>
                                </div>
                                <div class="order_list grid">
                                    <div class="col-0">
                                        预约医院:
                                    </div>
                                    <div class="col-1">
                                        <?php echo $results[$i]->hpName == '' ? '未填写' : $results[$i]->hpName; ?>
                                    </div>
                                </div>
                                <div class="order_list">
                                    <div class="">
                                        意向就诊时间:
                                    </div>
                                    <div class="mt10 color-orange">
                                        <?php
                                        if (!$results[$i]->dateStart || !$results[$i]->dateEnd) {
                                            echo '未填写';
                                        } else {
                                            echo $results[$i]->dateStart . '至' . $results[$i]->dateEnd;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </article>
    </section>
</div>