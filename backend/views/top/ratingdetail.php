<?php 
    use backend\assets\AppAsset;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;

    $this->registerCssFile('css/rating.min.css',['position' => \yii\web\View::POS_HEAD]);

    if($oderRateSorted){
        $rateMap = ArrayHelper::map($oderRateSorted,'_id','score','score');
        $arrayName = ArrayHelper::map($oderRateSorted,'_id','className','score');

        function countName($arrayName){
            $showName = NULL;
            foreach ($arrayName as $key => $value){
                foreach ($value as $key1 => $value1) {
                    $showName[$key][$value1][] = $value1;
                }
            }
            return $showName;
        }
        $ratingName = countName($arrayName);

        $totalScore = 0;
        foreach($rateMap as $value){
            $totalScore = array_sum($value)+$totalScore;
        }

        $badFood = ArrayHelper::map($oderRateSorted,'_id','className','reson_bad_food');
        $badFoodName = countName($badFood);



        $expensivePrice = ArrayHelper::map($oderRateSorted,'_id','className','reson_expensive_price');
        $expensivePriceName = countName($expensivePrice);

        $badService = ArrayHelper::map($oderRateSorted,'_id','className','reson_bad_service');
        $badServiceName = countName($badService);

        $badShiper = ArrayHelper::map($oderRateSorted,'_id','className','reson_bad_shipper');
        $badShiperName = countName($badShiper);

        $other = ArrayHelper::map($oderRateSorted,'_id','className','reson_other');

        $otherName = countName($other);
        $totalRepon = count($badFood[1]) + count($expensivePrice[1]) + count($badService[1]) + count($badShiper[1]) + count($other[1]);
        ?>
        <div class="rating-box">
            <div itemtype="http://schema.org/AggregateRating" itemscope="itemscope" itemprop="aggregateRating" class="score-container">
                <meta itemprop="ratingValue" content="4.331130504608154">
                <meta itemprop="ratingCount" content="12704866">
                <div aria-label=" Rated 4.3 stars out of five stars " class="score"><?php echo round((float)$totalScore/count($oderRateSorted));?></div>
                <div class="score-container-star-rating">
                    <div aria-label=" Rated 4.3 stars out of five stars " class="small-star star-rating-non-editable-container">
                        <div style="width: <?php echo (($totalScore/count($oderRateSorted))/5)*100; ?>%;" class="current-rating"></div>
                    </div>
                </div>
                <div class="reviews-stats">
                    <span class="reviewers-small"></span>
                    <span aria-label=" 12,704,866 ratings " class="reviews-num"><?php echo count($oderRateSorted);?></span> Lượt
                </div>
            </div>
            <div class="rating-histogram">
                <div class="rating-bar-container five"> <span class="bar-label"> <span class="star-tiny star-full"></span>5 </span> <span style="width:<?php echo (array_sum($rateMap[5])/$totalScore)*100?>%" class="bar"></span> <span aria-label=" 5 ratings " class="bar-number"><a id="popoverOption5" href="#" data-content="<?php
                        if($ratingName[5]){
                            foreach ($ratingName[5] as $key => $value) {
                                echo $key.'('.count($value).'lượt) ';
                            }
                        }else{echo '0 luợt';}
                        ?>" rel="popover" data-placement="bottom" data-original-title="5 Sao"><?php echo array_sum($rateMap[5]);?></a></span></div>

                <div class="rating-bar-container four"> <span class="bar-label"> <span class="star-tiny star-full"></span>4 </span> <span style="width:<?php echo (array_sum($rateMap[4])/$totalScore)*100?>%" class="bar"></span> <span aria-label=" 4 ratings " class="bar-number"><a id="popoverOption4" href="#" data-content="<?php
                        foreach ($ratingName[4] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="4 Sao"><?php echo array_sum($rateMap[4]);?></a></span></div>

                <div class="rating-bar-container three"> <span class="bar-label"> <span class="star-tiny star-full"></span>3 </span> <span style="width:<?php echo (array_sum($rateMap[3])/$totalScore)*100?>%" class="bar"></span> <span aria-label=" 3 ratings " class="bar-number"><a id="popoverOption3" href="#" data-content="<?php
                        foreach ($ratingName[3] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="3 Sao"><?php echo array_sum($rateMap[3]);?></a></span></div>

                <div class="rating-bar-container two"> <span class="bar-label"> <span class="star-tiny star-full"></span>2 </span> <span style="width:<?php echo (array_sum($rateMap[2])/$totalScore)*100?>%" class="bar"></span> <span aria-label=" 2 ratings " class="bar-number"><a id="popoverOption2" href="#" data-content="<?php
                        foreach ($ratingName[2] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="2 Sao"><?php echo array_sum($rateMap[2]);?></a></span></div>

                <div class="rating-bar-container one"> <span class="bar-label"> <span class="star-tiny star-full"></span>1 </span> <span style="width:<?php echo (array_sum($rateMap[1])/$totalScore)*100?>%" class="bar"></span> <span aria-label=" 1 ratings " class="bar-number"><a id="popoverOption1" href="#" data-content="<?php
                        foreach ($ratingName[1] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="1 Sao"><?php echo array_sum($rateMap[1]);?></a></span></div>
            </div>
        </div>


        <div class="rating-box">
            <div itemscope="itemscope" itemprop="aggregateRating" class="score-container">
                <div aria-label=" Rated 4.3 stars out of five stars " class="score"><?php echo $totalRepon;?></div>

                <div class="reviews-stats">
                    <span class="reviewers-small"></span>
                    <span aria-label=" 12,704,866 ratings " class="reviews-num"><?php /*echo $totalRepon;*/?></span> Lượt bình chọn
                </div>
            </div>
            <div class="rating-histogram">
                <div class="rating-bar-container five"> <span class="bar-label1">Bad Food </span> <span style="width:<?php echo (count($badFood[1])/$totalRepon)*100?>%" class="bar"></span> <span aria-label=" 5 ratings " class="bar-number"><a id="popoverOption15" href="#" data-content="<?php
                        foreach ($badFoodName[1] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="Bad Food"><?php echo count($badFood[1]);?></a></span></div>

                <div class="rating-bar-container four"> <span class="bar-label1"> Expensive </span> <span style="width:<?php echo (count($expensivePrice[1])/$totalRepon)*100?>%" class="bar"></span> <span aria-label=" 4 ratings " class="bar-number"><a id="popoverOption14" href="#" data-content="<?php
                        foreach ($expensivePriceName[1] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="Expensive Food"><?php echo count($expensivePrice[1]);?></a></span></div>

                <div class="rating-bar-container three"> <span class="bar-label1">Bad Shiper </span> <span style="width:<?php echo (count($badShiper[1])/$totalRepon)*100?>%" class="bar"></span> <span aria-label=" 3 ratings " class="bar-number"><a id="popoverOption13" href="#" data-content="<?php
                        foreach ($badShiperName[1] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="Bad Shipper"><?php echo count($badShiper[1]);?></a></span></div>

                <div class="rating-bar-container two"> <span class="bar-label1">Other </span> <span style="width:<?php echo (count($other[1])/$totalRepon)*100?>%" class="bar"></span> <span aria-label=" 2 ratings " class="bar-number"><a id="popoverOption12" href="#" data-content="<?php
                        foreach ($otherName[1] as $key => $value) {
                            echo $key.'('.count($value).'lượt) ';
                        }
                        ?>" rel="popover" data-placement="bottom" data-original-title="Other"><?php echo count($other[1]);?></a></span></div>
            </div>
        </div>
    <?php
    }else{
        echo '<h2>Dữ liệu đang được cập nhật, xin vui lòng quay lại sau</h2>';
    }
?>




<script>
$('#popoverOption5').popover({ trigger: "hover" });
$('#popoverOption4').popover({ trigger: "hover" });
$('#popoverOption3').popover({ trigger: "hover" });
$('#popoverOption2').popover({ trigger: "hover" });
$('#popoverOption1').popover({ trigger: "hover" });

$('#popoverOption15').popover({ trigger: "hover" });
$('#popoverOption14').popover({ trigger: "hover" });
$('#popoverOption13').popover({ trigger: "hover" });
$('#popoverOption12').popover({ trigger: "hover" });
</script>
