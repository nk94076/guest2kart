<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/content.php';
require __DIR__ . '/includes/icons.php';

$c = content();
$s = $c['site'];
$h = $c['hero'];
$ft = $c['footer'];
$ct = $c['contact'];
$color = fn(string $v, string $fallback) => preg_match('/^#[0-9a-fA-F]{6}$/', $v) ? $v : $fallback;
$c1 = $color($s['color1'], '#0f5c46');
$c2 = $color($s['color2'], '#16a34a');
$rgb = fn(string $hex) => implode(' ', array_map('hexdec', str_split(substr($hex, 1), 2)));
$wa = preg_replace('/\D/', '', $ft['whatsapp']);
$input = 'mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-normal text-slate-700 placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-4 focus:ring-brand/10';

function eyebrow(string $t): string
{
    return $t === '' ? '' : '<p class="mb-2 text-xs font-bold uppercase tracking-[.2em] text-brand">' . e($t) . '</p>';
}

function logo(array $s, bool $light = false): string
{
    if ($s['logo']) {
        return '<img src="' . e($s['logo']) . '" alt="' . e($s['name1'] . $s['name_accent'] . $s['name2']) . '" class="h-9 w-auto' . ($light ? ' brightness-0 invert' : '') . '" />';
    }
    $mark = '<svg viewBox="0 0 32 32" class="h-7 w-7" aria-hidden="true"><path d="M20 5 9 16l11 11" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/><path d="M28 9 21 16l7 7" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" opacity=".6"/></svg>';
    return '<span class="flex items-center gap-1.5 text-xl font-extrabold tracking-tight ' . ($light ? 'text-white' : 'text-slate-900') . '">'
        . '<span class="' . ($light ? 'text-white' : 'text-brand') . '">' . $mark . '</span>'
        . '<span>' . e($s['name1']) . '<span class="' . ($light ? 'text-emerald-300' : 'text-brand') . '">' . e($s['name_accent']) . '</span>' . e($s['name2']) . '</span></span>';
}

$nav = array_filter([
    'Home' => '#top',
    'Services' => $c['services']['show'] ? '#services' : '',
    'How It Works' => $c['how']['show'] ? '#how' : '',
    'Pricing' => $c['pricing']['show'] ? '#pricing' : '',
    'FAQ' => $c['faq']['show'] ? '#faq' : '',
    'Contact' => '#contact',
]);
$socials = array_filter(['linkedin' => $ft['linkedin'], 'twitter' => $ft['twitter'], 'facebook' => $ft['facebook'], 'instagram' => $ft['instagram'], 'youtube' => $ft['youtube']]);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($s['seo_title']) ?></title>
  <meta name="description" content="<?= e($s['seo_description']) ?>" />
  <meta property="og:title" content="<?= e($s['seo_title']) ?>" />
  <meta property="og:description" content="<?= e($s['seo_description']) ?>" />
  <?php if ($s['favicon']): ?><link rel="icon" href="<?= e($s['favicon']) ?>" /><?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/app.css?v=<?= @filemtime(__DIR__ . '/assets/app.css') ?>" />
  <style>:root { --brand: <?= $rgb($c1) ?>; --brand2: <?= $rgb($c2) ?>; }</style>
