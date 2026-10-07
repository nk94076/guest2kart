<?php
declare(strict_types=1);

// Website content: defaults + overrides saved from the admin "Website Content" editor.

function content_defaults(): array
{
    return [
        'site' => [
            'name1' => 'Guest', 'name_accent' => '2', 'name2' => 'Kart',
            'logo' => '', 'favicon' => '',
            'color1' => '#0f5c46', 'color2' => '#16a34a',
            'seo_title' => 'Guest2Kart – Guest Posting & Banner Ads on 100K+ Traffic Websites',
            'seo_description' => 'Publish guest posts and place banner ads on Google-approved, high-authority websites with 100K+ monthly traffic. Fast, affordable, guaranteed placement.',
            'nav_button' => 'Get Started',
        ],
        'hero' => [
            'show' => true,
            'badge' => 'Google-Approved Websites | 100K+ Monthly Traffic',
            'title_before' => 'Get Your', 'title_highlight' => 'Guest Posts & Banners on', 'title_after' => 'High-Traffic Websites',
            'subtitle' => 'Publish your articles, showcase your brand and reach real audiences on genuine, high-authority websites. Boost your SEO, brand visibility and traffic — the right way.',
            'button1' => 'Book Your Placement', 'button2' => 'View Pricing',
            'image' => '',
            'banner_text' => 'Your Brand Here',
            'float_value' => '+132%', 'float_label' => 'Organic Traffic',
            'stats' => [
                ['icon' => 'globe', 'value' => '500+', 'label' => 'Websites'],
                ['icon' => 'file', 'value' => '10K+', 'label' => 'Posts Published'],
                ['icon' => 'chart', 'value' => 'DA 50+', 'label' => 'Authority Sites'],
            ],
        ],
        'services' => [
            'show' => true,
            'eyebrow' => 'Our Services',
            'title' => 'Everything You Need to Grow Your Online Presence',
            'subtitle' => 'High-quality placements on real websites, managed by experts.',
            'link_text' => 'Learn More',
            'items' => [
                ['icon' => 'post', 'title' => 'Guest Posting', 'text' => 'Publish your articles on niche-relevant, high-DA websites with do-follow backlinks.'],
                ['icon' => 'image', 'title' => 'Banner Advertising', 'text' => 'Place your banner in header, sidebar or in-content sections on 100K+ traffic websites.'],
                ['icon' => 'link', 'title' => 'Link Insertion', 'text' => 'Add your link to existing, high-performing articles for instant SEO boost.'],
                ['icon' => 'edit', 'title' => 'Content Writing', 'text' => 'SEO-optimised, plagiarism-free articles written by expert writers.'],
                ['icon' => 'chart', 'title' => 'Traffic Reports', 'text' => 'Get live URLs and verified traffic/authority metrics for every placement.'],
                ['icon' => 'grid', 'title' => 'All Niches', 'text' => 'Tech, Finance, Health, Travel, Business, Lifestyle, Education, Crypto & more.'],
            ],
        ],
        'how' => [
            'show' => true,
            'eyebrow' => 'How It Works',
            'title' => 'Get Live in 4 Simple Steps',
            'subtitle' => 'From enquiry to live post — quick, transparent and hassle-free.',
            'items' => [
                ['icon' => 'file', 'title' => 'Submit Request', 'text' => 'Fill the form with your website & requirement.'],
                ['icon' => 'link', 'title' => 'Choose Websites', 'text' => 'We share a list of genuine, high-traffic websites.'],
                ['icon' => 'upload', 'title' => 'Send Post / Banner', 'text' => 'Share your article or banner creative with us.'],
                ['icon' => 'rocket', 'title' => 'Go Live', 'text' => 'Get live link & report within 24–72 hours.'],
            ],
        ],
        'pricing' => [
            'show' => true,
            'eyebrow' => 'Pricing Plans',
            'title' => 'Simple & Transparent Pricing',
            'subtitle' => 'Choose the right plan for your brand. Custom plans available on request.',
            'items' => [
                ['name' => 'Basic', 'tagline' => 'Get Started', 'price' => '₹1,999', 'suffix' => '/post', 'featured' => false, 'service' => 'Guest Post', 'button' => 'Get Started',
                 'features' => "1 Guest Post\nDA 30+ Website\nDo-follow Backlink\nPermanent Post"],
                ['name' => 'Pro', 'tagline' => 'For Growing Brands', 'price' => '₹4,999', 'suffix' => '/5 posts', 'featured' => true, 'service' => 'Guest Post + Banner', 'button' => 'Get Started',
                 'features' => "5 Guest Posts\n100K+ Traffic Websites\n1 Month Banner Ad\nContent Writing Included"],
                ['name' => 'Custom', 'tagline' => 'For Agencies & Enterprises', 'price' => 'Custom Quote', 'suffix' => '', 'featured' => false, 'service' => 'Banner Ad', 'button' => 'Contact Us',
                 'features' => "Header / Sidebar / In-content\n100K+ Monthly Visitors\nWeekly / Monthly Slots\nPerformance Report"],
            ],
        ],
        'why' => [
            'show' => true,
            'eyebrow' => 'Why Guest2Kart?',
            'title' => 'A Trusted Platform for Real Results',
            'points' => "Only Google-approved, genuine websites\nReal organic traffic (no bots)\nFast turnaround time (24–72 hours)\nPermanent posts & do-follow links\nReplacement guarantee if post is removed\nDedicated support on Email & WhatsApp",
            'image' => '',
            'testimonial' => 'Got our banner and 5 guest posts live within 2 days. Traffic and leads both went up in the first month. Highly recommended!',
            'testimonial_author' => 'Rahul S., E-commerce Founder',
            'rating' => '5',
        ],
        'faq' => [
            'show' => true,
            'eyebrow' => 'FAQ',
            'title' => 'Frequently Asked Questions',
            'link_text' => '', 'link_url' => '',
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
            'points' => "Response within 24 hours\nYour details are 100% safe\nFree consultation",
            'form_title' => 'Send Us a Request',
            'service_options' => "Guest Post\nBanner Ad\nGuest Post + Banner\nLink Insertion\nContent Writing",
            'budget_options' => "Under ₹2,000\n₹2,000 – ₹5,000\n₹5,000 – ₹20,000\n₹20,000+",
            'button' => 'Submit Request',
            'success' => 'Thank you! We have received your request. We will contact you soon — please check your email.',
        ],
        'footer' => [
            'description' => 'High-quality guest posts, banner placements and content solutions on real high-traffic websites.',
            'text' => '© {year} Guest2Kart. All rights reserved.',
            'email' => '', 'phone' => '', 'whatsapp' => '',
            'linkedin' => '', 'twitter' => '', 'facebook' => '', 'instagram' => '', 'youtube' => '',
            'privacy_url' => '', 'terms_url' => '',
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
