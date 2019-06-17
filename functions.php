<?php

function construct_query( $text, $code ) {
	$query =  "https://translate.googleapis.com/translate_a/single?client=gtx";
	$query .= "&dt=bd&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=t&dt=at";
	$query .= "&hl=en&sl=auto"; // HomeLang = English & SourceLang = auto
	$query .= "&tl=" . $code; // targetLang = code we set
	$query .= "&q=" . urlencode( $text );
	return $query;
}

function fix_garbled_json( $trans ) {
	// Google gives us something that looks like garbled JSON. So, let's fix it.
	while ( false !== strpos( $trans, '[,' ) ) :
		$trans = str_replace( '[,', '[null,', $trans );
	endwhile;
	while ( false !== strpos( $trans, ',,' ) ) :
		$trans = str_replace( ',,', ',null,', $trans );
	endwhile;
  $trans = json_decode( $trans, true );
	$string = '';
	foreach ( $trans[0] as $t ) :
		$string .= trim( $t[0] ) . ' ';
	endforeach;

	return $string;
}

// https://stackoverflow.com/questions/26714426/what-is-the-meaning-of-google-translate-query-params