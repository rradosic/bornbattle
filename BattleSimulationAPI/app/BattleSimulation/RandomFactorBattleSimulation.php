<?php

namespace App\BattleSimulation;

class RandomFactorBattleSimulation implements BattleSimulation
{
    private int $turnsDone = 0;
    private int $droneStrikes = 0;
    private int $casualties = 0;
    private int $moraleBoost = 2;
    private int $moraleChance = 40;
    private int $baseDroneChance = 5;
    private int $attacker;
    private int $defender;
    private array $armies;
    private array $currentUnits = [];


    /**
     * Simulates the battle with random factors of morale and drone attacks
     * @param Army $firstArmy 
     * @param Army $secondArmy 
     * @return BattleResult End result of the battle
     */
    public function battleArmies(Army $firstArmy, Army $secondArmy): BattleResult
    {
        $this->armies = [$firstArmy, $secondArmy];

        //Choose which army is the first attacker randomly
        $this->attacker = mt_rand(0, 1);
        $this->defender = !$this->attacker;

        $this->assignNewUnitToSide($this->attacker);
        $this->assignNewUnitToSide($this->defender);

        while ($this->armies[0]->hasUnits() && $this->armies[1]->hasUnits()) {
            $this->processTurn();
        }

        //Determine victor
        $victor = $firstArmy->getNumberOfUnits() > $secondArmy->getNumberOfUnits() ? 0 : 1;

        $battleResult = new BattleResult();
        $battleResult->victor = $this->armies[$victor]->getName();
        $battleResult->loser = $this->armies[!$victor]->getName();
        $battleResult->totalCasualties = $this->casualties;
        $battleResult->totalTurns = $this->turnsDone;
        $battleResult->droneStrikes = $this->droneStrikes;

        return $battleResult;
    }

    /**
     * Processes the battles turn. Initiates attack phase and checks for defender deaths.
     * @return void 
     */
    private function processTurn(): void
    {
        $this->processAttack();

        $this->checkDefenderHealth();

        //Switch roles between armies, basically just switches the index
        $this->attacker = !$this->attacker;
        $this->defender = !$this->defender;

        $this->turnsDone++;
    }

    /**
     * Process the attack phase of the current turn
     * @return void 
     */
    private function processAttack(): void
    {
        $defenderMorale = $this->calculateMorale();

        $attackerUnit = &$this->currentUnits[$this->attacker];
        $defenderUnit = &$this->currentUnits[$this->defender];

        //There is a small chance that the defending side will get a drone strike that insta kills attacker

        $droneChance = $this->calculateDroneChance();

        $droneAttack = mt_rand(1, 100) < $droneChance ? true : false;

        if ($droneAttack) {
            $this->killUnitOnSide($this->attacker);
            $this->droneStrikes++;
        } else {
            $defenderUnit->health -= $attackerUnit->getAttack() - $defenderUnit->getArmor() * $defenderMorale;
        }
    }

    private function calculateDroneChance()
    {
        $differenceInUnitNumbers = $this->armies[$this->attacker]->getNumberOfUnits() - $this->armies[$this->defender]->getNumberOfUnits();
        $droneChance = $this->baseDroneChance;
        if ($differenceInUnitNumbers > 0) {
            $droneChance += $differenceInUnitNumbers / 10;
        }

        //Limit the chance of drone to max 15%
        return min(15, $droneChance);
    }

    /**
     * Calculates if the morale boost will be given this turn
     * @return int Amount of morale boost
     */
    private function calculateMorale(): int
    {
        return mt_rand(1, 100) < $this->moraleChance ? $this->moraleBoost : 1;
    }

    /**
     * Checks the health of the current defender and kills him if it's below 0
     * @return void 
     */
    private function checkDefenderHealth(): void
    {
        $defender = $this->currentUnits[$this->defender];
        if ($defender->health <= 0) {
            $this->killUnitOnSide($this->defender);
        }
    }

    /**
     * Kills the unit on the specified side of the turn
     * @param int $side Side of the unit
     * @return void 
     */
    private function killUnitOnSide(int $side)
    {
        $this->assignNewUnitToSide($side);
        $this->reduceUnitFromSide($side);
        $this->casualties++;
    }

    /**
     * Assigns a new unit to the specified side 
     * @param int $side Side of the unit
     * @return void 
     */
    private function assignNewUnitToSide(int $side)
    {
        $this->currentUnits[$side] = new Unit($this->armies[$side]);
    }

    /**
     * Subtracts 1 from the total unit count of the specified side
     * @param int $side Side of the unit
     * @return void 
     */
    private function reduceUnitFromSide(int $side)
    {
        $this->armies[$side]->reduceUnits(1);
    }
}
