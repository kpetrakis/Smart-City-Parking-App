const fileForm = document.getElementById("fileForm");
const fileToUpload = document.querySelector("#fileToUpload");

fileForm.addEventListener("submit",function(e){
    e.preventDefault();

    const formData = new FormData();

    //console.log(fileToUpload.files);

    formData.append("fileToUpload",fileToUpload.files[0]);

    fetch("file_upload.php",{
        method: "POST",
        body: formData
    }).then(response => response.text())
    .then(text => {
        //document.querySelector('#response').className = obj.msgClass;
        //document.querySelector('#response').innerHTML= obj.msg;
        const resp = document.querySelector("div[id=response]");
        if(text=='Επιλέξτε ένα .kml αρχείο.'){
            //resp.className = 'alert alert-dismissible alert-danger';
            //resp.innerHTML = text;

            const markup = `<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Σφάλμα! </strong> ${text}
          </div>`;
          resp.innerHTML = markup;
        }else if(text=='Το αρχείο είναι πολύ μεγάλο.'){
            //resp.className = 'alert alert-dismissible alert-danger';
            //resp.innerHTML = text;
            const markup = `<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Σφάλμα! </strong> ${text}
          </div>`;
          resp.innerHTML = markup;

        }else if(text=='Το αρχείο υπάρχει ήδη.'){
            //resp.className = 'alert alert-dismissible alert-warning';
            //resp.innerHTML = text;
            const markup = `<div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Σφάλμα! </strong> ${text}
          </div>`;
          resp.innerHTML = markup;
        }else if(text=='1'){
            //resp.className = 'alert alert-dismissible alert-success';
            //resp.innerHTML = 'To αρχείο φορτώθηκε επιτυχώς!';
            const markup = `<div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>'Ολα πήγαν καλά! </strong> Το αρχείο φορτώθηκε επιτυχώς!.
          </div>`;
          resp.innerHTML = markup;
        }
    }).catch(console.error);
});