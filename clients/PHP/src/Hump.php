<?php

namespace Hewgo;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Hump
{
	public static function dump($name, $input = null)
	{
		if (!isset($input)) {
			$input = $name;
			$name  = null;
		}

		$html = self::getHTML($input);
		self::post('dump', $name, $html);
	}

	private static function getHTML($var)
	{
		$cloner = new VarCloner();
		$dumper = new HtmlDumper();
		$output = fopen('php://memory', 'r+b');

		$dumper->dump($cloner->cloneVar($var), $output); // DumpOK
		$output = stream_get_contents($output, -1, 0);

		// städa
		$output = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $output);
		$output = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $output);

		return $output;
	}

	private static function post($type, $name, $output)
	{
		$data = new Msg(
			title: $name,
			type: $type,
			html: $output,
		);

		self::sendRequest($data->toArray());
	}

	private static function isDocker(): bool
	{
		return is_file("/.dockerenv");
	}

	private static function sendRequest($data)
	{
		$data = json_encode(Encoding::toUTF8($data), JSON_UNESCAPED_UNICODE);

		$curlHandle = \curl_init();

		$host = self::isDocker() ? 'host.docker.internal' : 'localhost';
		$url = 'http://' . $host . ':8383/';

		curl_setopt($curlHandle, CURLOPT_URL, $url);

		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
		]);

		curl_setopt($curlHandle, CURLOPT_USERAGENT, 'Hewgo/hump');
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT, 2);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curlHandle, CURLOPT_ENCODING, '');
		curl_setopt($curlHandle, CURLINFO_HEADER_OUT, true);
		curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
		curl_setopt($curlHandle, CURLOPT_POST, true);

		curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
		curl_exec($curlHandle);

		curl_close($curlHandle);
	}
}
