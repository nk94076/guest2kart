<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/content.php';

session_set_cookie_params(['httponly' => true, 'samesite' => 'Strict', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: ./');
    exit;
}

const UPLOAD_TYPES = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/webp' => 'webp', 'image/gif' => 'gif',
                      'image/x-icon' => 'ico', 'image/vnd.microsoft.icon' => 'ico'];
const UPLOAD_FIELDS = ['site.logo', 'site.favicon', 'hero.image'];

// Item templates for repeatable lists: [section, key] => fields
const LISTS = [
    'hero.stats'     => ['value' => '', 'label' => ''],
    'services.items' => ['icon' => '', 'title' => '', 'text' => ''],
    'how.items'      => ['title' => '', 'text' => ''],
    'pricing.items'  => ['name' => '', 'price' => '', 'suffix' => '', 'featured' => false, 'service' => '', 'button' => '', 'features' => ''],
    'faq.items'      => ['q' => '', 'a' => ''],
];

function handle_upload(string $field): ?string
{
    $f = $_FILES['upload']['tmp_name'][$field] ?? '';
    if (!$f || ($_FILES['upload']['error'][$field] ?? 1) !== UPLOAD_ERR_OK) {
        return null;
    }
    if (filesize($f) > 3 * 1024 * 1024) {
        throw new RuntimeException('Image too large (max 3 MB).');
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f);
    if (!isset(UPLOAD_TYPES[$mime])) {
        throw new RuntimeException('Only PNG, JPG, WEBP, GIF or ICO images are allowed.');
    }
    $dir = __DIR__ . '/../uploads';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $name = bin2hex(random_bytes(8)) . '.' . UPLOAD_TYPES[$mime];
    if (!move_uploaded_file($f, "$dir/$name")) {
        throw new RuntimeException('Could not save the uploaded image.');
    }
    return 'uploads/' . $name;
}

$flash = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Invalid request');
    }
    try {
        if (isset($_POST['reset'])) {
            content_save([]);
        } else {
            $old = content();
            $new = [];
            $in = $_POST['c'] ?? [];
            foreach (content_defaults() as $sec => $fields) {
                foreach ($fields as $key => $default) {
                    $path = "$sec.$key";
                    if (isset(LISTS[$path])) {
                        $items = [];
                        foreach ((array) ($in[$sec][$key] ?? []) as $row) {
                            $item = [];
                            foreach (LISTS[$path] as $k => $d) {
                                $item[$k] = is_bool($d) ? !empty($row[$k]) : clip($row[$k] ?? '', 3000);
                            }
                            if (implode('', array_filter($item, 'is_string')) !== '') {
                                $items[] = $item;
                            }
                        }
                        $new[$sec][$key] = $items;
                    } elseif (in_array($path, UPLOAD_FIELDS, true)) {
                        $uploaded = handle_upload($path);
                        $new[$sec][$key] = $uploaded ?? (!empty($in[$sec]["{$key}_remove"]) ? '' : $old[$sec][$key]);
                    } elseif (is_bool($default)) {
                        $new[$sec][$key] = !empty($in[$sec][$key]);
                    } else {
                        $new[$sec][$key] = str_replace("\r\n", "\n", clip($in[$sec][$key] ?? '', 5000));
                    }
                }
            }
            content_save($new);
        }
        $_SESSION['flash'] = 'Saved! Your website is updated.';
        header('Location: content.php');
        exit;
    } catch (Throwable $err) {
        $error = $err->getMessage();
    }
}

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
$c = content();
$csrf = e($_SESSION['csrf']);

// ---------- field helpers ----------
function fname(string $sec, string $key): string { return "c[$sec][$key]"; }

