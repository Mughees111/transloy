<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin']="admin/dashboard";
$route['admin/logout']="admin/login/logout";
$route['admin/user-auth'] = 'admin/dashboard/auth_check';
$route['admin/notification'] = 'admin/dashboard/notification';
$route['admin/all-notifications'] = 'admin/dashboard/all_notifications';
$route['admin/notification-detail/(:num)'] = 'admin/dashboard/detail/$1';
$route['admin/my-profile'] = 'admin/myprofile/index';


$route['admin/push-notifications'] = 'admin/push/index';
$route['admin/push-notifications/send'] = 'admin/push/send';



///withdraws Routes
$route['admin/withdraws'] = 'admin/withdraws/index';
$route['admin/withdraw-status/(:num)/(:num)'] = 'admin/withdraws/status/$1/$2';





///Categories Routes
$route['admin/categories'] = 'admin/categories/index';
$route['admin/add-category'] = 'admin/categories/add';
$route['admin/category-status/(:num)/(:num)'] = 'admin/categories/status/$1/$2';
$route['admin/edit-category/(:num)'] = 'admin/categories/edit/$1';
$route['admin/delete-category/(:num)'] = 'admin/categories/delete/$1';
$route['admin/trash-categories'] = "admin/categories/trash";
$route['admin/restore-category/(:num)'] = 'admin/categories/restore/$1';
$route['admin/category-display-order'] = 'admin/categories/display_order';




///holidays Routes
$route['admin/holidays'] = 'admin/holidays/index';
$route['admin/add-holiday'] = 'admin/holidays/add';
$route['admin/delete-holiday/(:num)'] = 'admin/holidays/delete/$1';


///leaves Routes
$route['admin/leaves'] = 'admin/leaves/index';
$route['admin/delete-leave/(:num)'] = 'admin/leaves/delete/$1';



///sites Routes
$route['admin/sites'] = 'admin/sites/index';
$route['admin/add-site'] = 'admin/sites/add';
$route['admin/site-status/(:num)/(:num)'] = 'admin/sites/status/$1/$2';
$route['admin/edit-site/(:num)'] = 'admin/sites/edit/$1';
$route['admin/delete-site/(:num)'] = 'admin/sites/delete/$1';
$route['admin/trash-sites'] = "admin/sites/trash";
$route['admin/restore-site/(:num)'] = 'admin/sites/restore/$1';
$route['admin/site-display-order'] = 'admin/sites/display_order';



///departments Routes
$route['admin/departments'] = 'admin/departments/index';
$route['admin/add-department'] = 'admin/departments/add';
$route['admin/department-status/(:num)/(:num)'] = 'admin/departments/status/$1/$2';
$route['admin/edit-department/(:num)'] = 'admin/departments/edit/$1';
$route['admin/delete-department/(:num)'] = 'admin/departments/delete/$1';
$route['admin/trash-departments'] = "admin/departments/trash";
$route['admin/restore-department/(:num)'] = 'admin/departments/restore/$1';

///teams Routes
$route['admin/teams'] = 'admin/teams/index';
$route['admin/add-team'] = 'admin/teams/add';
$route['admin/team-status/(:num)/(:num)'] = 'admin/teams/status/$1/$2';
$route['admin/edit-team/(:num)'] = 'admin/teams/edit/$1';
$route['admin/delete-team/(:num)'] = 'admin/teams/delete/$1';
$route['admin/trash-teams'] = "admin/teams/trash";
$route['admin/restore-team/(:num)'] = 'admin/teams/restore/$1';



///Brands Routes
$route['admin/brands'] = 'admin/brands/index';
$route['admin/add-brand'] = 'admin/brands/add';
$route['admin/brand-status/(:num)/(:num)'] = 'admin/brands/status/$1/$2';
$route['admin/edit-brand/(:num)'] = 'admin/brands/edit/$1';
$route['admin/delete-brand/(:num)'] = 'admin/brands/delete/$1';
$route['admin/trash-brands'] = "admin/brands/trash";
$route['admin/restore-brand/(:num)'] = 'admin/brands/restore/$1';



///Parties Routes
$route['admin/parties'] = 'admin/parties/index';
$route['admin/party-details/(:num)'] = 'admin/parties/details/$1';
$route['admin/party-status/(:num)/(:num)'] = 'admin/parties/status/$1/$2';
$route['admin/delete-party/(:num)'] = 'admin/parties/delete/$1';
$route['admin/trash-parties'] = "admin/parties/trash";
$route['admin/restore-party/(:num)'] = 'admin/parties/restore/$1';



