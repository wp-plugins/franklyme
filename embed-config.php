<?php

define("ARGS",   serialize(array(
    'meta_key'     => 'frankly',
    'meta_value'   => undefined,
    'meta_compare' => '!=',
    'orderby'      => 'login',
    'order'        => 'ASC',
    'fields'       => 'all',
)));

add_action( 'wp_ajax_my_action', 'my_action_callback' );

function my_action_callback() {

    update_usermeta( get_current_user_id(), 'frankly', $_POST['frankly_uname'] );
    echo json_encode("done");
    wp_die();
}


class franklySettingsPage
{
    
    private $options;
    public $users;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page()
    {

        add_options_page(
            'Ask Frankly, Configuration', 
            'Frankly.me', 
            'publish_posts', 
            'frankly', 
            array( $this, 'create_admin_page' )
        );
    }


    public function page_init()
    {        

        register_setting(
                    'addASK_group', // Option group
                    'addASK', // Option name
                    array( $this, 'sanitize' ) // Sanitize
                );
        register_setting(
            'new_group', // Option group
            'new', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        
        
    

        add_settings_section(
            'setting_section', // ID
            '<h2>Add Ask Me Widget to your posts</h2>', // Title
            array( $this, 'print_section_info' ), // Callback
            'frankly' // Page
        );  

        add_settings_field(
            'add_ask', 
            'Add frankly.me ask button to your posts', 
            array( $this, 'add_ask_callback' ), 
            'frankly', 
            'setting_section'
        );      

        add_settings_field(
            'add_def_user', 
            'Default Frankly.me User', 
            array( $this, 'add_def_user_callback' ), 
            'frankly', 
            'setting_section'
        );  

        add_settings_field(
            'add_align', 
            'Align', 
            array( $this, 'add_align_callback' ), 
            'frankly', 
            'setting_section'
        );  

        add_settings_field(
            'add_position', 
            'Position at', 
            array( $this, 'add_position_callback' ), 
            'frankly', 
            'setting_section'
        );  

    }



    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {

        $new_input = array();
        $users = get_users(unserialize(ARGS));

        if( isset( $input['add_def_user'] ) )
            $new_input['add_def_user'] = absint( $input['add_def_user'] );


        if( isset( $input['add_ask'] ) ) 
        {
            if ( $input['add_ask'] == 'Yes')
            {
                $new_input['add_ask'] = 1;

            
                if( isset( $input['add_align'] ) ) 
                {
                    $new_input['add_align'] = absint( $input['add_align'] );
                }

                if( isset( $input['add_position'] ) ) 
                {
                    $new_input['add_position'] = absint( $input['add_position'] );
                }

            }


        }
    
        return $new_input;        
    }



    public function print_section_info()
    {
        print '<h4>Enter your settings below:</h4>';
    }


    public function frankly_uname_callback()
    {
        printf( '<input type="text" id="frankly_uname" name="addASK[frankly_uname]" ');

        printf('<br><br><br>
                <b style="decorator:underlined">How to get frankly user name?</b><br>
                    <div style="margin-left:20px">
                    <ul style="list-style-type:circle">
                    <li> Download the frankly.me app 
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=me.frankly">
                        Google Play<!-- <img src="images/icons/playstore.png" class="MainGetAppLinks"> --></a> or 
                        <a target="_blank" href="https://itunes.apple.com/in/app/frankly.me-talk-to-celebrities/id929968427&amp;mt=8">
                        App Store<!-- <img src="images/icons/appstore.png" class="MainGetAppLinks"> --></a>.
                    </li>
                    <li> Create an account</li>
                    <li> Open your profile to get your user name.</li>
                    </ul><div>'
                );
    }



    public function add_ask_callback()
    {
        printf(
            '<input type="checkbox" id="add_ask" name="addASK[add_ask]" value="Yes" %s/>',
            isset( $this->options['add_ask'] ) ? esc_attr( $this->options['add_ask'] == 1 ? 'checked' : '' ) : ''
        );
    }



    public function add_def_user_callback()
    {

        $users = get_users(unserialize(ARGS));

        printf('<select type="text" id="add_def_user" name="addASK[add_def_user]"  value="%s" >',
                   isset( $this->options['add_def_user'] ) ? esc_attr( $this->options['add_def_user']) : '');


        foreach ($users as $user) {
            
            $x = get_user_meta ( $user->ID, frankly, true );

            if($x != NULL)
            printf('<option value="%d" %s > %s ( for user having WP login id: %s )</option>',
                $user->ID , isset( $this->options['add_def_user'] ) ? (  esc_attr( $this->options['add_def_user']) == $user->ID ?  'selected' : '' ) : '' , $x , $user->user_login ) ;
    
        }

        printf('</select>');

        printf('</br></br>* Note: Ask button will be associated to default frankly.me user account unless the author has also registered one in his profile.');
        
    }


    public function add_align_callback()
    {

        printf('<select type="text" id="add_align" name="addASK[add_align]"  value="%s" >',
                   isset( $this->options['add_align'] ) ? esc_attr( $this->options['add_align']) : '');
    
        printf('<option value="1" %s >Left</option>',
         isset( $this->options['add_align'] ) ? (  esc_attr( $this->options['add_align']) == 1 ?  'selected' : '' ) : '' ) ;

        printf('<option value="2" %s >Right</option>',
         isset( $this->options['add_align'] ) ? (  esc_attr( $this->options['add_align']) == 2 ?  'selected' : '' ) : '' ) ;


        printf('</select>');

    }


    public function add_position_callback()
    {

        printf('<select type="text" id="add_position" name="addASK[add_position]"  value="%s" >',
                   isset( $this->options['add_position'] ) ? esc_attr( $this->options['add_position']) : '');
    
        printf('<option value="1" %s >Top</option>',
         isset( $this->options['add_position'] ) ? (  esc_attr( $this->options['add_position']) == 1 ?  'selected' : '' ) : '' ) ;

        printf('<option value="2" %s >Bottom</option>',
         isset( $this->options['add_position'] ) ? (  esc_attr( $this->options['add_position']) == 2 ?  'selected' : '' ) : '' ) ;


        printf('</select>');

    }


    public function create_admin_page()
    {
        

        $this->options = get_option( 'addASK' );
        

        print('<style>

           .settingSec
           {
                background: #e9e9e9;//f0f0f0;
                
                border: 1px #cdcdcd solid;//#e3e3e3
                border-radius: 6px;
                -moz-border-radius: 6px;
                -webkit-border-radius: 6px;

                margin-top: 15px;
                min-width: 480px;
                width: 100%;
                float: left;
                margin-bottom: 25px; 
                padding: 20px 20px 0px 30px;
                max-width: 960px;
           }

        </style>




        <div class="wrap" >
            <h2>Ask Frankly, Configuration</h2>           
           ');
           
            $users = get_users(unserialize(ARGS));
            if( ( current_user_can('manage_options')  && (count($users) == 0 ) ) || (  (! current_user_can('manage_options')) && get_user_meta ( get_current_user_id(), frankly, true ) == NULL ) )
            {
                print('<div id="settingWithOptions" class="settingSec">');

                print_signIn();

                print('</div>');
            }

            if( current_user_can('manage_options') && count($users) > 0 )
            {

                print('<div id="settingWithOptions" class="settingSec">
             
                             <form method="post" action="options.php">');
                   
                        settings_fields( 'addASK_group' ); 
                        do_settings_sections( 'frankly' );
                        submit_button();


                print('                   
                        </form>
                        <br>
                        </div>
                    ');
            }
            ?>

            <script type='text/javascript'>

                (function($){

                     if( $('#add_ask').is(':checked') )
                         $('#settingWithOptions table').eq(0).children('tbody').children('tr').show();//$('#add_ask').parents.find('tr').show();
                     else
                         $('#settingWithOptions table').eq(0).children('tbody').children('tr').not(':eq(0)').hide();                        


                    $('#add_ask').change(
                        function(){
                              $('#settingWithOptions table').eq(0).children('tbody').children('tr').not(':eq(0)').hide();                        

                            if( $(this).is(':checked') ){
                                $('#settingWithOptions table').eq(0).children('tbody').children('tr').show();
                            }
                    });
                    
                })(jQuery);

            </script>
            

            <?php

            $users = get_users(unserialize(ARGS));
            if( ( current_user_can('manage_options') && count($users)>0 )|| ( get_user_meta ( get_current_user_id(), frankly, true ) != NULL ) )
            {

                print('<div class="settingSec">');
            
                print_widget_description();
                
                print('</div>
           
                        
                <div class="settingSec">
                ');
                
                print_basic_description();
            
                print('</div>');

            
                if(current_user_can('manage_options'))
                {
                    
                    print('<div class="settingSec">');
                    print_adv_description();
                    print('</div>');
                }


            }
        
    }
}

if( is_admin() )
    $frankly_settings_page = new franklySettingsPage();


function print_signIn()
{
    print('<br>
        <h2>Enter your Frankly.me username to get started,</h2>
        <h4>Enter your settings below:</h4>
        <table class="form-table">
        <tr>
            <th scope="row">Frankly.me User Name</th>
            <td>
                <input type="text" id="frankly_uname" name="frankly_uname" />
                <span id="user-result"></span>
                <br><br><br>
                <b style="decorator:underlined">How to get frankly user name?</b><br>
                    <div style="margin-left:20px">
                    <ul style="list-style-type:circle">
                        
                        <li> Download the frankly.me app from
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=me.frankly">
                            <img style="height:30px; vertical-align: middle;" src="'. plugins_url( 'images/playstore.png' , __FILE__ ).'" class="MainGetAppLinks"></a> or 
                            <a target="_blank" href="https://itunes.apple.com/in/app/frankly.me-talk-to-celebrities/id929968427&amp;mt=8">
                            <img style="height:30px; vertical-align: middle;" src="'. plugins_url( 'images/appstore.png' , __FILE__ ).'" class="MainGetAppLinks"></a>.
                        </li>

                        <li> Create an account</li>
                        <li> Open your profile to get your user name.</li>
                    </ul>
                    <div>
            </td>
        </tr>
        </table>
        <button style="float:right;margin-right:40px;" class="button button-primary" id ="proceed" disabled >Proceed</button>

        
        <br><br><br><br>

        ');
?>
            <script>
            (function($){
              
                var delay = (function(){
                  var timer = 0;
                  return function(callback, ms){
                    clearTimeout (timer);
                    timer = setTimeout(callback, ms);
                  };
                })();

                var keyup_callback = function(){

                    $('#frankly_uname').val($('#frankly_uname').val().replace(/\s/g, ''));
                    var username = $('#frankly_uname').val();
                    var url = 'http://api.frankly.me/user/profile/' + username;
                    
                    if(username.length < 4){
                        $('#user-result').html('');
                        return;
                    }
                    
                    if(username.length >= 4){
                    
                        $('#user-result').html('<img src="'+ '<?php echo plugins_url( 'images/ajax-loader.gif' , __FILE__ );?>' +'" />');
                        /*
                        $.ajax({
                            method: 'POST',
                            url: 'http://api.frankly.me/user/exists',
                            data: {'username': username }
                            error: function()
                            {
                                $('#user-result').html('<img src="<?php echo plugins_url( 'images/not-available.png' , __FILE__ );?> + '" />');
                                $('#proceed').attr('disabled','disabled');
                            },
                            success: function()
                            {
                                $('#user-result').html('<img src="<?php echo plugins_url( 'images/available.png' , __FILE__ );?> + '" />'');
                                $('#proceed').removeAttr('disabled');

                            }
                        });
                        */
                        $.ajax({
                            method: 'GET',
                            url: url,
                            
                            error: function()
                            {
                                $('#user-result').html('<img src="' + '<?php echo plugins_url( 'images/not-available.png' , __FILE__ );?>' + '" />');
                                $('#proceed').attr('disabled','disabled');
                            },
                            success: function()
                            {
                                $('#user-result').html('<img src="' + '<?php echo plugins_url( 'images/available.png' , __FILE__ );?>' + '"  />');
                                $('#proceed').removeAttr('disabled');

                            }
                            /*
                            ,
                            statusCode: 
                            {
                                404: function() {
                                        console.log('a')            ;
                                    }
                            }*/

                        });
                        
                    }
                        
                };



                
                $('#frankly_uname').keyup( function(){
                    delay(  keyup_callback, 1000 );
                    });
                

                $('#proceed').click(function(){

                    var uname = $('#frankly_uname').val();

                    $.ajax({
                            method: 'POST',
                            url: ajaxurl,
                            data: {
                                    
                                    'action': 'my_action',
                                    'frankly_uname': uname,

                                 },
                            success: function(response)
                            {
                                window.location.assign('options-general.php?page=frankly');
                            }
                        });

                });


            })(jQuery);
            </script>

<?php

}

function print_widget_description()
{

    printf("</br>
            <h2>Frankly.me Side Pane widgets</h2></br>

            To use Frankly.me Ask Me side pane widgets, you can add them from the widgets menu in customize section of admin panel.</br>
            <br>If you don't know where it is, just head on to Admin Panel > Dashboard > Customize Your Site or click here <a href='customize.php'>Customize Page</a>.
            From here, click Widgets, then Add a Widget and then Frankly.me.<br>
            You will be required to chose among frankly.me ask button or frankly.me descriptive widget. More than one widget can also be added to your sidepane.</br>
            You need adminstrative permissions to customize your site this way.
            </br></br></br><br>");
    
}



function print_basic_description()
{
        $currentId = get_current_user_id(); 
        $currentUser = get_userdata($currentId);
        $currentLogin = $currentUser->user_login;
        $currentName = $currentUser->display_name;
        $currentFranklyId = get_user_meta ( $currentId, frankly, true );

?>

        <script type="text/javascript">

               function display(){
                    
                    
                    var currentId = <?php echo json_encode($currentId);?>;

                    var wpid;
                    <?php
                    if(current_user_can('manage_options'))
                    {
                        ?>

                        wpid = document.getElementById('user1').value;

                        <?php
                    }
                    else
                    {
                        ?>
                        
                        var u = <?php echo json_encode($currentFranklyId);?>;

                        if(u==null||u==''||u==' ')return;
                        wpid = currentId;

                        <?php
                    }
                    ?>
                    
                    var ty = document.getElementById('type1').value;
                    var f = document.getElementById('fl1').value;
                    var h = 280;
                    var w = 340;

                    if(wpid==null||wpid==''||wpid==' ')return;

                    if(ty=='Ask'||ty=='Small'||ty=='AskLg')
                        document.getElementById('code1').innerHTML = '[frankly' + ty + ' id="'+ wpid +'" style="'+ f +'"]';
                    else{
                        
                        if(ty=='Large1'){h=380;w=540;}
                        if(ty=='Large2'){h=480;w=640;}
                        if(ty=='Large3'){h=480;w=740;}
                        document.getElementById('code1').innerHTML= '[franklyLarge id="'+ wpid +'" style="'+ f +'" height="'+ h +'px" width="'+ w +'px" ]';
                    }
                }

        </script>

        </br>
        <h2>Frankly.me Embed widgets</h2></br>
        You can embed some widgets within you posts using our shortcodes.</br>
        To use Frankly.me Ask Me embed widgets,
        use our Frankly.me Embed widget Tag Generator:</br></br>
        
        <div>
        
            <form name="generator"  novalidate>
            <table class="form-table">

            <tr valign="top">
                <th>Frankly.me User Name</th>
                <td>
                <?php

                if(current_user_can('manage_options')){
                    
                    print('<select type="text" id="user1" onchange="display()">');
                    $users = get_users(unserialize(ARGS));
                    foreach ($users as $user)
                    {
                        
                        $x = get_user_meta ( $user->ID, frankly, true );

                        echo '<option value="' . $user->ID . '"> ' . $x  . ' ( for user having WP login id: '  .  $user->user_login . ' ) </option>';
                    }
                    

                    print('</select>');
                    print("</br></br>* Only those users are shown in the dropdown those who have registered their frankly.me user settings in Profile information.</br>");

                }
                else{

                    printf('<b>'. $currentFranklyId . ' ( for user having WP login id: '. $currentLogin .' ) </b>');

                }

                ?>
                </td>
            </tr>

            <tr valign="top"><th>Widget Type</th>
                <td>
                <select type="text" id="type1" onchange="display()">
                <option value='Ask' selected> Ask Button </option>
                <option value='AskLg' > Ask Button Large</option>
                <option value='Small'> Vertical Descriptive Widget </option>
                <option value='Large0'> Large Descriptive Widget (280x340) </option>
                <option value='Large1'> Large Descriptive Widget (380x540) </option>
                <option value='Large2'> Large Descriptive Widget (480x640) </option>
                <option value='Large3'> Large Descriptive Widget (480x740) </option>
                </select>
                </td>
            </tr>
            
            <tr valign="top"><th>Align</th>
                <td><select type="text" id="fl1" onchange="display()">
                <option value='float:left'> Left</option>
                <option value='float:right' selected> Right</option>
                </select></td>
            </tr>
            
            <tr valign="top">
                <th>Generated Shortcode&emsp;:</th>
                
                <td><b id="code1"></b>
                </td>


            </tr>
            </table>
            </form>
            <script type="text/javascript">display()</script>

            Copy and use this shortcode in your posts.
            </br></br></br>
             
        </div>
        <br>
<?php
    
}



function print_adv_description()
{
?>
        
        </br>
        <h2>Advanced Use of Shortcodes</h2></br>
        If you want to customize more, you can refer the following (fill up the values for items in '{ }'appropriately):
        </br>

        <ul>
        
            <li>For Frankly.me ask button use :&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
            [franklyAsk id="{}" style="float:{left/right}"]
            </li>

            <li>For Frankly.me Large ask button use :&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
            [franklyAskLg id="{}" style="float:{left/right}"]
            </li>


            <li>For Frankly.me descriptive widget use :&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
            [franklySmall id="{}" style="float:{left/right}"]
            </li>

            <li>For Frankly.me large descriptive widget use : &emsp;
            [franklyLarge id="{}" style="float:{left/right}" height="{}" width="{}"]
            </li>
            
        </ul>

        
            You can also use this versatile shortcode and vary the type field :<br> 
            [frankly type="{ask/ask_lg/sm/lg}" id="{}" style="float:{left/right}" height="{}" width="{}"]
            
        <br><br>

         Note: Except userid, all other attributes of shortcode are optional. The id attribute denotes numeric id of user's site login. The widget by default floats towards right. For franlyLarge  widget, default height is 480px and default width is 640px.
         You should not include '{' and '}' and you need to use one among left or right in float attribute of style and you can provide other styling options in style too.

        </br></br></br><br>
<?php 
    
}


?>
