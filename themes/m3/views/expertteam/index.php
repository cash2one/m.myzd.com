<?php
$this->setPageID('pTeam');
$this->setPageTitle('专家团队');
$urlApiAppNav2 = $this->createAbsoluteUrl('/api/list', array('model' => 'appnav2'));
$tUrl = $this->createUrl('expertteam/view');
?>
<div id="<?php echo $this->getPageID(); ?>" class="home-page" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" data-nav-rel="#f-nav-expertteam">    
    <div data-role="content">
        <div class="page">
            <section class="page-section">
                <div class="section-body pt10">

                </div>
            </section>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".ui-loader").show();
            $.ajax({
                //url: 'http://mingyizhudao.com/api/appnav2',
                url: "<?php echo $urlApiAppNav2; ?>",
                success: function (data) {
                    expertTeams = data.expertTeams;
                    var innerHtml = '';
                    for (var i = 0; i < expertTeams.length; i++) {
                        innerHtml = innerHtml +
                                '<div class="star-team"><a href="<?php echo $tUrl ?>?id=' +
                                expertTeams[i].teamId + '"><div class="row"><div class="ui-grid-c pt20"><div class="ui-block-a"><img class="img80 mt10" src="' +
                                expertTeams[i].teamLeader.urlImage + '"/></div><div class="ui-block-b pl10"><div class="team-name mt10">' +
                                expertTeams[i].teamName + '</div><div class="team-hosiptal mt5">' +
                                expertTeams[i].hospital + '</div><div class="team-slogan mt5">' +
                                expertTeams[i].slogan + '</div></div></div></div></a></div><div class="divider"></div>';
                    }
                    $('.section-body').html(innerHtml);
                },
                complete: function () {
                    $(".ui-loader").hide();
                }
            });
        });
    </script>
</div>
