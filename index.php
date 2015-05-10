<?php
/*
YLE News broadcast M3U generator
Markus Vuorio <markus.vuorio@gmail.com>
Joel Lehtonen <joel.lehtonen@koodilehto.fi>

Following example code from http://emmettbutler.com/threestegosaurusmoon/?p=955
*/

function getMedia($feed)
{
	$ret = array();

	// retrieve search results
	if($xml = simplexml_load_file($feed)) {
		$result = $xml->xpath("/rss/channel/item[1]/enclosure/@url");

        return (string)$result[0];
	}
}

//TODO: Read channel and language info from GET parameters and pass them to getFeedURL
$feedurl = 'http://feeds.yle.fi/areena/v1/series/1-1440981.rss?lang=fi';

//TODO: Get program filter string from GET parameters and pass it to getMedia
$media = getMedia($feedurl);

header('Location: '.$media);
?>