///invites Routes
$route['admin/invites'] = 'admin/invites/index';
$route['admin/refund-invite/(:num)'] = 'admin/invites/refund/$1';


///Sliders Routes
$route['admin/sliders'] = 'admin/sliders/index';
$route['admin/add-slider'] = 'admin/sliders/add';
$route['admin/slider-status/(:num)/(:num)'] = 'admin/sliders/status/$1/$2';
$route['admin/edit-slider/(:num)'] = 'admin/sliders/edit/$1';
$route['admin/delete-slider/(:num)'] = 'admin/sliders/delete/$1';
$route['admin/trash-sliders'] = "admin/sliders/trash";
$route['admin/restore-slider/(:num)'] = 'admin/sliders/restore/$1';

///Coupons Routes
$route['admin/coupons'] = 'admin/coupons/index';
$route['admin/add-coupon'] = 'admin/coupons/add';
$route['admin/coupon-status/(:num)/(:num)'] = 'admin/coupons/status/$1/$2';
$route['admin/edit-coupon/(:num)'] = 'admin/coupons/edit/$1';
$route['admin/delete-coupon/(:num)'] = 'admin/coupons/delete/$1';
$route['admin/trash-coupons'] = "admin/coupons/trash";
$route['admin/restore-coupon/(:num)'] = 'admin/coupons/restore/$1';


///Stores Routes
$route['admin/stores'] = 'admin/stores/index';
$route['admin/add-store'] = 'admin/stores/add';
$route['admin/store-status/(:num)/(:num)'] = 'admin/stores/status/$1/$2';
$route['admin/edit-store/(:num)'] = 'admin/stores/edit/$1';
$route['admin/delete-store/(:num)'] = 'admin/stores/delete/$1';
$route['admin/trash-stores'] = "admin/stores/trash";
$route['admin/restore-store/(:num)'] = 'admin/stores/restore/$1';

///languages Routes
$route['admin/languages'] = 'admin/languages/index';
$route['admin/add-language'] = 'admin/languages/add';
$route['admin/language-status/(:num)/(:num)'] = 'admin/languages/status/$1/$2';
$route['admin/language-default/(:num)/(:num)'] = 'admin/languages/default/$1/$2';
$route['admin/edit-language/(:num)'] = 'admin/languages/edit/$1';
$route['admin/delete-language/(:num)'] = 'admin/languages/delete/$1';
$route['admin/trash-languages'] = "admin/languages/trash";
$route['admin/restore-language/(:num)'] = 'admin/languages/restore/$1';


///Company Details Routes
$route['admin/company-details'] = 'admin/company_details/index';
$route['admin/add-company-detail'] = 'admin/company_details/add';
$route['admin/company-detail-status/(:num)/(:num)'] = 'admin/company_details/status/$1/$2';
$route['admin/edit-company-detail/(:num)'] = 'admin/company_details/edit/$1';
$route['admin/delete-company-detail/(:num)'] = 'admin/company_details/delete/$1';
$route['admin/trash-company-details'] = "admin/company_details/trash";
$route['admin/restore-company-detail/(:num)'] = 'admin/company_details/restore/$1';


///Payment Methods Routes
$route['admin/payment-methods'] = 'admin/payment_methods/index';
$route['admin/edit-payment-method/(:num)'] = 'admin/payment_methods/edit/$1';

///Invoice Templates Routes
$route['admin/invoice-templates'] = 'admin/invoice_templates/index';
$route['admin/view-invoice-template/(:num)'] = 'admin/invoice_templates/view/$1';
$route['admin/view-invoice-template/(:num)/(:num)'] = 'admin/invoice_templates/view/$1/$2';


///FAQs Routes
$route['admin/faqs'] = 'admin/faqs/index';
$route['admin/add-faq'] = 'admin/faqs/add';
$route['admin/faq-status/(:num)/(:num)'] = 'admin/faqs/status/$1/$2';
$route['admin/edit-faq/(:num)'] = 'admin/faqs/edit/$1';
$route['admin/delete-faq/(:num)'] = 'admin/faqs/delete/$1';
$route['admin/trash-faqs'] = "admin/faqs/trash";
$route['admin/restore-faq/(:num)'] = 'admin/faqs/restore/$1';


