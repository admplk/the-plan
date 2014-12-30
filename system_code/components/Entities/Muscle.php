<?php
namespace Entities
{
    use DatabaseMetaData\MuscleView;
    use Framework\Convert;
    
    /**
     * Description of Muscle
     *
     * @author admplk
     * @version 1.0
     * @created 30-Dec-2014
     * @lastmodified 30-Dec-2014
     */
    class Muscle
    {
        /**
         * The muscle id
         * @var int
         */
        public $MuscleId;
        
        /**
         * The muscle name
         * @var string
         */
        public $MuscleName;
        
        /**
         * The muscle group id
         * @var int
         */
        public $MuscleGroupId;
        
        /**
         * The muscle group name
         * @var string
         */
        public $MuscleGroupName;
        
        function __construct(array $muscleDetails)
        {
            $this->MuscleId = Convert::ArrayValueToInt($muscleDetails, MuscleView::COLUMN_MuscleId);
            $this->MuscleName = Convert::ArrayValueToString($muscleDetails, MuscleView::COLUMN_MuscleName);
            $this->MuscleGroupId = Convert::ArrayValueToInt($muscleDetails, MuscleView::COLUMN_MuscleGroupId);
            $this->MuscleGroupName = Convert::ArrayValueToString($muscleDetails, MuscleView::COLUMN_MuscleGroupName);
        }
    }
}