<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use \Illuminate\Http\Response;
use App\Services\Expense\ExpenseService;
use App\Http\Request\ExpenseRequest\ExpenseStoreRequest;
use App\Http\Request\ExpenseRequest\ExpenseUpdateRequest;

/**
 *  permitindo vincular o usuário solicitante
 */

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function store(ExpenseStoreRequest $request)
    {
        $validatedData = $request->validated();

        dd($validatedData);

        $expense = $this->expenseService->store($validatedData);
    
        return response()->json($expense, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $login
     * @return \Illuminate\Http\Response
     */
    public function show($login)
    {
        Expense::find($login);
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request)
    {
        $validatedData = $request->validated();

        $userId = Expense::find();

        $userId->fill($validatedData);
        $userId->save();

        return response()->json("Atualizado com sucesso!", Response::HTTP_OK);
    }

/**
 * atualiza o status com o valor fornecido na requisição e salva as mudanças
 */

    public function updateStatus($id, Request $request)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = $request->input('status');
        $expense->save();

        return response()->json([
            'message' => 'Status da despesa atualizado com sucesso',
            'despesa' => $expense
        ]);
    }

/**
 * consulta todas as despesas do usuário fornecido, soma o valor de todas elas e retorna o valor total em uma resposta JSON
 */
    public function totalDespesasPorUsuario($id)
    {
        $total = Expense::where('user_id', $id)
                        ->sum('value');

        return response()->json([
            'message' => 'Value total de despesas solicitadas pelo usuário',
            'total' => $total
        ]);
    }

    /**
     *  realiza uma junção com as tabelas "usuarios", "empresas" e "usuarios" (duas vezes) para obter as informações adicionais necessárias
     */
    public function listarDespesasComInfoAdicional()
    {
        $expenses = Expense::join('usuarios', 'despesas.user_id', '=', 'usuarios.id')
                            ->join('empresas', 'despesas.company_id', '=', 'empresas.id')
                            ->leftJoin('usuarios as aprovador', 'despesas.aprovador_id', '=', 'aprovador.id')
                            ->select('despesas.*', 'usuarios.nome as nome_usuario', 'empresas.nome_fantasia', 
                                    'empresas.razao_social', 'aprovador.nome as nome_aprovador')
                            ->get();

        $expensesComInfoAdicional = $expenses->map(function($expense) {
            $situacao = $expense->situacao == 'A' ? 'Aprovado' : 'Rejeitado';
            $justificativa = $expense->situacao == 'R' ? $expense->justificativa : null;

            return [
                'id' => $expense->id,
                'value' => $expense->valor,
                'usuario' => $expense->nome_usuario,
                'empresa' => $expense->nome_fantasia . ' - ' . $expense->razao_social,
                'situacao' => $situacao,
                'aprovador' => $expense->nome_aprovador,
                'date_approved_refused' => $expense->date_approved_refused,
                'justification_refused' => $justificativa
            ];
        });

        return response()->json([
            'message' => 'Despesas com informações adicionais',
            'despesas' => $expensesComInfoAdicional
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        return response()->json(null, 204);
    }
}
