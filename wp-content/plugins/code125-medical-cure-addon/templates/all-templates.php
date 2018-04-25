<?php

add_filter('c5_page_templates_base_url' , 'c5_page_templates_base_url');
function c5_page_templates_base_url()
{
    return C5_MC_URL . 'templates/';
}

add_filter( 'c5_get_all_page_templates', 'c5_get_all_page_templates' );
function c5_get_all_page_templates()
{
    $pages = array(
    "main-demo-about", "main-demo-accordion", "main-demo-appointment-layout-1", "main-demo-appointment-layout-2", "main-demo-appointment-layout-3", "main-demo-banners-layout-1", "main-demo-banners-layout-2", "main-demo-banners-layout-3", "main-demo-blog-carousel", "main-demo-blog-classic", "main-demo-blog-full-width", "main-demo-blog-grid", "main-demo-blog-shadow", "main-demo-blog-slider", "main-demo-blog-split", "main-demo-blog", "main-demo-call-to-action", "main-demo-contact-layout-1", "main-demo-contact-layout-2", "main-demo-contact-layout-3", "main-demo-contact-layout-4", "main-demo-contact-layout-5", "main-demo-counters", "main-demo-departements", "main-demo-departments", "main-demo-faq", "main-demo-gallery", "main-demo-image-comparison", "main-demo-newsletter", "main-demo-pricing-tables", "main-demo-services-carousel", "main-demo-services-pack-1", "main-demo-services-pack-2", "main-demo-services-pack-3", "main-demo-services-pack-4", "main-demo-services-pack-5", "main-demo-services-pack-6", "main-demo-services-single-2", "main-demo-social-icons", "main-demo-social-networks", "main-demo-staff-classic", "main-demo-staff-left-aligned", "main-demo-staff-shadow", "main-demo-staff-stack", "main-demo-tabs", "main-demo-testimonials", "main-demo-timeline", "main-demo", );
    return $pages;
}

