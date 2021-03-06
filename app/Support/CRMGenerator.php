<?php

namespace App\Support;

use Faker\Generator as Faker;
use JansenFelipe\FakerBR\FakerBR;

class CRMGenerator
{
    private static $ufs = [
        'AC'=>'Acre',
        'AL'=>'Alagoas',
        'AP'=>'Amapá',
        'AM'=>'Amazonas',
        'BA'=>'Bahia',
        'CE'=>'Ceará',
        'DF'=>'Distrito Federal',
        'ES'=>'Espírito Santo',
        'GO'=>'Goiás',
        'MA'=>'Maranhão',
        'MT'=>'Mato Grosso',
        'MS'=>'Mato Grosso do Sul',
        'MG'=>'Minas Gerais',
        'PA'=>'Pará',
        'PB'=>'Paraíba',
        'PR'=>'Paraná',
        'PE'=>'Pernambuco',
        'PI'=>'Piauí',
        'RJ'=>'Rio de Janeiro',
        'RN'=>'Rio Grande do Norte',
        'RS'=>'Rio Grande do Sul',
        'RO'=>'Rondônia',
        'RR'=>'Roraima',
        'SC'=>'Santa Catarina',
        'SP'=>'São Paulo',
        'SE'=>'Sergipe',
        'TO'=>'Tocantins'
    ];

    /**
     * Generate dynamic Doctor CRM.
     * @return string
     */
    public static function generate()
    {
        $faker = new Faker();
        $faker->addProvider(new FakerBR($faker));

        return $faker->numerify('#########') . ' CRM-' . array_rand(self::$ufs, 1);
    }
}
