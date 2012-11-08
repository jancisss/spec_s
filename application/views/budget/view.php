<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>2012 gada budžets</title>
    <style>
        p {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<div id="container">
    <?php foreach($budget_items as $budget){?>
        <div class="budget">
           <p><?php echo anchor('budget/'.$budget->id, $budget->name);?> value = <?php echo $budget->value;?></p>
        </div>
    <?php }?>
</div>

</body>
</html>