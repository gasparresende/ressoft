var xhttp = new XMLHttpRequest()


function getReq(url, callback, parametros = "") {
    xhttp.onreadystatechange = callback

    xhttp.open('GET', url + parametros, true)
    xhttp.send()
}

function postReq(url, callback, parametros = "") {
    xhttp.onreadystatechange = callback

    xhttp.open('POST', url, true)

    if (typeof (parametros) != 'object') {
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    }

    xhttp.send(parametros)
}

function antesEnviar(callback) {
    if (xhttp.readyState < 4) {
        callback()
    }
}

function sucesso(callback) {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        callback()
    }
}

function erros(callback) {
    xhttp.onerror = callback
}

