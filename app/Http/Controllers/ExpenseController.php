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
     *  realiza uma junção com as tabelas "users", "company" e "usuarios" (duas vezes) para obter as informações adicionais necessárias
     */
    public function listarDespesasComInfoAdicional()
    {
        $expenses = Expense::join('users', 'expense.user_id', '=', 'users.id')
                            ->join('company', 'expense.company_id', '=', 'company.id')
                            ->leftJoin('users as approved', 'expense.approved_id', '=', 'approved.id')
                            ->select('expense.*', 'users.name as name_user', 'company.name_fantasia', 
                                    'company.razao_social', 'approved.name as name_approved')
                            ->get();

        $expensesComInfoAdicional = $expenses->map(function($expense) {
            $situacao = $expense->situacao == 'A' ? 'Aprovado' : 'Rejeitado';
            $justification = $expense->situacao == 'R' ? $expense->justification : null;

            return [
                'id' => $expense->id,
                'value' => $expense->valor,
                'usuario' => $expense->name_user,
                'company' => $expense->name_fantasia . ' - ' . $expense->razao_social,
                'situacao' => $situacao,
                'approved' => $expense->name_approved,
                'date_approved_refused' => $expense->date_approved_refused,
                'justification_refused' => $justification
            ];
        });

        return response()->json([
            'message' => 'expense com informações adicionais',
            'expense' => $expensesComInfoAdicional
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
