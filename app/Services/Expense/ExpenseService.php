<?php

namespace App\Services\Expense;

use App\Repositories\Expense\ExpenseRepository;

class ExpenseService
{
    public $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function store($data)
    {
        return $this->expenseRepository->create($data);
    }

    public function show($data)
    {
        return $this->expenseRepository->show($data);
    }

    public function update($data)
    {
        return $this->expenseRepository->update($data);
    }

    public function destroy($data)
    {
        return;
    }
}