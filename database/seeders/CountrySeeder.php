<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()

    {
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AF', 'timezone' => 'Asia/Kabul'],
            ['name' => 'Åland Islands', 'code' => 'AX', 'timezone' => 'Europe/Mariehamn'],
            ['name' => 'Albania', 'code' => 'AL', 'timezone' => 'Europe/Tirane'],
            ['name' => 'Algeria', 'code' => 'DZ', 'timezone' => 'Africa/Algiers'],
            ['name' => 'American Samoa', 'code' => 'AS', 'timezone' => 'Pacific/Pago_Pago'],
            ['name' => 'Andorra', 'code' => 'AD', 'timezone' => 'Europe/Andorra'],
            ['name' => 'Angola', 'code' => 'AO', 'timezone' => 'Africa/Luanda'],
            ['name' => 'Anguilla', 'code' => 'AI', 'timezone' => 'America/Anguilla'],
            ['name' => 'Antarctica', 'code' => 'AQ', 'timezone' => 'Antarctica/McMurdo'],
            ['name' => 'Antigua and Barbuda', 'code' => 'AG', 'timezone' => 'America/Antigua'],
            ['name' => 'Argentina', 'code' => 'AR', 'timezone' => 'America/Buenos_Aires'],
            ['name' => 'Armenia', 'code' => 'AM', 'timezone' => 'Asia/Yerevan'],
            ['name' => 'Aruba', 'code' => 'AW', 'timezone' => 'America/Oranjestad'],
            ['name' => 'Australia', 'code' => 'AU', 'timezone' => 'Australia/Sydney'],
            ['name' => 'Austria', 'code' => 'AT', 'timezone' => 'Europe/Vienna'],
            ['name' => 'Azerbaijan', 'code' => 'AZ', 'timezone' => 'Asia/Baku'],
            ['name' => 'Bahamas', 'code' => 'BS', 'timezone' => 'America/Nassau'],
            ['name' => 'Bahrain', 'code' => 'BH', 'timezone' => 'Asia/Bahrain'],
            ['name' => 'Bangladesh', 'code' => 'BD', 'timezone' => 'Asia/Dhaka'],
            ['name' => 'Barbados', 'code' => 'BB', 'timezone' => 'America/Barbados'],
            ['name' => 'Belarus', 'code' => 'BY', 'timezone' => 'Europe/Minsk'],
            ['name' => 'Belgium', 'code' => 'BE', 'timezone' => 'Europe/Brussels'],
            ['name' => 'Belize', 'code' => 'BZ', 'timezone' => 'America/Belize'],
            ['name' => 'Benin', 'code' => 'BJ', 'timezone' => 'Africa/Porto-Novo'],
            ['name' => 'Bermuda', 'code' => 'BM', 'timezone' => 'Atlantic/Bermuda'],
            ['name' => 'Bhutan', 'code' => 'BT', 'timezone' => 'Asia/Thimphu'],
            ['name' => 'Bolivia, Plurinational State of', 'code' => 'BO', 'timezone' => 'America/La_Paz'],
            ['name' => 'Bonaire, Sint Eustatius and Saba', 'code' => 'BQ', 'timezone' => 'America/Kralendijk'],
            ['name' => 'Bosnia and Herzegovina', 'code' => 'BA', 'timezone' => 'Europe/Sarajevo'],
            ['name' => 'Botswana', 'code' => 'BW', 'timezone' => 'Africa/Gaborone'],
            ['name' => 'Bouvet Island', 'code' => 'BV', 'timezone' => 'Europe/Oslo'],
            ['name' => 'Brazil', 'code' => 'BR', 'timezone' => 'America/Sao_Paulo'],
            ['name' => 'British Indian Ocean Territory', 'code' => 'IO', 'timezone' => 'Indian/Antananarivo'],
            ['name' => 'Brunei Darussalam', 'code' => 'BN', 'timezone' => 'Asia/Brunei'],
            ['name' => 'Bulgaria', 'code' => 'BG', 'timezone' => 'Europe/Sofia'],
            ['name' => 'Burkina Faso', 'code' => 'BF', 'timezone' => 'Africa/Ouagadougou'],
            ['name' => 'Burundi', 'code' => 'BI', 'timezone' => 'Africa/Bujumbura'],
            ['name' => 'Cambodia', 'code' => 'KH', 'timezone' => 'Asia/Phnom_Penh'],
            ['name' => 'Cameroon', 'code' => 'CM', 'timezone' => 'Africa/Douala'],
            ['name' => 'Canada', 'code' => 'CA', 'timezone' => 'America/Toronto'],
            ['name' => 'Cape Verde', 'code' => 'CV', 'timezone' => 'Atlantic/Cape_Verde'],
            ['name' => 'Cayman Islands', 'code' => 'KY', 'timezone' => 'America/Grand_Turk'],
            ['name' => 'Central African Republic', 'code' => 'CF', 'timezone' => 'Africa/Bangui'],
            ['name' => 'Chad', 'code' => 'TD', 'timezone' => 'Africa/Ndjamena'],
            ['name' => 'Chile', 'code' => 'CL', 'timezone' => 'America/Santiago'],
            ['name' => 'China', 'code' => 'CN', 'timezone' => 'Asia/Shanghai'],
            ['name' => 'Christmas Island', 'code' => 'CX', 'timezone' => 'Indian/Christmas'],
            ['name' => 'Cocos (Keeling) Islands', 'code' => 'CC', 'timezone' => 'Indian/Cocos'],
            ['name' => 'Colombia', 'code' => 'CO', 'timezone' => 'America/Bogota'],
            ['name' => 'Comoros', 'code' => 'KM', 'timezone' => 'Africa/Moroni'],
            ['name' => 'Congo', 'code' => 'CG', 'timezone' => 'Africa/Brazzaville'],
            ['name' => 'Congo, the Democratic Republic of the', 'code' => 'CD', 'timezone' => 'Africa/Lubumbashi'],
            ['name' => 'Cook Islands', 'code' => 'CK', 'timezone' => 'Pacific/Rarotonga'],
            ['name' => 'Costa Rica', 'code' => 'CR', 'timezone' => 'America/Costa_Rica'],
            ['name' => 'Côte d\'Ivoire', 'code' => 'CI', 'timezone' => 'Africa/Abidjan'],
            ['name' => 'Croatia', 'code' => 'HR', 'timezone' => 'Europe/Zagreb'],
            ['name' => 'Cuba', 'code' => 'CU', 'timezone' => 'America/Havana'],
            ['name' => 'Curaçao', 'code' => 'CW', 'timezone' => 'America/Curacao'],
            ['name' => 'Cyprus', 'code' => 'CY', 'timezone' => 'Asia/Nicosia'],
            ['name' => 'Czech Republic', 'code' => 'CZ', 'timezone' => 'Europe/Prague'],
            ['name' => 'Denmark', 'code' => 'DK', 'timezone' => 'Europe/Copenhagen'],
            ['name' => 'Djibouti', 'code' => 'DJ', 'timezone' => 'Africa/Djibouti'],
            ['name' => 'Dominica', 'code' => 'DM', 'timezone' => 'America/Dominica'],
            ['name' => 'Dominican Republic', 'code' => 'DO', 'timezone' => 'America/Santo_Domingo'],
            ['name' => 'Ecuador', 'code' => 'EC', 'timezone' => 'America/Guayaquil'],
            ['name' => 'Egypt', 'code' => 'EG', 'timezone' => 'Africa/Cairo'],
            ['name' => 'El Salvador', 'code' => 'SV', 'timezone' => 'America/El_Salvador'],
            ['name' => 'Equatorial Guinea', 'code' => 'GQ', 'timezone' => 'Africa/Malabo'],
            ['name' => 'Eritrea', 'code' => 'ER', 'timezone' => 'Africa/Asmara'],
            ['name' => 'Estonia', 'code' => 'EE', 'timezone' => 'Europe/Tallinn'],
            ['name' => 'Ethiopia', 'code' => 'ET', 'timezone' => 'Africa/Addis_Ababa'],
            ['name' => 'Falkland Islands (Malvinas)', 'code' => 'FK', 'timezone' => 'Atlantic/Stanley'],
            ['name' => 'Faroe Islands', 'code' => 'FO', 'timezone' => 'Atlantic/Faroe'],
            ['name' => 'Fiji', 'code' => 'FJ', 'timezone' => 'Pacific/Fiji'],
            ['name' => 'Finland', 'code' => 'FI', 'timezone' => 'Europe/Helsinki'],
            ['name' => 'France', 'code' => 'FR', 'timezone' => 'Europe/Paris'],
            ['name' => 'French Guiana', 'code' => 'GF', 'timezone' => 'America/Cayenne'],
            ['name' => 'French Polynesia', 'code' => 'PF', 'timezone' => 'Pacific/Tahiti'],
            ['name' => 'French Southern Territories', 'code' => 'TF', 'timezone' => 'Indian/Kerguelen'],
            ['name' => 'Gabon', 'code' => 'GA', 'timezone' => 'Africa/Libreville'],
            ['name' => 'Gambia', 'code' => 'GM', 'timezone' => 'Africa/BanJul'],
            ['name' => 'Georgia', 'code' => 'GE', 'timezone' => 'Asia/Tbilisi'],
            ['name' => 'Germany', 'code' => 'DE', 'timezone' => 'Europe/Berlin'],
            ['name' => 'Ghana', 'code' => 'GH', 'timezone' => 'Africa/Accra'],
            ['name' => 'Gibraltar', 'code' => 'GI', 'timezone' => 'Europe/Gibraltar'],
            ['name' => 'Greece', 'code' => 'GR', 'timezone' => 'Europe/Athens'],
            ['name' => 'Greenland', 'code' => 'GL', 'timezone' => 'America/Godthab'],
            ['name' => 'Grenada', 'code' => 'GD', 'timezone' => 'America/Grenada'],
            ['name' => 'Guadeloupe', 'code' => 'GP', 'timezone' => 'America/Grand_Turk'],
            ['name' => 'Guam', 'code' => 'GU', 'timezone' => 'ChST'],
            ['name' => 'Guatemala', 'code' => 'GT', 'timezone' => 'America/Guatemala'],
            ['name' => 'Guernsey', 'code' => 'GG', 'timezone' => 'Europe/Guernsey'],
            ['name' => 'Guinea', 'code' => 'GN', 'timezone' => 'Africa/Conakry'],
            ['name' => 'Guinea-Bissau', 'code' => 'GW', 'timezone' => 'Africa/Bissau'],
            ['name' => 'Guyana', 'code' => 'GY', 'timezone' => 'America/Guyana'],
            ['name' => 'Haiti', 'code' => 'HT', 'timezone' => 'America/Port-au-Prince'],
            ['name' => 'Heard Island and McDonald Mcdonald Islands', 'code' => 'HM', 'timezone' => 'Indian/Kerguelen'],
            ['name' => 'Holy See (Vatican City State)', 'code' => 'VA', 'timezone' => 'Europe/Vatican'],
            ['name' => 'Honduras', 'code' => 'HN', 'timezone' => 'America/Tegucigalpa'],
            ['name' => 'Hong Kong', 'code' => 'HK', 'timezone' => 'Asia/Hong_Kong'],
            ['name' => 'Hungary', 'code' => 'HU', 'timezone' => 'Europe/Budapest'],
            ['name' => 'Iceland', 'code' => 'IS', 'timezone' => 'Atlantic/Reykjavik'],
            ['name' => 'India', 'code' => 'IN', 'timezone' => 'Asia/Kolkata'],
            ['name' => 'Indonesia', 'code' => 'ID', 'timezone' => 'Asia/Jakarta'],
            ['name' => 'Iran, Islamic Republic of', 'code' => 'IR', 'timezone' => 'Asia/Tehran'],
            ['name' => 'Iraq', 'code' => 'IQ', 'timezone' => 'Asia/Baghdad'],
            ['name' => 'Ireland', 'code' => 'IE', 'timezone' => 'Europe/Dublin'],
            ['name' => 'Isle of Man', 'code' => 'IM', 'timezone' => 'Europe/Isle_of_Man'],
            ['name' => 'Israel', 'code' => 'IL', 'timezone' => 'Asia/Jerusalem'],
            ['name' => 'Italy', 'code' => 'IT', 'timezone' => 'Europe/Rome'],
            ['name' => 'Jamaica', 'code' => 'JM', 'timezone' => 'America/Jamaica'],
            ['name' => 'Japan', 'code' => 'JP', 'timezone' => 'Asia/Tokyo'],
            ['name' => 'Jersey', 'code' => 'JE', 'timezone' => 'Europe/Jersey'],
            ['name' => 'Jordan', 'code' => 'JO', 'timezone' => 'Asia/Amman'],
            ['name' => 'Kazakhstan', 'code' => 'KZ', 'timezone' => 'Asia/Almaty'],
            ['name' => 'Kenya', 'code' => 'KE', 'timezone' => 'Africa/Nairobi'],
            ['name' => 'Kiribati', 'code' => 'KI', 'timezone' => 'Pacific/Tarawa'],
            ['name' => 'Korea, Democratic People\'s Republic of', 'code' => 'KP', 'timezone' => 'Asia/Pyongyang'],
            ['name' => 'Korea, Republic of', 'code' => 'KR', 'timezone' => 'Asia/Seoul'],
            ['name' => 'Kuwait', 'code' => 'KW', 'timezone' => 'Asia/Kuwait'],
            ['name' => 'Kyrgyzstan', 'code' => 'KG', 'timezone' => 'Asia/Bishkek'],
            ['name' => 'Lao People\'s Democratic Republic', 'code' => 'LA', 'timezone' => 'Asia/Vientiane'],
            ['name' => 'Latvia', 'code' => 'LV', 'timezone' => 'Europe/Riga'],
            ['name' => 'Lebanon', 'code' => 'LB', 'timezone' => 'Asia/Beirut'],
            ['name' => 'Lesotho', 'code' => 'LS', 'timezone' => 'Africa/Maseru'],
            ['name' => 'Liberia', 'code' => 'LR', 'timezone' => 'Africa/Monrovia'],
            ['name' => 'Libya', 'code' => 'LY', 'timezone' => 'Africa/Tripoli'],
            ['name' => 'Liechtenstein', 'code' => 'LI', 'timezone' => 'Europe/Vaduz'],
            ['name' => 'Lithuania', 'code' => 'LT', 'timezone' => 'Europe/Vilnius'],
            ['name' => 'Luxembourg', 'code' => 'LU', 'timezone' => 'Europe/Luxembourg'],
            ['name' => 'Macao', 'code' => 'MO', 'timezone' => 'Asia/Macau'],
            ['name' => 'Macedonia, the Former Yugoslav Republic of', 'code' => 'MK', 'timezone' => 'Europe/Skopje'],
            ['name' => 'Madagascar', 'code' => 'MG', 'timezone' => 'Indian/Antananarivo'],
            ['name' => 'Malawi', 'code' => 'MW', 'timezone' => 'Africa/Blantyre'],
            ['name' => 'Malaysia', 'code' => 'MY', 'timezone' => 'Asia/Kuala_Lumpur'],
            ['name' => 'Maldives', 'code' => 'MV', 'timezone' => 'Indian/Maldives'],
            ['name' => 'Mali', 'code' => 'ML', 'timezone' => 'Africa/Bamako'],
            ['name' => 'Malta', 'code' => 'MT', 'timezone' => 'Europe/Malta'],
            ['name' => 'Marshall Islands', 'code' => 'MH', 'timezone' => 'Pacific/Majuro'],
            ['name' => 'Martinique', 'code' => 'MQ', 'timezone' => 'America/Martinique'],
            ['name' => 'Mauritania', 'code' => 'MR', 'timezone' => 'Africa/Nouakchott'],
            ['name' => 'Mauritius', 'code' => 'MU', 'timezone' => 'Indian/Mauritius'],
            ['name' => 'Mayotte', 'code' => 'YT', 'timezone' => 'Indian/Mayotte'],
            ['name' => 'Mexico', 'code' => 'MX', 'timezone' => 'America/Mexico_City'],
            ['name' => 'Micronesia, Federated States of', 'code' => 'FM', 'timezone' => 'Pacific/Chuuk'],
            ['name' => 'Moldova, Republic of', 'code' => 'MD', 'timezone' => 'Europe/Chisinau'],
            ['name' => 'Monaco', 'code' => 'MC', 'timezone' => 'Europe/Monaco'],
            ['name' => 'Mongolia', 'code' => 'MN', 'timezone' => 'Asia/Ulaanbaatar'],
            ['name' => 'Montenegro', 'code' => 'ME', 'timezone' => 'Europe/Podgorica'],
            ['name' => 'Montserrat', 'code' => 'MS', 'timezone' => 'America/Montserrat'],
            ['name' => 'Morocco', 'code' => 'MA', 'timezone' => 'Africa/Casablanca'],
            ['name' => 'Mozambique', 'code' => 'MZ', 'timezone' => 'Africa/Maputo'],
            ['name' => 'Myanmar', 'code' => 'MM', 'timezone' => 'Asia/Yangon'],
            ['name' => 'Namibia', 'code' => 'NA', 'timezone' => 'Africa/Windhoek'],
            ['name' => 'Nauru', 'code' => 'NR', 'timezone' => 'Pacific/Nauru'],
            ['name' => 'Nepal', 'code' => 'NP', 'timezone' => 'Asia/Kathmandu'],
            ['name' => 'Netherlands', 'code' => 'NL', 'timezone' => 'Europe/Amsterdam'],
            ['name' => 'New Caledonia', 'code' => 'NC', 'timezone' => 'Pacific/Noumea'],
            ['name' => 'New Zealand', 'code' => 'NZ', 'timezone' => 'Pacific/Auckland'],
            ['name' => 'Nicaragua', 'code' => 'NI', 'timezone' => 'America/Managua'],
            ['name' => 'Niger', 'code' => 'NE', 'timezone' => 'Africa/Niamey'],
            ['name' => 'Nigeria', 'code' => 'NG', 'timezone' => 'Africa/Lagos'],
            ['name' => 'Niue', 'code' => 'NU', 'timezone' => 'Pacific/Niue'],
            ['name' => 'Norfolk Island', 'code' => 'NF', 'timezone' => 'Pacific/Norfolk'],
            ['name' => 'Northern Mariana Islands', 'code' => 'MP', 'timezone' => 'Pacific/Saipan'],
            ['name' => 'Norway', 'code' => 'NO', 'timezone' => 'Europe/Oslo'],
            ['name' => 'Oman', 'code' => 'OM', 'timezone' => 'Asia/Muscat'],
            ['name' => 'Pakistan', 'code' => 'PK', 'timezone' => 'Asia/Karachi'],
            ['name' => 'Palau', 'code' => 'PW', 'timezone' => 'Pacific/Palau'],
            ['name' => 'Palestine, State of', 'code' => 'PS', 'timezone' => 'Asia/Hebron'],
            ['name' => 'Panama', 'code' => 'PA', 'timezone' => 'America/Panama'],
            ['name' => 'Papua New Guinea', 'code' => 'PG', 'timezone' => 'Pacific/Port_Moresby'],
            ['name' => 'Paraguay', 'code' => 'PY', 'timezone' => 'America/Asuncion'],
            ['name' => 'Peru', 'code' => 'PE', 'timezone' => 'America/Lima'],
            ['name' => 'Philippines', 'code' => 'PH', 'timezone' => 'Asia/Manila'],
            ['name' => 'Pitcairn', 'code' => 'PN', 'timezone' => 'Pacific/Pitcairn'],
            ['name' => 'Poland', 'code' => 'PL', 'timezone' => 'Europe/Warsaw'],
            ['name' => 'Portugal', 'code' => 'PT', 'timezone' => 'Europe/Lisbon'],
            ['name' => 'Puerto Rico', 'code' => 'PR', 'timezone' => 'America/Puerto_Rico'],
            ['name' => 'Qatar', 'code' => 'QA', 'timezone' => 'Asia/Qatar'],
            ['name' => 'Réunion', 'code' => 'RE', 'timezone' => 'Indian/Reunion'],
            ['name' => 'Romania', 'code' => 'RO', 'timezone' => 'Europe/Bucharest'],
            ['name' => 'Russian Federation', 'code' => 'RU', 'timezone' => 'Europe/Moscow'],
            ['name' => 'Rwanda', 'code' => 'RW', 'timezone' => 'Africa/Kigali'],
            ['name' => 'Saint Barthélemy', 'code' => 'BL', 'timezone' => 'America/St_Barthelemy'],
            ['name' => 'Saint Helena, Ascension and Tristan da Cunha', 'code' => 'SH', 'timezone' => 'Atlantic/St_Helena'],
            ['name' => 'Saint Kitts and Nevis', 'code' => 'KN', 'timezone' => 'America/St_Kitts'],
            ['name' => 'Saint Lucia', 'code' => 'LC', 'timezone' => 'America/St_Lucia'],
            ['name' => 'Saint Martin (French part)', 'code' => 'MF', 'timezone' => 'America/Marigot'],
            ['name' => 'Saint Pierre and Miquelon', 'code' => 'PM', 'timezone' => 'America/Miquelon'],
            ['name' => 'Saint Vincent and the Grenadines', 'code' => 'VC', 'timezone' => 'America/St_Vincent'],
            ['name' => 'Samoa', 'code' => 'WS', 'timezone' => 'Pacific/Apia'],
            ['name' => 'San Marino', 'code' => 'SM', 'timezone' => 'Europe/San_Marino'],
            ['name' => 'Sao Tome and Principe', 'code' => 'ST', 'timezone' => 'Africa/Sao_Tome'],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'timezone' => 'Asia/Riyadh'],
            ['name' => 'Senegal', 'code' => 'SN', 'timezone' => 'Africa/Dakar'],
            ['name' => 'Serbia', 'code' => 'RS', 'timezone' => 'Europe/Belgrade'],
            ['name' => 'Seychelles', 'code' => 'SC', 'timezone' => 'Indian/Mahe'],
            ['name' => 'Sierra Leone', 'code' => 'SL', 'timezone' => 'Africa/Freetown'],
            ['name' => 'Singapore', 'code' => 'SG', 'timezone' => 'Asia/Singapore'],
            ['name' => 'Sint Maarten (Dutch part)', 'code' => 'SX', 'timezone' => 'America/Lower_Princes'],
            ['name' => 'Slovakia', 'code' => 'SK', 'timezone' => 'Europe/Bratislava'],
            ['name' => 'Slovenia', 'code' => 'SI', 'timezone' => 'Europe/Ljubljana'],
            ['name' => 'Solomon Islands', 'code' => 'SB', 'timezone' => 'Pacific/Guadalcanal'],
            ['name' => 'Somalia', 'code' => 'SO', 'timezone' => 'Africa/Mogadishu'],
            ['name' => 'South Africa', 'code' => 'ZA', 'timezone' => 'Africa/Johannesburg'],
            ['name' => 'South Georgia and the South Sandwich Islands', 'code' => 'GS', 'timezone' => 'Atlantic/South_Georgia'],
            ['name' => 'South Sudan', 'code' => 'SS', 'timezone' => 'Africa/Juba'],
            ['name' => 'Spain', 'code' => 'ES', 'timezone' => 'Europe/Madrid'],
            ['name' => 'Sri Lanka', 'code' => 'LK', 'timezone' => 'Asia/Colombo'],
            ['name' => 'Sudan', 'code' => 'SD', 'timezone' => 'Africa/Khartoum'],
            ['name' => 'Suriname', 'code' => 'SR', 'timezone' => 'America/Paramaribo'],
            ['name' => 'Svalbard and Jan Mayen', 'code' => 'SJ', 'timezone' => 'Europe/Longyearbyen'],
            ['name' => 'Swaziland', 'code' => 'SZ', 'timezone' => 'Africa/Mbabane'],
            ['name' => 'Sweden', 'code' => 'SE', 'timezone' => 'Europe/Stockholm'],
            ['name' => 'Switzerland', 'code' => 'CH', 'timezone' => 'Europe/Zurich'],
            ['name' => 'Syrian Arab Republic', 'code' => 'SY', 'timezone' => 'Asia/Damascus'],
            ['name' => 'Taiwan', 'code' => 'TW', 'timezone' => 'Asia/Taipei'],
            ['name' => 'Tajikistan', 'code' => 'TJ', 'timezone' => 'Asia/Dushanbe'],
            ['name' => 'Tanzania, United Republic of', 'code' => 'TZ', 'timezone' => 'Africa/Dar_es_Salaam'],
            ['name' => 'Thailand', 'code' => 'TH', 'timezone' => 'Asia/Bangkok'],
            ['name' => 'Timor-Leste', 'code' => 'TL', 'timezone' => 'Asia/Dili'],
            ['name' => 'Togo', 'code' => 'TG', 'timezone' => 'Africa/Lome'],
            ['name' => 'Tokelau', 'code' => 'TK', 'timezone' => 'Pacific/Fakaofo'],
            ['name' => 'Tonga', 'code' => 'TO', 'timezone' => 'Pacific/Tongatapu'],
            ['name' => 'Trinidad and Tobago', 'code' => 'TT', 'timezone' => 'America/Port_of_Spain'],
            ['name' => 'Tunisia', 'code' => 'TN', 'timezone' => 'Africa/Tunis'],
            ['name' => 'Turkey', 'code' => 'TR', 'timezone' => 'Europe/Istanbul'],
            ['name' => 'Turkmenistan', 'code' => 'TM', 'timezone' => 'Asia/Ashgabat'],
            ['name' => 'Turks and Caicos Islands', 'code' => 'TC', 'timezone' => 'America/Grand_Turk'],
            ['name' => 'Tuvalu', 'code' => 'TV', 'timezone' => 'Pacific/Funafuti'],
            ['name' => 'Uganda', 'code' => 'UG', 'timezone' => 'Africa/Kampala'],
            ['name' => 'Ukraine', 'code' => 'UA', 'timezone' => 'Europe/Kiev'],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'timezone' => 'Asia/Dubai'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'timezone' => 'Europe/London'],
            ['name' => 'United States', 'code' => 'US', 'timezone' => 'America/New_York'],
            ['name' => 'United States Minor Outlying Islands', 'code' => 'UM', 'timezone' => 'Pacific/Wake'],
            ['name' => 'Uruguay', 'code' => 'UY', 'timezone' => 'America/Montevideo'],
            ['name' => 'Uzbekistan', 'code' => 'UZ', 'timezone' => 'Asia/Tashkent'],
            ['name' => 'Vanuatu', 'code' => 'VU', 'timezone' => 'Pacific/Efate'],
            ['name' => 'Venezuela, Bolivarian Republic of', 'code' => 'VE', 'timezone' => 'America/Caracas'],
            ['name' => 'Viet Nam', 'code' => 'VN', 'timezone' => 'Asia/Ho_Chi_Minh'],
            ['name' => 'Virgin Islands, British', 'code' => 'VG', 'timezone' => 'America/Tortola'],
            ['name' => 'Virgin Islands, U.S.', 'code' => 'VI', 'timezone' => 'America/St_Thomas'],
            ['name' => 'Wallis and Futuna', 'code' => 'WF', 'timezone' => 'Pacific/Wallis'],
            ['name' => 'Western Sahara', 'code' => 'EH', 'timezone' => 'Africa/El_Aaiun'],
            ['name' => 'Yemen', 'code' => 'YE', 'timezone' => 'Asia/Aden'],
            ['name' => 'Zambia', 'code' => 'ZM', 'timezone' => 'Africa/Lusaka'],
            ['name' => 'Zimbabwe', 'code' => 'ZW', 'timezone' => 'Africa/Harare'],
        ];

        foreach ($countries as $key => $value) {
            Country::firstOrCreate($value);
        }
    }
}


