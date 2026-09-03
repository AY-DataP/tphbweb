<div class="tphb-form">
    <h3>Get In Touch</h3>
    <p>Have a question or want to connect? We would love to hear from you.</p>

    <form id="contactForm" novalidate>
        <input type="hidden" name="form_source" value="Get in Touch">
        <div class="form-group">
            <label for="contact_name">Your Name <span aria-hidden="true">*</span></label>
            <input type="text" id="contact_name" name="contact_name" placeholder="John Smith" required autocomplete="name">
        </div>
        <div class="form-group">
            <label for="contact_email">Email Address <span aria-hidden="true">*</span></label>
            <input type="email" id="contact_email" name="contact_email" placeholder="john@example.com" required autocomplete="email">
        </div>
        <div class="form-group">
            <label for="contact_subject">Subject</label>
            <input type="text" id="contact_subject" name="contact_subject" placeholder="How can we help?">
        </div>
        <div class="form-group">
            <label for="contact_message">Message <span aria-hidden="true">*</span></label>
            <textarea id="contact_message" name="contact_message" placeholder="Tell us how we can help or connect with you…" required></textarea>
        </div>
        <button type="submit" class="btn btn-secondary">Send Message</button>
        <div class="form-message" role="alert" aria-live="polite"></div>
    </form>
</div>
