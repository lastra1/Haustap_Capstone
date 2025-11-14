<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Homi</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="main-content">
        <div class="services-header">
            <h1 class="services-title">Services</h1>
            <select class="category-select">
                <option value="">CATEGORY</option>
                <option value="cleaning">Cleaning Services</option>
                <option value="outdoor">Outdoor Services</option>
                <option value="repairs">Home Repairs</option>
                <option value="beauty">Beauty Services</option>
                <option value="wellness">Wellness Services</option>
                <option value="tech">Tech & Gadget Services</option>
            </select>
        </div>

        <div class="services-grid">
            <a href="/services/cleaning" class="service-card" data-category="cleaning" style="text-decoration:none;color:inherit">
                <img src="images/cleaning.png" alt="Cleaning Services" class="service-image">
                <div class="service-content">
                    <h2 class="service-title">Cleaning Services</h2>
                    <p class="service-description">Professional and reliable cleaning to keep your space at its best. Expert cleaning services from our trusted professionals.</p>
                </div>
            </a>

            <a href="/services/outdoor" class="service-card" data-category="outdoor" style="text-decoration:none;color:inherit">
                <img src="images/outdoor.png" alt="Outdoor Services" class="service-image">
                <div class="service-content">
                    <h2 class="service-title">Outdoor Services</h2>
                    <p class="service-description">Expert gardening and outdoor care services to make your outdoor space beautiful and well-maintained.</p>
                </div>
            </a>

            <a href="/services/repairs" class="service-card" data-category="repairs" style="text-decoration:none;color:inherit">
                <img src="images/repair.png" alt="Home Repairs" class="service-image">
                <div class="service-content">
                    <h2 class="service-title">Home Repairs</h2>
                    <p class="service-description">Quick and reliable repairs for plumbing, electrical, and other home maintenance needs.</p>
                </div>
            </a>

            <a href="/services/beauty" class="service-card" data-category="beauty" style="text-decoration:none;color:inherit">
                <img src="images/beauty service.png" alt="Beauty Services" class="service-image">
                <div class="service-content">
                    <h2 class="service-title">Beauty Services</h2>
                    <p class="service-description">Pamper yourself at home with salon-quality beauty services from certified professionals.</p>
                </div>
            </a>

            <a href="/services/wellness" class="service-card" data-category="wellness" style="text-decoration:none;color:inherit">
                <img src="images/wellness.png" alt="Wellness Services" class="service-image">
                <div class="service-content">
                    <h2 class="service-title">Wellness Services</h2>
                    <p class="service-description">Enjoy relaxing wellness and self-care services in the comfort of your home.</p>
                </div>
            </a>

            <a href="/services/tech" class="service-card" data-category="tech" style="text-decoration:none;color:inherit">
                <img src="images/tech.png" alt="Tech & Gadget Services" class="service-image">
                <div class="service-content">
                    <h2 class="service-title">Tech & Gadget Services</h2>
                    <p class="service-description">Get expert help with device setup, repairs, and smart home installations.</p>
                </div>
            </a>
            </div>
            </main>

            <script src="/client/js/filter-services.js" defer></script>
        <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
