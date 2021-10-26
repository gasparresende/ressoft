function delete_item(ident) {

    $(ident).submit(function (e) {
        e.preventDefault()
        Swal.fire({
            title: 'Tens a certeza que deseja eliminar?',
            text: "Você não será capaz de reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit()

            }
        })
    })

}

$(function () {
    delete_item('.delete_item')
})
