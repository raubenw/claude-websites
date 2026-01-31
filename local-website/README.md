# De Beer Bonsmara - Local Test Website

A modern, impressive standalone website with shopping cart functionality that you can test locally.

## 🚀 Quick Start

### Option 1: Simple File Open

Just double-click `index.html` to open in your browser!

### Option 2: Local Server (Recommended for full features)

```bash
# Using Python
python -m http.server 8000
# Then open: http://localhost:8000

# Using Node.js
npx serve
# Then open: http://localhost:3000
```

## 📁 File Structure

```
local-website/
├── index.html          # Homepage
├── cattle.html         # Cattle products page
├── grass.html          # Grass seed mixes page
├── honey.html          # Honey products page
├── css/
│   └── styles.css      # Main stylesheet
├── js/
│   └── main.js         # JavaScript effects
└── README.md           # This file
```

## 🛒 Shopping Cart System: Snipcart

This website uses **Snipcart** - an HTML-based shopping cart that works with any website.

### How Snipcart Works:

1. Add products with simple HTML attributes
2. Cart appears as a sidebar
3. Checkout with Stripe/PayPal

### To Enable Live Payments:

1. Sign up at [snipcart.com](https://snipcart.com) (free to test)
2. Get your API key
3. Replace `YOUR_SNIPCART_API_KEY` in each HTML file
4. Configure your domain in Snipcart dashboard

### Product Button Example:

```html
<button
  class="snipcart-add-item"
  data-item-id="product-123"
  data-item-name="Product Name"
  data-item-price="29.99"
  data-item-url="/index.html"
  data-item-description="Description"
  data-item-image="image-url.jpg"
>
  Add to Cart
</button>
```

## 🎨 Features

### Visual Effects

- ✨ Preloader animation
- 🖱️ Custom cursor follower
- 📜 Scroll-triggered animations (AOS)
- 🃏 3D card tilt effects
- 🌊 Parallax hero section
- 🔘 Magnetic button effects
- ⌨️ Typing effect on hero text
- 💫 Ripple click effects

### Sections

- Hero with animated text
- Trust badges
- About with experience counter
- Product categories
- Featured package (cattle bundle)
- Quick shop grid
- Testimonials
- Contact form
- Newsletter popup
- Scroll-to-top button

## 🎯 Other Payment Options

### Alternative Cart Systems:

#### 1. **Snipcart** (Used in this demo)

- Easiest HTML integration
- Free to test, 2% + payment fees
- [snipcart.com](https://snipcart.com)

#### 2. **Stripe Checkout**

```html
<script async src="https://js.stripe.com/v3/buy-button.js"></script>
<stripe-buy-button buy-button-id="your_button_id" publishable-key="pk_live_xxx">
</stripe-buy-button>
```

#### 3. **PayPal Buttons**

```html
<div id="paypal-button-container"></div>
<script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>
<script>
  paypal
    .Buttons({
      /* config */
    })
    .render("#paypal-button-container");
</script>
```

#### 4. **Ecwid**

- Full e-commerce platform
- Embed anywhere
- [ecwid.com](https://www.ecwid.com)

#### 5. **Gumroad**

- Simple product embeds
- [gumroad.com](https://gumroad.com)

## 🔧 Customization

### Colors (in styles.css)

```css
:root {
  --gold: #c9a227;
  --brown-dark: #2d1f17;
  --cream: #f5f0e6;
  --green: #3f4929;
}
```

### Fonts

- Headings: Playfair Display
- Body: Lato

## 📱 Responsive

Fully responsive design:

- Desktop (1200px+)
- Tablet (768px - 1024px)
- Mobile (< 768px)

## 🖼️ Images

Currently using Unsplash placeholder images. Replace with your actual product photos:

- Cattle images
- Grass/field images
- Honey jar photos

## ⚡ Performance Tips

1. Optimize images (use WebP format)
2. Minify CSS/JS for production
3. Use a CDN for external libraries
4. Enable browser caching

## 📄 License

Feel free to use and modify for De Beer Bonsmara website.

---

**Created for De Beer Bonsmara Farm**
Premium Cattle • Grass • Honey
