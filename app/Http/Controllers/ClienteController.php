<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Clientes::all();
    }

    public function clienteCadastro(Request $request)
    {
        try {

            $cliente = new Clientes;

            if(!empty($request->nome) && isset($request->nome)){

                $cliente->nome = $request->nome;

            }else{

                return response()->json([
                    "message" => "Nome do cliente é obrigatório"
                ], 400);

            }

            if(!empty($request->telefone) && isset($request->telefone)){
                if (strlen($request->telefone) == 11) {

                $cliente->telefone = $request->telefone;

                }else{

                    return response()->json([
                        "message" => "Número de telefone inválido, não esqueça de usar o DDD"
                    ], 400);

                }
            }else{

                return response()->json([
                    "message" => "Telefone do cliente é obrigatório"
                ], 400);

            }

            if(!empty($request->cpf) && isset($request->cpf)){

                if($this->validaCPF($request->cpf) == true){

                    $cliente->cpf = $request->cpf;

                }else{

                    return response()->json([
                        "message" => "CPF com números inválidos"
                    ], 400);

                }

            }else{

                return response()->json([
                    "message" => "CPF do cliente é obrigatório"
                ], 400);

            }

            if(!empty($request->placa_carro) && isset($request->placa_carro)){
                if (strlen($request->placa_carro) == 7) {

                $cliente->placa_carro = $request->placa_carro;

                }else{

                    return response()->json([
                        "message" => "Placa do carro está incorreta!"
                    ], 400);

                }

            }else{

                return response()->json([
                    "message" => "Placa do carro do cliente é obrigatório"
                ], 400);

            }

            $cliente->telefone = $this->mask($cliente->telefone,'(##)#####-####');
            $cliente->placa_carro = $this->formataPlacadeCarro($cliente->placa_carro);

            $cliente->save();

            return response()->json([
                "message" => "Cliente Cadastrado com Sucesso!"
            ], 201);

        }catch (Exception $e) {

            echo 'Exceção capturada: ',  $e->getMessage(), "\n";

        }
    }

      public function buscarClientes()
      {
        try{

            $cliente = Clientes::get()->toJson(JSON_PRETTY_PRINT);
            return response($cliente, 200);

        }catch (Exception $e) {

            echo 'Exceção capturada: ',  $e->getMessage(), "\n";

        }

      }


      public function buscarClientesById($id)
     {
        try{

            if (Clientes::where('id', $id)->exists()) {
                $student = Clientes::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($student, 200);
            } else {
                return response()->json([
                "message" => "Cliente não encontrado!"
                ], 404);
            }

        }catch (Exception $e) {

            echo 'Exceção capturada: ',  $e->getMessage(), "\n";

        }
     }

      public function atualizarCliente(Request $request, $id)
    {
        try{

            if (Clientes::where('id', $id)->exists()) {
                $cliente = Clientes::find($id);

                $cliente->nome = is_null($request->nome) ? $cliente->nome : $request->nome;
                $cliente->telefone = is_null($request->telefone) ? $cliente->telefone : $this->mask($request->telefone,'(##)#####-####');
                $cliente->cpf = is_null($request->cpf) ? $cliente->cpf : $request->cpf;
                $cliente->placa_carro = is_null($request->placa_carro) ? $cliente->placa_carro : $this->formataPlacadeCarro($cliente->placa_carro);

                $cliente->save();

                return response()->json([
                    "message" => "As atualizações foram salvas!"
                ], 200);
                } else {
                return response()->json([
                    "message" => "Cliente não encontrado"
                ], 404);

            }

        }catch (Exception $e) {

            echo 'Exceção capturada: ',  $e->getMessage(), "\n";

        }
    }

    public function excluirCliente ($id)
    {
        try{

            if(Clientes::where('id', $id)->exists()) {
              $cliente = Clientes::find($id);
              $cliente->delete();

              return response()->json([
                "message" => "Cliente deletado!"
              ], 202);
            } else {
              return response()->json([
                "message" => "Cliente não encontrado!"
              ], 404);
            }

        }catch (Exception $e) {

             echo 'Exceção capturada: ',  $e->getMessage(), "\n";

        }

    }

      public function buscarFinalPlacaCliente ($final_placa)
      {
        try{

            if(Clientes::whereRaw(('SUBSTRING(placa_carro, -1) = '."'$final_placa'"))->exists() && is_numeric($final_placa)) {
              $cliente = Clientes::whereRaw('SUBSTRING(placa_carro, -1) = '."'$final_placa'")->get();
              $cliente->toJson(JSON_PRETTY_PRINT);

              return response($cliente, 200);

            } else {
              return response()->json([
                "message" => "Cliente não encontrado!"
              ], 404);
            }

        }catch (Exception $e) {

            echo 'Exceção capturada: ',  $e->getMessage(), "\n";

        }

      }




      function validaCPF($cpf)
      {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;

    }

    function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }

        return $maskared;
    }


    function formataPlacadeCarro($placa)
    {
        $tam	= strlen($placa);
        $primeiraParte = substr($placa,0,3);
        $segundaParte = substr($placa,3);

        $PLACA = $primeiraParte ."-". $segundaParte;
        return strtoupper($PLACA);
    }
}
