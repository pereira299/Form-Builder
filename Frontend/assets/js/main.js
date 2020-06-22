async function search(){
    
    const term = $(".search").val();
    const data = {"name":term}
    const res = await server(data);
    $("#itens").empty();
    for(let i = 0; i < res.length; i++){
        const item = res[0];
        $("#itens").append(
            "<div class='item col-lg-3 mb-2'>"+
                        "<div class='btn-group col-lg-12 px-0 mx-0'>"+
                            "<button class='btn btn-info col-lg-10' data-toggle='collapse' href='#form" + item.id + "'"+ 
                            "role='button' aria-expanded='false' aria-controls='form" + item.id + "'>"+
                             item.name + 
                            "</button>"+
                            "<button class='btn btn-info col-lg-2' id='rm" + item.id + "'>"+
                               "<i class='far fa-times-circle remove' aria-hidden='true'></i>"+
                            "</button>"+
                        "</div>"+
                        "<div class='collapse' id='form" + item.id + "'>"+
                            "<div class='card card-body'>"+
                                "<a class='btn btn-outline-info' href='/view/answers/"+ item.id+"'>Responder</a>"+
                                "<a class='btn btn-outline-info my-2' href='/view/form/answers/"+ item.id+"'>Ver respostas</a>"+
                            "</div>"+
                        "</div>"+
                    "</div>"
        )
    }

}

async function server(data){
    data = JSON.stringify(data);
    let res;
    await $.ajax({
        url:"http://192.168.15.180/form/name",
        method:"POST",
        data:data
    }).done((data, status, xhr) => {
        res = JSON.parse(data);
    })
     
    
    return res;
}

async function rmForm(id){
    id = id.replace("rm", "");

    await $.ajax({
        url:"http://192.168.15.180/form/remove/"+id,
    }).done((data, status, xhr) => {
        res = JSON.parse(data);
        if(res == null){
            alert("Removido com sucesso!")
            $("#item"+id).remove();
        }else{
            alert("Ocorreu um erro ao remover")
        }
    });
}