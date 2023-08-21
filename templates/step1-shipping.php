<div class="multistep-checkout-step1">
    <h2>Versand</h2>
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
            <!-- Add other countries as needed -->
        </select>
        <label for="phone">Telefon:</label>
        <input type="tel" id="phone" name="phone" required>
        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Weiter zu Schritt 2">
    </form>
</div>
