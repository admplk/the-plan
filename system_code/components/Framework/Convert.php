<?php
namespace Framework{
    /**
     * Convert class containing commonly used conversion functions
     *
     * @author Adam Pollock
     * @version 1.1
     * @created 31-JAN-2012
     * @lastModified 25-SEP-2013
     */
    class Convert
    {
        /**
         * Converts the supplied array value to an integer
         * @param array $array The array containing the value to convert
         * @param string $arrayKey The array item to try and convert
         * @param type $default [OPTIONAL] The value to return if the conversion fails
         * @return type The supplied array item converted to an integer
         */
        public static function ArrayValueToInt(array $array, $arrayKey, $default = 0){
            if(isset($array[$arrayKey])){
                return self::ToInt($array[$arrayKey], $default);
            }else{
                return $default;
            }
        }

        /**
         * Converts the supplied value to an integer
         * @param type $value The value to convert to an integer
         * @param type $default [OPTIONAL] The value to return if the conversion fails
         * @return integer The supplied value converted to an integer
         */
        public static function ToInt($value, $default = 0){
            if(isset($value)){
                return intval(filter_var($value, FILTER_SANITIZE_NUMBER_INT));
            }else{
                return $default;
            }
        }       

        /**
         * Converts the supplied array value to a string
         * @param array $array The array containing the value to convert
         * @param string $arrayKey The array item to try and convert
         * @param type $default [OPTIONAL] The value to return if the conversion fails
         * @return type The supplied array item converted to a string
         */
        public static function ArrayValueToString(array $array, $arrayKey, $default = ""){
            if(isset($array[$arrayKey])){
                return self::ToString($array[$arrayKey], $default);
            }else{
                return $default;
            }
        }

        /**
         * Converts the supplied value to a string
         * @param type $value The value to convert to a string
         * @param type $default The value to return if the conversion fails
         * @return string The supplied value converted to a string
         */
        public static function ToString($value, $default = ""){
            if(isset($value)){
                return filter_var($value, FILTER_SANITIZE_STRING);
            }else{
                return $default;
            }        
        }

        public static function ArrayValueToEmail(array $array, $arrayKey, $default = ""){
            if(isset($array[$arrayKey])){
                return filter_var($array[$arrayKey], FILTER_SANITIZE_EMAIL);
            }else{
                return $default;
            }
        }

        /**
         * Converts the supplied array value to a float
         * @param array $array The array containing the value to convert
         * @param string $arrayKey The array item to try and convert
         * @param type $default [OPTIONAL] The value to return if the conversion fails
         * @return type The supplied array item converted to a float
         */
        public static function ArrayValueToFloat(array $array, $arrayKey, $default = 0){
            if(isset($array[$arrayKey])){
                return self::ToFloat($array[$arrayKey], $default);
            }else{
                return $default;
            }
        }

        /**
         * Converts the supplied value to a float
         * @param type $value The value to convert to a float
         * @param type $default The value to return if the conversion fails
         * @return type The supplied value converted to a float
         */
        public static function ToFloat($value, $default = 0){
            try {
                if(isset($value)){
                    return floatval($value);
                }else{
                    return $default;
                }   
            } catch (Exception $ex) {
                return $default;
            }        
        }

        public static function ArrayValueToHtml(array $array, $arrayKey, $default = 0){
            if(isset($array[$arrayKey])){
                return self::ToHtml($array[$arrayKey], $default);
            }else{
                return $default;
            }
        }

        public static function ToHtml($value, $default = ""){
            if(isset($value)){
                return html_entity_decode($value);
            }else{
                return $default;
            }        
        }

        public static function FromHtml($value, $default = ""){
            if(isset($value)){
                return htmlentities($value);
            }else{
                return $default;
            }        
        }

        /**
         * 
         * @param string $date Date in format dd/mm/yyyy
         * @return string TimeStamp 
         */
        public static function ToTimeStamp($date){
            list($day,$month,$year)=explode('/',$date);
            $timestamp=mktime(0,0,0,$month,$day,$year);

            return date('Y-m-d', $timestamp);
        }

        /**
         * Converts the supplied timestamp to dd/mm/yyyy format
         * @param int $timeStamp
         * @return string Date in format dd/mm/yyyy
         */
        public static function ToDateMonthYear($timeStamp){
            return $timeStamp != "" ? date('d/m/Y', $timeStamp) : "";
        }

        /**
         * Returns the hour part of the supplied timestamp
         * @param int $timeStamp
         * @return string Hour part of supplied timestamp
         */
        public static function GetHourOnly($timeStamp){
            return $timeStamp != "" ? date('G', $timeStamp) : "";
        }

        /**
         * Returns the minute part of the supplied timestamp
         * @param int $timeStamp
         * @return string Minute part of the supplied timestamp
         */
        public static function GetMinuteOnly($timeStamp){
            return $timeStamp != "" ? date('i', $timeStamp) : "";
        }
    }
}
?>