let input_keys = [
    "idtk",
    "hoten",
    "socccd"
];

const idtk = document.getElementById("input_idtkreal")
const bs_perms = document.getElementById("input_bacsi");
const admin_perms = document.getElementById("input_admin");
const mk = document.getElementById("input_mk");
let delete_button = document.getElementById("delete_button");
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
if (mk){
    mk.addEventListener("click",function(){
        window.location.href = `../user/doimatkhau.php?id=${idtk.value}`;
    });
}

return_button.addEventListener("click",function(){
    show();
});

if (delete_button && idtk){

    delete_button.addEventListener("click",function(event){
        event.preventDefault();
        let prompt_result = confirm("Bạn có chắc muốn xóa lịch khám này?");
        if (prompt_result==true){
            let delete_xhttp = new XMLHttpRequest;
            delete_xhttp.open("POST","../server/scripts/deleteUser.php",false);
            delete_xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            delete_xhttp.send(`id=${idtk.value}`);
            
            console.log(idtk.value);

            if (delete_xhttp.readyState==4 && delete_xhttp.status==200) {
                /*alert("Xóa thành công.");*/
                //window.location.href = "../user/thongtincanhan.php";
                console.log(delete_xhttp.responseText);
            } else {
                console.log(`${delete_xhttp.statusText}`);
                console.log(`${delete_xhttp.status}`);
            }
        }
    });

}
