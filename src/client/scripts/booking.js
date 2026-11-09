//Plan: Set multi-stage form so you can fill in with AJAX along the way.

//Goal: Able to adjust form according to selected doctor's, faculty's work time and integrate it 
//into the form itself.

let current_stage = 0;
const number_of_stages = 3;

const xhttp = new XMLHttpRequest(); //Tìm kiếm chuyên gia dựa trên Chuyên khoa.
const xhttp2 = new XMLHttpRequest(); //Tìm kiếm khung giờ làm việc phù hợp với Chuyên khoa/Chuyên gia.

proceed_button = document.getElementById("pbutton");
return_button = document.getElementById("rbutton");
return_button2 = document.getElementById("rbutton2");

past_response = 0;

stages = [
    document.getElementById("form_step1"),
    document.getElementById("form_step2"),
    document.getElementById("form_step3"),
];
stages_preload_event = [

];
sub_stages = [
    [],
    [
        [document.getElementById("form_step2_1")],
        function(){
            kham_ck = document.getElementById("kham_ck");
            let returned_value = 0;
            if (kham_ck.value=="ck"){
                returned_value = 1;
            } else {
                returned_value = 0;
            }

            let ck_value = document.getElementById("ck_selection").value;

            if (ck_value!=past_response && (returned_value==0 || (Array.isArray(returned_value) && returned_value.includes(0)))) {
                //Update the cg list here.
                if (returned_value==0 || (Array.isArray(returned_value) && returned_value.includes(1))) {
                    xhttp.open("GET",`../server/scripts/updateExpertsInfo.php?ck=${document.getElementById("ck_selection").value}`,false);
                    xhttp.send();
                    if (xhttp.readyState==4 && xhttp.status==200) {
                        document.getElementById("prof_selection").innerHTML = xhttp.responseText;
                        console.log("Updated.");
                        console.log(xhttp.responseText);
                    }
                    console.log("Yes we update the list.");
                }
                past_response = ck_value;
            }
            return returned_value;
        } //Function that returns 0 (for form_step_2_1 to be displayed) or 1 (for form_step_2_2)
    ],
    [
        [document.getElementById("form_step3")],
        function() {
            //Load available time slots.
            
            return 0;
        },
    ]
];
display_type_storage = [];

for (let i = 0; i<stages.length; i++) {
    if (display_type_storage[stages[i].id]!=null) {
        continue;
    }
    display_type_storage[stages[i].id] = stages[i].style.display;
    stages[i].style.display = 'none';

}
for (let i = 0; i<sub_stages.length; i++) {
    if (Array.isArray(sub_stages[i][0])) {
        //sub_stage[i][0]: The documents that gets decided.
        //sub_stage[i][1]: The function.
        for (let j = 0; j < sub_stages[i][0].length; j++){

            var this_element = sub_stages[i][0][j];
            //console.log(i,j,this_element);
            if (display_type_storage[this_element.id]!=null){
                continue;
            }
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
                //I didn't properly structure the form. So right now it just runs the placeholder function.

                const result = sub_stages[i][1]();
                //console.log("Result",result);

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