add_filter('c5_get_all_elements' , 'c5_get_all_elements');
function c5_get_all_elements()
{
    $elements = array(
        "appointment/main-demo-appointment-layout-1-OqNEWe", "appointment/main-demo-appointment-layout-3-OqNEWe", "appointment/main-demo-zgWpAQ", "banners/main-demo-about-wfyYFA", "banners/main-demo-banners-layout-1-emfQGa", "banners/main-demo-banners-layout-1-hKbSAJ", "banners/main-demo-banners-layout-1-jjevIM", "banners/main-demo-banners-layout-1-jtdyfa", "banners/main-demo-banners-layout-1-sBNSgQ", "banners/main-demo-banners-layout-1-WuXGTk", "banners/main-demo-banners-layout-2-IBnMgE", "banners/main-demo-banners-layout-2-jlrQnV", "banners/main-demo-banners-layout-2-TKJoDr", "banners/main-demo-banners-layout-3-qwIMMa", "banners/main-demo-banners-layout-3-zQDKCt", "banners/main-demo-banners-layout-3-zQDKCtdPzt", "banners/main-demo-ewEgIs", "contact/main-demo-contact-layout-2-jyjkPXZyChwyIs", "contact/main-demo-contact-layout-3-lWMtgt", "contact/main-demo-contact-layout-3-uNpBnL", "contact/main-demo-contact-layout-4-LgPham", "contact/main-demo-contact-layout-4-ShFjvz", "contact/main-demo-contact-layout-5-NYBLia", "newsletter/main-demo-newsletter-mpjyeP", "newsletter/main-demo-newsletter-tPKBjb", "newsletter/main-demo-newsletter-UkdVGv", "newsletter/main-demo-newsletter-UKhNrc", "newsletter/main-demo-newsletter-ZhcCUU", "number/main-demo-counters-puDxAq", "number/main-demo-counters-puDxAqhxvk", "number/main-demo-counters-puDxAqySOY", "number/main-demo-ewEgIsLkaY", "others/main-demo-enKHjR", "others/main-demo-image-comparison-SwAktj", "others/main-demo-timeline-KIEemj", "others/main-demo-timeline-KIEemjVzHt", "others/main-demo-WMfPVI", "posts/main-demo-blog-carousel-NJApzH", "posts/main-demo-blog-carousel-oDeont", "posts/main-demo-blog-carousel-qeXTxT", "posts/main-demo-blog-classic-buEwMv", "posts/main-demo-blog-shadow-FzRvfo", "posts/main-demo-blog-slider-JFOdmo", "posts/main-demo-blog-slider-tcKqPj", "posts/main-demo-blog-split-dXjJrT", "posts/main-demo-blog-VTSbGQ", "posts/main-demo-qtsopv", "pricing-table/main-demo-departements-cardiac-surgery-FtMkSP", "pricing-table/main-demo-pricing-tables-CjBNPk", "pricing-table/main-demo-pricing-tables-EgYjpI", "pricing-table/main-demo-pricing-tables-magyuT", "pricing-table/main-demo-pricing-tables-RoRKQz", "service-column/main-demo-about-zKwVFu", "service-column/main-demo-appointment-layout-1-MiqTbf", "service-column/main-demo-departements-qKcYjf", "service-column/main-demo-FjJRvz", "service-column/main-demo-services-pack-1-xUsVzJlfQsAIOcxNFa", "service-column/main-demo-services-pack-1-xUsVzJlfQsAIOcxNFapIki", "service-column/main-demo-services-pack-1-xUsVzJlfQsAIOcxNFapIkipjzQ", "service-column/main-demo-services-pack-1-xUsVzJlfQsrutz", "service-column/main-demo-services-pack-1-xUsVzJlfQsrutzdFjF", "service-column/main-demo-services-pack-2-xUsVzJlfQs", "service-column/main-demo-services-pack-2-xUsVzJlfQsRAUh", "service-column/main-demo-services-pack-2-xUsVzJlfQsUOgO", "service-column/main-demo-services-pack-2-xUsVzJlfQsUOgOjkCf", "service-column/main-demo-services-pack-2-xUsVzJlfQsUOgOjkCfjPWD", "service-column/main-demo-services-pack-3-CtXWAH", "service-column/main-demo-services-pack-3-FjJRvz", "service-column/main-demo-services-pack-3-HTezKX", "service-column/main-demo-services-pack-3-HTezKXDiPz", "service-column/main-demo-services-pack-3-xUsVzJ", "service-column/main-demo-services-pack-3-xUsVzJEQWV", "service-column/main-demo-services-pack-4-FjJRvz", "service-column/main-demo-services-pack-4-xUsVzJrMoR", "service-column/main-demo-services-pack-4-xUsVzJrMoRBLbD", "service-column/main-demo-services-pack-4-xUsVzJrMoRxWOb", "service-column/main-demo-services-pack-5-CtXWAH", "service-column/main-demo-services-pack-5-FjJRvz", "service-column/main-demo-services-pack-5-HTezKX", "service-column/main-demo-services-pack-6-xUsVzJ", "service-column/main-demo-services-pack-6-xUsVzJlfQs", "service-column/main-demo-services-pack-6-xUsVzJlfQsAIOc", "service-column/main-demo-services-pack-6-xUsVzJlfQsrutzlSyu", "services-carousel/main-demo-services-carousel-kbyqSy", "services-carousel/main-demo-VfKEYV", "social-icons/main-demo-contact-layout-2-jyjkPXZyCh", "social-icons/main-demo-contact-layout-2-jyjkPXZyChwyIsxXHI", "social-icons/main-demo-social-icons-pROOaM", "social-icons/main-demo-social-icons-xlTUJS", "staff/main-demo-about-JOcdXZ", "staff/main-demo-GDyYfl", "staff/main-demo-staff-classic-RAdRyZ", "staff/main-demo-staff-classic-RAdRyZpTmK", "staff/main-demo-staff-left-aligned-RAdRyZ", "staff/main-demo-staff-left-aligned-RAdRyZpTmK", "staff/main-demo-staff-shadow-RAdRyZ", "staff/main-demo-staff-shadow-RAdRyZpTmK", "staff/main-demo-staff-stack-RAdRyZ", "staff/main-demo-staff-stack-RAdRyZpTmK", "tabs/main-demo-accordion-OEVosr", "tabs/main-demo-appointment-layout-1-OEVosr", "tabs/main-demo-faq-BUlIUM", "tabs/main-demo-tabs-gXGLMF", "tabs/main-demo-tabs-htxtce", "tabs/main-demo-tabs-igGDQM", "tabs/main-demo-tabs-mwmGeB", "tabs/main-demo-tabs-zBkoKY", "testimonials/main-demo-LTRRRE", "testimonials/main-demo-testimonials-dutyQg", "testimonials/main-demo-testimonials-ebIaDZ", "testimonials/main-demo-testimonials-hkwKLN", "testimonials/main-demo-testimonials-hlkXum", "testimonials/main-demo-testimonials-IbtBkE", "testimonials/main-demo-testimonials-KOVIzL", "testimonials/main-demo-testimonials-mRWIdH", "testimonials/main-demo-testimonials-SzzLOz",
    );
    return $elements;
}

?>
