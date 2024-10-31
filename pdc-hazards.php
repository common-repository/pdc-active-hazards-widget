<?php

  /*
  Plugin Name: PDC Active Hazards Widget
  Plugin URI: http://www.festerhead.com/pdc-hazards-widget
  Description: A widget that display PDC Active Hazards
  Version: 0.3
  Author: Steve Kunitzer (FesterHead)
  Author URI: http://www.festerhead.com
  */

/********************************************************
 *
 * Copyright (C) Steve Kunitzer (FesterHead)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 ********************************************************/

/**
 * Add function to widgets_init to load the widget.
 */
add_action( 'widgets_init', 'pdc_hazards_load_widgets' );
wp_enqueue_style( 'pdchazards-css', plugins_url( '/style.css', __FILE__ ) );

/**
 * Register the widget.
 */
function pdc_hazards_load_widgets() {
  register_widget( 'PDC_Hazards_Widget' );
}

/**
 * PDC Hazards Widget class.
 * This class handles everything that needs to be handled with the widget.
 */
class PDC_Hazards_Widget extends WP_Widget {

  /**
   * Widget setup.
   */
  function PDC_Hazards_Widget() {
    /* Widget settings. */
    $widget_ops = array( 'classname' => 'pdchazards', 'description' => __('PDC Active Hazards widget.', 'pdchazards') );

    /* Widget control settings. */
    $control_ops = array( 'id_base' => 'pdc-hazards-widget' );

    /* Create the widget. */
    $this->WP_Widget( 'pdc-hazards-widget', __('PDC Hazards Widget', 'pdchazards'), $widget_ops, $control_ops );
  }

  /**
   * Display the widget on the screen.
   */
  function widget( $args, $instance ) {
    extract( $args );

    /* Our variables from the widget settings. */
    $title = apply_filters('widget_title', $instance['title'] );
    $hazard_limit = $instance['hazards_count'];

    /* Before widget (defined by themes). */
    echo $before_widget;

    /* Display the widget title if one was input (before and after defined by themes). */
    if ( $title ) echo $before_title . $title . $after_title;

    $hazards = simplexml_load_file("http://hpxml.pdc.org/public.xml");
    ?>
    <table border="0">
    <?php
    $counter = 0;
    foreach( $hazards as $hazard ) {
      $counter++;
      if ( ( $hazard_limit != 'all' ) && ( $counter > $hazard_limit ) ) break;

      if ($counter > 1)
      {
      ?>
        <tr class="postContent"><td colspan="2">&nbsp;</td></tr>
      <?php
      }
    ?>
      <tr valign="top" class="postContent">
        <td class="PDC_<?php echo( $hazard->severity_ID ); ?>">
          <?php
            switch ( $hazard->type_ID ) {
              case "DROUGHT":
                ?><img src='http://www.pdc.org/images/map_icons/drought.png' border='0' alt='Drought' title='Drought'/><?php
                break;
              case "EARTHQUAKE":
                ?><img src='http://www.pdc.org/images/map_icons/earthquake.png' border='0' alt='Earthquake' title='Earthquake'/><?php
                break;
              case "FLOOD":
                ?><img src='http://www.pdc.org/images/map_icons/flood.png' border='0' alt='Flood' title='Flood'/><?php
                break;
              case "HIGHSURF":
                ?><img src='http://www.pdc.org/images/map_icons/high_surf.png' border='0' alt='High Surf' title='High Surf'/><?php
                break;
              case "HIGHWIND":
                ?><img src='http://www.pdc.org/images/map_icons/high_wind.png' border='0' alt='High Wind' title='High Wind'/><?php
                break;
              case "MANMADE":
                ?><img src='http://www.pdc.org/images/map_icons/man_made.png' border='0' alt='Man Made' title='Man Made'/><?php
                break;
              case "STORM":
                ?><img src='http://www.pdc.org/images/map_icons/storm.png' border='0' alt='Storm' title='Storm'/><?php
                break;
              case "CYCLONE":
                ?><img src='http://www.pdc.org/images/map_icons/tropical_cyclone.png' border='0' alt='Tropical Cyclone' title='Tropical Cyclone'/><?php
                break;
              case "TSUNAMI":
                ?><img src='http://www.pdc.org/images/map_icons/tsunami.png' border='0' alt='Tsunami' title='Tsunami'/><?php
                break;
              case "VOLCANO":
                ?><img src='http://www.pdc.org/images/map_icons/volcano_eruption.png' border='0' alt='Volcano Eruption' title='Volcano Eruption'/><?php
                break;
              case "WILDFIRE":
                ?><img src='http://www.pdc.org/images/map_icons/wildfire.png' border='0' alt='Wildfire' title='Wildfire'/><?php
                break;
              case "MARINE":
                ?><img src='http://www.pdc.org/images/map_icons/marine.png' border='0' alt='Marine' title='Marine'/><?php
                break;
              case "UNIT":
                ?><img src='http://www.pdc.org/images/map_icons/unit.png' border='0' alt='Unit' title='Unit'/><?php
                break;
              case "INCIDENT":
                ?><img src='http://www.pdc.org/images/map_icons/incident.png' border='0' alt='Incident' title='Incident'/><?php
                break;
              case "EQUIPMENT":
                ?><img src='http://www.pdc.org/images/map_icons/equipment.png' border='0' alt='Equipment' title='Equipment'/><?php
                break;
            }
          ?>
          <br/>
          <?php
            switch ( $hazard->severity_ID ) {
              case "TERMINATION":
                ?><img src='http://www.pdc.org/images/map_icons/termination.png' border='0' alt='Termination' title='Termination'/><?php
                break;
              case "INFORMATION":
                ?><img src='http://www.pdc.org/images/map_icons/information.png' border='0' alt='Information' title='Information'/><?php
                break;
              case "ADVISORY":
                ?><img src='http://www.pdc.org/images/map_icons/advisory.png' border='0' alt='Advisory' title='Advisory'/><?php
                break;
              case "WATCH":
                ?><img src='http://www.pdc.org/images/map_icons/watch.png' border='0' alt='Watch' title='Watch'/><?php
                break;
              case "WARNING":
                ?><img src='http://www.pdc.org/images/map_icons/warning.png' border='0' alt='Warning' title='Warning'/><?php
                break;
            }
          ?>
        </td>
        <td class="PDC_<?php echo( $hazard->severity_ID ); ?>">
          <a target="_blank" href="<?php echo $hazard->snc_url; ?>"><?php echo $hazard->hazard_Name; ?></a>
          <br/>
          <?php echo ( ucfirst( strtolower( $hazard->type_ID ) ) ); ?> - <?php echo ( ucfirst( strtolower( $hazard->severity_ID ) ) ); ?>
        </td>
      </tr>
      <tr class="postContent">
        <td class="PDC_<?php echo( $hazard->severity_ID ); ?>" colspan="2">
          <b>Reported:</b>
          <br/>
          <?php echo date('D, d M Y H:i:s e', strtotime( $hazard->create_Date_hst ) ); ?>
          <br/>
          <?php echo pdc_haz_ago( strtotime( $hazard->create_Date_hst ) ); ?>
        </td>
      </tr>
      <tr class="postContent">
        <td class="PDC_<?php echo( $hazard->severity_ID ); ?>" colspan="2">
          <b>Updated:</b>
          <br/>
          <?php echo date('D, d M Y H:i:s e', strtotime( $hazard->last_Update_hst ) ); ?>
          <br/>
          <?php echo pdc_haz_ago( strtotime( $hazard->last_Update_hst ) ); ?>
        </td>
      </tr>
    <?php
    }
    ?>
    </table>
    <br/>
    <?php

    /* After widget (defined by themes). */
    echo $after_widget;
  }

