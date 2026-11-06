//Plan: Set multi-stage form so you can fill in with AJAX along the way.

//Goal: Able to adjust form according to selected doctor's, faculty's work time and integrate it 
//into the form itself.

let current_stage = 0;
const number_of_stages = 3;

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {

}

proceed_button = document.getElementById("pbutton");
return_button = document.getElementById("rbutton");
return_button2 = document.getElementById("rbutton2");

stages = [
    document.getElementById("form_step1"),
    document.getElementById("form_step2"),
    document.getElementById("form_step3"),
];
stages_preload_event = [

];

past_response = 0;
sub_stages = [
    [],
    [
        [document.getElementById("form_step2_1"),document.getElementById("form_step2_2")],
        function(){
            kham_ck = document.getElementById("kham_ck");
            let returned_value = 0;
            if (kham_ck.value=="ck"){
                returned_value = 0;
            } else {
                returned_value = [0,1];
            }
            if (returned_value!=past_response) {
                //Update the cg list here.
                if (returned_value==1 || (Array.isArray(returned_value) && returned_value.includes(1))) {
                    
                }
                past_response = returned_value;
            }
            return returned_value;
        } //Function that returns 0 (for form_step_2_1 to be displayed) or 1 (for form_step_2_2)
    ],
    []
];
display_type_storage = [];

for (let i = 0; i<stages.length; i++) {
    
    display_type_storage[stages[i].id] = stages[i].style.display;
    stages[i].style.display = 'none';

}
for (let i = 0; i<sub_stages.length; i++) {
    if (Array.isArray(sub_stages[i][0])) {
        //sub_stage[i][0]: The documents that gets decided.
        //sub_stage[i][1]: The function.
        for (let j = 0; j < sub_stages[i][0].length; j++){

            var this_element = sub_stages[i][0][j];

            display_type_storage[this_element.id] = this_element.style.display;
            this_element.display = 'none';

        }
    }
}
display_type_storage["form_step_proceed"] = document.getElementById("form_step_proceed").style.display;
display_type_storage["form_step_finish"] = document.getElementById("form_step_finish").style.display;

function update_current_stage() {
    if (current_stage==number_of_stages-1) {
        document.getElementById("form_step_proceed").style.display = "none";
        document.getElementById("form_step_finish").style.display = display_type_storage["form_step_finish"];
    } else {
        document.getElementById("form_step_proceed").style.display = display_type_storage["form_step_proceed"];
        document.getElementById("form_step_finish").style.display = "none";
    }
    if (current_stage==0) {

    } else {
        
    }

    for (let i = 0; i<stages.length; i++) {
        if (i!=current_stage) {
            stages[i].style.display = 'none';
            continue;
        } else {
            stages[i].style.display = display_type_storage[stages[i].id];

            //If the sub_stage for stage i is defined, and there's something in the first list.
            if (Array.isArray(sub_stages[i]) && Array.isArray(sub_stages[i][0]) && sub_stages[i][0].length>0) {

                //Then make the decision and display what wins.
                //I didn't properly structure the form lol. So right now it just runs the placeholder function.

                const result = sub_stages[i][1]();
                console.log("Result",result);

                for (let j = 0; j < sub_stages[i][0].length; j++){

                    var this_element = sub_stages[i][0][j];
                    if (j==result || (Array.isArray(result) && result.includes(j))) {
                        this_element.style.display = display_type_storage[this_element.id];
                    } else {
                        this_element.style.display = 'none';
                    }
                }
            }
        }
    }
}
update_current_stage();

function increment_stage(increment) {
    
    if (current_stage+increment>=number_of_stages || current_stage+increment<0) {
        return;
    }
    current_stage += increment;
    console.log(current_stage);
    update_current_stage();
    
}

proceed_button.addEventListener("click",function(){
    increment_stage(1);
});

return_button.addEventListener("click",function(){
    increment_stage(-1);
});

return_button2.addEventListener("click",function(){
    increment_stage(-1);
});