let mymap = L.map('mapid');

let tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
{attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}, 
{foo: 'bar'});
tiles.addTo(mymap);

//mymap.setView([40.625419, 22.955246], 10);
Polygons = [];
const time_form = document.querySelector("#time_form");
const time_input = document.querySelector("#time_input");

fetch("admin/fetch_polygons.php",{
    method:"POST"
}).then(function(response){
    return response.json();
}).then(function(data){
    for(let element in data){
        cords = JSON.parse(data[element]);
        for(let i=0;i<cords.length;i+=2){
            let tmp = cords[i];  //antistrefw gia na einai stin morfi lat lng
            cords[i] = cords[i+1];
            cords[i+1] = tmp;  
         }
         //console.log(cords);
         let j=0;
         let coordinates = [];
         for(let i=0;i<cords.length;i+=2){
             coordinates[j] = new Array(cords[i],cords[i+1]);
             j++;
         }
            let polygon = L.polygon(coordinates).addTo(mymap);
            Polygons.push(polygon);
            polygon.on("click",function(event){
                $("#exampleModal").modal("show");
                console.log(JSON.stringify(event.latlng));//auto to event krataei tis sintetagmenes tou click
                //point = JSON.stringify(event.latlng);
                point = event.latlng;//simeio epilogis tou xristi
            });
         
    }
    const formData = new FormData();
    formData.append("time",time_input.value);

    fetch("admin/simulation.php",{
        method:"POST",
        body:formData
    }).then(function(response){
        return response.json();
    }).then(function(data){
        oikodomika_tetragwna = data;
        let i = 0;
            Polygons.forEach(function(element){
                if(data[i].pososto<=59){
                    element.setStyle({color:"green", fillColor:"green"});
                }else if(data[i].pososto>=60 && data[i].pososto<=84){
                    element.setStyle({color:"yellow", fillColor:"yellow"});
                }else{
                    element.setStyle({color:"red", fillColor:"red"});
                }
                i++;
            });
            mymap.setView([40.625419, 22.955246], 10);
    }).catch(console.error);

}).catch(console.error);


time_form.addEventListener("submit",function(e){
    e.preventDefault();

    const formData = new FormData();
    formData.append("time",time_input.value);

    fetch("admin/simulation.php",{
        method:"POST",
        body:formData
    }).then(response=>response.json()
    ).then(function(data){
        let i = 0;//counter
                Polygons.forEach(function(element){
                    if(data[i].pososto<=59){
                        element.setStyle({color:"green", fillColor:"green"});
                    }else if(data[i].pososto>=60 && data[i].pososto<=84){
                        element.setStyle({color:"yellow", fillColor:"yellow"});
                    }else{
                        element.setStyle({color:"red", fillColor:"red"});
                    }
                    i++;
                    
                });
    }).catch(console.error);
});


markers = [];//gia na diagrafw tous markers apo proigoumenes anazitiseis parking
const user_time = document.querySelector("#user_time");
const aktina = document.querySelector("#aktina");

const user_form = document.querySelector("#user_form");
user_form.addEventListener("submit",function(e){
    e.preventDefault();
    let ids_in_range = [];//krataei ta id twn poligwnwn mesa stin aktina anazitisis tou xristi

    const formData = new FormData();

    formData.append("user_time",user_time.value);
    formData.append("aktina",aktina.value);
    //gia tin apostasi se eutheia grammi apo to centroid tou cluster
    formData.append("point",JSON.stringify(point));
    //console.log(JSON.parse(oikodomika_tetragwna[0].centroid));
    //vriskw ta oikodomika tetragwna me id entos tis aktinas anazitisis tou xristi
    for(let element in oikodomika_tetragwna){
        tmp_latlng = new L.LatLng(JSON.parse(oikodomika_tetragwna[element].centroid)[1],JSON.parse(oikodomika_tetragwna[element].centroid)[0]);
        if(tmp_latlng.distanceTo(point)<=aktina.value){
            ids_in_range.push({"id":oikodomika_tetragwna[element].id,"centroid":oikodomika_tetragwna[element].centroid}); 
        }
    }
    formData.append("ids_in_range",JSON.stringify(ids_in_range));
    console.log(ids_in_range);
    //let latlng_a = new L.LatLng(JSON.parse(oikodomika_tetragwna[0].centroid)[1],JSON.parse(oikodomika_tetragwna[0].centroid)[0]);
    //console.log(latlng_a.distanceTo(point));

    fetch("user_search.php",{
        method:"POST",
        body:formData
    }).then((response)=>
        response.json()
    ).then(function(data){
        //diagrafw tous markers apo proigoumenes anazitiseis parking
        markers.forEach(function(elem){
            if(elem){
                mymap.removeLayer(elem);
             }else{
                 console.log("den bika");
             }
        });
        console.log(data);
        let response = document.querySelector("div[id=response]");
        if(data.length>1){
            markup = ``;
            for(let element in data){
                let marker = L.marker(data[element].point).addTo(mymap);
                marker.bindPopup("<b>Κατευθυνθείται εδώ!</b>").openPopup();
                marker.dragging.disable();
                markers.push(marker);
                let tmp_markup = `<div class="alert alert-success">
                Η απόσταση μέχρι το ${parseInt(element)+1}ο προτεινόμενο σημείο στάθμευσης είναι 
                <strong>${data[element].distance} μέτρα</strong>.
             </div>`
             markup += tmp_markup; 
            }
        }else{
            for(let element in data){
                console.log(data[element]);
                let marker = L.marker(data[element].point).addTo(mymap);
                marker.bindPopup("<b>Κατευθυνθείται εδώ!</b>").openPopup();
                marker.dragging.disable();
                markers.push(marker);
                 markup = `<div class="alert alert-success">
                 Η απόσταση μέχρι το προτεινόμενο σημείο στάθμευσης είναι 
                 <strong>${data[element].distance} μέτρα</strong>.
              </div>`;
            }
        }
        
        response.innerHTML = markup;
        $('#exampleModal').modal('hide');//kleinw to modal
    }).catch(console.error);
});