<?php


if (!defined("SERVER_HOST")) {
    exit;
}
class msagete_security extends home_security
{

    public function html_temizle($text)
    {
        return strip_tags(trim(filtre2($text)));
    }

    public function PermaLinkArray($arr)
    {
        foreach ($arr as $k => $v) {
            $arr[$k] = $this->PermaLink($v);
        }
        return $arr;
    }

    public function para_str($number = 0)
    {
        if (function_exists("money_format")) {
            setlocale(LC_MONETARY, "tr_TR");
            $tutar = money_format("%i", $number);
            $tutar = str_replace(" TRY", "", $tutar);
        } else {
            if (class_exists("NumberFormatter")) {
                $fmt = new NumberFormatter("tr_TR", NumberFormatter::CURRENCY);
                $tutar = $fmt->formatCurrency($number, "TRY");
                $tutar = str_replace(array("₺", "TL", " "), "", $tutar);
            } else {
                if (function_exists("number_format")) {
                    $tutar = number_format($number, 2, ",", ".");
                } else {
                    $tutar = $number;
                }
            }
        }
        $tutar = substr($tutar, -3) == ",00" ? substr($tutar, 0, -3) : $tutar;
        return $tutar;
    }

    public function para_int($money)
    {
        $cleanString = preg_replace("/([^0-9\\.,])/i", "", $money);
        $onlyNumbersString = preg_replace("/([^0-9])/i", "", $money);
        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;
        $stringWithCommaOrDot = preg_replace("/([,\\.])/", "", $cleanString, $separatorsCountToBeErased);
        $removedThousendSeparator = preg_replace("/(\\.|,)(?=[0-9]{3,}\$)/", "", $stringWithCommaOrDot);
        return (double) str_replace(",", ".", $removedThousendSeparator);
    }

    public function alt_replace($string)
    {
        $search = array(chr(194) . chr(160), chr(194) . chr(144), chr(194) . chr(157), chr(194) . chr(129), chr(194) . chr(141), chr(194) . chr(143), chr(194) . chr(173), chr(173));
        $string = str_replace($search, "", $string);
        return trim($string);
    }

    public function turkce_karakter_kontrol($string)
    {
        if (preg_match("/[ÖÇŞİĞÜğüşıöç]/", $string)) {
            return true;
        }
        return false;
    }

    public function mesaj($string)
    {
        $string = trim($string);
        $string = filtre2($string);
        $string = nl2br($string);
        $string = strip_tags($string, "<br>");
        return $string;
    }

    public function html_text($string)
    {
        return addslashes($string);
    }

    public function text($string)
    {
        return addslashes(filtre2(htmlspecialchars($string)));
    }

    private function temizle($metin)
    {
        return mb_convert_case(str_ireplace("I", "ı", $metin), MB_CASE_LOWER, "UTF-8");
    }

    public function title($string)
    {
        $title = htmlspecialchars(strip_tags(stripslashes($string)));
        return filtre2(preg_replace("/[^ a-z-A-Z-0-9ÇİĞÖŞÜçığöşü.,]['\"+_]/", "", $title));
    }

    public function isim($string)
    {
        $title = htmlspecialchars(strip_tags(stripslashes($string)));
        return preg_replace("/[^ []a-z-A-Z-0-9ÇİĞÖŞÜçığöşü.]/", "", $title);
    }

    public function sadece_text($string)
    {
        $string = $this->toAscii($string);
        return $string;
    }

