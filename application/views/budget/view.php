
<div id="content">
    <?php foreach($budget_items as $budget){?>
        <div class="budget">
           <p><?php echo anchor('budget/'.$budget->id, $budget->nosaukums);?></p>
        </div>
    <?php }?>
</div>
