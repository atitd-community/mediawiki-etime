<?php

use MediaWiki\MediaWikiServices;

class ETime
{
	/** Seconds a reading is reused, about one game minute. */
	private const CACHE_TTL = 15;

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
	 * All we need to do here is get the current Egypt time from the game's
	 * time API and return it as a string that is cleaned up a bit for display.
	 *
	 * @param $input
	 * @param $params
	 * @param $parser
	 * @param $frame
	 *
	 * @return string
	 */
	public static function renderETime( $input, $params, $parser, $frame ) {
		global $wgETimeGameId;

		$parser->getOutput()->updateCacheExpiry( self::CACHE_TTL );

		$services = MediaWikiServices::getInstance();
		$cache = $services->getMainWANObjectCache();

		// A failed fetch is cached as '' so a slow API isn't asked again on every view
		$output = $cache->getWithSetCallback(
			$cache->makeGlobalKey( 'etime', $wgETimeGameId ),
			self::CACHE_TTL,
			static function () use ( $services, $wgETimeGameId ) {
				$raw = $services->getHttpRequestFactory()->get(
					'https://gamedata.desert-nomad.com/api/time/' . rawurlencode( $wgETimeGameId ),
					[ 'timeout' => 3, 'connectTimeout' => 2 ],
					__METHOD__
				);

				$text = json_decode( $raw ?? '', true )['text'] ?? null;

				return is_string( $text ) ? $text : '';
			}
		);

		return htmlspecialchars( $output === '' ? 'Error' : $output );
	}
}
