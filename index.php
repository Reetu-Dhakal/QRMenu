<?php
/**
 * HamroMenu — Cloud Restaurant Management Platform
 * Complete Landing Page with Contact Section
 */

 $brand = "HamroMenu";
 $tagline = "Digitize Your Restaurant. Delight Your Customers.";
 $year = date("Y");

// Contact form handling
 $formSent = false;
 $formError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = htmlspecialchars(trim($_POST['contact_name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['contact_email'] ?? ''));
    $restaurant = htmlspecialchars(trim($_POST['contact_restaurant'] ?? ''));
    $message = htmlspecialchars(trim($_POST['contact_message'] ?? ''));

    if (empty($name) || empty($email) || empty($message)) {
        $formError = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formError = 'Please enter a valid email address.';
    } else {
        // In production, send email or save to database here
        // mail('hello@hamromenu.com', 'Contact Form', "Name: $name\nEmail: $email\nRestaurant: $restaurant\nMessage: $message");
        $formSent = true;
    }
}

 $badges = [
    ['solar:shield-check-bold', 'No credit card required'],
    ['solar:clock-circle-bold', 'Setup in 5 minutes'],
    ['solar:cloud-bold', 'Cloud based'],
    ['solar:lock-bold', 'Secure & reliable'],
];

 $logos = [
    ['solar:mountains-bold', 'Everest Cafe'],
    ['solar:chef-hat-bold', 'Himalayan Kitchen'],
    ['solar:cup-hot-bold', 'Momo House'],
    ['solar:home-bold', 'Terrace Kitchen'],
    ['solar:buildings-bold', 'Urban Bite'],
    ['solar:plate-bold', 'Newa Kitchen'],
];

 $features = [
    ['solar:qr-code-bold', 'from-brand-400 to-brand-600', 'QR Digital Menu', 'Create beautiful digital menus. Customers scan a QR code and see your full menu instantly on their phone.'],
    ['solar:cart-large-2-bold', 'from-ok-400 to-ok-600', 'Smart Ordering', 'Let customers place orders from their table. Orders go straight to the kitchen — no miscommunication.'],
    ['solar:users-group-rounded-bold', 'from-blue-400 to-blue-600', 'Staff Management', 'Role-based access for waiters, kitchen staff, and managers. Everyone stays in sync.'],
    ['solar:chart-2-bold', 'from-violet-400 to-violet-600', 'Sales & Analytics', 'Track revenue, popular items, peak hours, and trends with real-time dashboards.'],
    ['solar:armchair-bold', 'from-amber-400 to-amber-600', 'Table Management', 'Visual table layout with live status. See occupied, reserved, or available at a glance.'],
    ['solar:monitor-smartphone-bold', 'from-rose-400 to-rose-600', 'Cloud Dashboard', 'Access everything from anywhere. Works on any device, any browser, anytime.'],
];

 $steps = [
    ['Register', 'Sign up in seconds'],
    ['Create Menu', 'Add items & photos'],
    ['Generate QR', 'One per table'],
    ['Customers Scan', 'Browse & order'],
    ['Orders to Kitchen', 'Instant delivery'],
    ['Grow', 'Scale up'],
];

 $dashStats = [
    ['solar:wallet-money-bold', 'brand-50', 'brand-500', '₨ 1,28,450', "This Month's Revenue", '12.5%', true],
    ['solar:bag-check-bold', 'ok-50', 'ok-500', '3,842', 'Total Orders', '8.2%', true],
    ['solar:armchair-bold', 'blue-50', 'blue-500', '18', 'Active Tables', 'of 24', false],
    ['solar:users-group-rounded-bold', 'violet-50', 'violet-500', '9', 'Staff Online', 'of 12', false],
];

 $chartBars = [
    ['Mon', 50, 'bg-brand-100'],
    ['Tue', 68, 'bg-brand-200'],
    ['Wed', 42, 'bg-brand-200'],
    ['Thu', 82, 'bg-brand-300'],
    ['Fri', 72, 'bg-brand-400'],
    ['Sat', 92, 'bg-brand-500'],
    ['Sun', 78, 'bg-brand-400'],
];

 $feedbacks = [
    ['AS', 'bg-brand-100', 'text-brand-600', 'Anita Sharma', '"Love the QR menu!"', 5],
    ['RP', 'bg-blue-100', 'text-blue-600', 'Raj Pradhan', '"Quick service."', 4],
    ['ST', 'bg-ok-100', 'text-ok-600', 'Sita Thapa', '"So easy to use!"', 5],
];

 $benefits = [
    ['solar:document-medicine-bold', 'brand-50', 'brand-500', 'No Paper Menus', 'Save on printing, stay current'],
    ['solar:refresh-bold', 'ok-50', 'ok-500', 'Instant Updates', 'Change prices in real-time'],
    ['solar:bolt-bold', 'blue-50', 'blue-500', 'Faster Service', 'Orders reach kitchen instantly'],
    ['solar:qr-code-bold', 'violet-50', 'violet-500', 'QR Ordering', 'Customers order from their seat'],
    ['solar:chart-2-bold', 'amber-50', 'amber-500', 'Sales Reports', 'Data to make smart decisions'],
    ['solar:shield-check-bold', 'rose-50', 'rose-500', 'Secure Cloud', 'Bank-level data protection'],
    ['solar:users-group-rounded-bold', 'teal-50', 'teal-500', 'Multi-User Access', 'Your whole team, one platform'],
    ['solar:graph-up-bold', 'indigo-50', 'indigo-500', 'Restaurant Analytics', 'Understand trends, optimize'],
];

 $withoutHM = ['Printed menus that get dirty & outdated', 'Waiters manually taking orders', 'No sales tracking or analytics', 'Kitchen confusion & slow service'];
 $withHM = ['Beautiful digital menus, always current', 'Customers order directly via QR', 'Real-time sales dashboards & reports', 'Streamlined kitchen operations'];

 $nums = [
    ['500+', 'Restaurants', 'brand'],
    ['120K+', 'Orders Processed', 'ok'],
    ['98%', 'Satisfaction', 'blue'],
    ['99.9%', 'Uptime', 'violet'],
];

 $plans = [
    [
        'name' => 'Starter', 'price' => 'Free', 'period' => '', 'desc' => 'For small cafes',
        'features' => ['QR Digital Menu', '50 Menu Items', 'Basic Dashboard', '1 User Account'],
        'btn' => 'Get Started Free', 'style' => 'outline', 'badge' => '',
    ],
    [
        'name' => 'Professional', 'price' => '₨ 2,999', 'period' => '/month', 'desc' => 'For growing restaurants',
        'features' => ['Unlimited Menu Items', 'Smart QR Ordering', 'Sales Reports & Analytics', 'Staff Management', 'Table Management', 'Up to 10 Users'],
        'btn' => 'Start Free Trial', 'style' => 'primary', 'badge' => 'Most Popular',
    ],
    [
        'name' => 'Enterprise', 'price' => 'Custom', 'period' => '', 'desc' => 'For multi-branch operations',
        'features' => ['Multi-Branch Support', 'API Access', 'Premium Support', 'Custom Integrations', 'Unlimited Users', 'Dedicated Manager'],
        'btn' => 'Contact Sales', 'style' => 'outline', 'badge' => '',
    ],
];

 $reviews = [
    ['RP', 'from-brand-400 to-brand-600', 'Rajesh Pradhan', 'Owner, Himalayan Kitchen', '"We stopped printing menus entirely. Order accuracy improved by 40%. Customers love the experience."', 5],
    ['ST', 'from-ok-400 to-ok-600', 'Sita Tamang', 'Manager, Everest Cafe', '"The analytics dashboard is a game changer. I can see what sells, when it sells, and plan accordingly."', 5],
    ['BG', 'from-blue-400 to-blue-600', 'Bikash Gurung', 'Owner, Momo House', '"We were live in 30 minutes. Staff adapted quickly and customers genuinely appreciate the modern feel."', 4],
];

 $faqs = [
    ['Do customers need to download an app?', 'No. They scan the QR code with their phone camera and the menu opens in the browser. Works on any device, no app needed.'],
    ['Can I update my menu anytime?', 'Yes. Add, edit, or remove items, change prices, update photos — all from your dashboard. Changes appear instantly for customers.'],
    ['Can multiple staff use the system?', 'Absolutely. Add team members with role-based access. Waiters, kitchen staff, and managers each get appropriate permissions.'],
    ['How does QR ordering work?', 'Each table gets a unique QR code. Customers scan it, browse the menu, add items to cart, and place orders that go straight to the kitchen display.'],
    ['Is the platform secure?', 'Yes. We use industry-standard encryption, secure cloud infrastructure, and daily backups. Your data is protected with bank-level security.'],
    ['What happens if the internet goes down?', 'Orders placed before the outage are saved. Once connectivity returns, everything syncs automatically. No data is ever lost.'],
    ['Can I try it before paying?', 'Of course. The Starter plan is completely free with no time limit. Upgrade only when you need more features.'],
];

 $contactInfo = [
    ['solar:map-point-bold', 'brand-50', 'brand-500', 'Office', 'Putalisadak, Kathmandu, Nepal'],
    ['solar:letter-bold', 'ok-50', 'ok-500', 'Email', 'hello@hamromenu.com'],
    ['solar:phone-bold', 'blue-50', 'blue-500', 'Phone', '+977 9801-234567'],
    ['solar:clock-circle-bold', 'violet-50', 'violet-500', 'Hours', 'Sun–Fri, 10 AM – 6 PM'],
];

 $footerLinks = [
    'Product' => [
        ['Features', '#features'],
        ['Pricing', '#pricing'],
        ['Documentation', '#'],
        ['Integrations', '#'],
        ['Changelog', '#'],
    ],
    'Company' => [
        ['About Us', '#'],
        ['Careers', '#'],
        ['Blog', '#'],
        ['Contact', '#contact'],
    ],
    'Legal' => [
        ['Privacy Policy', '#'],
        ['Terms of Service', '#'],
        ['Cookie Policy', '#'],
        ['Security', '#'],
    ],
];

 $socials = [
    ['simple-icons:facebook', 'Facebook', 'https://facebook.com'],
    ['simple-icons:instagram', 'Instagram', 'https://instagram.com'],
    ['simple-icons:linkedin', 'LinkedIn', 'https://linkedin.com'],
    ['simple-icons:x', 'X (Twitter)', 'https://x.com'],
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $brand ?> — <?= $tagline ?></title>
    <meta name="description" content="Manage QR menus, orders, tables, staff, and analytics from one simple cloud platform built for restaurants.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: { 50:'#FFF7ED',100:'#FFEDD5',200:'#FED7AA',300:'#FDBA74',400:'#FB923C',500:'#F97316',600:'#EA580C',700:'#C2410C' },
                        ok: { 50:'#F0FDF4',100:'#DCFCE7',500:'#22C55E',600:'#16A34A' },
                        ink: '#0F172A',
                        mute: '#64748B',
                        line: '#E2E8F0',
                        page: '#FAFBFC',
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #FAFBFC; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }

        .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 1.5px; background: #F97316; transition: width .25s ease; }
        .nav-link:hover::after { width: 100%; }

        .faq-body { max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .25s ease; }
        .faq-body.open { max-height: 200px; }
        .faq-icon { transition: transform .25s ease; }
        .faq-icon.flip { transform: rotate(180deg); }

        .card-lift { transition: transform .25s ease, box-shadow .25s ease; }
        .card-lift:hover { transform: translateY(-3px); box-shadow: 0 12px 32px -8px rgba(0,0,0,.08); }

        @keyframes gentle-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .float-1 { animation: gentle-float 5s ease-in-out infinite; }
        .float-2 { animation: gentle-float 5s ease-in-out 1.5s infinite; }

        @keyframes bar-up { from{transform:scaleY(0)} to{transform:scaleY(1)} }
        .bar-grow { transform-origin: bottom; animation: bar-up .8s ease-out forwards; }

        .logo-gray { filter: grayscale(1); opacity: .4; transition: all .25s ease; }
        .logo-gray:hover { filter: grayscale(0); opacity: .8; }

        .laptop-shell { background: linear-gradient(160deg,#e4e4e7,#d4d4d8); border-radius: 14px 14px 0 0; padding: 6px; }
        .laptop-notch { height: 10px; background: linear-gradient(160deg,#e4e4e7,#d4d4d8); border-radius: 0 0 6px 6px; margin: 0 -16px; position: relative; }
        .laptop-notch::before { content:''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background: #d4d4d8; border-radius: 0 0 3px 3px; }

        .phone-shell { background: #1c1c1e; border-radius: 28px; padding: 6px; box-shadow: 0 24px 48px -12px rgba(0,0,0,.18); }

        .pricing-highlight { border-color: #FDBA74; box-shadow: 0 0 0 1px #FED7AA, 0 12px 32px -8px rgba(249,115,22,.12); }
        .pricing-highlight:hover { box-shadow: 0 0 0 1px #FED7AA, 0 16px 40px -8px rgba(249,115,22,.18); }

        .form-input { transition: border-color .2s ease, box-shadow .2s ease; }
        .form-input:focus { border-color: #F97316; box-shadow: 0 0 0 3px rgba(249,115,22,.08); outline: none; }
        .form-input.error { border-color: #EF4444; box-shadow: 0 0 0 3px rgba(239,68,68,.06); }

        @keyframes fade-in { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
        .fade-in { animation: fade-in .4s ease forwards; }
    </style>
</head>
<body class="bg-white text-ink antialiased">

<!-- ===== NAVBAR ===== -->
<nav id="nav" class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
    <div class="max-w-6xl mx-auto px-5 h-[60px] flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-brand-500 flex items-center justify-center">
                <iconify-icon icon="solar:chef-hat-bold" class="text-white text-xs"></iconify-icon>
            </div>
            <span class="font-bold text-[15px] tracking-tight"><?= $brand ?></span>
        </a>
        <div class="hidden md:flex items-center gap-7">
            <a href="#features" class="nav-link text-[13px] font-medium text-mute hover:text-ink transition-colors">Features</a>
            <a href="#how" class="nav-link text-[13px] font-medium text-mute hover:text-ink transition-colors">How It Works</a>
            <a href="#pricing" class="nav-link text-[13px] font-medium text-mute hover:text-ink transition-colors">Pricing</a>
            <a href="#faq" class="nav-link text-[13px] font-medium text-mute hover:text-ink transition-colors">FAQ</a>
            <a href="#contact" class="nav-link text-[13px] font-medium text-mute hover:text-ink transition-colors">Contact</a>
        </div>
        <div class="hidden md:flex items-center gap-4">
            <a href="#" class="text-[13px] font-medium text-mute hover:text-ink transition-colors">Log in</a>
            <a href="#" class="text-[13px] font-semibold text-white bg-ink hover:bg-slate-800 px-5 py-2 rounded-xl transition-colors">Register Restaurant</a>
        </div>
        <button id="menuBtn" class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-page transition-colors">
            <iconify-icon icon="solar:hamburger-menu-linear" class="text-xl"></iconify-icon>
        </button>
    </div>
    <div id="menuDrop" class="md:hidden hidden bg-white/95 backdrop-blur-xl border-b border-line">
        <div class="px-5 py-4 space-y-1">
            <a href="#features" class="block py-2 text-sm text-mute hover:text-ink">Features</a>
            <a href="#how" class="block py-2 text-sm text-mute hover:text-ink">How It Works</a>
            <a href="#pricing" class="block py-2 text-sm text-mute hover:text-ink">Pricing</a>
            <a href="#faq" class="block py-2 text-sm text-mute hover:text-ink">FAQ</a>
            <a href="#contact" class="block py-2 text-sm text-mute hover:text-ink">Contact</a>
            <div class="pt-3 mt-2 border-t border-line flex flex-col gap-2">
                <a href="#" class="py-2 text-sm text-mute">Log in</a>
                <a href="#" class="text-sm font-semibold text-white bg-ink px-5 py-2.5 rounded-xl text-center">Register Restaurant</a>
            </div>
        </div>
    </div>
</nav>


<!-- ===== HERO ===== -->
<section class="pt-28 pb-20 md:pt-36 md:pb-28 overflow-hidden">
    <div class="max-w-6xl mx-auto px-5">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div>
                <div class="reveal">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full">
                        <iconify-icon icon="solar:star-bold" class="text-[10px]"></iconify-icon>
                        500+ restaurants trust us
                    </span>
                </div>
                <h1 class="text-[clamp(2.2rem,5vw,3.4rem)] font-extrabold leading-[1.1] tracking-tight mt-6 reveal">
                    <?= $tagline ?>
                </h1>
                <p class="text-[15px] text-mute leading-relaxed mt-5 max-w-md reveal">
                    Manage QR menus, orders, tables, staff, and analytics from one simple cloud platform built for restaurants.
                </p>
                <div class="flex flex-wrap gap-3 mt-8 reveal">
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-ink hover:bg-slate-800 px-6 py-3 rounded-2xl transition-colors">
                        Start Free Trial
                        <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-ink bg-white hover:bg-page border border-line px-6 py-3 rounded-2xl transition-colors">
                        Book a Demo
                    </a>
                </div>
                <div class="flex flex-wrap gap-x-5 gap-y-1.5 mt-9 reveal">
                    <?php foreach ($badges as $b): ?>
                    <span class="flex items-center gap-1.5 text-[11px] text-mute font-medium">
                        <iconify-icon icon="<?= $b[0] ?>" class="text-ok-500 text-xs"></iconify-icon>
                        <?= $b[1] ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Mockups -->
            <div class="relative reveal">
                <div class="laptop-shell shadow-lg shadow-slate-200/60">
                    <div class="bg-white rounded-[10px] overflow-hidden">
                        <div class="flex items-center gap-1.5 px-3 py-2 bg-page border-b border-line">
                            <span class="w-2 h-2 rounded-full bg-red-300"></span>
                            <span class="w-2 h-2 rounded-full bg-amber-300"></span>
                            <span class="w-2 h-2 rounded-full bg-green-300"></span>
                            <div class="flex-1 flex justify-center">
                                <span class="text-[9px] text-mute bg-white border border-line rounded px-3 py-0.5 flex items-center gap-1">
                                    <iconify-icon icon="solar:lock-bold" class="text-ok-500 text-[8px]"></iconify-icon>
                                    dashboard.<?= strtolower($brand) ?>.com
                                </span>
                            </div>
                        </div>
                        <div class="p-3 bg-page">
                            <div class="grid grid-cols-4 gap-2 mb-2.5">
                                <div class="bg-white rounded-xl p-2.5 border border-line/60">
                                    <div class="text-[8px] text-mute font-medium">Revenue</div>
                                    <div class="text-[13px] font-bold mt-0.5">₨ 45,280</div>
                                    <div class="text-[8px] text-ok-600 font-semibold mt-0.5">↑ 12.5%</div>
                                </div>
                                <div class="bg-white rounded-xl p-2.5 border border-line/60">
                                    <div class="text-[8px] text-mute font-medium">Orders</div>
                                    <div class="text-[13px] font-bold mt-0.5">128</div>
                                    <div class="text-[8px] text-ok-600 font-semibold mt-0.5">↑ 8.2%</div>
                                </div>
                                <div class="bg-white rounded-xl p-2.5 border border-line/60">
                                    <div class="text-[8px] text-mute font-medium">Tables</div>
                                    <div class="text-[13px] font-bold mt-0.5">14 / 20</div>
                                    <div class="w-full bg-line rounded-full h-1 mt-1.5"><div class="bg-brand-500 h-1 rounded-full" style="width:70%"></div></div>
                                </div>
                                <div class="bg-white rounded-xl p-2.5 border border-line/60">
                                    <div class="text-[8px] text-mute font-medium">Staff</div>
                                    <div class="text-[13px] font-bold mt-0.5">6 / 8</div>
                                    <div class="flex -space-x-1 mt-1.5">
                                        <span class="w-3.5 h-3.5 rounded-full bg-brand-100 border border-white"></span>
                                        <span class="w-3.5 h-3.5 rounded-full bg-ok-100 border border-white"></span>
                                        <span class="w-3.5 h-3.5 rounded-full bg-blue-100 border border-white text-[6px] flex items-center justify-center font-bold text-blue-500">+4</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-2 bg-white rounded-xl p-2.5 border border-line/60">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[9px] font-semibold">Sales This Week</span>
                                        <span class="text-[7px] bg-ink text-white px-1.5 py-0.5 rounded-full">Week</span>
                                    </div>
                                    <div class="flex items-end gap-1.5 h-16">
                                        <?php foreach ($chartBars as $i => $cb): ?>
                                        <div class="flex-1 <?= $cb[2] ?> rounded-t bar-grow" style="height:<?= $cb[1] ?>%;animation-delay:<?= $i * .07 ?>s"></div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="flex gap-1.5 mt-1">
                                        <?php foreach ($chartBars as $cb): ?>
                                        <span class="flex-1 text-center text-[6px] text-mute"><?= $cb[0] ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-2.5 border border-line/60">
                                    <span class="text-[9px] font-semibold">Top Items</span>
                                    <div class="mt-2 space-y-1.5">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[9px]">🍛</span>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[8px] font-semibold truncate">Momo</div>
                                                <div class="text-[7px] text-mute">42 sold</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[9px]">🥘</span>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[8px] font-semibold truncate">Thali</div>
                                                <div class="text-[7px] text-mute">38 sold</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[9px]">🍜</span>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[8px] font-semibold truncate">Chow Mein</div>
                                                <div class="text-[7px] text-mute">31 sold</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 bg-white rounded-xl p-2.5 border border-line/60">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-ok-500"></span>
                                        <span class="text-[8px] font-medium">Table 5 — Momo x2, Coke</span>
                                    </div>
                                    <span class="text-[7px] bg-ok-50 text-ok-600 px-1.5 py-0.5 rounded-full font-medium">Ready</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="laptop-notch relative"></div>

                <!-- Phone -->
                <div class="absolute -bottom-3 -left-6 md:-left-14 z-10 float-1">
                    <div class="phone-shell w-[120px]">
                        <div class="bg-white rounded-[22px] overflow-hidden">
                            <div class="flex items-center justify-between px-3 pt-1.5 pb-0.5">
                                <span class="text-[7px] font-semibold">9:41</span>
                                <span class="w-10 h-2 bg-ink rounded-full"></span>
                                <iconify-icon icon="solar:battery-full-bold" class="text-[9px]"></iconify-icon>
                            </div>
                            <div class="px-2.5 pb-2.5 pt-1">
                                <div class="text-[9px] font-bold">🍽️ Himalayan Kitchen</div>
                                <div class="text-[7px] text-mute mb-1.5">Scan QR to order</div>
                                <div class="bg-page rounded-lg p-2 flex justify-center mb-1.5">
                                    <div class="w-12 h-12 bg-ink rounded flex items-center justify-center">
                                        <iconify-icon icon="solar:qr-code-bold" class="text-white text-lg"></iconify-icon>
                                    </div>
                                </div>
                                <div class="text-center text-[7px] font-semibold text-brand-500 mb-1.5">Scan to View Menu</div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 bg-page rounded-lg p-1.5">
                                        <span class="text-[9px]">🍛</span>
                                        <span class="text-[7px] font-semibold flex-1">Chicken Momo</span>
                                        <span class="w-3.5 h-3.5 rounded bg-brand-500 flex items-center justify-center">
                                            <iconify-icon icon="solar:add-circle-bold" class="text-white text-[7px]"></iconify-icon>
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1.5 bg-page rounded-lg p-1.5">
                                        <span class="text-[9px]">🥘</span>
                                        <span class="text-[7px] font-semibold flex-1">Thali Set</span>
                                        <span class="w-3.5 h-3.5 rounded bg-brand-500 flex items-center justify-center">
                                            <iconify-icon icon="solar:add-circle-bold" class="text-white text-[7px]"></iconify-icon>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating notification -->
                <div class="absolute -top-3 right-0 md:-right-2 z-10 float-2">
                    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/60 border border-line/50 p-2.5 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-ok-50 flex items-center justify-center">
                            <iconify-icon icon="solar:bell-bing-bold" class="text-ok-500 text-xs"></iconify-icon>
                        </div>
                        <div>
                            <div class="text-[9px] font-semibold">New Order!</div>
                            <div class="text-[7px] text-mute">Table 7 — ₨ 1,280</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ===== TRUSTED BY ===== -->
<section class="py-12 border-y border-line/60">
    <div class="max-w-6xl mx-auto px-5">
        <p class="text-center text-[11px] font-semibold text-mute/60 tracking-widest uppercase mb-8">Trusted by restaurants across Nepal</p>
        <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-5">
            <?php foreach ($logos as $l): ?>
            <span class="logo-gray flex items-center gap-1.5 cursor-default select-none">
                <iconify-icon icon="<?= $l[0] ?>" class="text-xl text-slate-500"></iconify-icon>
                <span class="text-sm font-bold text-slate-500 tracking-tight"><?= $l[1] ?></span>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ===== FEATURES ===== -->
<section id="features" class="py-24 bg-page">
    <div class="max-w-6xl mx-auto px-5">
        <div class="text-center max-w-lg mx-auto mb-14 reveal">
            <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">Features</span>
            <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight">Everything you need to run your restaurant</h2>
            <p class="text-sm text-mute mt-3 leading-relaxed">Powerful tools designed for the way restaurants actually work.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($features as $f): ?>
            <div class="card-lift bg-white rounded-2xl p-6 border border-line/50 reveal">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br <?= $f[1] ?> flex items-center justify-center mb-4">
                    <iconify-icon icon="<?= $f[0] ?>" class="text-white text-lg"></iconify-icon>
                </div>
                <h3 class="text-[15px] font-bold tracking-tight mb-1.5"><?= $f[2] ?></h3>
                <p class="text-[13px] text-mute leading-relaxed"><?= $f[3] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ===== HOW IT WORKS ===== -->
<section id="how" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5">
        <div class="text-center max-w-lg mx-auto mb-14 reveal">
            <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">How It Works</span>
            <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight">Up and running in minutes</h2>
            <p class="text-sm text-mute mt-3 leading-relaxed">Six simple steps to digitize your restaurant.</p>
        </div>
        <div class="relative max-w-3xl mx-auto">
            <div class="hidden md:block absolute top-5 left-[calc(8.33%+18px)] right-[calc(8.33%+18px)] h-px bg-gradient-to-r from-brand-300 via-brand-400 to-ok-400"></div>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-y-10 md:gap-y-0">
                <?php foreach ($steps as $i => $s): ?>
                <div class="flex flex-col items-center text-center reveal">
                    <div class="relative z-10 w-10 h-10 rounded-xl bg-brand-500 text-white flex items-center justify-center text-sm font-bold mb-3 shadow-sm shadow-brand-500/20"><?= $i + 1 ?></div>
                    <h4 class="text-[13px] font-bold"><?= $s[0] ?></h4>
                    <p class="text-[11px] text-mute mt-0.5 leading-snug max-w-[90px]"><?= $s[1] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<!-- ===== DASHBOARD SHOWCASE ===== -->
<section class="py-24 bg-page">
    <div class="max-w-6xl mx-auto px-5">
        <div class="text-center max-w-lg mx-auto mb-14 reveal">
            <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">Dashboard</span>
            <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight">Your restaurant, at a glance</h2>
            <p class="text-sm text-mute mt-3 leading-relaxed">One clean dashboard to control everything.</p>
        </div>
        <div class="reveal">
            <div class="bg-white rounded-2xl border border-line/60 shadow-sm shadow-slate-100 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-2.5 border-b border-line/50 bg-page/60">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-md bg-brand-500 flex items-center justify-center">
                            <iconify-icon icon="solar:chef-hat-bold" class="text-white text-[8px]"></iconify-icon>
                        </div>
                        <span class="text-[12px] font-bold"><?= $brand ?></span>
                        <div class="hidden sm:flex items-center gap-0.5 ml-5">
                            <?php foreach (['Dashboard','Orders','Menu','Tables','Staff','Reports'] as $j => $tab): ?>
                            <span class="text-[11px] font-medium <?= $j === 0 ? 'text-ink bg-white border border-line/50' : 'text-mute hover:text-ink' ?> px-2.5 py-1 rounded-lg transition-colors cursor-pointer"><?= $tab ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="hidden sm:flex items-center bg-white border border-line/50 rounded-lg px-2.5 py-1 gap-1.5">
                            <iconify-icon icon="solar:magnifer-linear" class="text-mute text-[10px]"></iconify-icon>
                            <span class="text-[10px] text-mute">Search...</span>
                        </div>
                        <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-[10px] font-bold text-brand-600">RK</div>
                    </div>
                </div>
                <div class="p-5 bg-page/30">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                        <?php foreach ($dashStats as $s): ?>
                        <div class="bg-white rounded-xl p-4 border border-line/40">
                            <div class="flex items-center justify-between mb-2.5">
                                <div class="w-8 h-8 rounded-lg bg-<?= $s[1] ?> flex items-center justify-center">
                                    <iconify-icon icon="<?= $s[0] ?>" class="text-<?= $s[2] ?> text-sm"></iconify-icon>
                                </div>
                                <?php if ($s[6]): ?>
                                <span class="text-[10px] font-semibold text-ok-600 bg-ok-50 px-2 py-0.5 rounded-full">↑ <?= $s[5] ?></span>
                                <?php else: ?>
                                <span class="text-[10px] text-mute bg-page px-2 py-0.5 rounded-full"><?= $s[5] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-xl font-bold"><?= $s[3] ?></div>
                            <div class="text-[11px] text-mute mt-0.5"><?= $s[4] ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-3">
                        <div class="lg:col-span-2 bg-white rounded-xl p-4 border border-line/40">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-[13px] font-bold">Sales Analytics</h3>
                                    <p class="text-[11px] text-mute">Revenue this week</p>
                                </div>
                                <div class="flex gap-0.5 bg-page rounded-lg p-0.5">
                                    <span class="text-[10px] font-semibold bg-white text-ink px-2.5 py-1 rounded-md shadow-sm">Week</span>
                                    <span class="text-[10px] font-medium text-mute px-2.5 py-1 rounded-md cursor-pointer">Month</span>
                                </div>
                            </div>
                            <div class="flex items-end gap-2.5 h-32">
                                <?php foreach ($chartBars as $ci => $cb): ?>
                                <div class="flex-1 flex flex-col items-center gap-1.5">
                                    <div class="w-full <?= $cb[2] ?> rounded-lg bar-grow" style="height:<?= $cb[1] ?>%;animation-delay:<?= $ci * .08 ?>s"></div>
                                    <span class="text-[9px] text-mute"><?= $cb[0] ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-line/40">
                            <h3 class="text-[13px] font-bold mb-3">Feedback</h3>
                            <div class="space-y-2.5">
                                <?php foreach ($feedbacks as $fb): ?>
                                <div class="bg-page rounded-lg p-2.5">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <div class="w-5 h-5 rounded-full <?= $fb[1] ?> flex items-center justify-center text-[8px] font-bold <?= $fb[2] ?>"><?= $fb[0] ?></div>
                                        <span class="text-[10px] font-semibold"><?= $fb[3] ?></span>
                                    </div>
                                    <div class="flex gap-px mb-1">
                                        <?php for ($si = 0; $si < 5; $si++): ?>
                                        <iconify-icon icon="solar:star-bold" class="text-[8px] <?= $si < $fb[5] ? 'text-amber-400' : 'text-slate-200' ?>"></iconify-icon>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-[10px] text-mute leading-relaxed"><?= $fb[4] ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ===== WHY CHOOSE ===== -->
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div class="reveal">
                <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">Why <?= $brand ?></span>
                <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight leading-tight">Built for restaurants that want to lead</h2>
                <p class="text-sm text-mute mt-4 leading-relaxed max-w-md">Every feature is designed around how restaurants actually work — not how software companies think they should.</p>
                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4 mt-8">
                    <?php foreach ($benefits as $b): ?>
                    <div class="flex items-start gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-<?= $b[1] ?> flex items-center justify-center flex-shrink-0 mt-0.5">
                            <iconify-icon icon="<?= $b[0] ?>" class="text-<?= $b[2] ?> text-xs"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-bold"><?= $b[3] ?></h4>
                            <p class="text-[11px] text-mute mt-0.5"><?= $b[4] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="reveal">
                <div class="bg-page rounded-2xl p-6 border border-line/40">
                    <div class="space-y-5">
                                                <div class="bg-white rounded-xl p-4 border border-red-100/80">
                            <div class="flex items-center gap-1.5 mb-3">
                                <iconify-icon icon="solar:close-circle-bold" class="text-red-300 text-sm"></iconify-icon>
                                <span class="text-[11px] font-bold text-red-400">Without <?= $brand ?></span>
                            </div>
                            <?php foreach ($withoutHM as $w): ?>
                            <div class="flex items-start gap-2 text-[12px] text-mute mb-1.5 last:mb-0">
                                <iconify-icon icon="solar:close-circle-linear" class="text-red-200 text-sm mt-px flex-shrink-0"></iconify-icon>
                                <?= $w ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center shadow-md shadow-brand-500/20">
                                <iconify-icon icon="solar:arrow-down-bold" class="text-white text-sm"></iconify-icon>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-ok-100/80">
                            <div class="flex items-center gap-1.5 mb-3">
                                <iconify-icon icon="solar:check-circle-bold" class="text-ok-500 text-sm"></iconify-icon>
                                <span class="text-[11px] font-bold text-ok-600">With <?= $brand ?></span>
                            </div>
                            <?php foreach ($withHM as $wi): ?>
                            <div class="flex items-start gap-2 text-[12px] text-ink mb-1.5 last:mb-0">
                                <iconify-icon icon="solar:check-circle-linear" class="text-ok-500 text-sm mt-px flex-shrink-0"></iconify-icon>
                                <?= $wi ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ===== STATISTICS ===== -->
<section class="py-20 bg-white border-y border-line/60">
    <div class="max-w-5xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-6 text-center">
            <?php foreach ($nums as $n): ?>
            <div class="reveal">
                <div class="text-3xl md:text-4xl font-extrabold text-<?= $n[2] ?>-500"><?= $n[0] ?></div>
                <div class="text-[13px] text-mute mt-1 font-medium"><?= $n[1] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ===== PRICING ===== -->
<section id="pricing" class="py-24 bg-page">
    <div class="max-w-6xl mx-auto px-5">
        <div class="text-center max-w-lg mx-auto mb-14 reveal">
            <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">Pricing</span>
            <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight">Simple, transparent pricing</h2>
            <p class="text-sm text-mute mt-3 leading-relaxed">No hidden fees. No surprises. Pick what works for you.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5 max-w-4xl mx-auto">
            <?php foreach ($plans as $p): ?>
            <div class="card-lift bg-white rounded-2xl p-7 border <?= $p['style'] === 'primary' ? 'pricing-highlight' : 'border-line/50' ?> flex flex-col relative reveal">
                <?php if (!empty($p['badge'])): ?>
                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 text-[10px] font-bold text-white bg-brand-500 px-3 py-0.5 rounded-full"><?= $p['badge'] ?></span>
                <?php endif; ?>
                <div class="mb-5">
                    <h3 class="text-[15px] font-bold"><?= $p['name'] ?></h3>
                    <p class="text-[11px] text-mute mt-0.5"><?= $p['desc'] ?></p>
                </div>
                <div class="mb-5">
                    <span class="text-3xl font-extrabold"><?= $p['price'] ?></span>
                    <?php if ($p['period']): ?>
                    <span class="text-sm text-mute font-medium"><?= $p['period'] ?></span>
                    <?php endif; ?>
                </div>
                <ul class="space-y-2.5 mb-7 flex-1">
                    <?php foreach ($p['features'] as $f): ?>
                    <li class="flex items-center gap-2 text-[13px] text-mute">
                        <iconify-icon icon="solar:check-circle-bold" class="text-ok-500 text-sm flex-shrink-0"></iconify-icon>
                        <?= $f ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="#" class="block text-center text-[13px] font-semibold rounded-xl px-5 py-3 transition-colors <?= $p['style'] === 'primary' ? 'text-white bg-brand-500 hover:bg-brand-600' : 'text-ink bg-page hover:bg-line/40 border border-line/60' ?>">
                    <?= $p['btn'] ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="text-center text-[12px] text-mute/60 mt-8 reveal">All plans include SSL encryption, daily backups, and email support.</p>
    </div>
</section>


<!-- ===== TESTIMONIALS ===== -->
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5">
        <div class="text-center max-w-lg mx-auto mb-14 reveal">
            <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">Testimonials</span>
            <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight">Loved by restaurant owners</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            <?php foreach ($reviews as $r): ?>
            <div class="card-lift bg-page rounded-2xl p-6 border border-line/40 reveal">
                <div class="flex gap-px mb-3">
                    <?php for ($si = 0; $si < 5; $si++): ?>
                    <iconify-icon icon="solar:star-bold" class="text-sm <?= $si < $r[5] ? 'text-amber-400' : 'text-slate-200' ?>"></iconify-icon>
                    <?php endfor; ?>
                </div>
                <p class="text-[13px] text-ink leading-relaxed mb-5"><?= $r[4] ?></p>
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br <?= $r[1] ?> flex items-center justify-center text-white text-[11px] font-bold"><?= $r[0] ?></div>
                    <div>
                        <div class="text-[13px] font-bold"><?= $r[2] ?></div>
                        <div class="text-[11px] text-mute"><?= $r[3] ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ===== FAQ ===== -->
<section id="faq" class="py-24 bg-page">
    <div class="max-w-2xl mx-auto px-5">
        <div class="text-center mb-14 reveal">
            <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">FAQ</span>
            <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight">Frequently asked questions</h2>
            <p class="text-sm text-mute mt-3">Can't find what you're looking for? <a href="#contact" class="text-brand-600 hover:text-brand-700 font-medium underline underline-offset-2">Contact us</a>.</p>
        </div>
        <div class="space-y-2.5 reveal">
            <?php foreach ($faqs as $faq): ?>
            <div class="bg-white rounded-xl border border-line/40 overflow-hidden">
                <button class="w-full flex items-center justify-between p-4 text-left group" onclick="toggleFaq(this)">
                    <span class="text-[13px] font-semibold pr-4 group-hover:text-brand-600 transition-colors"><?= $faq[0] ?></span>
                    <iconify-icon icon="solar:alt-arrow-down-linear" class="faq-icon text-mute text-base flex-shrink-0"></iconify-icon>
                </button>
                <div class="faq-body px-4">
                    <p class="text-[13px] text-mute leading-relaxed pb-4"><?= $faq[1] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ===== CONTACT ===== -->
<section id="contact" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5">
        <div class="grid lg:grid-cols-5 gap-12 lg:gap-16">
            <!-- Left info -->
            <div class="lg:col-span-2 reveal">
                <span class="inline-block text-[11px] font-semibold text-brand-600 bg-brand-50 px-3 py-1 rounded-full mb-4">Contact</span>
                <h2 class="text-[28px] md:text-[34px] font-extrabold tracking-tight leading-tight">Let's talk about your restaurant</h2>
                <p class="text-sm text-mute mt-4 leading-relaxed">Have a question, want a demo, or ready to get started? We'd love to hear from you.</p>

                <div class="mt-8 space-y-5">
                    <?php foreach ($contactInfo as $ci): ?>
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-<?= $ci[1] ?> flex items-center justify-center flex-shrink-0">
                            <iconify-icon icon="<?= $ci[0] ?>" class="text-<?= $ci[2] ?> text-lg"></iconify-icon>
                        </div>
                        <div>
                            <div class="text-[12px] font-bold text-mute/60 uppercase tracking-wider"><?= $ci[3] ?></div>
                            <div class="text-[14px] font-medium mt-0.5"><?= $ci[4] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Map placeholder -->
                <div class="mt-8 bg-page rounded-2xl border border-line/40 overflow-hidden aspect-[4/3] relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <iconify-icon icon="solar:map-point-bold" class="text-3xl text-brand-300"></iconify-icon>
                            <p class="text-[12px] text-mute mt-2">Putalisadak, Kathmandu</p>
                            <a href="https://maps.google.com" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-[11px] font-semibold text-brand-600 hover:text-brand-700 mt-2">
                                Open in Google Maps
                                <iconify-icon icon="solar:arrow-right-up-linear" class="text-xs"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right form -->
            <div class="lg:col-span-3 reveal">
                <div class="bg-page rounded-2xl p-7 md:p-9 border border-line/40">
                    <?php if ($formSent): ?>
                    <div class="fade-in text-center py-10">
                        <div class="w-14 h-14 rounded-2xl bg-ok-50 flex items-center justify-center mx-auto mb-4">
                            <iconify-icon icon="solar:check-circle-bold" class="text-ok-500 text-2xl"></iconify-icon>
                        </div>
                        <h3 class="text-lg font-bold">Message sent!</h3>
                        <p class="text-sm text-mute mt-1.5 max-w-sm mx-auto">Thanks for reaching out. We'll get back to you within a few hours during business hours.</p>
                        <a href="#contact" class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-brand-600 hover:text-brand-700 mt-5">
                            Send another message
                            <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
                        </a>
                    </div>
                    <?php else: ?>
                    <?php if ($formError): ?>
                    <div class="fade-in flex items-center gap-2.5 bg-red-50 border border-red-100 text-red-600 text-[13px] font-medium px-4 py-3 rounded-xl mb-6">
                        <iconify-icon icon="solar:danger-triangle-bold" class="text-base flex-shrink-0"></iconify-icon>
                        <?= $formError ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="#contact" id="contactForm" novalidate>
                        <input type="hidden" name="contact_submit" value="1">

                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="c_name" class="block text-[12px] font-semibold text-mute/70 uppercase tracking-wider mb-1.5">Full Name <span class="text-red-400">*</span></label>
                                <input
                                    type="text" id="c_name" name="contact_name"
                                    value="<?= htmlspecialchars($_POST['contact_name'] ?? '') ?>"
                                    placeholder="Rajesh Pradhan"
                                    required
                                    class="form-input w-full bg-white border border-line/70 rounded-xl px-4 py-3 text-[14px] placeholder:text-mute/40"
                                >
                            </div>
                            <div>
                                <label for="c_email" class="block text-[12px] font-semibold text-mute/70 uppercase tracking-wider mb-1.5">Email <span class="text-red-400">*</span></label>
                                <input
                                    type="email" id="c_email" name="contact_email"
                                    value="<?= htmlspecialchars($_POST['contact_email'] ?? '') ?>"
                                    placeholder="rajesh@restaurant.com"
                                    required
                                    class="form-input w-full bg-white border border-line/70 rounded-xl px-4 py-3 text-[14px] placeholder:text-mute/40"
                                >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="c_restaurant" class="block text-[12px] font-semibold text-mute/70 uppercase tracking-wider mb-1.5">Restaurant Name</label>
                            <input
                                type="text" id="c_restaurant" name="contact_restaurant"
                                value="<?= htmlspecialchars($_POST['contact_restaurant'] ?? '') ?>"
                                placeholder="Himalayan Kitchen"
                                class="form-input w-full bg-white border border-line/70 rounded-xl px-4 py-3 text-[14px] placeholder:text-mute/40"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="c_subject" class="block text-[12px] font-semibold text-mute/70 uppercase tracking-wider mb-1.5">Subject</label>
                            <select id="c_subject" name="contact_subject" class="form-input w-full bg-white border border-line/70 rounded-xl px-4 py-3 text-[14px] text-mute appearance-none cursor-pointer" style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22><path fill=%22%2394a3b8%22 d=%22M7 10l5 5 5-5z%22/></svg>');background-repeat:no-repeat;background-position:right 16px center;">
                                <option value="">Select a topic</option>
                                <option value="demo" <?= (($_POST['contact_subject'] ?? '') === 'demo') ? 'selected' : '' ?>>Request a Demo</option>
                                <option value="pricing" <?= (($_POST['contact_subject'] ?? '') === 'pricing') ? 'selected' : '' ?>>Pricing Question</option>
                                <option value="support" <?= (($_POST['contact_subject'] ?? '') === 'support') ? 'selected' : '' ?>>Technical Support</option>
                                <option value="enterprise" <?= (($_POST['contact_subject'] ?? '') === 'enterprise') ? 'selected' : '' ?>>Enterprise Inquiry</option>
                                <option value="other" <?= (($_POST['contact_subject'] ?? '') === 'other') ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="c_message" class="block text-[12px] font-semibold text-mute/70 uppercase tracking-wider mb-1.5">Message <span class="text-red-400">*</span></label>
                            <textarea
                                id="c_message" name="contact_message"
                                rows="5"
                                placeholder="Tell us about your restaurant and what you're looking for..."
                                required
                                class="form-input w-full bg-white border border-line/70 rounded-xl px-4 py-3 text-[14px] placeholder:text-mute/40 resize-none"
                            ><?= htmlspecialchars($_POST['contact_message'] ?? '') ?></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 text-[14px] font-semibold text-white bg-ink hover:bg-slate-800 px-8 py-3.5 rounded-xl transition-colors"
                        >
                            Send Message
                            <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
                        </button>

                        <p class="text-[11px] text-mute/50 mt-3">We typically respond within 2–4 hours during business hours.</p>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ===== CTA ===== -->
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5">
        <div class="bg-brand-500 rounded-3xl relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-[0.06]" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:20px 20px"></div>
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative text-center py-16 px-6">
                <h2 class="text-[28px] md:text-[38px] font-extrabold text-white tracking-tight leading-tight">Ready to Transform<br>Your Restaurant?</h2>
                <p class="text-white/80 mt-4 text-[15px] max-w-md mx-auto leading-relaxed">Join hundreds of restaurants already using <?= $brand ?> to modernize their operations.</p>
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <a href="#" class="inline-flex items-center gap-2 text-[13px] font-semibold text-brand-600 bg-white hover:bg-brand-50 px-7 py-3.5 rounded-2xl transition-colors">
                        Start Free Trial
                        <iconify-icon icon="solar:arrow-right-linear" class="text-sm"></iconify-icon>
                    </a>
                    <a href="#contact" class="inline-flex items-center gap-2 text-[13px] font-semibold text-white bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/20 px-7 py-3.5 rounded-2xl transition-colors">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ===== FOOTER ===== -->
<footer class="bg-page border-t border-line/60">
    <div class="border-b border-line/60">
        <div class="max-w-6xl mx-auto px-5 py-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-[18px] font-bold tracking-tight">Ready to get started?</h3>
                <p class="text-[13px] text-mute mt-1">Join 500+ restaurants already on <?= $brand ?>.</p>
            </div>
            <div class="flex gap-3">
                <a href="#" class="text-[13px] font-semibold text-white bg-ink hover:bg-slate-800 px-6 py-2.5 rounded-xl transition-colors">Start Free Trial</a>
                <a href="#contact" class="text-[13px] font-semibold text-ink bg-white hover:bg-slate-50 border border-line/60 px-6 py-2.5 rounded-xl transition-colors">Talk to Sales</a>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto px-5 pt-12 pb-10">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-10">
            <div class="col-span-2">
                <a href="/" class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-brand-500 flex items-center justify-center">
                        <iconify-icon icon="solar:chef-hat-bold" class="text-white text-xs"></iconify-icon>
                    </div>
                    <span class="font-bold text-[15px] tracking-tight"><?= $brand ?></span>
                </a>
                <p class="text-[13px] text-mute leading-relaxed max-w-[260px] mb-5">
                    The modern cloud platform for restaurants. Digitize menus, manage orders, track analytics — all from one place.
                </p>
                <div class="flex gap-2">
                    <?php foreach ($socials as $s): ?>
                    <a href="<?= $s[2] ?>" target="_blank" rel="noopener" title="<?= $s[1] ?>" class="w-8 h-8 rounded-lg bg-white border border-line/60 hover:border-line hover:bg-slate-50 flex items-center justify-center transition-colors">
                        <iconify-icon icon="<?= $s[0] ?>" class="text-mute text-xs"></iconify-icon>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php foreach ($footerLinks as $heading => $links): ?>
            <div>
                <h4 class="text-[11px] font-bold uppercase tracking-widest text-mute/50 mb-4"><?= $heading ?></h4>
                <ul class="space-y-2.5">
                    <?php foreach ($links as $link): ?>
                    <li><a href="<?= $link[1] ?>" class="text-[13px] text-mute hover:text-ink transition-colors"><?= $link[0] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="border-t border-line/60">
        <div class="max-w-6xl mx-auto px-5 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-[11px] text-mute/50">&copy; <?= $year ?> <?= $brand ?>. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="text-[11px] text-mute/50 hover:text-mute transition-colors">Privacy</a>
                <a href="#" class="text-[11px] text-mute/50 hover:text-mute transition-colors">Terms</a>
                <a href="#" class="text-[11px] text-mute/50 hover:text-mute transition-colors">Cookies</a>
            </div>
            <p class="text-[11px] text-mute/50 flex items-center gap-1">Made with <iconify-icon icon="solar:heart-bold" class="text-brand-500 text-[11px]"></iconify-icon> in Nepal</p>
        </div>
    </div>
</footer>


<script>
// Navbar scroll
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => {
    const y = window.scrollY;
    nav.style.background = y > 16 ? 'rgba(255,255,255,.88)' : 'transparent';
    nav.style.backdropFilter = y > 16 ? 'blur(16px)' : 'none';
    nav.style.borderBottom = y > 16 ? '1px solid rgba(226,232,240,.5)' : '1px solid transparent';
});

// Mobile menu
const menuBtn = document.getElementById('menuBtn');
const menuDrop = document.getElementById('menuDrop');
let menuOpen = false;
menuBtn.addEventListener('click', () => {
    menuOpen = !menuOpen;
    menuDrop.classList.toggle('hidden');
    menuBtn.querySelector('iconify-icon').setAttribute('icon', menuOpen ? 'solar:close-circle-linear' : 'solar:hamburger-menu-linear');
});
menuDrop.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
    menuDrop.classList.add('hidden');
    menuOpen = false;
    menuBtn.querySelector('iconify-icon').setAttribute('icon', 'solar:hamburger-menu-linear');
}));

// FAQ accordion
function toggleFaq(btn) {
    const body = btn.nextElementSibling;
    const icon = btn.querySelector('.faq-icon');
    const isOpen = body.classList.contains('open');
    document.querySelectorAll('.faq-body').forEach(b => b.classList.remove('open'));
    document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('flip'));
    if (!isOpen) {
        body.classList.add('open');
        icon.classList.add('flip');
    }
}

// Scroll reveal
const obs = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('visible'), i * 60);
            obs.unobserve(e.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        e.preventDefault();
        const t = document.querySelector(href);
        if (t) window.scrollTo({ top: t.offsetTop - 70, behavior: 'smooth' });
    });
});

// Client-side form validation feedback
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function() {
        let valid = true;
        this.querySelectorAll('[required]').forEach(input => {
            input.classList.remove('error');
            if (!input.value.trim()) {
                input.classList.add('error');
                valid = false;
            }
        });
        // Email format check
        const email = this.querySelector('[type="email"]');
        if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            email.classList.add('error');
            valid = false;
        }
        if (!valid) {
            // Let server-side handle the error display, but still prevent empty submit feel
        }
    });

    // Remove error on input
    contactForm.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('input', () => input.classList.remove('error'));
    });
}
</script>

</body>
</html>