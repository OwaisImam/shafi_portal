<?php

namespace App\Constants;

use App\Models\EmailTemplate;

class DefaultValues
{
    const INACTIVE = 'inactive';
    const ACTIVE = 'active';
    const VERIFIED = 'verfied';
    const NOTVERIFIED = 'not_verfied';

    const SUPERDMIN = 'super_admin';
    const ADMIN = 'admin';
    const CUSTOMER = 'customer';

    const CURRENCY = '$';

    const PAGINATION_LIMIT = 10;
    const SERVICE_ICONS = [
        'flaticon-wifi-signal',
        'flaticon-multimedia',
        'flaticon-wifi',
        'flaticon-speedometer',
        'flaticon-speedometer-1',
        'flaticon-download-to-storage-drive',
        'flaticon-support',
        'flaticon-arrow-pointing-to-right',
        'flaticon-care-about-environment',
        'flaticon-technical-support',
        'flaticon-router',
        'flaticon-wifi-1',
        'flaticon-wifi-signal-tower',
        'flaticon-online-shop',
        'flaticon-key',
        'flaticon-shield',
        'flaticon-resume',
        'flaticon-check-mark',
        'flaticon-help',
        'flaticon-add',
        'flaticon-remove',
        'flaticon-facebook',
        'flaticon-facebook-message',
        'flaticon-download-arrow',
        'flaticon-paper-plane',
        'flaticon-quote-left',
        'flaticon-place',
        'flaticon-address-book',
        'flaticon-signal',
        'flaticon-pdf',
        'flaticon-txt',
    ];

    const PORTFOLIO_CATEGORIES = [
        'Embroidery Digitize', 'Vector Digitize',
    ];

    const PERMISSION_MODULES = [
    'Services', 'Feature', 'Plans', 'Faqs', 'Email Templates', 'Quotation',
    'Quotation Request', 'Orders', 'Blogs', 'Invoice', 'Users', 'Roles & Permissions',
    'SMTP Settings', 'Header', 'Footer', 'Pages', 'Business Setting',
    'Portfolio',
    'Testimonial',
    'Clients',
    'Reports',
    'Leads',
    ];

