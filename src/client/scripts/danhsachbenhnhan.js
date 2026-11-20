let danh_sach = document.getElementsByClassName("lichkham_card");

const form = document.getElementById("main_form");
const ten_bn = document.getElementById('ten_bn');



function removeAccents(str) {
  return str.normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd').replace(/Đ/g, 'D');
}

function applyFilter(ten) {

    for (let x=0;x<danh_sach.length;x++) {
        var this_element = danh_sach[x];
        var childs = this_element.children;
        let pass = true;

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
    applyFilter(sanitize(ten_bn.value));
});