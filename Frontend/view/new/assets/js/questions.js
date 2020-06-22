var count = 0;
function addQuestion(){
    $("#questions").append(
        "<div class='col-lg-12 card card-body shadow mb-2' id='question"+count+"'>"+
        "<div class='col-lg-6 offset-lg-6 row mb-2 px-0 mb-3'>"+
            "<button class='col-lg-1 offset-lg-5 mr-2 btn btn-outline-success' onclick='toUp(\"question"+count+"\")'>"+
                "<i class='fas fa-sort-up trash-icon offset-lg-2 mx-0'></i>"+
            "</button>"+
            "<button class='col-lg-1 mr-2 btn btn-outline-success' onclick='toDown(\"question"+count+"\")'>"+
                "<i class='fas fa-sort-down trash-icon offset-lg-2 mx-0'></i>"+
            "</button>"+
            "<div class='col-lg-3 px-0'>"+
                "<input type='checkbox' id='required"+count+"' data-toggle='toggle' data-onstyle='info' data-on='Obrigatorio'"+
                    "data-off='Opcional'>"+
            "</div>"+
            "<button class='btn btn-outline-danger col-lg-1' onclick='rmQuestion(\"question"+count+"\")'>"+
                "<i class='far fa-trash-alt trash-icon offset-lg-2 mx-0'></i>"+
            "</button>"+
        "</div>"+
        "<div class='col-lg-12 row pr-0'>"+
            "<div class='edit"+count+" col-lg-6 border-right border-secondary'>"+
                "<input type='text' class='form-control col-lg-12 mb-2' onchange='changeTitle(this.value, this.id)' id='nome"+count+"' placeholder='Pergunta'>"+
                "<select class='form-control col-lg-9 mb-2' id='type"+count+"' onchange='changeQuest(this.value, this.id)'>"+
                    "<option value=''>Selecione...</option>"+
                    "<option value='text'>Texto curto</option>"+
                    "<option value='textarea'>Texto longo</option>"+
                    "<option value='select'>Lista</option>"+
                    "<option value='checkbox'>Escolher varios</option>"+
                    "<option value='radio'>Escolher um</option>"+
                    "<option value='date'>Data</option>"+
                    "<option value='datetime'>Data e horario</option>"+
                    "<option value='time'>Horario</option>"+
                    "<option value='number'>Numero</option>"+
                    "<option value='color'>Cor</option>"+
                    "<option value='range'>intervalo de valores</option>"+
                "</select>"+
                "<div class='col-lg-12 px-0' id='options"+count+"'></div>"+
            "</div>"+
            "<div class='preview"+count+" col-lg-6 pr-0'>"+
                "<p class='col-lg-12 text-center'>Pre-visualização</p>"+
                "<h4 id='title"+count+"' class='col-lg-12 mb-2'></h4>"+
                "<div id='item"+count+"' class='col-lg-12'></div>"+
            "</div>"+
        "</div>"+
    "</div>"
    );
    $('#required'+count).bootstrapToggle();
    count++;
}

function rmQuestion(id){
    $("#"+id).remove();
}

function toUp(id){
    const elem = $("#"+id)[0];
    if(elem.previousSibling != null){
        const prevId = elem.previousSibling.id;
        $("#"+id).remove();
        $(elem).insertBefore("#"+prevId);
    }else{
        alert("Esta já é a primeira pergunta")
    }
}

function toDown(id){
    const elem = $("#"+id)[0];
    if(elem.nextSibling != null){
        const nextId = elem.nextSibling.id;
        $("#"+id).remove();
        $(elem).insertAfter("#"+nextId);
    }else{
        alert("Esta já é a ultima pergunta")
    }
}