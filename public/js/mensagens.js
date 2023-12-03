function eliminar(url){

    Swal.fire({
        title: 'Têm a Certeza que deseja eliminar ?',
        text: "Atenção! Se elimina, não será possível reverter.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = url

        }
    })
}

function eliminar2(url, id){

    Swal.fire({
        title: 'Are you sure you want to delete?',
        text: "Heads up! If deleted, it will not be possible to revert.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = url+id

        }
    })
}

function cancelar(url){

    Swal.fire({
        title: 'Têm a Certeza que deseja Cancelar ?',
        text: "Atenção! A Reserva será cancelada.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = url

        }
    })
}

function check_in(url){

    Swal.fire({
        title: 'Têm a Certeza que deseja Registar a Entrada ?',
        text: "Atenção! O Status da Reserva será alterado para Check-IN.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Check-IN!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = url

        }
    })
}

function check_out(url){

    Swal.fire({
        title: 'Têm a Certeza que deseja Registar a Saída ?',
        text: "Atenção! O Status da Reserva Será alterado para Check-Out.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Check-Out!'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = url

        }
    })
}

function show_msg(mensagem, tipo) {

    if (tipo === 1)
        Swal.fire('Sucesso!', mensagem, 'success')

    else if (tipo === 0)
        Swal.fire('Erro!', mensagem, 'error')

    else
        Swal.fire('Alerta!', mensagem, 'warning')
}

function show_msg2(titulo, mensagem, tipo) {

    if (tipo === 1)
        Swal.fire(titulo, mensagem, 'success')

    else if (tipo === 0)
        Swal.fire(titulo, mensagem, 'error')

    else
        Swal.fire(titulo, mensagem, 'warning')

}


function show_msg_som(){
    var soundfile = "sounds/RedAlert.mp3";
    Swal.fire({
        title: 'Your Title!',
        html: 'Text or Content',
        confirmButtonClass: 'btn btn-primary',
        confirmButtonText: 'Your Text',
        buttonsStyling: false,
        onOpen: function () {
            var audplay = new Audio(soundfile)
            audplay.play();
        }
    })
}
