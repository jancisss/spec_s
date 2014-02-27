<form name="input" action="<?php echo base_url('import/take'); ?>" method="post">
    <label for="table_name">Tabulas nosaukums</label> <input type="text" id="table_name" name="table_name">

    <div> <label for="text_input">Faila teksts</label><textarea  name="text_input"  style="width:700px; height:400px"id="text_input"></textarea>
    </div>
    <input type="submit" value="Submit">
</form>