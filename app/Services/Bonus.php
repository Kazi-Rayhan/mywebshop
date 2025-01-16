<?php

namespace App\Services;

use App\Models\Level;
use App\Models\User;

class Bonus
{
    private User $manager;
    private Level $level;
    private int $completed_session;


    public function __construct(User $manager, int $completed_session)
    {
        $this->manager = $manager;
        $this->completed_session = $completed_session;
        $this->level = $this->getLevel();
    }

    private function getLevel()
    {
        return Level::find($this->manager->level);
    }
    public function calculate()
    {
        $bonus = 0;
        if ($this->manager->level && $this->level) {
            
            foreach ($this->level->bonus as $range => $commission) {
                if ($this->completed_session < $range) {
                    break;
                }

                $bonus = $commission;
            }
        }
        return $bonus * $this->completed_session;
    }
}
