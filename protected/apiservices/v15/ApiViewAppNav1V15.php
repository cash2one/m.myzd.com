<?php

class ApiViewAppNav1V15 extends EApiViewService {

    private $diseaesUrl;
    private $doctorUrl;
    private $banners;   // clickable slide show
    private $url;
    private $disCategoryList;    // 疾病分类
    private $doctors;   // search hospital by city

    protected function loadData() {
        $this->results = new stdClass();

        // load slideshow banners.
        $this->loadBanners();
        $this->loadUrl();
        // load Disease Categories.
        $this->loadDiseaseCategoryList();

    }

    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'errorCode' => 0,
                'errorMsg' => 'success',
                'results' => $this->results,
            );
        }
    }

    private function loadBanners() {
        if (is_null($this->banners)) {
            $this->setBanners();
        }
    }

    private function loadUrl() {
        if (is_null($this->url)) {
            $this->setUrl();
        }
    }

    private function loadDiseaseCategoryList() {
        if (is_null($this->disCategoryList)) {
            $this->disCategoryList = array();
            $disMgr = new DiseaseManager();
            $models = $disMgr->loadDiseaseCategoryListV8();
            if (arrayNotEmpty($models)) {
                $this->setDiseaseCategoryList($models);
            }
        }
    }


    private function setBanners() {
        $data = array(
            array(
                'pageTitle' => '互联网共享经济医时代来啦',
                'actionUrl' => 'http://m.mingyizhudao.com/mobile/home/page/view/internet/header/0',
                'imageUrl' => 'http://static.mingyizhudao.com/147693609846958',
                'type' => 0,
            ),
           array(
                'pageTitle' => '韩国三星',
                'actionUrl' => 'http://m.mingyizhudao.com/mobile/home/page/view/medicalsevice/header/0',
                'imageUrl' => 'http://static.mingyizhudao.com/147505375737374',
                'type' => 0,
            ),
            array(
                'pageTitle' => '改变从现在开始',
                'actionUrl' => 'http://m.mingyizhudao.com/mobile/home/page/view/change/header/0',
                'imageUrl' => 'http://static.mingyizhudao.com/147330339912652',
                'type' => 0,
            ),
            array(
                'pageTitle' => '名医义诊',
                'actionUrl' => 'http://m.mingyizhudao.com/mobile/home/page/view/myyzDoctor/header/0',
                'imageUrl' => 'http://static.mingyizhudao.com/146606890329840',
                'type' => 0,
            ),
            array(
                'pageTitle' => '名医公益',
                'actionUrl' => 'http://m.mingyizhudao.com/mobile/event/view/page/mygy/header/0',
                'imageUrl' => 'http://static.mingyizhudao.com/147150951177488',
                'type' => 0,
            ),
//            array(
//                'pageTitle' => '凯瑟琳',
//                'actionUrl' => 'http://m.mingyizhudao.com/mobile/event/view/page/catherine/header/0',
//                'imageUrl' => 'http://7xsq2z.com2.z0.glb.qiniucdn.com/14652900984794',
//                'type' => 0,
//            ),
        );

        $this->results->banners = $data;
    }

    private function setUrl() {
        $data = array(
            'diseasename' => Yii::app()->createAbsoluteUrl('/api2/diseasename'),
            'quickbooking' => Yii::app()->createAbsoluteUrl('/api2/quickbooking'),
            'doctor' => Yii::app()->createAbsoluteUrl('/api2/doctor'),
            'benefit' => 'http://m.mingyizhudao.com/mobile/home/page/view/myzy/agent/app/addBackBtn/0/header/0/footer/0/app/0',
        );

        $this->results->url = $data;
    }

    /**
     * 
     * @param array $models DiseaseCategory.
     */
    private function setDiseaseCategoryList(array $models) {
        $navList = array();
        foreach ($models as $model) {
            $data = new stdClass();
            $data->id = $model->getCategoryId();
            $data->name = $model->getCategoryName();
            $subGroup = new stdClass();
            $subGroup->id = $model->getSubCategoryId();
            $subGroup->name = $model->getSubCategoryName();
            $diseasesList = CategoryDiseaseJoin::model()->getAllBySubCatId($model->getSubCategoryId());

            if (arrayNotEmpty($diseasesList)) {
                foreach ($diseasesList as $disease) {
                    $disModel = $disease->getDisease();
                    $dataDis = new stdClass();
                    $dataDis->id = $disModel->getId();
                    $dataDis->name = $disModel->getName();
                    $subGroup->diseases[] = $dataDis;
                }
            }

            if (isset($navList[$data->id])) {
                $navList[$data->id]->subCat[] = $subGroup;
            } else {

                $navList[$data->id] = $data;
                $navList[$data->id]->subCat[] = $subGroup;
            }
        }
        $this->results->disNavs = array_values($navList);
    }


}