function text(array $c, string $sec, string $key, string $label, string $hint = ''): void
{ ?>
  <label class="block text-sm font-semibold text-slate-700"><?= e($label) ?>
    <input name="<?= fname($sec, $key) ?>" value="<?= e($c[$sec][$key]) ?>" class="mt-1 w-full rounded-lg border px-3 py-2 font-normal" />
    <?php if ($hint): ?><span class="text-xs font-normal text-slate-400"><?= e($hint) ?></span><?php endif; ?>
  </label>
<?php }

function area(array $c, string $sec, string $key, string $label, string $hint = '', int $rows = 3): void
{ ?>
  <label class="block text-sm font-semibold text-slate-700 md:col-span-2"><?= e($label) ?>
    <textarea name="<?= fname($sec, $key) ?>" rows="<?= $rows ?>" class="mt-1 w-full rounded-lg border px-3 py-2 font-normal"><?= e($c[$sec][$key]) ?></textarea>
    <?php if ($hint): ?><span class="text-xs font-normal text-slate-400"><?= e($hint) ?></span><?php endif; ?>
  </label>
<?php }

function toggle(array $c, string $sec): void
{ ?>
  <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 md:col-span-2">
    <input type="checkbox" name="<?= fname($sec, 'show') ?>" value="1" <?= $c[$sec]['show'] ? 'checked' : '' ?> class="h-4 w-4" /> Show this section on website
  </label>
<?php }

function image(array $c, string $sec, string $key, string $label, string $hint): void
{ $v = $c[$sec][$key]; ?>
  <div class="text-sm font-semibold text-slate-700">
    <?= e($label) ?>
    <div class="mt-1 flex items-center gap-3 rounded-lg border p-3">
      <?php if ($v): ?><img src="../<?= e($v) ?>" alt="" class="h-12 max-w-[140px] rounded bg-slate-100 object-contain" /><?php endif; ?>
      <div class="flex-1">
        <input type="file" name="upload[<?= "$sec.$key" ?>]" accept="image/png,image/jpeg,image/webp,image/gif,image/x-icon" class="text-xs font-normal" />
        <?php if ($v): ?><label class="mt-1 flex items-center gap-1 text-xs font-normal text-red-600"><input type="checkbox" name="<?= fname($sec, $key . '_remove') ?>" value="1" /> Remove</label><?php endif; ?>
      </div>
    </div>
    <span class="text-xs font-normal text-slate-400"><?= e($hint) ?></span>
  </div>
<?php }

// Repeatable list editor
function repeater(array $c, string $sec, string $key, string $label, array $fields, string $addText): void
{
    $base = fname($sec, $key);
    $render = function ($i, array $row) use ($base, $fields) { ?>
      <div class="rep-item relative rounded-xl border bg-slate-50 p-4">
        <button type="button" onclick="this.closest('.rep-item').remove()" class="absolute right-3 top-3 text-xs font-semibold text-red-600">✕ Remove</button>
        <div class="grid gap-3 pr-16 md:grid-cols-2">
          <?php foreach ($fields as $k => [$lbl, $type]): $n = "{$base}[$i][$k]"; $val = $row[$k] ?? ''; ?>
            <?php if ($type === 'area'): ?>
              <label class="block text-xs font-semibold text-slate-600 md:col-span-2"><?= e($lbl) ?><textarea name="<?= $n ?>" rows="3" class="mt-1 w-full rounded border px-2 py-1.5 text-sm font-normal"><?= e((string) $val) ?></textarea></label>
            <?php elseif ($type === 'check'): ?>
              <label class="flex items-center gap-2 text-xs font-semibold text-slate-600"><input type="checkbox" name="<?= $n ?>" value="1" <?= $val ? 'checked' : '' ?> /> <?= e($lbl) ?></label>
            <?php else: ?>
              <label class="block text-xs font-semibold text-slate-600"><?= e($lbl) ?><input name="<?= $n ?>" value="<?= e((string) $val) ?>" class="mt-1 w-full rounded border px-2 py-1.5 text-sm font-normal" /></label>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php };
    ?>
    <div class="md:col-span-2">
      <div class="mb-2 text-sm font-semibold text-slate-700"><?= e($label) ?></div>
      <div class="rep-list space-y-3" data-next="<?= count($c[$sec][$key]) ?>">
        <?php foreach (array_values($c[$sec][$key]) as $i => $row) { $render($i, $row); } ?>
      </div>
      <template><?php $render('__i__', []); ?></template>
      <button type="button" onclick="addItem(this)" class="mt-3 rounded-lg border-2 border-dashed border-indigo-300 px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50">+ <?= e($addText) ?></button>
    </div>
<?php }

