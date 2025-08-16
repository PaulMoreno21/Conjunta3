function cargarPaginas(nombre_de_pagina){
    fetch(nombre_de_pagina)
    .then(res =>res.text())
    .then(
        data=> document.getElementById("tablas").innerHTML =data
    )
}