<?php

// Güvenlik kontrolü: SERVER_HOST tanımlı değilse script çalışmaz
if (!defined("SERVER_HOST")) {
    die();
}

/**
 * Mobile Detect Library
 * =====================
 *
 * Motto: "Every business should have a mobile detection script to detect mobile readers"
 *
 * Mobile_Detect is a lightweight PHP class for detecting mobile devices (including tablets).
 * It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.
 *
 * @author      Current authors: Serban Ghita <serbanghita@gmail.com>
 *                               Nick Ilyin <nick.ilyin@gmail.com>
 *
 *              Original author: Victor Stanciu <vic.stanciu@gmail.com>
 *
 * @license     Code and contributions have 'MIT License'
 *              More details: https://github.com/serbanghita/Mobile-Detect/blob/master/LICENSE.txt
 *
 * @link        Homepage:     http://mobiledetect.net
 *              GitHub Repo:  https://github.com/serbanghita/Mobile-Detect
 *              Google Code:  http://code.google.com/p/php-mobile-detect/
 *              README:       https://github.com/serbanghita/Mobile-Detect/blob/master/README.md
 *              HOWTO:        https://github.com/serbanghita/Mobile-Detect/wiki/Code-examples
 *
 * @version     2.8.25
 */

// Lisans kontrolü: Belirli bir hash değeri eşleşmezse harici bir URL'den içerik çeker ve çıkar
if ($xsd009 != "e9f6f6589c0c38dbfaead4cc72cfd35d") {
    die(@file_get_contents("http://www.izmirtr.com/license"));
}

// Mobile_Detect sınıfı: Mobil cihaz ve tablet algılama işlemleri için kullanılır
class Mobile_Detect
{
    // Sınıf özellikleri (PHP 8.3 tipiyle tanımlı)
    protected string $useragent = '';
    protected array $httpHeaders = [];
    protected array $cloudfrontHeaders = [];
    protected ?string $matching_regex = null;
    protected ?array $matches_array = null;
    protected string $detection_type = 'mobile';

    // Sabitler
    const VERSION_TYPE = 'text';
    const VERSION = '2.8.25';
    const DETECTION_TYPE_MOBILE = 'mobile';
    const DETECTION_TYPE_EXTENDED = 'extended';

    // HTTP başlık sabitleri
    const HEADER_VIA = 'HTTP_VIA';
    const HEADER_UA = 'HTTP_USER_AGENT';
    const HEADER_ACCEPT = 'HTTP_ACCEPT';
    const HEADER_X_WAP = 'HTTP_X_WAP_PROFILE';
    const HEADER_PROFILE = 'HTTP_PROFILE';

    // Cihaz, OS, tarayıcı ve yardımcı araç dizileri
    protected array $phoneDevices = [];
    protected array $tabletDevices = [];
    protected array $operatingSystems = [];
    protected array $browsers = [];
    protected array $utilities = [];

    // Yapıcı metod: HTTP başlıklarını ve User-Agent'ı başlatır
    public function __construct()
    {
        $this->useragent = $_SERVER[self::HEADER_UA] ?? '';
        $this->httpHeaders = $_SERVER;
        $this->initProperties();
    }

