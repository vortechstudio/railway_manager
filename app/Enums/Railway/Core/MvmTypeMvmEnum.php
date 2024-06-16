<?php

namespace App\Enums\Railway\Core;

enum MvmTypeMvmEnum: string
{
    case ELECTRICITE = 'electricite';
    case GASOIL = 'gasoil';
    case PRET = 'pret';
    case INTERET = 'interet';
    case TAXE = 'taxe';
    case MAINTENANCE_ENGINE = 'maintenance_engine';
    case MAINTENANCE_TECHNICENTRE = 'maintenance_technicentre';
    case BILLETTERIE = 'billetterie';
    case RENT_TRAJET_AUX = 'rent_trajet_aux';
    case COMMERCE = 'commerce';
    case PUBLICITE = 'publicite';
    case PARKING = 'parking';
    case IMPOT = 'impot';
    case SUBVENTION = 'subvention';
    case ACHAT_MATERIEL = 'achat_materiel';
    case ACHAT_LIGNE = 'achat_ligne';
    case ACHAT_HUB = 'achat_hub';
    case LOCATION_MATERIEL = 'location_materiel';
    case COUT_TRAJET = 'cout_trajet';
    case DIVERS = 'divers';
    case VENTE_HUB = 'vente_hub';
    case VENTE_LIGNE = 'vente_ligne';
    case VENTE_ENGINE = 'vente_engine';
    case INCIDENT = 'incident';
    case RESEARCH = 'research';
}
