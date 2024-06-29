<?php

namespace Hewgo;

use DateTime;

class Msg
{

	private $timestamp;
	private array $extra = [];
	private array $trace = [];

	public function __construct(
		public ?string $title = null,
		public string $type = 'info',
		public mixed $output = '',
		public string $html = '',
	) {
		$this->timestamp = new DateTime();

		// först lägg till extra data så inte det skrivs över
		$this->extra = $this->extraData();

		$this->trace = $this->backtrace();
	}

	private function backtrace()
	{
		$backtrace   = debug_backtrace();
		// Ta bort classerna som man är i 
		unset($backtrace[0]);
		unset($backtrace[1]);
		unset($backtrace[2]);

		foreach ($backtrace as $key => $val) {

			$args = [];
			foreach ($val['args'] as $k => $v) {
				if (is_object($v)) {
					$val['args'][$k] = get_class($v);
				}

				$args[] = gettype($val['args'][$k]);
			}
			$backtrace[$key] = $val['file'] . ':: (' . $val['line'] . ') :: ' . $val['function'] . '(' . implode(', ', $args) . ')';

			if (!empty($val['args'])) {
				$this->extra['args'][] = $val['args'];
			}
		}

		return $backtrace;
	}

	private function extraData()
	{
		$extra = [
			'GET' =>  $_GET ?? [],
			'POST' =>  $_POST ?? [],
			'COOKIE' =>  $_COOKIE ?? [],
			'SERVER' =>  $_SERVER ?? [],
			'REQUEST' =>  $_REQUEST ?? [],
			'FILES' =>  $_FILES ?? [],
			'ENV' =>  $_ENV ?? [],
			'SESSION' =>  $_SESSION ?? [],
			'GLOBALS' =>  $GLOBALS ?? [],
			'HEADERS' =>  $http_response_header ?? [],
		];

		foreach ($extra as $k => $v) {
			$extra[$k] = array_filter($v);
		}
		return  array_filter($extra);
	}

	public function addExtra($key, $data)
	{
		$this->extra[$key] = $data;
	}

	public function toArray()
	{
		return [
			'title'	 => $this->title ?? 'Dump',
			'type' => $this->type,
			'output' => $this->output,
			'html' => $this->html,
			'timestamp' => $this->timestamp->format('Ymd H:i:s'),
			'extra' => $this->extra,
			'trace' => $this->trace,
		];
	}
}
