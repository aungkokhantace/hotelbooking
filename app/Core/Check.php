<?php namespace App\Core;
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 10/25/2016
 * Time: 10:42 AM
 */
use App\Core\Config\ConfigRepository;
use App\Setup\Booking\BookingRepository;
use Validator;
use Auth;
use App\Http\Requests;
use App\Session;
use App\Core\User\UserRepository;
use App\Setup\FrontedClient\FrontedClient;
use App\Setup\Backend\Backend;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\Permission\PermissionRepository;

class Check
{
    /**
     *
     * @return bool
     */
    public static function validSession()
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            return true;
        }
        return false;
    }

    public static function hasPermission($permissions,$routeAction) {

        if(isset($permissions) && count($permissions)>0) {
            foreach ($permissions as $key => $permission) {
                if ($permission['url'] == $routeAction) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $methodString
     * @param $method
     * @return bool
     */
    public static function hasMethods($methodString,$method) {
        $methods = explode('|', $methodString);
        return (in_array("*", $methods) || in_array($method, $methods));
    }

     /**
     * @return mixed
     */
    public static function logout() {
        //flush session
        Session::flush();

        //redirect user to login page
        return Redirect::to('/backend_mps/login');
    }

    public static function getInfo() {
        $info = array();
        $info['companyName'] = "";
        if(Check::validSession()) {
            $info['userName'] = strtoupper(session('user')['user_name']);
            $info['userId'] = session('user')['id'];
            $info['userRoleId'] = session('user')['role_id'];
        }
        return $info;
    }

    public static function companyLogo() {

        $ConfigRepository = new ConfigRepository();
        $companyLogo = $ConfigRepository->getCompanyLogo();

        if(isset($companyLogo) && count($companyLogo)>0 ) {

            if(isset($companyLogo[0]->value) && $companyLogo[0]->value != ""){
                return $companyLogo[0]->value;
            }
            else{
                return "/images/aceplus-logo.png";
            }
        }
        return "/images/aceplus-logo.png";
    }

    public static function companyName() {

        $ConfigRepository = new ConfigRepository();
        $companyName = $ConfigRepository->getCompanyName();

        if(isset($companyName) && count($companyName)>0 ) {

            if(isset($companyName[0]->value) && $companyName[0]->value != ""){
                return $companyName[0]->value;
            }
            else{
                return "AcePlus Backend";
            }
        }
        return "AcePlus Backend";
    }

    public static function createSession($id) {
        $userRepository = new UserRepository();
        $tempUser = $userRepository->getObjByID($id);
        $permissions = $userRepository->getPermissionByUserId($id);
        session(['user'=>$tempUser->toArray()]);
        session(['permissions' => $permissions]);
    }

    public static function createSessionCustomer($id){
        $repo         = new UserRepository();
        $tempCustomer = $repo->getObjByID($id);
        session(['customer' =>$tempCustomer->toArray()]);
    }

    public static function checkBookingByUserId($b_id,$u_id){
        $repo                           = new BookingRepository();
        $bookings                       = $repo->getBookingByBookIdAndUserId($b_id,$u_id);
        $result['aceplusStatusCode']    = ReturnMessage::UNAUTHORIZED;

        if(isset($bookings) && count($bookings) > 0){
            $result['aceplusStatusCode']    = ReturnMessage::OK;
        }
        return $result;
    }

    public static function checkBookingByHotelId($h_id){
        $repo                           = new BookingRepository();
        $bookings                       = $repo->getBookingByHotelId($h_id);
        $result['aceplusStatusCode']    = ReturnMessage::UNAUTHORIZED;

        if(isset($bookings) && count($bookings) > 0){
            $result['aceplusStatusCode']    = ReturnMessage::OK;
        }
        return $result;
    }

    public static function getPermissionByRoleId($role_id) {
        if($role_id) {
            $permissionRepo = new PermissionRepository();
            $permissions = $permissionRepo->getPermissionsByRoleId($role_id);
            if($permissions){
              $permission_url_array = array();
              foreach($permissions as $permission){
                array_push($permission_url_array,$permission['url']);
              }
              return $permission_url_array;
            }
        }
        return null;
    }

    public static function checkToDelete($table,$column,$id){
      $result = DB::select("SELECT * FROM $table WHERE $column = $id AND deleted_at IS NULL");
      return $result;
    }

}
