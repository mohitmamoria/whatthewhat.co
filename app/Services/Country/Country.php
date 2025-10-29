<?php

namespace App\Services\Country;

use libphonenumber\PhoneNumberUtil;

class Country
{
    public static function all()
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        // All supported ISO 3166-1 alpha-2 region codes, e.g. ['IN','US','GB',...]
        $regions = $phoneUtil->getSupportedRegions();

        $countries = [];

        foreach ($regions as $regionCode) {
            $isdCode = $phoneUtil->getCountryCodeForRegion($regionCode); // e.g. 91
            $name     = \Locale::getDisplayRegion('-' . $regionCode, 'en'); // "India"
            $flag     = static::flag($regionCode);

            $countries[] = [
                'alpha_2'   => $regionCode,
                'name'      => $name,
                'isd'       => '+' . $isdCode,
                'flag'      => $flag,
            ];
        }

        // Put India first, then sort rest by name.
        usort($countries, function ($a, $b) {
            if ($a['alpha_2'] === 'IN') return -1;
            if ($b['alpha_2'] === 'IN') return 1;
            return strcmp($a['name'], $b['name']);
        });

        return $countries;
    }

    public static function flag(string $countryCode): string
    {
        $countryCode = strtoupper($countryCode);
        $offset = 127397; // Unicode offset for regional indicator symbols

        $chars = [];
        foreach (str_split($countryCode) as $char) {
            $chars[] = mb_chr(ord($char) + $offset, 'UTF-8');
        }

        return implode('', $chars);
    }
}
