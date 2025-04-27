<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use common\models\User;
// use common\models\RentalPayment;
use common\models\Application;
use common\models\ApplicationMark;
use common\models\PageType12;
use common\models\Definitions;
use backend\models\ApplicationForm;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * LoginLogSearch represents the model behind the search form about `common\models\LoginLog`.
 */
class ApplicationFormImport extends Model
{
  public $file;
  public $error_excel=[];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['file'],'required'],
          [['file'],'file','extensions'=>'excel, xls, xlsx,csv','maxSize'=>1024 * 1024 * 5],
        ];
    }

    public function attributeLabels(){
        return [
          'file'=>Yii::t('app', 'Select File'),
        ];
    }

    public function import(){
      $this->file = UploadedFile::getInstance($this,'file');

      if($this->validate()){
        // require __DIR__ . '/../../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        // require __DIR__ . '/../../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php';
   			// $objPHPExcel = \PHPExcel_IOFactory::load($this->file->tempName);
   			$objPHPExcel = IOFactory::load($this->file->tempName);

   			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
          if ($objPHPExcel->getIndex($worksheet) != 0) {
            return;
          }
   				$worksheetTitle     = $worksheet->getTitle();
   				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
   				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
   				// $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
   				$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
   				$nrColumns = ord($highestColumn) - 64;

          $user_model_array = [];
          $application_model_array = [];

   				if($highestRow>=2){
            $fail = 0;
   					for ($i=2; $i<=$highestRow; $i++)
   					{
   						$empty_line=true;
   						for ($j=0; $j<$highestColumnIndex; $j++){
   							$empty_line=$empty_line && ($worksheet->getCellByColumnAndRow($j, $i)->getValue()==NULL);
   						}

   						if(!$empty_line){
                $appl_no              = (string)$worksheet->getCellByColumnAndRow(1, $i)->getValue();
                $appl_no              = trim($appl_no);

                $application_model = ApplicationForm::findOne(['appl_no' => $appl_no]);
                
                if ($application_model) {
                  $type = 'edit';
                } else {
                  $type = 'create';
                }

                $priority_1           = (string)$worksheet->getCellByColumnAndRow(2, $i)->getValue();
                $priority_2           = (string)$worksheet->getCellByColumnAndRow(3, $i)->getValue();
                $priority_3           = (string)$worksheet->getCellByColumnAndRow(4, $i)->getValue();
                $chi_name             = (string)$worksheet->getCellByColumnAndRow(5, $i)->getValue();
                $eng_name             = (string)$worksheet->getCellByColumnAndRow(6, $i)->getValue();
                $phone                = (string)$worksheet->getCellByColumnAndRow(7, $i)->getValue();
                $mobile               = (string)$worksheet->getCellByColumnAndRow(8, $i)->getValue();
                $address              = (string)$worksheet->getCellByColumnAndRow(9, $i)->getValue();
                $area                 = (string)$worksheet->getCellByColumnAndRow(10, $i)->getValue();
                $email                = (string)$worksheet->getCellByColumnAndRow(11, $i)->getValue();
                $house_type           = (string)$worksheet->getCellByColumnAndRow(12, $i)->getValue();
                $house_type_other	    = (string)$worksheet->getCellByColumnAndRow(13, $i)->getValue();
                $private_type	        = (string)$worksheet->getCellByColumnAndRow(14, $i)->getValue();
                $together_type	      = (string)$worksheet->getCellByColumnAndRow(15, $i)->getValue();
                $together_type_other	= (string)$worksheet->getCellByColumnAndRow(16, $i)->getValue();
                $live_rent	          = (string)$worksheet->getCellByColumnAndRow(17, $i)->getValue();
                $live_year	          = (string)$worksheet->getCellByColumnAndRow(18, $i)->getValue();
                $live_month	          = (string)$worksheet->getCellByColumnAndRow(19, $i)->getValue();
                $family_member	      = (string)$worksheet->getCellByColumnAndRow(20, $i)->getValue();
                $prh	                = (string)$worksheet->getCellByColumnAndRow(21, $i)->getValue();
                $prh_no	              = (string)$worksheet->getCellByColumnAndRow(22, $i)->getValue();
                $prh_location	        = (string)$worksheet->getCellByColumnAndRow(23, $i)->getValue();
                $apply_prh_year	      = (string)$worksheet->getCellByColumnAndRow(24, $i)->getValue();
                $apply_prh_month	    = (string)$worksheet->getCellByColumnAndRow(25, $i)->getValue();
                $apply_prh_day	      = (string)$worksheet->getCellByColumnAndRow(26, $i)->getValue();
                $app_gender	          = (string)$worksheet->getCellByColumnAndRow(27, $i)->getValue();
                $app_born_date	      = (string)$worksheet->getCellByColumnAndRow(28, $i)->getValue();
                $app_id_type        	= (string)$worksheet->getCellByColumnAndRow(29, $i)->getValue();
                $app_id_no	          = (string)$worksheet->getCellByColumnAndRow(30, $i)->getValue();
                $app_marriage_status	= (string)$worksheet->getCellByColumnAndRow(31, $i)->getValue();
                $app_chronic_patient	= (string)$worksheet->getCellByColumnAndRow(32, $i)->getValue();
                $app_working_status	  = (string)$worksheet->getCellByColumnAndRow(33, $i)->getValue();
                $app_career	          = (string)$worksheet->getCellByColumnAndRow(34, $i)->getValue();
                $app_income	          = (string)$worksheet->getCellByColumnAndRow(35, $i)->getValue();
                $app_funding_type_1   = (string)$worksheet->getCellByColumnAndRow(36, $i)->getValue();
                $app_funding_type_2   = (string)$worksheet->getCellByColumnAndRow(37, $i)->getValue();
                $app_funding_type_3   = (string)$worksheet->getCellByColumnAndRow(38, $i)->getValue();
                $app_funding_type_4   = (string)$worksheet->getCellByColumnAndRow(39, $i)->getValue();
                $app_funding_type_5   = (string)$worksheet->getCellByColumnAndRow(40, $i)->getValue();
                $app_funding_type_6   = (string)$worksheet->getCellByColumnAndRow(41, $i)->getValue();
                $app_funding_value	  = (string)$worksheet->getCellByColumnAndRow(42, $i)->getValue();
                $app_asset	          = (string)$worksheet->getCellByColumnAndRow(43, $i)->getValue();
                $app_asset_type	      = (string)$worksheet->getCellByColumnAndRow(44, $i)->getValue();
                $app_asset_value	    = (string)$worksheet->getCellByColumnAndRow(45, $i)->getValue();
                $app_deposit	        = (string)$worksheet->getCellByColumnAndRow(46, $i)->getValue();
                $m1_chi_name	        = (string)$worksheet->getCellByColumnAndRow(47, $i)->getValue();
                $m1_eng_name	        = (string)$worksheet->getCellByColumnAndRow(48, $i)->getValue();
                $m1_gender	          = (string)$worksheet->getCellByColumnAndRow(49, $i)->getValue();
                $m1_born_date	        = (string)$worksheet->getCellByColumnAndRow(50, $i)->getValue();
                $m1_id_type         	= (string)$worksheet->getCellByColumnAndRow(51, $i)->getValue();
                $m1_id_no	            = (string)$worksheet->getCellByColumnAndRow(52, $i)->getValue();
                $m1_relationship	    = (string)$worksheet->getCellByColumnAndRow(53, $i)->getValue();
                $m1_marriage_status	  = (string)$worksheet->getCellByColumnAndRow(54, $i)->getValue();
                $m1_chronic_patient	  = (string)$worksheet->getCellByColumnAndRow(55, $i)->getValue();
                $m1_special_study	    = (string)$worksheet->getCellByColumnAndRow(56, $i)->getValue();
                $m1_working_status	  = (string)$worksheet->getCellByColumnAndRow(57, $i)->getValue();
                $m1_career	          = (string)$worksheet->getCellByColumnAndRow(58, $i)->getValue();
                $m1_income	          = (string)$worksheet->getCellByColumnAndRow(59, $i)->getValue();
                $m1_funding_type_1    = (string)$worksheet->getCellByColumnAndRow(60, $i)->getValue();
                $m1_funding_type_2    = (string)$worksheet->getCellByColumnAndRow(61, $i)->getValue();
                $m1_funding_type_3    = (string)$worksheet->getCellByColumnAndRow(62, $i)->getValue();
                $m1_funding_type_4    = (string)$worksheet->getCellByColumnAndRow(63, $i)->getValue();
                $m1_funding_type_5    = (string)$worksheet->getCellByColumnAndRow(64, $i)->getValue();
                $m1_funding_type_6    = (string)$worksheet->getCellByColumnAndRow(65, $i)->getValue();
                $m1_funding_value	    = (string)$worksheet->getCellByColumnAndRow(66, $i)->getValue();
                $m1_asset	            = (string)$worksheet->getCellByColumnAndRow(67, $i)->getValue();
                $m1_asset_type	      = (string)$worksheet->getCellByColumnAndRow(68, $i)->getValue();
                $m1_asset_value	      = (string)$worksheet->getCellByColumnAndRow(69, $i)->getValue();
                $m1_deposit	          = (string)$worksheet->getCellByColumnAndRow(70, $i)->getValue();
                $m2_chi_name	        = (string)$worksheet->getCellByColumnAndRow(71, $i)->getValue();
                $m2_eng_name	        = (string)$worksheet->getCellByColumnAndRow(72, $i)->getValue();
                $m2_gender	          = (string)$worksheet->getCellByColumnAndRow(73, $i)->getValue();
                $m2_born_date	        = (string)$worksheet->getCellByColumnAndRow(74, $i)->getValue();
                $m2_id_type	          = (string)$worksheet->getCellByColumnAndRow(75, $i)->getValue();
                $m2_id_no	            = (string)$worksheet->getCellByColumnAndRow(76, $i)->getValue();
                $m2_relationship	    = (string)$worksheet->getCellByColumnAndRow(77, $i)->getValue();
                $m2_marriage_status	  = (string)$worksheet->getCellByColumnAndRow(78, $i)->getValue();
                $m2_chronic_patient	  = (string)$worksheet->getCellByColumnAndRow(79, $i)->getValue();
                $m2_special_study	    = (string)$worksheet->getCellByColumnAndRow(80, $i)->getValue();
                $m2_working_status	  = (string)$worksheet->getCellByColumnAndRow(81, $i)->getValue();
                $m2_career	          = (string)$worksheet->getCellByColumnAndRow(82, $i)->getValue();
                $m2_income	          = (string)$worksheet->getCellByColumnAndRow(83, $i)->getValue();
                $m2_funding_type_1    = (string)$worksheet->getCellByColumnAndRow(84, $i)->getValue();
                $m2_funding_type_2    = (string)$worksheet->getCellByColumnAndRow(85, $i)->getValue();
                $m2_funding_type_3    = (string)$worksheet->getCellByColumnAndRow(86, $i)->getValue();
                $m2_funding_type_4    = (string)$worksheet->getCellByColumnAndRow(87, $i)->getValue();
                $m2_funding_type_5    = (string)$worksheet->getCellByColumnAndRow(88, $i)->getValue();
                $m2_funding_type_6    = (string)$worksheet->getCellByColumnAndRow(89, $i)->getValue();
                $m2_funding_value	    = (string)$worksheet->getCellByColumnAndRow(90, $i)->getValue();
                $m2_asset	            = (string)$worksheet->getCellByColumnAndRow(91, $i)->getValue();
                $m2_asset_type	      = (string)$worksheet->getCellByColumnAndRow(92, $i)->getValue();
                $m2_asset_value	      = (string)$worksheet->getCellByColumnAndRow(93, $i)->getValue();
                $m2_deposit	          = (string)$worksheet->getCellByColumnAndRow(94, $i)->getValue();
                $m3_chi_name	        = (string)$worksheet->getCellByColumnAndRow(95, $i)->getValue();
                $m3_eng_name	        = (string)$worksheet->getCellByColumnAndRow(96, $i)->getValue();
                $m3_gender	          = (string)$worksheet->getCellByColumnAndRow(97, $i)->getValue();
                $m3_born_date	        = (string)$worksheet->getCellByColumnAndRow(98, $i)->getValue();
                $m3_id_type	          = (string)$worksheet->getCellByColumnAndRow(99, $i)->getValue();
                $m3_id_no	            = (string)$worksheet->getCellByColumnAndRow(100, $i)->getValue();
                $m3_relationship	    = (string)$worksheet->getCellByColumnAndRow(101, $i)->getValue();
                $m3_marriage_status	  = (string)$worksheet->getCellByColumnAndRow(102, $i)->getValue();
                $m3_chronic_patient	  = (string)$worksheet->getCellByColumnAndRow(103, $i)->getValue();
                $m3_special_study	    = (string)$worksheet->getCellByColumnAndRow(104, $i)->getValue();
                $m3_working_status	  = (string)$worksheet->getCellByColumnAndRow(105, $i)->getValue();
                $m3_career	          = (string)$worksheet->getCellByColumnAndRow(106, $i)->getValue();
                $m3_income	          = (string)$worksheet->getCellByColumnAndRow(107, $i)->getValue();
                $m3_funding_type_1    = (string)$worksheet->getCellByColumnAndRow(108, $i)->getValue();
                $m3_funding_type_2    = (string)$worksheet->getCellByColumnAndRow(109, $i)->getValue();
                $m3_funding_type_3    = (string)$worksheet->getCellByColumnAndRow(110, $i)->getValue();
                $m3_funding_type_4    = (string)$worksheet->getCellByColumnAndRow(111, $i)->getValue();
                $m3_funding_type_5    = (string)$worksheet->getCellByColumnAndRow(112, $i)->getValue();
                $m3_funding_type_6    = (string)$worksheet->getCellByColumnAndRow(113, $i)->getValue();
                $m3_funding_value	    = (string)$worksheet->getCellByColumnAndRow(114, $i)->getValue();
                $m3_asset	            = (string)$worksheet->getCellByColumnAndRow(115, $i)->getValue();
                $m3_asset_type	      = (string)$worksheet->getCellByColumnAndRow(116, $i)->getValue();
                $m3_asset_value	      = (string)$worksheet->getCellByColumnAndRow(117, $i)->getValue();
                $m3_deposit	          = (string)$worksheet->getCellByColumnAndRow(118, $i)->getValue();
                $m4_chi_name	        = (string)$worksheet->getCellByColumnAndRow(119, $i)->getValue();
                $m4_eng_name	        = (string)$worksheet->getCellByColumnAndRow(120, $i)->getValue();
                $m4_gender	          = (string)$worksheet->getCellByColumnAndRow(121, $i)->getValue();
                $m4_born_date	        = (string)$worksheet->getCellByColumnAndRow(122, $i)->getValue();
                $m4_id_type	          = (string)$worksheet->getCellByColumnAndRow(123, $i)->getValue();
                $m4_id_no	            = (string)$worksheet->getCellByColumnAndRow(124, $i)->getValue();
                $m4_relationship	    = (string)$worksheet->getCellByColumnAndRow(125, $i)->getValue();
                $m4_marriage_status	  = (string)$worksheet->getCellByColumnAndRow(126, $i)->getValue();
                $m4_chronic_patient	  = (string)$worksheet->getCellByColumnAndRow(127, $i)->getValue();
                $m4_special_study	    = (string)$worksheet->getCellByColumnAndRow(128, $i)->getValue();
                $m4_working_status	  = (string)$worksheet->getCellByColumnAndRow(129, $i)->getValue();
                $m4_career          	= (string)$worksheet->getCellByColumnAndRow(130, $i)->getValue();
                $m4_income          	= (string)$worksheet->getCellByColumnAndRow(131, $i)->getValue();
                $m4_funding_type_1    = (string)$worksheet->getCellByColumnAndRow(132, $i)->getValue();
                $m4_funding_type_2    = (string)$worksheet->getCellByColumnAndRow(133, $i)->getValue();
                $m4_funding_type_3    = (string)$worksheet->getCellByColumnAndRow(134, $i)->getValue();
                $m4_funding_type_4    = (string)$worksheet->getCellByColumnAndRow(135, $i)->getValue();
                $m4_funding_type_5    = (string)$worksheet->getCellByColumnAndRow(136, $i)->getValue();
                $m4_funding_type_6    = (string)$worksheet->getCellByColumnAndRow(137, $i)->getValue();
                $m4_funding_value	    = (string)$worksheet->getCellByColumnAndRow(138, $i)->getValue();
                $m4_asset	            = (string)$worksheet->getCellByColumnAndRow(139, $i)->getValue();
                $m4_asset_type	      = (string)$worksheet->getCellByColumnAndRow(140, $i)->getValue();
                $m4_asset_value	      = (string)$worksheet->getCellByColumnAndRow(141, $i)->getValue();
                $m4_deposit	          = (string)$worksheet->getCellByColumnAndRow(142, $i)->getValue();
                $m5_chi_name	        = (string)$worksheet->getCellByColumnAndRow(143, $i)->getValue();
                $m5_eng_name	        = (string)$worksheet->getCellByColumnAndRow(144, $i)->getValue();
                $m5_gender	          = (string)$worksheet->getCellByColumnAndRow(145, $i)->getValue();
                $m5_born_date	        = (string)$worksheet->getCellByColumnAndRow(146, $i)->getValue();
                $m5_id_type	          = (string)$worksheet->getCellByColumnAndRow(147, $i)->getValue();
                $m5_id_no	            = (string)$worksheet->getCellByColumnAndRow(148, $i)->getValue();
                $m5_relationship	    = (string)$worksheet->getCellByColumnAndRow(149, $i)->getValue();
                $m5_marriage_status	  = (string)$worksheet->getCellByColumnAndRow(150, $i)->getValue();
                $m5_chronic_patient	  = (string)$worksheet->getCellByColumnAndRow(151, $i)->getValue();
                $m5_special_study	    = (string)$worksheet->getCellByColumnAndRow(152, $i)->getValue();
                $m5_working_status	  = (string)$worksheet->getCellByColumnAndRow(153, $i)->getValue();
                $m5_career	          = (string)$worksheet->getCellByColumnAndRow(154, $i)->getValue();
                $m5_income	          = (string)$worksheet->getCellByColumnAndRow(155, $i)->getValue();
                $m5_funding_type_1    = (string)$worksheet->getCellByColumnAndRow(156, $i)->getValue();
                $m5_funding_type_2    = (string)$worksheet->getCellByColumnAndRow(157, $i)->getValue();
                $m5_funding_type_3    = (string)$worksheet->getCellByColumnAndRow(158, $i)->getValue();
                $m5_funding_type_4    = (string)$worksheet->getCellByColumnAndRow(159, $i)->getValue();
                $m5_funding_type_5    = (string)$worksheet->getCellByColumnAndRow(160, $i)->getValue();
                $m5_funding_type_6    = (string)$worksheet->getCellByColumnAndRow(161, $i)->getValue();
                $m5_funding_value	    = (string)$worksheet->getCellByColumnAndRow(162, $i)->getValue();
                $m5_asset	            = (string)$worksheet->getCellByColumnAndRow(163, $i)->getValue();
                $m5_asset_type	      = (string)$worksheet->getCellByColumnAndRow(164, $i)->getValue();
                $m5_asset_value	      = (string)$worksheet->getCellByColumnAndRow(165, $i)->getValue();
                $m5_deposit	          = (string)$worksheet->getCellByColumnAndRow(166, $i)->getValue();
                $single_parents	      = (string)$worksheet->getCellByColumnAndRow(167, $i)->getValue();
                $pregnant	            = (string)$worksheet->getCellByColumnAndRow(168, $i)->getValue();
                $pregnant_period	    = (string)$worksheet->getCellByColumnAndRow(169, $i)->getValue();
                $total_income	        = (string)$worksheet->getCellByColumnAndRow(170, $i)->getValue();
                $total_funding	      = (string)$worksheet->getCellByColumnAndRow(171, $i)->getValue();
                $total_asset	        = (string)$worksheet->getCellByColumnAndRow(172, $i)->getValue();
                $social_worker_name	  = (string)$worksheet->getCellByColumnAndRow(173, $i)->getValue();
                $social_worker_phone  = (string)$worksheet->getCellByColumnAndRow(174, $i)->getValue();
                $social_worker_email  = (string)$worksheet->getCellByColumnAndRow(175, $i)->getValue();

                $project_model_1 = PageType12::findOne(['title_tw' => trim($priority_1)]);
                $priority_1 = $project_model_1 ? $project_model_1->id : '';

                $project_model_2 = PageType12::findOne(['title_tw' => trim($priority_2)]);
                $priority_2 = $project_model_2 ? $project_model_2->id : '';

                $project_model_3 = PageType12::findOne(['title_tw' => trim($priority_3)]);
                $priority_3 = $project_model_3 ? $project_model_3->id : '';

                $house_type           = $this->convertToKey($house_type, Definitions::getHouseType());
                $private_type         = $this->convertToKey($private_type, Definitions::getPrivateType());
                $together_type        = $this->convertToKey($together_type, Definitions::getTogetherType());
                $live_year            = $this->convertToKey($live_year, Definitions::getLiveYear());
                $live_month           = $this->convertToKey($live_month, Definitions::getLiveMonth());
                $prh                  = $this->convertToKey($prh, Definitions::getPrh());
                $prh_location         = $this->convertToKey($prh_location, Definitions::getPrhLocation());
                $app_gender           = $this->convertToKey($app_gender, Definitions::getGender());
                $app_id_type          = $this->convertToKey($app_id_type, Definitions::getIdType());
                $app_marriage_status  = $this->convertToKey($app_marriage_status, Definitions::getMarriageStatus());
                $app_working_status   = $this->convertToKey($app_working_status, Definitions::getWorkingStatus());

                $app_funding_type_1   = $this->convertToKey($app_funding_type_1, Definitions::getFundingType2());
                $app_funding_type_2   = $this->convertToKey($app_funding_type_2, Definitions::getFundingType2());
                $app_funding_type_3   = $this->convertToKey($app_funding_type_3, Definitions::getFundingType2());
                $app_funding_type_4   = $this->convertToKey($app_funding_type_4, Definitions::getFundingType2());
                $app_funding_type_5   = $this->convertToKey($app_funding_type_5, Definitions::getFundingType2());
                $app_funding_type_6   = $this->convertToKey($app_funding_type_6, Definitions::getFundingType2());

                $app_funding_type = [];
                if ($app_funding_type_1 == 1) array_push($app_funding_type, Definitions::getFundingType(1));
                if ($app_funding_type_2 == 1) array_push($app_funding_type, Definitions::getFundingType(2));
                if ($app_funding_type_3 == 1) array_push($app_funding_type, Definitions::getFundingType(3));
                if ($app_funding_type_4 == 1) array_push($app_funding_type, Definitions::getFundingType(4));
                if ($app_funding_type_5 == 1) array_push($app_funding_type, Definitions::getFundingType(5));
                if ($app_funding_type_6 == 1) array_push($app_funding_type, Definitions::getFundingType(6));
                $app_funding_type = implode(',', $app_funding_type);

                $app_funding_types    = $this->convertToArray($app_funding_type, Definitions::getFundingType());

                $app_asset            = $this->convertToKey($app_asset, Definitions::getAsset());
                $m1_gender            = $this->convertToKey($m1_gender, Definitions::getGender());
                $m1_id_type           = $this->convertToKey($m1_id_type, Definitions::getIdType());
                $m1_marriage_status   = $this->convertToKey($m1_marriage_status, Definitions::getMarriageStatus());
                $m1_special_study     = $this->convertToKey($m1_special_study, [0 => '否', 1 => '是']);
                $m1_working_status    = $this->convertToKey($m1_working_status, Definitions::getWorkingStatus());

                $m1_funding_type_1   = $this->convertToKey($m1_funding_type_1, Definitions::getFundingType2());
                $m1_funding_type_2   = $this->convertToKey($m1_funding_type_2, Definitions::getFundingType2());
                $m1_funding_type_3   = $this->convertToKey($m1_funding_type_3, Definitions::getFundingType2());
                $m1_funding_type_4   = $this->convertToKey($m1_funding_type_4, Definitions::getFundingType2());
                $m1_funding_type_5   = $this->convertToKey($m1_funding_type_5, Definitions::getFundingType2());
                $m1_funding_type_6   = $this->convertToKey($m1_funding_type_6, Definitions::getFundingType2());

                $m1_funding_type = [];
                if ($m1_funding_type_1 == 1) array_push($m1_funding_type, Definitions::getFundingType(1));
                if ($m1_funding_type_2 == 1) array_push($m1_funding_type, Definitions::getFundingType(2));
                if ($m1_funding_type_3 == 1) array_push($m1_funding_type, Definitions::getFundingType(3));
                if ($m1_funding_type_4 == 1) array_push($m1_funding_type, Definitions::getFundingType(4));
                if ($m1_funding_type_5 == 1) array_push($m1_funding_type, Definitions::getFundingType(5));
                if ($m1_funding_type_6 == 1) array_push($m1_funding_type, Definitions::getFundingType(6));
                $m1_funding_type = implode(',', $m1_funding_type);

                $m1_funding_types     = $this->convertToArray($m1_funding_type, Definitions::getFundingType());

                $m1_asset             = $this->convertToKey($m1_asset, Definitions::getAsset());
                $m2_gender            = $this->convertToKey($m2_gender, Definitions::getGender());
                $m2_id_type           = $this->convertToKey($m2_id_type, Definitions::getIdType());
                $m2_marriage_status   = $this->convertToKey($m2_marriage_status, Definitions::getMarriageStatus());
                $m2_special_study     = $this->convertToKey($m2_special_study, [0 => '否', 1 => '是']);
                $m2_working_status    = $this->convertToKey($m2_working_status, Definitions::getWorkingStatus());

                $m2_funding_type_2   = $this->convertToKey($m2_funding_type_2, Definitions::getFundingType2());
                $m2_funding_type_3   = $this->convertToKey($m2_funding_type_3, Definitions::getFundingType2());
                $m2_funding_type_4   = $this->convertToKey($m2_funding_type_4, Definitions::getFundingType2());
                $m2_funding_type_5   = $this->convertToKey($m2_funding_type_5, Definitions::getFundingType2());
                $m2_funding_type_6   = $this->convertToKey($m2_funding_type_6, Definitions::getFundingType2());

                $m2_funding_type = [];
                if ($m2_funding_type_1 == 1) array_push($m2_funding_type, Definitions::getFundingType(1));
                if ($m2_funding_type_2 == 1) array_push($m2_funding_type, Definitions::getFundingType(2));
                if ($m2_funding_type_3 == 1) array_push($m2_funding_type, Definitions::getFundingType(3));
                if ($m2_funding_type_4 == 1) array_push($m2_funding_type, Definitions::getFundingType(4));
                if ($m2_funding_type_5 == 1) array_push($m2_funding_type, Definitions::getFundingType(5));
                if ($m2_funding_type_6 == 1) array_push($m2_funding_type, Definitions::getFundingType(6));
                $m2_funding_type = implode(',', $m2_funding_type);

                $m2_funding_types     = $this->convertToArray($m2_funding_type, Definitions::getFundingType());

                $m2_asset             = $this->convertToKey($m2_asset, Definitions::getAsset());
                $m3_gender            = $this->convertToKey($m3_gender, Definitions::getGender());
                $m3_id_type           = $this->convertToKey($m3_id_type, Definitions::getIdType());
                $m3_marriage_status   = $this->convertToKey($m3_marriage_status, Definitions::getMarriageStatus());
                $m3_special_study     = $this->convertToKey($m3_special_study, [0 => '否', 1 => '是']);
                $m3_working_status    = $this->convertToKey($m3_working_status, Definitions::getWorkingStatus());

                $m3_funding_type_1   = $this->convertToKey($m3_funding_type_1, Definitions::getFundingType2());
                $m3_funding_type_2   = $this->convertToKey($m3_funding_type_2, Definitions::getFundingType2());
                $m3_funding_type_3   = $this->convertToKey($m3_funding_type_3, Definitions::getFundingType2());
                $m3_funding_type_4   = $this->convertToKey($m3_funding_type_4, Definitions::getFundingType2());
                $m3_funding_type_5   = $this->convertToKey($m3_funding_type_5, Definitions::getFundingType2());
                $m3_funding_type_6   = $this->convertToKey($m3_funding_type_6, Definitions::getFundingType2());

                $m3_funding_type = [];
                if ($m3_funding_type_1 == 1) array_push($m3_funding_type, Definitions::getFundingType(1));
                if ($m3_funding_type_2 == 1) array_push($m3_funding_type, Definitions::getFundingType(2));
                if ($m3_funding_type_3 == 1) array_push($m3_funding_type, Definitions::getFundingType(3));
                if ($m3_funding_type_4 == 1) array_push($m3_funding_type, Definitions::getFundingType(4));
                if ($m3_funding_type_5 == 1) array_push($m3_funding_type, Definitions::getFundingType(5));
                if ($m3_funding_type_6 == 1) array_push($m3_funding_type, Definitions::getFundingType(6));
                $m3_funding_type = implode(',', $m3_funding_type);

                $m3_funding_types     = $this->convertToArray($m3_funding_type, Definitions::getFundingType());

                $m3_asset             = $this->convertToKey($m3_asset, Definitions::getAsset());
                $m4_gender            = $this->convertToKey($m4_gender, Definitions::getGender());
                $m4_id_type           = $this->convertToKey($m4_id_type, Definitions::getIdType());
                $m4_marriage_status   = $this->convertToKey($m4_marriage_status, Definitions::getMarriageStatus());
                $m4_special_study     = $this->convertToKey($m4_special_study, [0 => '否', 1 => '是']);
                $m4_working_status    = $this->convertToKey($m4_working_status, Definitions::getWorkingStatus());

                $m4_funding_type_1   = $this->convertToKey($m4_funding_type_1, Definitions::getFundingType2());
                $m4_funding_type_2   = $this->convertToKey($m4_funding_type_2, Definitions::getFundingType2());
                $m4_funding_type_3   = $this->convertToKey($m4_funding_type_3, Definitions::getFundingType2());
                $m4_funding_type_4   = $this->convertToKey($m4_funding_type_4, Definitions::getFundingType2());
                $m4_funding_type_5   = $this->convertToKey($m4_funding_type_5, Definitions::getFundingType2());
                $m4_funding_type_6   = $this->convertToKey($m4_funding_type_6, Definitions::getFundingType2());

                $m4_funding_type = [];
                if ($m4_funding_type_1 == 1) array_push($m4_funding_type, Definitions::getFundingType(1));
                if ($m4_funding_type_2 == 1) array_push($m4_funding_type, Definitions::getFundingType(2));
                if ($m4_funding_type_3 == 1) array_push($m4_funding_type, Definitions::getFundingType(3));
                if ($m4_funding_type_4 == 1) array_push($m4_funding_type, Definitions::getFundingType(4));
                if ($m4_funding_type_5 == 1) array_push($m4_funding_type, Definitions::getFundingType(5));
                if ($m4_funding_type_6 == 1) array_push($m4_funding_type, Definitions::getFundingType(6));
                $m4_funding_type = implode(',', $m4_funding_type);

                $m4_funding_types     = $this->convertToArray($m4_funding_type, Definitions::getFundingType());

                $m4_asset             = $this->convertToKey($m4_asset, Definitions::getAsset());
                $m5_gender            = $this->convertToKey($m5_gender, Definitions::getGender());
                $m5_id_type           = $this->convertToKey($m5_id_type, Definitions::getIdType());
                $m5_marriage_status   = $this->convertToKey($m5_marriage_status, Definitions::getMarriageStatus());
                $m5_special_study     = $this->convertToKey($m5_special_study, [0 => '否', 1 => '是']);
                $m5_working_status    = $this->convertToKey($m5_working_status, Definitions::getWorkingStatus());

                $m5_funding_type_1   = $this->convertToKey($m5_funding_type_1, Definitions::getFundingType2());
                $m5_funding_type_2   = $this->convertToKey($m5_funding_type_2, Definitions::getFundingType2());
                $m5_funding_type_3   = $this->convertToKey($m5_funding_type_3, Definitions::getFundingType2());
                $m5_funding_type_4   = $this->convertToKey($m5_funding_type_4, Definitions::getFundingType2());
                $m5_funding_type_5   = $this->convertToKey($m5_funding_type_5, Definitions::getFundingType2());
                $m5_funding_type_6   = $this->convertToKey($m5_funding_type_6, Definitions::getFundingType2());

                $m5_funding_type = [];
                if ($m5_funding_type_1 == 1) array_push($m5_funding_type, Definitions::getFundingType(1));
                if ($m5_funding_type_2 == 1) array_push($m5_funding_type, Definitions::getFundingType(2));
                if ($m5_funding_type_3 == 1) array_push($m5_funding_type, Definitions::getFundingType(3));
                if ($m5_funding_type_4 == 1) array_push($m5_funding_type, Definitions::getFundingType(4));
                if ($m5_funding_type_5 == 1) array_push($m5_funding_type, Definitions::getFundingType(5));
                if ($m5_funding_type_6 == 1) array_push($m5_funding_type, Definitions::getFundingType(6));
                $m5_funding_type = implode(',', $m5_funding_type);

                $m5_funding_types     = $this->convertToArray($m5_funding_type, Definitions::getFundingType());

                $m5_asset             = $this->convertToKey($m5_asset, Definitions::getAsset());
                $single_parents       = $this->convertToKey($single_parents, Definitions::getSingleParents());
                $pregnant             = $this->convertToKey($pregnant, Definitions::getPregnant());


                
//$start_date = str_replace('/', '-', $start_date);
//echo $start_date.'<br />';
//echo date('Y-m-d', strtotime($start_date));
//exit();

                if ($type == 'edit') {
                  $user_model = User::findOne(['id' => $application_model->user_id]);
                } else {
                  $check_user_model = User::findOne(['mobile' => $mobile]);

                  if (!$check_user_model) {
                    $user_model = new User;

                    $user_model->chi_name = $chi_name;
                    $user_model->eng_name = $eng_name;
                    $user_model->mobile = $mobile;
                    $user_model->status = $user_model::STATUS_ACTIVE;
                    $user_model->role = $user_model::ROLE_MEMBER;
                    $user_model->password_hash = '$2y$13$Kp71i/AcmLWAZwhgK4T7l.u1S3gc2QvqQis0KpHT2LSngdQNqZkDm'; // LSThousing2022
                    $user_model->user_appl_status = $user_model::USER_APPL_STATUS_UNALLOCATE_UNIT;
                  } else {
                    $user_model = $check_user_model;
                  }


                  $application_model = new ApplicationForm;
                }

                $application_model->appl_no              = $appl_no;
                $application_model->priority_1           = $priority_1;
                $application_model->priority_2           = $priority_2;
                $application_model->priority_3           = $priority_3;
                $application_model->chi_name             = $chi_name;
                $application_model->eng_name             = $eng_name;
                $application_model->phone                = $phone;
                $application_model->mobile               = $mobile;
                $application_model->address              = $address;
                $application_model->area                 = $area;
                $application_model->email                = $email;
                $application_model->house_type           = $house_type;
                $application_model->house_type_other     = $house_type_other;
                $application_model->private_type         = $private_type;
                $application_model->together_type        = $together_type;
                $application_model->together_type_other  = $together_type_other;
                $application_model->live_rent            = $live_rent;
                $application_model->live_year            = $live_year;
                $application_model->live_month           = $live_month;
                $application_model->family_member        = $family_member;
                $application_model->prh                  = $prh;
                $application_model->prh_no               = $prh_no;
                $application_model->prh_location         = $prh_location;
                $application_model->apply_prh_year       = $apply_prh_year;
                $application_model->apply_prh_month      = $apply_prh_month;
                $application_model->apply_prh_day        = $apply_prh_day;
                $application_model->app_gender           = $app_gender;
                $application_model->app_born_date        = $app_born_date;
                $application_model->app_id_type          = $app_id_type;
                $application_model->app_id_no            = $app_id_no;
                $application_model->app_marriage_status  = $app_marriage_status;
                $application_model->app_chronic_patient  = $app_chronic_patient;
                $application_model->app_working_status   = $app_working_status;
                $application_model->app_career           = $app_career;
                $application_model->app_income           = $app_income;
                $application_model->app_funding_type     = $app_funding_types;
                $application_model->app_funding_value    = $app_funding_value;
                $application_model->app_asset            = $app_asset;
                $application_model->app_asset_type       = $app_asset_type;
                $application_model->app_asset_value      = $app_asset_value;
                $application_model->app_deposit          = $app_deposit;
                $application_model->m1_chi_name          = $m1_chi_name;
                $application_model->m1_eng_name          = $m1_eng_name;
                $application_model->m1_gender            = $m1_gender;
                $application_model->m1_born_date         = $m1_born_date;
                $application_model->m1_id_type           = $m1_id_type;
                $application_model->m1_id_no             = $m1_id_no;
                $application_model->m1_relationship      = $m1_relationship;
                $application_model->m1_marriage_status   = $m1_marriage_status;
                $application_model->m1_chronic_patient   = $m1_chronic_patient;
                $application_model->m1_special_study     = $m1_special_study;
                $application_model->m1_working_status    = $m1_working_status;
                $application_model->m1_career            = $m1_career;
                $application_model->m1_income            = $m1_income;
                $application_model->m1_funding_type      = $m1_funding_types;
                $application_model->m1_funding_value     = $m1_funding_value;
                $application_model->m1_asset             = $m1_asset;
                $application_model->m1_asset_type        = $m1_asset_type;
                $application_model->m1_asset_value       = $m1_asset_value;
                $application_model->m1_deposit           = $m1_deposit;
                $application_model->m2_chi_name          = $m2_chi_name;
                $application_model->m2_eng_name          = $m2_eng_name;
                $application_model->m2_gender            = $m2_gender;
                $application_model->m2_born_date         = $m2_born_date;
                $application_model->m2_id_type           = $m2_id_type;
                $application_model->m2_id_no             = $m2_id_no;
                $application_model->m2_relationship      = $m2_relationship;
                $application_model->m2_marriage_status   = $m2_marriage_status;
                $application_model->m2_chronic_patient   = $m2_chronic_patient;
                $application_model->m2_special_study     = $m2_special_study;
                $application_model->m2_working_status    = $m2_working_status;
                $application_model->m2_career            = $m2_career;
                $application_model->m2_income            = $m2_income;
                $application_model->m2_funding_type      = $m2_funding_types;
                $application_model->m2_funding_value     = $m2_funding_value;
                $application_model->m2_asset             = $m2_asset;
                $application_model->m2_asset_type        = $m2_asset_type;
                $application_model->m2_asset_value       = $m2_asset_value;
                $application_model->m2_deposit           = $m2_deposit;
                $application_model->m3_chi_name          = $m3_chi_name;
                $application_model->m3_eng_name          = $m3_eng_name;
                $application_model->m3_gender            = $m3_gender;
                $application_model->m3_born_date         = $m3_born_date;
                $application_model->m3_id_type           = $m3_id_type;
                $application_model->m3_id_no             = $m3_id_no;
                $application_model->m3_relationship      = $m3_relationship;
                $application_model->m3_marriage_status   = $m3_marriage_status;
                $application_model->m3_chronic_patient   = $m3_chronic_patient;
                $application_model->m3_special_study     = $m3_special_study;
                $application_model->m3_working_status    = $m3_working_status;
                $application_model->m3_career            = $m3_career;
                $application_model->m3_income            = $m3_income;
                $application_model->m3_funding_type      = $m3_funding_types;
                $application_model->m3_funding_value     = $m3_funding_value;
                $application_model->m3_asset             = $m3_asset;
                $application_model->m3_asset_type        = $m3_asset_type;
                $application_model->m3_asset_value       = $m3_asset_value;
                $application_model->m3_deposit           = $m3_deposit;
                $application_model->m4_chi_name          = $m4_chi_name;
                $application_model->m4_eng_name          = $m4_eng_name;
                $application_model->m4_gender            = $m4_gender;
                $application_model->m4_born_date         = $m4_born_date;
                $application_model->m4_id_type           = $m4_id_type;
                $application_model->m4_id_no             = $m4_id_no;
                $application_model->m4_relationship      = $m4_relationship;
                $application_model->m4_marriage_status   = $m4_marriage_status;
                $application_model->m4_chronic_patient   = $m4_chronic_patient;
                $application_model->m4_special_study     = $m4_special_study;
                $application_model->m4_working_status    = $m4_working_status;
                $application_model->m4_career            = $m4_career;
                $application_model->m4_income            = $m4_income;
                $application_model->m4_funding_type      = $m4_funding_types;
                $application_model->m4_funding_value     = $m4_funding_value;
                $application_model->m4_asset             = $m4_asset;
                $application_model->m4_asset_type        = $m4_asset_type;
                $application_model->m4_asset_value       = $m4_asset_value;
                $application_model->m4_deposit           = $m4_deposit;
                $application_model->m5_chi_name          = $m5_chi_name;
                $application_model->m5_eng_name          = $m5_eng_name;
                $application_model->m5_gender            = $m5_gender;
                $application_model->m5_born_date         = $m5_born_date;
                $application_model->m5_id_type           = $m5_id_type;
                $application_model->m5_id_no             = $m5_id_no;
                $application_model->m5_relationship      = $m5_relationship;
                $application_model->m5_marriage_status   = $m5_marriage_status;
                $application_model->m5_chronic_patient   = $m5_chronic_patient;
                $application_model->m5_special_study     = $m5_special_study;
                $application_model->m5_working_status    = $m5_working_status;
                $application_model->m5_career            = $m5_career;
                $application_model->m5_income            = $m5_income;
                $application_model->m5_funding_type      = $m5_funding_types;
                $application_model->m5_funding_value     = $m5_funding_value;
                $application_model->m5_asset             = $m5_asset;
                $application_model->m5_asset_type        = $m5_asset_type;
                $application_model->m5_asset_value       = $m5_asset_value;
                $application_model->m5_deposit           = $m5_deposit;
                $application_model->single_parents       = $single_parents;
                $application_model->pregnant             = $pregnant;
                $application_model->pregnant_period      = $pregnant_period;
                $application_model->total_income         = $total_income;
                $application_model->total_funding        = $total_funding;
                $application_model->total_asset          = $total_asset;
                $application_model->social_worker_name   = $social_worker_name;
                $application_model->social_worker_phone  = $social_worker_phone;
                $application_model->social_worker_email  = $social_worker_email;

                $application_model->application_status = $application_model::APPL_STATUS_SUBMITED_FORM;

                // echo '<pre>';
                // print_r($application_model);
                // echo '</pre>';
                // exit();

                if ($type == 'edit') {
                  $application_model->user_id = $user_model->id;
                }

                if (!$application_model->validate()) {
                  $this->error_excel[$i] = $application_model;
                  $fail = 1;
                }
                  
   							array_push($user_model_array, $user_model);
   							array_push($application_model_array, $application_model);

   							$user_model->detachBehaviors(); // PHP < 5.3 memory management
   							unset($user_model);
   							$application_model->detachBehaviors(); // PHP < 5.3 memory management
   							unset($application_model);
   						}
   					}
          }
          if ($fail === 0) {
            foreach($user_model_array as $k => $user_model){
              if ($type == 'create') {
                $check_user_model2 = User::findOne(['mobile' => $user_model->mobile]);

                if (!$check_user_model2) {
                  $user_model->save(false);

                  $no_of_zero = $user_model::APP_NO_LENGTH - strlen($user_model->id);
                  $user_model->app_no = str_pad($user_model::APP_NO_PREFIX, $no_of_zero, '0').$user_model->id;

                  $user_model->updateAttributes(['app_no']);
                }
              
                $application_model_array[$k]->user_id = $user_model->id;
              }
            }
            
            foreach($application_model_array as $application_model){
              $application_model->save(false);
              
              if ($type == 'create') {
                if ($application_model->appl_no == '') {
                  $no_of_zero = $application_model::APPL_NO_LENGTH - strlen($application_model->id);
                  $application_model->appl_no = str_pad($application_model::APPL_NO_PREFIX, $no_of_zero, '0').$application_model->id;

                  // $application_model->save(false);
                  $application_model->updateAttributes(['appl_no']);
                }
              
                // $application_mark_model = new ApplicationMark;
                // $application_mark_model->application_id = $application_model->id;
                // $application_mark_model->save(false);

                $application_model->afterFind();
                $application_model->setApplicationMark();

                // $application_model->sendSubmittedEmail(1);
              }
            }            
          }
        }
      }
    }

    public function convertToKey ($data, $arr)
    {
      $valid = false;

      foreach ($arr as $k => $v) {
        if ($data == $v) {
          $data = $k;
          $valid = true;
        }
      }

      $data = $valid ? $data : NULL;

      return $data;
    }

    public function convertToArray ($data, $arr)
    {
      $datum = explode(',', $data);
                
      foreach ($datum as $k => $v) {
        $valid = false;
        $data = trim($v);

        foreach ($arr as $k2 => $v2) {
          if ($data == $v2) {
            $datum[$k] = (string)$k2;
            $valid = true;
          }
        }

        if (!$valid) array_splice($datum, $k, 1);
      }

      return $datum;
    }
}
