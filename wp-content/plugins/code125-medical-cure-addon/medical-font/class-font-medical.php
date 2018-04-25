<?php

/**
*
*/
class C5_MEDICAL_FONT
{

    function __construct()
    {
        add_filter('c5_add_icons' , array($this, 'fonts'));
        add_filter('c5_add_icons' , array($this, 'web_medical_font'));

        add_action( 'wp_enqueue_scripts', array($this, 'style_enqueue') );
        add_action( 'admin_enqueue_scripts', array($this, 'style_enqueue') );

    }
    public function style_enqueue()
    {
        wp_enqueue_style( 'medical-font', C5_MC_URL . 'medical-font/flaticon.css' );
        wp_enqueue_style( 'medical-font-flaticon', C5_MC_URL . 'medical-font/flaticon/flaticon.css' );
        wp_enqueue_style( 'webfont-medical-font', C5_MC_URL . 'medical-font/webfont-medical-icons/wfmi-style.css' );
    }

    public function fonts($all_icons)
    {
        $icons = array(
            'flaticon-ambulance',
            'flaticon-band-aid',
            'flaticon-dna',
            'flaticon-first-aid-kit',
            'flaticon-heart',
            'flaticon-hospital',
            'flaticon-injury',
            'flaticon-lungs',
            'flaticon-medical-history',
            'flaticon-medicine',
            'flaticon-medicine-1',
            'flaticon-medicine-2',
            'flaticon-nurse',
            'flaticon-pill',
            'flaticon-surgeon',
            'flaticon-syringe',
            'flaticon-thermometer',
            'flaticon-tooth',
            'flaticon-transfusion',
            'flaticon-wheelchair',
        );
        foreach ($icons as $icon) {
            $all_icons[] = array('title'=> ucfirst(str_replace("flaticon-", "", $icon)) , 'value' => $icon);
        }
        return $all_icons;
    }

