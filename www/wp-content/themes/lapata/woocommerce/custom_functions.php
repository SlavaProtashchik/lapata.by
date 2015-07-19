<?php
function textFunc( $str, $maxLen, $slug )
	{

	if ( mb_strlen( $str ) > $maxLen )
		{
		preg_match( '/^.{0,'.$maxLen.'} .*?/ui', $str, $match );
		return $match[0].''.$slug;
		}
	else {
		return $str;
		}
	}
?>