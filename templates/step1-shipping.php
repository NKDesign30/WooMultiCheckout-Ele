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
    document.getElementById('next-step').addEventListener('click', function() {
        var firstName = document.getElementById('first-name').value;
        var lastName = document.getElementById('last-name').value;
        var address = document.getElementById('address').value;
        var city = document.getElementById('city').value;
        var postcode = document.getElementById('postcode').value;
        var country = document.getElementById('country').value;
        var shippingAddress = firstName + ' ' + lastName + ', ' + address + ', ' + city + ', ' + postcode + ', ' + country;
        localStorage.setItem('shippingAddress', shippingAddress);

        var billingAddress = shippingAddress; // Assuming billing address is the same as shipping address
        localStorage.setItem('billingAddress', billingAddress);
    });
</script>