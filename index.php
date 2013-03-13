#EXTM3U
<?php
/*
YLE News broadcast M3U generator
Markus Vuorio <markus.vuorio@gmail.com>

Following example code from http://emmettbutler.com/threestegosaurusmoon/?p=955
*/

function getFeedURL($language, $channel)
{
	$channel = trim($channel);
	$language = trim($language);
	if ($channel == "") $channel = "yle-radio-suomi";
	if ($language == "") $language = "fin";
	$format = "http://areena.yle.fi/radio/uutiset/kaikki.rss?kieli=%s&kanava=%s&jarjestys=uusin";
	return sprintf($format, $language, $channel);
}

function getMedia($feed, $namefilter="Yle Uutiset:")
{
	//$feedUrl = 'http://emmettbutler.com/threestegosaurusmoon/?feed=rss2';
	$ret = array();
	$ret[0] = "";

	// retrieve search results
	if($xml = simplexml_load_file($feed)) { //load xml file using simplexml
		$result[] = $xml->xpath("/rss/channel/item"); //divide feed into array elements
		
		foreach($result[0] as $items)
		{
			foreach($items as $key => $data)
			{
				if($key == "title" && strstr($data, $namefilter))
				{
					$ret[0] = (string)$data;
				}
				
				//TODO: Tidy this, looks nasty
				if($ret[0] != "" && $key == "enclosure")
				{
					$data = (array)$data;
					$atts = $data["@attributes"];
					$ret[1] = $atts["url"];
					return $ret;
				}
			}
		}	
	}
}

$feedurl = getFeedURL("", "");
$media = getMedia($feedurl);

//TODO: See what the magical -1 is in the #EXTINF
printf("#EXTINF:-1,%s\n", $media[0]);
echo $media[1];
?>
