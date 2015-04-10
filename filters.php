<?php
//TODO : SINGLE PAGE POSt

function list_filter($content) {
 // if(one post)
  	
  	//$auth = get_the_author_ID();
  	//$wpid = the_author(); //$auth->ID;
	
	//$wpid = the_author_meta('ID');
	$uid = get_the_author_meta('frankly');

	$retrieve = get_option( 'addASK' );
	//return json_encode($uid) . $content;

	if($retrieve['add_ask']==1)
	{
		if($uid == NULL)
		{
			$defUser = $retrieve['add_def_user'];
			if($defUser!=NULL)
			{
				$uid = get_the_author_meta( 'frankly', $defUser );

				if($uid == NULL) return $content;
			}
		}


		$height = '20px';
		$width = '52px';
		$style = 'float:' . (($retrieve['add_align']==1) ? 'left':'right') ;



		$html =  '<iframe src="http://embed.frankly.me/askBtnSm/template.html?user='.$uid.'" '.
					' height="' . $height . '" width="' . $width . '" ' .
                    ' style="' . $style . '" frameborder="0" scrolling="no" ' .
                    ' marginheight="0px" marginwidth="0px"></iframe></br>';

		if($retrieve['add_position'] == 1)
			return $html . $content;
		else
			return  $content . $html;
	}                        
	
	else

		return $content;
  
}
// <script>
/*var x = <?php echo json_encode($wpid); ?>;


// console.log(<?php echo json_encode($auth); ?>);
// console.log(<?php echo json_encode(get_the_ID()); ?>);
// //console.log(<?php echo json_encode(get_author_meta('ID')); ?>);
// console.log(<?php echo json_encode(get_the_author(get_the_ID())); ?>);
//console.log(<?php echo json_encode(the_author_meta('ID'));?>);
*/
// </script>

/*function single_post_filter($content) {
 
 // if(one post)
/*  $uid = get_the_author_meta('frankly');
//To do : any ask or other vertical
	  $height = '444px';
	  $width = '202px';
	  $style = 'float:right';
	  $html = '<iframe src="http://embed.frankly.me/userWidgetSm/template.html?user='.$uid.
	  						'"height="' . $height . '" width="' . $width . 
	                        '" style="' . $style .'" frameborder="0" scrolling="no"' .
	                        ' marginheight="0px" marginwidth="0px"></iframe>';

  return $html . $content;*//*
  return $content;
}*/


//if(is_singlular())
//add_filter( 'the_content', 'single_post_filter', 2);
//else
add_filter( 'the_content', 'list_filter', 20);

?>