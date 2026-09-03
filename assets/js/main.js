/* TPHB — The Praise House Baltimore | Main JavaScript */
'use strict';

document.addEventListener('DOMContentLoaded', () => {

  // ── Header scroll behavior ───────────────────────────────────────────────
  const header = document.getElementById('siteHeader');
  if (header) {
    const isHeroPage = document.querySelector('.hero');

    const updateHeader = () => {
      if (isHeroPage) {
        if (window.scrollY > 60) {
          header.classList.add('scrolled');
          header.classList.remove('transparent');
        } else {
          header.classList.add('transparent');
          header.classList.remove('scrolled');
        }
      } else {
        header.classList.add('scrolled');
      }
    };

    if (isHeroPage) header.classList.add('transparent');
    else header.classList.add('scrolled');

    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();
  }

  // ── Mobile navigation ────────────────────────────────────────────────────
  const hamburger      = document.getElementById('hamburger');
  const mobileNav      = document.getElementById('mobileNav');
  const mobileNavClose = document.getElementById('mobileNavClose');
  const backdrop       = document.getElementById('mobileNavBackdrop');

  function openMobileNav() {
    mobileNav.classList.add('open');
    mobileNav.setAttribute('aria-hidden', 'false');
    hamburger.setAttribute('aria-expanded', 'true');
    hamburger.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeMobileNav() {
    mobileNav.classList.remove('open');
    mobileNav.setAttribute('aria-hidden', 'true');
    hamburger.setAttribute('aria-expanded', 'false');
    hamburger.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (hamburger)      hamburger.addEventListener('click', openMobileNav);
  if (mobileNavClose) mobileNavClose.addEventListener('click', closeMobileNav);
  if (backdrop)       backdrop.addEventListener('click', closeMobileNav);

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && mobileNav?.classList.contains('open')) closeMobileNav();
  });

  // ── Hero Swiper ──────────────────────────────────────────────────────────
  // Video autoplays muted (browser requirement).
  // Unmutes automatically on the user's first interaction with the page.
  function getHeroVideos() {
    return document.querySelectorAll('.hero-swiper video');
  }

  getHeroVideos().forEach(function (v) { v.muted = true; });

  function heroUnmuteOnce() {
    getHeroVideos().forEach(function (v) {
      v.muted  = false;
      v.volume = 1;
    });
    document.removeEventListener('click',      heroUnmuteOnce);
    document.removeEventListener('touchstart', heroUnmuteOnce);
    document.removeEventListener('keydown',    heroUnmuteOnce);
  }
  document.addEventListener('click',      heroUnmuteOnce);
  document.addEventListener('touchstart', heroUnmuteOnce);
  document.addEventListener('keydown',    heroUnmuteOnce);

  const heroSwiper = document.querySelector('.hero-swiper');
  if (heroSwiper && typeof Swiper !== 'undefined') {
    var heroSwiperReady = false;
    new Swiper('.hero-swiper', {
      loop: true,
      speed: 900,
      autoplay: { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: false, waitForTransition: false },
      effect: 'fade',
      fadeEffect: { crossFade: true },
      pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
      navigation: {
        nextEl: '.hero-swiper .swiper-button-next',
        prevEl: '.hero-swiper .swiper-button-prev',
      },
      a11y: { prevSlideMessage: 'Previous slide', nextSlideMessage: 'Next slide' },
      on: {
        afterInit: function () {
          heroSwiperReady = true;
          getHeroVideos().forEach(function (v) { v.play().catch(function () {}); });
        },
        slideChange: function () {
          if (!heroSwiperReady) return;
          if (this.realIndex !== 0) {
            getHeroVideos().forEach(function (v) { v.pause(); });
          }
        },
        slideChangeTransitionEnd: function () {
          if (this.realIndex === 0) {
            var hero = document.querySelector('.hero');
            var rect = hero ? hero.getBoundingClientRect() : null;
            var heroVisible = rect && rect.bottom > 0 && rect.top < window.innerHeight;
            if (heroVisible) {
              getHeroVideos().forEach(function (v) {
                v.currentTime = 0;
                v.play().catch(function () {});
              });
            }
          }
        },
      },
    });
  }

  // ── Testimonials Swiper ──────────────────────────────────────────────────
  const testimonialsSwiper = document.querySelector('.testimonials-swiper');
  if (testimonialsSwiper && typeof Swiper !== 'undefined') {
    new Swiper('.testimonials-swiper', {
      loop: true,
      speed: 700,
      autoplay: { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
      slidesPerView: 1,
      spaceBetween: 32,
      pagination: { el: '.testimonials-swiper .swiper-pagination', clickable: true },
      navigation: {
        nextEl: '.testimonials-swiper__next',
        prevEl: '.testimonials-swiper__prev',
      },
    });
  }

  // ── Event Countdown Timers ───────────────────────────────────────────────
  function updateCountdown(el) {
    const iso     = el.dataset.eventDate;
    if (!iso) return;

    const target  = new Date(iso).getTime();
    const now     = Date.now();
    const diff    = target - now;

    if (diff <= 0) {
      el.closest('.countdown')?.remove();
      return;
    }

    const days    = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

    const d = el.querySelector('[data-unit="days"]');
    const h = el.querySelector('[data-unit="hours"]');
    const m = el.querySelector('[data-unit="minutes"]');
    const s = el.querySelector('[data-unit="seconds"]');

    if (d) d.textContent = String(days).padStart(2, '0');
    if (h) h.textContent = String(hours).padStart(2, '0');
    if (m) m.textContent = String(minutes).padStart(2, '0');
    if (s) s.textContent = String(seconds).padStart(2, '0');
  }

  const countdownEls = document.querySelectorAll('.countdown[data-event-date]');
  if (countdownEls.length) {
    countdownEls.forEach(el => {
      updateCountdown(el);
      setInterval(() => updateCountdown(el), 1000);
    });
  }

  // ── Events Tabs ──────────────────────────────────────────────────────────
  const eventTabs = document.querySelectorAll('.events-tab');
  const eventPanels = document.querySelectorAll('.events-panel');

  eventTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      eventTabs.forEach(t => t.classList.remove('active'));
      eventPanels.forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      const target = document.getElementById(tab.dataset.panel);
      if (target) target.classList.add('active');
    });
  });

  // ── YouTube Live Detection ───────────────────────────────────────────────
  const liveBanner = document.getElementById('liveBanner');
  const liveModal  = document.getElementById('liveModal');
  const liveClose  = document.getElementById('liveModalClose');
  const liveWatch  = document.getElementById('liveWatchBtn');
  const liveFrame  = document.getElementById('liveIframe');
  let   currentLiveId = '';

  async function checkYoutubeLive() {
    if (!window.tphbData?.restUrl) return;
    try {
      const res  = await fetch(tphbData.restUrl + 'live-check', {
        headers: { 'X-WP-Nonce': tphbData.restNonce }
      });
      const data = await res.json();

      if (data.live && data.video_id) {
        currentLiveId = data.video_id;
        if (liveBanner) liveBanner.classList.add('is-live');
      } else {
        currentLiveId = '';
        if (liveBanner) liveBanner.classList.remove('is-live');
        if (liveModal)  closeLiveModal();
      }
    } catch (e) { /* silent fail */ }
  }

  function openLiveModal() {
    if (!liveModal || !currentLiveId) return;
    if (liveFrame) {
      liveFrame.src = `https://www.youtube.com/embed/${currentLiveId}?autoplay=1&rel=0`;
    }
    liveModal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLiveModal() {
    if (!liveModal) return;
    liveModal.classList.remove('open');
    if (liveFrame) liveFrame.src = '';
    document.body.style.overflow = '';
  }

  if (liveBanner) liveBanner.addEventListener('click', openLiveModal);
  if (liveWatch)  liveWatch.addEventListener('click', openLiveModal);
  if (liveClose)  liveClose.addEventListener('click', closeLiveModal);
  liveModal?.addEventListener('click', e => { if (e.target === liveModal) closeLiveModal(); });

  if (liveBanner || liveWatch) {
    checkYoutubeLive();
    setInterval(checkYoutubeLive, 2 * 60 * 1000);
  }

  // ── Contact Form ─────────────────────────────────────────────────────────
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async e => {
      e.preventDefault();
      const btn = contactForm.querySelector('[type="submit"]');
      const msg = contactForm.querySelector('.form-message');
      btn.disabled = true;
      btn.textContent = 'Sending…';

      const body = new FormData();
      body.append('action',          'tphb_contact_form');
      body.append('nonce',           tphbData.nonce);
      body.append('contact_name',    contactForm.contact_name?.value    || '');
      body.append('contact_email',   contactForm.contact_email?.value   || '');
      body.append('contact_subject', contactForm.contact_subject?.value || '');
      body.append('contact_message', contactForm.contact_message?.value || '');

      try {
        const res  = await fetch(tphbData.ajaxUrl, { method: 'POST', body });
        const data = await res.json();
        if (msg) {
          msg.textContent = data.data?.message || (data.success ? 'Message sent!' : 'Error. Please try again.');
          msg.className   = 'form-message show ' + (data.success ? 'success' : 'error');
        }
        if (data.success) contactForm.reset();
      } catch {
        if (msg) { msg.textContent = 'Something went wrong. Please try again.'; msg.className = 'form-message show error'; }
      }

      btn.disabled = false;
      btn.textContent = 'Send Message';
    });
  }

  // ── Prayer Request Form ──────────────────────────────────────────────────
  const prayerForm = document.getElementById('prayerForm');
  if (prayerForm) {
    prayerForm.addEventListener('submit', async e => {
      e.preventDefault();
      const btn = prayerForm.querySelector('[type="submit"]');
      const msg = prayerForm.querySelector('.form-message');
      btn.disabled = true;
      btn.textContent = 'Submitting…';

      const body = new FormData();
      body.append('action',         'tphb_prayer_request');
      body.append('nonce',          tphbData.nonce);
      body.append('prayer_name',    prayerForm.prayer_name?.value    || '');
      body.append('prayer_email',   prayerForm.prayer_email?.value   || '');
      body.append('prayer_request', prayerForm.prayer_request?.value || '');
      body.append('prayer_private', prayerForm.prayer_private?.checked ? '1' : '0');

      try {
        const res  = await fetch(tphbData.ajaxUrl, { method: 'POST', body });
        const data = await res.json();
        if (msg) {
          msg.textContent = data.data?.message || (data.success ? 'Prayer request submitted!' : 'Error. Please try again.');
          msg.className   = 'form-message show ' + (data.success ? 'success' : 'error');
        }
        if (data.success) prayerForm.reset();
      } catch {
        if (msg) { msg.textContent = 'Something went wrong. Please try again.'; msg.className = 'form-message show error'; }
      }

      btn.disabled = false;
      btn.textContent = 'Submit Prayer Request';
    });
  }

  // ── Plan a Visit / First-Time Visitor Form ───────────────────────────────
  const visitForm = document.getElementById('visitForm');
  if (visitForm) {
    const visitType      = document.getElementById('visit_type');
    const groupVisited   = document.getElementById('visit-group-visited');
    const groupPlanning  = document.getElementById('visit-group-planning');
    const submitBtn      = document.getElementById('visitSubmitBtn');
    const dateToday      = document.getElementById('visit_date_today');

    // Auto-fill today's date for the "visited today" group
    if (dateToday) dateToday.value = new Date().toISOString().split('T')[0];

    function setGroupRequired(group, required) {
      group.querySelectorAll('[data-required]').forEach(el => {
        if (required) el.setAttribute('required', '');
        else          el.removeAttribute('required');
      });
    }

    function showGroup(type) {
      groupVisited.classList.toggle('visit-conditional--visible', type === 'visited');
      groupPlanning.classList.toggle('visit-conditional--visible', type === 'planning');
      setGroupRequired(groupVisited,  type === 'visited');
      setGroupRequired(groupPlanning, type === 'planning');
      if (type === 'visited')  submitBtn.textContent = 'Submit My Details →';
      if (type === 'planning') submitBtn.textContent = 'Reserve My Visit →';
    }

    visitType.addEventListener('change', () => showGroup(visitType.value));

    visitForm.addEventListener('submit', async e => {
      e.preventDefault();
      const msg  = visitForm.querySelector('.form-message');
      const orig = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = 'Sending…';

      const body = new FormData();
      body.append('action',              'tphb_plan_visit');
      body.append('nonce',               tphbData.nonce);
      body.append('visit_type',          visitType.value                              || '');
      body.append('visit_first_name',    visitForm.visit_first_name?.value            || '');
      body.append('visit_last_name',     visitForm.visit_last_name?.value             || '');
      body.append('visit_email',         visitForm.visit_email?.value                 || '');
      body.append('visit_phone',         visitForm.visit_phone?.value                 || '');
      body.append('visit_referral',      visitForm.visit_referral?.value              || '');
      body.append('visit_notes',         visitForm.visit_notes?.value                 || '');
      body.append('visit_date_today',    visitForm.visit_date_today?.value            || '');
      body.append('visit_came_with',     visitForm.visit_came_with?.value             || '');
      body.append('visit_followup',      visitForm.visit_followup?.checked  ? '1' : '0');
      body.append('visit_planned_date',  visitForm.visit_planned_date?.value          || '');
      body.append('visit_party',         visitForm.visit_party?.value                 || '');
      body.append('visit_transport',     visitForm.visit_transport?.checked ? '1' : '0');

      try {
        const res  = await fetch(tphbData.ajaxUrl, { method: 'POST', body });
        const data = await res.json();
        if (msg) {
          msg.textContent = data.data?.message || (data.success ? 'Submitted!' : 'Error. Please try again.');
          msg.className   = 'form-message show ' + (data.success ? 'success' : 'error');
        }
        if (data.success) { visitForm.reset(); groupVisited.classList.remove('visit-conditional--visible'); groupPlanning.classList.remove('visit-conditional--visible'); }
      } catch {
        if (msg) { msg.textContent = 'Something went wrong. Please try again.'; msg.className = 'form-message show error'; }
      }

      submitBtn.disabled = false;
      submitBtn.textContent = orig;
    });
  }

  // ── Scroll-reveal animations ─────────────────────────────────────────────
  const revealEls = document.querySelectorAll('.fade-in-up');
  if (revealEls.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0, rootMargin: '0px 0px 160px 0px' });

    revealEls.forEach((el, i) => {
      el.style.transitionDelay = (i % 4) * 0.08 + 's';
      observer.observe(el);
    });
  }

  // ── Gallery lightbox (simple) ─────────────────────────────────────────────
  const galleryItems = document.querySelectorAll('.gallery-item[data-src]');
  if (galleryItems.length) {
    const lightbox    = document.createElement('div');
    lightbox.id       = 'galleryLightbox';
    lightbox.style.cssText = 'display:none;position:fixed;inset:0;z-index:3000;background:rgba(0,0,0,0.92);align-items:center;justify-content:center;';
    lightbox.innerHTML = `<button style="position:absolute;top:1.5rem;right:1.5rem;color:#fff;font-size:2rem;background:none;border:none;cursor:pointer;line-height:1;">&times;</button><img style="max-width:90vw;max-height:90vh;border-radius:8px;object-fit:contain;" alt="">`;
    document.body.appendChild(lightbox);

    const lbImg   = lightbox.querySelector('img');
    const lbClose = lightbox.querySelector('button');

    galleryItems.forEach(item => {
      item.addEventListener('click', () => {
        lbImg.src = item.dataset.src;
        lbImg.alt = item.dataset.alt || '';
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      });
    });

    lbClose.addEventListener('click', () => {
      lightbox.style.display = 'none';
      document.body.style.overflow = '';
    });
    lightbox.addEventListener('click', e => {
      if (e.target === lightbox) { lightbox.style.display = 'none'; document.body.style.overflow = ''; }
    });
  }

  // ── Smooth anchor scroll ─────────────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const target = document.querySelector(link.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const top = target.getBoundingClientRect().top + window.scrollY - 88;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

});
