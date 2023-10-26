<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InventoriesExport implements FromView
{

    private $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function view(): View
    {
        $this->dados['img'] = false;
        return view('report.stocks', $this->dados);
    }
}
