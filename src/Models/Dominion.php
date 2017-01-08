<?php

namespace OpenDominion\Models;

use OpenDominion\Services\DominionSelectorService;

class Dominion extends AbstractModel
{
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function realm()
    {
        return $this->belongsTo(Realm::class);
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function selectedByAuthUser()
    {
        $dominionSelectorService = app()->make(DominionSelectorService::class);

        $selectedDominion = $dominionSelectorService->getUserSelectedDominion();

        if ($selectedDominion === null) {
            return false;
        }

        return ($this->id === $selectedDominion->id);
    }

    /**
     * Returns the Dominion's population, military and non-military.
     *
     * @return int
     */
    public function getPopulation()
    {
        return ($this->peasants + $this->getPopulationMilitary());
    }

    /**
     * Returns the Dominion's military population.
     *
     * @return int
     */
    public function getPopulationMilitary()
    {
        return (
            $this->draftees
            + $this->military_unit1
            + $this->military_unit2
            + $this->military_unit3
            + $this->military_unit4
            + $this->military_spies
            + $this->military_wizards
            + $this->military_archmages
        );
    }
}
