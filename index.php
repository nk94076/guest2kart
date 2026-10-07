<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guest2Kart – Guest Posting & Banner Ads on 100K+ Traffic Websites</title>
  <meta name="description" content="Publish guest posts and place banner ads on Google-approved, high-authority websites with 100K+ monthly traffic. Fast, affordable, guaranteed placement." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Poppins', 'ui-sans-serif', 'system-ui'] },
          colors: { brand: { DEFAULT: '#4f46e5', 2: '#9333ea' } },
        },
      },
    };
  </script>
  <style>
    .grad-text { background: linear-gradient(90deg, #4f46e5, #9333ea); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .grad-bg { background: linear-gradient(90deg, #4f46e5, #9333ea); }
  </style>
</head>
<body class="font-sans text-slate-600 antialiased">

  <!-- NAV -->
  <header class="sticky top-0 z-20 border-b border-slate-100 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5">
      <a href="#" class="text-2xl font-extrabold text-slate-900">Guest<span class="text-brand">2</span>Kart</a>
      <nav class="hidden gap-8 font-medium md:flex">
        <a href="#services" class="hover:text-brand">Services</a>
        <a href="#how" class="hover:text-brand">How it Works</a>
        <a href="#pricing" class="hover:text-brand">Pricing</a>
        <a href="#faq" class="hover:text-brand">FAQ</a>
      </nav>
      <a href="#contact" class="grad-bg rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow hover:shadow-lg">Get Started</a>
    </div>
  </header>

  <!-- HERO -->
  <section class="bg-[radial-gradient(circle_at_80%_10%,#ede9fe,transparent_50%),radial-gradient(circle_at_0%_90%,#e0e7ff,transparent_45%)] py-16 md:py-24">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 md:grid-cols-2">
      <div>
        <span class="inline-block rounded-full bg-indigo-50 px-4 py-1.5 text-sm font-semibold text-brand">✅ Google-Approved • 100K+ Monthly Traffic</span>
        <h1 class="mt-5 text-4xl font-extrabold leading-tight text-slate-900 md:text-5xl">
          Get Your <span class="grad-text">Guest Posts &amp; Banners</span> Live on High-Traffic Websites
        </h1>
        <p class="mt-5 text-lg text-slate-500">We publish your articles and display your banner ads on genuine, high-authority websites with <b class="text-slate-700">100K+ real monthly visitors</b>. Boost your SEO, brand visibility and sales — fast.</p>
        <div class="mt-8 flex flex-wrap gap-4">
          <a href="#contact" class="grad-bg rounded-xl px-7 py-3.5 font-semibold text-white shadow-lg transition hover:-translate-y-0.5">Book Your Placement</a>
          <a href="#pricing" class="rounded-xl border-2 border-brand px-7 py-3 font-semibold text-brand transition hover:-translate-y-0.5">View Pricing</a>
        </div>
        <div class="mt-10 flex gap-10">
          <div><b class="block text-2xl text-slate-900">500+</b><span class="text-sm">Websites</span></div>
          <div><b class="block text-2xl text-slate-900">10K+</b><span class="text-sm">Posts Published</span></div>
          <div><b class="block text-2xl text-slate-900">DA 50+</b><span class="text-sm">Authority</span></div>
        </div>
      </div>
      <div class="rounded-2xl bg-white p-5 shadow-2xl shadow-slate-900/10">
        <div class="flex gap-1.5"><i class="h-2.5 w-2.5 rounded-full bg-red-400"></i><i class="h-2.5 w-2.5 rounded-full bg-amber-400"></i><i class="h-2.5 w-2.5 rounded-full bg-emerald-400"></i></div>
        <div class="grad-bg my-4 rounded-lg py-6 text-center font-bold tracking-widest text-white">YOUR BANNER HERE</div>
        <div class="my-2.5 h-2.5 w-4/5 rounded bg-slate-100"></div>
        <div class="my-2.5 h-2.5 w-11/12 rounded bg-slate-100"></div>
        <div class="my-2.5 h-2.5 w-3/5 rounded bg-slate-100"></div>
        <div class="mt-4 rounded-lg border-2 border-dashed border-indigo-200 p-4 font-semibold text-slate-900">📝 Your Guest Post<br /><small class="font-normal text-slate-500">with do-follow backlink</small></div>
        <div class="mt-4 flex justify-between text-sm font-semibold text-brand"><span>📈 120K visits/mo</span><span>⭐ DA 62</span></div>
      </div>
    </div>
  </section>

  <!-- SERVICES -->
  <section id="services" class="py-20">
    <div class="mx-auto max-w-6xl px-5">
      <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl">What We Offer</h2>
      <p class="mb-12 mt-2 text-center text-slate-500">Everything you need to grow your online presence on trusted websites.</p>
      <div class="grid gap-6 md:grid-cols-3">
        <?php
        $services = [
            ['📝', 'Guest Posting', 'Send us your article (or let us write it) and we publish it on niche-relevant, high-DA websites with permanent do-follow backlinks.'],
            ['🖼️', 'Banner Advertising', 'Place your banner in header, sidebar or in-content spots on websites with 100K+ monthly traffic and get real eyeballs on your brand.'],
            ['🔗', 'Link Insertion', 'Get your link added into existing, already-ranking articles for faster SEO results and instant authority.'],
            ['✍️', 'Content Writing', 'SEO-optimised, plagiarism-free articles written by expert writers tailored to your niche and audience.'],
            ['📊', 'Traffic Reports', 'Get live URLs and verified traffic/authority metrics of every website your content goes on.'],
            ['🌍', 'All Niches', 'Tech, Finance, Health, Travel, Business, Lifestyle, Education, Crypto & more — we have the right site for you.'],
        ];
        foreach ($services as [$icon, $title, $text]): ?>
          <div class="rounded-2xl border border-slate-100 bg-white p-7 transition hover:-translate-y-1 hover:shadow-xl">
            <div class="mb-3 text-4xl"><?= $icon ?></div>
            <h3 class="mb-1.5 text-lg font-semibold text-slate-900"><?= $title ?></h3>
            <p><?= $text ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section id="how" class="bg-indigo-50/50 py-20">
    <div class="mx-auto max-w-6xl px-5">
      <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl">How It Works</h2>
      <p class="mb-12 mt-2 text-center text-slate-500">Simple 4-step process — from enquiry to live post.</p>
      <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <?php
        $steps = [
            ['Submit Request', 'Fill the form below with your website & requirement.'],
            ['Choose Websites', 'We share a list of approved 100K+ traffic websites.'],
            ['Send Post / Banner', 'Share your article or banner creative with us.'],
            ['Go Live 🚀', 'Get the live link & report within 24–72 hours.'],
        ];
        foreach ($steps as $i => [$title, $text]): ?>
          <div class="rounded-2xl bg-white p-7 text-center">
            <span class="grad-bg mb-3 inline-grid h-12 w-12 place-items-center rounded-full font-bold text-white"><?= $i + 1 ?></span>
            <h4 class="font-semibold text-slate-900"><?= $title ?></h4>
            <p class="text-sm text-slate-500"><?= $text ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- PRICING -->
  <section id="pricing" class="py-20">
    <div class="mx-auto max-w-6xl px-5">
      <h2 class="text-center text-3xl font-bold text-slate-900 md:text-4xl">Simple Pricing</h2>
      <p class="mb-12 mt-2 text-center text-slate-500">Transparent packages. Custom plans available on request.</p>
      <div class="grid items-stretch gap-6 md:grid-cols-3">
        <?php
        $plans = [
            ['Starter', 'Basic', 'Guest Post', false, ['1 Guest Post', 'DA 30+ Website', 'Do-follow Backlink', 'Permanent Post']],
            ['Growth', 'Pro', 'Guest Post + Banner', true, ['5 Guest Posts', '100K+ Traffic Websites', '1 Month Banner Ad', 'Content Writing Included']],
            ['Banner Ads', 'Custom', 'Banner Ad', false, ['Header / Sidebar / In-content', '100K+ Monthly Visitors', 'Weekly / Monthly Slots', 'Performance Report']],
        ];
        foreach ($plans as [$name, $price, $service, $featured, $features]): ?>
          <div class="relative flex flex-col rounded-2xl p-8 text-center <?= $featured ? 'border-2 border-brand shadow-2xl shadow-indigo-500/20 md:scale-105' : 'border border-slate-200' ?>">
            <?php if ($featured): ?><span class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-full bg-brand px-4 py-1 text-xs font-semibold text-white">Most Popular</span><?php endif; ?>
            <h3 class="text-lg font-semibold text-slate-900"><?= $name ?></h3>
            <div class="my-3 text-4xl font-extrabold text-slate-900"><?= $price ?><small class="text-sm font-medium text-slate-500"> plan</small></div>
            <ul class="mb-6 flex-1 space-y-2">
              <?php foreach ($features as $f): ?><li>✔ <?= $f ?></li><?php endforeach; ?>
            </ul>
            <a href="#contact" data-service="<?= $service ?>" class="<?= $featured ? 'grad-bg text-white' : 'border-2 border-brand text-brand' ?> rounded-xl py-3 font-semibold transition hover:-translate-y-0.5">Enquire Now</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- WHY US -->
  <section class="bg-indigo-50/50 py-20">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 md:grid-cols-2">
      <div>
        <h2 class="text-3xl font-bold text-slate-900 md:text-4xl">Why Choose Guest2Kart?</h2>
        <ul class="mt-6 space-y-3 font-medium">
          <li>✅ Only Google-approved, genuine websites — no PBNs</li>
          <li>✅ Real organic traffic of 100K+ visitors / month</li>
          <li>✅ Fast turnaround: live in 24–72 hours</li>
          <li>✅ Permanent posts &amp; do-follow links</li>
          <li>✅ Replacement guarantee if a post is removed</li>
          <li>✅ Dedicated support on Email &amp; WhatsApp</li>
        </ul>
      </div>
      <div class="rounded-2xl bg-white p-8 text-lg italic shadow-xl">
        <p>“Got our banner and 5 guest posts live within 2 days. Traffic and leads both went up in the first month. Highly recommended!”</p>
        <b class="mt-4 block text-base not-italic text-brand">— Rahul S., E-commerce Founder</b>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="py-20">
    <div class="mx-auto max-w-3xl px-5">
      <h2 class="mb-10 text-center text-3xl font-bold text-slate-900 md:text-4xl">Frequently Asked Questions</h2>
      <?php
      $faqs = [
          ['Are the websites Google-approved?', 'Yes. All websites are indexed on Google, have real organic traffic and many are Google News / AdSense approved.'],
          ['How long does it take to get published?', 'Usually 24–72 hours after the content / banner is approved.'],
          ['Can you write the article for me?', 'Yes, our expert writers can create SEO-optimised content for your niche.'],
          ['Are the links do-follow and permanent?', 'Yes, guest posts come with permanent do-follow backlinks unless you request otherwise.'],
          ['What banner sizes do you support?', 'Standard sizes like 728×90, 300×250, 160×600 and 320×50 (mobile). Custom sizes on request.'],
      ];
      foreach ($faqs as [$q, $a]): ?>
        <details class="group mb-3 rounded-xl border border-slate-100 px-5 py-4">
          <summary class="cursor-pointer list-none font-semibold text-slate-900 after:float-right after:content-['+'] group-open:after:content-['−']"><?= $q ?></summary>
          <p class="mt-3 text-slate-500"><?= $a ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- CONTACT FORM -->
  <section id="contact" class="bg-gradient-to-br from-slate-900 to-indigo-950 py-20 text-slate-300">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 md:grid-cols-5">
      <div class="md:col-span-2">
        <h2 class="text-3xl font-bold leading-snug text-white md:text-4xl">Let's Get Your Brand on <span class="bg-gradient-to-r from-indigo-300 to-purple-200 bg-clip-text text-transparent">100K+ Traffic</span> Websites</h2>
        <p class="mt-4">Fill in the form and our team will get back to you with the best websites &amp; pricing for your niche.</p>
        <ul class="mt-6 space-y-2">
          <li>⚡ Response within 24 hours</li>
          <li>🔒 Your details are 100% safe</li>
          <li>💬 Free consultation</li>
        </ul>
      </div>
      <form id="leadForm" class="rounded-2xl bg-white p-7 text-slate-700 md:col-span-3" novalidate>
        <?php $input = 'mt-1.5 block w-full rounded-lg border border-slate-300 px-3.5 py-3 font-normal focus:border-brand focus:outline-none focus:ring-4 focus:ring-indigo-100'; ?>
        <div class="grid gap-4 sm:grid-cols-2">
          <label class="text-sm font-semibold text-slate-900">Full Name *<input name="name" required maxlength="100" placeholder="Your name" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Email *<input name="email" type="email" required maxlength="150" placeholder="you@example.com" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Phone / WhatsApp<input name="phone" maxlength="30" placeholder="+91 98765 43210" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Your Website<input name="website" maxlength="200" placeholder="https://yourwebsite.com" class="<?= $input ?>" /></label>
          <label class="text-sm font-semibold text-slate-900">Service *
            <select name="service" id="serviceSelect" class="<?= $input ?> bg-white">
              <option>Guest Post</option><option>Banner Ad</option><option>Guest Post + Banner</option><option>Link Insertion</option><option>Content Writing</option>
            </select>
          </label>
          <label class="text-sm font-semibold text-slate-900">Budget
            <select name="budget" class="<?= $input ?> bg-white">
              <option value="">Select budget</option><option>Under $100</option><option>$100 – $500</option><option>$500 – $1000</option><option>$1000+</option>
            </select>
          </label>
        </div>
        <label class="mt-4 block text-sm font-semibold text-slate-900">Message<textarea name="message" rows="4" maxlength="2000" placeholder="Tell us your niche, number of posts, banner size etc." class="<?= $input ?>"></textarea></label>
        <input type="text" name="company_website_hp" class="absolute -left-[9999px]" tabindex="-1" autocomplete="off" />
        <button type="submit" id="submitBtn" class="grad-bg mt-5 w-full rounded-xl py-3.5 font-semibold text-white transition hover:shadow-lg disabled:cursor-wait disabled:opacity-70">Submit Request</button>
        <p id="formMsg" class="mt-3 text-sm font-medium" role="status"></p>
      </form>
    </div>
  </section>

  <footer class="bg-slate-950 py-6 text-center text-sm text-slate-400">© <?= date('Y') ?> Guest2Kart. All rights reserved.</footer>

  <script>
    document.querySelectorAll('[data-service]').forEach((b) =>
      b.addEventListener('click', () => (document.getElementById('serviceSelect').value = b.dataset.service))
    );

    const form = document.getElementById('leadForm');
    const msg = document.getElementById('formMsg');
    const btn = document.getElementById('submitBtn');
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
        show('🎉 Thank you! We have received your request. We will contact you soon — please check your email.', true);
      } catch (err) {
        show(err.message || 'Something went wrong. Please try again.', false);
      } finally {
        btn.disabled = false;
        btn.textContent = 'Submit Request';
      }
    });
  </script>
</body>
</html>