</head>
<body id="top" class="bg-white font-sans text-slate-600 antialiased">

  <!-- NAV -->
  <header class="sticky top-0 z-30 border-b border-slate-100 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-5">
      <a href="#top"><?= logo($s) ?></a>
      <nav class="hidden items-center gap-7 text-sm font-medium text-slate-700 lg:flex">
        <?php foreach ($nav as $label => $href): ?><a href="<?= $href ?>" class="hover:text-brand"><?= $label ?></a><?php endforeach; ?>
      </nav>
      <div class="flex items-center gap-2">
        <a href="#contact" class="hidden items-center gap-2 rounded-full bg-brand px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 sm:inline-flex"><?= e($s['nav_button']) ?> <?= icon('arrow', 'h-4 w-4') ?></a>
        <button id="menuBtn" class="rounded-lg p-2 text-slate-700 lg:hidden" aria-label="Menu"><svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>
      </div>
    </div>
    <nav id="mobileNav" class="hidden border-t border-slate-100 bg-white px-5 py-3 lg:hidden">
      <?php foreach ($nav as $label => $href): ?><a href="<?= $href ?>" class="block py-2 font-medium text-slate-700"><?= $label ?></a><?php endforeach; ?>
    </nav>
  </header>

  <?php if ($h['show']): ?>
  <!-- HERO -->
  <section class="relative overflow-hidden bg-gradient-to-br from-white via-white to-cream">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-14 md:py-20 lg:grid-cols-2">
      <div>
        <?php if ($h['badge']): ?>
          <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm">
            <svg viewBox="0 0 24 24" class="h-4 w-4"><path fill="#4285F4" d="M22.5 12.3c0-.8-.1-1.5-.2-2.2H12v4.2h5.9a5 5 0 0 1-2.2 3.3v2.7h3.6c2-1.9 3.2-4.7 3.2-8"/><path fill="#34A853" d="M12 23c3 0 5.5-1 7.3-2.7l-3.6-2.7c-1 .7-2.2 1.1-3.7 1.1-2.9 0-5.3-1.9-6.2-4.5H2.1V17A11 11 0 0 0 12 23"/><path fill="#FBBC05" d="M5.8 14.2a6.6 6.6 0 0 1 0-4.3V7.1H2.1a11 11 0 0 0 0 9.9z"/><path fill="#EA4335" d="M12 5.4c1.6 0 3.1.6 4.2 1.7l3.2-3.2A11 11 0 0 0 2.1 7.1l3.7 2.8C6.7 7.3 9.1 5.4 12 5.4"/></svg>
            <?= e($h['badge']) ?>
          </span>
        <?php endif; ?>
        <h1 class="mt-5 text-4xl font-extrabold leading-[1.1] tracking-tight text-slate-900 md:text-5xl">
          <?= e($h['title_before']) ?> <span class="text-brand"><?= e($h['title_highlight']) ?></span> <?= e($h['title_after']) ?>
        </h1>
        <p class="mt-5 max-w-lg text-base leading-relaxed text-slate-600 md:text-lg"><?= e($h['subtitle']) ?></p>
        <div class="mt-8 flex flex-wrap gap-3">
          <?php if ($h['button1']): ?><a href="#contact" class="inline-flex items-center gap-2 rounded-lg bg-brand px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand/20 transition hover:-translate-y-0.5"><?= e($h['button1']) ?> <?= icon('arrow', 'h-4 w-4') ?></a><?php endif; ?>
          <?php if ($h['button2']): ?><a href="#pricing" class="rounded-lg border border-slate-300 bg-white px-6 py-3.5 text-sm font-semibold text-slate-800 transition hover:-translate-y-0.5 hover:border-brand hover:text-brand"><?= e($h['button2']) ?></a><?php endif; ?>
        </div>
        <?php if ($h['stats']): ?>
        <div class="mt-10 flex flex-wrap gap-x-8 gap-y-4">
          <?php foreach ($h['stats'] as $st): ?>
            <div class="flex items-center gap-3">
              <span class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-700"><?= icon($st['icon'] ?? 'globe', 'h-5 w-5') ?></span>
              <div><b class="block text-lg leading-tight text-slate-900"><?= e($st['value']) ?></b><span class="text-xs text-slate-500"><?= e($st['label']) ?></span></div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="relative">
        <?php if ($h['image']): ?>
          <img src="<?= e($h['image']) ?>" alt="" class="w-full rounded-3xl object-cover shadow-2xl shadow-slate-900/10" />
        <?php else: ?>
          <!-- Illustrated laptop (replace with your own photo from Admin → Website Content → Hero) -->
          <div class="relative mx-auto max-w-md pt-6">
            <div class="absolute -left-6 bottom-10 h-40 w-40 rounded-full bg-emerald-100 blur-2xl"></div>
            <div class="relative rounded-t-2xl border-[10px] border-slate-800 bg-slate-800 shadow-2xl">
              <div class="overflow-hidden rounded-md bg-white">
                <div class="flex items-center gap-1 border-b bg-slate-50 px-3 py-2"><i class="h-2 w-2 rounded-full bg-red-400"></i><i class="h-2 w-2 rounded-full bg-amber-400"></i><i class="h-2 w-2 rounded-full bg-emerald-400"></i><span class="ml-2 h-2 w-24 rounded bg-slate-200"></span></div>
                <div class="p-4">
                  <div class="rounded-lg bg-brand p-4 text-white">
                    <p class="text-xl font-extrabold leading-tight"><?= e($h['banner_text']) ?></p>
                    <span class="mt-2 inline-block rounded bg-brand-2 px-2 py-0.5 text-[10px] font-semibold">Learn More</span>
                  </div>
                  <div class="mt-3 grid grid-cols-3 gap-2"><span class="h-2 rounded bg-slate-200"></span><span class="h-2 rounded bg-slate-200"></span><span class="h-2 rounded bg-slate-100"></span></div>
                  <svg viewBox="0 0 200 60" class="mt-3 w-full text-brand"><path d="M0 50 C30 45 40 30 70 35 S110 20 130 25 170 8 200 5" fill="none" stroke="currentColor" stroke-width="3"/><path d="M0 50 C30 45 40 30 70 35 S110 20 130 25 170 8 200 5 V60 H0z" fill="currentColor" opacity=".08"/></svg>
                </div>
              </div>
            </div>
            <div class="mx-auto h-3 w-[110%] -translate-x-[4.5%] rounded-b-xl bg-slate-300"></div>
          </div>
        <?php endif; ?>
        <?php if ($h['float_value']): ?>
          <div class="absolute -top-2 right-0 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-xl md:-right-4">
            <div><b class="block text-lg text-slate-900"><?= e($h['float_value']) ?></b><span class="text-xs text-slate-500"><?= e($h['float_label']) ?></span></div>
            <span class="text-brand"><?= icon('trending', 'h-8 w-8') ?></span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['services']['show']): $sv = $c['services']; ?>
  <!-- SERVICES -->
  <section id="services" class="scroll-mt-16 py-20">
    <div class="mx-auto max-w-6xl px-5">
      <div class="mx-auto mb-12 max-w-2xl text-center">
        <?= eyebrow($sv['eyebrow']) ?>
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl"><?= e($sv['title']) ?></h2>
        <p class="mt-3 text-slate-500"><?= e($sv['subtitle']) ?></p>
      </div>
      <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($sv['items'] as $it): ?>
          <div class="group rounded-2xl border border-slate-200/80 bg-white p-7 transition hover:-translate-y-1 hover:border-brand/30 hover:shadow-xl hover:shadow-slate-900/5">
            <span class="grid h-12 w-12 place-items-center rounded-xl bg-emerald-50 text-brand"><?= icon($it['icon'] ?? 'star') ?></span>
            <h3 class="mt-5 text-lg font-bold text-slate-900"><?= e($it['title']) ?></h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-500"><?= e($it['text']) ?></p>
            <?php if ($sv['link_text']): ?><a href="#contact" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand"><?= e($sv['link_text']) ?> <?= icon('arrow', 'h-4 w-4 transition group-hover:translate-x-1') ?></a><?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['how']['show']): $hw = $c['how']; $n = count($hw['items']); ?>
  <!-- HOW IT WORKS -->
  <section id="how" class="scroll-mt-16 bg-cream py-20">
    <div class="mx-auto max-w-6xl px-5">
      <div class="mx-auto mb-14 max-w-2xl text-center">
        <?= eyebrow($hw['eyebrow']) ?>
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl"><?= e($hw['title']) ?></h2>
        <p class="mt-3 text-slate-500"><?= e($hw['subtitle']) ?></p>
      </div>
      <div class="grid gap-10 sm:grid-cols-2 lg:flex lg:items-start lg:justify-between lg:gap-4">
        <?php foreach ($hw['items'] as $i => $it): ?>
          <div class="relative flex-1 text-center">
            <div class="relative mx-auto mb-4 grid h-16 w-16 place-items-center rounded-2xl bg-white text-slate-800 shadow-sm">
              <?= icon($it['icon'] ?? 'star', 'h-7 w-7') ?>
              <span class="absolute -left-3 -top-3 grid h-7 w-7 place-items-center rounded-full bg-brand text-xs font-bold text-white"><?= $i + 1 ?></span>
            </div>
            <h4 class="font-bold text-slate-900"><?= e($it['title']) ?></h4>
            <p class="mx-auto mt-1 max-w-[200px] text-sm text-slate-500"><?= e($it['text']) ?></p>
          </div>
          <?php if ($i < $n - 1): ?><span class="mt-6 hidden text-slate-400 lg:block"><?= icon('chevron', 'h-5 w-5') ?></span><?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['pricing']['show']): $pr = $c['pricing']; ?>
  <!-- PRICING -->
  <section id="pricing" class="scroll-mt-16 py-20">
    <div class="mx-auto max-w-6xl px-5">
      <div class="mx-auto mb-12 max-w-2xl text-center">
        <?= eyebrow($pr['eyebrow']) ?>
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl"><?= e($pr['title']) ?></h2>
        <p class="mt-3 text-slate-500"><?= e($pr['subtitle']) ?></p>
      </div>
      <div class="grid items-stretch gap-6 md:grid-cols-3">
        <?php foreach ($pr['items'] as $p): $f = !empty($p['featured']); ?>
          <div class="relative flex flex-col rounded-2xl bg-white p-7 <?= $f ? 'border-2 border-brand shadow-2xl shadow-brand/10' : 'border border-slate-200' ?>">
            <?php if ($f): ?><span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-md bg-brand px-3 py-1 text-xs font-semibold text-white">Most Popular</span><?php endif; ?>
            <h3 class="text-xl font-bold text-slate-900"><?= e($p['name']) ?></h3>
            <?php if (!empty($p['tagline'])): ?><p class="text-sm text-slate-500"><?= e($p['tagline']) ?></p><?php endif; ?>
            <div class="my-5 flex items-baseline gap-1"><span class="text-3xl font-extrabold text-slate-900"><?= e($p['price']) ?></span><span class="text-sm text-slate-500"><?= e($p['suffix']) ?></span></div>
            <ul class="mb-7 flex-1 space-y-2.5 text-sm text-slate-700">
              <?php foreach (lines($p['features']) as $feat): ?><li class="flex items-start gap-2"><span class="mt-0.5 text-brand"><?= icon('tick', 'h-4 w-4') ?></span><?= e($feat) ?></li><?php endforeach; ?>
            </ul>
            <a href="#contact" data-service="<?= e($p['service']) ?>" class="<?= $f ? 'bg-brand text-white hover:opacity-90' : 'border border-slate-300 text-slate-800 hover:border-brand hover:text-brand' ?> rounded-lg py-3 text-center text-sm font-semibold transition"><?= e($p['button']) ?></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['why']['show']): $wy = $c['why']; ?>
  <!-- WHY US -->
  <section class="relative overflow-hidden bg-cream">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-5 py-20 lg:grid-cols-2">
      <div>
        <?= eyebrow($wy['eyebrow']) ?>
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl"><?= e($wy['title']) ?></h2>
        <ul class="mt-7 space-y-3.5">
          <?php foreach (lines($wy['points']) as $pt): ?>
            <li class="flex items-center gap-3 text-slate-700"><span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-brand text-white"><?= icon('tick', 'h-3.5 w-3.5') ?></span><?= e($pt) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="relative min-h-[320px]">
        <div class="absolute -right-10 top-6 h-72 w-72 rounded-full bg-brand/90 lg:-right-24"></div>
        <?php if ($wy['image']): ?>
          <img src="<?= e($wy['image']) ?>" alt="" class="relative ml-auto h-[380px] w-full max-w-sm rounded-3xl object-cover shadow-2xl" />
        <?php else: ?>
          <div class="relative ml-auto grid h-[380px] w-full max-w-sm place-items-center rounded-3xl bg-gradient-to-br from-emerald-50 to-white text-brand/30 shadow-2xl">
            <?= icon('users', 'h-24 w-24') ?>
          </div>
        <?php endif; ?>
        <?php if ($wy['testimonial']): ?>
          <div class="relative -mt-28 max-w-xs rounded-2xl bg-white p-5 shadow-2xl lg:absolute lg:bottom-10 lg:left-0 lg:mt-0">
            <p class="text-sm italic leading-relaxed text-slate-700">“<?= e($wy['testimonial']) ?>”</p>
            <p class="mt-3 text-sm font-bold text-brand">— <?= e($wy['testimonial_author']) ?></p>
            <div class="mt-2 flex gap-0.5 text-amber-400">
              <?php for ($i = 0; $i < max(0, min(5, (int) $wy['rating'])); $i++): ?><svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/></svg><?php endfor; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($c['faq']['show']): $fq = $c['faq']; ?>
  <!-- FAQ -->
  <section id="faq" class="scroll-mt-16 py-20">
    <div class="mx-auto max-w-6xl px-5">
      <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div><?= eyebrow($fq['eyebrow']) ?><h2 class="text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl"><?= e($fq['title']) ?></h2></div>
        <?php if ($fq['link_text'] && $fq['link_url']): ?><a href="<?= e($fq['link_url']) ?>" class="inline-flex items-center gap-1 border-b-2 border-brand pb-0.5 text-sm font-semibold text-brand"><?= e($fq['link_text']) ?> <?= icon('arrow', 'h-4 w-4') ?></a><?php endif; ?>
      </div>
      <div class="max-w-3xl space-y-3">
        <?php foreach ($fq['items'] as $i => $q): ?>
          <details class="rounded-xl border border-slate-200 bg-white px-5 py-4 open:bg-slate-50" <?= $i === 0 ? 'open' : '' ?>>
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-bold text-slate-900"><?= e($q['q']) ?><span class="faq-icon text-slate-500 transition"><?= icon('plus', 'h-4 w-4') ?></span></summary>
            <p class="mt-2 text-sm leading-relaxed text-slate-500"><?= e($q['a']) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- CONTACT -->
  <section id="contact" class="relative scroll-mt-16 overflow-hidden bg-brand py-20 text-emerald-50">
    <div class="pointer-events-none absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-white/5"></div>
    <div class="pointer-events-none absolute -right-20 -top-20 h-80 w-80 rounded-full bg-white/5"></div>
    <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-5 lg:grid-cols-2">
      <div>
        <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-white md:text-4xl"><?= e($ct['title_before']) ?> <span class="text-emerald-300"><?= e($ct['title_highlight']) ?></span> <?= e($ct['title_after']) ?></h2>
        <p class="mt-5 max-w-md text-emerald-100/90"><?= e($ct['text']) ?></p>
        <ul class="mt-7 space-y-3 text-sm">
          <?php $pi = ['clock', 'lock', 'chat']; foreach (lines($ct['points']) as $i => $pt): ?>
            <li class="flex items-center gap-3"><span class="text-amber-300"><?= icon($pi[$i % 3], 'h-5 w-5') ?></span><?= e($pt) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <form id="leadForm" class="rounded-2xl bg-white p-6 text-slate-700 shadow-2xl md:p-8" novalidate>
        <h3 class="mb-5 text-lg font-bold text-slate-900"><?= e($ct['form_title']) ?></h3>
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="text-xs font-semibold text-slate-800">Full Name *<input name="name" required maxlength="100" placeholder="Your name" class="<?= $input ?>" /></label>
          <label class="text-xs font-semibold text-slate-800">Email *<input name="email" type="email" required maxlength="150" placeholder="you@example.com" class="<?= $input ?>" /></label>
          <label class="text-xs font-semibold text-slate-800">Phone / WhatsApp<input name="phone" maxlength="30" placeholder="+91 98765 43210" class="<?= $input ?>" /></label>
          <label class="text-xs font-semibold text-slate-800">Your Website<input name="website" maxlength="200" placeholder="https://yourwebsite.com" class="<?= $input ?>" /></label>
          <label class="text-xs font-semibold text-slate-800">Service *
            <select name="service" id="serviceSelect" class="<?= $input ?>">
              <?php foreach (lines($ct['service_options']) as $o): ?><option><?= e($o) ?></option><?php endforeach; ?>
            </select>
          </label>
          <label class="text-xs font-semibold text-slate-800">Budget
            <select name="budget" class="<?= $input ?>">
              <option value="">Select budget</option>
              <?php foreach (lines($ct['budget_options']) as $o): ?><option><?= e($o) ?></option><?php endforeach; ?>
            </select>
          </label>
        </div>
        <label class="mt-4 block text-xs font-semibold text-slate-800">Message<textarea name="message" rows="3" maxlength="2000" placeholder="Tell us your niche, number of posts, banner size etc." class="<?= $input ?>"></textarea></label>
        <input type="text" name="company_website_hp" class="absolute -left-[9999px]" tabindex="-1" autocomplete="off" />
        <button type="submit" id="submitBtn" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand py-3.5 text-sm font-semibold text-white transition hover:opacity-90 disabled:cursor-wait disabled:opacity-70"><span><?= e($ct['button']) ?></span> <?= icon('arrow', 'h-4 w-4') ?></button>
        <p id="formMsg" class="mt-3 text-sm font-medium" role="status"></p>
      </form>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-[#0b1f1a] text-slate-400">
    <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-4">
      <div class="md:col-span-2">
        <?= logo($s, true) ?>
        <p class="mt-4 max-w-sm text-sm leading-relaxed"><?= e($ft['description']) ?></p>
        <div class="mt-4 space-y-1.5 text-sm">
          <?php if ($ft['email']): ?><a href="mailto:<?= e($ft['email']) ?>" class="flex items-center gap-2 hover:text-white"><?= icon('mail', 'h-4 w-4') ?><?= e($ft['email']) ?></a><?php endif; ?>
          <?php if ($ft['phone']): ?><a href="tel:<?= e(preg_replace('/[^\d+]/', '', $ft['phone'])) ?>" class="flex items-center gap-2 hover:text-white"><?= icon('phone', 'h-4 w-4') ?><?= e($ft['phone']) ?></a><?php endif; ?>
        </div>
      </div>
      <div>
        <h4 class="mb-4 text-sm font-semibold text-white">Quick Links</h4>
        <div class="grid grid-cols-2 gap-2 text-sm">
          <?php foreach ($nav as $label => $href): ?><a href="<?= $href ?>" class="hover:text-white"><?= $label ?></a><?php endforeach; ?>
        </div>
      </div>
      <?php if ($socials || $wa): ?>
      <div>
        <h4 class="mb-4 text-sm font-semibold text-white">Follow Us</h4>
        <div class="flex gap-3">
          <?php foreach ($socials as $net => $url): ?>
            <a href="<?= e($url) ?>" target="_blank" rel="noopener" aria-label="<?= $net ?>" class="grid h-9 w-9 place-items-center rounded-full bg-white/10 text-white transition hover:bg-brand"><?= icon($net, 'h-4 w-4') ?></a>
          <?php endforeach; ?>
          <?php if ($wa): ?><a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" aria-label="WhatsApp" class="grid h-9 w-9 place-items-center rounded-full bg-white/10 text-white transition hover:bg-brand"><?= icon('chat', 'h-4 w-4') ?></a><?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="border-t border-white/10">
      <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-5 py-5 text-xs">
        <span><?= e(str_replace('{year}', date('Y'), $ft['text'])) ?></span>
        <span class="flex gap-5">
          <?php if ($ft['privacy_url']): ?><a href="<?= e($ft['privacy_url']) ?>" class="hover:text-white">Privacy Policy</a><?php endif; ?>
          <?php if ($ft['terms_url']): ?><a href="<?= e($ft['terms_url']) ?>" class="hover:text-white">Terms &amp; Conditions</a><?php endif; ?>
        </span>
      </div>
    </div>
  </footer>

  <?php if ($wa): ?>
    <a href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"
       class="fixed bottom-5 right-5 z-30 grid h-14 w-14 place-items-center rounded-full bg-[#25D366] text-white shadow-xl transition hover:scale-105">
      <svg viewBox="0 0 24 24" class="h-7 w-7 fill-current"><path d="M17.5 14.4c-.3-.1-1.8-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6l.4-.5.3-.5c.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.2-.3-.3-.6-.4M12 21.8a9.9 9.9 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A9.8 9.8 0 0 1 12 2.2a9.8 9.8 0 0 1 9.8 9.8 9.8 9.8 0 0 1-9.8 9.8M20.5 3.5A11.8 11.8 0 0 0 12 0C5.5 0 .2 5.3.2 11.9c0 2.1.5 4.1 1.6 5.9L.1 24l6.3-1.7a11.9 11.9 0 0 0 5.7 1.4c6.5 0 11.9-5.3 11.9-11.9 0-3.2-1.2-6.2-3.5-8.4"/></svg>
    </a>
  <?php endif; ?>

  <script>
    document.getElementById('menuBtn').addEventListener('click', () => document.getElementById('mobileNav').classList.toggle('hidden'));
    document.querySelectorAll('#mobileNav a').forEach((a) => a.addEventListener('click', () => document.getElementById('mobileNav').classList.add('hidden')));
    document.querySelectorAll('[data-service]').forEach((b) =>
      b.addEventListener('click', () => {
        const sel = document.getElementById('serviceSelect');
        if ([...sel.options].some((o) => o.value === b.dataset.service)) sel.value = b.dataset.service;
      })
    );

    const form = document.getElementById('leadForm');
    const msg = document.getElementById('formMsg');
    const btn = document.getElementById('submitBtn');
    const btnLabel = btn.querySelector('span');
    const btnText = btnLabel.textContent;
    const successText = <?= json_encode($ct['success'], JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?>;
    const show = (text, ok) => { msg.textContent = text; msg.className = 'mt-3 text-sm font-medium ' + (ok ? 'text-emerald-600' : 'text-red-600'); };

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(form);
      if (!fd.get('name').trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fd.get('email'))) {
        return show('Please enter your name and a valid email.', false);
      }
      btn.disabled = true;
      btnLabel.textContent = 'Submitting...';
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
        btnLabel.textContent = btnText;
      }
    });
  </script>
</body>
</html>
