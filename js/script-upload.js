// Import the functions you need from the SDKs you need
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyCAaAB6OJhrfZDi9nEqc1bOm500UrZyH38",
    authDomain: "fstage-9d9a5.firebaseapp.com",
    projectId: "fstage-9d9a5",
    storageBucket: "fstage-9d9a5.appspot.com",
    messagingSenderId: "224216473602",
    appId: "1:224216473602:web:98a77c74f3d1d501c1471b"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
console.log(firebase)

const fileIsAnImage = (file) => ["image/png", "image/jpeg"].includes(file.type);
const fileIsADocument = (file) => ["application/pdf"].includes(file.type);

const getPathToTpload = (file,pathType,id) => {
    let img_upload_path = "images/";
    let doc_upload_path = "document/";
    let fileDestination="";
    switch (pathType)
    {
        case 1://photo etudiant
            fileDestination=img_upload_path + "EtudiantPhoto/"+id+"IMG";

            break;
        case 2://cv etudiant
            fileDestination= doc_upload_path+ "EtudiantCv/"+id+"CV";
            break;
        case 3:///logo ent
            fileDestination=img_upload_path+ "CompanyPhoto/"+id+"IMG";
            break;
        case 4:/// photo responsable
            fileDestination=img_upload_path+ "ResposablesPhoto/"+id+"IMG";
        case 5:/// document rapport
            fileDestination=doc_upload_path+ "RapportStage/"+id+"RAP";
            break;
        case 6:/// document contrat
            fileDestination=doc_upload_path+ "ContratStage/"+id+"CRT";
            break;

    }

    fileDestination=fileDestination+'.'+file.name.split('.').pop();
    console.log(fileDestination);
    return fileDestination;
/*
    if (fileIsAnImage(file)) return img_upload_path;
    if (fileIsADocument(file)) return doc_upload_path;*/
};


const uploadFileToFirebase=(inputFile,btnSubmit,pathStorageId,pathType,id)=>
{
    document.getElementById("modal-progress-upload").innerHTML='    <div  class="modal fade" id="myModalHandaleUpload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="3"\n' +
        '              aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
        '            <div class="modal-dialog" style="min-width: 365px;max-width: 550px">\n' +
        '                <div class="modal-content d-flex justify-content-center " style="max-width: 800px;margin:auto;">\n' +
        '\n' +
        '                    <div class="modal-body mt-4">\n' +
        '                        <div class="container-fluid">\n' +
        '                            <div class="row">\n' +
        '\n' +
        '                                <span class="headline-form mx-auto" style="width: fit-content" > En cours d’importation</span>\n' +
        '\n' +
        '                            </div>\n' +
        '                            <div class="row">\n' +
        '                                <div class="d-flex flex-column justify-content-center p-xl-4 my-4">\n' +
        '                                    <img style="max-width: 145px;margin: auto " src="./../assets/icon/importImg.png" alt="">\n' +
        '                                    <div>\n' +
        '                                        <div id="progress-parent" class="progress mt-2">\n' +
        '                                            <div class="progress-bar"  id="progress" role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> <span id="progress-value"></span> </div>\n' +
        '                                        </div>\n' +
        '                                        <!--                                   -->\n' +
        '                                        <!--                                   <progress  value="0" max="100" id="progress" class="progressbar"></progress>-->\n' +
        '                                        <!--                                   <p id="uploading" class="successMsg"></p>-->\n' +
        '                                    </div>\n' +
        '                                    <span class="my-3" style="text-align: center;\n' +
        '\n' +
        'color: #565656;\n' +
        '">\n' +
        '                                    Veuillez patienter jusqu’a l’importation du fichier est terminer\n' +
        '                                </span>\n' +
        '\n' +
        '                                </div>\n' +
        '\n' +
        '                            </div>\n' +
        '\n' +
        '                        </div>\n' +
        '\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '\n' +
        '            </div>\n' +
        '        </div>\n  '
    var myModal = new bootstrap.Modal(document.getElementById('myModalHandaleUpload'), {
        keyboard: false
    });

    myModal.toggle();
        document.getElementById(btnSubmit).disabled = true;

        var files = document.getElementById(inputFile).files;
        console.log(files[0]);



    //checks if files are selected
    if (files.length != 0) {
        //Loops through all the selected files
        for (let i = 0; i < files.length; i++) {
            //create a storage reference
            var storage = firebase.storage().ref(getPathToTpload(files[i],pathType,id) );
            //upload file
            var upload = storage.put(files[i]);

            //update progress bar
            upload.on(
                "state_changed",
                function progress(snapshot) {
                    var percentage =
                        (snapshot.bytesTransferred / snapshot.totalBytes) * 100;

                    //100 -> p_progress
                    //%
                    let progressMain =document.getElementById("progress")
                    let p_progress =document.getElementById("progress-parent")
                    let p_width=p_progress.offsetWidth
                    console.log(document.getElementById("progress-parent").offsetWidth)
                    progressMain.setAttribute('aria-valuenow',percentage)

                    console.log(p_width )
                    console.log((percentage)*(p_width)/100);
                    progressMain.style.backgroundColor="#7b61ff"
                    progressMain.style.width =(((percentage)*(p_width))/100) +  'px' //toString(parseInt(percentage)) + 'px'
                    document.getElementById("progress-value").textContent=parseInt(percentage)

                    //document.getElementById("progress").value = percentage;

                },

                function error() {
                    alert("error uploading file");
                },

                function complete() {
                    getFileUrl(getPathToTpload(files[i],pathType,id),btnSubmit,pathStorageId);
                    myModal.toggle();


                }
            );
        }
    } else {
        alert("File is not selected.");
    }

}

function getFileUrl(filename,btnSubmit,pathStorageFile) {
    //create a storage reference
    var storage = firebase.storage().ref(filename);

    //get file url
    storage
        .getDownloadURL()
        .then(function(url) {
           // document.getElementById("pathStorageFile").innerHTML += `${url}`;
            document.getElementById(pathStorageFile).setAttribute("value",url);

            document.getElementById(btnSubmit).disabled = false;;
            console.log(url);
        })
        .catch(function(error) {
            console.log("error encountered");
        });
}