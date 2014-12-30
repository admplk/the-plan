<?php
namespace Readers
{   
    use Framework\Dal\IDataAccess;
    use Framework\Convert;
    use DatabaseMetaData\MuscleView;
    use Entities\Muscle;
    
    /**
     * Description of MuscleReader
     *
     * @author admplk
     * @version 1.0
     * @created 30-Dec-2014
     * @lastmodified 30-Dec-2014
     */
    class MuscleReader
    {
        /**
         * DataAccess object
         * @var IDataAccess
         */
        private $_dal;
        
        /**
         * Creates a new MuscleReader object
         * @param IDataAccess $dal DataAccess object
         */
        function __construct(IDataAccess $dal){
            $this->_dal = $dal;            
        }
        
        /**
         * Gets all muscle types
         * @return Array of Muscle objects
         */
        public function GetAllMuscles(){
            try {
                $musclesDB = $this->_dal->Retrieve(MuscleView::NAME);
                
                $muscles = array();
                foreach ($musclesDB as $muscle){
                    $muscleId = Convert::ArrayValueToInt($muscle, MuscleView::COLUMN_MuscleId);
                    $muscles[$muscleId] = new Muscle($muscle);
                }
                
                return $muscles;
            } catch (Exception $ex)
            {
                echo $ex->getTraceAsString();
            }
        }
    }
}