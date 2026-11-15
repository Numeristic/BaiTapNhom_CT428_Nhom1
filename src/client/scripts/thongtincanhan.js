let form_input_ids = [
    "idtk",
    "hoten",
    "socccd"
];

const bs_perms = document.getElementById("input_bacsi");
const admin_perms = document.getElementById("input_admin");

const label_ck = document.getElementById("label_ck");
const ck = document.getElementById("input_ck");

if (bs_perms && admin_perms && label_ck && ck) {
    function on_bs_change(){
        if (bs_perms.checked==false) {
            label_ck.style.display = 'none';
            ck.style.display = 'none';
        } else {
            label_ck.style.display = 'inline';
            ck.style.display = 'inline';
        }
    }
    on_bs_change();

    bs_perms.addEventListener("change",on_bs_change);
}