<?php

    add_shortcode('franklyAsk','frankly_widget_ask');
    add_shortcode('franklyAskLg','frankly_widget_ask_lg');
    add_shortcode('franklySmall','frankly_widget_sm');
    add_shortcode('franklyLarge','frankly_widget_lg');
    add_shortcode('frankly','frankly_widget');




    //Ask Button
    function frankly_widget_ask( $atts ) {

        $a = shortcode_atts(
            array(
                'id' => '1',
                'height' => '20px',
                'width'  => '52px',
                'style'    => 'float:right',

            ), $atts);


            if ( ! empty( $a['id'] ) ) {

                $uid = get_user_meta ( $a['id'], frankly, true );
                
                if( $uid != NULL ){

                    ob_start();
                    ?>
                    <iframe src="http://embed.frankly.me/askBtnSm/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>" 
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>                      

                    <?php
                    return ob_get_clean();
                }
            
            }

    }


    //Ask Button Large
    function frankly_widget_ask_lg( $atts ) {

        $a = shortcode_atts(
            array(

                'id'  =>  '1',
                'height' => '50px',
                'width'  => '255px',
                'style'    => 'float:right',

            ), $atts);


            if ( ! empty( $a['id'] ) ) {

                $uid = get_user_meta ( $a['id'], frankly, true );

                if( $uid != NULL ){

                    ob_start();
                    ?>
                    <iframe src="http://embed.frankly.me/askBtnLg/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>"
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>

                    <?php
                    return ob_get_clean();
                }
            }

    }





    //Small Widget
    function frankly_widget_sm( $atts ) {

        $a = shortcode_atts(
            array(

                'id'  =>  '1',
                'height' => '444px',
                'width'  => '202px',
                'style'    => 'float:right',
            ), $atts);

            if ( ! empty( $a['id'] ) ) {

                $uid = get_user_meta ( $a['id'], frankly, true );

                if( $uid != NULL ){

                    ob_start();
                    ?>
                     <iframe src="http://embed.frankly.me/userWidgetSm/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>" 
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>

                    <?php
                    return ob_get_clean();
                }
            }
    }




   //Large Widget
    function frankly_widget_lg( $atts ) {

        $a = shortcode_atts(
            array(

                'id'  =>  '1',
                'height' => '480px',
                'width'  => '640px',
                'style'    => 'float:right',

            ), $atts);

            if ( ! empty( $a['id'] ) ) {
                
                $uid = get_user_meta ( $a['id'], frankly, true );
                
                if( $uid != NULL ){

                    ob_start();
                    ?>

                    <iframe src="http://embed.frankly.me/userWidgetLg/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>"
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>

                    <?php
                    return ob_get_clean();
                }
            }
    }






    //Versatile widget - just pass type="ask/sm/lg" as attribute
    function frankly_widget( $atts ) {



        $a = shortcode_atts(
            array(

                'id'  =>  '1',
                'type'   => 'lg',
                'height' => '480px',
                'width'  => '640px',
                'style'    => 'float:right',

            ), $atts);



        if($a['type']=='ask') {

            if ( ! empty( $a['id'] ) ) {

                $uid = get_user_meta ( $a['id'], frankly, true );
                
                if( $uid != NULL ){

                    $a['height'] = '20px';
                    $a['width'] = '52px';

                    ob_start();

                    ?>
                    <iframe src="http://embed.frankly.me/askBtnSm/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>" 
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>                      
                    
                    <?php
                    return ob_get_clean();
                }

            }

        }
        
        

        else if($a['type']=='ask_lg') {

            if ( ! empty( $a['id'] ) ) {

                $uid = get_user_meta ( $a['id'], frankly, true );
                
                if( $uid != NULL ){

                    $a['height'] = '50px';
                    $a['width'] = '255px';

                    ob_start();

                    ?>
                    <iframe src="http://embed.frankly.me/askBtnLg/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>"
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>

                    <?php
                    return ob_get_clean();
                }

           }

        }


        else if($a['type']=='sm') {

            if ( ! empty( $a['id'] ) ) {

                
                $uid = get_user_meta ( $a['id'], frankly, true );
                
                if( $uid != NULL ){

                    $a['height'] = '444px';
                    $a['width'] = '202px';

                    ob_start();

                    ?>


                    <iframe src="http://embed.frankly.me/userWidgetSm/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>" 
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>


                    <?php
                    return ob_get_clean();
                }
            }

        }


        else if($a['type']=='lg') {

            if ( ! empty( $a['id'] ) ) {

                $uid = get_user_meta ( $a['id'], frankly, true );
                
                if( $uid != NULL ){

                    ob_start();
                    ?>


                    <iframe src="http://embed.frankly.me/userWidgetLg/template.html?user=<?php _e($uid); ?>"
                        height="<?php _e($a['height']);?>" width="<?php _e($a['width']);?>"
                        style="<?php _e($a['style']);?>" frameborder="0" scrolling="no" 
                        marginheight="0px" marginwidth="0px"></iframe>

                    <?php
                    return ob_get_clean();
                }

            }

        }
    

    }
?>