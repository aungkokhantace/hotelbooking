<?php

namespace App\Http\Controllers\Setup\CSVImport;

use App\Core\Utility;
use App\Setup\Country\CountryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\CsvEntryRequest;
use App\Setup\CsvImport\CsvImportRepositoryInterface;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
class CSVImportController extends Controller
{
    private $repo;

    public function __construct(CsvImportRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function import() {
        return view('backend.csv_import.index');
    }

    public function store(CsvEntryRequest $request) {
        $request->validate();
        $table_name         = Input::get('tbl_name');
        $csv                = Input::file('csv_upl');
        try {
            DB::beginTransaction();
            $handle         = fopen($csv, 'r');
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($table_name == 'amenities') {

                    $insert_val         = implode("','",$data);
                    $result             = $this->repo->createAmenities($insert_val);
                    if($result['aceplusStatusCode'] != ReturnMessage::OK){

                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }
                }
                if ($table_name == 'features') {

                    $insert_val         = implode("','",$data);
                    $result             = $this->repo->createFeatures($insert_val);
                    if($result['aceplusStatusCode'] != ReturnMessage::OK){

                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }
                }  
                //Table For facilities group
                if ($table_name == 'facility_group') {

                    $insert_val         = implode("','",$data);
                    $result             = $this->repo->createFacilityGroup($insert_val);
                    if($result['aceplusStatusCode'] != ReturnMessage::OK){

                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }
                }

                //Table For facilities
                if ($table_name == 'facilities') {
                    $facility_group_name = $data[1];
                    $facility_group      = DB::table('facility_group')->select('id')->where('name', $facility_group_name)->first();

                    if (count($facility_group) >= 1) {
                        $implode             = array();
                        //Insert Facility Group id to Facilities
                        foreach ($data as $key => $value) {
                            if ($key == 1) {
                                $implode[$key]  = $facility_group->id;
                            } else {
                                $implode[$key]  = $value;
                            }
                        }
                        $insert_val          = implode("','",$implode);
                        $result             = $this->repo->createFacility($insert_val);
                        if($result['aceplusStatusCode'] != ReturnMessage::OK){

                            DB::rollback();
                            alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                            return redirect()->action('Setup\CSVImport\CSVImportController@import');
                        }
                    } else {
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! Facilities Group have some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }
                }
                //Table Landmark
                if ($table_name == 'landmarks') {
                    $township_name      = $data[2];
                    $township        = $this->repo->getTownshipIdByName($township_name);

                    if(count($township) >= 1) {
                        //Insert township id to Landmarks
                        $implode       = array();
                        foreach ($data as $key => $value) {
                            if ($key == 2) {
                                $implode[$key]  = $township->id;
                            } else {
                                $implode[$key]  = $value;
                            }
                        }
                        $insert_val         = implode("','",$implode);
                        $result             = $this->repo->createLandmarks($insert_val);
                        if($result['aceplusStatusCode'] != ReturnMessage::OK){

                            DB::rollback();
                            alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                            return redirect()->action('Setup\CSVImport\CSVImportController@import');
                        }
                    } else {
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! Township have some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }
                } 

                if ($table_name == 'hotels') {
                    $admin_key          = 21;
                    $admin_email_key    = 23;
                    $hotel_key          = 20;
                    $password_key       = 24;
                    $admin_arr          = array();
                    foreach ($data as $key => $value) {
                        if ($key >= $admin_key) {
                            if ($key == $password_key) {
                                $admin_arr[] = bcrypt($value);
                            } else {
                                $admin_arr[]      = $value;
                            }
                        }    
                    }
                    $insert_val         = implode("','",$admin_arr);
                    $result             = $this->repo->createAdmin($insert_val);
                    if($result['aceplusStatusCode'] != ReturnMessage::OK){

                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }

                    $admin_email    = $data[$admin_email_key];
                    $admin          = DB::table('core_users')->select('id')->where('email', $admin_email)->first();
                    if(count($admin) >= 1) {
                        //Insert township id to Landmarks
                        $hotel_arr       = array();
                        foreach ($data as $key => $value) {
                            if ($key < $admin_key) {
                                $hotel_arr[]      = $value;
                            }    
                        }

                        //Add Admin id to hotel array
                        $admin_id           = $admin->id;
                        array_push($hotel_arr, $admin_id);
                        $country_name       = $hotel_arr[9];
                        $city_name          = $hotel_arr[10];
                        $township_name      = $hotel_arr[11];
                        //Get Country Id
                        $country            = $this->repo->getCountryIdByName($country_name);
                        $city               = $this->repo->getCityIdByName($city_name);
                        $township           = $this->repo->getTownshipIdByName($township_name);

                        if(count($country) >= 1 AND count($city) >= 1 AND count($township) >= 1) {
                            
                            $implode       = array();
                            foreach ($hotel_arr as $key => $value) {
                                if ($key == 8) {
                                    $implode[$key]  = $admin_email;
                                } elseif ($key == 9) {
                                    $implode[$key]  = $country->id;
                                } elseif($key == 10) {
                                    $implode[$key]  = $city->id;
                                } elseif ($key == 11) {
                                    $implode[$key]  = $township->id;
                                } else {
                                    $implode[$key]  = $value;
                                }
                            }
                            $insert_val         = implode("','",$implode);
                            $result             = $this->repo->createHotels($insert_val);
                            if($result['aceplusStatusCode'] != ReturnMessage::OK){

                                DB::rollback();
                                alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                                return redirect()->action('Setup\CSVImport\CSVImportController@import');
                            }

                        } else {
                            DB::rollback();
                            alert()->error('Error Message', 'Sorry! There have some problem in Township or City or Country.')->persistent('Close');

                            return redirect()->action('Setup\CSVImport\CSVImportController@import');
                        }
                    } else {
                        DB::rollback();
                        alert()->error('Error Message', 'Sorry! There is some problem.')->persistent('Close');

                        return redirect()->action('Setup\CSVImport\CSVImportController@import');
                    }
                }
            }
            DB::commit();
            alert()->success('Success Message', 'Table has imported successfully')->persistent('Close');
            return redirect()->action('Setup\CSVImport\CSVImportController@import');

        } catch(\Exception $e){
            DB::rollback();
        }
    }
}
