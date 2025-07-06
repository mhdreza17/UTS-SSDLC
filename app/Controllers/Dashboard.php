<?php

namespace App\Controllers;

use App\Models\UserProgressModel;
use App\Models\LevelModel;
use App\Models\GameResultModel;

class Dashboard extends BaseController
{
    protected $userProgressModel;
    protected $levelModel;
    protected $gameResultModel;

    public function __construct()
    {
        $this->userProgressModel = new UserProgressModel();
        $this->levelModel = new LevelModel();
        $this->gameResultModel = new GameResultModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        
        $data = [
            'title' => 'Dashboard - Security Quiz Game',
            'userProgress' => $this->userProgressModel->getUserProgress($userId),
            'allLevels' => $this->levelModel->getAllLevels(),
            'recentResults' => $this->gameResultModel->where('user_id', $userId)
                                                   ->orderBy('created_at', 'DESC')
                                                   ->limit(5)
                                                   ->findAll()
        ];

        return view('dashboard/index', $data);
    }
}
