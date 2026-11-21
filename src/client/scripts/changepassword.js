const form = document.getElementById("main_form");
const mk = document.getElementById("input_mk");
const rpt_mk = document.getElementById("input_rptmk");



form.addEventListener("submit",function(event){
    let repeated = rpt_mk.value;
    let mkhau = mk.value;
    if (repeated!=mkhau) {
        event.preventDefault();
        alert("Mật khẩu lặp lại không đúng!");
        return false;
    }
    return true;
});
