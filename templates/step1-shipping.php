<div class="step1-form-container">
    <h2>Wohin sollen wir dein Paket schicken?</h2>
    <div class="step1-form-box">
        <form id="step1-form">
            <div class="form-field">
                <label for="anrede">Anrede:</label>
                <select name="anrede" id="anrede">
                    <option value="herr">Herr</option>
                    <option value="frau">Frau</option>
                </select>
            </div>
            <div class="form-field">
                <label for="first-name">Vorname:</label>
                <input type="text" id="first-name" name="first-name" required>

            </div>
            <div class="form-field">
                <label for="nachname">Nachname:</label>
                <input type="text" name="last-name" id="last-name" required>
            </div>
            <div class="form-field">
                <label for="strasse">Straße und Hausnummer:</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div class="form-field">
                <label for="plz">Postleitzahl:</label>
                <input type="text" name="postcode" id="postcode" required>
            </div>
            <div class="form-field">
                <label for="ort">Ort/Stadt:</label>
                <input type="text" name="city" id="city" required>
            </div>
            <div class="form-field">
                <label for="land">Land/Region:</label>
                <select name="country" id="country">
                    <option value="deutschland">Deutschland</option>
                    <option value="oesterreich">Österreich</option>
                    <option value="schweiz">Schweiz</option>
                </select>
            </div>
            <div class="form-field">
                <label for="telefon">Telefon:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="form-field">
                <label for="email">Email Adresse:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-field">
                <label for="anmerkungen">Anmerkungen:</label>
                <textarea name="notes" id="notes"></textarea>
            </div>
            <input type="hidden" id="current-step" value="1">

            <div class="next-button-container">
                <button id="next-step">Weiter</button>
            </div>
        </form>
    </div>
</div>


<script>
    jQuery(document).ready(function($) {
        $('#next-step').on('click', function(e) {
            e.preventDefault();

            var anrede = document.getElementById('anrede').value;
            var firstName = document.getElementById('first-name').value;
            var lastName = document.getElementById('last-name').value;
            var address = document.getElementById('address').value;
            var city = document.getElementById('city').value;
            var postcode = document.getElementById('postcode').value;
            var country = document.getElementById('country').value;
            var phone = document.getElementById('phone').value;
            var email = document.getElementById('email').value;
            var notes = document.getElementById('notes').value;

            localStorage.setItem('anrede', anrede);
            localStorage.setItem('shipping_first_name', firstName);
            localStorage.setItem('shipping_last_name', lastName);
            localStorage.setItem('shipping_address_1', address);
            localStorage.setItem('shipping_city', city);
            localStorage.setItem('shipping_postcode', postcode);
            localStorage.setItem('shipping_country', country);
            localStorage.setItem('phone', phone);
            localStorage.setItem('email', email);
            localStorage.setItem('notes', notes);

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
    .step1-form-container {
        font-size: 16px;
    }

    .step1-form-box {
        border: 1px solid #f5f5f5;
        border-radius: 20px;
        padding: 20px;
    }

    .form-field {
        margin-bottom: 20px;
    }

    .form-field label {
        display: block;
        margin-bottom: 5px;
    }

    .form-field input[type="text"],
    .form-field input[type="email"],
    .form-field select,
    .form-field textarea {
        border: 1px solid #cfc47e;
        border-radius: 15px;
        padding: 5px 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .form-field textarea {
        height: 100px;
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