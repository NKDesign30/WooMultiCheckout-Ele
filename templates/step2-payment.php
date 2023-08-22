<div class="wmc-step wmc-step2">
    <h2><?php _e('Schritt 2: Zahlung', 'woomulticheckout'); ?></h2>
    <form id="wmc-step2-form" method="post">
        <?php
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        var_dump($available_gateways); // Debugging: Zeigt alle verfügbaren Zahlungsgateways an.
        ?>
        <div class="wmc-payment-methods">
            <?php
            foreach ($available_gateways as $gateway) {
                echo '<div class="wmc-payment-method">';
                echo '<input type="radio" id="' . esc_attr($gateway->id) . '" name="payment_method" value="' . esc_attr($gateway->id) . '">';
                echo '<label for="' . esc_attr($gateway->id) . '">' . $gateway->get_icon() . esc_html($gateway->get_title()) . '</label>';
                echo '</div>';
            }
            ?>
        </div>
        <input type="hidden" id="current-step" value="2">
        <div class="next-button-container">
            <button id="next-step"><?php _e('Weiter', 'woomulticheckout'); ?></button>
        </div>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#next-step').on('click', function(e) {
            e.preventDefault();

            var paymentMethod = $("input[name='payment_method']:checked").val();
            console.log("Selected Payment Method in Step 2:", paymentMethod); // Debugging: Zeigt die ausgewählte Zahlungsmethode in der Konsole an.

            localStorage.setItem('payment_method', paymentMethod);

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