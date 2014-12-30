<?php
require_once ('includes/initialisePage.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>The Plan</title>
    </head>
    <body>
        <h1>The Plan</h1>
        <h3>Date: <?php echo gmdate("d-m-Y"); ?></h3>
        <table>
            <tr><th>Goal</th><th>Completed</th></tr>
            <tr><td>Be awesome</td><td><input type="checkbox" /></td></tr>
        </table>
        <p>
<?php
$dal = new Framework\Dal\DataAccess(DB_THEPLAN);
$muscleReader = new Readers\MuscleReader($dal);
$muscles = $muscleReader->GetAllMuscles();
?>
            <h3>Muscles:</h3>
            <table>
                <tr><th>MuscleId</th><th>MuscleName</th><th>MuscleGroupId</th><th>MuscleGroupName</th></tr>
                
                <?php foreach($muscles as $muscle){ ?>
                <tr>
                    <td><?php echo $muscle->MuscleId; ?></td>
                    <td><?php echo $muscle->MuscleName; ?></td>
                    <td><?php echo $muscle->MuscleGroupId; ?></td>
                    <td><?php echo $muscle->MuscleGroupName; ?></td>
                </tr>
                <?php } ?>
            </table>
        </p>
    </body>
</html>
