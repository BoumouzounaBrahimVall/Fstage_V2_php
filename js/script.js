

 
var nav = document.querySelector('nav');

var etudiant = document.querySelector('#tab-etudiant');
var whoIsTheUser=document.querySelector('#who');
var responsable= document.querySelector('#tab-responsible');

etudiant.addEventListener('click', function () {
etudiant.classList.add('active','btn-seconnecter');
responsable.classList.remove('active','btn-seconnecter');
whoIsTheUser.setAttribute("value", "etudiant");
});
responsable.addEventListener('click', function () {
    responsable.classList.add('active','btn-seconnecter');
    whoIsTheUser.setAttribute("value", "responsable");
    etudiant.classList.remove('active','btn-seconnecter');
});

