let input_keys = [
    "idck",
    "tenck"
];

const idck = document.getElementById("input_idck");
let delete_button = document.getElementById("delete_button");
const return_button = document.getElementById("return_button2");

const label_ck = document.getElementById("label_ck");
const ck = document.getElementById("input_ck");

let saved_values = [];
for (let x=0;x<input_keys.length;x++){

    var input_obj = document.getElementById(`input_${input_keys[x]}`);
    saved_values[input_keys[x]] = input_obj.value;

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
}
return_button.addEventListener("click",function(){
    show();
});

if (delete_button && idck){

    delete_button.addEventListener("click",function(event){
        event.preventDefault();
        let prompt_result = confirm("Bạn có chắc muốn xóa chuyên khoa này?");
        if (prompt_result==true){
            let delete_xhttp = new XMLHttpRequest;
            delete_xhttp.open("POST","../server/scripts/deleteCk.php",false);
            delete_xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            delete_xhttp.send(`idck=${idck.value}`);
            
            console.log(idck.value);

            if (delete_xhttp.readyState==4 && delete_xhttp.status==200) {
                /*alert("Xóa thành công.");*/
                //window.location.href = "../user/thongtincanhan.php";
                console.log(delete_xhttp.responseText);
                alert(delete_xhttp.responseText);
            } else {
                console.log(`${delete_xhttp.statusText}`);
                console.log(`${delete_xhttp.status}`);
                alert(delete_xhttp.responseText);
            }
        }
    });

}
