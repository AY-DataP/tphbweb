<section class="plan-visit-section section" id="plan-visit">
    <div class="container">

        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">You're Welcome Here</span>
            <h2 class="section-header__title">Welcome — Let's Stay Connected</h2>
            <p class="section-header__subtitle">Whether you worshipped with us for the first time today or you're planning your very first visit, we'd love to know you. Fill in the form and our Welcome Team will be in touch.</p>
            <div class="section-divider"></div>
        </div>

        <div class="visit-form-wrap fade-in-up">
            <form id="visitForm" novalidate>
                <input type="hidden" name="form_source" value="New Here">

                <!-- Identifying question — drives conditional fields -->
                <div class="form-group">
                    <label for="visit_type">Which best describes you? <span aria-hidden="true">*</span></label>
                    <select id="visit_type" name="visit_type" required>
                        <option value="" disabled selected>Select…</option>
                        <option value="visited">I visited The Praise House for the first time today</option>
                        <option value="planning">I haven't visited yet — I'm planning my first visit</option>
                    </select>
                </div>

                <!-- Common fields -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="visit_first_name">First Name <span aria-hidden="true">*</span></label>
                        <input type="text" id="visit_first_name" name="visit_first_name" placeholder="John" required autocomplete="given-name">
                    </div>
                    <div class="form-group">
                        <label for="visit_last_name">Last Name <span aria-hidden="true">*</span></label>
                        <input type="text" id="visit_last_name" name="visit_last_name" placeholder="Smith" required autocomplete="family-name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="visit_email">Email Address <span aria-hidden="true">*</span></label>
                        <input type="email" id="visit_email" name="visit_email" placeholder="john@example.com" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="visit_phone">Phone Number <span aria-hidden="true">*</span></label>
                        <input type="tel" id="visit_phone" name="visit_phone" placeholder="+1 (555) 000-0000" required autocomplete="tel">
                    </div>
                </div>

                <div class="form-group">
                    <label for="visit_referral">How did you hear about us? <span aria-hidden="true">*</span></label>
                    <select id="visit_referral" name="visit_referral" required>
                        <option value="" disabled selected>Select…</option>
                        <option value="Friend or Family">Friend or Family</option>
                        <option value="Social Media">Social Media</option>
                        <option value="Google / Search">Google / Search</option>
                        <option value="Drove or Walked by">Drove or Walked by</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Group 1: Visited today -->
                <div id="visit-group-visited" class="visit-conditional">
                    <div class="visit-conditional__divider">About Your Visit Today</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="visit_date_today">Date of Your Visit <span aria-hidden="true">*</span></label>
                            <input type="date" id="visit_date_today" name="visit_date_today" data-required>
                        </div>
                        <div class="form-group">
                            <label for="visit_came_with">Who did you come with? <span aria-hidden="true">*</span></label>
                            <select id="visit_came_with" name="visit_came_with" data-required>
                                <option value="" disabled selected>Select…</option>
                                <option value="Solo">Solo</option>
                                <option value="Couple">Couple</option>
                                <option value="Family">Family</option>
                                <option value="Brought a friend">Brought a friend</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" id="visit_followup" name="visit_followup" value="1" checked>
                            <span>I'd welcome a follow-up from the Welcome Team</span>
                        </label>
                    </div>
                </div>

                <!-- Group 2: Planning to visit -->
                <div id="visit-group-planning" class="visit-conditional">
                    <div class="visit-conditional__divider">About Your Upcoming Visit</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="visit_planned_date">Preferred Visit Date <span aria-hidden="true">*</span></label>
                            <input type="date" id="visit_planned_date" name="visit_planned_date" data-required>
                        </div>
                        <div class="form-group">
                            <label for="visit_party">Who's coming? <span aria-hidden="true">*</span></label>
                            <select id="visit_party" name="visit_party" data-required>
                                <option value="" disabled selected>Select…</option>
                                <option value="Just me">Just me</option>
                                <option value="Couple">Couple</option>
                                <option value="Family with children">Family with children</option>
                                <option value="Small group">Small group</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" id="visit_transport" name="visit_transport" value="1">
                            <span>I need help with transportation to get to church</span>
                        </label>
                    </div>
                </div>

                <!-- Common optional -->
                <div class="form-group">
                    <label for="visit_notes">Anything you'd like us to know? <span class="form-optional">(optional)</span></label>
                    <textarea id="visit_notes" name="visit_notes" placeholder="Questions, special needs, or anything that would help us make your experience great…" rows="4"></textarea>
                </div>

                <button type="submit" id="visitSubmitBtn" class="btn btn-primary btn-lg">Submit &rarr;</button>
                <div class="form-message" role="alert" aria-live="polite"></div>

            </form>
        </div>

    </div>
</section>
