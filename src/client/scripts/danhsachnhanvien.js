let danh_sach = document.getElementsByClassName("lichkham_card");

const form = document.getElementById("main_form");
const ck = document.getElementById('ck');
const ten_bs = document.getElementById('ten_bs');

const init_ck_inner = ck.innerHTML;

let past_ck_value = ck.value;

let loadck_xhttp = new XMLHttpRequest;

function loadCk() {
    loadck_xhttp.open("GET","../server/scripts/loadCk2.php",false);
    loadck_xhttp.send();

    if (loadck_xhttp.readyState==4 && loadck_xhttp.status==200) {
        ck.innerHTML = `${init_ck_inner}\n${loadck_xhttp.responseText}`;
    }
}
loadCk();

function removeAccents(str) {
  return str.normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd').replace(/Đ/g, 'D');
}

function applyFilter(chuyenkhoa,ten) {

    for (let x=0;x<danh_sach.length;x++) {
        var this_element = danh_sach[x];
        var childs = this_element.children;
        let pass = true;

        if (chuyenkhoa!=null) {
            if (childs[6].innerHTML!=chuyenkhoa) {
                pass = false;
            }
        }
        if (ten!=null) {
            let text = removeAccents(childs[2].innerHTML.toLowerCase());
            if (!text.includes(removeAccents(ten.toLowerCase()))) {
                pass = false;
            }
        }
        if (pass){
            this_element.style.display = 'table-row'; 
        } else {
            this_element.style.display = "none";
        }
    }
}
//cg.addEventListener('change',on_cg_change);

//applyFilter(null,"nk",null,null,null);
function sanitize(value) {
    if (value=="") {
        return null;
    }
    return value;
}
form.addEventListener("submit",function(event){
    event.preventDefault();
    applyFilter(sanitize(ck.value),sanitize(ten_bs.value));
});