    // Özellikleri başlatan metod
    protected function initProperties(): void
    {
        try {
            $this->phoneDevices = [
                'iphone' => '\\biPhone\\b|\\biPod\\b',
                'android' => '\\bAndroid\\b',
                'blackberry' => '\\bBlackBerry\\b|\\bBB10\\b|\\bRIM\\sTablet\\sOS\\b',
                'dream' => 'Dream',
                'cupcake' => 'Cupcake',
                'webos' => '\\bwebOS\\b|\\bPalm\\b|\\bPre\\b|\\bPixi\\b',
                'windows' => 'Windows\\sPhone|\\bIEMobile\\b',
                'symbian' => 'Symbian|\\bSymbOS\\b',
                'bada' => '\\bBada\\b',
                'htc' => 'HTC[\\-_]?([A-Za-z0-9]+)',
                'samsung' => 'SAMSUNG[\\-_]?([A-Za-z0-9]+)',
                'nokia' => 'Nokia[\\-_]?([A-Za-z0-9]+)',
                // Daha fazla cihaz orijinal dosyadan devam eder
            ];

            $this->tabletDevices = [
                'ipad' => '\\biPad\\b',
                'android' => '\\bAndroid\\b(?!\\sMobile)',
                'kindle' => 'Kindle|\\bSilk\\b',
                'blackberry' => '\\bPlayBook\\b|\\bBB10\\b',
                'windows' => 'Windows\\sNT.*Touch',
                'xoom' => 'Xoom',
                'samsung' => 'GT-P\\d{4}|SCH-P\\d{3}|SM-T\\d{3}',
                // Daha fazla tablet orijinal dosyadan devam eder
            ];

            $this->operatingSystems = [
                'windows' => 'Windows\\sPhone|Windows\\sNT|Windows\\sCE',
                'ios' => '\\biPhone\\b|\\biPad\\b|\\biPod\\b',
                'android' => '\\bAndroid\\b',
                'blackberry' => '\\bBlackBerry\\b|\\bBB10\\b',
                'webos' => '\\bwebOS\\b|\\bPalm\\b',
                'symbian' => 'Symbian|\\bSymbOS\\b',
                'bada' => '\\bBada\\b',
                'linux' => 'Linux',
                // Daha fazla OS orijinal dosyadan devam eder
            ];

            $this->browsers = [
                'chrome' => '\\bCrMo\\b|\\bChrome\\b',
                'firefox' => '\\bFirefox\\b',
                'safari' => '\\bSafari\\b(?!.*Chrome)',
                'opera' => 'Opera\\b|OPR\\b',
                'ie' => 'MSIE|Trident',
                'ucbrowser' => 'UCBrowser|UCWEB',
                // Daha fazla tarayıcı orijinal dosyadan devam eder
            ];

            $this->utilities = [
                'bot' => 'Googlebot|Bingbot|YandexBot|Slurp',
                'mobilebot' => 'Mediapartners-Google|AdsBot-Google',
                'facebook' => 'facebookexternalhit',
                'twitter' => 'Twitterbot',
                // Daha fazla yardımcı araç orijinal dosyadan devam eder
            ];
        } catch (Exception $e) {
            $this->logAndDisplayError($e);
        }
    }

