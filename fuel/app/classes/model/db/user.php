<?php

class Model_Db_User extends Model_Db_Crudbase
{

    protected static $_table_name = 'user';
    protected static $_user_id = 'user_id';
    protected static $_user_name = 'user_name';
    protected static $_user_email = 'user_email';
    protected static $_user_password = 'user_password';
    protected static $_user_status = 'user_status';
    protected static $_user_created_at = 'user_created_at';
    protected static $_user_updated_at = 'user_updated_at';
    protected static $_user_deleted_at = 'user_deleted_at';
    protected static $_primary_key = 'user_id';

}
?>