    public function harf_rakam($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^a-z-A-Z-0-9ÇİĞÖŞÜçığöşü_]/", "", $string);
    }

    public function harf($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^a-z-A-ZÇİĞÖŞÜçığöşü]/", "", $string);
    }

    public static function rakam($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^0-9.]/", "", $string);
    }

    public static function sayi($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^0-9.\\-]/", "", $string);
    }

    public function prakam($string)
    {
        $string = strip_tags(stripslashes($string));
        $string = preg_replace("/[^0-9.,]/", "", $string);
        return $string == "" ? 0 : $string;
    }

    public function zrakam($string)
    {
        $string = $this->rakam($string);
        return $string == "" ? 0 : $string;
    }

    public function parola($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^a-z-A-Z-0-9ÇİĞÖŞÜçığöşü@!#\$%^&._]/", "", $string);
    }

    public function eposta($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^a-z-A-Z-0-9@._]/", "", $string);
    }

    public function cookie_session($string)
    {
        $string = strip_tags(stripslashes($string));
        return preg_replace("/[^ a-z-A-Z-0-9ÇİĞÖŞÜçığöşü._@]/", "", $string);
    }

    public function url($string)
    {
        $string = mysql_real_escape_string(strip_tags(stripslashes($string)));
        return $string;
    }

    public function url_kontrol($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public function eposta_kontrol($eposta)
    {
        return filter_var($eposta, FILTER_VALIDATE_EMAIL);
    }

    public function filtre($str)
    {
        return strip_tags($str, "<br><p><b><i><o><table><tr><td><th><thead><tbody><img><a><font><span><strong><em><ul><ol><li><h1><h2><h3><h4><h5>");
    }

    public function flood_engeli()
    {
        if (time() - 1 < $_SESSION["sec"]) {
            echo "Flood yapmayın!";
            exit;
        }
        $_SESSION["sec"] = time();
    }

    public function PermaLink($str, $options = array())
    {
        $str = str_replace(array("&#39;", "&quot;", "&#39;", "&quot;"), " ", $str);
        $str = mb_convert_encoding((string) $str, "UTF-8", mb_list_encodings());
        $defaults = array("delimiter" => "-", "limit" => NULL, "lowercase" => true, "replacements" => array(), "transliterate" => true);
        $options = array_merge($defaults, $options);
        $char_map = array("À" => "A", "Á" => "A", "Â" => "A", "Ã" => "A", "Ä" => "A", "Å" => "A", "Æ" => "AE", "Ç" => "C", "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N", "Ò" => "O", "Ó" => "O", "Ô" => "O", "Õ" => "O", "Ö" => "O", "Ő" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "Ű" => "U", "Ý" => "Y", "Þ" => "TH", "ß" => "ss", "à" => "a", "á" => "a", "â" => "a", "ã" => "a", "ä" => "a", "å" => "a", "æ" => "ae", "ç" => "c", "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï" => "i", "ð" => "d", "ñ" => "n", "ò" => "o", "ó" => "o", "ô" => "o", "õ" => "o", "ö" => "o", "ő" => "o", "ø" => "o", "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "ű" => "u", "ý" => "y", "þ" => "th", "ÿ" => "y", "©" => "(c)", "Α" => "A", "Β" => "B", "Γ" => "G", "Δ" => "D", "Ε" => "E", "Ζ" => "Z", "Η" => "H", "Θ" => "8", "Ι" => "I", "Κ" => "K", "Λ" => "L", "Μ" => "M", "Ν" => "N", "Ξ" => "3", "Ο" => "O", "Π" => "P", "Ρ" => "R", "Σ" => "S", "Τ" => "T", "Υ" => "Y", "Φ" => "F", "Χ" => "X", "Ψ" => "PS", "Ω" => "W", "Ά" => "A", "Έ" => "E", "Ί" => "I", "Ό" => "O", "Ύ" => "Y", "Ή" => "H", "Ώ" => "W", "Ϊ" => "I", "Ϋ" => "Y", "α" => "a", "β" => "b", "γ" => "g", "δ" => "d", "ε" => "e", "ζ" => "z", "η" => "h", "θ" => "8", "ι" => "i", "κ" => "k", "λ" => "l", "μ" => "m", "ν" => "n", "ξ" => "3", "ο" => "o", "π" => "p", "ρ" => "r", "σ" => "s", "τ" => "t", "υ" => "y", "φ" => "f", "χ" => "x", "ψ" => "ps", "ω" => "w", "ά" => "a", "έ" => "e", "ί" => "i", "ό" => "o", "ύ" => "y", "ή" => "h", "ώ" => "w", "ς" => "s", "ϊ" => "i", "ΰ" => "y", "ϋ" => "y", "ΐ" => "i", "Ş" => "S", "İ" => "I", "Ç" => "C", "Ü" => "U", "Ö" => "O", "Ğ" => "G", "ş" => "s", "ı" => "i", "ç" => "c", "ü" => "u", "ö" => "o", "ğ" => "g", "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E", "Ё" => "Yo", "Ж" => "Zh", "З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C", "Ч" => "Ch", "Ш" => "Sh", "Щ" => "Sh", "Ъ" => "", "Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "Yu", "Я" => "Ya", "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "yo", "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "sh", "ъ" => "", "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "Є" => "Ye", "І" => "I", "Ї" => "Yi", "Ґ" => "G", "є" => "ye", "і" => "i", "ї" => "yi", "ґ" => "g", "Č" => "C", "Ď" => "D", "Ě" => "E", "Ň" => "N", "Ř" => "R", "Š" => "S", "Ť" => "T", "Ů" => "U", "Ž" => "Z", "č" => "c", "ď" => "d", "ě" => "e", "ň" => "n", "ř" => "r", "š" => "s", "ť" => "t", "ů" => "u", "ž" => "z", "Ą" => "A", "Ć" => "C", "Ę" => "e", "Ł" => "L", "Ń" => "N", "Ó" => "o", "Ś" => "S", "Ź" => "Z", "Ż" => "Z", "ą" => "a", "ć" => "c", "ę" => "e", "ł" => "l", "ń" => "n", "ó" => "o", "ś" => "s", "ź" => "z", "ż" => "z", "Ā" => "A", "Č" => "C", "Ē" => "E", "Ģ" => "G", "Ī" => "i", "Ķ" => "k", "Ļ" => "L", "Ņ" => "N", "Š" => "S", "Ū" => "u", "Ž" => "Z", "ā" => "a", "č" => "c", "ē" => "e", "ģ" => "g", "ī" => "i", "ķ" => "k", "ļ" => "l", "ņ" => "n", "š" => "s", "ū" => "u", "ž" => "z");
        $str = preg_replace(array_keys($options["replacements"]), $options["replacements"], $str);
        if ($options["transliterate"]) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }
        $str = preg_replace("/[^\\p{L}\\p{Nd}]+/u", $options["delimiter"], $str);
        $str = preg_replace("/(" . preg_quote($options["delimiter"], "/") . "){2,}/", "\$1", $str);
        $str = mb_substr($str, 0, $options["limit"] ? $options["limit"] : mb_strlen($str, "UTF-8"), "UTF-8");
        $str = trim($str, $options["delimiter"]);
        return $options["lowercase"] ? mb_strtolower($str, "UTF-8") : $str;
    }

    private function toAscii($str)
    {
        $clean = preg_replace("/[^a-zA-Z0-9\\/_|+ -]/", "", $str);
        $clean = strtolower(trim($clean, ""));
        $clean = preg_replace("/[\\/_|+ -]+/", "", $clean);
        return $clean;
    }
}
if ($xsd006 != "527cbb94538f6768970d0fc630ee0acf") {
    exit(@file_get_contents("http://www.izmirtr.com/license"));
}
function ag7xjCywFCJVWMPe7sjWbZnzQg($a, $b)
{
    return $a . "-" . $b . "1fbo1CcJXpDMErhc1oZO3rJs";
}

