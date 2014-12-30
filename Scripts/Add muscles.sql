/**
Script to add in muscle entries
**/

/** Temp table to hold muscle groups **/
CREATE TEMPORARY TABLE IF NOT EXISTS 
  temp_musclegroups ENGINE=InnoDB
AS ( select * from
        (
                SELECT 'Arms' AS MuscleGroup UNION
                SELECT 'Back' UNION
                SELECT 'Chest' UNION
                SELECT 'Legs' UNION
                SELECT 'Shoulders' UNION
                SELECT 'Abdominals'
        ) muscles
);

/** Add the muscle groups **/
INSERT INTO MuscleGroup(Name)
SELECT 
    T1.MuscleGroup
FROM 
    temp_musclegroups T1
    LEFT JOIN MuscleGroup MG ON T1.MuscleGroup = MG.Name
WHERE 
    MG.Id IS NULL;



/** Temp table to hold muscles **/
CREATE TEMPORARY TABLE IF NOT EXISTS 
  temp_muscles ENGINE=InnoDB
AS ( select * from
        (
                SELECT 'Biceps' AS Muscle, 'Arms' AS MuscleGroup UNION
                SELECT 'Triceps', 'Arms' UNION                
                SELECT 'Forearm', 'Arms' UNION
                SELECT 'Lats', 'Back' UNION
                SELECT 'Upper Back', 'Back' UNION
                SELECT 'Middle Back', 'Back' UNION
                SELECT 'Lower Back', 'Back' UNION
                SELECT 'Upper Pectorals', 'Chest' UNION
                SELECT 'Lower Pectorals', 'Chest' UNION
                SELECT 'Serratus', 'Chest' UNION
                SELECT 'Front Deltoids', 'Shoulders' UNION
                SELECT 'Side Deltoids', 'Shoulders' UNION
                SELECT 'Rear Deltoids', 'Shoulders' UNION
                SELECT 'Trapezius', 'Shoulders' UNION
                SELECT 'Rectus Abdominus', 'Abdominals' UNION
                SELECT 'Obliques', 'Abdominals' UNION
                SELECT 'Glutes', 'Legs' UNION
                SELECT 'Quadriceps', 'Legs' UNION
                SELECT 'Hamstrings', 'Legs' UNION
                SELECT 'Calves', 'Legs'
        ) muscles
);

/** Add the muscles **/
INSERT INTO Muscle(MuscleGroupId, Name)
SELECT 
    MG.Id,
    T1.Muscle
FROM 
    temp_muscles T1
    INNER JOIN MuscleGroup MG ON T1.MuscleGroup = MG.Name
    LEFT JOIN Muscle M ON T1.Muscle = M.Name
WHERE 
    M.Id IS NULL;


/** Drop the temp tables **/
DROP TABLE IF EXISTS temp_musclegroups;
DROP TABLE IF EXISTS temp_muscles;