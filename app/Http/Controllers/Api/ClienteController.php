<?php
namespace App\Http\Controllers\Api

public function getTotalClientes()
{
    return response()->json([
        'totalClientes' => Cliente::count()
    ]);
}
