<?php
//Set the header type
header("Content-Type: application/rss+xml; charset=UTF-8");
//Include files
require_once('basic-config.php');
global $G_common_settings;
require_once($G_common_settings->kamar_common_display_path . '/kamar.php');
require_once($G_common_settings->kamar_common_interface_path . '/kamar.php');
$technical_config_path = $G_common_settings->config_path . '/technical-config.php';
require_once($technical_config_path);
//Load config from settings
$config['fm_path']                           = $config['fm_path'];
$config['caching_path']                      = $config['caching_path'];
//Get instance
$kamar = Kamar::getKAMARInstance();
$kamar->setFMPath($config['fm_path']);
$kamar_cache = KamarCache::getKAMARCacheInstance();
$kamar_cache->setCachePath($config['caching_path']);
$kcd_utilities = KamarKCDUtilities::getKamarKCDUtilitiesInstance();
//Get notices
$notice_day = strtotime(date("Y-m-d"));
$notice_list = NoticeFactory::buildWebNoticeList($notice_day);
	// Caching the entire output of the view so that the date generated is constant. for RSS readers.
	try {
		$cached_rss = $kamar_cache->getCacheItem('KCI_RSS_Notices_' . $notice_day, KCI_TIME_TO_CACHE_NOTICES, false);
	}
	catch (Exception $e) {
		try {
			// cache not found, load the notices to cache
			try {
				$cached_rss = $kamar_cache->setCacheItem('KCI_RSS_Notices_' . $notice_day, NoticeDisplay::showNoticesRSS($notice_list), false);
				echo(NoticeDisplay::showNoticesRSS($notice_list));
			} catch (Exception $e) {
				// suppress the exception as writing to the cache isn't a deal breaker
				// TODO: Log this or something ~ Adam
			}

		} catch (DatabaseQueryException $f) {
			try {
				// for some reason we couldn't query fresh data from the database, we hope we can fall back to an existing cache file or we let the exception slip through
				$cached_rss = $kamar_cache->getCacheItem('KCI_RSS_Notices_' . $notice_day, KCI_NO_EXPIRATON, false);
			} catch (Exception $g) {
				// if we can't get the cache file then the database exception is likely what is relevant
				throw $f;
			}
		}
	}


echo($cached_rss);

?>