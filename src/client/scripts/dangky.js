const form = document.getElementById("main_form");
const red_requireds = document.getElementsByClassName("red_required");

for (let i = 0; i<red_requireds.length; i++){
    red_requireds[i].style.display = 'none';
}

form_input_ids = [
    "hoten",
    "socccd",
    "ngaysinh",
    "sodt",
    "emailtk",
    "mk",
    "rptmk"
];

function validate(name,input_obj){
    if (name=="sodt" && input_obj.value.length<10){
        return false;
    } else if (name=="socccd" && input_obj.value.length!=12){
        return false;
    } else if (name=="rptmk" && input_obj.value!=document.getElementById("input_mk").value){
        return false;
    }
    return true;
}

form.addEventListener("submit",function(event){
    var validation_result = true;
    for (let x=0;x<form_input_ids.length;x++) {

        let input_element = document.getElementById(`input_${form_input_ids[x]}`);
        let label_element = document.getElementById(`label_${form_input_ids[x]}`);

        if (!validate(form_input_ids[x],input_element) || !input_element.checkValidity() || input_element.value == null) {
            validation_result = false;
            event.preventDefault();

            let tag = label_element.querySelector(".red_required");
            tag.style.display = 'inline';
        }
    }
    if (!validation_result){
        console.log("Test");
        
    }
    return validation_result;
})