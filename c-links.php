<?php
/*
Plugin Name: _ANDYP - WPBakery component : C-Links
Plugin URI: http://londonparkour.com
Description: LondonParkour Custom Visual Composer Component - Link
Version: 1.0
Author: Andy Pearson
Author URI: http://londonparkour.com
*/

// ┌─────────────────────────────────────┐ 
// │                                     │░
// │                                     │░
// │         LondonParkour C-Link        │░
// │                                     │░
// │                                     │░
// └─────────────────────────────────────┘░
//  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

// Example from https://bitbucket.org/wpbakery/extend-wpbakery-page-builder-plugin-example/src/master/assets/

// don't load directly
if (!defined('ABSPATH')) die('-1');


//  ┌──────────────────────────────────────┐
//  │            C-Panel Class             │
//  └──────────────────────────────────────┘
class VC_C_Link {

    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'clink', array( $this, 'renderShortcode' ) );

        // Register CSS and JS INTO FOOTER! (To stop render-blocking)
        add_action( 'get_footer', array( $this, 'loadCssAndJs' ) );
    }
 



    public function integrateWithVC() {

        // Check if WPBakery Page Builder is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Extend WPBakery Page Builder is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

		//  ┌──────────────────────────────────────┐
		//  │         Create the VC Inputs         │
		//  └──────────────────────────────────────┘
        vc_map( array(
            "name" => __("C-Link", 'vc_extend'),
            "description" => __("Component - Link", 'vc_extend'),
            "base" => "clink",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/ldnpk.png', __FILE__), // or css class name which you can refer in your css file later. Example: "vc_extend_my_class"
            "category" => __('LondonParkour', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

				//  ┌──────────────────────────────────────┐
				//  │                                      │
				//  │        GENERAL PANEL SETTINGS        │
				//  │                                      │
				//  └──────────────────────────────────────┘
                    
                    //  ┌──────────────────────────────────────┐
					//  │              Unique ID               │
					//  └──────────────────────────────────────┘
					array(
						"type" => "textfield",
						"holder" => "div",		// used to display on edit page.
						"heading" => __("Unique Class Name (required!)", 'vc_extend'),
						"param_name" => "unique_class",
						"value" => __("", 'vc_extend'),
						"description" => __("This is a unique class nane for CSS to target this link.", 'vc_extend')
					),

                    //  ┌──────────────────────────────────────┐
					//  │                 Link                 │
					//  └──────────────────────────────────────┘
					array(
                        "type" => "vc_link",
						"heading" => __("Link underneath", 'vc_extend'),
						"param_name" => "link_url",
						"value" => __("", 'vc_extend'),
                        "description" => __("Link URL", 'vc_extend'),
                    ),

                    //  ┌──────────────────────────────────────┐
					//  │             Text Colour              │
					//  └──────────────────────────────────────┘
					array(
						"type" => "colorpicker",
						"heading" => __("Text colour", 'vc_extend'),
						"param_name" => "text_colour",
						"value" => '', 
						"description" => __("Choose Text color", 'vc_extend'),
						"edit_field_class" => __("vc_col-xs-4"),
                    ),

                    //  ┌──────────────────────────────────────┐
					//  │             Icon Colour              │
					//  └──────────────────────────────────────┘
					array(
						"type" => "colorpicker",
						"heading" => __("Icon color", 'vc_extend'),
						"param_name" => "icon_colour",
						"value" => '', 
						"description" => __("Choose Icon color", 'vc_extend'),
						"edit_field_class" => __("vc_col-xs-4"),
                    ),
                    

                    //  ┌──────────────────────────────────────┐
					//  │             Disable Icon             │
					//  └──────────────────────────────────────┘
					array(
						"type" => "checkbox",
						"heading" => __("Text Underlined?", 'vc_extend'),
						"param_name" => "text_underline",
						"value" => __("", 'vc_extend'),
						"description" => __("This will render an underline on the link text.", 'vc_extend'),
						"edit_field_class" => __("vc_col-xs-4"),
					),
                    
                    //  ┌──────────────────────────────────────┐
					//  │                Icon                  │
					//  └──────────────────────────────────────┘
					array(
						"type" => "textfield",
						"heading" => __("Material Icon", 'vc_extend'),
						"param_name" => "icon_unicode",
						"value" => __("", 'vc_extend'),
						"description" => __("Material icon unicode - see <a href=\"https://github.com/google/material-design-icons/blob/master/iconfont/codepoints\">Material Icons</a> chevron_right = e5cc, help = e8fd", 'vc_extend'),	
                        "edit_field_class" => __("vc_col-xs-4"),
                    ),

                    //  ┌──────────────────────────────────────┐
					//  │            Hover Colour              │
					//  └──────────────────────────────────────┘
					array(
						"type" => "colorpicker",
						"heading" => __("Text Hover colour", 'vc_extend'),
						"param_name" => "text_hover_colour",
						"value" => '', 
						"description" => __("Choose Text color", 'vc_extend'),
						"edit_field_class" => __("vc_col-xs-4"),
                    ),
                    
                    //  ┌──────────────────────────────────────┐
					//  │          Icon HoverColour            │
					//  └──────────────────────────────────────┘
					array(
						"type" => "colorpicker",
						"heading" => __("Icon Hover color", 'vc_extend'),
						"param_name" => "icon_hover_colour",
						"value" => '', 
						"description" => __("Choose Icon Hover color", 'vc_extend'),
						"edit_field_class" => __("vc_col-xs-4"),
                    ),
                    
                    //  ┌──────────────────────────────────────┐
					//  │               Spacing                │
					//  └──────────────────────────────────────┘
					array(
						"type" => "textfield",
						"heading" => __("Spacing between text and icon", 'vc_extend'),
						"param_name" => "text_icon_padding",
						"value" => __("", 'vc_extend'),
                        "description" => __("This is to give the icon a little whitespace if needed. (include measurement: px / % / em )", 'vc_extend'),
                        "edit_field_class" => __("vc_col-xs-4"),
                    ),
                    
                    //  ┌──────────────────────────────────────┐
					//  │             Make a block             │
					//  └──────────────────────────────────────┘
					array(
						"type" => "checkbox",
						"heading" => __("Make a block?", 'vc_extend'),
						"param_name" => "link_as_block",
                        "value" => array(
                            "" => "true"
                        ),
						"description" => __("Make the link a display:block; element", 'vc_extend'),
						"edit_field_class" => __("vc_col-xs-4"),
                    ),

                    //  ┌──────────────────────────────────────┐
					//  │              text align              │
					//  └──────────────────────────────────────┘
					array(
						"type" => "dropdown",
						"heading" => __("Text Alignment", 'vc_extend'),
						"param_name" => "text_alignment",
						'value'       => array(
                            'Left'    => 'left',
                            'Center'  => 'center',
                            'Right'   => 'right'
                          ),
                        'std'         => 'left', // Your default value
						"description" => __("Make the link a display:block; element", 'vc_extend'),
                        "edit_field_class" => __("vc_col-xs-4"),
                        'dependency'    => array(
                            'element'   => 'link_as_block',
                            'value'     => "true"
                        )
					),

                //  ┌──────────────────────────────────────┐
				//  │                                      │
				//  │              CSS Design              │
				//  │                                      │
				//  └──────────────────────────────────────┘	
                    array(
                        'type' => 'css_editor',
                        'heading' => __( 'Css', 'my-text-domain' ),
                        'param_name' => 'css',
                        'group' => __( 'CSS', 'my-text-domain' ),
                    ),
             
            )
        ) );
    }
	
	


    /*
    Shortcode logic how it should be rendered
    */
    public function renderShortcode( $atts, $content = null ) {

		//  ┌──────────────────────────────────────┐
		//  │         Shortcode parameters         │
		//  └──────────────────────────────────────┘
		extract(
			shortcode_atts(
				array(
                    // General
                    'unique_class' => '',
					'link_url' => '',
					'text_colour' => '',
					'text_hover_colour' => '',
					'text_underline' => '',
					'text_icon_padding' => '',
					'icon_unicode' => 'e5cc',
					'icon_colour' => '',
					'icon_hover_colour' => '',
					'link_as_block' => '',
                    'text_alignment' => '',
                    
                    // Design
					'css' => '',
				),
				$atts
			)
        );

        // Used for the CSS Design Tab that comes with WPBakery.
        //$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'clink', $atts );
        
        // Use the link builder element to create the URL link.
        $href = vc_build_link( $link_url, true );
        $unique_class = 'c-link__'. $unique_class;

        if ($href['url'] != "") { 
            $link = '<a class="c-link '.$unique_class .' '. esc_attr( $css_class ).' " href=" '.$href['url'].' " title="'.$href['title'].'" target="'.$href['target'].'" rel="'.$href['rel'].'"><span>'.$href['title'].'</span></a>';
        } 
            
		//  ┌──────────────────────────────────────┐
		//  │         Start Output Buffer          │
		//  └──────────────────────────────────────┘
		ob_start(); 
        ?>
            <style>

                /*
                    colour
                */
                <?php echo '.'.$unique_class; ?>, 
                <?php echo '.'.$unique_class; ?>:visited {
                    color: <?php echo $text_colour; ?>;
                    <?php if ($link_as_block != '') { ?> display:block;  <?php } ?>;
                    text-align: <?php echo $text_alignment; ?>;
                }

                <?php echo '.'.$unique_class; ?>:hover {
                    color: <?php echo $text_hover_colour; ?>;
                }

                /*
                    icon
                */
                <?php echo '.'.$unique_class; ?>:after {
                    color: <?php echo $icon_colour; ?>;
                    content: '<?php echo '\\'.$icon_unicode; ?>';
                    padding-left: <?php echo $text_icon_padding; ?>;
                }

                <?php echo '.'.$unique_class; ?>:hover:after {
                    color: <?php echo $icon_hover_colour; ?>;
                }

                    /*
                        border bottom underline
                    */
                    <?php echo '.'.$unique_class; ?> span {
                        border-bottom-color: <?php echo $text_colour; ?>;
                        
                        <?php if ($text_underline != '') { ?> border-bottom: 1px solid;  <?php } ?>
                        
                    }

                    <?php echo '.'.$unique_class; ?>:hover span {
                        border-bottom-color: <?php echo $text_hover_colour; ?>;
                    }
                
            </style>

            <?php echo $link; ?>	
		<?php

		return ob_get_clean();

    }





    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      wp_register_style( 'vc_extend_style_link', plugins_url('assets/vc_c-links.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style_link' );
    }





    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
	}
	


}
// Finally initialize code
new VC_C_Link();