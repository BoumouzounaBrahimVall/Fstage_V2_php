let selectedFile;
console.log(window.XLSX);
document.getElementById('inputextract').addEventListener("change", (event) => {
    selectedFile = event.target.files[0];
    console.log(selectedFile);
})

let data=[{
    "name":"jayanth",
    "data":"scd",
    "abc":"sdef"
}]


document.getElementById('buttonextra').addEventListener("click", () => {
    XLSX.utils.json_to_sheet(data, 'out.xlsx');
    if(selectedFile){
        let fileReader = new FileReader();
        fileReader.readAsBinaryString(selectedFile);
        fileReader.onload = (event)=>{
            let data = event.target.result;
            let workbook = XLSX.read(data,{type:"binary"});
            console.log(workbook);

            workbook.SheetNames.forEach(sheet => {
                let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                let tmp;
                var table = document.getElementById('myTable');
                for(let k=0;k<rowObject.length;k++){
                    tmp= JSON.stringify(rowObject[k],undefined,4);
                    howe =JSON.parse(tmp);

                    console.log(howe);
                    var etu =`<div class="row overflow-auto p-2 border rounded-3">
                                <div class=" col-lg-3 col-sm-6">
                                    <label for="inputCNE"  class="col-form-label">CNE</label>

                                    <input class="form-control" value='${howe.CNE}' name="cne[]"  type="text" id="inputCNE">
                                </div>
                                <div class=" col-lg-3 col-sm-6">
                                    <label for="inputnom" class="col-form-label">Nom</label>
                                    <input class="form-control" value='${howe.NOM}' type="text" id="inputnom" name="nom[]">
                                </div>
                                <div class=" col-lg-3 col-sm-6">
                                    <label for="prenom" class="col-form-label">Prenom</label>

                                    <input class="form-control" type="text" value='${howe.PRENOM}' id="prenom" name="prenom[]">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="email" class="col-form-label">Email</label>

                                    <input class="form-control" type="email" value='${howe.Email}' id="email" name="email[]">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="datenais" class="col-form-label">Date de naissence</label>

                                    <input class="form-control" value='${excelDateToJSDate(howe['Date naissance'])}' type="date" id="datenais" name="datenais[]">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="inputtel" class="col-form-label">Telephone</label>

                                    <input class="form-control" type="text" value='${howe.Tel}' id="inputtel" name="tel[]">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="ville" class="col-form-label">Ville</label>

                                    <input class="form-control" value='${howe.Ville}' type="text" id="ville" name="ville[]">
                                </div>
                                <div class=" col-lg-3 col-sm-6">
                                    <label for="pays" class="col-form-label">Pays</label>

                                    <input class="form-control" value='${howe.pays}' type="tel" id="pays" name="pays[]">
                                </div>
                                <div class=" col-lg-3 col-sm-6">
                                    <label for="niv" class="col-form-label">Niveau</label>

                                    <input class="form-control" value='${howe.NIVEAU}' type="text" id="niv" name="niv[]">
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <label for="pass" class="col-form-label">Mot de passe</label>

                                    <input class="form-control" value='${howe["Mot De passe"]}' type="text" id="pass" name="pass[]">
                                </div>
                            </div>`;
                    table.innerHTML += etu;
                }

            });


        }

    }
});


function excelDateToJSDate(excelDate) {
    var date = new Date(Math.round((excelDate - (25567 + 1)) * 86400 * 1000));
    return date.toISOString().split('T')[0];;
}