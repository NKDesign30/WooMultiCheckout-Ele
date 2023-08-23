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
                echo '<label for="payment_method_' . esc_attr($gateway->id) . '">';
                echo $gateway->get_icon(); // Display the icon of the payment method
                echo esc_html($gateway->get_title());
                echo '</label>';
                echo '</div>';
            }
        }
        ?>
        <h2>Hast du einen Gutschein oder Rabattcode?</h2>
        <div class="coupon-container">
            <label for="coupon_code">Rabattcode:</label>
            <div class="coupon-field">
                <input type="text" name="coupon_code" id="coupon_code" placeholder="Gutscheincode eingeben">
                <button type="submit" name="apply_coupon" value="Gutschein anwenden">Anwenden</button>
            </div>
        </div>
        <input type="hidden" id="current-step" value="2">
        <div class="next-button-container">
            <button id="next-step">Weiter</button>
        </div>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#next-step').on('click', function(e) {
            e.preventDefault();

            var paymentMethod = $("input[name='payment_method']:checked").val();
            console.log("Ausgewählte Zahlungsmethode:", paymentMethod);

            localStorage.setItem('payment_method', paymentMethod);

            var couponCodeElement = document.getElementById('coupon_code');
            var couponCode = couponCodeElement ? couponCodeElement.value : '';
            localStorage.setItem('coupon_code', couponCode);

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


<style>
    .wmc-review-section {
        border: 1px solid #f5f5f5;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .wmc-review-section h3 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .wmc-review-section p {
        font-size: 16px;
    }

    .edit-link {
        cursor: pointer;
        color: blue;
        text-decoration: underline;
    }

    .hidden {
        display: none;
    }

    .step2-payment {
        font-size: 16px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        border: 1px solid #f5f5f5;
        border-radius: 20px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .payment-option input[type="radio"] {
        margin-right: 10px;
    }

    .payment-option label {
        display: flex;
        align-items: center;
    }

    .payment-option img {
        width: 30px;
        height: 30px;
        margin-right: 10px;
    }

    .coupon-container {
        border: 1px solid #f5f5f5;
        border-radius: 20px;
        padding: 20px;
        font-size: 16px;
    }

    .coupon-field {
        display: flex;
        align-items: center;
    }

    .coupon-field label {
        display: block;
        margin-bottom: 10px;
    }

    .coupon-field input[type="text"] {
        border: 1px solid #cfc47e;
        border-radius: 15px;
        padding: 5px 10px;
        margin-right: 20px;
        flex-grow: 1;
    }

    .coupon-field button {
        background-color: #cfc47e;
        color: #fff;
        border: none;
        border-radius: 15px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .coupon-field button:hover {
        background-color: #b5b06a;
    }

    .next-button-container {
        position: sticky;
        bottom: 0;
        background-color: #fff;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 114%;
        box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        margin-left: -7%;
    }

    #next-step {
        background-color: #cfc47e;
        color: #fff;
        border: none;
        border-radius: 35px;
        padding: 10px 20px;
        cursor: pointer;
        width: 80%;
        height: 44px;
    }

    #next-step:hover {
        background-color: #b5b06a;
    }
</style>