
/*mymap.on("click",function(e){
        $("#exampleModal").modal("show");
        console.log(`${e.latlng.lat}  ${e.latlng.lng}`);
        let center_cords = this.getBounds().getCenter();
        console.log(this);
        //console.log(e.latlng.toString());
    });


const insert_form = document.querySelector("#insert_form");
const zitisi = document.querySelector("#zitisi");
const parking_spots = document.querySelector("#parking_spots");


insert_form.addEventListener("submit",function(e){
    e.preventDefault();

    const formData = new FormData();

    formData.append("parking_spots",parking_spots.value);
    formData.append("zitisi",zitisi.value);
    formData.append("center_cords",center_cords);

    fetch("insert_data.php",{
        method: "POST",
        body: formData
    }).then(function(response){
        console.log(response);
    }).catch(console.error);
});*/