function a9lv9bll1v0muilrweoojrmzccz()
{
    return "_]X}|gHwPv/t|1bG&8p[V:|EZD2AL9/[r4D]X3^Joee";
}
function aoxbsf76hk6lpufb8t5hnmzrcpu()
{
    return "Ry&5:|V:6=02!dPJ84PzBe+d^(ElV)GkGk<VYE-OW0f";
}
function aytq7drdmlgk8pldljyrdwcrp3f()
{
    return "G%jGJ2)0+I_PisIEnlc[!Q985F-4XJ<k=?HNC@P?d)v";
}
function aiocvsemnhlc0byrgplavfbgdio()
{
    return "-sK>bLjI:LAx@u8W&j)>2g3b4[VfNh}qVOzun;Sgi:v";
}
function afvchoylvosrrg11rfojhrki6pu()
{
    return "p2uRk<NqL}G+ZGCHIOm)|Lxf34I)F_EZAe9hlkLo5;/";
}
function atrtowbkpnduybvopplrlxdt3tj()
{
    return "yIq^}K}Z2^=R`c7V8?k5S2zbjA]q(=(%%(3>;x^gKGm";
}
function ayskatnqgai753nhiir5jxzmzxi()
{
    return "(VDc%ru#%oo*oe%SAyMXLT&~JN>K|Y;zZ03ck[NIX)/";
}
function auszyrsfrsa0gaugp25hmeauckh()
{
    return "jH:)1NOBW!~g4a/!z4&y(jR[(FV2TtjO7Y~NsY}rRTN";
}
function aqypbcvyxlok8qnogspnvxawvto()
{
    return "/&vGJ>D?cGzpb`Nl*X]xeCJ4FS:DloZ=!RFxjPEaL-P";
}
function atg6wcqkqj6jdw2npev7zvlqoxi()
{
    return ":dGU?QCnvk@~P6r=4>hh8i5_q<;xfB[WD=DQk0OsO?a";
}
function aydfynu6ryqb1eungusfhifl0sq()
{
    return "Rel)Z6+FeC`BUDwOJ!)k1|D5*Y+99<VSgO+nYX;k*LJ";
}
function ahohsulw5czeicnyhgi3sfmh0jx()
{
    return "tJ-=jVU#?iQ-|Xf9vSyB3Y@)Y-P>yJ`h#?f/=rHQ+E0";
}
function atzvcnlskzcarfxmwglkleyqv3q()
{
    return "g7acm3jIPF#JBLg`MGxx(w*LJrqq#UtO4%5SS+h/2Qm";
}
function atpi5zbeqh3bxmdi8lmd16hfm0n()
{
    return "mG?Ifjy7J67jWIg#I&i~9U49ea=</L=t4<2cYR7&m^Z";
}
function azl62gyjkg5ou0kibfsql5jnr6a()
{
    return "Q73X)UHx|Y`lXQ2dc[D%Y>c<+|nmz3%/QlAranYJPpT";
}
function axut825uvasycoerqxy3elwdmmd()
{
    return "z/d_^23W:NOE@zwgo:W<(8/PG@3X1(RSB<IAZ};6-(]";
}
function a7dvrqi9bbsqxedufti4pgh6q1q()
{
    return "7z|PDau7JmCCT<I)V2xX4i}2tSH6P6C2*vutcA7vz8M";
}
function auwuute9fbhlwpnkxvqxgv1rbza()
{
    return "7t}QVluw6]MFCGDa6p-p:cSkq?nXj)[-4]zAo7C/J4<";
}
function adzjwycyls7ypu0eagy6zvvc7dl()
{
    return "Ap^3OaZ!<PKcD8L<;hX]pEbDyq=(xa*0#R158N5*Sw}";
}
function ayvjtmteyksfse7vutwllrmw7y4()
{
    return "_pWx&L!P4beK@b4HJryg`~vhn)HkSgGc%asgtqjjPK<";
}
function av2a8utikv40gmiqrbozqs9icre()
{
    return "a%[hqtItRBT]7t^R6SE7vDd+t|B;Gy^%5o:9/R9ZK8s";
}
function a4nw4xh4i8dhcvpnbvqo8v4sudf()
{
    return "}e6Gi9:V}F#xl`9G8+wcerW%ab|*kHDz%<QPrt`pqm-";
}
function aqzco5qdcxv9u2803ds6pxk1ik3()
{
    return "25Mmo@~Gg`nPgBBkQ=sG)pEhB-24@8~qwK;@+KIB/;O";
}
function a0ijjjgaj03h9fquyqfzflxgamj()
{
    return "GsqaBzP!=/q<*+Tr&U%A*x_u~X^zj(;_rUiw-}@u`m}";
}
function atp3eeulf4cpzgmjkqsq4rfilak()
{
    return "P/C=7n;@3odz(mHvvHo97Krfx_MBPyS2/pFa(Fn|%3v";
}
function atiiq4jpklywjf7fecwtmi1qmvd()
{
    return ")+G1#[O]h/UpF>e!cpN+Sl`}nFD#:FQC|*0_ZEjuk#[";
}
function aqgodjoghlzcoe9wksuxcvm2k7v()
{
    return "J-jA)q34EBCa:AVKn41N@6[L*p+>w3xAmaW#RL/4zPw";
}
function adax4batpihtyytna2v68schjyn()
{
    return "y_~H:TA@tA@^6qI7S^FFs]qc*R6!J%0=w[`;)t~~<9D";
}
function axknuycbghuvzeoys3d5dayiaot()
{
    return "=2~j1q>dZpR#OPnSw1DaC#huJm>O[z47&Id3Cm?Wl_B";
}
function accufqi5cznemt60tx0wadz6bsd()
{
    return "idb21JtjoXq_sgvfQQ/q00&D19rb(Y`Sh!Ee>SHNsEt";
}
function aivehoqqeonrca7jpvfitq8gqms()
{
    return "6?+#-`7=633AGakXbja6V:5(8/Sg/s10Vak<Y<cMt/`";
}

function ascii($text)
{
    $replace = array("Ç", "İ", "Ğ", "Ö", "Ş", "Ü", "ç", "ı", "ğ", "ö", "ş", "ü");
    $search = array("&#199;", "&#304;", "&#286;", "&#214;", "&#350;", "&#220;", "&#231;", "&#305;", "&#287;", "&#246;", "&#351;", "&#252;");
    $text = str_replace($search, $replace, $text);
    return $text;
}

function filtre2($deger)
{
    return str_replace(array("'", "\"", "\\&#39;", "\\&quot;"), array("&#39;", "&quot;", "&#39;", "&quot;"), $deger);
}

?>