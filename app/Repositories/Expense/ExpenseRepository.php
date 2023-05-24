<?php

namespace App\Repositories\Expense;

use App\Models\Expense;

class ExpenseRepository
{
        protected $model;
        
        public function __construct(Expense $model)
        {
                $this->model = $model;
        }
        
        public function find($id)
        {
                return $this->model->find($id);
        }

        public function create($data)
        {
                return $this->model->create([
                        'user_id' => $data['user_id'],
                        'company_id' => $data['company_id'],
                        'value' => $data['value'],
                        'status' => $data['status'],
                        'approved' => $data['approved_refused'],
                        'date_approved' => $data['date_approved_refused'],
                        'justification_refused' => $data['justification_refused'],
                ]);
        }

        public function show($data)
        {
                return $this->model->show($data);
        }

        public function update($data)
        {
                return;
        }

        public function destroy($data)
        {
                return;
        }
}