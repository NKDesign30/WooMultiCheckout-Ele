<div class="step2-payment">
    <h2>Zahlung</h2>
    <p>Bitte wählen Sie Ihre bevorzugte Zahlungsmethode aus:</p>
    <form id="payment-form" method="post">
        <?php
        // Get available payment gateways
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        if (!empty($available_gateways)) {
            foreach ($available_gateways as $gateway) {
                echo '<div class="payment-option">';
                echo '<input type="radio" name="payment_method" value="' . esc_attr($gateway->id) . '" id="payment_method_' . esc_attr($gateway->id) . '">';
                echo '<label for="payment_method_' . esc_attr($gateway->id) . '">' . esc_html($gateway->get_title()) . '</label>';
                echo '</div>';
            }
        }
        ?>
        <div class="coupon-field">
            <label for="coupon_code">Gutscheincode:</label>
            <input type="text" name="coupon_code" id="coupon_code" placeholder="Gutscheincode eingeben">
            <button type="submit" name="apply_coupon" value="Gutschein anwenden">Gutschein anwenden</button>
        </div>
        <input type="hidden" id="current-step" value="2">
        <button id="next-step">Weiter</button>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#next-step').on('click', function(e) {
            e.preventDefault();
            var currentStep = parseInt($('#current-step').val());
            var nextStep = currentStep + 1;
            var url = window.location.href;
            var newUrl = updateUrlParameter(url, 'step', nextStep);
            window.location.href = newUrl;
        });

        function updateUrlParameter(url, param, paramVal) {
            var newAdditionalURL = "";
            var tempArray = url.split("?");
            var baseURL = tempArray[0];
            var additionalURL = tempArray[1];
            var temp = "";
            if (additionalURL) {
                tempArray = additionalURL.split("&");
                for (var i = 0; i < tempArray.length; i++) {
                    if (tempArray[i].split('=')[0] != param) {
                        newAdditionalURL += temp + tempArray[i];
                        temp = "&";
                    }
                }
            }
            var rows_txt = temp + "" + param + "=" + paramVal;
            return baseURL + "?" + newAdditionalURL + rows_txt;
        }
    });
</script>