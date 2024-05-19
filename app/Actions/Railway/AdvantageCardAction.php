<?php

namespace App\Actions\Railway;

use App\Models\Railway\Config\RailwayAdvantageCard;
use App\Models\Railway\Engine\RailwayEngine;

class AdvantageCardAction extends AdvantageDropRate
{
    /**
     * Generate RailwayAdvantageCard objects
     *
     * This method generates RailwayAdvantageCard objects and saves them to the database.
     * It iterates over the existing RailwayAdvantageCard objects and deletes them before generating new ones.
     * For each generated card, it assigns a random class and type, calculates the quantity (qte) based on the type and class,
     * defines the coast based on the class, generates a description based on the type and quantity,
     * calculates the drop rate based on the quantity and type, and assigns a random model_id if the type is 'engine'.
     */
    public function generate(): void
    {
        foreach (RailwayAdvantageCard::all() as $card) {
            $card->delete();
        }

        // TODO: ajouter la prise en charge de model_id pour les reskins lorsque le développement est terminer
        for ($i = 0; $i <= 250; $i++) {
            $class = $this->generateClass();
            $type = $this->generateType();
            $qte = $this->generateQteFromTypeAndClass($type, $class);
            $coast = $this->defineCoastFromClass($class);
            RailwayAdvantageCard::create([
                'class' => $class,
                'type' => $type,
                'description' => $this->defineDescriptionFromType($type, $qte),
                'qte' => $qte,
                'tpoint' => $coast,
                'drop_rate' => $this->calculateDropRateByType($qte, $type),
                'model_id' => $type == 'engine' ? RailwayEngine::all()->random()->id : null,
                'name_function' => $this->defineNameFunctionFromType($type),
            ]);
        }
    }

    /**
     * Generate a random class for RailwayAdvantageCard
     *
     * This method returns a randomly selected class for a RailwayAdvantageCard.
     * The available classes are 'premium', 'first', 'second', and 'first'.
     *
     * @return string The randomly selected class
     */
    public function generateClass(): string
    {
        $classes = collect(['premium', 'first', 'second', 'first']);

        return $classes->random();
    }

    /**
     * Generates a random type from a predefined list.
     */
    public function generateType(): string
    {
        $types = collect(['argent', 'research_rate', 'research_coast', 'audit_int', 'audit_ext', 'simulation', 'credit_impot', 'engine', 'reskin']);

        return $types->random();
    }

    /**
     * Generate quantity from type and class.
     *
     * @param  string  $type  The type of the item.
     * @param  string  $class  The class of the item.
     * @return float|int The generated quantity.
     */
    public function generateQteFromTypeAndClass(string $type, string $class): float|int
    {
        return match ($class) {
            'premium' => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 10),
            'first' => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 5),
            'second' => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 2),
            'third' => self::generateQteFromType($type),
            default => 0,
        };
    }

    /**
     * Generate the quantity from the given type.
     *
     * @param  string  $type  The type to generate the quantity from.
     * @return float|int The generated quantity.
     */
    public function generateQteFromType(string $type): float|int
    {
        return match ($type) {
            'argent', 'credit_impot', 'research_coast' => round(random_int(100000, 1000000), -3, PHP_ROUND_HALF_UP),
            'research_rate' => round(generateRandomFloat(0.05, 0.20), 2, PHP_ROUND_HALF_UP),
            'audit_int', 'audit_ext', 'simulation' => random_int(1, 10),
            'engine', 'reskin' => 1,
            default => 0,
        };
    }

    /**
     * Define the coast based on the given class.
     *
     * @param  string  $class  The class to define the coast from.
     * @return int The defined coast.
     */
    public function defineCoastFromClass(string $class): int
    {
        return match ($class) {
            'premium' => 50,
            'first' => 25,
            'second' => 15,
            default => 0,
        };
    }

    /**
     * Define the description from the given type and quantity.
     *
     * @param  string  $type  The type to define the description from.
     * @param  int  $qte  The quantity to define the description from.
     * @return string The defined description.
     */
    public function defineDescriptionFromType(string $type, int $qte): string
    {
        if ($type == 'engine' || $type == 'reskin') {
            $motor = RailwayEngine::all()->random();
        } else {
            $motor = null;
        }

        return match ($type) {
            'argent' => '+ '.number_format($qte, 0, ',', ' ').' €',
            'research_rate' => 'Taux R&D + '.$qte.'%',
            'research_coast' => 'Budget R&D + '.number_format($qte, 0, ',', ' ').' €',
            'audit_int' => number_format($qte, 0, ',', ' ').' audit interne',
            'audit_ext' => number_format($qte, 0, ',', ' ').' audit externe',
            'simulation' => number_format($qte, 0, ',', ' ').' simulation',
            'credit_impot' => 'Impôt - '.number_format($qte, 0, ',', ' ').' €',
            'engine' => $motor->name,
            'reskin' => 'Reskin de '.$motor->name,
            default => 'Erreur',
        };
    }

    /**
     * Calculate drop rate by type.
     *
     * @param  int  $qte  The quantity.
     * @param  string  $type  The type.
     * @return float|int The drop rate.
     */
    public function calculateDropRateByType(int $qte, string $type)
    {
        return match ($type) {
            'argent' => $this->rateArgent($qte),
            'research_rate' => $this->rateResearchRate($qte),
            'research_coast' => $this->rateResearchCoast($qte),
            'audit_int' => $this->rateAuditInt($qte),
            'audit_ext' => $this->rateAuditExt($qte),
            'simulation' => $this->rateSimulation($qte),
            'credit_impot' => $this->rateCreditImpot($qte),
            'engine', 'reskin' => 5.0,
            default => 0,
        };
    }

    /**
     * Retrieve a collection of categories.
     *
     * @param  string  $search  The optional string to search for categories.
     * @return \Illuminate\Support\Collection The collection of categories.
     */
    public function categories(string $search = ''): \Illuminate\Support\Collection
    {
        $lists = collect();
        $lists->push([
            'slug' => 'third',
            'name' => 'Troisième classe',
            'color_bg' => 'bg-grey-800',
            'color_text' => 'text-grey-300',
            'cards' => RailwayAdvantageCard::where('class', 'third'),
        ]);

        $lists->push([
            'slug' => 'second',
            'name' => 'Seconde classe',
            'color_bg' => 'bg-red-800',
            'color_text' => 'text-red-300',
            'cards' => RailwayAdvantageCard::where('class', 'second'),
        ]);

        $lists->push([
            'slug' => 'first',
            'name' => 'Première classe',
            'color_bg' => 'bg-blue-800',
            'color_text' => 'text-blue-300',
            'cards' => RailwayAdvantageCard::where('class', 'first'),
        ]);

        $lists->push([
            'slug' => 'premium',
            'name' => 'Premium',
            'color_bg' => 'bg-yellow-800',
            'color_text' => 'text-yellow-300',
            'cards' => RailwayAdvantageCard::where('class', 'premium'),
        ]);

        return $lists;
    }

    /**
     * Define the name function from the given type.
     *
     * @param  string  $type  The type to define the name function from.
     * @return string|null The defined name function or null if not found.
     */
    private function defineNameFunctionFromType(string $type): ?string
    {
        return match ($type) {
            'argent' => 'argent',
            'research_rate' => 'research_rate',
            'research_coast' => 'research_coast',
            'audit_int' => 'audit_int',
            'audit_ext' => 'audit_ext',
            'simulation' => 'simulation',
            'credit_impot' => 'credit_impot',
            'engine' => 'engine',
            'reskin' => 'reskin',
            default => null,
        };
    }
}
