<?php
// app/Models/Cliente.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'cpf_cnpj',
        'email',
        'telefone',
        'endereco',
        'tipo', // residencial, comercial, industrial
        'status'
    ];

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }

    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }
}

// app/Models/Fatura.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $fillable = [
        'cliente_id',
        'numero',
        'valor',
        'data_emissao',
        'data_vencimento',
        'status',
        'consumo_kwh',
        'valor_kwh',
        'impostos',
        'desconto'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}

// app/Models/Consumo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    protected $fillable = [
        'cliente_id',
        'data_leitura',
        'leitura_anterior',
        'leitura_atual',
        'consumo_kwh',
        'observacoes'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
