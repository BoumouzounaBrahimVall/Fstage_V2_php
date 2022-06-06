const verifyCvUploaded = (num) =>
{
    console.log(num);
    console.log(`num : ${num}`);
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false
    });


    let cvInput=document.getElementById('cv');
    let offre=document.getElementById('noffre');
    offre.setAttribute('value',num);
    console.log(`cv : ${cvInput.value}`);
    if ( cvInput.value==2){
        myModal.show();
    }

}