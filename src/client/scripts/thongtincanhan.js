let input_keys = [
    "idtk",
    "hoten",
    "socccd"
];

const bs_perms = document.getElementById("input_bacsi");
const admin_perms = document.getElementById("input_admin");
const return_button = document.getElementById("return_button2");

const label_ck = document.getElementById("label_ck");
const ck = document.getElementById("input_ck");

let saved_values = [];
for (let x=0;x<input_keys.length;x++){
    //var label = document.getElementById(`label_${input_keys[x]}`);
    var input_obj = document.getElementById(`input_${input_keys[x]}`);
    //console.log(`input_${input_keys[x]}`);
    saved_values[input_keys[x]] = input_obj.value;
}
if (ck) {
    saved_values["ck"] = ck.value;
}
if (bs_perms){
    saved_values["bs_perms"] = bs_perms.checked;
}
if (admin_perms){
    saved_values["admin_perms"] = admin_perms.checked;
}

function on_bs_change(){
    if (bs_perms.checked==false) {
        label_ck.style.display = 'none';
        ck.style.display = 'none';
    } else {
        label_ck.style.display = 'inline';
        ck.style.display = 'inline';
    }
}

function show() {
    for (let x=0;x<input_keys.length;x++){
        var input_obj = document.getElementById(`input_${input_keys[x]}`);
        input_obj.value = saved_values[input_keys[x]];
    }
    if (bs_perms && ck) {
        bs_perms.checked = saved_values["bs_perms"];
        on_bs_change();
    } 
    if (ck) {
        ck.value = saved_values["ck"];
    }
    if (admin_perms) {
        admin_perms.checked = saved_values["admin_perms"];
    }
}

if (bs_perms && admin_perms && label_ck && ck) {
    on_bs_change();
    bs_perms.addEventListener("change",on_bs_change);
}

return_button.addEventListener("click",function(){
    show();
})