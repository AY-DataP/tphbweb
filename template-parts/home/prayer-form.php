<div class="tphb-form">
    <h3>Prayer Request</h3>
    <p>Share your prayer need with us. Our team prays over every request. You are not alone.</p>

    <form id="prayerForm" novalidate>
        <input type="hidden" name="form_source" value="Prayer Request">
        <div class="form-group">
            <label for="prayer_name">Your Name <span aria-hidden="true">*</span></label>
            <input type="text" id="prayer_name" name="prayer_name" placeholder="Your name" required autocomplete="name">
        </div>
        <div class="form-group">
            <label for="prayer_email">Email Address</label>
            <input type="email" id="prayer_email" name="prayer_email" placeholder="Optional — we will follow up" autocomplete="email">
        </div>
        <div class="form-group">
            <label for="prayer_request">Your Prayer Request <span aria-hidden="true">*</span></label>
            <textarea id="prayer_request" name="prayer_request" placeholder="Share what is on your heart…" required rows="5"></textarea>
        </div>
        <div class="form-check">
            <input type="checkbox" id="prayer_private" name="prayer_private">
            <label for="prayer_private">Keep my request private (only seen by the prayer team)</label>
        </div>
        <button type="submit" class="btn btn-outline-white">Submit Prayer Request</button>
        <div class="form-message" role="alert" aria-live="polite"></div>
    </form>
</div>
