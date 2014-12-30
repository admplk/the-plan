<?php
namespace Framework\Dal{
    use \SqlParamsList;
    use \PDO;
    use \PDOException;
    
    /**
     * DataAccess object
     *
     * @author Adam Pollock
     * @version 1.5
     * @created 01-DEC-2011
     * @lastModified 30-DEC-2014
     */
    class DataAccess extends PDO implements IDataAccess
    {            
        const DEBUG_MODE = true;

        /**
         * Constructor for DataAccess class
         * @param string $databaseName The name of the database
         */
        function __construct($databaseName)
        {
            try{
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . $databaseName;
                parent::__construct($dsn, DB_USER, DB_PASSWORD);
            }
            catch (PDOException $e){
                throw new Exception("There was an error connecting to the database.");
                //TODO - Should do something better than just throwing another exception.
            }
        }

        /**
         * Retrieve raw data from database
         * @param string $tableName The name of the table to query
         * @param SqlParamsList $search [OPTIONAL] The search parameters used in the table query
         * @param array $sort [OPTIONAL] The parameters to order the returned results by       
         * @param integer $minRow [OPTIONAL] The row in the table to start at when retrieving data
         * @param integer $limit [OPTIONAL] The number of rows to return
         * @return array Returns array of data indexed by column name
         */
        public function Retrieve($tableName, SqlParamsList $searchList = null, $sort = array(), $minRow = 0, $limit = null){        
            $query = "SELECT * FROM ";
            $query .= $tableName;

            $search = array();
            if(!is_null($searchList)){
                $search = $searchList->Get();
            }
            
            $count = 1;           
            $orInProgress = false;
            foreach ($search as $sqlParam)
            {
                //enclose value in quotes unless is keyword null
                if($sqlParam->value != "null"){
                    $sqlParam->value = "'" . $sqlParam->value . "'";
                }

                //close OR statement if param is not part of OR statement, and OR statement is in progress
                if(!$sqlParam->partOfOrClause && $orInProgress){
                    $query .= ")";
                    $orInProgress = false;
                }

                if($sqlParam->partOfOrClause){
                    //open OR statement if param is part of OR statement, and OR statement is not in progress
                    if(!$orInProgress){
                        if($count == 1){
                            $query .= " WHERE (" . $sqlParam->field . " " . $sqlParam->modifier . " " . $sqlParam->value;
                            $orInProgress = true;
                        }
                        else{
                            $query .= " AND (" . $sqlParam->field . " " . $sqlParam->modifier . " " . $sqlParam->value;
                            $orInProgress = true;
                        }
                    }
                    //else OR statement is in progress
                    else{
                        $query .= " OR " . $sqlParam->field . " " . $sqlParam->modifier . " " . $sqlParam->value;
                    }
                }
                elseif($count == 1){
                    $query .= " WHERE " . $sqlParam->field . " " . $sqlParam->modifier . " " . $sqlParam->value;                                                         
                }
                else{
                    $query .= " AND " . $sqlParam->field . " " . $sqlParam->modifier . " " . $sqlParam->value;
                }

                $count++;
            }

            //close OR statement if still open
            if($orInProgress){
                $query .= ")";
            }            

            if(!is_null($sort)){
                $count = 1;
                foreach ($sort as $key => $value)
                {
                    if($count == 1){
                        $query .= " ORDER BY " . $key . " " . $value;
                    }
                    else{
                        $query .= ", " . $key . " " . $value;
                    }

                    $count++;
                }
            }

            if(!is_null($limit)){
                $query .= " LIMIT " . $minRow . ", " . $limit;
            }

            if($this::DEBUG_MODE){
    //            print_r($query);
                $file=fopen("c:\sqlLog.txt","a");
                fwrite($file, "\r\nRETRIEVE QUERY (" . gmdate("Y-m-d H:i:s"). "):\n" . $query . "\r\n");
                fclose($file);
            }        

            $sqlStatement = $this->prepare($query);        

            if(!$sqlStatement->execute()){
                $this->LogError("Query error: " . addslashes($query), implode(",", $sqlStatement->errorInfo()));
            }

            $results = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);                

    //        if(count($results) == 0){
    //            $this->LogError("Query returned 0 results: " . addslashes($query), implode(",", $results));
    //        }

            $sqlStatement->closeCursor();        

            return $results;        
        }

        /**
         * Updates an entry in the database
         * @param string $tableName The name of the table to update
         * @param array $fields The fields to update in the query
         * @param array $where The where clause used to filter what rows to update    
         */
        public function Update($tableName, $fields, $where){        
            if(!is_null($fields)){
                $query = "UPDATE ";
                $query .= $tableName;       

                $count = 1;
                foreach ($fields as $key => $value)
                {
                    //enclose value in quotes unless is keyword null
                    if($value != "null"){
                        $value = "'" . $value . "'";
                    }

                    if($count == 1){
                        $query .= " SET " . $key . " = " . $value;
                    }
                    else{
                        $query .= ", " . $key . " = " . $value;
                    }

                    $count++;
                }

                //TODO - Replace array with SqlParamsList
                if(!is_null($where)){
                    $count = 1;
                    foreach ($where as $key => $value)
                    {
                        if($count == 1){
                            $query .= " WHERE " . $key . " = '" . $value . "'";
                        }
                        else{
                            $query .= " AND " . $key . " = '" . $value . "'";
                        }

                        $count++;
                    }
                }

                if($this::DEBUG_MODE){
    //                print_r($query);
                    $file=fopen("c:\sqlLog.txt","a");
                    fwrite($file, "\r\nUPDATE QUERY (" . gmdate("Y-m-d H:i:s"). "):\n" . $query . "\r\n");
                    fclose($file);
                }

                $sqlStatement = $this->prepare($query);       
                if(!$sqlStatement->execute()){
                    $this->LogError("Query error: " . addslashes($query), implode(",", $sqlStatement->errorInfo()));
                }

                if($sqlStatement->rowCount() == 0){
                    $this->LogError("Query updated 0 rows: " . addslashes($query), "n/a");
                }

                $sqlStatement->closeCursor();
            }
        }

