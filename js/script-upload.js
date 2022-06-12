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

const getPathToTpload = (file) => {
    const img_upload_path = "images/";
    const doc_upload_path = "document/";
    if (fileIsAnImage(file)) return img_upload_path;
    if (fileIsADocument(file)) return doc_upload_path;
};


const uploadFileToFirebase=(inputFile,btnSubmit,pathStorageId)=>
{
        document.getElementById(btnSubmit).disabled = true;

        var files = document.getElementById(inputFile).files;
        console.log(files[0]);



    //checks if files are selected
    if (files.length != 0) {
        //Loops through all the selected files
        for (let i = 0; i < files.length; i++) {
            //create a storage reference
            var storage = firebase.storage().ref(getPathToTpload(files[i]) + files[i].name);
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
                    getFileUrl(getPathToTpload(files[i]) + files[i].name,btnSubmit,pathStorageId);
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