///Questions Routes
$route['admin/questions'] = 'admin/questions/index';
$route['admin/add-question'] = 'admin/questions/add';
$route['admin/question-status/(:num)/(:num)'] = 'admin/questions/status/$1/$2';
$route['admin/edit-question/(:num)'] = 'admin/questions/edit/$1';
$route['admin/delete-question/(:num)'] = 'admin/questions/delete/$1';
$route['admin/trash-questions'] = "admin/questions/trash";
$route['admin/restore-question/(:num)'] = 'admin/questions/restore/$1';


///Questions Routes
$route['admin/questionnaires'] = 'admin/questionnaires/index';
$route['admin/add-questionnaire'] = 'admin/questionnaires/add';
$route['admin/questionnaire-status/(:num)/(:num)'] = 'admin/questionnaires/status/$1/$2';
$route['admin/edit-questionnaire/(:num)'] = 'admin/questionnaires/edit/$1';
$route['admin/delete-questionnaire/(:num)'] = 'admin/questionnaires/delete/$1';
$route['admin/trash-questionnaires'] = "admin/questionnaires/trash";
$route['admin/restore-questionnaire/(:num)'] = 'admin/questionnaires/restore/$1';


///Quantity Units Routes
$route['admin/quantity-units'] = 'admin/quantity_units/index';
$route['admin/add-quantity-unit'] = 'admin/quantity_units/add';
$route['admin/quantity-unit-status/(:num)/(:num)'] = 'admin/quantity_units/status/$1/$2';
$route['admin/edit-quantity-unit/(:num)'] = 'admin/quantity_units/edit/$1';
$route['admin/delete-quantity-unit/(:num)'] = 'admin/quantity_units/delete/$1';
$route['admin/trash-quantity-units'] = "admin/quantity_units/trash";
$route['admin/restore-quantity-unit/(:num)'] = 'admin/quantity_units/restore/$1';


///Product Routes
$route['admin/products'] = 'admin/products/index';
$route['admin/product/(:num)'] = 'admin/products/details/$1';
$route['admin/add-product'] = 'admin/products/add';
$route['admin/product-status/(:num)/(:num)'] = 'admin/products/status/$1/$2';
$route['admin/edit-product/(:num)'] = 'admin/products/edit/$1';
$route['admin/delete-product/(:num)'] = 'admin/products/delete/$1';
$route['admin/delete-product-image/(:num)'] = 'admin/products/delete_image/$1';
$route['admin/trash-products'] = "admin/products/trash";
$route['admin/restore-product/(:num)'] = 'admin/products/restore/$1';


///Offers Routes
$route['admin/offers'] = 'admin/offers/index';
$route['admin/add-offer'] = 'admin/offers/add';
$route['admin/offer-status/(:num)/(:num)'] = 'admin/offers/status/$1/$2';
$route['admin/edit-offer/(:num)'] = 'admin/offers/edit/$1';
$route['admin/delete-offer/(:num)'] = 'admin/offers/delete/$1';
$route['admin/trash-offers'] = "admin/offers/trash";
$route['admin/restore-offer/(:num)'] = 'admin/offers/restore/$1';
$route['admin/send-offer-as-newsletter/(:num)'] = 'admin/offers/send_as_newsletter/$1';



///Notifications Routes
$route['admin/notifications'] = 'admin/notifications/index';
$route['admin/add-notification'] = 'admin/notifications/add';
$route['admin/notification-status/(:num)/(:num)'] = 'admin/notifications/status/$1/$2';
$route['admin/edit-notification/(:num)'] = 'admin/notifications/edit/$1';
$route['admin/delete-notification/(:num)'] = 'admin/notifications/delete/$1';
$route['admin/trash-notifications'] = "admin/notifications/trash";
$route['admin/restore-notification/(:num)'] = 'admin/notifications/restore/$1';


///Admins Routes
$route['admin/admins'] = 'admin/admins/index';
$route['admin/add-admin'] = 'admin/admins/add';
$route['admin/admin-status/(:num)/(:num)'] = 'admin/admins/status/$1/$2';
$route['admin/edit-admin/(:num)'] = 'admin/admins/edit/$1';
$route['admin/trash-admins'] = 'admin/admins/trash';
$route['admin/delete-admin/(:num)'] = 'admin/admins/delete/$1';
$route['admin/restore-admin/(:num)'] = 'admin/admins/restore/$1';
$route['admin/admin-detail/(:num)'] = 'admin/admins/admin_detail/$1';
$route['admin/edit-admin-roles/(:num)'] = 'admin/admins/edit_admin_roles/$1';



