<?php
namespace DatabaseMetaData{
    /**
     * MetaData for UserTable
     *
     * @author Adam Pollock
     * @version 1.0
     * @created 30-Dec-2014
     * @lastModified 30-Dec-2014
     */
    class UserTable
    {
        /**
         * Name of the database table
         */
        const NAME = "User";
        
        //Column names
        const COLUMN_Id = "Id";
        const COLUMN_Username = "Username";
        const COLUMN_Password = "Password";
        const COLUMN_LastLoginDate = "LastLoginDate";
        const COLUMN_PasswordExpired = "PasswordExpired";
    }
}
?>