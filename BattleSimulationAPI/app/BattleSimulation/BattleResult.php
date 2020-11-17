<?php

namespace App\BattleSimulation;

class BattleResult
{
    public string $victor;
    public string $loser;
    public int $totalCasualties;
    public int $totalTurns;
    public int $droneStrikes;

    /**
     * Gives an array representation of this result
     * @return array
     */
    public function toArray()
    {
        return [
            'victor' => $this->victor,
            'loser' => $this->loser,
            'totalCasualties' => $this->totalCasualties,
            'totalTurns' => $this->totalTurns,
            'droneStrikes' => $this->droneStrikes,
        ];
    }
}
