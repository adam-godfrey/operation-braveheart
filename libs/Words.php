<?php
class Words {

	public function __construct() {
	
	}
	
	// truncate each of the news item's content to a set number of words
	public static function truncateWords($rows) {
	
		// loop through the array 
		foreach($rows as $key => $row) {
			// and truncate content to 60 words
			$rows[$key]['content'] = self::trunc($row['content'], 60);
		}
		
		return $rows;
	}
	
	public function adv_count_words($str) {
	
		$words = 0;
		$str = eregi_replace(" +", " ", $str);
		$array = explode(" ", $str);
		
		for($i=0;$i < count($array);$i++)
		{
			if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$i]))
			$words++;
		}
		return $words;
	}
	
	public static function ShortenText($text, $chars) {
	
		$text = $text." ";
		$text = substr($text,0,$chars);
		$text = substr($text,0,strrpos($text,' '));
		$text = $text."...";

		return $text;
	}

	public function abbr($str, $maxLen) {
	
		if (strlen($str) > $maxLen && $maxLen > 1)
		{
			preg_match("#^.{1,".$maxLen."}\.#s", $str, $matches);
			return $matches[0];
		}
		else
		{
			return $str;
		}
	}
	
	public static function trunc($phrase, $max_words) {
	
		$phrase_array = explode(' ',$phrase);
		
		if(count($phrase_array) > $max_words && $max_words > 0)
			$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
  
		return $phrase;
	}

	//This function intelligently trims a body of text to a certain
	//number of words, but will not break a sentence.
	public function smart_trim($string, $truncation)
	{
		$matches = preg_split("/\s+/", $string);
		$count = count($matches);

		if($count > $truncation)
		{
			//Grab the last word; we need to determine if
			//it is the end of the sentence or not
			$last_word = strip_tags($matches[$truncation-1]);
			$lw_count = strlen($last_word);

			//The last word in our truncation has a sentence ender
			if($last_word[$lw_count-1] == "." || $last_word[$lw_count-1] == "?" || $last_word[$lw_count-1] == "!")
			{
				for($i=$truncation;$i<$count;$i++)
				{
					unset($matches[$i]);
				}
			} 
			//The last word in our truncation doesn't have a sentence ender, find the next one
			else
			{
				//Check each word following the last word until
				//we determine a sentence's ending
				for($i=($truncation);$i<$count;$i++)
				{
					if($ending_found != true)
					{
						$len = strlen(strip_tags($matches[$i]));
						if($matches[$i][$len-1] == "." || $matches[$i][$len-1] == "?" || $matches[$i][$len-1] == "!")
						{
							//Test to see if the next word starts with a capital
							if($matches[$i+1][0] == strtoupper($matches[$i+1][0]))
							{
								$ending_found = true;
							}
						}
					} 
					else
					{
						unset($matches[$i]);
					}
				}
			}

			//Check to make sure we still have a closing <p> tag at the end
			$body = implode(' ', $matches);
			
			if(substr($body, -4) != "</p>")
			{
				$body = $body."</p>";
			}
			return $body; 
		}
		else
		{
			return $string;
		}
	}

	public function trim_text($input, $length, $ellipses = true, $strip_html = true)
	{
		//strip tags, if desired
		if ($strip_html)
		{
			$input = strip_tags($input);
		}
	 
		//no need to trim, already shorter than trim length
		if (strlen($input) <= $length)
		{
			return $input;
		}
	 
		//find last space within length
		$last_space = strrpos(substr($input, 0, $length), ' ');
		$trimmed_text = substr($input, 0, $last_space);
	 
		//add ellipses (...)
		if ($ellipses)
		{
			$trimmed_text .= '...';
		}
	 
		return $trimmed_text;
	}
}
?>