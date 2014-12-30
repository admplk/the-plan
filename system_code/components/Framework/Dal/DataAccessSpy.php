<?php
/**
 * Mock DataAccess class, for use in unit tests.
 *
 * @author Adam Pollock
 * @version 1.0
 * @created 08-Mar-2012
 * @lastModified 08-Mar-2012
 */
class DataAccessSpy implements IDataAccess
{    
    /** @var array */
    private $_dataToReturn;
    
    /** @var array */
    private $_searchQueries;
    
    function __construct()
    {
        $this->_dataToReturn = array();
        $this->_searchQueries = array();
    }
    
    public function Delete($tableName, $where)
    {
        //TODO
    }
    
    public function Insert($tableName, $fields, $returnIdentity = false)
    {
        //TODO
    }
    
    public function LogChange($message, $userId)
    {
        //TODO
    }
    
    public function LogError($message, $stackTrace)
    {
        //TODO
    }
    
    public function Retrieve($tableName, array $search, $sort, $minRow = 0, $limit = null)
    {
        if(!array_key_exists($tableName, $this->_searchQueries)){
            $this->_searchQueries[$tableName] = $search;
        }
        
        if(array_key_exists($tableName, $this->_dataToReturn)){
            return $this->_dataToReturn[$tableName];
        }
    }
    
    public function Update($tableName, $fields, $where)
    {
        //TODO
    }
    
    /**
     * Add data to return for a certain table when it is queried
     * @param string $tablename The name of the table
     * @param array $data The data to return
     */
    public function AddDataToReturn($tablename, $data){
        if(!array_key_exists($tablename, $this->_dataToReturn)){
            $this->_dataToReturn[$tablename] = $data;
        }
    }
    
    public function ContainsSearchQuery($tableName, array $search){
        $isValid = false;
        
        if(array_key_exists($tableName, $this->_searchQueries)){
            $actualSearch = $this->_searchQueries[$tableName];
            
            foreach($search as $sqlParam){
                if($this->CheckSqlParamExists($actualSearch, $sqlParam)){
                    $isValid = true;
                }else{
                    return false;
                }
            }
        }
        
        return $isValid;
    }
    
    private function CheckSqlParamExists(array $actualSearch, SqlParam $sqlParam){
        foreach($actualSearch as $actualSqlParam){
            if($sqlParam->Equals($actualSqlParam)){
                return true;
            }
        }
                
        return false;
    }
} 
?>
