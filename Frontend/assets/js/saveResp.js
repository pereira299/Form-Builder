function validate(){
    const questions = $(".quest");
    let res = []
    let valid  = true;
    for(let i = 0; i < questions.length; i++){
        const item = {}
        const quest = questions[i];
        const id = quest.id.replace("question", "");
        let required = $("#item"+id)[0].classList.value.indexOf("required");
        if(required >= 0){
            required = true;
        }else{
            required = false;
        }

        const options = $("#item"+id).children();
        if(options.length == 1){
            item.text = options[0].value;
        }else if(options.length > 1){
            const tag = options[1].tagName;
            switch(tag){
                case "INPUT":
                    const txt0 = options[0].value;
                    const txt1 = options[1].value;
                    item.text = txt0 + "  " + txt1;
                    break;
                case "DIV":
                    item.text = $("#item"+id+" > p > input").val();
                    break;
                case "LABEL":
                    item.text = getChecked(id);
                    break;
            }
        }

        if(item.text.trim() == "" && required){
            valid = false;
            const nome = $("#title"+id).html();
            alert('A pergunta "'+nome+'" é obrigatoria');
            break;
        }

        item.quest = id;
        item.user = sessionStorage.getItem("user");
        res.push(item);
    }

    if(valid){
        return res;
    }else{
        return false;
    }
}

function getChecked(id){
    const label = $("#item"+ id +" > label");
    let res = [];
    for(let i = 0; i < label.length; i++){
        const item = label[i].children[0]

        if(item.checked){
            res.push(label[i].children[1].innerHTML);
        }
    }
    switch(res.length){
        case 0: 
            res = "";
            break;
        case 1:
            res = res[0];
            break;
        default:
            res = res.join(", ");
    }

    return res;
}
async function salvar(){
    debugger;
    const valid = validate();
    
    if(valid != false){
        debugger;
        let data = {answers:valid};
        let ref = window.location.href.split("/");
        const form = ref[ref.length-1];
        data = JSON.stringify(data);
        let res;
        await $.ajax({
            url:"http://192.168.15.180/answer/form/"+form,
            method:"POST",
            data:data
        }).done((data, status, xhr) => {
            debugger;
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

/*
    {
        form: int, 
        answers:[
            {
                text: resp,
                quest: int,
                user: int
            },
            {
                text: resp,
                quest: int,
                user: int
            },
        ]
    }
*/