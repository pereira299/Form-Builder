function changeQuest(type, id){
    id = id.replace("type","");
    $("#item"+id).empty();
    let elem, options;
    switch(type){
        case"text":
            elem = "<input type='text' class='form-control' placeholder='Resposta...'>";
            options = false;
            break;
        case"textarea":
            elem = "<textarea class='form-control' placeholder='Resposta...'></textarea>";
            options = false;
            break;
        case"select":
            elem = "<select class='form-control'><option value=''>Selecione...</option></select>";
            options = true;
            break;
        case"checkbox":
            elem = "<label class='row col-lg-12'><input type='checkbox' class='form-control-sm mr-2'><p>Item</p></label>";
            options = true;
            break;
        case"radio":
            elem = "<label class='row col-lg-12'><input type='radio' name='radio"+id+"' class='form-control-sm mr-2'><p>Item</p></label>";
            options = true;
            break;
        case"date":
            elem = "<input type='date' class='form-control'>";
            options = false;
            break;
        case"datetime":
            elem = "<input type='date' class='form-control mb-2'><input type='time' class='form-control'>";
            options = false;
            break;
        case"time":
            elem = "<input type='time' class='form-control'>";
            options = false;
            break;
        case"number":
            elem = "<input type='number' class='form-control'>"
            options = false;
            break;
        case"color":
            elem = "<input type='color' class='form-control'>"
            options = false;
            break;
        case"range":
            elem = "<p>"+
            "<input type='text' id='amount' readonly style='border:0; color:#17a2b8; font-weight:bold;'>"+
            "</p>"+
            "<div id='slider"+id+"'></div>";
            options = true;
            break;
    }
    $("#item"+id).append(elem);
    if(type == "range"){
        setSlider("#slider"+id)
    }
    if(options){
        hiddenOptions(id);
        showOptions(type, id);
    }else{
        hiddenOptions(id);        
    }
}

function changeTitle(value, id){
    if(value.length > 2){
        $("#"+id).css("border-color", "#ced4da");
        value = value.charAt(0).toUpperCase() + value.slice(1)
        id = id.replace("nome", "");
        $("#title"+id).html(value);
    }else{
        $("#"+id).css("border-color", "#dc3545");
    }
}
function setSlider(id){
    $( id ).slider({
        range: true,
        min: 0,
        max: 100,
        values: [ 25, 75 ],
        slide: function( event, ui ) {
          $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        }
      });
}
function hiddenOptions(id){
    $("#options"+id).empty();
}

function showOptions(type, id){
    
    const op = randomId();
    $("#options"+id).append(
        "<div class='col-lg-6 row px-0 mx-0'>"+
        "<input type'text' id='"+op+"' onchange='changeOption(\""+type+"\", \""+op+"\", this.value)' class='col-lg-9 form-control' placeholder='Opção'>"+
        "<buttn class='btn btn-info col-lg-2 ml-2' onclick='addOptions(\""+type+"\",\""+id+"\")'>"+
        "<i class='fas fa-plus'></i>"+
        "</button>"+
        "</div>"
    )
    switch(type){
        case "select":
            $("#item"+id+" > select").append(
                "<option class='"+op+"' value=''></option>"
            )
            break;
        case "checkbox":
            $("#item"+id+" > label").addClass(op)
            break;
        case "radio":
            $("#item"+id+" > label").addClass(op)
            break;
        case "range":
            $("#options"+id).empty()
            $("#options"+id).append(
                "<div class='col-lg-12 row px-0 mx-0 row'>"+
                "<input type='number' class='col-lg-5 form-control mr-2' onchange='changeOption(\"rangeIn\", \""+id+"\", this.value)' value='0'>"+
                "<input type='number' class='col-lg-5 form-control' onchange='changeOption(\"rangeOut\", \""+id+"\", this.value)' value='100'>"+
                "</div>"
            )
            break;
    }
    

}

function changeOption(type, id, value){
    switch(type){
        case "select":
            $("option."+id).val(value);
            $("option."+id).html(value);
            break;
        case "checkbox":
            $("."+id+" > input").val(value);
            $("."+id+" > p").html(value);
            break;
        case "radio":
            $("."+id+" > input").val(value);
            $("."+id+" > p").html(value);
            break;
        case "rangeIn":
            $("#slider"+id).slider("option", "min", parseInt(value));
            break;
        case "rangeOut":
            $("#slider"+id).slider("option", "max", parseInt(value));
            break;
    }
}
function addOptions(type, id){
    const op = randomId();
    $("#options"+id).append(
        "<div class='col-lg-6 row px-0 mx-0 mt-2'>"+
        "<input type'text' id='"+op+"' onchange='changeOption(\""+type+"\", \""+op+"\", this.value)' class='col-lg-9 form-control' placeholder='Opção'>"+
        "<buttn class='btn btn-danger col-lg-2 ml-2' onclick='rmOptions(\""+op+"\")'>"+
        "<i class='fas fa-minus'></i>"+
        "</button>"+
        "</div>"
    )
    switch(type){
        case "select":
            $("#item"+id+" > select").append(
                "<option class='"+op+"' value=''></option>"
            )
            break;
        case "checkbox":
            $("#item"+id).append("<label class='row col-lg-12 "+op+"'><input type='checkbox' class='form-control-sm mr-2'><p>Item</p></label>")
            break;
        case "radio":
            $("#item"+id).append("<label class='row col-lg-12 "+op+"'><input type='radio' name='radio"+id+"' class='form-control-sm mr-2'><p>Item</p></label>")
            break;
    }
}

function rmOptions(id){
    $("#"+id).parent().remove();
    $("."+id).remove();

}

function randomId(){
    const chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    let res = "";
    const qtdd = Math.floor(Math.random() * (10 - 5) ) + 5;
    for(let i = 0; i < 8; i++){
        const pos = Math.floor(Math.random() * chars.length );
        res = res+chars.charAt(pos);
    }
    return res;
}