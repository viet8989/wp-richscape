/**
 * Richscape Banner Slider – richscape-banner-slider.js
 *
 * Vanilla JS. No jQuery dependency.
 * Handles: autoplay, prev/next arrows, dot nav,
 *          keyboard navigation, touch/swipe, pause on hover,
 *          and ARIA live-region updates.
 */
(function () {
  'use strict';

  // ── Config ──────────────────────────────────────────────────
  var AUTOPLAY_MS   = 5000;   // ms between auto-advances
  var SWIPE_THRESH  = 50;     // px of drag needed to trigger swipe

  // ── Init on DOM ready ────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.richscape-banner-slider').forEach(initSlider);
  });

  /**
   * Initialise one slider instance.
   * @param {HTMLElement} slider
   */
  function initSlider(slider) {
    var track   = slider.querySelector('.rbs-track');
    var slides  = Array.from(slider.querySelectorAll('.rbs-slide'));
    var dotsWrap = slider.querySelector('.rbs-dots');
    var btnPrev = slider.querySelector('.rbs-prev');
    var btnNext = slider.querySelector('.rbs-next');

    if (!slides.length) return;

    var current   = 0;
    var total     = slides.length;
    var timer     = null;
    var touchStartX = 0;
    var touchEndX   = 0;

    // ── Build dot buttons dynamically ───────────────────────
    slides.forEach(function (_, i) {
      var dot = document.createElement('button');
      dot.className = 'rbs-dot' + (i === 0 ? ' active' : '');
      dot.setAttribute('role', 'tab');
      dot.setAttribute('aria-label', 'Slide ' + (i + 1));
      dot.setAttribute('aria-selected', i === 0 ? 'true' : 'false');
      dot.addEventListener('click', function () { goTo(i); });
      dotsWrap.appendChild(dot);
    });

    var dots = Array.from(dotsWrap.querySelectorAll('.rbs-dot'));

    // Set ARIA live on the track so screen readers announce changes
    track.setAttribute('aria-live', 'polite');

    // ── Show slide at index ──────────────────────────────────
    function goTo(index) {
      // Wrap around
      index = (index + total) % total;

      // Update slides
      slides[current].classList.remove('active');
      slides[index].classList.add('active');

      // Update dots
      dots[current].classList.remove('active');
      dots[current].setAttribute('aria-selected', 'false');
      dots[index].classList.add('active');
      dots[index].setAttribute('aria-selected', 'true');

      current = index;
    }

    // ── Auto-advance ─────────────────────────────────────────
    function startTimer() {
      stopTimer();
      timer = setInterval(function () { goTo(current + 1); }, AUTOPLAY_MS);
    }

    function stopTimer() {
      if (timer) { clearInterval(timer); timer = null; }
    }

    // ── Arrow buttons ────────────────────────────────────────
    if (btnPrev) {
      btnPrev.addEventListener('click', function () {
        goTo(current - 1);
        startTimer(); // reset timer on manual interaction
      });
    }

    if (btnNext) {
      btnNext.addEventListener('click', function () {
        goTo(current + 1);
        startTimer();
      });
    }

    // ── Pause on hover / touch ───────────────────────────────
    slider.addEventListener('mouseenter', stopTimer);
    slider.addEventListener('mouseleave', startTimer);
    slider.addEventListener('touchstart', stopTimer, { passive: true });
    slider.addEventListener('touchend',   startTimer, { passive: true });

    // ── Keyboard navigation (left / right arrow keys) ────────
    // Make the slider focusable so keyboard events reach it
    slider.setAttribute('tabindex', '0');
    slider.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') {
        goTo(current - 1);
        startTimer();
      } else if (e.key === 'ArrowRight') {
        goTo(current + 1);
        startTimer();
      }
    });

    // ── Touch swipe (left / right) ───────────────────────────
    slider.addEventListener('touchstart', function (e) {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slider.addEventListener('touchend', function (e) {
      touchEndX = e.changedTouches[0].screenX;
      var delta = touchStartX - touchEndX;

      if (Math.abs(delta) >= SWIPE_THRESH) {
        // Positive delta = swiped left = next slide
        goTo(delta > 0 ? current + 1 : current - 1);
        startTimer();
      }
    }, { passive: true });

    // ── Kick off autoplay ────────────────────────────────────
    startTimer();
  }

}());
