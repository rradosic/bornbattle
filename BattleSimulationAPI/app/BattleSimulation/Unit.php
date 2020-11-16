<?php

namespace App\BattleSimulation;

class Unit
{
    public float $health = 100;
    private int $armor = 7;
    private int $attack = 14;


    public function getArmor(): int
    {
        return $this->armor;
    }

    public function getAttack(): int
    {
        return $this->attack;
    }

}
