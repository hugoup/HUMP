<?php

include '../vendor/autoload.php';
include 'inc.php';

use Hewgo\Hump;


class TestClass
{
	private $apa = 'apa';
	protected $gam = 'fågel';

	public $lala = [
		'test' => 'adsf',
		'apa' => [
			'nested' => 'apa',
			'mer'	 => [
				'apa' => 'apa'
			]
		]
	];

	public function getBird()
	{
		return $this->gam;
	}
}



// Hump::dump([
// 	'test' => 'adsf',
// 	[
// 		'test' => 'adsf',
// 		'apa' => [
// 			'nested' => 'apa',
// 			'mer'	 => [
// 				'apa' => 'apa'
// 			]
// 		]
// 	]
// ]);


// Hump::dump('Tjosan');


Hump::dump('Namnet på classen', new TestClass);

echo gethostbyname('local.dev');

echo '<br>';

echo gethostbyname('host-gateway');


testing('aaaa');
