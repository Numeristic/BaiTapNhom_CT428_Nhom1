let danh_sach = document.getElementsByClassName("lichkham_card");

const form = document.getElementById("main_form");
let ck = document.getElementById('ck');
const cg = document.getElementById('cg');
const khoang = document.getElementById('khoang');
const ngaykham = document.getElementById('ngaykham');
const trangthai = document.getElementById('trangthai');

const init_ck_inner = ck.innerHTML;
const init_cg_inner = cg.innerHTML;
const init_tt_inner = trangthai.innerHTML;


let past_ck_value = ck.value;
let past_cg_value = cg.value;

let cgck_xhttp = new XMLHttpRequest;
let cgkg_xhttp = new XMLHttpRequest;
let loadck_xhttp = new XMLHttpRequest;
let loadtt_xhttp = new XMLHttpRequest;


function on_ck_change() {
    let ck_value = ck.value;
    if (past_ck_value!=ck_value) {
        cgck_xhttp.open("GET",`../server/scripts/updateExpertsInfo.php?ck=${ck_value}`,false);
        cgck_xhttp.send();
        if (cgck_xhttp.readyState==4 && cgck_xhttp.status==200){
            console.log(cgck_xhttp.responseText);
            cg.innerHTML = `${init_cg_inner}\n${cgck_xhttp.responseText}`;
        }
    }
    //on_cg_change();
    
    past_ck_value = ck_value;
}

function loadCk() {
    loadck_xhttp.open("GET","../server/scripts/loadCk2.php",false);
    loadck_xhttp.send();

    if (loadck_xhttp.readyState==4 && loadck_xhttp.status==200) {
        ck.innerHTML = `${init_ck_inner}\n${loadck_xhttp.responseText}`;
    }
}
function loadTrangThai() {
    loadtt_xhttp.open("GET","../server/scripts/loadTrangThai.php",false);
    loadtt_xhttp.send();

    if (loadtt_xhttp.readyState==4 && loadtt_xhttp.status==200) {
        trangthai.innerHTML = `${init_tt_inner}\n${loadtt_xhttp.responseText}`;
    }
}
loadCk();
loadTrangThai();

function applyFilter(bacsi,chuyenkhoa,ngay_type,ngay,trangthai) {

    for (let x=0;x<danh_sach.length;x++) {
        var this_element = danh_sach[x];
        var childs = this_element.children;
        pass = true;
        /*

        0 <td>$stt</td>
        1 <td>$id</td>
        2 <td>$id_bn</td>
        3 <td>$ten_ck</td>
        4 <td>$ht_bs</td>
        5 <td>$ngaykham</td>
        6 <td>$lydokham</td>
        7 <td>$trangthai</td>
        8 <td style=\"display: none;\">$id_bs</td>
        9 <td style=\"display: none;\">$id_ck</td>
        10 <td><a href=\"phieukhambenh.php?id=$id\">Xem</a></td>

        */
        if (chuyenkhoa!=null) {
            if (childs[9].innerHTML!=chuyenkhoa) {
                pass = false;
            }
        }
        if (bacsi!=null) {
            if (childs[8].innerHTML!=bacsi) {
                pass = false;
            }
        }
        if (ngay_type!=null && ngay!=null) {
            card_date = new Date(childs[5].innerHTML);
            given_date = new Date(ngay);

            card_date = card_date.getTime();
            given_date = given_date.getTime();
            console.log(ngay);
            console.log(childs[5].innerHTML);
            if ((ngay_type==1 && card_date>=given_date)||(ngay_type==2 && card_date!=given_date)||(ngay_type==3 && card_date<=given_date)) {
                pass = false;
            }
        }
        if (trangthai!=null) {
            if (childs[7].innerHTML!=trangthai) {
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
    applyFilter(sanitize(cg.value),sanitize(ck.value),sanitize(khoang.value),sanitize(ngaykham.value),sanitize(trangthai.value));
});
ck.addEventListener('change',on_ck_change);