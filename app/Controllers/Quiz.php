<?php

namespace App\Controllers;

use App\Models\LevelModel;
use App\Models\QuestionModel;
use App\Models\GameResultModel;
use App\Models\UserProgressModel;

class Quiz extends BaseController
{
    protected $levelModel;
    protected $questionModel;
    protected $gameResultModel;
    protected $userProgressModel;

    public function __construct()
    {
        $this->levelModel = new LevelModel();
        $this->questionModel = new QuestionModel();
        $this->gameResultModel = new GameResultModel();
        $this->userProgressModel = new UserProgressModel();
    }

    public function index()
    {
        $data['levels'] = $this->levelModel->getAllLevels();
        return view('quiz/index', $data);
    }

    public function level($levelId)
    {
        $level = $this->levelModel->getLevelById($levelId);
        if (!$level) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Level not found');
        }

        $questions = $this->questionModel->getQuestionsByLevel($levelId);
        
        $data = [
            'level' => $level,
            'questions' => $questions,
            'totalQuestions' => count($questions)
        ];

        return view('quiz/level', $data);
    }

    public function submitAnswer()
    {
        $request = $this->request->getJSON(true);
        
        $questionId = $request['question_id'];
        $selectedAnswer = $request['selected_answer'];
        
        $question = $this->questionModel->getQuestionById($questionId);
        
        $isCorrect = ($question['correct_answer'] === $selectedAnswer);
        
        return $this->response->setJSON([
            'correct' => $isCorrect,
            'correct_answer' => $question['correct_answer'],
            'explanation' => $question['explanation']
        ]);
    }

    public function saveResult()
    {
        $request = $this->request->getJSON(true);
        
        $data = [
            'user_id' => session()->get('user_id'), // Add this line
            'player_name' => session()->get('full_name') ?? $request['player_name'] ?? 'Anonymous',
            'level_id' => $request['level_id'],
            'score' => $request['score'],
            'total_questions' => $request['total_questions'],
            'time_taken' => $request['time_taken']
        ];

        $resultId = $this->gameResultModel->saveResult($data);
        
        // Update user progress if logged in
        if (session()->get('isLoggedIn')) {
            $this->userProgressModel->updateProgress(
                session()->get('user_id'),
                $request['level_id'],
                $request['score'],
                $request['time_taken']
            );
        }
        
        return $this->response->setJSON([
            'success' => true,
            'result_id' => $resultId
        ]);
    }

    public function leaderboard()
    {
        $data['topScores'] = $this->gameResultModel->getTopScores(20);
        return view('quiz/leaderboard', $data);
    }
}
