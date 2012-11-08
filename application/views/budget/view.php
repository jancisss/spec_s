
<div id="content">
    <?php foreach($budget_items as $budget){?>
        <div class="budget">
           <p><?php echo anchor('budget/'.$budget->id, $budget->name);?> value = <?php echo $budget->value;?></p>
        </div>
    <?php }?>
</div>