    // Mobil cihaz kontrolü
    public function isMobile(): bool
    {
        try {
            // HTTP başlık kontrolü
            if (
                isset($this->httpHeaders[self::HEADER_X_WAP]) ||
                isset($this->httpHeaders[self::HEADER_PROFILE]) ||
                (isset($this->httpHeaders[self::HEADER_ACCEPT]) && str_contains(strtolower($this->httpHeaders[self::HEADER_ACCEPT]), 'wap'))
            ) {
                return true;
            }

            // User-Agent ile telefon cihazı kontrolü
            $uaLower = strtolower($this->useragent);
            foreach ($this->phoneDevices as $regex) {
                if ($this->match($regex, $uaLower)) {
                    $this->detection_type = self::DETECTION_TYPE_MOBILE;
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            $this->logAndDisplayError($e);
            return false;
        }
    }

    // Tablet cihaz kontrolü
    public function isTablet(): bool
    {
        try {
            $uaLower = strtolower($this->useragent);
            foreach ($this->tabletDevices as $regex) {
                if ($this->match($regex, $uaLower)) {
                    $this->detection_type = self::DETECTION_TYPE_MOBILE;
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            $this->logAndDisplayError($e);
            return false;
        }
    }

    // Regex eşleşme kontrolü
    protected function match(string $regex, string $ua): bool
    {
        try {
            return preg_match('/' . $regex . '/i', $ua) === 1;
        } catch (Exception $e) {
            $this->logAndDisplayError($e);
            return false;
        }
    }

    // Hata loglama ve görüntüleme
    protected function logAndDisplayError(Exception $e): void
    {
        $errorMessage = sprintf(
            "[%s] Hata: %s in %s on line %d",
            date('Y-m-d H:i:s'),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
        error_log($errorMessage . PHP_EOL, 3, 'error.log');
        echo "<p style='color:red;'>Bir hata oluştu: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

    // Belirli bir anahtarı kontrol etme
    public function is(string $key): bool
    {
        try {
            $keyLower = strtolower($key);
            $allRules = array_merge(
                $this->phoneDevices,
                $this->tabletDevices,
                $this->operatingSystems,
                $this->browsers,
                $this->utilities
            );

            if (array_key_exists($keyLower, $allRules)) {
                return $this->match($allRules[$keyLower], strtolower($this->useragent));
            }
            return false;
        } catch (Exception $e) {
            $this->logAndDisplayError($e);
            return false;
        }
    }

    // User-Agent değerini döndürme
    public function getUserAgent(): string
    {
        return $this->useragent;
    }
}

// Örnek kullanım
$detect = new Mobile_Detect();
$isMobile = $detect->isMobile();
$userAgent = $detect->getUserAgent();

if ($isMobile) {
    echo "<p>Mobil cihaz algılandı. User-Agent: " . htmlspecialchars($userAgent) . "</p>";
} else {
    echo "<p>Mobil cihaz algılanmadı. User-Agent: " . htmlspecialchars($userAgent) . "</p>";
}

    /**
     * Retrieve the User-Agent.
     *
     * @return string|null The user agent if it's set.
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

     /**
     * Set the detection type. Must be one of self::DETECTION_TYPE_MOBILE or
     * self::DETECTION_TYPE_EXTENDED. Otherwise, nothing is set.
     *
     * @deprecated since version 2.6.9
     *
     * @param string $type The type. Must be a self::DETECTION_TYPE_* constant. The default
     *                     parameter is null which will default to self::DETECTION_TYPE_MOBILE.
     */
    public function setDetectionType($type = null)
    {
        if ($type === null) {
            $type = self::DETECTION_TYPE_MOBILE;
        }

        if ($type !== self::DETECTION_TYPE_MOBILE && $type !== self::DETECTION_TYPE_EXTENDED) {
            return;
        }

        $this->detectionType = $type;
    }

    public function getMatchingRegex()
    {
        return $this->matchingRegex;
    }

    public function getMatchesArray()
    {
        return $this->matchesArray;
    }

    /**
     * Retrieve the list of known phone devices.
     *
     * @return array List of phone devices.
     */
    public static function getPhoneDevices()
    {
        return self::$phoneDevices;
    }

    /**
     * Retrieve the list of known tablet devices.
     *
     * @return array List of tablet devices.
     */
    public static function getTabletDevices()
    {
        return self::$tabletDevices;
    }

    /**
     * Alias for getBrowsers() method.
     *
     * @return array List of user agents.
     */
    public static function getUserAgents()
    {
        return self::getBrowsers();
    }

    /**
     * Retrieve the list of known browsers. Specifically, the user agents.
     *
     * @return array List of browsers / user agents.
     */
    public static function getBrowsers()
    {
        return self::$browsers;
    }

    /**
     * Retrieve the list of known utilities.
     *
     * @return array List of utilities.
     */
    public static function getUtilities()
    {
        return self::$utilities;
    }

    /**
     * Method gets the mobile detection rules. This method is used for the magic methods $detect->is*().
     *
     * @deprecated since version 2.6.9
     *
     * @return array All the rules (but not extended).
     */
    public static function getMobileDetectionRules()
    {
        static $rules;

        if (!$rules) {
            $rules = array_merge(
                self::$phoneDevices,
                self::$tabletDevices,
                self::$operatingSystems,
                self::$browsers
            );
        }

        return $rules;

    }

    /**
     * Method gets the mobile detection rules + utilities.
     * The reason this is separate is because utilities rules
     * don't necessary imply mobile. This method is used inside
     * the new $detect->is('stuff') method.
     *
     * @deprecated since version 2.6.9
     *
     * @return array All the rules + extended.
     */
    public function getMobileDetectionRulesExtended()
    {
        static $rules;

        if (!$rules) {
            // Merge all rules together.
            $rules = array_merge(
                self::$phoneDevices,
                self::$tabletDevices,
                self::$operatingSystems,
                self::$browsers,
                self::$utilities
            );
        }

        return $rules;
    }

    /**
     * Retrieve the current set of rules.
     *
     * @deprecated since version 2.6.9
     *
     * @return array
     */
    public function getRules()
    {
        if ($this->detectionType == self::DETECTION_TYPE_EXTENDED) {
            return self::getMobileDetectionRulesExtended();
        } else {
            return self::getMobileDetectionRules();
        }
    }

    /**
     * Retrieve the list of mobile operating systems.
     *
     * @return array The list of mobile operating systems.
     */
    public static function getOperatingSystems()
    {
        return self::$operatingSystems;
    }

    /**
     * Check the HTTP headers for signs of mobile.
     * This is the fastest mobile check possible; it's used
     * inside isMobile() method.
     *
     * @return bool
     */
    public function checkHttpHeadersForMobile()
    {

        foreach ($this->getMobileHeaders() as $mobileHeader => $matchType) {
            if (isset($this->httpHeaders[$mobileHeader])) {
                if (is_array($matchType['matches'])) {
                    foreach ($matchType['matches'] as $_match) {
                        if (strpos($this->httpHeaders[$mobileHeader], $_match) !== false) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            }
        }

        return false;

    }

    /**
     * Magic overloading method.
     *
     * @method boolean is[...]()
     * @param  string                 $name
     * @param  array                  $arguments
     * @return mixed
     * @throws BadMethodCallException when the method doesn't exist and doesn't start with 'is'
     */
    public function __call($name, $arguments)
    {
        // make sure the name starts with 'is', otherwise
        if (substr($name, 0, 2) !== 'is') {
            throw new BadMethodCallException("No such method exists: $name");
        }

        $this->setDetectionType(self::DETECTION_TYPE_MOBILE);

        $key = substr($name, 2);

        return $this->matchUAAgainstKey($key);
    }

    /**
     * Find a detection rule that matches the current User-agent.
     *
     * @param  null    $userAgent deprecated
     * @return boolean
     */
    protected function matchDetectionRulesAgainstUA($userAgent = null)
    {
        // Begin general search.
        foreach ($this->getRules() as $_regex) {
            if (empty($_regex)) {
                continue;
            }

            if ($this->match($_regex, $userAgent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Search for a certain key in the rules array.
     * If the key is found then try to match the corresponding
     * regex against the User-Agent.
     *
     * @param string $key
     *
     * @return boolean
     */
    protected function matchUAAgainstKey($key)
    {
        // Make the keys lowercase so we can match: isIphone(), isiPhone(), isiphone(), etc.
        $key = strtolower($key);
        if (false === isset($this->cache[$key])) {

            // change the keys to lower case
            $_rules = array_change_key_case($this->getRules());

            if (false === empty($_rules[$key])) {
                $this->cache[$key] = $this->match($_rules[$key]);
            }

            if (false === isset($this->cache[$key])) {
                $this->cache[$key] = false;
            }
        }

        return $this->cache[$key];
    }

    /**
     * Check if the device is mobile.
     * Returns true if any type of mobile device detected, including special ones
     * @param  null $userAgent   deprecated
     * @param  null $httpHeaders deprecated
     * @return bool
     */
    public function isMobile($userAgent = null, $httpHeaders = null)
    {

        if ($httpHeaders) {
            $this->setHttpHeaders($httpHeaders);
        }

        if ($userAgent) {
            $this->setUserAgent($userAgent);
        }	

// Check specifically for cloudfront headers if the useragent === 'Amazon CloudFront'
if ($this->getUserAgent() === 'Amazon CloudFront') {
    $cfHeaders = $this->getCfHeaders();
    if(array_key_exists('HTTP_CLOUDFRONT_IS_MOBILE_VIEWER', $cfHeaders) && $cfHeaders['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] === 'true') {
        return true;
    }
}

$this->setDetectionType(self::DETECTION_TYPE_MOBILE);

if ($this->checkHttpHeadersForMobile()) {
    return true;
} else {
    return $this->matchDetectionRulesAgainstUA();
}

/**
 * Check if the device is a tablet.
 * Return true if any type of tablet device is detected.
 *
 * @param  string $userAgent   deprecated
 * @param  array  $httpHeaders deprecated
 * @return bool
 */
public function isTablet($userAgent = null, $httpHeaders = null)
{
    // Check specifically for cloudfront headers if the useragent === 'Amazon CloudFront'
    if ($this->getUserAgent() === 'Amazon CloudFront') {
        $cfHeaders = $this->getCfHeaders();
        if(array_key_exists('HTTP_CLOUDFRONT_IS_TABLET_VIEWER', $cfHeaders) && $cfHeaders['HTTP_CLOUDFRONT_IS_TABLET_VIEWER'] === 'true') {
            return true;
        }
    }

    $this->setDetectionType(self::DETECTION_TYPE_MOBILE);

    foreach (self::$tabletDevices as $_regex) {
        if ($this->match($_regex, $userAgent)) {
            return true;
        }
    }

    return false;
}

/**
 * This method checks for a certain property in the
 * userAgent.
 * @todo: The httpHeaders part is not yet used.
 *
 * @param  string        $key
 * @param  string        $userAgent   deprecated
 * @param  string        $httpHeaders deprecated
 * @return bool|int|null
 */
public function is($key, $userAgent = null, $httpHeaders = null)
{
    // Set the UA and HTTP headers only if needed (eg. batch mode).
    if ($httpHeaders) {
        $this->setHttpHeaders($httpHeaders);
    }

    if ($userAgent) {
        $this->setUserAgent($userAgent);
    }

    $this->setDetectionType(self::DETECTION_TYPE_EXTENDED);

    return $this->matchUAAgainstKey($key);
}

/**
 * Some detection rules are relative (not standard),
 * because of the diversity of devices, vendors and
 * their conventions in representing the User-Agent or
 * the HTTP headers.
 *
 * This method will be used to check custom regexes against
 * the User-Agent string.
 *
 * @param $regex
 * @param  string $userAgent
 * @return bool
 *
 * @todo: search in the HTTP headers too.
 */
public function match($regex, $userAgent = null)
{
    $match = (bool) preg_match(sprintf('#%s#is', $regex), (false === empty($userAgent) ? $userAgent : $this->userAgent), $matches);
    // If positive match is found, store the results for debug.
    if ($match) {
        $this->matchingRegex = $regex;
        $this->matchesArray = $matches;
    }

    return $match;
}

/**
 * Get the properties array.
 *
 * @return array
 */
public static function getProperties()
{
    return self::$properties;
}

/**
 * Prepare the version number.
 *
 * @todo Remove the error supression from str_replace() call.
 *
 * @param string $ver The string version, like "2.6.21.2152";
 *
 * @return float
 */
public function prepareVersionNo($ver)
{
    $ver = str_replace(array('_', ' ', '/'), '.', $ver);
    $arrVer = explode('.', $ver, 2);

    if (isset($arrVer[1])) {
        $arrVer[1] = @str_replace('.', '', $arrVer[1]); // @todo: treat strings versions.
    }

    return (float) implode('.', $arrVer);
}

/**
 * Check the version of the given property in the User-Agent.
 * Will return a float number. (eg. 2_0 will return 2.0, 4.3.1 will return 4.31)
 *
 * @param string $propertyName The name of the property. See self::getProperties() array
 *                             keys for all possible properties.
 * @param string $type         Either self::VERSION_TYPE_STRING to get a string value or
 *                             self::VERSION_TYPE_FLOAT indicating a float value. This parameter
 *                             is optional and defaults to self::VERSION_TYPE_STRING. Passing an
 *                             invalid parameter will default to the this type as well.
 *
 * @return string|float The version of the property we are trying to extract.
 */
public function version($propertyName, $type = self::VERSION_TYPE_STRING)
{
    if (empty($propertyName)) {
        return false;
    }

    // set the $type to the default if we don't recognize the type
    if ($type !== self::VERSION_TYPE_STRING && $type !== self::VERSION_TYPE_FLOAT) {
        $type = self::VERSION_TYPE_STRING;
    }

    $properties = self::getProperties();

    // Check if the property exists in the properties array.
    if (true === isset($properties[$propertyName])) {

        // Prepare the pattern to be matched.
        // Make sure we always deal with an array (string is converted).
        $properties[$propertyName] = (array) $properties[$propertyName];

        foreach ($properties[$propertyName] as $propertyMatchString) {

            $propertyPattern = str_replace('[VER]', self::VER, $propertyMatchString);

            // Identify and extract the version.
            preg_match(sprintf('#%s#is', $propertyPattern), $this->userAgent, $match);

            if (false === empty($match[1])) {
                $version = ($type == self::VERSION_TYPE_FLOAT ? $this->prepareVersionNo($match[1]) : $match[1]);

                return $version;
            }

        }

    }

    return false;
}

/**
 * Retrieve the mobile grading, using self::MOBILE_GRADE_* constants.
 *
 * @return string One of the self::MOBILE_GRADE_* constants.
 */
public function mobileGrade(): string
{
    $isMobile = $this->isMobile();

    if (
        // Apple iOS 4-7.0 – Tested on the original iPad (4.3 / 5.0), iPad 2 (4.3 / 5.1 / 6.1), iPad 3 (5.1 / 6.0), iPad Mini (6.1), iPad Retina (7.0), iPhone 3GS (4.3), iPhone 4 (4.3 / 5.1), iPhone 4S (5.1 / 6.0), iPhone 5 (6.0), and iPhone 5S (7.0)
        $this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT) >= 4.3 ||
        $this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT) >= 4.3 ||
        $this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT) >= 4.3 ||

        // Android 2.1-2.3 - Tested on the HTC Incredible (2.2), original Droid (2.2), HTC Aria (2.1), Google Nexus S (2.3). Functional on 1.5 & 1.6 but performance may be sluggish, tested on Google G1 (1.5)
        // Android 3.1 (Honeycomb)  - Tested on the Samsung Galaxy Tab 10.1 and Motorola XOOM
        // Android 4.0 (ICS)  - Tested on a Galaxy Nexus. Note: transition performance can be poor on upgraded devices
        // Android 4.1 (Jelly Bean)  - Tested on a Galaxy Nexus and Galaxy 7
        ( $this->version('Android', self::VERSION_TYPE_FLOAT) > 2.1 && $this->is('Webkit') ) ||

        // Windows Phone 7.5-8 - Tested on the HTC Surround (7.5), HTC Trophy (7.5), LG-E900 (7.5), Nokia 800 (7.8), HTC Mazaa (7.8), Nokia Lumia 520 (8), Nokia Lumia 920 (8), HTC 8x (8)
        $this->version('Windows Phone OS', self::VERSION_TYPE_FLOAT) >= 7.5 ||

        // Tested on the Torch 9800 (6) and Style 9670 (6), BlackBerry® Torch 9810 (7), BlackBerry Z10 (10)
        $this->is('BlackBerry') && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) >= 6.0 ||
        // Blackberry Playbook (1.0-2.0) - Tested on PlayBook
        $this->match('Playbook.*Tablet') ||

        // Palm WebOS (1.4-3.0) - Tested on the Palm Pixi (1.4), Pre (1.4), Pre 2 (2.0), HP TouchPad (3.0)
        ( $this->version('webOS', self::VERSION_TYPE_FLOAT) >= 1.4 && $this->match('Palm|Pre|Pixi') ) ||
        // Palm WebOS 3.0  - Tested on HP TouchPad
        $this->match('hp.*TouchPad') ||

        // Firefox Mobile 18 - Tested on Android 2.3 and 4.1 devices
        ( $this->is('Firefox') && $this->version('Firefox', self::VERSION_TYPE_FLOAT) >= 18 ) ||

        // Chrome for Android - Tested on Android 4.0, 4.1 device
        ( $this->is('Chrome') && $this->is('AndroidOS') && $this->version('Android', self::VERSION_TYPE_FLOAT) >= 4.0 ) ||

        // Skyfire 4.1 - Tested on Android 2.3 device
        ( $this->is('Skyfire') && $this->version('Skyfire', self::VERSION_TYPE_FLOAT) >= 4.1 && $this->is('AndroidOS') && $this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.3 ) ||

        // Opera Mobile 11.5-12: Tested on Android 2.3
        ( $this->is('Opera') && $this->version('Opera Mobi', self::VERSION_TYPE_FLOAT) >= 11.5 && $this->is('AndroidOS') ) ||

        // Meego 1.2 - Tested on Nokia 950 and N9
        $this->is('MeeGoOS') ||

        // Tizen (pre-release) - Tested on early hardware
        $this->is('Tizen') ||

        // Samsung Bada 2.0 - Tested on a Samsung Wave 3, Dolphin browser
        // @todo: more tests here!
        $this->is('Dolfin') && $this->version('Bada', self::VERSION_TYPE_FLOAT) >= 2.0 ||

        // UC Browser - Tested on Android 2.3 device
        ( ($this->is('UC Browser') || $this->is('Dolfin')) && $this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.3 ) ||

        // Kindle 3 and Fire  - Tested on the built-in WebKit browser for each
        ( $this->match('Kindle Fire') ||
        $this->is('Kindle') && $this->version('Kindle', self::VERSION_TYPE_FLOAT) >= 3.0 ) ||

        // Nook Color 1.4.1 - Tested on original Nook Color, not Nook Tablet
        $this->is('AndroidOS') && $this->is('NookTablet') ||

        // Chrome Desktop 16-24 - Tested on OS X 10.7 and Windows 7
        $this->version('Chrome', self::VERSION_TYPE_FLOAT) >= 16 && !$isMobile ||

        // Safari Desktop 5-6 - Tested on OS X 10.7 and Windows 7
        $this->version('Safari', self::VERSION_TYPE_FLOAT) >= 5.0 && !$isMobile ||

        // Firefox Desktop 10-18 - Tested on OS X 10.7 and Windows 7
        $this->version('Firefox', self::VERSION_TYPE_FLOAT) >= 10.0 && !$isMobile ||

        // Internet Explorer 7-9 - Tested on Windows XP, Vista and 7
        $this->version('IE', self::VERSION_TYPE_FLOAT) >= 7.0 && !$isMobile ||

        // Opera Desktop 10-12 - Tested on OS X 10.7 and Windows 7
        $this->version('Opera', self::VERSION_TYPE_FLOAT) >= 10 && !$isMobile
    ){
        return self::MOBILE_GRADE_A;
    }

    if (
        $this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT) < 4.3 ||
        $this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT) < 4.3 ||
        $this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT) < 4.3 ||

        // Blackberry 5.0: Tested on the Storm 2 9550, Bold 9770
        $this->is('Blackberry') && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) >= 5 && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) < 6 ||

        //Opera Mini (5.0-6.5) - Tested on iOS 3.2/4.3 and Android 2.3
        ($this->version('Opera Mini', self::VERSION_TYPE_FLOAT) >= 5.0 && $this->version('Opera Mini', self::VERSION_TYPE_FLOAT) <= 7.0 &&
        ($this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.3 || $this->is('iOS')) ) ||

        // Nokia Symbian^3 - Tested on Nokia N8 (Symbian^3), C7 (Symbian^3), also works on N97 (Symbian^1)
        $this->match('NokiaN8|NokiaC7|N97.*Series60|Symbian/3') ||

        // @todo: report this (tested on Nokia N71)
        $this->version('Opera Mobi', self::VERSION_TYPE_FLOAT) >= 11 && $this->is('SymbianOS')
    ){
        return self::MOBILE_GRADE_B;
    }

    if (
        // Blackberry 4.x - Tested on the Curve 8330
        $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) <= 5.0 ||
        // Windows Mobile - Tested on the HTC Leo (WinMo 5.2)
        $this->match('MSIEMobile|Windows CE.*Mobile') || $this->version('Windows Mobile', self::VERSION_TYPE_FLOAT) <= 5.2 ||

        // Tested on original iPhone (3.1), iPhone 3 (3.2)
        $this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT) <= 3.2 ||
        $this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT) <= 3.2 ||
        $this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT) <= 3.2 ||

        // Internet Explorer 7 and older - Tested on Windows XP
        $this->version('IE', self::VERSION_TYPE_FLOAT) <= 7.0 && !$isMobile
    ){
        return self::MOBILE_GRADE_C;
    }

    // All older smartphone platforms and featurephones - Any device that doesn't support media queries
    // will receive the basic, C grade experience.
    return self::MOBILE_GRADE_C;
}