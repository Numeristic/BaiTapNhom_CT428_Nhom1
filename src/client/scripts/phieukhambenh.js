const input_keys = [
    "maphieu",
    "ck",
    "cg",
    "ngaykham",
    "lydokham"
];
let ck = document.getElementById(`input_ck`);
let cg = document.getElementById(`input_cg`);

let cgck_xhttp = new XMLHttpRequest;


let saved_values = [];
for (let x=0;x<input_keys.length;x++){
    //var label = document.getElementById(`label_${input_keys[x]}`);
    var input_obj = document.getElementById(`input_${input_keys[x]}`);
    console.log(`input_${input_keys[x]}`);
    saved_values[input_keys[x]] = input_obj.value;
}

function show(){
    for (let x=0;x<input_keys.length;x++){
        var input_obj = document.getElementById(`input_${input_keys[x]}`);
        input_obj.value = saved_values[input_keys[x]];
    }
}
function update_db() {

}

let past_ck_value = "";
function on_ck_change() {
    let ck_value = ck.value;
    if (past_ck_value!=ck_value) {
        cgck_xhttp.open("GET",`../server/scripts/updateExpertsInfo.php?ck=${ck_value}`,false);
        cgck_xhttp.send();
        if (cgck_xhttp.readyState==4 && cgck_xhttp.status==200){
            cg.innerHTML = cgck_xhttp.responseText;
        }
    }
    past_ck_value = ck_value;
}
on_ck_change();

ck.addEventListener('change',on_ck_change);

