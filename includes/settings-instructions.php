<div class="wcts-right-col">
    <div class="ebxwcts-row">
        <div class="ebxwcts-col">
            <img class="ebxwcts-logo" src="<?php echo plugins_url('admin/img/time-slots-logo.png', dirname(__FILE__) ); ?>" alt="Time Slots Logo">
        </div>
        <?php
        if( ! function_exists('ebxwcts_instructions_cta') ) {
            function ebxwcts_instructions_cta() {
                $html = '<div class="ebxwcts-col">';
                $html .= '<h2 class="ebxwcts-h2">Pro Version</h2>';
                $html .= '<h3 class="ebxwcts-h3">Only $39/year</h3>';
                $html .= '<a href="https://gettimeslots.com" class="ebxwcts-button" target="_blank">Purchase Now</a>';
                $html .= '</div>';
                return $html;
            }
        }
        $ebxwcts_timeslots_cta = apply_filters( 'ebxwcts_instructions_panel_cta', ebxwcts_instructions_cta() );
        echo $ebxwcts_timeslots_cta;
        ?>
    </div>
    <div class="ebxwcts-main">
        <h2 class="ebxwcts-h2">Description</h2>
        <p class="ebxwcts-description">Time Slots for WooCommerce, the easiest way to book paid consulting calls. Set your availability, and Time Slots will be generated for the next 7 days (outlook period adjustable with pro version), only on the days you select at the times you specify.</p>
        <h2 class="ebxwcts-h2">Usage</h2>
        <hr>
        <h4 class="ebxwcts-h4">Enable Time Slots</h4>
        <p class="ebxwcts-description">Create a WooCommerce product. In the main metabox where the publish button is located, check the time slot checkbox to enable time slots on that product page.</p>
        <h4 class="ebxwcts-h4">Label</h4>
        <p class="ebxwcts-description">This is the text that will appear above the dropdown box on the product page.</p>
        <h4 class="ebxwcts-h4">Weekdays</h4>
        <p class="ebxwcts-description">Check the days of the week that you would like to have available to be booked.</p>
        <h4 class="ebxwcts-h4">Time Slots</h4>
        <p class="ebxwcts-description">Select the times of the day that you would like to be available to be booked. A time slot will be created for each day of the week that is enabled.</p>
        <h4 class="ebxwcts-h4">Timezone</h4>
        <p class="ebxwcts-description">Select your timezone, this will be displayed on the product page.</p>
        <div class="ebxwcts-bottom-cta">
            <?php
            if( ! function_exists('ebxwcts_instructions_cta_bottom') ) {
                function ebxwcts_instructions_cta_bottom() {
                    $html = '<h2 class="ebxwcts-h2">Pro Version</h2><hr>';
                    $html .= '<h4 class="ebxwcts-h4">Benefits:</h4>';
                    $html .= '<ul class="ebxwcts-ul">';
                    $html .= '<li>Add up to 10 time slots</li>';
                    $html .= '<li>Set the outlook period beyond the default, and enable an offset of days</li>';
                    $html .= '<li>Auto removal of time slots that are already booked</li>';
                    $html .= '<li>An appointment post type is created for easy management</li>';
                    $html .= '</ul>';
                    $html .= '<a href="https://gettimeslots.com" class="ebxwcts-button" target="_blank">Purchase Now</a>';
                    return $html;
                }
            }
            $ebxwcts_timeslots_cta_bottom = apply_filters( 'ebxwcts_instructions_panel_cta', ebxwcts_instructions_cta_bottom() );
            echo $ebxwcts_timeslots_cta_bottom;
            ?>
        </div>
    </div>
</div><!-- end right col  -->