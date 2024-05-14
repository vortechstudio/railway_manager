<?php

namespace App\Enums\Railway\Config;

enum LevelRewardTypeEnum: string
{
    case ARGENT = 'argent';
    case TPOINT = 'tpoint';
    case RD_RATE = 'rd_rate';
    case RD_COAST = 'rd_coast';
    case AUDIT_INT = 'audit_int';
    case AUDIT_EXT = 'audit_ext';
    case SIMULATION = 'simulation';
    case IMPOT = 'impot';
    case ENGINE = 'engine';
    case ENGINE_R = 'engine_r';

    public static function getLabel($case): string
    {
        return match ($case) {
            self::ARGENT => 'Argent',
            self::TPOINT => 'TPoint',
            self::RD_RATE => 'Taux de recherche',
            self::RD_COAST => 'App de recherche',
            self::AUDIT_INT => 'Audit Interne',
            self::AUDIT_EXT => 'Audit Externe',
            self::SIMULATION => 'Simulation',
            self::IMPOT => 'Crédit Impot',
            self::ENGINE => 'Matériel Roulant',
            self::ENGINE_R => 'reskin',
        };
    }

    public static function getValue($case): string
    {
        return match ($case) {
            self::ARGENT => 'argent',
            self::TPOINT => 'TPoint',
            self::RD_RATE => 'research_rate',
            self::RD_COAST => 'research_coast',
            self::AUDIT_INT => 'audit_int',
            self::AUDIT_EXT => 'audit_ext',
            self::SIMULATION => 'simulation',
            self::IMPOT => 'credit_impot',
            self::ENGINE => 'engine',
            self::ENGINE_R => 'reskin',
        };
    }

    public static function getIcon($case): string
    {
        return match ($case) {
            self::ARGENT => \Storage::url('icons/railway/argent.png'),
            self::TPOINT => \Storage::url('icons/railway/tpoint.png'),
            self::RD_RATE => \Storage::url('icons/railway/rate_research.png'),
            self::RD_COAST => \Storage::url('icons/railway/research.png'),
            self::AUDIT_INT => \Storage::url('icons/railway/audit_int.png'),
            self::AUDIT_EXT => \Storage::url('icons/railway/audit_ext.png'),
            self::SIMULATION => \Storage::url('icons/railway/simulation.png'),
            self::IMPOT => \Storage::url('icons/railway/credit_impot.png'),
            self::ENGINE => \Storage::url('icons/railway/train.png'),
            self::ENGINE_R => \Storage::url('icons/railway/reskin.png'),
        };
    }
}
