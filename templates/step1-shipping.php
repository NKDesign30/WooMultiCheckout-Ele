<div class="wmc-step wmc-step1">
    <h2><?php _e('Schritt 1: Versand', 'woomulticheckout'); ?></h2>
    <form id="wmc-shipping-form">
        <div class="wmc-field">
            <label for="wmc-first-name"><?php _e('Vorname', 'woomulticheckout'); ?></label>
            <input type="text" id="wmc-first-name" name="first_name" required>
        </div>
        <div class="wmc-field">
            <label for="wmc-last-name"><?php _e('Nachname', 'woomulticheckout'); ?></label>
            <input type="text" id="wmc-last-name" name="last_name" required>
        </div>
        <div class="wmc-field">
            <label for="wmc-address"><?php _e('Adresse', 'woomulticheckout'); ?></label>
            <input type="text" id="wmc-address" name="address" required>
        </div>
        <div class="wmc-field">
            <label for="wmc-city"><?php _e('Stadt', 'woomulticheckout'); ?></label>
            <input type="text" id="wmc-city" name="city" required>
        </div>
        <div class="wmc-field">
            <label for="wmc-postcode"><?php _e('PLZ', 'woomulticheckout'); ?></label>
            <input type="text" id="wmc-postcode" name="postcode" required>
        </div>
<div class="wmc-field">
    <label for="wmc-country"><?php _e('Land', 'woomulticheckout'); ?></label>
    <select id="wmc-country" name="country" required>
        <?php
        $countries = wmc_get_countries();
        foreach ($countries as $code => $name) {
            echo '<option value="' . esc_attr($code) . '">' . esc_html($name) . '</option>';
        }
        ?>
    </select>
</div>
        <div class="wmc-field">
            <label for="wmc-phone"><?php _e('Telefon', 'woomulticheckout'); ?></label>
            <input type="tel" id="wmc-phone" name="phone" required>
        </div>
        <div class="wmc-field">
            <label for="wmc-email"><?php _e('E-Mail', 'woomulticheckout'); ?></label>
            <input type="email" id="wmc-email" name="email" required>
        </div>
        <button type="button" id="wmc-next-step"><?php _e('Weiter', 'woomulticheckout'); ?></button>
    </form>
</div>
