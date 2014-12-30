--muscle view
CREATE VIEW vwMuscle AS
SELECT
    M.Id AS MuscleId,
    M.Name AS MuscleName,
    MG.Id AS MuscleGroupId,
    MG.Name AS MuscleGroupName
FROM
    Muscle M
    INNER JOIN MuscleGroup MG ON M.MuscleGroupId = MG.Id