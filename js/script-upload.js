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
            fileDestination=img_upload_path + "EtudiantPhoto/"+id;
            break;
        case 2://cv etudiant
            fileDestination= doc_upload_path+ "EtudiantCv/"+id;
            break;
        case 3:///logo ent
            fileDestination=img_upload_path+ "CompanyPhoto/"+id;
            break;
        case 4:/// photo responsable
            fileDestination=img_upload_path+ "ResposablesPhoto/"+id;
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
                    //document.getElementById("progress").value = percentage;
                },

                function error() {
                    alert("error uploading file");
                },

                function complete() {
                    getFileUrl(getPathToTpload(files[i],pathType,id),btnSubmit,pathStorageId);
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