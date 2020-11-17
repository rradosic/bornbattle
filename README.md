# BornBattle

The task was to implement an API endpoint which simulates a battle of two armies with a random modifier which affects the outcome of the battle. Random modifiers in this instance are morale boosts for the defending side and a small chance of a drone strike that instantly kills the attacker. This gives the army with a lower number of units a chance to win.

## Installation
### Requirements

 - Docker

### Steps
 1. `git clone https://github.com/rradosic/bornbattle.git`
 2. `cd bornbattle`
 3. `docker run --rm -v $(pwd)/BattleSimulationAPI:/app composer install`
 4. `docker-compose up`

The application should now be running at http://localhost:8080

## Endpoints

#### Simulate battle
  Simulates the battle and returns the result

* **URL**

  /

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `army1=[integer]`
   `army2=[integer]`


* **Success Response:**

  * **Code:** 200 <br />
    **Example Content:** `{"success":true,"result":{"victor":"Army 1","loser":"Army 2","totalCasualties":161,"totalTurns":2554}}`
 
* **Error Response:**

  * **Code:** 422 Unprocessable Entity <br />
    **Example Content:** `{"army2":["The army2 must be an integer."]}`