function section_start(string $id, string $title, string $desc = ''): void
{ ?>
  <section id="<?= $id ?>" class="scroll-mt-24 rounded-2xl bg-white p-6 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900"><?= e($title) ?></h2>
    <?php if ($desc): ?><p class="mb-4 text-sm text-slate-500"><?= e($desc) ?></p><?php else: ?><div class="mb-4"></div><?php endif; ?>
    <div class="grid gap-4 md:grid-cols-2">
<?php }

function section_end(): void { echo '</div></section>'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guest2Kart Admin – Website Content</title><meta name="robots" content="noindex" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
  <header class="sticky top-0 z-20 flex flex-wrap items-center justify-between gap-3 bg-slate-900 px-6 py-3 text-white">
    <h1 class="text-xl font-bold">Guest2Kart Admin</h1>
    <nav class="flex flex-wrap gap-2 text-sm">
      <a href="./" class="rounded-lg px-4 py-2 hover:bg-slate-700">📥 Leads</a>
      <a href="content.php" class="rounded-lg bg-slate-700 px-4 py-2">✏️ Website Content</a>
      <a href="../" target="_blank" class="rounded-lg px-4 py-2 hover:bg-slate-700">🌐 View Site</a>
      <a href="./?action=logout" class="rounded-lg px-4 py-2 hover:bg-slate-700">Logout</a>
    </nav>
  </header>

  <div class="mx-auto flex max-w-7xl gap-6 p-6">
    <aside class="sticky top-20 hidden h-fit w-48 shrink-0 space-y-1 text-sm lg:block">
      <?php foreach (['brand' => '🎨 Logo & Branding', 'hero' => '🏠 Hero / Top', 'services' => '🧩 Services', 'how' => '🪜 How it Works',
                      'pricing' => '💰 Pricing', 'why' => '⭐ Why Us', 'faq' => '❓ FAQ', 'contact' => '📝 Contact Form',
                      'footer' => '📞 Footer & Contact', 'email' => '✉️ Auto Email'] as $id => $t): ?>
        <a href="#<?= $id ?>" class="block rounded-lg px-3 py-2 hover:bg-white"><?= $t ?></a>
      <?php endforeach; ?>
    </aside>

    <main class="min-w-0 flex-1">
      <?php if ($flash): ?><div class="mb-4 rounded-xl bg-emerald-50 p-4 font-semibold text-emerald-700">✅ <?= e($flash) ?> <a href="../" target="_blank" class="underline">View site →</a></div><?php endif; ?>
      <?php if ($error): ?><div class="mb-4 rounded-xl bg-red-50 p-4 font-semibold text-red-700">⚠️ <?= e($error) ?></div><?php endif; ?>

      <form method="post" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf" value="<?= $csrf ?>" />

        <?php section_start('brand', 'Logo & Branding', 'Upload a logo image, or leave it empty to show the text logo.'); ?>
          <?php image($c, 'site', 'logo', 'Logo', 'PNG/JPG/WEBP, about 300×80 px. Shown at 40px height.'); ?>
          <?php image($c, 'site', 'favicon', 'Favicon (browser tab icon)', 'Square PNG or ICO, e.g. 64×64 px.'); ?>
          <?php text($c, 'site', 'name1', 'Text logo – part 1', 'Used when no logo image'); ?>
          <?php text($c, 'site', 'name_accent', 'Text logo – coloured part'); ?>
          <?php text($c, 'site', 'name2', 'Text logo – part 2'); ?>
          <?php text($c, 'site', 'nav_button', 'Top menu button text'); ?>
          <label class="block text-sm font-semibold text-slate-700">Main colour
            <input type="color" name="<?= fname('site', 'color1') ?>" value="<?= e($c['site']['color1']) ?>" class="mt-1 block h-10 w-24 rounded border" /></label>
          <label class="block text-sm font-semibold text-slate-700">Second (gradient) colour
            <input type="color" name="<?= fname('site', 'color2') ?>" value="<?= e($c['site']['color2']) ?>" class="mt-1 block h-10 w-24 rounded border" /></label>
          <?php text($c, 'site', 'seo_title', 'SEO title (Google & browser tab)'); ?>
          <?php area($c, 'site', 'seo_description', 'SEO description (Google)', '', 2); ?>
        <?php section_end(); ?>

        <?php section_start('hero', 'Hero / Top Section'); ?>
          <?php toggle($c, 'hero'); ?>
          <?php text($c, 'hero', 'badge', 'Small badge above heading'); ?>
          <?php text($c, 'hero', 'title_before', 'Heading – start'); ?>
          <?php text($c, 'hero', 'title_highlight', 'Heading – coloured part'); ?>
          <?php text($c, 'hero', 'title_after', 'Heading – end'); ?>
          <?php area($c, 'hero', 'subtitle', 'Sub text'); ?>
          <?php text($c, 'hero', 'button1', 'Button 1 text', 'Leave empty to hide'); ?>
          <?php text($c, 'hero', 'button2', 'Button 2 text', 'Leave empty to hide'); ?>
          <?php image($c, 'hero', 'image', 'Right side image (optional)', 'Upload to replace the demo card on the right.'); ?>
          <?php text($c, 'hero', 'banner_text', 'Demo card – banner text'); ?>
          <?php text($c, 'hero', 'card_post', 'Demo card – post title'); ?>
          <?php text($c, 'hero', 'card_post_sub', 'Demo card – post sub text'); ?>
          <?php text($c, 'hero', 'card_stat1', 'Demo card – stat 1'); ?>
          <?php text($c, 'hero', 'card_stat2', 'Demo card – stat 2'); ?>
          <?php repeater($c, 'hero', 'stats', 'Numbers under buttons', ['value' => ['Number', 'text'], 'label' => ['Label', 'text']], 'Add number'); ?>
        <?php section_end(); ?>

        <?php section_start('services', 'Services'); ?>
          <?php toggle($c, 'services'); ?>
          <?php text($c, 'services', 'title', 'Title'); ?>
          <?php text($c, 'services', 'subtitle', 'Sub title'); ?>
          <?php repeater($c, 'services', 'items', 'Service cards', ['icon' => ['Icon (emoji)', 'text'], 'title' => ['Title', 'text'], 'text' => ['Description', 'area']], 'Add service'); ?>
        <?php section_end(); ?>

        <?php section_start('how', 'How it Works'); ?>
          <?php toggle($c, 'how'); ?>
          <?php text($c, 'how', 'title', 'Title'); ?>
          <?php text($c, 'how', 'subtitle', 'Sub title'); ?>
          <?php repeater($c, 'how', 'items', 'Steps', ['title' => ['Step title', 'text'], 'text' => ['Step text', 'text']], 'Add step'); ?>
        <?php section_end(); ?>

        <?php section_start('pricing', 'Pricing'); ?>
          <?php toggle($c, 'pricing'); ?>
          <?php text($c, 'pricing', 'title', 'Title'); ?>
          <?php text($c, 'pricing', 'subtitle', 'Sub title'); ?>
          <?php repeater($c, 'pricing', 'items', 'Plans', [
              'name' => ['Plan name', 'text'], 'price' => ['Price (e.g. ₹999 or $49)', 'text'], 'suffix' => ['After price (e.g. / post)', 'text'],
              'button' => ['Button text', 'text'], 'service' => ['Form service to preselect', 'text'], 'featured' => ['Highlight as "Most Popular"', 'check'],
              'features' => ['Features (one per line)', 'area'],
          ], 'Add plan'); ?>
        <?php section_end(); ?>

        <?php section_start('why', 'Why Choose Us + Testimonial'); ?>
          <?php toggle($c, 'why'); ?>
          <?php text($c, 'why', 'title', 'Title'); ?>
          <?php area($c, 'why', 'points', 'Points (one per line)', '', 6); ?>
          <?php area($c, 'why', 'testimonial', 'Testimonial text', 'Leave empty to hide'); ?>
          <?php text($c, 'why', 'testimonial_author', 'Testimonial author'); ?>
        <?php section_end(); ?>

        <?php section_start('faq', 'FAQ'); ?>
          <?php toggle($c, 'faq'); ?>
          <?php text($c, 'faq', 'title', 'Title'); ?>
          <?php repeater($c, 'faq', 'items', 'Questions', ['q' => ['Question', 'text'], 'a' => ['Answer', 'area']], 'Add question'); ?>
        <?php section_end(); ?>

        <?php section_start('contact', 'Contact Form Section'); ?>
          <?php text($c, 'contact', 'title_before', 'Heading – start'); ?>
          <?php text($c, 'contact', 'title_highlight', 'Heading – coloured part'); ?>
          <?php text($c, 'contact', 'title_after', 'Heading – end'); ?>
          <?php area($c, 'contact', 'text', 'Text'); ?>
          <?php area($c, 'contact', 'points', 'Points (one per line)'); ?>
          <?php area($c, 'contact', 'service_options', 'Service dropdown options (one per line)', '', 5); ?>
          <?php area($c, 'contact', 'budget_options', 'Budget dropdown options (one per line)', '', 4); ?>
          <?php text($c, 'contact', 'button', 'Submit button text'); ?>
          <?php area($c, 'contact', 'success', 'Message shown after submit', '', 2); ?>
        <?php section_end(); ?>

        <?php section_start('footer', 'Footer & Contact Details', 'Filled details show in the footer. WhatsApp also adds a floating chat button.'); ?>
          <?php text($c, 'footer', 'email', 'Email'); ?>
          <?php text($c, 'footer', 'phone', 'Phone'); ?>
          <?php text($c, 'footer', 'whatsapp', 'WhatsApp number', 'With country code, e.g. 919876543210'); ?>
          <?php text($c, 'footer', 'text', 'Copyright text', '{year} = current year'); ?>
        <?php section_end(); ?>

        <?php section_start('email', 'Auto Email to Customer', 'Sent to everyone who fills the form. Use {name}, {service}, {email}.'); ?>
          <?php text($c, 'email', 'subject', 'Subject'); ?>
          <div></div>
          <?php area($c, 'email', 'body', 'Message', '', 8); ?>
        <?php section_end(); ?>

        <div class="sticky bottom-0 -mx-6 flex flex-wrap items-center justify-between gap-3 border-t bg-white/95 px-6 py-4 backdrop-blur">
          <button name="reset" value="1" formnovalidate onclick="return confirm('Reset ALL website content to default? Uploaded images will be unlinked.')" class="text-sm font-semibold text-red-600">↺ Reset to default</button>
          <button class="rounded-xl bg-indigo-600 px-8 py-3 font-semibold text-white shadow hover:bg-indigo-700">💾 Save Changes</button>
        </div>
      </form>
    </main>
  </div>

  <script>
    function addItem(btn) {
      const wrap = btn.parentElement;
      const list = wrap.querySelector('.rep-list');
      const i = Number(list.dataset.next);
      list.dataset.next = i + 1;
      const html = wrap.querySelector('template').innerHTML.replaceAll('__i__', i);
      list.insertAdjacentHTML('beforeend', html);
    }
  </script>
</body>
</html>
