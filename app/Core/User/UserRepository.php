<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Core\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Core\Permission\PermissionRepository;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Core\ReturnMessage;

class UserRepository implements UserRepositoryInterface
{
    public function create($userObj)
    {
        $tempObj = Utility::addCreatedBy($userObj);
        $tempObj->save();
    }

    public function update($userObj)
    {
        $tempObj = Utility::addUpdatedBy($userObj);
        $tempObj->save();
    }

    public function getUsers()
    {
        // $users = User::whereNull('deleted_at')->where('role_id','!=', 4)->get();
        $users = User::whereNull('deleted_at')
                        ->where('role_id','!=', 4)
                        ->where('status','=', 1)
                        ->get();
        return $users;
    }

    public function getUserByEmail($email)
    {
        $user = DB::select("SELECT * FROM core_users WHERE email = '$email'");
        return $user;
    }

    public function getRoles(){
        $roles = DB::table('core_roles')->get();
        return $roles;
    }

    public function delete_users($id){
        if($id != 1){
            //DB::table('core_users')->where('id',$id)->update(['deleted_at'=> date('Y-m-d H:m:i')]);
            $userObj = User::find($id);
            $userObj = Utility::addDeletedBy($userObj);
            $userObj->deleted_at = date('Y-m-d H:m:i');
            $userObj->save();
        }
    }

    public function getObjByID($id){
        $user = User::find($id);
        return $user;
    }

    public function changeDisableToEnable($id,$cur){
        DB::table('core_users')->where('id',$id)->update(['last_activity'=>$cur,'status'=>1]);
    }

    public function changeEnableToDisable($id)
    {
        DB::table('core_users')->where('id',$id)->update(['status'=>0]);
    }


    public function getPermissionByUserId($userId) {

        $roleId = DB::table("core_users")
            ->select('role_id')
            ->where('id' , '=' , $userId)
            ->first();

        if($roleId) {
            $permissionRepo = new PermissionRepository();
            $permissions = $permissionRepo->getPermissionsByRoleId($roleId->role_id);

            if($permissions)
                return $permissions;
        }
        return null;
    }

    //get users with greater roles than current role
    public function getUsersWithExceptRoles($current_user_role, $except_role_array){
        // $result = DB::table('core_users')->where('role_id','>=',$current_user_role)->whereNotIn('role_id',$except_role_array)->get();
        // $result = User::where('role_id','>=',$current_user_role)->whereNotIn('role_id',$except_role_array)->get();

        // $result = User::where('role_id','>',$current_user_role)
        //                 ->whereNotIn('role_id',$except_role_array)
        //                 ->get();

        $result = User::where('role_id','>',$current_user_role)
                        ->whereNotIn('role_id',$except_role_array)
                        ->where('status','=', 1)
                        ->get();
        return $result;
    }

    //get greater roles than current role
    public function getRolesWithExceptRoles($current_user_role, $except_role_array){
        // $result = DB::table('core_roles')->where('id','>=',$current_user_role)->whereNotIn('id',$except_role_array)->get();
        $result = DB::table('core_roles')->where('id','>',$current_user_role)->whereNotIn('id',$except_role_array)->get();
        return $result;
    }

    //get roles for user profile, including current user role
    public function getRolesForUserProfile($current_user_role, $except_role_array){
        $result = DB::table('core_roles')->where('id','>=',$current_user_role)->whereNotIn('id',$except_role_array)->get();
        return $result;
    }

    public function disable_user($id){
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        try{
            if($id != '1'){
                //DB::table('core_users')->where('id',$id)->update(['deleted_at'=> date('Y-m-d H:m:i')]);
                $userObj = User::find($id);
                $userObj = Utility::addUpdatedBy($userObj);
                $userObj->status = 0; //change status to 0; i.e. inactive
                $userObj->updated_at = date('Y-m-d H:m:i');
                $userObj->save();

                //disable info log
                $date = $userObj->updated_at;
                $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' disabled user_id = '.$userObj->id . PHP_EOL;
                LogCustom::create($date,$message);
            }
            else{
                //disable error log
                $date    = date("Y-m-d H:i:s");
                $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' disabled  user_id = U0001 and got error'. PHP_EOL;
                LogCustom::create($date,$message);
            }

        }
        catch(\Exception $e){
            //disable error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' disabled  user_id = ' .$userObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function enable_user($id){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        try{
            if($id != '1'){
                //DB::table('core_users')->where('id',$id)->update(['deleted_at'=> date('Y-m-d H:m:i')]);
                $userObj = User::find($id);
                $userObj = Utility::addUpdatedBy($userObj);
                $userObj->status = 1; //change status to 1; i.e. active
                $userObj->updated_at = date('Y-m-d H:m:i');
                $userObj->save();

                //enable info log
                $date = $userObj->updated_at;
                $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' enabled user_id = '.$userObj->id . PHP_EOL;
                LogCustom::create($date,$message);

                $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                return $returnedObj;
            }
            else{
                //enable error log
                $date    = date("Y-m-d H:i:s");
                $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' enabled  user_id = U0001 and got error'. PHP_EOL;
                LogCustom::create($date,$message);

                $returnedObj['aceplusStatusMessage'] = $e->getMessage();
                return $returnedObj;
            }


        }
        catch(\Exception $e){
            //enable error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' enabled  user_id = ' .$userObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    //get disabled users
    public function getDisabledUsersWithExceptRoles($current_user_role, $except_role_array){
        $result = User::where('role_id','>',$current_user_role)
                        ->whereNotIn('role_id',$except_role_array)
                        ->where('status','=', 0)
                        ->get();
        return $result;
    }

    public function getCustomers()
    {
        $customers = User::whereNull('deleted_at')
                        ->where('role_id','=', 4)
                        ->where('status','=', 1)
                        ->get();
        return $customers;
    }
}