///managers Routes
$route['admin/managers'] = 'admin/managers/index';
$route['admin/add-manager'] = 'admin/managers/add';
//$route['admin/admin-status/(:num)/(:num)'] = 'admin/managers/status/$1/$2';
$route['admin/edit-manager/(:num)'] = 'admin/managers/edit/$1';
$route['admin/trash-managers'] = 'admin/managers/trash';
$route['admin/delete-manager/(:num)'] = 'admin/managers/delete/$1';
$route['admin/restore-manager/(:num)'] = 'admin/managers/restore/$1';
$route['admin/manager-detail/(:num)'] = 'admin/managers/admin_detail/$1';
$route['admin/edit-manager-roles/(:num)'] = 'admin/managers/edit_admin_roles/$1';


///Emails Routes
$route['admin/emails'] = 'admin/emails/index';
$route['admin/add-email'] = 'admin/emails/add';
$route['admin/email-status/(:num)/(:num)'] = 'admin/emails/status/$1/$2';
$route['admin/edit-email/(:num)'] = 'admin/emails/edit/$1';
$route['admin/delete-email/(:num)'] = 'admin/emails/delete/$1';
$route['admin/trash-emails'] = "admin/emails/trash";
$route['admin/restore-email/(:num)'] = 'admin/emails/restore/$1';


///Pages Routes
$route['admin/pages'] = 'admin/pages/index';
$route['admin/add-page'] = 'admin/pages/add';
$route['admin/page-status/(:num)/(:num)'] = 'admin/pages/status/$1/$2';
$route['admin/edit-page/(:num)'] = 'admin/pages/edit/$1';
$route['admin/delete-page/(:num)'] = 'admin/pages/delete/$1';
$route['admin/trash-pages'] = "admin/pages/trash";
$route['admin/restore-page/(:num)'] = 'admin/pages/restore/$1';


///Reports Routes
$route['admin/reports'] = 'admin/reports/index';
$route['admin/presence_trends'] = 'admin/reports/presence_trends';
$route['admin/report-employee'] = 'admin/reports/report';
//$route['admin/report-employee'] = 'admin/reports/presence_trends';

///Petty Cash Routes
$route['admin/pettycash'] = 'admin/pettycash/index';

///employees Routes
$route['admin/employees'] = 'admin/employees/index';
$route['admin/add-employee'] = 'admin/employees/add';
$route['admin/employee-status/(:num)/(:num)'] = 'admin/employees/status/$1/$2';
$route['admin/employee-report'] = 'admin/employees/report';
$route['admin/edit-employee/(:num)'] = 'admin/employees/edit/$1';
$route['admin/delete-employee/(:num)'] = 'admin/employees/delete/$1';
$route['admin/trash-employees'] = "admin/employees/trash";
$route['admin/restore-employee/(:num)'] = 'admin/employees/restore/$1';
$route['admin/reset-password-employee/(:num)'] = 'admin/employees/password/$1';



///Orders Routes
$route['admin/orders'] = 'admin/orders/index';
$route['admin/add-order'] = 'admin/orders/add';
$route['admin/order-status/(:num)/(:num)'] = 'admin/orders/status/$1/$2';
$route['admin/edit-order/(:num)'] = 'admin/orders/edit/$1';
$route['admin/delete-order/(:num)'] = 'admin/orders/delete/$1';
$route['admin/trash-orders'] = "admin/orders/trash";
$route['admin/restore-order/(:num)'] = 'admin/orders/restore/$1';



///Affiliates Routes
$route['admin/affiliates'] = 'admin/affiliates/index';
$route['admin/add-affiliate'] = 'admin/affiliates/add';
$route['admin/affiliate-status/(:num)/(:num)'] = 'admin/affiliates/status/$1/$2';
$route['admin/edit-affiliate/(:num)'] = 'admin/affiliates/edit/$1';
$route['admin/delete-affiliate/(:num)'] = 'admin/affiliates/delete/$1';
$route['admin/trash-affiliates'] = "admin/affiliates/trash";
$route['admin/restore-affiliate/(:num)'] = 'admin/affiliates/restore/$1';


///// Location Routes
$route['admin/get-states'] = 'admin/location/get_stats_by_country_id';
$route['admin/get-cities'] = 'admin/location/get_city_by_state_id';