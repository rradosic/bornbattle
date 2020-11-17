<?php

namespace App\BattleSimulation;

interface BattleSimulation
{
    public function battleArmies(Army $firstArmy, Army $secondArmy): BattleResult;
}
