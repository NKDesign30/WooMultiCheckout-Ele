<div class="step1-shipping">
    <h2>Versanddetails</h2>
    <form id="step1-form">
        <label for="first-name">Vorname:</label>
        <input type="text" id="first-name" name="first-name" required>
        <label for="last-name">Nachname:</label>
        <input type="text" id="last-name" name="last-name" required>
        <label for="address">Adresse:</label>
        <input type="text" id="address" name="address" required>
        <label for="city">Stadt:</label>
        <input type="text" id="city" name="city" required>
        <label for="postcode">Postleitzahl:</label>
        <input type="text" id="postcode" name="postcode" required>
        <label for="country">Land:</label>
        <select id="country" name="country">
            <option value="de">Deutschland</option>
            <option value="at">Österreich</option>
            <option value="ch">Schweiz</option>
        </select>
        <input type="hidden" id="current-step" value="1">
        <button id="next-step">Weiter</button>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {
        $('#next-step').on('click', function(e) {
            e.preventDefault();

            var firstName = document.getElementById('first-name').value;
            var lastName = document.getElementById('last-name').value;
            var address = document.getElementById('address').value;
            var city = document.getElementById('city').value;
            var postcode = document.getElementById('postcode').value;
            var country = document.getElementById('country').value;

            localStorage.setItem('shipping_first_name', firstName);
            localStorage.setItem('shipping_last_name', lastName);
            localStorage.setItem('shipping_address_1', address);
            localStorage.setItem('shipping_city', city);
            localStorage.setItem('shipping_postcode', postcode);
            localStorage.setItem('shipping_country', country);

            // Assuming billing address is the same as shipping address
            localStorage.setItem('billing_first_name', firstName);
            localStorage.setItem('billing_last_name', lastName);
            localStorage.setItem('billing_address_1', address);
            localStorage.setItem('billing_city', city);
            localStorage.setItem('billing_postcode', postcode);
            localStorage.setItem('billing_country', country);

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
</style>