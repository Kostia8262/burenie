"""
Растровые иконки сайта из знака-капли (тот же, что в inc/parts/logo.php).

    python tools/make-icons.py

Пишет:
  site/favicon.ico                    16/32/48, прозрачный фон — для /favicon.ico,
                                      который браузеры и Яндекс запрашивают сами;
  site/assets/img/touch-icon.png      180, синяя плашка — iOS заливает прозрачное чёрным;
  site/assets/img/icon-192.png, -512  для manifest.webmanifest, знак в безопасной
                                      зоне maskable (круг 80%).

Нужен только Pillow. SVG-версия — site/assets/img/favicon.svg, правится руками.
"""

from pathlib import Path
from PIL import Image, ImageDraw

ROOT = Path(__file__).resolve().parent.parent / "site"
IMG = ROOT / "assets" / "img"

BLUE_TOP = (0x2E, 0x9B, 0xC4)
BLUE = (0x12, 0x52, 0x7E)
ORANGE = (0xEF, 0x7B, 0x1C)
WHITE = (255, 255, 255)

SS = 8  # суперсэмплинг, потом уменьшаем с LANCZOS


def cubic(p0, p1, p2, p3, n=48):
    pts = []
    for i in range(1, n + 1):
        t = i / n
        u = 1 - t
        pts.append((
            u**3 * p0[0] + 3 * u * u * t * p1[0] + 3 * u * t * t * p2[0] + t**3 * p3[0],
            u**3 * p0[1] + 3 * u * u * t * p1[1] + 3 * u * t * t * p2[1] + t**3 * p3[1],
        ))
    return pts


# Контур капли в координатах viewBox 0 0 40 40 (см. logo.php)
DROP = [(20, 2.5)]
DROP += cubic((20, 2.5), (26.4, 10.2), (31.5, 16.7), (31.5, 22.8))
DROP += cubic((31.5, 22.8), (31.5, 30.3), (26.3, 36), (20, 36))
DROP += cubic((20, 36), (13.7, 36), (8.5, 30.3), (8.5, 22.8))
DROP += cubic((8.5, 22.8), (8.5, 16.7), (13.6, 10.2), (20, 2.5))

ROD = (18, 10.5, 22, 25.5)
BIT = [(15, 25.5), (25, 25.5), (20, 32)]


def gradient(size, top, bottom):
    g = Image.new("RGB", (1, size))
    for y in range(size):
        k = y / max(size - 1, 1)
        g.putpixel((0, y), tuple(round(a + (b - a) * k) for a, b in zip(top, bottom)))
    return g.resize((size, size))


def mapper(size, x0, y0, span):
    """Координаты знака (40-сетка) -> пиксели холста size×size."""
    s = size / span
    return lambda p: ((p[0] - x0) * s, (p[1] - y0) * s)


def favicon(px):
    """Капля на прозрачном фоне, кадр как у favicon.svg."""
    n = px * SS
    m = mapper(n, 3, 2.25, 34)
    mask = Image.new("L", (n, n), 0)
    ImageDraw.Draw(mask).polygon([m(p) for p in DROP], fill=255)

    # градиент по высоте самой капли, а не холста
    top, bottom = m((0, 2.5))[1], m((0, 36))[1]
    col = Image.new("RGB", (1, n))
    for y in range(n):
        k = min(max((y - top) / (bottom - top), 0), 1)
        col.putpixel((0, y), tuple(round(a + (b - a) * k) for a, b in zip(BLUE_TOP, BLUE)))
    img = Image.new("RGBA", (n, n), (0, 0, 0, 0))
    img.paste(col.resize((n, n)), (0, 0), mask)

    d = ImageDraw.Draw(img)
    (x0, y0), (x1, y1) = m(ROD[:2]), m(ROD[2:])
    d.rectangle((x0, y0, x1, y1), fill=WHITE)
    d.polygon([m(p) for p in BIT], fill=ORANGE)
    return img.resize((px, px), Image.LANCZOS)


def tile(px):
    """Синяя плашка во весь квадрат, белая капля в центре (60% высоты)."""
    n = px * SS
    img = gradient(n, BLUE_TOP, BLUE).convert("RGBA")
    # капля 33.5 единиц высотой должна занять 60% стороны
    span = 33.5 / 0.6
    cx, cy = 20, (2.5 + 36) / 2
    m = mapper(n, cx - span / 2, cy - span / 2, span)
    d = ImageDraw.Draw(img)
    d.polygon([m(p) for p in DROP], fill=WHITE)
    (x0, y0), (x1, y1) = m(ROD[:2]), m(ROD[2:])
    d.rectangle((x0, y0, x1, y1), fill=BLUE)
    d.polygon([m(p) for p in BIT], fill=ORANGE)
    return img.resize((px, px), Image.LANCZOS)


if __name__ == "__main__":
    big = favicon(256)
    big.save(ROOT / "favicon.ico", sizes=[(16, 16), (32, 32), (48, 48)])
    tile(180).convert("RGB").save(IMG / "touch-icon.png", optimize=True)
    tile(192).convert("RGB").save(IMG / "icon-192.png", optimize=True)
    tile(512).convert("RGB").save(IMG / "icon-512.png", optimize=True)
    print("ok")
