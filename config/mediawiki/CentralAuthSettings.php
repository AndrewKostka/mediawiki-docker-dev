<?php

# https://www.mediawiki.org/wiki/Extension:CentralAuth
# https://www.mediawiki.org/wiki/Manual:$wgConf#Example

wfLoadExtension( 'CentralAuth' );

$wgCentralAuthDatabase = 'centralauth';
$wgCentralAuthAutoMigrate = true;
$wgCentralAuthAutoMigrateNonGlobalAccounts = true;

$wgLocalDatabases = array(
    'default',
    'centralauth'
);

$wgConf->wikis = $wgLocalDatabases;
$wgConf->localVHosts = array( 'db-master.mw.test' );

$wgConf->settings = array(
    'wgServer' => array(
        'default' => 'http://default.web.mw.test:8080',
        'centralauth' => 'http://centralauth.web.mw.test:8080'
    ),

    'wgCanonicalServer' => array(
        'default' => 'http://default.web.mw.test:8080',
        'centralauth' => 'http://centralauth.web.mw.test:8080'
    ),

    'wgScriptPath' => array(
        'default' => '/mediawiki',
    ),

    'wgArticlePath' => array(
        'default' => '/mediawiki/index.php/$1',
    ),

    'wgSitename' => array(
        'default' => 'default',
        'centralauth' => 'centralauth',
    ),

    'wgLanguageCode' => array(
        'default' => '$lang',
    ),

    'wgLocalInterwiki' => array(
        'default' => '$lang',
    )
);

function efGetSiteParams( $conf, $wiki ) {
    $site = null;
    $lang = null;
    foreach( $conf->suffixes as $suffix ) {
        if ( substr( $wiki, -strlen( $suffix ) ) == $suffix ) {
            $site = $suffix;
            $lang = substr( $wiki, 0, -strlen( $suffix ) );
            break;
        }
    }
    return array(
        'suffix' => $site,
        'lang' => $lang,
        'params' => array(
            'lang' => $lang,
            'site' => $site,
            'wiki' => $wiki,
        ),
        'tags' => array(),
    );
}

$wgConf->suffixes = $wgLocalDatabases;
$wgConf->siteParamsCallback = 'efGetSiteParams';
$wgConf->extractAllGlobals( $wgDBname );
