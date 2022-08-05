

const time_form = document.querySelector("#time_form");
const time_input = document.querySelector("#time_input");


time_form.addEventListener("submit",function(e){
    e.preventDefault();

    console.log(time_input.value);
    const formData = new FormData();

    formData.append("time",time_input.value);

    fetch("insert_time.php",{
        method: "POST",
        body: formData
    }).then(function(response){
        return response.json();
    }).then(function(data){
        console.log(data);
        console.log(JSON.parse(data[0].coordinates));
        for(let element in data){
           let centroid = JSON.parse(data[element].centroid);
           let tmp = centroid[0];
           centroid[0] = centroid[1];
           centroid[1] = tmp;
           let cords= JSON.parse(data[element].coordinates);
            for(let i=0;i<cords.length;i+=2){
                let tmp = cords[i];  //antistrefw gia na einai stin morfi lat lng
                cords[i] = cords[i+1];
                cords[i+1] = tmp;  
             }
             //console.log(cords);
           //console.log(centroid);
           let j=0;
             let coordinates = [];
             for(let i=0;i<cords.length;i+=2){
                 coordinates[j] = new Array(cords[i],cords[i+1]);
                 j++;
             }
             if(JSON.parse(data[element].pososto)<=59){
                 color = "green";
             }else if(JSON.parse(data[element].pososto)>=60 && JSON.parse(data[element].pososto)<=84){
                 color = "yellow";
             }else{
                 color = "red";
             }
             console.log(color);
             let polygon = L.polygon(coordinates,{color:color, fillColor:color}).addTo(mymap);
          
        
        }
        mymap.setView([40.625419, 22.955246], 8);
            
    }).catch(console.error);
});