    const TIMEZONES = [
        '(GMT-12:00) International Date Line West' => 'Pacific/Wake',
        '(GMT-11:00) Midway Island' => 'Pacific/Apia',
        '(GMT-11:00) Samoa' => 'Pacific/Apia',
        '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
        '(GMT-09:00) Alaska' => 'America/Anchorage',
        '(GMT-08:00) Pacific Time (US &amp; Canada); Tijuana' => 'America/Los_Angeles',
        '(GMT-07:00) Arizona' => 'America/Phoenix',
        '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
        '(GMT-07:00) La Paz' => 'America/Chihuahua',
        '(GMT-07:00) Mazatlan' => 'America/Chihuahua',
        '(GMT-07:00) Mountain Time (US &amp; Canada)' => 'America/Denver',
        '(GMT-06:00) Central America' => 'America/Managua',
        '(GMT-06:00) Central Time (US &amp; Canada)' => 'America/Chicago',
        '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
        '(GMT-06:00) Mexico City' => 'America/Mexico_City',
        '(GMT-06:00) Monterrey' => 'America/Mexico_City',
        '(GMT-06:00) Saskatchewan' => 'America/Regina',
        '(GMT-05:00) Bogota' => 'America/Bogota',
        '(GMT-05:00) Eastern Time (US &amp; Canada)' => 'America/New_York',
        '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
        '(GMT-05:00) Lima' => 'America/Bogota',
        '(GMT-05:00) Quito' => 'America/Bogota',
        '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
        '(GMT-04:00) Caracas' => 'America/Caracas',
        '(GMT-04:00) La Paz' => 'America/Caracas',
        '(GMT-04:00) Santiago' => 'America/Santiago',
        '(GMT-03:30) Newfoundland' => 'America/St_Johns',
        '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
        '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Greenland' => 'America/Godthab',
        '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
        '(GMT-01:00) Azores' => 'Atlantic/Azores',
        '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(GMT) Casablanca' => 'Africa/Casablanca',
        '(GMT) Edinburgh' => 'Europe/London',
        '(GMT) Greenwich Mean Time : Dublin' => 'Europe/London',
        '(GMT) Lisbon' => 'Europe/London',
        '(GMT) London' => 'Europe/London',
        '(GMT) Monrovia' => 'Africa/Casablanca',
        '(GMT+01:00) Amsterdam' => 'Europe/Berlin',
        '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
        '(GMT+01:00) Berlin' => 'Europe/Berlin',
        '(GMT+01:00) Bern' => 'Europe/Berlin',
        '(GMT+01:00) Bratislava' => 'Europe/Belgrade',
        '(GMT+01:00) Brussels' => 'Europe/Paris',
        '(GMT+01:00) Budapest' => 'Europe/Belgrade',
        '(GMT+01:00) Copenhagen' => 'Europe/Paris',
        '(GMT+01:00) Ljubljana' => 'Europe/Belgrade',
        '(GMT+01:00) Madrid' => 'Europe/Paris',
        '(GMT+01:00) Paris' => 'Europe/Paris',
        '(GMT+01:00) Prague' => 'Europe/Belgrade',
        '(GMT+01:00) Rome' => 'Europe/Berlin',
        '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(GMT+01:00) Skopje' => 'Europe/Sarajevo',
        '(GMT+01:00) Stockholm' => 'Europe/Berlin',
        '(GMT+01:00) Vienna' => 'Europe/Berlin',
        '(GMT+01:00) Warsaw' => 'Europe/Sarajevo',
        '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
        '(GMT+01:00) Zagreb' => 'Europe/Sarajevo',
        '(GMT+02:00) Athens' => 'Europe/Istanbul',
        '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
        '(GMT+02:00) Cairo' => 'Africa/Cairo',
        '(GMT+02:00) Harare' => 'Africa/Johannesburg',
        '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
        '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
        '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(GMT+02:00) Kyiv' => 'Europe/Helsinki',
        '(GMT+02:00) Minsk' => 'Europe/Istanbul',
        '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
        '(GMT+02:00) Riga' => 'Europe/Helsinki',
        '(GMT+02:00) Sofia' => 'Europe/Helsinki',
        '(GMT+02:00) Tallinn' => 'Europe/Helsinki',
        '(GMT+02:00) Vilnius' => 'Europe/Helsinki',
        '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
        '(GMT+03:00) Kuwait' => 'Asia/Riyadh',
        '(GMT+03:00) Moscow' => 'Europe/Moscow',
        '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
        '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
        '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
        '(GMT+03:00) Volgograd' => 'Europe/Moscow',
        '(GMT+03:30) Tehran' => 'Asia/Tehran',
        '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(GMT+04:00) Baku' => 'Asia/Tbilisi',
        '(GMT+04:00) Muscat' => 'Asia/Muscat',
        '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(GMT+04:00) Yerevan' => 'Asia/Tbilisi',
        '(GMT+04:30) Kabul' => 'Asia/Kabul',
        '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(GMT+05:00) Islamabad' => 'Asia/Karachi',
        '(GMT+05:00) Karachi' => 'Asia/Karachi',
        '(GMT+05:00) Tashkent' => 'Asia/Karachi',
        '(GMT+05:30) Chennai' => 'Asia/Calcutta',
        '(GMT+05:30) Kolkata' => 'Asia/Calcutta',
        '(GMT+05:30) Mumbai' => 'Asia/Calcutta',
        '(GMT+05:30) New Delhi' => 'Asia/Calcutta',
        '(GMT+05:45) Kathmandu' => 'Asia/Katmandu',
        '(GMT+06:00) Almaty' => 'Asia/Novosibirsk',
        '(GMT+06:00) Astana' => 'Asia/Dhaka',
        '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
        '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
        '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
        '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
        '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
        '(GMT+07:00) Jakarta' => 'Asia/Bangkok',
        '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
        '(GMT+08:00) Chongqing' => 'Asia/Hong_Kong',
        '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
        '(GMT+08:00) Kuala Lumpur' => 'Asia/Singapore',
        '(GMT+08:00) Perth' => 'Australia/Perth',
        '(GMT+08:00) Singapore' => 'Asia/Singapore',
        '(GMT+08:00) Taipei' => 'Asia/Taipei',
        '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
        '(GMT+08:00) Urumqi' => 'Asia/Hong_Kong',
        '(GMT+09:00) Osaka' => 'Asia/Tokyo',
        '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
        '(GMT+09:00) Seoul' => 'Asia/Seoul',
        '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
        '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
        '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
        '(GMT+09:30) Darwin' => 'Australia/Darwin',
        '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
        '(GMT+10:00) Canberra' => 'Australia/Sydney',
        '(GMT+10:00) Guam' => 'Pacific/Guam',
        '(GMT+10:00) Hobart' => 'Australia/Hobart',
        '(GMT+10:00) Melbourne' => 'Australia/Sydney',
        '(GMT+10:00) Port Moresby' => 'Pacific/Guam',
        '(GMT+10:00) Sydney' => 'Australia/Sydney',
        '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
        '(GMT+11:00) Magadan' => 'Asia/Magadan',
        '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
        '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
        '(GMT+12:00) Auckland' => 'Pacific/Auckland',
        '(GMT+12:00) Fiji' => 'Pacific/Fiji',
        '(GMT+12:00) Kamchatka' => 'Pacific/Fiji',
        '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(GMT+12:00) Wellington' => 'Pacific/Auckland',
        '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu',
    ];

    public static function prepareEmailBody($templateKey, $params = [], $subjectParams = [])
    {
        $template = EmailTemplate::where('key', $templateKey)->first();

        $subject = $template->subject;
        $content = $template->content;

        if (count($subjectParams) > 0) {

            foreach ($subjectParams as $key => $value) {

                $subject = str_contains($subject, $key) ? str_replace($key, $value, $subject) : $subject;
            }
        }

        if (count($params) > 0) {

            foreach ($params as $key => $value) {

                $content = str_contains($content, $key) ? str_replace($key, $value, $content) : $content;
            }
        }

        return [
            'subject' => $subject,
            'content' => $content,
        ];
    }
}
