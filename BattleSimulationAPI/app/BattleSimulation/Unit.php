<?php

namespace App\BattleSimulation;

class Unit
{
    public float $health = 100;
    private int $armor = 7;
    private int $attack = 14;


    /**
     * Returns the amount of armor
     * @return int Armour amount
     */
    public function getArmor(): int
    {
        return $this->armor;
    }

    /**
     * Returns the attack strength
     * @return int Attack strength
     */
    public function getAttack(): int
    {
        return $this->attack;
    }

}
