<div id ="contest">
    
    
    <h2>Institūcijas</h2>
    <?php
    foreach($institutions as $institution){
        echo "<div>". $institution->nosaukums . '</div>';
    }
    ?>
    <h2>Oranizācijas</h2>
    <?php
    foreach($organizations as $organization){
        echo "<div>". $organization->title . '</div>';
    }
    ?>
</div>