<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Interfaces\Answer\AnswerRepositoryInterface;

class IndexController extends Controller
{
    public function __construct(private AnswerRepositoryInterface $answerRepository)
    {
    }

    public function index(): InertiaResponse
    {
        return Inertia::render('Admin/Dashboard', [
            'top10_users' => $this->answerRepository->getAnswers([
                'select' => [
                    'answers.id',
                    'users.name',
                    'answers.result',
                    'answers.created_at'
                ],
                'limit' => 10,
                'order_by' => 'result',
                'order' => 'desc',
            ]),
        ]);
    }
}
