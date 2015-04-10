<?php

add_action('admin_menu','wp_plugin_frankly_menu');

function wp_plugin_frankly_menu(){
    add_options_page('Ask Frankly, Configuration','Frankly.me','publish_posts','frankly','wp_plugin_frankly_options');
}


function wp_plugin_frankly_options(){
        $currentId = get_current_user_id(); 
        $currentUser = get_userdata($currentId);

        $currentLogin = $currentUser->user_login;
        $currentName = $currentUser->display_name;
        $currentFranklyId = get_user_meta ( $currentId, frankly, true );    
    ?>


    <script>

       function display(){

            var wpid = document.getElementById('user1').value;
            var ty = document.getElementById('type1').value;
            var f = document.getElementById('fl1').value;
            var h = 280;
            var w = 340;

            if(wpid==null||wpid==''||wpid==' ')return;

            if(ty=='Ask'||ty=='Small'||ty=='AskLg')
                document.getElementById('code1').innerHTML = '[frankly' + ty + ' wpid="'+ wpid +'" style="'+ f +'"]';
            else{
                
                if(ty=='Large1'){h=380;w=540;}
                if(ty=='Large2'){h=480;w=640;}
                if(ty=='Large3'){h=480;w=740;}
                document.getElementById('code1').innerHTML= '[franklyLarge wpid="'+ wpid +'" style="'+ f +'" height="'+ h +'px" width="'+ w +'px" ]';
            }
        }

        function display_single(){

            var u = <?php echo json_encode($currentFranklyId);?>;
            var currentId = <?php echo json_encode($currentId);?>;
            var ty = document.getElementById('type2').value;
            var f = document.getElementById('fl2').value;
            var h = 280;
            var w = 340;
            
            if(u==null||u==''||u==' ')return;

            if(ty=='Ask'||ty=='Small'||ty=='AskLg')
                document.getElementById('code2').innerHTML = '[frankly' + ty + ' wpid="'+ currentId +'" style="'+ f +'"]';
            else{
                
                if(ty=='Large1'){h=380;w=540;}
                if(ty=='Large2'){h=480;w=640;}
                if(ty=='Large3'){h=480;w=740;}
                document.getElementById('code2').innerHTML= '[franklyLarge wpid="'+ currentId +'" style="'+ f +'" height="'+ h +'px" width="'+ w +'px" ]';
            }
        }

    </script>

    <div class="wrap">

        <h2>Ask Frankly, Configuration</h2></br></br>

        You can add our widgets to wordpress's sidepane or embed them within your post.</br>
        
        
        </br>
        <b>Frankly.me Side Pane widgets</b></br>

        To use Frankly.me Ask Me side pane widgets, you can add them from the widgets menu in customize section of admin panel.</br>
        You will be required to chose among frankly.me ask button or frankly.me descriptive widget. More than one widget can also be added to your sidepane.</br>
        You need adminstrative permissions to add side pane widgets.
        </br></br>
        
        <b>Frankly.me Embed widgets</b></br>

        You can embed some widgets within you posts using our shortcodes.</br>
        To use Frankly.me Ask Me embed widgets,
        use our Frankly.me Embed widget Tag Generator:</br></br>
        
    
        
       

        <?php 
    
            
            $args = array(
                'meta_key'     => 'frankly',
                'meta_value'   => undefined,
                'meta_compare' => '!=',
                'orderby'      => 'login',
                'order'        => 'ASC',
                'fields'       => 'all',
            ); 
            


            if( current_user_can('manage_options') ){ 
                
                $users = get_users($args); 

                if(count($users)>0){
                    ?>
                        
                        <div>
                        </br>
                            * Only those users are shown in the dropdown those who have registered their frankly.me user settings in Profile information.
                        </br>
                            <form name="generator"  novalidate>
                            <table class="form-table">

                            <tr valign="top">
                                <th>Frankly.me User Name</th>
                                <td>
                                

                                <select type="text" id="user1" onchange="display()">
                                <?php
                                foreach ($users as $user) {
                                    
                                    $x = get_user_meta ( $user->ID, frankly, true );

                                    echo '<option value="' . $user->ID . '"> ' . $x  . ' ( for user having WP login id: '  .  $user->user_login . ' ) </option>';
                                }
                                ?>

                                </select>
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
                            
                            <tr valign="top"><th>Floating towards</th>
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
                    
                    
                        </br></br>
                        If you want to customize more, you can refer the following (fill up the values for items in '{ }'appropriately):
                        </br>

                        <ul>
                        
                            <li>For Frankly.me ask button use :&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
                            [franklyAsk wpid="{}" style="float:{left/right}"]
                            </li>

                            <li>For Frankly.me Large ask button use :&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;
                            [franklyAskLg wpid="{}" style="float:{left/right}"]
                            </li>


                            <li>For Frankly.me descriptive widget use :&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;
                            [franklySmall wpid="{}" style="float:{left/right}"]
                            </li>

                            <li>For Frankly.me large descriptive widget use : &emsp;
                            [franklyLarge wpid="{}" style="float:{left/right}" height="{}" width="{}"]
                            </li>

                        </ul>
                         Note: Except userid, all other attributes of shortcode are optional. The widget by default floats towards right. For franlyLarge  widget, default height is 480px and default width is 640px.
                         You should not include '{' and '}' and you need to use one among left or right in float attribute of style and you can provide other styling options in style too.


                    <?php 
                    }
                    else{
                        ?>
                            </br>
                            <b style="color:red"> To use our widgets, you first need to add frankly.me profile information of required user in his Wordpress User settings. If you don't know where it is, just head on to Admin Panel>Users, select the required user and then scroll to the bottom and fill out his Frankly.me Profile Information.</b>
                            </br>

                        <?php

                    }




                }

                else if(current_user_can('publish_posts')){
                    
                    
                    if($currentFranklyId != NULL){
                    ?>
                            <div>
                                <form name="generator"  novalidate>
                                <table class="form-table">

                                <tr valign="top">
                                    <th>Frankly.me User Name</th>
                                    <td>
                                        

                                    <b id="user2"><?php echo $currentFranklyId . ' ( for user having WP login id: '. $currentLogin .' )'; ?></b>

                                    
                                    </td>
                                </tr>

                                <tr valign="top"><th>Widget Type</th>
                                    <td>
                                    <select type="text" id="type2" onchange="display_single()">
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
                                
                                <tr valign="top"><th>Floating towards</th>
                                    <td><select type="text" id="fl2" onchange="display_single()">
                                    <option value='float:left'> Left</option>
                                    <option value='float:right' selected> Right</option>
                                    </select></td>
                                </tr>
                                
                                <tr valign="top">
                                    <th>Generated Shortcode&emsp;:</th>
                                    
                                    <td><b id="code2"></b>
                                    </td>


                                </tr>
                                </table>
                                </form>
                                <script type="text/javascript">display_single()</script>

                                Copy and use this shortcode in your posts.
                                </br></br></br>
                                 
                            </div>
                    <?php
                           
                    }

                    else{
                        ?>
                    

                    </br>
                    <b style="color:red"> To use our widgets, you first need to add frankly.me profile information of required user in his Wordpress User settings. If you don't know where it is, just head on to Admin Panel>Users, select the required user and then scroll to the bottom and fill out his Frankly.me Profile Information.</b>
                    </br>
                    <?php

                    }

                }



        if( current_user_can('manage_options')){ 
            ?>


        <?php 
        }
        ?>                     

    </div>  

<?php
}
?>