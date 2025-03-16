let selectClinic = document.getElementById("exampleSelectGender");
let divData = document.getElementById("div-data");
let inputSearch = document.getElementById("inputSearch");
let inputValue = document.getElementById("inputValue");


let data = [];
let dataAfterFalter = [];


// Send data to my Array
for (let index = 0; index < selectClinic.options.length; index++) {
    data.push({
        id: selectClinic.options[index].value,
        name: selectClinic.options[index].text
    });

}

// dataAfterFalter = data;

function SendAllDataFormDiv(data) {
    divData.innerHTML = "";
    data.forEach(item => {
        const h5 = document.createElement("h5");
        h5.className = "content-data";
        h5.textContent = item.name;
        h5.onclick = () => {
            OnClickH4(item.id, item.name)
        };
        divData.appendChild(h5);
    });
}


SendAllDataFormDiv(data)

function OnChangeInput(txt) {
    dataAfterFalter = data.filter((i) => {
        return i.name.toLowerCase().includes(txt.toLowerCase());
    });
    SendAllDataFormDiv(dataAfterFalter);
}

function OnClickH4(id, name) {
    console.log('name :>> ', name);
    inputSearch.value = name;
    inputValue.value = id;
}

function OpendivData(isOpen) {
    setTimeout(() => {
        if (isOpen) {
            divData.style.maxHeight = "50vh";
        } else {
            divData.style.maxHeight = "00vh";
        }

    }, [100]);
}