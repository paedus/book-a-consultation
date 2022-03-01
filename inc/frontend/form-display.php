<form action="/" method="post" id="salesforce_form" class="form-std">
    <div class="form-field mb16">
        <label for="" class="form-field-label">
            <span class="form-field-label small-txt prim">First name</span>
            <input type="text" required class="form-field-input name-field body-txt" name="name" placeholder="Your full name">
        </label>
    </div>
    <div class="form-field mb16">
        <label for="" class="form-field-label">
            <span class="form-field-label small-txt prim">Surname</span>
            <input type="text" required class="form-field-input surname-field body-txt" name="surname" placeholder="Your full name">
        </label>
    </div>
    <div class="form-field mb16">
        <label for="" class="form-field-label">
            <span class="form-field-label small-txt prim">E-mail</span>
            <input type="text" required class="form-field-input email-field body-txt" name="surname" placeholder="Your e-mail">
        </label>
    </div>
    <div class="form-field mb24">
        <label for="" class="form-field-label">
            <span class="form-field-label small-txt prim">Phone</span>
            <input type="number" required class="form-field-input phone-field body-txt" name="phone" id="phone_field" placeholder="777 888 999">
        </label>
    </div>
    <div class="form-field form-field-checkbox mb16">
        <input type="checkbox" required class="form-field-input phone-field" id="privacy_check" name="policy">
        <label for="privacy_check" class="form-field-label">
            <p class="small-txt quar">I agree that you will process my data per <a href="#" class="quar small-link">privacy policy</a></p>
        </label>
    </div>
</form>