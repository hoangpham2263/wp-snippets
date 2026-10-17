<?php 
// ========== Add field Mobile Logo ==========
function custom_theme_customize_register($wp_customize)
{
  $wp_customize->add_setting('mobile_logo'); 

  $wp_customize->add_control(new WP_Customize_Image_Control(
    $wp_customize,
    'mobile_logo',
    array(
      'label'      => __('Mobile Logo', 'your-textdomain'),
      'section'    => 'title_tagline',
      'settings'   => 'mobile_logo',
      'priority'   => 8,
    )
  ));
}
add_action('customize_register', 'custom_theme_customize_register');
?>