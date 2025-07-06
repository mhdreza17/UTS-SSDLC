<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProgressModel extends Model
{
    protected $table            = 'user_progress';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'level_id', 'best_score', 'best_time', 'attempts'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'completed_at';
    protected $updatedField  = 'completed_at';

    public function getUserProgress($userId)
    {
        return $this->select('user_progress.*, levels.level_name, levels.level_description')
                   ->join('levels', 'levels.id = user_progress.level_id')
                   ->where('user_id', $userId)
                   ->findAll();
    }

    public function updateProgress($userId, $levelId, $score, $time)
    {
        $existing = $this->where('user_id', $userId)
                        ->where('level_id', $levelId)
                        ->first();

        if ($existing) {
            $updateData = [
                'attempts' => $existing['attempts'] + 1
            ];

            if ($score > $existing['best_score']) {
                $updateData['best_score'] = $score;
            }

            if ($time < $existing['best_time'] || $existing['best_time'] == 0) {
                $updateData['best_time'] = $time;
            }

            return $this->update($existing['id'], $updateData);
        } else {
            return $this->insert([
                'user_id' => $userId,
                'level_id' => $levelId,
                'best_score' => $score,
                'best_time' => $time,
                'attempts' => 1
            ]);
        }
    }
}
