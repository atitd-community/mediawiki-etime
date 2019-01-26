This is a MediaWiki extension that adds a `{{#tag:etime}}` tag that retrieves and displays the current Egpyt time.

Installation
============

  * Download and place the files in a directory called `ETime` in your `extensions/` folder.
  * Add the following code at the bottom of your LocalSettings.php:

```php
wfLoadExtension( 'ETime' );
```

  * Run `composer install` from within the `ETime` directory.
  * **Done** — Navigate to Special:Version on your wiki to verify that the extension is successfully installed.