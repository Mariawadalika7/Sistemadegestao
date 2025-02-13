<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Cliente::count(); // Conta os clientes

        return view('dashboard', compact('totalClientes')); // Passa a variável para a view
    }
}
