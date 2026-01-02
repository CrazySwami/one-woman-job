# One Woman Job - WordPress Theme

Feminine, elegant WordPress theme for furniture assembly and home organization services.

---

## Development Environment

### Local Docker Setup
- **URL**: `https://local3.hustletogether.com` (via Cloudflare tunnel on port 3002)
- **Direct**: `http://localhost:3002`
- **WordPress Container**: `owj-wordpress`
- **Database Container**: `owj-db`
- **Theme Mount**: `/root/repos/one-woman-job` → `/var/www/html/wp-content/themes/one-woman-job`

### Docker Commands
```bash
# Start environment
cd /root/repos/one-woman-job/docker && docker-compose up -d

# Stop environment
cd /root/repos/one-woman-job/docker && docker-compose down

# View logs
docker logs owj-wordpress -f

# Run WP-CLI
docker-compose -f /root/repos/one-woman-job/docker/docker-compose.yml run --rm wpcli <command>
```

---

## Project Structure

```
/root/repos/one-woman-job/
├── CLAUDE.md                 # This file
├── style.css                 # Main stylesheet with theme header
├── functions.php             # Theme setup and functions
├── header.php                # Site header
├── footer.php                # Site footer
├── front-page.php            # Homepage template
├── index.php                 # Fallback template
├── page.php                  # Page template
├── inc/
│   ├── admin-settings.php    # Admin settings page
│   └── setup-wizard.php      # Setup wizard
├── assets/
│   ├── css/
│   │   ├── admin.css         # Admin styles
│   │   └── wizard.css        # Wizard styles
│   ├── js/
│   │   ├── main.js           # Frontend JavaScript
│   │   ├── admin.js          # Admin JavaScript
│   │   └── wizard.js         # Wizard JavaScript
│   └── images/
└── docker/
    └── docker-compose.yml
```

---

## Theme Features

### Brand Colors (CSS Variables)
```css
--bg-cream: #fdfaf6;
--bg-cream-alt: #f9f5ef;
--card-cream: #f5f1ea;
--card-rose: #f8e4e4;
--dusty-rose: #e2bfbf;
--dusty-rose-dark: #d4a8a8;
--dusty-rose-light: #f5e8e8;
--text-dark: #3d3d3d;
--text-medium: #5a5a5a;
--text-light: #888888;
--text-rose: #c9a5a5;
```

### Typography
- **Headings**: Cormorant Garamond (serif)
- **Body**: Montserrat (sans-serif)

### Unique Border Radius
Three corners rounded, top-left square:
```css
--radius-sm: 0 12px 12px 12px;
--radius-md: 0 20px 20px 20px;
--radius-lg: 0 28px 28px 28px;
```

---

## Admin Settings

Access via **Dashboard → OWJ Settings**

### Tabs:
1. **General** - Business info, top banner
2. **Hero Section** - Hero image, welcome text, stats
3. **Content** - Services, pricing, story
4. **Gallery** - Work portfolio images
5. **Social & Contact** - Phone, email, social links

---

## Setup Wizard

Appears on theme activation. Guides user through:
1. Business information
2. Contact details
3. Branding (hero image, pricing)
4. Complete

---

## Theme Options

Get options with: `owj_get_option('key', 'default')`

### Available Options:
- `business_name` - Business name
- `owner_name` - Owner's name
- `nav_logo_text` - Navigation logo text
- `tagline` - Business tagline
- `service_area` - Geographic service area
- `company_phone` - Phone number
- `contact_email` - Email address
- `hero_image` - Hero section image URL
- `hero_welcome` - Welcome text
- `hero_text_1` through `hero_text_4` - Hero paragraphs
- `stat_1_number`, `stat_1_label` - First stat
- `stat_2_number`, `stat_2_label` - Second stat
- `service_1_title`, `service_1_desc` - First service
- `service_2_title`, `service_2_desc` - Second service
- `organizing_price` - Hourly rate for organizing
- `story_text_1` through `story_text_3` - Story paragraphs
- `gallery_images` - Array of gallery image URLs
- `social_facebook`, `social_instagram`, `social_tiktok` - Social URLs
- `show_banner` - Show/hide top banner
- `show_spanish` - Show/hide "Se Habla Español"

---

## Sections (front-page.php)

1. **Top Banner** - Promotional message
2. **Navigation** - Logo + menu + CTA
3. **Hero Section** - Image + welcome text
4. **Stats Section** - Two stat cards
5. **Section Title** - Main headline
6. **Brand Logos** - IKEA, Amazon, Walmart, Wayfair
7. **Services** - Two service cards
8. **Features** - Two feature cards with icons
9. **My Story** - About the owner
10. **Pricing** - Assembly + Organizing cards
11. **My Work** - Image slider/gallery
12. **Footer** - Contact info + social links

---

## Animations

CSS classes for scroll-triggered animations:
- `.animate.fade-up` - Fade in from below
- `.animate.fade-in` - Simple fade in
- `.animate.scale-in` - Scale up fade
- `.delay-1` through `.delay-5` - Animation delays

JavaScript handles adding `.in-view` class on scroll.

---

**Version**: 1.0.0
**Last Updated**: December 30, 2025
