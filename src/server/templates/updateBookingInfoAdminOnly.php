<label for="tt" id="label_tt">
    Trạng thái <p class="red_required">*</p>
</label>
<br>
<select name="tt" class="input_text" id="input_tt">
    <?php 
        $id_tt = $data_result["ID_TrangThai"];
        require_once("../server/norun/loadTrangThai.php");
    ?>
</select>