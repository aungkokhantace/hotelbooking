<?php namespace App\Core\User;

/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 5/21/2016
 * Time: 3:51 PM
 */
interface UserRepositoryInterface
{
    public function getUsers();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete_users($id);
    public function getRoles();
    public function changeDisableToEnable($id,$cur);
    public function changeEnableToDisable($id);
    public function getPermissionByUserId($userId);
    public function getUsersWithExceptRoles($current_user_role, $except_role_array);
    public function getRolesWithExceptRoles($current_user_role, $except_role_array);
    public function getRolesForUserProfile($current_user_role, $except_role_array);
    public function disable_user($id);
    public function enable_user($id);
    public function getDisabledUsersWithExceptRoles($current_user_role, $except_role_array);
}
