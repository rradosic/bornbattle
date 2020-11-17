<?php

namespace App\Http\Controllers;

use App\BattleSimulation\Army;
use App\BattleSimulation\BattleSimulation;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BattleSimulationController extends Controller
{

    public function battle(Request $request, BattleSimulation $battleSimulation)
    {
        $this->validate($request, [
            'army1' => 'required|integer',
            'army2' => 'required|integer',
        ]);

        //Maybe do this in the middleware but its fine since its only one route
        $requestHash = md5(time());
        Log::info("New battle request:" . $requestHash, $request->all());

        $firstArmy = new Army(config('battle.firstArmyName'), $request->army1);
        $secondArmy = new Army(config('battle.secondArmyName'), $request->army2);

        try {
            $battleResult = $battleSimulation->battleArmies($firstArmy, $secondArmy);
        } catch (\Throwable $e) {
            Log::error("Request " . $requestHash . " failed:", $e->getTrace());
            return response('', 500)->json([
                'success' => false,
            ]);
        }

        //Maybe do this in the middleware but its fine since its only one route
        Log::info("Battle request " . $requestHash . " done:", $battleResult->toArray());

        return response()->json([
            'success' => true,
            'result' => $battleResult->toArray()
        ]);
    }
}
