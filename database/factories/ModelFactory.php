<?php

use Ace\Paciente;
use Ace\Acompanante;
use Ace\Agenda;
use Ace\Tratamiento;
use Ace\Laboratorio;
use Ace\Medicamento;
use Faker\Generator;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// $factory->define(Ace\User::class, function (Faker\Generator $faker) {
//     static $password;

//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'password' => $password ?: $password = bcrypt('secret'),
//         'remember_token' => str_random(10),
//     ];
// });

$factory->define(Paciente::class, function (Generator $faker) {

    $array = [
        'tipoId' => $faker->numberBetween($min = 1, $max = 5),
        'identificacion' => $faker->unique()->randomNumber($nbDigits = 8),
        'nombres' => $faker->name($gender = null|'male'|'female'),
        'apellidos' => $faker->lastName,
        'fechaNacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'telefonoFijo' => $faker->phoneNumber,
        'telefonoCelular' => $faker->phoneNumber,
        'email' => $faker->email,
        'genero' => $faker->numberBetween($min = 1, $max = 3),
        'hijos' => $faker->boolean,
        'ciudad_id' => $faker->numberBetween($min = 1, $max = 1112),
        'ubicacion' => $faker->numberBetween($min = 1, $max = 2),
        'direccion' => $faker->address,
        'estadoCivil' => $faker->numberBetween($min = 1, $max = 5),
        'ocupacion' => $faker->jobTitle,
        'eps_id' => $faker->numberBetween($min = 1, $max = 66),
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
    ];

    return $array;
});

$factory->define(Acompanante::class, function (Generator $faker) {

    $array = [
        'tipoId' => $faker->numberBetween($min = 1, $max = 5),
        'identificacion' => $faker->unique()->randomNumber($nbDigits = 8),
        'nombres' => $faker->name($gender = null|'male'|'female'),
        'apellidos' => $faker->lastName,
        'telefonoFijo' => $faker->phoneNumber,
        'telefonoCelular' => $faker->phoneNumber,
    ];

    return $array;
});

$factory->define(Tratamiento::class, function (Generator $faker) {

    $array = [
        'nombre' => $faker->word,
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
    ];

    return $array;
});

$factory->define(Laboratorio::class, function (Generator $faker) {

    $array = [
        'nombre' => $faker->word,
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
    ];

    return $array;
});

$factory->define(Medicamento::class, function (Generator $faker) {

    $array = [
        'nombre' => $faker->word,
        'tipo' => $faker->numberBetween($min = 1, $max = 2),
        'concentracion' => $faker->word,
        'unidades' => $faker->numberBetween($min = 1, $max = 100),
        'presentacion_id' => $faker->numberBetween($min = 1, $max = 48),
        'laboratorio_id' => $faker->numberBetween($min = 1, $max = 10),
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
    ];

    return $array;
});