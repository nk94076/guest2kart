<?php
declare(strict_types=1);

// Website content: defaults + overrides saved from the admin "Website Content" editor.

function content_defaults(): array
{
    return [
        'site' => [
            'name1' => 'Guest', 'name_accent' => '2', 'name2' => 'Kart',
            'logo' => '', 'favicon' => '',
            'color1' => '#4f46e5', 'color2' => '#9333ea',
            'seo_title' => 'Guest2Kart – Guest Posting & Banner Ads on 100K+ Traffic Websites',
            'seo_description' => 'Publish guest posts and place banner ads on Google-approved, high-authority websites with 100K+ monthly traffic. Fast, affordable, guaranteed placement.',
            'nav_button' => 'Get Started',
        ],
        'hero' => [
            'show' => true,
            'badge' => '✅ Google-Approved • 100K+ Monthly Traffic',
            'title_before' => 'Get Your', 'title_highlight' => 'Guest Posts & Banners', 'title_after' => 'Live on High-Traffic Websites',
            'subtitle' => 'We publish your articles and display your banner ads on genuine, high-authority websites with 100K+ real monthly visitors. Boost your SEO, brand visibility and sales — fast.',
            'button1' => 'Book Your Placement', 'button2' => 'View Pricing',
            'image' => '',
            'banner_text' => 'YOUR BANNER HERE',
            'card_post' => '📝 Your Guest Post', 'card_post_sub' => 'with do-follow backlink',
            'card_stat1' => '📈 120K visits/mo', 'card_stat2' => '⭐ DA 62',
            'stats' => [
                ['value' => '500+', 'label' => 'Websites'],
                ['value' => '10K+', 'label' => 'Posts Published'],
                ['value' => 'DA 50+', 'label' => 'Authority'],
            ],
        ],
        'services' => [
            'show' => true,
            'title' => 'What We Offer',
            'subtitle' => 'Everything you need to grow your online presence on trusted websites.',
            'items' => [
                ['icon' => '📝', 'title' => 'Guest Posting', 'text' => 'Send us your article (or let us write it) and we publish it on niche-relevant, high-DA websites with permanent do-follow backlinks.'],
                ['icon' => '🖼️', 'title' => 'Banner Advertising', 'text' => 'Place your banner in header, sidebar or in-content spots on websites with 100K+ monthly traffic and get real eyeballs on your brand.'],
                ['icon' => '🔗', 'title' => 'Link Insertion', 'text' => 'Get your link added into existing, already-ranking articles for faster SEO results and instant authority.'],
                ['icon' => '✍️', 'title' => 'Content Writing', 'text' => 'SEO-optimised, plagiarism-free articles written by expert writers tailored to your niche and audience.'],
                ['icon' => '📊', 'title' => 'Traffic Reports', 'text' => 'Get live URLs and verified traffic/authority metrics of every website your content goes on.'],
                ['icon' => '🌍', 'title' => 'All Niches', 'text' => 'Tech, Finance, Health, Travel, Business, Lifestyle, Education, Crypto & more — we have the right site for you.'],
            ],
        ],
        'how' => [
            'show' => true,
            'title' => 'How It Works',
            'subtitle' => 'Simple 4-step process — from enquiry to live post.',
            'items' => [
                ['title' => 'Submit Request', 'text' => 'Fill the form below with your website & requirement.'],
                ['title' => 'Choose Websites', 'text' => 'We share a list of approved 100K+ traffic websites.'],
                ['title' => 'Send Post / Banner', 'text' => 'Share your article or banner creative with us.'],
                ['title' => 'Go Live 🚀', 'text' => 'Get the live link & report within 24–72 hours.'],
            ],
        ],
        'pricing' => [
            'show' => true,
            'title' => 'Simple Pricing',
            'subtitle' => 'Transparent packages. Custom plans available on request.',
            'items' => [
                ['name' => 'Starter', 'price' => 'Basic', 'suffix' => 'plan', 'featured' => false, 'service' => 'Guest Post', 'button' => 'Enquire Now',
                 'features' => "1 Guest Post\nDA 30+ Website\nDo-follow Backlink\nPermanent Post"],
                ['name' => 'Growth', 'price' => 'Pro', 'suffix' => 'plan', 'featured' => true, 'service' => 'Guest Post + Banner', 'button' => 'Enquire Now',
                 'features' => "5 Guest Posts\n100K+ Traffic Websites\n1 Month Banner Ad\nContent Writing Included"],
                ['name' => 'Banner Ads', 'price' => 'Custom', 'suffix' => 'plan', 'featured' => false, 'service' => 'Banner Ad', 'button' => 'Enquire Now',
                 'features' => "Header / Sidebar / In-content\n100K+ Monthly Visitors\nWeekly / Monthly Slots\nPerformance Report"],
            ],
        ],
        'why' => [
            'show' => true,
            'title' => 'Why Choose Guest2Kart?',
            'points' => "Only Google-approved, genuine websites — no PBNs\nReal organic traffic of 100K+ visitors / month\nFast turnaround: live in 24–72 hours\nPermanent posts & do-follow links\nReplacement guarantee if a post is removed\nDedicated support on Email & WhatsApp",
            'testimonial' => 'Got our banner and 5 guest posts live within 2 days. Traffic and leads both went up in the first month. Highly recommended!',
            'testimonial_author' => 'Rahul S., E-commerce Founder',
        ],
        'faq' => [
            'show' => true,
            'title' => 'Frequently Asked Questions',
            'items' => [
                ['q' => 'Are the websites Google-approved?', 'a' => 'Yes. All websites are indexed on Google, have real organic traffic and many are Google News / AdSense approved.'],
                ['q' => 'How long does it take to get published?', 'a' => 'Usually 24–72 hours after the content / banner is approved.'],
                ['q' => 'Can you write the article for me?', 'a' => 'Yes, our expert writers can create SEO-optimised content for your niche.'],
                ['q' => 'Are the links do-follow and permanent?', 'a' => 'Yes, guest posts come with permanent do-follow backlinks unless you request otherwise.'],
                ['q' => 'What banner sizes do you support?', 'a' => 'Standard sizes like 728×90, 300×250, 160×600 and 320×50 (mobile). Custom sizes on request.'],
            ],
        ],
        'contact' => [
            'title_before' => "Let's Get Your Brand on", 'title_highlight' => '100K+ Traffic', 'title_after' => 'Websites',
            'text' => 'Fill in the form and our team will get back to you with the best websites & pricing for your niche.',
            'points' => "⚡ Response within 24 hours\n🔒 Your details are 100% safe\n💬 Free consultation",
            'service_options' => "Guest Post\nBanner Ad\nGuest Post + Banner\nLink Insertion\nContent Writing",
            'budget_options' => "Under \$100\n\$100 – \$500\n\$500 – \$1000\n\$1000+",
            'button' => 'Submit Request',
            'success' => '🎉 Thank you! We have received your request. We will contact you soon — please check your email.',
        ],
        'footer' => [
            'text' => '© {year} Guest2Kart. All rights reserved.',
            'email' => '', 'phone' => '', 'whatsapp' => '',
        ],
        'email' => [
            'subject' => 'Thank you for contacting Guest2Kart - We will contact you soon',
            'body' => "Hi {name},\n\nThank you for reaching out to Guest2Kart!\n\nWe have received your request for {service}. Our team will review it and we will contact you soon.\n\nRegards,\nTeam Guest2Kart",
        ],
    ];
}

function content_file(): string
{
    global $config;
    return rtrim($config['data_dir'] ?? (__DIR__ . '/../data'), '/') . '/content.json';
}

// Saved values override defaults; lists ("items"/"stats") are replaced whole.
function content_merge(array $defaults, array $saved): array
{
    foreach ($saved as $k => $v) {
        if (is_array($v) && isset($defaults[$k]) && is_array($defaults[$k]) && !array_is_list($defaults[$k])) {
            $defaults[$k] = content_merge($defaults[$k], $v);
        } elseif (array_key_exists($k, $defaults)) {
            $defaults[$k] = $v;
        }
    }
    return $defaults;
}

function content(): array
{
    static $c = null;
    if ($c === null) {
        $saved = is_file(content_file()) ? json_decode((string) file_get_contents(content_file()), true) : null;
        $c = content_merge(content_defaults(), is_array($saved) ? $saved : []);
    }
    return $c;
}

function content_save(array $c): void
{
    $file = content_file();
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0775, true);
    }
    file_put_contents($file . '.tmp', json_encode($c, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    rename($file . '.tmp', $file);
}

function lines(string $s): array
{
    return array_values(array_filter(array_map('trim', explode("\n", $s)), 'strlen'));
}