    public function web_medical_font($all_icons)
    {
        $icons = array(

            'icon-i-womens-health',
            'icon-i-waiting-area',
            'icon-i-volume-control',
            'icon-i-ultrasound',
            'icon-i-text-telephone',
            'icon-i-surgery',
            'icon-i-stairs',
            'icon-i-radiology',
            'icon-i-physical-therapy',
            'icon-i-pharmacy',
            'icon-i-pediatrics',
            'icon-i-pathology',
            'icon-i-outpatient',
            'icon-i-mental-health',
            'icon-i-medical-records',
            'icon-i-medical-library',
            'icon-i-mammography',
            'icon-i-laboratory',
            'icon-i-labor-delivery',
            'icon-i-immunizations',
            'icon-i-imaging-root-category',
            'icon-i-imaging-alternative-pet',
            'icon-i-imaging-alternative-mri',
            'icon-i-imaging-alternative-mri-two',
            'icon-i-imaging-alternative-ct',
            'icon-i-fire-extinguisher',
            'icon-i-family-practice',
            'icon-i-emergency',
            'icon-i-elevators',
            'icon-i-ear-nose-throat',
            'icon-i-drinking-fountain',
            'icon-i-cardiology',
            'icon-i-billing',
            'icon-i-anesthesia',
            'icon-i-ambulance',
            'icon-i-alternative-complementary',
            'icon-i-administration',
            'icon-i-social-services',
            'icon-i-smoking',
            'icon-i-restrooms',
            'icon-i-restaurant',
            'icon-i-respiratory',
            'icon-i-registration',
            'icon-i-oncology',
            'icon-i-nutrition',
            'icon-i-nursery',
            'icon-i-no-smoking',
            'icon-i-neurology',
            'icon-i-mri-pet',
            'icon-i-interpreter-services',
            'icon-i-internal-medicine',
            'icon-i-intensive-care',
            'icon-i-inpatient',
            'icon-i-information-us',
            'icon-i-infectious-diseases',
            'icon-i-hearing-assistance',
            'icon-i-health-services',
            'icon-i-health-education',
            'icon-i-gift-shop',
            'icon-i-genetics',
            'icon-i-first-aid',
            'icon-i-dermatology',
            'icon-i-dental',
            'icon-i-coffee-shop',
            'icon-i-chapel',
            'icon-i-cath-lab',
            'icon-i-care-staff-area',
            'icon-i-accessibility',
            'icon-i-diabetes-education',
            'icon-i-hospital',
            'icon-i-kidney',
            'icon-i-ophthalmology',
            'icon-womens-health',
            'icon-waiting-area',
            'icon-volume-control',
            'icon-ultrasound',
            'icon-text-telephone',
            'icon-surgery',
            'icon-stairs',
            'icon-radiology',
            'icon-physical-therapy',
            'icon-pharmacy',
            'icon-pediatrics',
            'icon-pathology',
            'icon-outpatient',
            'icon-ophthalmology',
            'icon-mental-health',
            'icon-medical-records',
            'icon-medical-library',
            'icon-mammography',
            'icon-laboratory',
            'icon-labor-delivery',
            'icon-kidney',
            'icon-immunizations',
            'icon-imaging-root-category',
            'icon-imaging-alternative-pet',
            'icon-imaging-alternative-mri',
            'icon-imaging-alternative-mri-two',
            'icon-imaging-alternative-ct',
            'icon-hospital',
            'icon-fire-extinguisher',
            'icon-family-practice',
            'icon-emergency',
            'icon-elevators',
            'icon-ear-nose-throat',
            'icon-drinking-fountain',
            'icon-diabetes-education',
            'icon-cardiology',
            'icon-billing',
            'icon-anesthesia',
            'icon-ambulance',
            'icon-alternative-complementary',
            'icon-administration',
            'icon-accessibility',
            'icon-social-services',
            'icon-smoking',
            'icon-restrooms',
            'icon-restaurant',
            'icon-respiratory',
            'icon-oncology',
            'icon-nutrition',
            'icon-nursery',
            'icon-no-smoking',
            'icon-neurology',
            'icon-mri-pet',
            'icon-interpreter-services',
            'icon-internal-medicine',
            'icon-intensive-care',
            'icon-inpatient',
            'icon-information-us',
            'icon-infectious-diseases',
            'icon-hearing-assistance',
            'icon-health-services',
            'icon-health-education',
            'icon-gift-shop',
            'icon-genetics',
            'icon-first-aid',
            'icon-dental',
            'icon-coffee-shop',
            'icon-chapel',
            'icon-cath-lab',
            'icon-care-staff-area',
            'icon-registration',
            'icon-dermatology',

            //new flaticon

            'flaticon-molar-crown',
            'flaticon-molar-3',
            'flaticon-molar-2',
            'flaticon-molar-1',
            'flaticon-gum',
            'flaticon-molar',
            'flaticon-premolar',
            'flaticon-teeth',
            'flaticon-implants',
            'flaticon-pills',
            'flaticon-2-pills',
            'flaticon-medicine-1',
            'flaticon-medical',
            'flaticon-eye-1',
            'flaticon-science-1',
            'flaticon-science',
            'flaticon-epidermis',
            'flaticon-pimples',
            'flaticon-head',
            'flaticon-throat',
            'flaticon-x-ray-2',
            'flaticon-lungs-2',
            'flaticon-x-ray-of-bones',
            'flaticon-x-ray-1',
            'flaticon-mother-with-baby-in-arms',
            'flaticon-baby-with-diaper',
            'flaticon-patient',
            'flaticon-rehabilitation',
            'flaticon-first-aid-kit',
            'flaticon-heart-1',
            'flaticon-doctor-1',
            'flaticon-cardiogram-and-heart',
            'flaticon-heart',
            'flaticon-transport-1',
            'flaticon-transport',
            'flaticon-blood',
            'flaticon-health-care',
            'flaticon-ambulance',
            'flaticon-nurse-1',
            'flaticon-wheelchair-2',
            'flaticon-wheelchair-1',
            'flaticon-lungs-1',
            'flaticon-ear',
            'flaticon-dentist',
            'flaticon-hospital-bed',
            'flaticon-nurse',
            'flaticon-prescription',
            'flaticon-hospital',
            'flaticon-lungs',
            'flaticon-medicine',
            'flaticon-wheelchair',
            'flaticon-dna',
            'flaticon-bone',
            'flaticon-eye',
            'flaticon-weighing-scale',
            'flaticon-doctor',
            'flaticon-tooth',
            'flaticon-stomach',
            'flaticon-emergency-call',
            'flaticon-syringe',
            'flaticon-x-ray',
            'flaticon-treatment',
            'flaticon-magnifying-glass-1',
            'flaticon-technology-2',
            'flaticon-plus-symbol',
            'flaticon-check',
            'flaticon-technology-1',
            'flaticon-checkmark-outlined-circular-button',
            'flaticon-symbol',
            'flaticon-facebook-placeholder-for-locate-places-on-maps',
            'flaticon-quotes',
            'flaticon-interface-1', 
            'flaticon-next',
            'flaticon-magnifying-glass',
            'flaticon-placeholder',
            'flaticon-calendar-1',
            'flaticon-add',
            'flaticon-plus',
            'flaticon-view',
            'flaticon-calendar',
            'flaticon-multimedia',
            'flaticon-technology',
            'flaticon-clock-1',
            'flaticon-interface',
            'flaticon-clock',
        );
        foreach ($icons as $icon) {
            $all_icons[] = array('title'=> ucfirst(str_replace("icon-", "", $icon)) , 'value' => $icon);
        }
        return $all_icons;
    }
}
$obj = new C5_MEDICAL_FONT();

?>