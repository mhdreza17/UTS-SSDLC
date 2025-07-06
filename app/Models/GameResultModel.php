<?php

namespace App\Models;

use CodeIgniter\Model;

class GameResultModel extends Model
{
    protected $table            = 'game_results';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'player_name', 'level_id', 'score', 'total_questions', 'time_taken'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function saveResult($data)
    {
        return $this->insert($data);
    }

    public function getTopScores($limit = 10)
    {
        return $this->select('game_results.*, levels.level_name')
                   ->join('levels', 'levels.id = game_results.level_id')
                   ->orderBy('score', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getResultsByLevel($levelId)
    {
        return $this->where('level_id', $levelId)
                   ->orderBy('score', 'DESC')
                   ->findAll();
    }
}
