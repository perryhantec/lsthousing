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
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * LoginLogSearch represents the model behind the search form about `common\models\LoginLog`.
 */
class ApplicationImport extends Model
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
          // $rental_payment_model_array = [];

   				if($highestRow>=2){
            $fail = 0;
   					for ($i=2; $i<=$highestRow; $i++)
   					{
   						$empty_line=true;
   						for ($j=0; $j<$highestColumnIndex; $j++){
   							$empty_line=$empty_line && ($worksheet->getCellByColumnAndRow($j, $i)->getValue()==NULL);
   						}

   						if(!$empty_line){
                $appl_no     = (string)$worksheet->getCellByColumnAndRow(1, $i)->getValue();
                $appl_no     = trim($appl_no);

                $application_model = Application::findOne(['appl_no' => $appl_no]);
                
                if ($application_model) {
                  $type = 'edit';
                } else {
                  $type = 'create';
                }
                
                $project         = (string)$worksheet->getCellByColumnAndRow(2, $i)->getValue();
                
                $project_model = PageType12::findOne(['title_tw' => trim($project)]);
                $project = $project_model ? $project_model->id : '';
                
                $room_no        = (string)$worksheet->getCellByColumnAndRow(3, $i)->getValue();
                $chi_name       = (string)$worksheet->getCellByColumnAndRow(4, $i)->getValue();
                $eng_name       = (string)$worksheet->getCellByColumnAndRow(5, $i)->getValue();
                $mobile         = (string)$worksheet->getCellByColumnAndRow(6, $i)->getValue();
                $start_date     = (string)$worksheet->getCellByColumnAndRow(7, $i)->getValue();
                // $payment_year   = (string)$worksheet->getCellByColumnAndRow(6, $i)->getValue();
                // $payment_month  = (string)$worksheet->getCellByColumnAndRow(7, $i)->getValue();
                // $start_date     = (string)$worksheet->getCellByColumnAndRow(8, $i)->getValue();

//$start_date = str_replace('/', '-', $start_date);
//echo $start_date.'<br />';
//echo date('Y-m-d', strtotime($start_date));
//exit();

                if ($type == 'edit') {
                  $user_model = User::findOne(['id' => $application_model->user_id]);
                  // $rental_payment_model = RentalPayment::findOne(['user_id' => $user_model->id]);
                } else {
                  $check_user_model = User::findOne(['mobile' => $mobile]);

                  if (!$check_user_model) {
                    $user_model = new User;
                    // $rental_payment_model = new RentalPayment;

                    $user_model->chi_name = $chi_name;
                    $user_model->eng_name = $eng_name;
                    $user_model->mobile = $mobile;
                    $user_model->room_no = $room_no;
                    $user_model->start_date = (string)$start_date;
                    $user_model->status = $user_model::STATUS_ACTIVE;
                    $user_model->role = $user_model::ROLE_MEMBER;
                    $user_model->password_hash = '$2y$13$Kp71i/AcmLWAZwhgK4T7l.u1S3gc2QvqQis0KpHT2LSngdQNqZkDm'; // LSThousing2022
                    $user_model->user_appl_status = $user_model::USER_APPL_STATUS_ALLOCATED_UNIT;
                  } else {
                    $user_model = $check_user_model;
                  }

                  $application_model = new Application;
                }
                
                $application_model->appl_no = $appl_no;
                $application_model->project = $project;
                $application_model->room_no = $room_no;
                $application_model->chi_name = $chi_name;
                $application_model->eng_name = $eng_name;
                $application_model->mobile = $mobile;
                $application_model->start_date = $start_date;
                $application_model->priority_1 = $project;
                $application_model->family_member = 1;
                $application_model->approved = $application_model::APPROVED;
                $application_model->application_status = $application_model::APPL_STATUS_ALLOCATED_UNIT;

                // $rental_payment_model->payment_year = $payment_year;
                // $rental_payment_model->payment_month = $payment_month;
                // $rental_payment_model->files = '[]';
                // $rental_payment_model->is_read = $rental_payment_model::IS_READ_YES;

                if ($type == 'edit') {
                  $application_model->user_id = $user_model->id;
                  // $rental_payment_model->user_id = $user_model->id;
                }

                // if (!$appl_no) {
                //   $application_model->addError('appl_no','請輸入申請編號');
                //   $this->error_excel[$i] = $application_model;
                //   $fail++;
                // }
                
                if (!$mobile) {
                  $application_model->addError('mobile','請輸入流動電話號碼');
                  $this->error_excel[$i] = $application_model;
                  $fail++;
                }
                
                // if (
                //     (int)$mobile < 40000000 ||
                //     ((int)$mobile > 69999999 && (int)$mobile < 90000000) ||
                //     (int)$mobile > 99999999
                // ) {
                //   $application_model->addError('mobile','請輸入正確流動電話號碼');
                //   $this->error_excel[$i] = $application_model;
                //   $fail++;
                // }
                
                if ($type == 'create' && User::findOne(['mobile' => $mobile])) {
                  $application_model->addError('mobile','會員已有該流動電話號碼');
                  $this->error_excel[$i] = $application_model;
                  $fail++;
                }
                
                if (!$chi_name && !$eng_name) {
                  $application_model->addError('chi_name','請輸入姓名(中文)或姓名(英文)');
                  $this->error_excel[$i] = $application_model;
                  $fail++;
                }
                  
   							array_push($user_model_array, $user_model);
   							array_push($application_model_array, $application_model);
   							// array_push($rental_payment_model_array, $rental_payment_model);

   							$user_model->detachBehaviors(); // PHP < 5.3 memory management
   							unset($user_model);
   							$application_model->detachBehaviors(); // PHP < 5.3 memory management
   							unset($application_model);
   							// $rental_payment_model->detachBehaviors(); // PHP < 5.3 memory management
   							// unset($rental_payment_model);
   						}
   					}
          }
          if($fail === 0){
            foreach($user_model_array as $k => $user_model){              
              if ($type == 'create') {
                $check_user_model2 = User::findOne(['mobile' => $user_model->mobile]);

                if (!$check_user_model2) {
                  $user_model->save(false);

                  $no_of_zero = $user_model::APP_NO_LENGTH - strlen($user_model->id);
                  $user_model->app_no = str_pad($user_model::APP_NO_PREFIX, $no_of_zero, '0').$user_model->id;

                  $user_model->updateAttributes(['app_no']);                
                }

                // $rental_payment_model_array[$k]->user_id = $user_model->id;
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
                
                $application_mark_model = new ApplicationMark;
                $application_mark_model->application_id = $application_model->id;
                $application_mark_model->save(false);
              }
            }
            
            // foreach($rental_payment_model_array as $rental_payment_model){
            //   $rental_payment_model->save(false);
            // }
          }
        }
      }
    }

}
