<?php

class AccessController extends Controller
{
        /**
         * default action
         */
        public $layout = '//layouts/column2_new';
        
        public $defaultAction = 'AssignAccess';

        
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;
        
        
        /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    
        
        /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('assignaccess'),
                'users'=>UserModule::getAdmins(),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
        
        
        /**
         * Assign access to the users screenwise
         */
        public function actionAssignAccess($id){
            if($id == 1){
                throw new CHttpException(403,'Not applicable for admin.');
            }
            
            $user_id = Yii::app()->user->getId();
            
            if($user_id != 1){
                throw new CHttpException(403,'Access denied.');
            }
            
            $usermodel = User::model()->notsafe()->findByPk($id);
            
            if($usermodel->superuser == 1){
                $screens = $this->getDataDetails();
            }else{
                $screens = $this->getDataDetailsUser();
            }
            
            
            if(isset($_POST['accessdata']) && $_POST['accessdata']){  
                // echo "<pre>"; print_r($_POST); die();
                $usermodel->accessdetails = serialize($_POST['selections']); 
                $usermodel->save();
                   
              }

            if(isset($usermodel->accessdetails)){
                    
                $selections = unserialize($usermodel->accessdetails);
            }else{
                $selections = array();
            }
            
            $this->render('access',array( 'model'=>$usermodel, 'screens'=>$screens, 'id'=>$id,
                                          'selections' => $selections
            ));
        }
        
        
        /**
         * get all data
         */
        public function getDataDetails(){
            $screens =   array (
                'SKU' => array(
                    1 => 'Sku',
                    2 => 'OnlySku',
                    3 => 'Content',
                    4 => 'Images',
                    5 => 'Client Rel',
                    6 => 'Stones',
                    7 => 'Metals',
                    8 => 'Findings',
                    9 => 'Addon',
                ),
                'Purchase Order' => array(
                    11 => 'Purchase Order',
                    12 => 'PO Details',
                    13 => 'PO Skus',
                    14 => 'PO Status Log',
                    15 => 'PO Sku Status',
                    16 => 'PO Sku Status Log',
                ),
                'Dept' => array(
                    17 => 'Dept',
                    18 => 'Finding Stocks',
                    19 => 'Metal Stocks',
                    20 => 'Chemical Stocks',
                    21 => 'Stone Stocks',
                    22 => 'Stone Vouchers',
                    23 => 'Sku Log',
                    24 => 'Material Request',
                    25 => 'Material Request Log'
                ),
                'Reports' => array(
                    26 => 'Dept Stone Report',
                    27 => 'Dept Metal Report',
                    28 => 'Dept Sku Report',
                    29 => 'Dept Stock Report',
                    30 => 'Dept Stock Summary',
                    31 => 'Dept Stock Details',
                    32 => 'Dept Stock Ledger',
                    58 => 'Location Stock Ledger'
                    
                ),
                'Client' => array(
                    33 => 'Clients',
                    34 => 'Client Parameters'
                ),
                'Cost Add' => array(
                    35 => 'Cost Additions',
                    36 => 'Metal',
                    37 => 'Stone',
                    38 => 'Finding',
                    39 => 'Setting',
                    40 => 'Chemical',
                ),
                'Metal' => array(
                    41 => 'Metals',
                    42 => 'MetalM',
                    43 => 'Stamp',
                    44 => 'Cost Log'
                ),
                'Stone' => array(
                    45 => 'StoneM',
                    46 => 'Shape',
                    47 => 'Clarity',
                    48 => 'Size',
                    49 => 'Cost Log'
                ),
                'StatusM' => array(
                    50 => 'StatusM',
                    51 => 'Navigation'
                ),
                'Upload' => array(
                    52 => 'Upload'
                ),
                'Invoices' => array(
                    53 => 'Invoices'
                ),
                'Locations' => array(
                    54 => 'Locations',
                    55 => 'Location Stocks'
                ),
                'Master' => array(
                    56 => 'Master',
                ),
                'Keywords' => array(
                   57 => 'Keywords' ,
                ),
                'Exports' => array(
                   72 => 'Amazon' ,
                   73 => 'CA' ,
                   74 => 'JOV' ,
                   75 => 'VG' ,
                   76 => 'Worksheet' ,
                   59 => 'Quotesheet' ,
                   60 => 'SN Spec' ,
                   61 => 'BB' ,
                   62 => 'Boss' ,
                   63 => 'Code Me' ,
                   64 => 'HT' ,
                   65 => 'ZY' ,
                   66 => 'QB' ,
                   67 => 'GKW' ,
                   68 => 'TH' ,
                   69 => 'QOV' ,
                   70 => 'QJC' ,
                   71 => 'JZ' ,
                   77 => 'New Worksheet' ,
                   78 => 'SN Factsheet' ,
                   79 => 'RS Factsheet' ,
                   80 => 'GTDF',
                ),
            );
            
            return $screens;
        }
        
        
        /**
         * get all data
         */
        public function getDataDetailsUser(){
            $screens =   array (
                'SKU' => array(
                    1 => 'Sku',
                    10 => 'Export',
                ),
                'Purchase Order' => array(
                    11 => 'Purchase Order',
                ),
                'Dept' => array(
                    17 => 'Dept',
                ),
               
                'Cost Add' => array(
                    35 => 'Cost Additions',
                    36 => 'Metal',
                    37 => 'Stone',
                    38 => 'Finding',
                    39 => 'Setting',
                    40 => 'Chemical',
                ),
                'Metal' => array(
                    41 => 'Metals',
                    42 => 'MetalM',
                    43 => 'Stamp',
                    44 => 'Cost Log'
                ),
                'Stone' => array(
                    45 => 'StoneM',
                    46 => 'Shape',
                    47 => 'Clarity',
                    48 => 'Size',
                    49 => 'Cost Log'
                ),
                
                'Locations' => array(
                    54 => 'Locations',
                ),
                'Master' => array(
                    56 => 'Master',
                ),
                'Keywords' => array(
                   57 => 'Keywords', 
              ),
                'Exports' => array(
                   72 => 'Amazon' ,
                   73 => 'CA' ,
                   74 => 'JOV' ,
                   75 => 'VG' ,
                   76 => 'Worksheet' ,
                   59 => 'Quotesheet' ,
                   60 => 'SN Spec' ,
                   61 => 'BB' ,
                   62 => 'Boss' ,
                   63 => 'Code Me' ,
                   64 => 'HT' ,
                   65 => 'ZY' ,
                   66 => 'QB' ,
                   67 => 'GKW' ,
                   68 => 'TH' ,
                   69 => 'QOV' ,
                   70 => 'QJC' ,
                   71 => 'JZ' ,
                   77 => 'New Worksheet' ,
                   78 => 'SN Factsheet' ,
                   79 => 'RS Factsheet' ,
                ),
            );
            
            return $screens;
        }
}

?>
