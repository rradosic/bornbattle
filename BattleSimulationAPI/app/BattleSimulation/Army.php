<?php

namespace App\BattleSimulation;

class Army
{
    private string $name = 'Name';
    private int $numberOfUnits = 100;

    /**
     * Contructs the Army object
     *
     * @param string $name Name of the army
     * @param integer $numberOfUnits Number of units in the army
     */
    public function __construct(string $name, int $numberOfUnits)
    {
        $this->numberOfUnits = $numberOfUnits;
    }

    /**
     * Returns the name of the army
     *
     * @return string Name of the army
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the number of units remaining in the army
     * @return int number of the units
     */ 
    public function getNumberOfUnits(): int
    {
        return $this->name;
    }

    /**
     * Reduces the number of remainnig units by the specified number
     * @param int $number Number to reduce by. Defualts to 1
     * @return void 
     */
    public function reduceUnits(int $number=1): void
    {
        if($this->numberOfUnits >= $number) $this->numberOfUnits -+ $number;
    }
}
