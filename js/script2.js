
const verifyCvOnLoad = () =>
{

    let cvInput=document.getElementById('cv');
    console.log( `cvInput : ${cvInput.value}`);
    console.log(cvInput.value.length)
    var myModal1 = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false
    });

    if ( cvInput.value.length==0){
        myModal1.show();
    }


}
const verifyCvUploaded = (num) =>
{

    var myModalPostuler = new bootstrap.Modal(document.getElementById('myModalPostuler'), {
        keyboard: false
    });


    let cvInput=document.getElementById('cv');
    let offre=document.getElementById('noffrePos');
    offre.setAttribute('value',num);
    console.log(`cv : ${cvInput.value}`);

        myModalPostuler.show();

}

const modifySubmitdate = (inputId, btnId,subbtn) => {


    console.log('pass');
    let subBtn=document.getElementById(subbtn);
    let input = document.getElementsByClassName(inputId);
    let i;
    let btn = document.getElementById(btnId);
    let icon = btn.firstChild;
    if (icon.getAttribute("id") === "modifier") {

        subBtn.setAttribute("class","btn bt");

        btn.setAttribute("class","d-none");
        for(i = 0; i < input.length; i++)
        {
            input[i].disabled = false;
        }
        subBtn.setAttribute('value',btnId);
        subBtn.setAttribute('type','submit');


    }
    if (inputId==='inputDetail')
    {
        document.getElementsByClassName("trumbowyg-editor")[0].setAttribute('contenteditable',"true");
        input[2].parentElement.classList.remove('trumbowyg-disabled');
    }

}
