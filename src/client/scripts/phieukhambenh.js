const input_keys = [
    "maphieu",
    "ck",
    "cg",
    "ngaykham",
    "lydokham",
    "tt"
];

let ck = document.getElementById('input_ck');
let cg = document.getElementById('input_cg');
let undo_button = document.getElementById("return_button2");
let timeslot_container = document.getElementById('timeslots_container');

let cgck_xhttp = new XMLHttpRequest;
let cgkg_xhttp = new XMLHttpRequest;


let saved_values = [];
let radios = document.getElementsByName("khung_gio");
for (let x=0;x<input_keys.length;x++){
    //var label = document.getElementById(`label_${input_keys[x]}`);
    var input_obj = document.getElementById(`input_${input_keys[x]}`);
    //console.log(`input_${input_keys[x]}`);
    if (input_obj){
        saved_values[input_keys[x]] = input_obj.value;
    }
}
for (let x=0;x<radios.length;x++) {
    if (radios[x].tagName=="INPUT" && radios[x].checked) {
        saved_values["khung_gio"] = radios[x].value;
        break;
    }
}


console.log(saved_values);


function show(){
    for (let x=0;x<input_keys.length;x++){
        var input_obj = document.getElementById(`input_${input_keys[x]}`);
        if (input_obj){
            input_obj.value = saved_values[input_keys[x]];
            if (input_keys[x]=="ck") {
                on_ck_change();
            }
            if (input_keys[x]=="cg") {
                on_cg_change();
            }
        }
        
    }
    let current_radios = document.getElementsByName("khung_gio");
    let index = -1;
    for (let x=0;x<current_radios.length;x++) {
        current_radios[x].checked = false;
        if (current_radios[x].value==saved_values["khung_gio"]) {
            index = x;
        }
    }
    current_radios[index].checked = true;
}

let past_ck_value = ck.value;
let past_cg_value = cg.value;

function on_cg_change(){
    let ck_value = ck.value;
    let cg_value = cg.value;
    parameters = `ck=${ck_value}`;
    if (((past_cg_value!=cg_value)||(past_ck_value!=ck_value))) {
        past_cg_value = cg_value;
        if (cg_value!="") {
            parameters=`${parameters}&cg=${cg_value}`;
        }
        cgkg_xhttp.open("GET",`../server/scripts/loadTimeSlots.php?${parameters}`,false);
        cgkg_xhttp.send();
        if (cgkg_xhttp.readyState==4 && cgkg_xhttp.status==200){
            timeslot_container.innerHTML = `${cgkg_xhttp.responseText}`;
        }
    }
    cg_first = false;
}

function on_ck_change() {
    let ck_value = ck.value;
    if (past_ck_value!=ck_value) {
        past_ck_value = ck_value;
        cgck_xhttp.open("GET",`../server/scripts/updateExpertsInfo.php?ck=${ck_value}`,false);
        cgck_xhttp.send();
        if (cgck_xhttp.readyState==4 && cgck_xhttp.status==200){
            cg.innerHTML = "<option value=\"\">Trống (Khám theo chuyên khoa)</option>\n";
            cg.innerHTML = `${cg.innerHTML}\n${cgck_xhttp.responseText}`;
        }
    }
    on_cg_change();
}
//on_ck_change();
//on_cg_change();

ck.addEventListener('change',on_ck_change);
cg.addEventListener('change',on_cg_change);
undo_button.addEventListener('click',show);

