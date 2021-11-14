'use strict'

// Get a list of vehicles in inventory based on the classificationId 
let classificationList = document.querySelector("#classificationList");

classificationList.addEventListener("change", function () {
    let classificationId = classificationList.value;
    console.log(`classificationId is: ${classificationId}`);
    let classIdURL = "/phpmotors/vehicles/index.php?action=getInventoryItems&classificationId=" + classificationId;
    fetch(classIdURL)
        .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            throw Error("Network response was not OK");
        })
        .then(function (data) {
            console.log(data);
            buildInventoryList(data);
        })
        .catch(function (error) {
            console.log('There was a problem: ', error.message)
        })
})

// Build inventory items into HTML table components and inject into DOM 

function buildInventoryList(data) { 

    let inventoryRecords = document.getElementById("inventoryRecords"); 

    let dataTable = '<thead>'; 
    dataTable += '<tr><th>Vehicle Name</th><th>&nbsp;</th><th>&nbsp;</th></tr>'; 
    dataTable += '</thead>'; 

    dataTable += '<tbody>'; 

    data.forEach(function (element) { 
     console.log(element.invId + ", " + element.invModel); 
     dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`; 
     dataTable += `<td><a href='/phpmotors/vehicles?action=mod&invId=${element.invId}' class='edit-inventory' title='Click to modify'>Modify</a></td>`; 
     dataTable += `<td><a href='/phpmotors/vehicles?action=del&invId=${element.invId}' class='delete-inventory' title='Click to delete'>Delete</a></td></tr>`; 
    }) 
    dataTable += '</tbody>'; 

    inventoryRecords.innerHTML = dataTable; 
}