        /**
         * Insert a new row into the specified table
         * @param string $tableName The table to insert the row into
         * @param array $fields The data to insert into the table
         * @param bool $returnIdentity [OPTIONAL] Whether to return the id field of the row insert
         */
        public function Insert($tableName, $fields, $returnIdentity = false){        
            if(!is_null($fields)){
                $query = "INSERT INTO ";
                $query .= $tableName;       

                $count = 1;
                foreach ($fields as $key => $value)
                {                 
    //                if($value !== ""){
                        if($count == 1){
                            $query .= " (" . $key;
                        }
                        else{
                            $query .= ", " . $key;
                        }

                        $count++;
    //                }
                }
                $query .= ") VALUES(";

                $count = 1;
                foreach ($fields as $key => $value)
                {                
    //                if($value !== ""){
                        if($count == 1){
                            $query .= "'" . $value . "'";
                        }
                        else{
                            $query .= ", '" . $value . "'";
                        }

                        $count++;
    //                }
                }
                $query .= ")";

                if($this::DEBUG_MODE){
    //                print_r($query);
                    $file=fopen("c:\sqlLog.txt","a");
                    fwrite($file, "\r\nINSERT QUERY (" . gmdate("Y-m-d H:i:s"). "):\n" . $query . "\r\n");
                    fclose($file);
                }

                $sqlStatement = $this->prepare($query);       
                if(!$sqlStatement->execute()){
                    $this->LogError("Query error: " . addslashes($query), implode(",", $sqlStatement->errorInfo()));
                }                        
                $sqlStatement->closeCursor();

                if($returnIdentity){
                    return $this->lastInsertId("Id");
                }
            }
        }

        /**
         * Delete data from database
         * @param string $tableName The name of the table to delete data from
         * @param array $where The where clause used to filter what rows to delete     
         */
        public function Delete($tableName, $where){        
            $query = "DELETE FROM ";
            $query .= $tableName;

            //TODO - Replace array with SqlParamsList
            if(!is_null($where)){
                $count = 1;
                foreach ($where as $key => $value)
                {
                    if($count == 1){
                        $query .= " WHERE " . $key . " = '" . $value . "'";
                    }
                    else{
                        $query .= " AND " . $key . " = '" . $value . "'";
                    }

                    $count++;
                }
            }        

            if($this::DEBUG_MODE){
    //            print_r($query);
                $file=fopen("c:\sqlLog.txt","a");
                fwrite($file, "\r\nDELETE QUERY (" . gmdate("Y-m-d H:i:s"). "):\n" . $query . "\r\n");
                fclose($file);
            }

            $sqlStatement = $this->prepare($query);       
            if(!$sqlStatement->execute()){
                $this->LogError("Query error: " . addslashes($query), implode(",", $sqlStatement->errorInfo()));
            }        

            if($sqlStatement->rowCount() == 0){
                $this->LogError("Query deleted 0 rows: " . addslashes($query), "n/a");
            }

            $sqlStatement->closeCursor();
        }

        public function RunRawSql($query){
            if($this::DEBUG_MODE){
    //            print_r($query);
                $file=fopen("c:\sqlLog.txt","a");
                fwrite($file, "\r\nRAW SQL QUERY (" . gmdate("Y-m-d H:i:s"). "):\n" . $query . "\r\n");
                fclose($file);
            }

            $sqlStatement = $this->prepare($query);        

            if(!$sqlStatement->execute()){
                $this->LogError("Query error: " . addslashes($query), implode(",", $sqlStatement->errorInfo()));
            }

            $results = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);

            $sqlStatement->closeCursor();        

            return $results;   
        }

        /**
         * Log a database data change in the ChangeLog table
         * @param string $message A description of the change being made
         * @param integer $userId The id of the user who made the change
         */
        public function LogChange($message, $userId){
            $dateNow = gmdate("Y-m-d H:i:s");
            $query = "INSERT INTO ChangeLog (DateOfChange, ChangeMade, UserId) VALUES ('$dateNow', '$message', $userId)";       

    //        print_r($query);
            $sqlStatement = $this->prepare($query);       
            $sqlStatement->execute();
            $sqlStatement->closeCursor();
        }

        /**
         * Attempt to log an error in the ErrorLog table
         * @param string $message A description of the error that occurred
         * @param string $stackTrace The stacktrace for the error that occurred
         */
        public function LogError($message, $stackTrace){        
            $dateNow = gmdate("Y-m-d H:i:s");
            $query = "INSERT INTO ErrorLog (DateOfError, Message, StackTrace) VALUES ('$dateNow', '$message', '$stackTrace')";       

    //        print_r($query);
            $sqlStatement = $this->prepare($query);       
            $sqlStatement->execute();
            $sqlStatement->closeCursor();
        }
    }
}
?>