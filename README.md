This is a MediaWiki extension that adds a `{{#tag:etime}}` tag that retrieves and displays the current Egpyt time.

Installation
============

  * Download and place the files in a directory called `ETime` in your `extensions/` folder.
  * Add the following code at the bottom of your LocalSettings.php:

```php
wfLoadExtension( 'ETime' );
```

  * **Done** — Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

Configuration
=============

  * `$wgETimeGameId` (default `ATITD11A`): the game world whose time is shown, as https://gamedata.desert-nomad.com/api/time/ names it.