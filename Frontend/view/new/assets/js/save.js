function validate(){
    let data = {}, valid = true;
    const title = $("#title").val();
    const desc = $("#desc").val();
    
    if(title.length == 0){
        alert("Seu formulario precisa de um titulo");
        valid = false;
    }else if(title.length < 3){
        alert("O formulario possui um titulo muito curto, insira ao menos 4 caracteres");
        valid = false;
    }else{
        data.name = title;
        data.desc = desc;
    }
    

    const questions = $("#questions");
    const qtdd = questions.children().length;
    if(qtdd == 0){
        alert("Não há perguntas nesse formulario, insira ao menos uma");
        valid = false;
    }else{
        data.questions = [];
        for(let i = 0; i < qtdd; i++){
            const quest = questions.children()[i];
            const id = quest.id.replace("question", "");
            const nome = $("#nome"+id).val();
            const type = $("#type"+id).val();
            let options;
            if(type == "range"){
                options = $("#options"+id).children().children();
            }else{
                options = $("#options"+id).children();
            }
            
            let require = $("#required"+id)[0].checked;
            let pergunta = {};
            switch(require){
                case true:
                    pergunta.require = 1;
                    break;
                case false:
                    pergunta.require = 0;
                    break;
            }
            if(nome.length == 0){
                alert("A "+(i+1)+"º pergunta precisa ter um titulo");
                valid = false;
                break;
            }
            if(nome.length < 3){
                alert("A "+(i+1)+"º pergunta tem um titulo muito curto, insira ao menos 3 caracteres");
                valid = false;
                break;
            }
            pergunta.title = nome;
            pergunta.pos = i;

            if(type.length == 0){
                alert("A "+(i+1)+"º pergunta precisa ter um tipo de resposta");
                valid = false;
                break;
            }
            pergunta.type = type;
            if(options.length == 1){
                alert("É necessario ao menos duas opções para o tipo de resposta da "+(i+1)+"º pergunta");
                valid = false;
                break;
            }
            pergunta.options = [];
            if(options.length > 1){
                let itens = []
                for(let o = 0; o < options.length; o++){
                    
                    const op = options[o];
                    let input;
                    if(type == "range"){
                        input = op.value;
                    }else{
                        input = $(op).children()[0].value;
                    }

                    if(input.length < 1){
                        alert(" A "+(o+1)+"º opção da "+(i+1)+"º pergunta deve ser preenchida ou excluida");
                        valid = false;
                        break;
                    }
                    itens.push(input);
                }
                if(!valid){
                    break;
                }
                pergunta.options = itens;
            }
            data.questions.push(pergunta);
        }

    }
    if(valid){
        return data;
    }else{
        return false;
    }
}

async function save(){
    let data = validate();
    if( data != false){

        data = JSON.stringify(data);
        let res;
        await $.ajax({
            url:"http://192.168.15.180/form/add",
            method:"POST",
            data:data
        }).done((data, status, xhr) => {
            res = JSON.parse(data);
            if(res == 1){
                alert("salvo com sucesso!")
                window.location.href = "http://localhost:8080";
            }else{
                alert("Ocorreu um erro ao salvar")
            }
        });
        
        
    }
}