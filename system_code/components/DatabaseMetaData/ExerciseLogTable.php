<?php
namespace DatabaseMetaData{
    /**
     * MetaData for ExerciseLogTable
     *
     * @author Adam Pollock
     * @version 1.0
     * @created 30-Dec-2014
     * @lastModified 30-Dec-2014
     */
    class ExerciseLogTable
    {
        /**
         * Name of the database table
         */
        const NAME = "ExerciseLog";
        
        //Column names
        const COLUMN_LogId = "LogId";
        const COLUMN_DateId = "DateId";
        const COLUMN_ExerciseId = "ExerciseId";
        const COLUMN_Sets = "Sets";
        const COLUMN_Reps = "Reps";
        const COLUMN_WeightKg = "WeightKg";
    }
}
?>