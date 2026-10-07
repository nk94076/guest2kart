<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/content.php';

$c = content();
$s = $c['site'];
$h = $c['hero'];
$color = fn(string $v, string $fallback) => preg_match('/^#[0-9a-fA-F]{3,8}$/', $v) ? $v : $fallback;
$c1 = $color($s['color1'], '#4f46e5');
$c2 = $color($s['color2'], '#9333ea');
$input = 'mt-1.5 block w-full rounded-lg border border-slate-300 px-3.5 py-3 font-normal focus:border-brand focus:outline-none focus:ring-4 focus:ring-indigo-100';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($s['seo_title']) ?></title>
  <meta name="description" content="<?= e($s['seo_description']) ?>" />
  <?php if ($s['favicon']): ?><link rel="icon" href="<?= e($s['favicon']) ?>" /><?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        fontFamily: { sans: ['Poppins', 'ui-sans-serif', 'system-ui'] },
        colors: { brand: { DEFAULT: '<?= $c1 ?>', 2: '<?= $c2 ?>' } },
      } },
    };
  </script>
  <style>
    .grad-text { background: linear-gradient(90deg, <?= $c1 ?>, <?= $c2 ?>); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .grad-bg { background: linear-gradient(90deg, <?= $c1 ?>, <?= $c2 ?>); }
  </style>
</head>
<body class="font-sans text-slate-600 antialiased">

  <!-- NAV -->
  <header class="sticky top-0 z-20 border-b border-slate-100 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5">
      <a href="#" class="text-2xl font-extrabold text-slate-900">
        <?php if ($s['logo']): ?>
          <img src="<?= e($s['logo']) ?>" alt="<?= e($s['name1'] . $s['name_accent'] . $s['name2']) ?>" class="h-10 w-auto" />
        <?php else: ?>
          <?= e($s['name1']) ?><span class="text-brand"><?= e($s['name_accent']) ?></span><?= e($s['name2']) ?>
        <?php endif; ?>
      </a>
      <nav class="hidden gap-8 font-medium md:flex">
        <?php if ($c['services']['show']): ?><a href="#services" class="hover:text-brand">Services</a><?php endif; ?>
        <?php if ($c['how']['show']): ?><a href="#how" class="hover:text-brand">How it Works</a><?php endif; ?>
        <?php if ($c['pricing']['show']): ?><a href="#pricing" class="hover:text-brand">Pricing</a><?php endif; ?>
        <?php if ($c['faq']['show']): ?><a href="#faq" class="hover:text-brand">FAQ</a><?php endif; ?>
      </nav>
      <a href="#contact" class="grad-bg rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow hover:shadow-lg"><?= e($s['nav_button']) ?></a>
    </div>
  </header>

  <?php if ($h['show']): ?>
  <!-- HERO -->
  <section class="bg-[radial-gradient(circle_at_80%_10%,#ede9fe,transparent_50%),radial-gradient(circle_at_0%_90%,#e0e7ff,transparent_45%)] py-16 md:py-24">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 md:grid-cols-2">
      <div>
        <?php if ($h['badge']): ?><span class="inline-block rounded-full bg-indigo-50 px-4 py-1.5 text-sm font-semibold text-brand"><?= e($h['badge']) ?></span><?php endif; ?>
        <h1 class="mt-5 text-4xl font-extrabold leading-tight text-slate-900 md:text-5xl">
          <?= e($h['title_before']) ?> <span class="grad-text"><?= e($h['title_highlight']) ?></span> <?= e($h['title_after']) ?>
        </h1>
        <p class="mt-5 text-lg text-slate-500"><?= e($h['subtitle']) ?></p>
        <div class="mt-8 flex flex-wrap gap-4">
          <?php if ($h['button1']): ?><a href="#contact" class="grad-bg rounded-xl px-7 py-3.5 font-semibold text-white shadow-lg transition hover:-translate-y-0.5"><?= e($h['button1']) ?></a><?php endif; ?>
          <?php if ($h['button2']): ?><a href="#pricing" class="rounded-xl border-2 border-brand px-7 py-3 font-semibold text-brand transition hover:-translate-y-0.5"><?= e($h['button2']) ?></a><?php endif; ?>
        </div>
        <?php if ($h['stats']): ?>
        <div class="mt-10 flex flex-wrap gap-10">
          <?php foreach ($h['stats'] as $st): ?>
            <div><b class="block text-2xl text-slate-900"><?= e($st['value']) ?></b><span class="text-sm"><?= e($st['label']) ?></span></div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
      <?php if ($h['image']): ?>
        <img src="<?= e($h['image']) ?>" alt="" class="w-full rounded-2xl shadow-2xl shadow-slate-900/10" />
      <?php else: ?>
      <div class="rounded-2xl bg-white p-5 shadow-2xl shadow-slate-900/10">
        <div class="flex gap-1.5"><i class="h-2.5 w-2.5 rounded-full bg-red-400"></i><i class="h-2.5 w-2.5 rounded-full bg-amber-400"></i><i class="h-2.5 w-2.5 rounded-full bg-emerald-400"></i></div>
        <div class="grad-bg my-4 rounded-lg py-6 text-center font-bold tracking-widest text-white"><?= e($h['banner_text']) ?></div>
        <div class="my-2.5 h-2.5 w-4/5 rounded bg-slate-100"></div>
        <div class="my-2.5 h-2.5 w-11/12 rounded bg-slate-100"></div>
        <div class="my-2.5 h-2.5 w-3/5 rounded bg-slate-100"></div>
        <div class="mt-4 rounded-lg border-2 border-dashed border-indigo-200 p-4 font-semibold text-slate-900"><?= e($h['card_post']) ?><br /><small class="font-normal text-slate-500"><?= e($h['card_post_sub']) ?></small></div>
        <div class="mt-4 flex justify-between text-sm font-semibold text-brand"><span><?= e($h['card_stat1']) ?></span><span><?= e($h['card_stat2']) ?></span></div>
      </div>
      <?php endif; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['services']['show']): ?>
  <!-- SERVICES -->
  <section id="services" class="py-20">
    <div class="mx-auto max-w-6xl px-5">
      <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl"><?= e($c['services']['title']) ?></h2>
      <p class="mb-12 mt-2 text-center text-slate-500"><?= e($c['services']['subtitle']) ?></p>
      <div class="grid gap-6 md:grid-cols-3">
        <?php foreach ($c['services']['items'] as $it): ?>
          <div class="rounded-2xl border border-slate-100 bg-white p-7 transition hover:-translate-y-1 hover:shadow-xl">
            <div class="mb-3 text-4xl"><?= e($it['icon']) ?></div>
            <h3 class="mb-1.5 text-lg font-semibold text-slate-900"><?= e($it['title']) ?></h3>
            <p><?= e($it['text']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['how']['show']): ?>
  <!-- HOW IT WORKS -->
  <section id="how" class="bg-indigo-50/50 py-20">
    <div class="mx-auto max-w-6xl px-5">
      <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl"><?= e($c['how']['title']) ?></h2>
      <p class="mb-12 mt-2 text-center text-slate-500"><?= e($c['how']['subtitle']) ?></p>
      <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach ($c['how']['items'] as $i => $it): ?>
          <div class="rounded-2xl bg-white p-7 text-center">
            <span class="grad-bg mb-3 inline-grid h-12 w-12 place-items-center rounded-full font-bold text-white"><?= $i + 1 ?></span>
            <h4 class="font-semibold text-slate-900"><?= e($it['title']) ?></h4>
            <p class="text-sm text-slate-500"><?= e($it['text']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['pricing']['show']): ?>
  <!-- PRICING -->
  <section id="pricing" class="py-20">
    <div class="mx-auto max-w-6xl px-5">
      <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl"><?= e($c['pricing']['title']) ?></h2>
      <p class="mb-12 mt-2 text-center text-slate-500"><?= e($c['pricing']['subtitle']) ?></p>
      <div class="grid items-stretch gap-6 md:grid-cols-3">
        <?php foreach ($c['pricing']['items'] as $p): $f = !empty($p['featured']); ?>
          <div class="relative flex flex-col rounded-2xl p-8 text-center <?= $f ? 'border-2 border-brand shadow-2xl shadow-indigo-500/20 md:scale-105' : 'border border-slate-200' ?>">
            <?php if ($f): ?><span class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-full bg-brand px-4 py-1 text-xs font-semibold text-white">Most Popular</span><?php endif; ?>
            <h3 class="text-lg font-semibold text-slate-900"><?= e($p['name']) ?></h3>
            <div class="my-3 text-4xl font-extrabold text-slate-900"><?= e($p['price']) ?><small class="text-sm font-medium text-slate-500"> <?= e($p['suffix']) ?></small></div>
            <ul class="mb-6 flex-1 space-y-2">
              <?php foreach (lines($p['features']) as $feat): ?><li>✔ <?= e($feat) ?></li><?php endforeach; ?>
            </ul>
            <a href="#contact" data-service="<?= e($p['service']) ?>" class="<?= $f ? 'grad-bg text-white' : 'border-2 border-brand text-brand' ?> rounded-xl py-3 font-semibold transition hover:-translate-y-0.5"><?= e($p['button']) ?></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['why']['show']): ?>
  <!-- WHY US -->
  <section class="bg-indigo-50/50 py-20">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 md:grid-cols-2">
      <div>
        <h2 class="text-3xl font-bold text-slate-900 md:text-4xl"><?= e($c['why']['title']) ?></h2>
        <ul class="mt-6 space-y-3 font-medium">
          <?php foreach (lines($c['why']['points']) as $pt): ?><li>✅ <?= e($pt) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <?php if ($c['why']['testimonial']): ?>
      <div class="rounded-2xl bg-white p-8 text-lg italic shadow-xl">
        <p>“<?= e($c['why']['testimonial']) ?>”</p>
        <b class="mt-4 block text-base not-italic text-brand">— <?= e($c['why']['testimonial_author']) ?></b>
      </div>
      <?php endif; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['faq']['show']): ?>
  <!-- FAQ -->
  <section id="faq" class="py-20">
    <div class="mx-auto max-w-3xl px-5">
      <h2 class="mb-10 text-center text-3xl font-bold text-slate-900 md:text-4xl"><?= e($c['faq']['title']) ?></h2>
      <?php foreach ($c['faq']['items'] as $fq): ?>
        <details class="group mb-3 rounded-xl border border-slate-100 px-5 py-4">
          <summary class="cursor-pointer list-none font-semibold text-slate-900 after:float-right after:content-['+'] group-open:after:content-['−']"><?= e($fq['q']) ?></summary>
          <p class="mt-3 text-slate-500"><?= e($fq['a']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- CONTACT FORM -->
  <?php $ct = $c['contact']; ?>
  <section id="contact" class="bg-gradient-to-br from-slate-900 to-indigo-950 py-20 text-slate-300">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 md:grid-cols-5">
      <div class="md:col-span-2">
        <h2 class="text-3xl font-bold leading-snug text-white md:text-4xl"><?= e($ct['title_before']) ?> <span class="bg-gradient-to-r from-indigo-300 to-purple-200 bg-clip-text text-transparent"><?= e($ct['title_highlight']) ?></span> <?= e($ct['title_after']) ?></h2>
        <p class="mt-4"><?= e($ct['text']) ?></p>
        <ul class="mt-6 space-y-2">
          <?php foreach (lines($ct['points']) as $pt): ?><li><?= e($pt) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <form id="leadForm" class="rounded-2xl bg-white p-7 text-slate-700 md:col-span-3" novalidate>
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="text-sm font-semibold text-slate-900">Full Name *<input name="name" required maxlength="100" placeholder="Your name" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Email *<input name="email" type="email" required maxlength="150" placeholder="you@example.com" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Phone / WhatsApp<input name="phone" maxlength="30" placeholder="+91 98765 43210" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Your Website<input name="website" maxlength="200" placeholder="https://yourwebsite.com" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Service *
            <select name="service" id="serviceSelect" class="<?= $input ?> bg-white">
              <?php foreach (lines($ct['service_options']) as $o): ?><option><?= e($o) ?></option><?php endforeach; ?>
            </select>
          </label>
          <label class="text-sm font-semibold text-slate-900">Budget
            <select name="budget" class="<?= $input ?> bg-white">
              <option value="">Select budget</option>
              <?php foreach (lines($ct['budget_options']) as $o): ?><option><?= e($o) ?></option><?php endforeach; ?>
            </select>
          </label>
        </div>
        <label class="mt-4 block text-sm font-semibold text-slate-900">Message<textarea name="message" rows="4" maxlength="2000" placeholder="Tell us your niche, number of posts, banner size etc." class="<?= $input ?>"></textarea></label>
        <input type="text" name="company_website_hp" class="absolute -left-[9999px]" tabindex="-1" autocomplete="off" />
        <button type="submit" id="submitBtn" class="grad-bg mt-5 w-full rounded-xl py-3.5 font-semibold text-white transition hover:shadow-lg disabled:cursor-wait disabled:opacity-70"><?= e($ct['button']) ?></button>
        <p id="formMsg" class="mt-3 text-sm font-medium" role="status"></p>
      </form>
    </div>
  </section>

  <?php $ft = $c['footer']; ?>
  <footer class="bg-slate-950 py-6 text-center text-sm text-slate-400">
    <?php if ($ft['email'] || $ft['phone'] || $ft['whatsapp']): ?>
      <div class="mb-2 flex flex-wrap justify-center gap-5">
        <?php if ($ft['email']): ?><a href="mailto:<?= e($ft['email']) ?>" class="hover:text-white">✉️ <?= e($ft['email']) ?></a><?php endif; ?>
        <?php if ($ft['phone']): ?><a href="tel:<?= e(preg_replace('/[^\d+]/', '', $ft['phone'])) ?>" class="hover:text-white">📞 <?= e($ft['phone']) ?></a><?php endif; ?>
        <?php if ($ft['whatsapp']): ?><a href="https://wa.me/<?= e(preg_replace('/\D/', '', $ft['whatsapp'])) ?>" target="_blank" rel="noopener" class="hover:text-white">💬 WhatsApp</a><?php endif; ?>
      </div>
    <?php endif; ?>
    <?= e(str_replace('{year}', date('Y'), $ft['text'])) ?>
  </footer>

  <?php if ($ft['whatsapp']): ?>
    <a href="https://wa.me/<?= e(preg_replace('/\D/', '', $ft['whatsapp'])) ?>" target="_blank" rel="noopener" aria-label="WhatsApp"
       class="fixed bottom-5 right-5 z-30 grid h-14 w-14 place-items-center rounded-full bg-emerald-500 text-2xl text-white shadow-xl hover:bg-emerald-600">💬</a>
  <?php endif; ?>

  <script>
    document.querySelectorAll('[data-service]').forEach((b) =>
      b.addEventListener('click', () => (document.getElementById('serviceSelect').value = b.dataset.service))
    );

    const form = document.getElementById('leadForm');
    const msg = document.getElementById('formMsg');
    const btn = document.getElementById('submitBtn');
    const btnText = btn.textContent;
    const successText = <?= json_encode($ct['success'], JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?>;
    const show = (text, ok) => { msg.textContent = text; msg.className = 'mt-3 text-sm font-medium ' + (ok ? 'text-emerald-600' : 'text-red-600'); };

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(form);
      if (!fd.get('name').trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fd.get('email'))) {
        return show('Please enter your name and a valid email.', false);
      }
      btn.disabled = true;
      btn.textContent = 'Submitting...';
      try {
        const res = await fetch('submit.php', { method: 'POST', body: fd });
        const out = await res.json();
        if (!res.ok || !out.ok) throw new Error(out.error || 'Something went wrong');
        form.reset();
        show(successText, true);
      } catch (err) {
        show(err.message || 'Something went wrong. Please try again.', false);
      } finally {
        btn.disabled = false;
        btn.textContent = btnText;
      }
    });
  </script>
</body>
</html>