  /**
   * Update the widget settings.
   */
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['hazards_count'] = $new_instance['hazards_count'];
    return $instance;
  }

  /**
   * Displays the widget settings controls on the widget panel.
   */
  function form( $instance ) {

    /* Set up some default widget settings. */
    $defaults = array( 'title' => __('PDC Active Hazards', 'pdc-hazards'), 'hazards_count' => __('5', 'pdc-hazards-count') );
    $instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
      <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
    </p>

    <!-- Hazard Count: Select Box -->
    <p>
      <label for="<?php echo $this->get_field_id( 'hazards_count' ); ?>"><?php _e('# Hazards to show:', 'pdc-hazards-count'); ?></label>
      <select id="<?php echo $this->get_field_id( 'hazards_count' ); ?>" name="<?php echo $this->get_field_name( 'hazards_count' ); ?>" class="widefat" style="width:100%;">
        <option <?php if ( '1' == $instance['hazards_count'] ) echo 'selected="selected"'; ?>>1</option>
        <option <?php if ( '3' == $instance['hazards_count'] ) echo 'selected="selected"'; ?>>3</option>
        <option <?php if ( '5' == $instance['hazards_count'] ) echo 'selected="selected"'; ?>>5</option>
        <option <?php if ( '10' == $instance['hazards_count'] ) echo 'selected="selected"'; ?>>10</option>
        <option <?php if ( 'all' == $instance['hazards_count'] ) echo 'selected="selected"'; ?>>all</option>
      </select>
    </p>

  <?php
  }
}

function pdc_haz_ago( $time ) {
 $periods = array( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
 $lengths = array( "60","60","24","7","4.35","12","10" );

 $now = time();

 $difference = $now - $time;
 $tense      = "ago";

 for( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths )-1; $j++ ) {
   $difference /= $lengths[$j];
 }

 $difference = round( $difference );

 if( $difference != 1 ) {
     $periods[$j].= "s";
 }

 return "$difference $periods[$j] $tense ";
}

?>
