<?php
/**
 * Simple sql paramater class. 
 *
 * @author Adam Pollock
 * @version 1.0
 * @created 11-DEC-2011
 * @lastModified 11-DEC-2011
 * 
 * @param string $field The table field
 * @param string $modifier The sql query modifier
 * @param string $value The field value
 * @param bool $partOfOrClause [OPTIONAL] Whether the sql param is part of an OR clause
 */
class SqlParam
{
    /**
     * @var string The table field
     */
    public $field;
    
    /**
     * @var string The field value
     */
    public $value;
    
    /**
     * @var string The sql query modifier
     */
    public $modifier;
    
    /**
     * @var bool Whether the sql param is part of an or clause
     */
    public $partOfOrClause;
    
    /**
     * Constructor for SqlParam class.
     * @param string $field The table field
     * @param string $modifier The sql query modifier
     * @param string $value The field value
     * @param bool $partOfOrClause Whether the sql param is part of an OR clause
     */
    function __construct($field, $modifier, $value, $partOfOrClause = false)
    {
        $this->field = $field;
        $this->modifier = $modifier;
        $this->value = $value;
        $this->partOfOrClause = $partOfOrClause;
    }
    
    /**
     * Checks whether the parameters of this SqlParam equals another SqlParam
     * @param SqlParam $anotherSqlParam The SqlParam object to compare against
     * @return boolean Whether or not the comparing SqlParam has the same underlying parameter values
     */
    function Equals(SqlParam $anotherSqlParam){
        $isEqual = false;
        
        if($this->field == $anotherSqlParam->field && $this->modifier == $anotherSqlParam->modifier &&
            $this->value == $anotherSqlParam->value && $this->partOfOrClause == $anotherSqlParam->partOfOrClause){
            $isEqual = true;
        }
        
        return $isEqual;
    }
}
?>
