<?php
/**
 * Object for storing a collection of sql parameters for
 * use in querying the database.
 *
 * @author Adam Pollock
 * @version 1.0
 * @created 11-DEC-2011
 * @lastModified 11-DEC-2011
 */
class SqlParamsList
{
    /**     
     * @var array
     */
    private $_sqlParams;
    
    /**
     * Constructor for SqlParamsList class.
     * Creates a new array of SqlParam objects.
     */
    function __construct()
    {
        $this->_sqlParams = array();
    }
    
    /**
     * Returns the built up list of SqlParam objects
     * @return array Collection of SqlParam objects
     */
    public function Get(){
        return $this->_sqlParams;
    }
    
    /**
     * Add another SqlParam to the collection
     * @param string $field The table field
     * @param string $modifier The sql query modifier
     * @param string $value The field value 
     * @param bool $partOfOrClause [OPTIONAL] Whether the sql param is part of an OR clause
     */
    public function Add($field, $modifier, $value, $partOfOrClause = false){
        $newSqlParam = new SqlParam($field, $modifier, $value, $partOfOrClause);
        $this->_sqlParams[] = $newSqlParam;
    }
}
?>
