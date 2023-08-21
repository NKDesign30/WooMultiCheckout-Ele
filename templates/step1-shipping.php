<div class="checkout-step checkout-step1">
    <h2>Versand</h2>
    <form id="shipping-form">
        <div class="form-group">
            <label for="first-name">Vorname</label>
            <input type="text" id="first-name" name="first-name" required>
        </div>
        <div class="form-group">
            <label for="last-name">Nachname</label>
            <input type="text" id="last-name" name="last-name" required>
        </div>
        <div class="form-group">
            <label for="street">Straße und Hausnummer</label>
            <input type="text" id="street" name="street" required>
        </div>
        <div class="form-group">
            <label for="postcode">Postleitzahl</label>
            <input type="text" id="postcode" name="postcode" required>
        </div>
        <div class="form-group">
            <label for="city">Stadt</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="country">Land</label>
            <select id="country" name="country" required>
                <option value="de">Deutschland</option>
                <option value="at">Österreich</option>
                <option value="ch">Schweiz</option>
                <!-- Add more countries as needed -->
            </select>
        </div>
        <div class="form-group">
            <label for="phone">Telefonnummer</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">E-Mail-Adresse</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit" class="btn-next">Weiter</button>
    </form>
</div>