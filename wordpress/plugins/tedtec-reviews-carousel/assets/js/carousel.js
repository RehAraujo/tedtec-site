(function () {
  'use strict';

  function initCarousel(root) {
    if (!root || root.dataset.ttCarouselReady === 'true') return;

    var track = root.querySelector('[data-tt-track]');
    var prevButton = root.querySelector('[data-tt-prev]');
    var nextButton = root.querySelector('[data-tt-next]');
    var dots = root.querySelector('[data-tt-dots]');

    if (!track || !prevButton || !nextButton || !dots) return;

    var slides = Array.prototype.slice.call(track.children);
    if (!slides.length) return;

    root.dataset.ttCarouselReady = 'true';

    var total = slides.length;
    var perView = getPerView();
    var index = 0;
    var autoplayId = null;
    var resizeFrame = null;
    var dragFrame = null;
    var startX = null;
    var startY = null;
    var dragX = 0;
    var draggingHorizontally = false;
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    track.style.touchAction = 'pan-y';

    function getPerView() {
      if (window.innerWidth <= 640) return 1;
      if (window.innerWidth <= 1024) return 2;
      return 3;
    }

    function maxIndex() {
      return Math.max(0, total - perView);
    }

    function pageStarts() {
      var starts = [];
      for (var i = 0; i < total; i += perView) {
        var start = Math.min(i, maxIndex());
        if (starts.indexOf(start) === -1) starts.push(start);
      }
      return starts;
    }

    function slideWidth() {
      return slides[0].getBoundingClientRect().width;
    }

    function setTransform(offset) {
      track.style.transform = 'translate3d(' + offset + 'px,0,0)';
    }

    function renderDots() {
      var starts = pageStarts();
      dots.hidden = starts.length <= 1;

      while (dots.children.length < starts.length) {
        var button = document.createElement('button');
        button.type = 'button';
        button.addEventListener('click', function () {
          goTo(Number(this.dataset.ttStart));
          resetAutoplay();
        });
        dots.appendChild(button);
      }

      var focusedDot = document.activeElement && document.activeElement.parentNode === dots
        ? Array.prototype.indexOf.call(dots.children, document.activeElement)
        : -1;

      while (dots.children.length > starts.length) {
        dots.removeChild(dots.lastElementChild);
      }

      if (focusedDot >= starts.length && dots.lastElementChild) {
        dots.lastElementChild.focus();
      }

      starts.forEach(function (start, dotIndex) {
        var button = dots.children[dotIndex];
        button.dataset.ttStart = String(start);
        button.setAttribute('aria-label', 'Ir para o grupo ' + (dotIndex + 1));
        if (start === index) button.setAttribute('aria-current', 'true');
        else button.removeAttribute('aria-current');
      });
    }

    function update() {
      index = Math.max(0, Math.min(index, maxIndex()));
      setTransform(-(index * slideWidth()));
      renderDots();

      var hasMultiplePages = pageStarts().length > 1;
      prevButton.hidden = !hasMultiplePages;
      nextButton.hidden = !hasMultiplePages;
    }

    function goTo(target) {
      index = Math.max(0, Math.min(target, maxIndex()));
      update();
    }

    function next() {
      var starts = pageStarts();
      var current = starts.indexOf(index);
      if (current === -1) {
        var following = starts.find(function (start) { return start > index; });
        goTo(following !== undefined ? following : starts[0]);
        return;
      }
      goTo(starts[(current + 1) % starts.length]);
    }

    function previous() {
      var starts = pageStarts();
      var current = starts.indexOf(index);
      var target = current <= 0 ? starts.length - 1 : current - 1;
      goTo(starts[target]);
    }

    function stopAutoplay() {
      if (autoplayId !== null) {
        window.clearInterval(autoplayId);
        autoplayId = null;
      }
    }

    function startAutoplay() {
      stopAutoplay();
      if (reducedMotion.matches || document.hidden || root.contains(document.activeElement) || pageStarts().length <= 1) return;
      autoplayId = window.setInterval(next, 5000);
    }

    function resetAutoplay() {
      stopAutoplay();
      startAutoplay();
    }

    function scheduleResize() {
      if (resizeFrame !== null) window.cancelAnimationFrame(resizeFrame);
      resizeFrame = window.requestAnimationFrame(function () {
        resizeFrame = null;
        var nextPerView = getPerView();
        if (nextPerView !== perView) {
          perView = nextPerView;
          index = Math.min(Math.floor(index / perView) * perView, maxIndex());
        }
        update();
        resetAutoplay();
      });
    }

    function resetDrag() {
      if (dragFrame !== null) {
        window.cancelAnimationFrame(dragFrame);
        dragFrame = null;
      }
      startX = null;
      startY = null;
      dragX = 0;
      draggingHorizontally = false;
      track.style.removeProperty('transition');
    }

    function onTouchStart(event) {
      if (!event.touches || event.touches.length !== 1) return;
      startX = event.touches[0].clientX;
      startY = event.touches[0].clientY;
      dragX = 0;
      draggingHorizontally = false;
      stopAutoplay();
    }

    function onTouchMove(event) {
      if (startX === null || !event.touches || event.touches.length !== 1) return;
      var deltaX = event.touches[0].clientX - startX;
      var deltaY = event.touches[0].clientY - startY;

      if (!draggingHorizontally && Math.abs(deltaX) < 8 && Math.abs(deltaY) < 8) return;
      if (!draggingHorizontally && Math.abs(deltaY) > Math.abs(deltaX)) return;

      draggingHorizontally = true;
      dragX = deltaX;
      event.preventDefault();
      track.style.transition = 'none';

      if (dragFrame !== null) window.cancelAnimationFrame(dragFrame);
      dragFrame = window.requestAnimationFrame(function () {
        dragFrame = null;
        setTransform(-(index * slideWidth()) + dragX);
      });
    }

    function onTouchEnd() {
      if (startX === null) return;
      var threshold = Math.min(56, slideWidth() * 0.16);
      var direction = draggingHorizontally && Math.abs(dragX) >= threshold ? (dragX < 0 ? 1 : -1) : 0;
      resetDrag();
      if (direction > 0) next();
      else if (direction < 0) previous();
      else update();
      startAutoplay();
    }

    prevButton.addEventListener('click', function () {
      previous();
      resetAutoplay();
    });
    nextButton.addEventListener('click', function () {
      next();
      resetAutoplay();
    });
    root.addEventListener('mouseenter', stopAutoplay);
    root.addEventListener('mouseleave', startAutoplay);
    root.addEventListener('focusin', stopAutoplay);
    root.addEventListener('focusout', startAutoplay);
    track.addEventListener('touchstart', onTouchStart, { passive: true });
    track.addEventListener('touchmove', onTouchMove, { passive: false });
    track.addEventListener('touchend', onTouchEnd, { passive: true });
    track.addEventListener('touchcancel', function () {
      update();
      resetDrag();
      startAutoplay();
    }, { passive: true });
    window.addEventListener('resize', scheduleResize, { passive: true });
    document.addEventListener('visibilitychange', function () {
      document.hidden ? stopAutoplay() : startAutoplay();
    });

    if (typeof reducedMotion.addEventListener === 'function') {
      reducedMotion.addEventListener('change', function () {
        update();
        resetAutoplay();
      });
    }

    update();
    startAutoplay();
  }

  function initAll() {
    document.querySelectorAll('[data-tt-carousel]').forEach(initCarousel);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll, { once: true });
  } else {
    initAll();
  }
})();
