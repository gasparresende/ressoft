<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10" type="text/javascript"></script>

<!-- Erro de validação -->

<!--
@if($errors->any)
    @foreach($errors->all() as $key => $erro)
        <script>
            Swal.fire('Alerta!', '{{$erro}}', 'warning')
        </script>
    @endforeach
@endif
-->
<!-- ERRO DE OPERAÇÃO -->

@if (\Session::has('sucesso'))
    <script>
        Swal.fire('Sucesso!', '{{\Session::get('sucesso')}}', 'success')
    </script>
@elseif(\Session::has('erro'))
    <script>
        Swal.fire('Erro!', '{{\Session::get('erro')}}', 'error')
    </script>

@elseif(\Session::has('alerta'))
    <script>
        Swal.fire('Alerta!', '{{\Session::get('alerta')}}', 'warning')
    </script>

@elseif(\Session::has('questao'))
    <script>
        Swal.fire({
            title: '{{\Session::get('questao')}}',
            showDenyButton: true,
            //showCancelButton: true,
            confirmButtonText: `Sim`,
            denyButtonText: `Não`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                //Swal.fire('Confirmado!', '', 'success')
                //Abrir Caixa
                location.href = '/caixas/create'
            } else if (result.isDenied) {
                //Swal.fire('Changes are not saved', '', 'info')
            }
        })
    </script>

@endif



