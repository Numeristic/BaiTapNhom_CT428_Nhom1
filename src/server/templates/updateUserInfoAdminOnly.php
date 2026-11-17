<br>
<label>Cấp quyền:</label>
<div>
    <input type="checkbox" id="input_bacsi" name="bs_perms" <?php if ($is_bs>0) {
        echo "checked";
    } ?>>
    <label for="bs_perms">Bác sĩ</label>

    <input type="checkbox" id="input_admin" name="admin_perms" <?php if ($is_admin>0) {
        echo "checked";
    } ?>>
    <label for="admin_perms">Admin</label>
</div>
<br>

<label for="ck" id="label_ck">Chuyên khoa:</label>
<br>
<select name="ck" id="input_ck" class="input_text">
    <option value="">Chọn chuyên khoa</option>
    <?php 
        require_once("../server/scripts/sqlCredentials.php");

        require_once("../server/norun/loadCk2.php");
    ?>
</select>
<br>


