<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

class ETime
{
	/**
	 * The MediaWiki hook we'll start from. Sets the text
	 * for the {{#tag}} and calls the render function.
	 *
	 * @param \Parser $parser
	 */
	public static function onParserSetup( &$parser ){
		$parser->setHook('etime', 'ETime::renderETime' );
	}

	/**
	 * All we need to do here is get the current Egypt time from the ArmEagle
	 * API and return it as a string that is cleaned up a bit for display.
	 *
	 * @param $input
	 * @param $params
	 * @param $parser
	 * @param $frame
	 *
	 * @return string
	 */
	public static function renderETime( $input, $params, $parser, $frame ) {

		$parser->disableCache();

		$client = new Client();

		$response = $client->request('GET', 'https://atitd.sharpnetwork.net/gameclock/tabtime.asp');

		$raw = $response->getBody()->getContents();

		$split = explode("\t", $raw);

		$output = 'Year ' . $split[0] . ', ' . $split[1] . ' ' . $split[2] . '-' . $split[3] . ', ' . $split[4] . ':' . $split[5] . ' ' . $split[6];

		return $output;
	}
}