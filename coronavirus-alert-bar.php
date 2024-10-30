<?php
/*
    Plugin Name: Coronavirus Alert Bar
    Description: Coronavirus Alert Bar Plugin
    Version: 1.0.4
    Author: Ryan Bracey
    Author URI: https://www.ryanbracey.com/
*/


defined( 'WPINC' ) || die;

add_action( 'wp_enqueue_scripts', 'mbcvab_enqueue_public_assets', 100 );
function mbcvab_enqueue_public_assets() {
    wp_enqueue_style( 'mbcvab-style-css', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_style( 'mbcvab-fontawesome-css', plugins_url( 'css/all.css', __FILE__ ) );

    wp_enqueue_script( 'jquery' );
}

// Add customizer section
add_action( 'customize_register', 'mbcvab_add_section' );
function mbcvab_add_section( $wp_customize ) {
    
    $wp_customize->add_section( 'mbcvab_section' , array(
            'title'             => 'Coronavirus Alert Bar',
            'priority'          => 30,
        ) 
    );
    
    $wp_customize->add_setting( 'icon' , array(
            'default'     => false,
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'background' , array(
            'default'     => '#F8F0CE',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'border' , array(
            'default'     => '#DEB408',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'text_color' , array(
            'default'     => '#444',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'link_color' , array(
            'default'     => '#CD2653',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'title' , array(
            'default'     => 'COVID-19 Resource Center',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'message' , array(
            'default'     => 'As new information continues to emerge on COVID-19, we will be keeping you up to date on our business operations.',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'cta' , array(
            'default'     => 'Learn More',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_setting( 'cta_link' , array(
            'default'     => '',
            'transport'   => 'refresh',
        ) 
    ); 

    $wp_customize->add_setting( 'cta_target_blank' , array(
            'default'           =>  false,
            'transport'         =>  'refresh',
        ) 
    ); 

    $wp_customize->add_setting( 'alert_display' , array(
            'default'     => 'Hide',
            'transport'   => 'refresh',
        ) 
    );

    $wp_customize->add_control( 'icon', array(
            'label'         => 'Corona Virus Icon',
            'description'   => 'Add a corona vrius icon',
            'section'       => 'mbcvab_section',
            'settings'      => 'icon',
            'type'          => 'checkbox',
        )
    );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background', array(
            'label'         => 'Background Color',
            'description'   => 'Set the background color of the alert',
            'section'       => 'mbcvab_section',
            'settings'      => 'background',
        )
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'border', array(
            'label'         => 'Border Color',
            'description'   => 'Set the bottom border color of the alert',
            'section'       => 'mbcvab_section',
            'settings'      => 'border',
        )
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
            'label'         => 'Text Color',
            'description'   => 'Set the text color of the alert',
            'section'       => 'mbcvab_section',
            'settings'      => 'text_color',
        )
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
            'label'         => 'Link Color',
            'description'   => 'Set the link color of the alert',
            'section'       => 'mbcvab_section',
            'settings'      => 'link_color',
        )
    ) );

    $wp_customize->add_control( 'title', array(
            'label'         => 'Title',
            'description'   => 'Add an alert title',
            'section'       => 'mbcvab_section',
            'settings'      => 'title',
            'type'          => 'text',
        )
    );

    $wp_customize->add_control( 'message', array(
            'label'         => 'Message',
            'description'   => 'Add an alert message',
            'section'       => 'mbcvab_section',
            'settings'      => 'message',
            'type'          => 'textarea',
        )
    );

    $wp_customize->add_control( 'cta', array(
            'label'         => 'Call to Action',
            'description'   => 'Add an alert call to action',
            'section'       => 'mbcvab_section',
            'settings'      => 'cta',
            'type'          => 'text',
        )
    );

    $wp_customize->add_control( 'cta_link', array(
            'label'         => 'Call to Action Link',
            'description'   => 'Add an link to the call to action',
            'section'       => 'mbcvab_section',
            'settings'      => 'cta_link',
            'type'          => 'text',
        )
    );

    $wp_customize->add_control( 'cta_target_blank', array(
            'label'             => 'Open Link in New Tab',
            'section'           => 'mbcvab_section',
            'settings'          => 'cta_target_blank',
            'type'              => 'checkbox',
        )
    );

    $wp_customize->add_control( 'alert_display', array(
            'label'         => 'Display Options',
            'description'   => 'Chose whether to display alert across the entire site, on just the home page or not at all',
            'section'       => 'mbcvab_section',
            'settings'      => 'alert_display',
            'type'          => 'radio',
            'choices'       => array(
                'hide'      => 'Hide',
                'full-site' => 'Full Site',
                'home-page' => 'Home Page',
            ),
        )
    );

}

// Add settings link
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mbcvab_add_action_links' );
function mbcvab_add_action_links ( $links ) {
    $mylinks = array(
        '<a href="' . admin_url( '/customize.php?autofocus[section]=mbcvab_section' ) . '">Settings</a>',
    );
    return array_merge( $links, $mylinks );
}

// Hook alert bar
add_action( 'wp_head', 'mbcvab', 99 );
function mbcvab() {

    if ( ( get_theme_mod( 'alert_display', 'home-page' ) == 'home-page' ) && is_front_page() ) {
        add_action( 'wp_footer', 'mbcvab_closer_script' );
        ?>
            <div class="cv-alert-bar">
                <div class="wrap<?php if ( true === get_theme_mod( 'icon' ) ) { echo ' cv-alert-icon'; }?>">
                    <?php if ( true === get_theme_mod( 'icon' ) ) { ?>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/corona-virus.svg'; ?>" width="110" height="71" alt="coronavirus">
                    <?php } ?>   
                    <p class="cv-alert-message">
                        <?php if ( get_theme_mod( 'title' ) ) { ?>
                            <span class="cv-alert-title"><?php echo get_theme_mod( 'title' ); ?></span>:
                        <?php } ?>
                        <?php if ( get_theme_mod( 'message' ) ) { ?>
                            <?php echo get_theme_mod( 'message' ); ?> 
                        <?php } ?>  
                        <?php if ( get_theme_mod( 'cta' ) ) { ?>
                            - <a href="<?php echo get_theme_mod( 'cta_link' ); ?>" class="cv-alert-title"<?php if ( true === get_theme_mod( 'cta_target_blank' ) ) { echo ' target="_blank"'; }?>><?php echo get_theme_mod( 'cta' ); ?></a>
                        <?php } ?> 
                    </p>
                    <div class="cv-alert-closer"><i class="fas fa-times"></i></div>
                </div>
            </div>
        <?php
    } else if ( get_theme_mod( 'alert_display', 'full-site' ) == 'full-site' ) {
        add_action( 'wp_footer', 'mbcvab_closer_script' );
        ?>
            <div class="cv-alert-bar">
                <div class="wrap<?php if ( true === get_theme_mod( 'icon' ) ) { echo ' cv-alert-icon'; }?>">
                    <?php if ( true === get_theme_mod( 'icon' ) ) { ?>
                        <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/corona-virus.svg'; ?>" width="110" height="71" alt="coronavirus">
                    <?php } ?>  
                    <p class="cv-alert-message">
                        <?php if ( get_theme_mod( 'title' ) ) { ?>
                            <span class="cv-alert-title"><?php echo get_theme_mod( 'title' ); ?></span>:
                        <?php } ?>
                        <?php if ( get_theme_mod( 'message' ) ) { ?>
                            <?php echo get_theme_mod( 'message' ); ?> 
                        <?php } ?>  
                        <?php if ( get_theme_mod( 'cta' ) ) { ?>
                            - <a href="<?php echo get_theme_mod( 'cta_link' ); ?>" class="cv-alert-title"<?php if ( true === get_theme_mod( 'cta_target_blank' ) ) { echo ' target="_blank"'; }?>><?php echo get_theme_mod( 'cta' ); ?></a>
                        <?php } ?> 
                    </p>
                    <div class="cv-alert-closer"><i class="fas fa-times"></i></div>
                </div>
            </div>
        <?php
    } else {

    }
}

// Add alert script
function mbcvab_closer_script() {
    ?>
    <script>
        jQuery( document ).ready( function() {

            jQuery( 'body' ).addClass( 'cv-alert-bar-active' );

            // Collapse search on click
            jQuery( '.cv-alert-closer' ).click( function() {
                jQuery( '.cv-alert-bar' ).slideUp();
                jQuery( 'body' ).removeClass( 'cv-alert-bar-active' );
            });

        });
    </script>
    <?php
}

// Set alert bar background color
add_action( 'wp_head', 'mbcvab_index_css_styles' );
function mbcvab_index_css_styles() {
    ?>
        <style type="text/css">
            .cv-alert-bar {
                background: <?php echo get_theme_mod( 'background', '#F8F0CE' ); ?>;
                border-bottom: 1px solid <?php echo get_theme_mod( 'border', '#DEB408' ); ?>;
                color: <?php echo get_theme_mod( 'text_color', '#444' ); ?>;
            }

            .cv-alert-bar a {
                color: <?php echo get_theme_mod( 'link_color', '#CD2653' ); ?>;;
            }
        </style>
    <?php
}