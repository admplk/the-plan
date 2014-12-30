<?php
namespace Framework\Dal{
    use \SqlParamsList;
    
    /**
     * Interface for DataAccess class
     * 
     * @author Adam Pollock
     * @version 1.0
     * @created 08-Mar-2012
     * @lastModified 08-Mar-2012
     */
    interface IDataAccess
    {
        /**
         * Retrieve raw data from database
         * @param string $tableName The name of the table to query
         * @param SqlParamsList $search [OPTIONAL] The search parameters used in the table query
         * @param array $sort [OPTIONAL] The parameters to order the returned results by       
         * @param integer $minRow [OPTIONAL] The row in the table to start at when retrieving data
         * @param integer $limit [OPTIONAL] The number of rows to return
         * @return array Returns array of data indexed by column name
         */
        public function Retrieve($tableName, SqlParamsList $search = null, $sort = array(), $minRow = 0, $limit = null);

        /**
         * Updates an entry in the database
         * @param string $tableName The name of the table to update
         * @param array $fields The fields to update in the query
         * @param array $where The where clause used to filter what rows to update    
         */
        public function Update($tableName, $fields, $where);

        /**
         * Insert a new row into the specified table
         * @param string $tableName The table to insert the row into
         * @param array $fields The data to insert into the table
         * @param bool $returnIdentity [OPTIONAL] Whether to return the id field of the row insert
         */
        public function Insert($tableName, $fields, $returnIdentity = false);

        /**
         * Delete data from database
         * @param string $tableName The name of the table to delete data from
         * @param array $where The where clause used to filter what rows to delete     
         */
        public function Delete($tableName, $where);

        /**
         * Log a database data change in the ChangeLog table
         * @param string $message A description of the change being made
         * @param integer $userId The id of the user who made the change
         */
        public function LogChange($message, $userId);

        /**
         * Attempt to log an error in the ErrorLog table
         * @param string $message A description of the error that occurred
         * @param string $stackTrace The stacktrace for the error that occurred
         */
        public function LogError($message, $stackTrace);
    }
}
?>