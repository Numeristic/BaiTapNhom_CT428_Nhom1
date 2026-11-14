const input_keys = [
    "maphieu",
    "ck",
    "cg",
    "ngaykham",
    "lydokham"
];
const checked_keys = [];
const selection_keys = [];

let ck = document.getElementById('input_ck');
let cg = document.getElementById('input_cg');
let timeslot_container = document.getElementById('timeslots_container');

let cgck_xhttp = new XMLHttpRequest;
let cgkg_xhttp = new XMLHttpRequest;


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
let past_cg_value = "";
function on_cg_change(){
    let ck_value = ck.value;
    let cg_value = cg.value;
    parameters = `ck=${ck_value}`;
    if ((past_cg_value!=cg_value)||(past_ck_value!=ck_value)) {
        if (cg_value!="") {
            parameters=`${parameters}&cg=${cg_value}`;
        }
        cgkg_xhttp.open("GET",`../server/scripts/loadTimeSlots.php?${parameters}`,false);
        cgkg_xhttp.send();
        if (cgkg_xhttp.readyState==4 && cgkg_xhttp.status==200){
            timeslot_container.innerHTML = `${cgkg_xhttp.responseText}`;
        }
    }
    past_cg_value = cg_value;
}
function on_ck_change() {
    let ck_value = ck.value;
    if (past_ck_value!=ck_value && past_ck_value!="") {
        cgck_xhttp.open("GET",`../server/scripts/updateExpertsInfo.php?ck=${ck_value}`,false);
        cgck_xhttp.send();
        if (cgck_xhttp.readyState==4 && cgck_xhttp.status==200){
            cg.innerHTML = "<option value=\"\">Trống (Khám theo chuyên khoa)</option>\n";
            cg.innerHTML = `${cg.innerHTML}\n${cgck_xhttp.responseText}`;
        }
    }
    on_cg_change();
    past_ck_value = ck_value;
}
on_ck_change();
on_cg_change();

ck.addEventListener('change',on_ck_change);
cg.addEventListener('change',on_cg_change);

