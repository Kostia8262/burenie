/* sos-bureniednr.ru — поведение страницы. Без библиотек. */
(function () {
  "use strict";

  var calm = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- выпадающие разделы меню ---------- */
  var toggles = document.querySelectorAll(".nav__toggle");

  if (toggles.length) {
    toggles.forEach(function (t) {
      t.addEventListener("click", function () {
        var open = t.getAttribute("aria-expanded") === "true";
        toggles.forEach(function (o) {
          o.setAttribute("aria-expanded", "false");
        });
        t.setAttribute("aria-expanded", String(!open));
      });
    });

    // клик мимо меню и Esc закрывают раскрытый раздел
    document.addEventListener("click", function (e) {
      if (!e.target.closest || !e.target.closest("[data-submenu]")) {
        toggles.forEach(function (o) {
          o.setAttribute("aria-expanded", "false");
        });
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        toggles.forEach(function (o) {
          o.setAttribute("aria-expanded", "false");
        });
      }
    });
  }

  /* ---------- окно заявки ---------- */
  var modal = document.getElementById("leadModal");

  if (modal && typeof modal.showModal === "function") {
    document.addEventListener("click", function (e) {
      var open = e.target.closest && e.target.closest("[data-lead-open]");
      if (open) {
        e.preventDefault();
        if (nav && nav.getAttribute("data-open") === "true") {
          burger.setAttribute("aria-expanded", "false");
          nav.setAttribute("data-open", "false");
        }
        modal.showModal();
        var first = modal.querySelector('input[name="name"]');
        if (first) first.focus();
        return;
      }
      if (e.target.closest && e.target.closest("[data-lead-close]")) {
        modal.close();
      }
    });

    // клик по подложке за пределами карточки закрывает окно
    modal.addEventListener("click", function (e) {
      if (e.target === modal) modal.close();
    });
  }

  /* ---------- цели аналитики ---------- */
  function goal(name) {
    try {
      if (window.ym && window.SOS_YM) window.ym(window.SOS_YM, "reachGoal", name);
      if (window.gtag) window.gtag("event", name);
    } catch (e) {
      /* счётчик не должен ломать страницу */
    }
  }

  document.addEventListener("click", function (e) {
    var a = e.target.closest && e.target.closest('a[href^="tel:"]');
    if (a && !a.hasAttribute("data-lead-open")) goal("phone_click");
    var t = e.target.closest && e.target.closest('a[href^="https://t.me/"]');
    if (t) goal("telegram_click");
  });

  /* ---------- меню ---------- */
  var burger = document.querySelector(".burger");
  var nav = document.getElementById("nav");

  if (burger && nav) {
    burger.addEventListener("click", function () {
      var open = burger.getAttribute("aria-expanded") === "true";
      burger.setAttribute("aria-expanded", String(!open));
      nav.setAttribute("data-open", String(!open));
    });

    nav.addEventListener("click", function (e) {
      if (e.target.tagName === "A") {
        burger.setAttribute("aria-expanded", "false");
        nav.setAttribute("data-open", "false");
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && burger.getAttribute("aria-expanded") === "true") {
        burger.setAttribute("aria-expanded", "false");
        nav.setAttribute("data-open", "false");
        burger.focus();
      }
    });
  }

  /* ---------- единственный поставленный момент: проходка разреза ---------- */
  var core = document.querySelector(".corex__col");

  if (core) {
    if (calm || !("IntersectionObserver" in window)) {
      core.classList.add("is-in");
    } else {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (en) {
            if (en.isIntersecting) {
              en.target.classList.add("is-in");
              io.unobserve(en.target);
            }
          });
        },
        { rootMargin: "0px 0px -18% 0px" }
      );
      io.observe(core);
    }
  }

  /* ---------- лента снимков ---------- */
  document.querySelectorAll("[data-shots]").forEach(function (box) {
    var track = box.querySelector(".shots__track");
    var dotBox = box.querySelector(".shots__dots");
    if (!track || !dotBox) return;

    var items = [].slice.call(track.querySelectorAll(".shots__item"));
    var dots = [].slice.call(dotBox.querySelectorAll(".shots__dot"));
    if (items.length < 2 || dots.length !== items.length) return;

    dotBox.hidden = false;

    function show(i) {
      track.scrollTo({
        left: items[i].offsetLeft - track.offsetLeft,
        behavior: calm ? "auto" : "smooth",
      });
    }

    function mark(i) {
      dots.forEach(function (d, n) {
        d.classList.toggle("is-on", n === i);
        if (n === i) d.setAttribute("aria-current", "true");
        else d.removeAttribute("aria-current");
      });
    }

    dots.forEach(function (d, i) {
      d.addEventListener("click", function () {
        show(i);
        mark(i);
      });
    });

    var tick;
    track.addEventListener("scroll", function () {
      clearTimeout(tick);
      tick = setTimeout(function () {
        var i = Math.round(track.scrollLeft / track.clientWidth);
        mark(Math.max(0, Math.min(items.length - 1, i)));
      }, 90);
    });

    track.addEventListener("keydown", function (e) {
      if (e.key !== "ArrowLeft" && e.key !== "ArrowRight") return;
      e.preventDefault();
      var cur = Math.round(track.scrollLeft / track.clientWidth);
      var next = cur + (e.key === "ArrowRight" ? 1 : -1);
      if (next < 0 || next >= items.length) return;
      show(next);
      mark(next);
    });

    /* автопрокрутка раз в 3 с; стоит, пока человек смотрит или листает сам */
    var cur = 0, hold = false;
    track.addEventListener("scroll", function () {
      cur = Math.round(track.scrollLeft / track.clientWidth);
    });
    ["mouseenter", "focusin", "touchstart"].forEach(function (ev) {
      box.addEventListener(ev, function () { hold = true; }, { passive: true });
    });
    ["mouseleave", "focusout", "touchend"].forEach(function (ev) {
      box.addEventListener(ev, function () { hold = false; }, { passive: true });
    });
    setInterval(function () {
      if (hold || document.hidden) return;
      var r = track.getBoundingClientRect();
      if (r.bottom < 0 || r.top > innerHeight) return;
      var next = (cur + 1) % items.length;
      show(next);
      mark(next);
    }, 3000);
  });

  /* ---------- телефонная маска ---------- */
  document.querySelectorAll('input[type="tel"]').forEach(function (inp) {
    inp.addEventListener("input", function () {
      var d = inp.value.replace(/\D/g, "").slice(0, 11);
      if (d[0] === "8") d = "7" + d.slice(1);
      if (d && d[0] !== "7") d = "7" + d;
      var out = "+7";
      if (d.length > 1) out += " (" + d.slice(1, 4);
      if (d.length >= 5) out += ") " + d.slice(4, 7);
      if (d.length >= 8) out += "-" + d.slice(7, 9);
      if (d.length >= 10) out += "-" + d.slice(9, 11);
      inp.value = out;
    });
  });

  /* ---------- отправка заявки ---------- */
  document.querySelectorAll("form[data-lead]").forEach(function (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var btn = form.querySelector('button[type="submit"]');
      var box = form.querySelector("[data-msg]");
      var label = btn ? btn.textContent : "";

      if (btn) {
        btn.disabled = true;
        btn.textContent = "Отправляем…";
      }

      fetch(form.getAttribute("action") || "/zayavka/", {
        method: "POST",
        body: new FormData(form),
        headers: { "X-Requested-With": "fetch" },
      })
        .then(function (r) {
          return r.json();
        })
        .then(function (res) {
          if (box) {
            box.className = "form-msg " + (res.ok ? "form-msg--ok" : "form-msg--err");
            box.textContent = res.msg;
            box.hidden = false;
          }
          if (res.ok) {
            form.reset();
            goal("lead_sent");
          }
        })
        .catch(function () {
          if (box) {
            box.className = "form-msg form-msg--err";
            box.textContent =
              "Не получилось отправить. Позвоните, пожалуйста: " +
              (form.dataset.tel || "");
            box.hidden = false;
          }
        })
        .finally(function () {
          if (btn) {
            btn.disabled = false;
            btn.textContent = label;
          }
        });
    });
  });
})();

/* Калькулятор проходки. Считает только метры на цену метра — остальное в
   смете зависит от участка, и придумывать его на клиенте нельзя. */
(function () {
  var box = document.querySelector("[data-calc]");
  if (!box) return;

  var rate = parseInt(box.dataset.rate, 10) || 0;
  var range = box.querySelector("#calc-depth");
  var outD = box.querySelector("[data-calc-depth]");
  var outS = box.querySelector("[data-calc-sum]");
  var gors = box.querySelectorAll("input[name=calc-gor]");
  if (!range || !outD || !outS) return;

  function money(n) {
    return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
  }

  function redraw() {
    var m = parseInt(range.value, 10) || 0;
    outD.textContent = m;
    outS.textContent = money(m * rate);
  }

  Array.prototype.forEach.call(gors, function (g) {
    g.addEventListener("change", function () {
      if (!g.checked) return;
      range.min = g.dataset.min;
      range.max = g.dataset.max;
      range.value = g.value;
      redraw();
    });
  });

  range.addEventListener("input", redraw);
  redraw();
})();
