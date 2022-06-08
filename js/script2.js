
const verifyCvOnLoad = () =>
{

    let cvInput=document.getElementById('cv');
    console.log( `cvInput : ${cvInput.value}`);
    var myModal1 = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false
    });

    if ( cvInput.value==2){
        myModal1.show();
    }


}
const verifyCvUploaded = (num) =>
{
    console.log(num);
    console.log(`num : ${num}`);
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false
    });
    var myModalPostuler = new bootstrap.Modal(document.getElementById('myModalPostuler'), {
        keyboard: false
    });


    let cvInput=document.getElementById('cv');
    let offre=document.getElementById('noffrePos');
    offre.setAttribute('value',num);
    console.log(`cv : ${cvInput.value}`);
    if ( cvInput.value==2){
        myModal.show();
    }else
        myModalPostuler.show();

}
