<?php

class Frankly_Widget extends WP_Widget {
    

    function __construct() {
        parent::__construct(
            'frankly_widget',
            __( 'Frankly.me', 'frankly-me' ),
            array( 'description' => __( 'Sidebar widget for Frankly.me', 'frankly-me' ), )
        );
    }



    public function widget( $args, $instance ) {

        $widget_type = empty($instance['frankly_widget_type']) ? 'sm':  $instance['frankly_widget_type'];


        echo $args['before_widget'];

        if($widget_type=='sm')
        {
            $widget_height=444;
            $widget_width=202;


            if ( ! empty( $instance['frankly_userid'] ) ) {
                
                $uid = get_user_meta ( $instance['frankly_userid'], frankly, true );

                if( $uid != NULL ){

                    echo '<iframe src="http://embed.frankly.me/userWidgetSm/template.html?user='.
                        $uid  . '" height="' . $widget_height . 'px" width="' . $widget_width . 'px"
                        frameborder="0" scrolling="no" marginheight="0px" marginwidth="0px"></iframe>';
                
                }

            }

        }

        if($widget_type=='ask')
        {
            $widget_height=20;
            $widget_width=52;

            if ( ! empty( $instance['frankly_userid'] ) ) {

                $uid = get_user_meta ( $instance['frankly_userid'], frankly, true );
                
                if( $uid != NULL ){


                    echo '<iframe src="http://embed.frankly.me/askBtnSm/template.html?user='.
                        $uid  . '" height="' . $widget_height . 'px" width="' . $widget_width . 'px"
                        frameborder="0" scrolling="no" marginheight="0px" marginwidth="0px"></iframe>';
                }
            }


        }

        echo $args['after_widget'];
    }




    public function form( $instance ) {
    
        $args = array(
                'meta_key'     => 'frankly',
                'meta_value'   => undefined,
                'meta_compare' => '!=',
                'orderby'      => 'login',
                'order'        => 'ASC',
                'fields'       => 'all',
            ); 

        $users = get_users($args); 

        if(count($users)>0){
                    
                $frankly_userid = ! empty( $instance['frankly_userid'] ) ? $instance['frankly_userid'] : __( '', 'frankly-me' );
            
            ?>
            
                <p>
            
                    <label for="<?php echo $this->get_field_id( 'frankly_userid' ); ?>">
                        <?php _e( 'Frankly.me User Id:' ); ?>
                    </label>

                    <select class="widefat" id="<?php echo $this->get_field_id( 'frankly_userid' ); ?>"
                     name="<?php echo $this->get_field_name( 'frankly_userid' ); ?>" type="text" >
                        <?php
                        foreach ($users as $key => $user) {
                            $x = get_user_meta ( $user->ID, frankly, true );

                            ?>
                            
                            

                            <option value="<?php echo $user->ID;?>"  <?php echo (($frankly_userid == $user->ID)?'selected':''); ?> >
                             <?php echo $x;?> ( for user having WP login id: <?php echo $user->user_login; ?> ) </option>

                            <?php

                        }
                        
                        ?>

                    </select>


                </p>


            <?php
            
                $frankly_widget_type = ! empty( $instance['frankly_widget_type'] ) ? $instance['frankly_widget_type'] : __( 'sm', 'frankly-me' );
            
            ?>
            
                <p>
                
                    <label for="<?php echo $this->get_field_id( 'frankly_widget_type' ); ?>"><?php _e( 'Widget Type:' ); ?></label>

                    <select class='widefat' id="<?php echo $this->get_field_id('frankly_widget_type'); ?>"
                            name="<?php echo $this->get_field_name('frankly_widget_type'); ?>" type="text">
                            
                        <option value='ask'<?php echo ($frankly_widget_type=='ask')?'selected':''; ?>>Ask Button</option>
                        <option value='sm'<?php echo ($frankly_widget_type=='sm')?'selected':''; ?>>Vertical Descriptive Widget</option>
                        <!--<option value='lg'<?php //echo ($frankly_widget_type=='lg')?'selected':''; ?>>Large Descriptive Widget (280x340)</option>-->
                    </select>

                </p>


                <p>
                    * Only those users are shown in the dropdown those who have registered their frankly.me user settings in Profile information.
                </p>

            <?php
            }

            else{

                ?>
                
                <p>
                    <b style="color:red"> To use our widgets, you first need to add frankly.me profile information of required user in his Wordpress User settings. If you don't know where it is, just head on to Admin Panel>Users, select the required user and then scroll to the bottom and fill out his Frankly.me Profile Information.</b>
                </p>

                <?php

            }

    }




    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['frankly_userid'] = ( ! empty( $new_instance['frankly_userid'] ) ) ? strip_tags( $new_instance['frankly_userid'] ) : '';


        $instance['frankly_widget_type'] = ( ! empty( $new_instance['frankly_widget_type'] ) ) ? strip_tags( $new_instance['frankly_widget_type'] ) : '';

        return $instance;
    }

}




function register_frankly_widget() {
    register_widget( 'Frankly_Widget' );
}



add_action( 'widgets_init', 'register_frankly_widget' );

?>