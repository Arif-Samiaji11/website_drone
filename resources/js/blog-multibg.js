(function () {
    function tryParseJSON(text) {
        try { return JSON.parse(text); } catch (e) { return null; }
    }

    function setBg(el, url) {
        el.style.opacity = '0.92';
        setTimeout(function () {
            el.style.backgroundImage = 'url("' + url + '")';
            el.style.opacity = '1';
        }, 120);
    }

    function setActiveThumb(container, url) {
        var thumbs = container.querySelectorAll('.blog__thumbs img');
        thumbs.forEach(function (img) {
            img.classList.toggle('is-active', img.getAttribute('data-bg') === url);
        });
    }

    function initMultiBGPerCard(card) {
        var list = tryParseJSON(card.getAttribute('data-bg-list'));
        if (!list || !Array.isArray(list) || list.length === 0) return;

        var intervalMs = parseInt(card.getAttribute('data-bg-interval') || '3500', 10);
        var idx = 0;
        var timer = null;
        var isPaused = false;

        setBg(card, list[idx]);
        setActiveThumb(card, list[idx]);

        function play() {
            if (timer || list.length < 2) return;
            timer = setInterval(function () {
                if (isPaused) return;
                idx = (idx + 1) % list.length;
                setBg(card, list[idx]);
                setActiveThumb(card, list[idx]);
            }, intervalMs);
        }

        function stop() {
            if (!timer) return;
            clearInterval(timer);
            timer = null;
        }

        play();

        card.addEventListener('mouseenter', function () { isPaused = true; });
        card.addEventListener('mouseleave', function () { isPaused = false; });

        var thumbs = card.querySelectorAll('.blog__thumbs img');
        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function (e) {
                e.preventDefault();
                var url = thumb.getAttribute('data-bg');
                var foundIndex = list.indexOf(url);
                idx = foundIndex >= 0 ? foundIndex : idx;
                setBg(card, url);
                setActiveThumb(card, url);
                stop();
                play();
            });
        });
    }

    function initAll() {
        var cards = document.querySelectorAll('.latest__item[data-bg-list]');
        cards.forEach(initMultiBGPerCard);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
