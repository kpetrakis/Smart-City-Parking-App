const delete_button = document.querySelector("button[name=delete]");

delete_button.addEventListener("click",function(e){
    e.preventDefault();

    
    fetch("file_delete.php",{
        method: 'POST',
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text=='ok'){
            let delete_response = document.querySelector("#delete_response");
            //delete_response.className = 'alert alert-dismissible alert-success'
            //delete_response.innerHTML = "Το αρχείο διαγράφτηκε επιτυχώς";
            const markup = `<div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong></strong> Όλα τα δεδομένα διαγράφτηκαν επιτυχώς απο την βάση!
          </div>`;
          delete_response.innerHTML = markup;

        }else{
            let delete_response = document.querySelector("div[id=delete_response]");
            /*delete_response.className = 'alert alert-dismissible alert-danger';
            let dismiss_btn = document.createElement("button");
            let textnode = document.createTextNode("&times;");
            dismiss_btn.setAttribute("type","button");
            dismiss_btn.setAttribute("class","close");
            dismiss_btn.setAttribute("data-dismiss","alert");
            dismiss_btn.appendChild(textnode);
            delete_response.appendChild(dismiss_btn);
            delete_response.innerHTML = "Κάτι πήγε στραβά και η διαγραφή δεν έγινε";*/
            const markup = `<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Σφάλμα! </strong> Κάτι πήγε στραβά και η διαγραφή δεν έγινε.
          </div>`;
          delete_response.innerHTML = markup;
        

        }
    }).catch(console.error);
});