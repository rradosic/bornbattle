<?php

namespace App\BattleSimulation;

class RandomFactorBattleSimulation implements BattleSimulation
{
    private int $turnsDone = 0;
    private int $moraleBoost;
    private int $moraleChance = 15;
    private int $casualties = 0;
    private int $attacker;
    private int $defender;
    private array $armies;
    private array $currentUnits;

    public function __construct(int $moraleBoost = 2) {
        $this->moraleBoost = $moraleBoost;
    }

    public function battleArmies(Army $firstArmy, Army $secondArmy): BattleResult
    {
        $this->armies = [$firstArmy, $secondArmy];

        //Choose which army is the first attacker randomly
        $this->attacker = rand(0,1);
        $this->defender = !$this->attacker;

        $this->currentUnits = [new Unit($firstArmy), new Unit($secondArmy)];

        while ($this->armies[0]->hasUnits() && $this->armies[1]->hasUnits()) {
            $this->processTurn();
        }

        $battleResult = new BattleResult();
        $battleResult->victor = $this->armies[$this->defender]->getName();
        $battleResult->loser = $this->armies[$this->attacker]->getName();
        $battleResult->totalCasualties = $this->casualties;
        $battleResult->totalTurns = $this->turnsDone;

        return $battleResult;
    }

    private function processTurn(): void
    {
        $this->processAttack();

        $this->checkDefenderHealth();

        //Switch roles between armies
        $this->attacker = !$this->attacker;
        $this->defender = !$this->defender;

        $this->turnsDone++;
    }

    private function processAttack(): void
    {
        $attackerMorale = $this->calculateMorale();
        $defenderMorale = $this->calculateMorale();

        $attacker = &$this->currentUnits[$this->attacker];
        $defender = &$this->currentUnits[$this->defender];

        $defender->health -= $attacker->getAttack()*$attackerMorale - $defender->getArmor()*$defenderMorale;

    }

    private function calculateMorale(): int{
        $randomValue = rand(1,100);
        return $randomValue < $this->moraleChance ? $this->moraleBoost : 1;
    }

    private function checkDefenderHealth(): void{
        $defender = $this->currentUnits[$this->defender];
        if($defender->health <= 0){
            $this->currentUnits[$this->defender] = new Unit($this->armies[$this->defender]);
            $this->armies[$this->defender]->reduceUnits();
            $this->casualties++;
        }
    }
}
