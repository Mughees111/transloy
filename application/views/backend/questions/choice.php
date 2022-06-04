
<div class="card" style="float: left;clear: both; width: 100%;">
     <div class="card-header">
        <h4 class="m-b-0 text-white pull-left">Choice</h4>

        <button class="btn btn-danger btn-sm pull-right" onclick="removeChoiceSection(this);">Remove</button>
    </div>
<div style="padding: 20px; background: #d8d8d8; border:1px dotted #d8d8d8; float: left; width: 100%;">
    <div class="form-group">
        <h5>Choice Text</h5>
        <input type="text" name="choices[]" class="form-control form-control-line" placeholder="Choice Text" value="<?php echo $choice; ?>">
    </div>

    <div class="form-group ">
        <div class="controls">
        <label>

            <input <?php if($is_correct==1) echo "checked"; ?> type="checkbox" value="1" name="correct[]" class="form-control form-control-line"> Correct? </label>
        </div>
    </div>
</div>
</div>
