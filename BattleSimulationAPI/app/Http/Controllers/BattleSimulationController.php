<?php

namespace App\Http\Controllers;

use App\BattleSimulation\Army;
use App\BattleSimulation\BattleSimulation;
use Illuminate\Http\Request;

class BattleSimulationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function battle(Request $request, BattleSimulation $battleSimulation)
    {
        $this->validate($request, [
            'army1'=> 'required|integer',
            'army2'=> 'required|integer',
        ]);

        $firstArmy = new Army("Army 1", $request->army1);
        $secondArmy = new Army("Army 2", $request->army2);

        $battleResult = $battleSimulation->battleArmies($firstArmy, $secondArmy);

        dd(json_encode($battleResult));
    }
}
