let mymap = L.map('mapid');

let tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
{attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}, 
{foo: 'bar'});
tiles.addTo(mymap);

//gia tin forma eisagwgis
const insert_form = document.querySelector("#insert_form");
const zitisi = document.querySelector("#zitisi");
const parking_spots = document.querySelector("#parking_spots");

const fetch_button = document.querySelector("button[name=fetch_polygons]");


Polygons = []; //karataw ola ta polygons pou dimiourgountai
               // ton xreiazomai gia na ta xromatisw stin eksomoiwsi

fetch_button.addEventListener("click",function(e){
    e.preventDefault();
    

    fetch("fetch_polygons.php",{
        method: "POST"
    }).then(function(response){
        return response.json();
    }).then(function(data){
        console.log(data.length);
        let id = 1;
        for(let element in data){
            cords= JSON.parse(data[element]);
            console.log(cords);
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
             //console.log(coordinates);
             let polygon = L.polygon(coordinates,{color:"black", fillColor:"gray"}).addTo(mymap);
             Polygons.push(polygon);
             polygon.on("click",function(event){
                $("#exampleModal").modal("show");
                console.log(this);
                console.log(event.sourceTarget._latlngs[0]);
                console.log(event.sourceTarget._latlngs[0][0]);
                console.log(`lat:${event.sourceTarget._latlngs[0][0].lat} long:${event.sourceTarget._latlngs[0][0].lng}`)
                points = [];
                let k=0;
                for(let i=0;i<event.sourceTarget._latlngs[0].length;i++){
                    points[i] = new Array(event.sourceTarget._latlngs[0][i].lat,event.sourceTarget._latlngs[0][i].lng);
                }
    
            });
            }
        mymap.setView([40.625419, 22.955246], 8);
    }).then(function(){
        const time_form = document.querySelector("#time_form");
        const time_input = document.querySelector("#time_input");


        time_form.addEventListener("submit",function(e){
            e.preventDefault();

            console.log(time_input.value);
            const formData = new FormData();

            formData.append("time",time_input.value);

            fetch("simulation.php",{
                method: "POST",
                body: formData
            }).then(function(response){
                return response.json();
                //console.log(Polygons);

            }).then(function(data){
                console.log(data[0]);
                //console.log(Polygons[0]);
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

    }).catch(console.error);
});



insert_form.addEventListener("submit",function(e){
    e.preventDefault();

    const formData = new FormData();

    formData.append("parking_spots",parking_spots.value);
    formData.append("zitisi",zitisi.value);
    formData.append("points",points);

    fetch("insert_data.php",{
        method: "POST",
        body: formData
    }).then(function(response){
        return response.text();
    }).then(function(text){
        const insert_resp = document.querySelector("div[id=insert_response]")
        if(text=="Οι θέσεις στάθμευσης του πολυγώνου ενημερώθηκαν επιτυχώς!"){
            const mark = `<div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>'Ολα πήγαν καλά! </strong> ${text}
          </div>`
          insert_resp.innerHTML = mark;
        }else{
            const mark = `<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Σφάλμα! </strong> Οι θέσεις στάθμευσης του πολυγώνου δεν ενημερώθηκαν!
          </div>`
          insert_resp.innerHTML = mark;
        }
    }).catch(console.error);
});




/*
    fetch("fetch_polygons.php",{
        method:"POST"
    }).then(function(response){
        return response.json();
    }).then(function(data){
       // data.forEach(function(item){
         //   console.log(item));
        //})
        console.log(data);
        
        let cords = [];
        let j=0;
        for(let i=0;i<data.length;i+=2){
            cords[j] = new Array(data[i+1], data[i]);
            j++;
        }
        console.log(cords);
        
        let polygon = L.polygon(cords,{color:"gray", fillColor:"gray"}).addTo(mymap);
        let center = polygon.getBounds().getCenter();
        mymap.setView(center, 16);

    }).catch(console.error);*/
