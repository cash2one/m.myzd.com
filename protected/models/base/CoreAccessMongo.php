<?php

/**
 * This is the model class for table "AppLog".
 *
 * The followings are the available columns in table 'AppLog':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $user_host_ip
 * @property string $username
 * @property string $url
 * @property integer $site
 * @property string $url_referrer
 * @property string $user_agent
 * @property string $user_host
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class CoreAccessMongo extends EMongoDocument
{
        public $id;
        public $user_host_ip;
        public $url;
        public $url_referrer;
        public $user_agent;
        public $user_host;
        public $date_created;
        public $date_updated;
        public $date_deleted;
        
    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    // This method is required!
    public function getCollectionName()
    {
        return 'CoreAccess';
    }
//     public function addInfo($values) {
        
//         $this->save();
//     }
    public function rules()
    {
       // NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			            array('user_host_ip', 'length', 'max' => 20),
        //    array('url, url_referrer', 'length', 'max' => 255),
       //     array('user_agent, user_host', 'length', 'max' => 45),
        
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_host_ip, url, url_referrer, user_agent, user_host, date_created, date_updated, date_deleted', 'safe', 'on' => 'search'),
		);
    }
    
}
