<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Sandwich;
use DateTime;

class SandwichController extends Controller
{
    public function detail($name)
    {
        if (empty($_SESSION['user_id'])) {
            return header("Location: /login");
        }

        $sandwich = Sandwich::get($name);

        if (!$sandwich) {
            return $this->view('sandwich/notfound', [
                'name' => $name
            ]);
        }

        // Gestion des jours (semaine en cours / semaine suivante)
        $days = $this->buildDaysList();

        $this->view('sandwich/detail', [
            'name' => ucfirst($name),
            'sandwich' => $sandwich,
            'days' => $days
        ]);
    }

    private function buildDaysList()
    {
        $days = ['Lundi', 'Mardi', 'Jeudi', 'Vendredi'];
        $result = [];

        $now = new DateTime();
        $nowNum = (int)$now->format('N');  // 5 = Vendredi, 6-7 weekend

        $limitToday = new DateTime('today 11:20');

        // SEMAINE SUIVANTE SI : vendredi après 16h OU week-end
        $nextWeek = ($nowNum === 5 && $now >= new DateTime('today 16:00')) || ($nowNum >= 6);

        foreach ($days as $dayName) {

            $d = clone $now;

            // semaine actuelle ou suivante ?
            if ($nextWeek) {
                $d->modify("next week $dayName");
            } else {
                $d->modify("this week $dayName");
            }

            $isDisabled = false;

            if (!$nextWeek) {
                if ($d < $now || ($d->format('Y-m-d') === $now->format('Y-m-d') && $now > $limitToday)) {
                    $isDisabled = true;
                }
            }

            $result[] = [
                'label' => $dayName,
                'date'  => $d->format('d/m/Y'),
                'disabled' => $isDisabled
            ];
        }

        return $result;
    }
}