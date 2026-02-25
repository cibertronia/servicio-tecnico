<?php

namespace Common;
use \Faker\Factory;
use \Faker\Generator;

class Faker extends Generator {

	public static function random($input = 6) {
		$faker = Factory::create();

		if (is_array($input)) {
			return $faker->randomElement($input);
		} else {
			return $faker->randomNumber($input);
		}
	}

	public static function text() {
		$faker = Factory::create();
		return $faker->text();
	}

	public static function street() {
		$faker = Factory::create();

		$add_number = $faker->randomNumber(4);
        $add_directional = $faker->randomElement(['N', 'S', 'W', 'E']);
        $add_street = $faker->streetName;
        $add_street_suffix = $faker->streetSuffix;
        $unit_number = $faker->buildingNumber;
        $unit_designator = $faker->randomElement(['BLDG', 'TRLR', 'FL', 'HTS']);

        $address = $add_number.' '.$add_directional.' '.$add_street.' '.$add_street_suffix;
        $address_2 = $unit_designator.' '.$unit_number;

        return [
        	'address' => $address,
        	'address_2' => $address_2,
        	'components' => [
				'street_number' => $add_number,
				'street_name' => $add_street,
				'unit_designator' => $unit_designator,
				'unit_number' => $unit_number,
				'street_suffix' => $add_street_suffix,
				'directional' => $add_directional
			]
        ];
	}

	public static function getPosition(&$data) {
        $faker = Factory::create();

        $status = 'OK';
        $data = (object)['status' => $status];

        return [$faker->latitude(25, 42), $faker->longitude(-125, -70)];
    }

	public static function address($include_extra = false) {
		$faker = Factory::create();

		$street = self::street();

		$address = [
			'address' => get('address', $street),
			'address_2' => get('address_2', $street),
			'city' => $faker->city,
			'state' => $faker->stateAbbr,
			'zip' => $faker->postcode,
			'type' => $faker->randomElement(['Residential', 'Business', 'POE', 'Appartment'])
		];

		if ($include_extra) {
			$address = array_merge($address, get('components', $street));
		}

		return $address;
	}

	public static function cc() {
		$faker = Factory::create();

		return [
			'holder' => $faker->name,
			'number' => $faker->creditCardNumber,
			'expiry_month' => $faker->numberBetween(1, 12),
			'expiry_year' =>$faker->numberBetween((int)date('Y'), (int)date('Y', strtotime('+10 year'))),
			'cvv' => $faker->randomNumber(3)
		];
	}

	public static function vehicle() {
		$faker = Factory::create();
		$faker->addProvider(new \Faker\Provider\Fakecar($faker));

		$v = $faker->vehicleArray();

		return [
			'year' => $faker->biasedNumberBetween(1998, 2017, 'sqrt'),
			'type' => ucwords($faker->vehicleType),
			'plate_number' => $faker->vehicleRegistration,
			'vin' => strtoupper($faker->vin),
			'state' => $faker->stateAbbr,
			'make' => $faker->randomElement(\Models\Option::map('value', ['type' => \Models\Option::TYPE_VEHICLE_MAKE])),
			'model' => get('model', $v),
			'color' => $faker->randomElement(\Models\Option::map('value', ['type' => \Models\Option::TYPE_COLOR]))
		];
	}

	public static function email() {
		$faker = Factory::create();
		return $faker->email;
	}

	public static function user() {
		$faker = Factory::create();

		return [
			'firstname' => $faker->firstName,
			'lastname' => $faker->lastName,
			'email' => $faker->email
		];
	}
}