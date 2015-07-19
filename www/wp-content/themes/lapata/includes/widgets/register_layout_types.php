<?php

function choose_template($layout, $items) {


  $layout_template=strtr($layout, array( 
                          "linear"=>"content-widget-product-linear",
                          "mix1"=>"content-widget-product-mix1",
                        /*  "mix2"=>"content-widget-product-mix2", */
                          "default"=>"content-widget-product"
                        )
           );

  $layout_items_num="";

/*
  if ( substr($layout, 0, 3)=="mix" ) {
	  if ($items>0 && $items<=6) {
	  	$layout_items_num="-6";
	  } elseif ($items>6 && $items<=12) {
	  	$layout_items_num="-12";
	  }
	} */

  $result=$layout_template.$layout_items_num.".php";

	return $result;
}
?>