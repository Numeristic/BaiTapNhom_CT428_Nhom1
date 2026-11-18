const form = document.getElementById("main_form");

const idck = document.getElementById("input_idck");
const tenck = document.getElementById("input_tenck");


if (form && idck && tenck) {
    form.addEventListener("submit",function(event){
        event.preventDefault();

        let add_xhttp = new XMLHttpRequest;
        add_xhttp.open("POST","../server/scripts/addCk.php",false);
        add_xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        add_xhttp.send(`idck=${idck.value}&tenck=${tenck.value}`);

        /*if (add_xhttp.readyState==4 && add_xhttp.status==200) {

        }*/
        alert(add_xhttp.responseText);
    });
}