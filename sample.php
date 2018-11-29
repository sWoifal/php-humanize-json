<?php

    // json pretty format function
	// incorporates code taken from php manual comment at http://php.net/manual/en/function.highlight-string.php#118550
    function prettyJson($jsonObj, $addPre = true)
    {
		// create jsonObject from string (if given param is string)
		if('string' === gettype($jsonObj)) {
			$jsonObj = json_decode($jsonObj);
		}

		$text = json_encode($jsonObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $text = trim($text);
        $text = highlight_string("<?php " . $text, true);  // highlight_string() requires opening PHP tag or otherwise it will not colorize the text
        $text = trim($text);
        $text = preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "", $text, 1);  // remove prefix
        $text = preg_replace("|\\</code\\>\$|", "", $text, 1);  // remove suffix 1
        $text = trim($text);  // remove line breaks
        $text = preg_replace("|\\</span\\>\$|", "", $text, 1);  // remove suffix 2
        $text = trim($text);  // remove line breaks
        $text = preg_replace("|^(\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>)(&lt;\\?php&nbsp;)(.*?)(\\</span\\>)|", "\$1\$3\$4", $text);  // remove custom added "<?php "

        // color format property names
        $pattern = "|\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>\"([^\"]+)\"\\</span\\>\\<span style\\=\"color\\: (#[a-fA-F0-9]{0,6})\"\\>\\:|";
        $replace = '<span style="color: #333333;">\1</span><span style="color: \2">:';
        $text = preg_replace($pattern, $replace, $text);

        return ($addPre ? '<pre>'.$text.'</pre>' : $text);
    }


    $sampleJson = '{"a": 200, "b": "sample", "c": {"p1": "test", "p2": "test2"}, "d": [0, 23, 42]}';
    echo prettyJson($sampleJson);

