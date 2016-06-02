<?php

class ApiViewAppNav3 extends EApiViewService {

    private $searchInputs;
    private $data;

    public function __construct($values) {
        parent::__construct();
        $this->searchInputs = $values;
    }

    protected function loadData() {
        $apiService = new ApiViewHospitalSearch($this->searchInputs);
        $this->data = $apiService->loadApiViewData();
    }

    protected function createOutput() {
        if (is_null($this->output)) {
            $this->output = array(
                'status' => self::RESPONSE_OK,
                'locations' => $this->data->locations,
                'hospitalSearchUrl'=>Yii::app()->createAbsoluteUrl('/api/list', array('model'=>'hospital', 'city'=>'')),
                'hospitalViewUrl' => Yii::app()->createAbsoluteUrl('/api/view', array('model' => 'hospital', 'id' => '')),
                'hospitals' => $this->data->hospitals,
            );
        }
    }

}
