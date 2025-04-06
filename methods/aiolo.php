<?php
// +------------------------------------------------------------------------+
// | class.upload.php                                                       |
// +------------------------------------------------------------------------+
// | Copyright (c) Colin Verot 2003-2019. All rights reserved.              |
// | Email         colin@verot.net                                          |
// | Web           http://www.verot.net                                     |
// +------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify   |
// | it under the terms of the GNU General Public License version 2 as      |
// | published by the Free Software Foundation.                             |
// |                                                                        |
// | This program is distributed in the hope that it will be useful,        |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of         |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          |
// | GNU General Public License for more details.                           |
// |                                                                        |
// | You should have received a copy of the GNU General Public License      |
// | along with this program; if not, write to the                          |
// |   Free Software Foundation, Inc., 59 Temple Place, Suite 330,          |
// |   Boston, MA 02111-1307 USA                                            |
// |                                                                        |
// | Please give credit on sites that use class.upload and submit changes   |
// | of the script so other people can use them as well.                    |
// | This script is free to use, don't abuse.                               |
// +------------------------------------------------------------------------+

namespace Verot\Upload;

if (!defined('IMG_WEBP')) define('IMG_WEBP', 32);

/**
 * Dosya yükleme sınıfı
 *
 * @author    Colin Verot <colin@verot.net>
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright Colin Verot
 */
class Upload {

    /**
     * Sınıf versiyonu
     *
     * @access public
     * @var string
     */
    var $version;

    /**
     * Yüklenen dosya adı
     *
     * @access public
     * @var string
     */
    var $file_src_name;

    /**
     * Yüklenen dosya adı gövdesi (uzantı olmadan)
     *
     * @access public
     * @var string
     */
    var $file_src_name_body;

    /**
     * Yüklenen dosya uzantısı
     *
     * @access public
     * @var string
     */
    var $file_src_name_ext;

    /**
     * Yüklenen dosya MIME türü
     *
     * @access public
     * @var string
     */
    var $file_src_mime;

    /**
     * Yüklenen dosya boyutu, bayt cinsinden
     *
     * @access public
     * @var double
     */
    var $file_src_size;

    /**
     * $_FILES'den gelen olası PHP hata kodunu tutar
     *
     * @access public
     * @var string
     */
    var $file_src_error;

    /**
     * Yüklenen dosya adı, sunucu yolu dahil
     *
     * @access public
     * @var string
     */
    var $file_src_pathname;

    /**
     * Yüklenen dosya adı geçici kopyası
     *
     * @access private
     * @var string
     */
    var $file_src_temp;

    /**
     * Hedef dosya adı
     *
     * @access public
     * @var string
     */
    var $file_dst_path;

    /**
     * Hedef dosya adı
     *
     * @access public
     * @var string
     */
    var $file_dst_name;

    /**
     * Hedef dosya adı gövdesi (uzantı olmadan)
     *
     * @access public
     * @var string
     */
    var $file_dst_name_body;

    /**
     * Hedef dosya uzantısı
     *
     * @access public
     * @var string
     */
    var $file_dst_name_ext;

    /**
     * Hedef dosya adı, yol dahil
     *
     * @access public
     * @var string
     */
    var $file_dst_pathname;

    /**
     * Kaynak görüntü genişliği
     *
     * @access public
     * @var integer
     */
    var $image_src_x;

    /**
     * Kaynak görüntü yüksekliği
     *
     * @access public
     * @var integer
     */
    var $image_src_y;

    /**
     * Kaynak görüntü renk derinliği
     *
     * @access public
     * @var integer
     */
    var $image_src_bits;

    /**
     * Piksel sayısı
     *
     * @access public
     * @var long
     */
    var $image_src_pixels;

    /**
     * Görüntü türü (png, gif, jpg, webp veya bmp)
     *
     * @access public
     * @var string
     */
    var $image_src_type;

    /**
     * Hedef görüntü genişliği
     *
     * @access public
     * @var integer
     */
    var $image_dst_x;

    /**
     * Hedef görüntü yüksekliği
     *
     * @access public
     * @var integer
     */
    var $image_dst_y;

    /**
     * Hedef görüntü türü (png, gif, jpg, webp veya bmp)
     *
     * @access public
     * @var integer
     */
    var $image_dst_type;

    /**
     * Desteklenen görüntü formatları
     *
     * @access private
     * @var array
     */
    var $image_supported;

    /**
     * Kaynak dosyanın bir görüntü olup olmadığını belirten bayrak
     *
     * @access public
     * @var boolean
     */
    var $file_is_image;

    /**
     * Sınıf oluşturulduktan sonra ayarlanan bayrak
     *
     * Dosyanın doğru şekilde yüklenip yüklenmediğini gösterir
     *
     * @access public
     * @var bool
     */
    var $uploaded;

    /**
     * PHP yükleme kontrollerini durduran bayrak
     *
     * Sınıfı bir dosya adıyla başlattığımızı gösterir, bu durumda
     * PHP *yüklemesinin* geçerliliği kontrol edilmeyecektir
     *
     * Bu bayrak yerel bir dosya üzerinde çalışırken otomatik olarak true olarak ayarlanır
     *
     * Uyarı: yüklemelerde, güvenlik nedeniyle bu bayrak false olarak ayarlanmalıdır
     *
     * @access public
     * @var bool
     */
    var $no_upload_check;

    /**
     * Bir işlem çağrıldıktan sonra ayarlanan bayrak
     *
     * İşlemin ve sonuç dosyasının kopyalanmasının başarılı olup olmadığını gösterir
     *
     * @access public
     * @var bool
     */
    var $processed;

    /**
     * Olası hata mesajını sade İngilizce olarak tutar
     *
     * @access public
     * @var string
     */
    var $error;

    /**
     * HTML formatında bir günlük tutar
     *
     * @access public
     * @var string
     */
    var $log;

    // Üzerine yazılabilir işleme değişkenleri

    /**
     * Bu değişkeni dosya adı gövdesini (uzantı olmadan) değiştirmek için ayarlayın
     *
     * @access public
     * @var string
     */
    var $file_new_name_body;

    /**
     * Bu değişkeni dosya adı gövdesine bir dize eklemek için ayarlayın
     *
     * @access public
     * @var string
     */
    var $file_name_body_add;

    /**
     * Bu değişkeni dosya adı gövdesine bir dize eklemek için ayarlayın
     *
     * @access public
     * @var string
     */
    var $file_name_body_pre;

    /**
     * Bu değişkeni dosya uzantısını değiştirmek için ayarlayın
     *
     * @access public
     * @var string
     */
    var $file_new_name_ext;

    /**
     * Bu değişkeni dosya adını biçimlendirmek (boşlukları _ ile değiştirmek) için ayarlayın
     *
     * @access public
     * @var boolean
     */
    var $file_safe_name;

    /**
     * Kaynak dosyanın uzantısı yoksa bir uzantı ekler
     *
     * Dosya bir görüntü ise, doğru uzantı eklenecektir
     * Aksi takdirde, bir .txt uzantısı seçilecektir
     *
     * @access public
     * @var boolean
     */
    var $file_force_extension;

    /**
     * MIME türünü izin verilen listeye karşı kontrol etmek istemiyorsanız bu değişkeni false olarak ayarlayın
     *
     * Güvenlik nedeniyle bu değişken varsayılan olarak true olarak ayarlanmıştır
     *
     * @access public
     * @var boolean
     */
    var $mime_check;

    /**
     * MIME türünü Fileinfo PECL uzantısıyla kontrol etmek istemiyorsanız bu değişkeni false olarak ayarlayın
     * Bazı sistemlerde, Fileinfo hatalı olabilir ve sınıf kodunda doğrudan devre dışı bırakmak isteyebilirsiniz.
     *
     * Ayrıca magic database dosyasının yolunu belirterek de ayarlayabilirsiniz.
     * true olarak ayarlanırsa, sınıf MAGIC ortam değişkenini okumaya çalışacaktır
     * ve boşsa, sistemin varsayılanına dönecektir
     * Boş bir dize olarak ayarlanırsa, yol argümanı olmadan finfo_open çağrılacaktır
     *
     * Güvenlik nedeniyle bu değişken varsayılan olarak true olarak ayarlanmıştır
     *
     * @access public
     * @var boolean
     */
    var $mime_fileinfo;

    /**
     * MIME türünü UNIX file() komutuyla kontrol etmek istemiyorsanız bu değişkeni false olarak ayarlayın
     *
     * Güvenlik nedeniyle bu değişken varsayılan olarak true olarak ayarlanmıştır
     *
     * @access public
     * @var boolean
     */
    var $mime_file;

    /**
     * MIME türünü magic.mime dosyası ile kontrol etmek istemiyorsanız bu değişkeni false olarak ayarlayın
     *
     * mime_content_type() işlevi kaldırılacak,
     * ve bu değişken gelecekteki bir sürümde false olarak ayarlanacaktır
     *
     * Güvenlik nedeniyle bu değişken varsayılan olarak true olarak ayarlanmıştır
     *
     * @access public
     * @var boolean
     */
    var $mime_magic;

/**
 * MIME türünü getimagesize() ile kontrol etmek istemiyorsanız init() fonksiyonunda bu değişkeni false olarak ayarlayın
 *
 * Sınıf, getimagesize() ile bir MIME türü almaya çalışır
 * Eğer bir MIME döndürülmezse, dosya türünden MIME türünü tahmin etmeye çalışır
 *
 * Güvenlik nedeniyle bu değişken varsayılan olarak true olarak ayarlanmıştır
 *
 * @access public
 * @var boolean
 */
var $mime_getimagesize;

/**
 * Tehlikeli betikleri basit metin dosyalarına dönüştürmek istemiyorsanız bu değişkeni false olarak ayarlayın
 * Kara listeye alınmış uzantıların listesi {@link dangerous} içindedir
 *
 * Bu kontrol, yasaklanmış MIME türlerini veya uzantıları kontrol etmeden önce gerçekleşir
 * Betikleri metin dosyalarına dönüştürmek yerine yüklemeleri yasaklamak istiyorsanız,
 * {@link no_script} değişkenini false olarak ayarlayın ve yerine {@link forbidden} kullanın
 *
 * @access public
 * @var boolean
 */
var $no_script;

/**
 * Tehlikeli dosya uzantıları
 *
 * {@link no_script} true ise uygulanan tehlikeli uzantıların listesi
 * Dosya böyle bir uzantıya sahipse, metin dosyasına dönüştürülür
 *
 * @access public
 * @var array
 */
var $dangerous;

/**
 * Dosya zaten mevcutsa dosyanın otomatik olarak yeniden adlandırılmasına izin vermek için bu değişkeni true olarak ayarlayın
 *
 * Varsayılan değer true'dur
 *
 * Örneğin, foo.ext yüklenirken,<br>
 * eğer foo.ext zaten mevcutsa, yükleme foo_1.ext olarak yeniden adlandırılacaktır<br>
 * ve eğer foo_1.ext zaten mevcutsa, yükleme foo_2.ext olarak yeniden adlandırılacaktır<br>
 *
 * Bu seçeneğin {@link file_overwrite} true ise herhangi bir etkisi olmayacağını unutmayın
 *
 * @access public
 * @var bool
 */
var $file_auto_rename;

/**
 * Hedef dizin eksikse otomatik olarak oluşturulmasına izin vermek için bu değişkeni true olarak ayarlayın (özyinelemeli çalışır)
 *
 * Varsayılan değer true'dur
 *
 * @access public
 * @var bool
 */
var $dir_auto_create;

/**
 * Hedef dizin yazılabilir değilse otomatik chmod izni vermek için bu değişkeni true olarak ayarlayın
 *
 * Varsayılan değer true'dur
 *
 * @access public
 * @var bool
 */
var $dir_auto_chmod;

/**
 * Sınıfın dizinleri oluştururken veya bir dizine yazmaya çalışırken kullanmasını istediğiniz varsayılan chmod'u ayarlayın
 *
 * Varsayılan değer 0755'dir (tırnak işaretleri olmadan)
 *
 * @access public
 * @var bool
 */
var $dir_chmod;

/**
 * Mevcut bir dosyanın üzerine yazılmasına izin vermek için bu değişkeni true olarak ayarlayın
 *
 * Varsayılan değer false'dur, bu nedenle hiçbir dosyanın üzerine yazılmaz
 *
 * @access public
 * @var bool
 */
var $file_overwrite;

/**
 * Yüklenen dosya için maksimum boyutu bayt cinsinden değiştirmek için bu değişkeni ayarlayın
 *
 * Varsayılan değer php.ini'deki <i>upload_max_filesize</i> değeridir
 *
 * Bayt cinsinden değer (tamsayı) veya kısayol bayt değerleri (dize) kullanılabilir.
 * Kullanılabilir seçenekler K (Kilobayt için), M (Megabayt için) ve G (Gigabayt için)'dir
 *
 * @access public
 * @var double
 */
var $file_max_size;

/**
 * php.ini'den max dosya boyutu
 *
 * @access private
 * @var double
 */
var $file_max_size_raw;

/**
 * Dosya bir resimse boyutunu yeniden boyutlandırmak için bu değişkeni true olarak ayarlayın
 *
 * Muhtemelen {@link image_x} ve {@link image_y} ayarlamak ve belki de oran değişkenlerinden birini ayarlamak isteyeceksiniz
 *
 * Varsayılan değer false (yeniden boyutlandırma yok)
 *
 * @access public
 * @var bool
 */
var $image_resize;

/**
 * Dosya bir resimse dönüştürmek için bu değişkeni ayarlayın
 *
 * Olası değerler: ''; 'png'; 'jpeg'; 'gif'; 'webp'; 'bmp'
 *
 * Varsayılan değer '' (dönüşüm yok)<br>
 * Eğer {@link resize} true ise, {@link convert} kaynak dosya uzantısına ayarlanacaktır
 *
 * @access public
 * @var string
 */
var $image_convert;

/**
 * İşlenen resim için istenen (veya maksimum/minimum) genişliği piksel cinsinden ayarlayın
 *
 * Varsayılan değer 150'dir
 *
 * @access public
 * @var integer
 */
var $image_x;

/**
 * İşlenen resim için istenen (veya maksimum/minimum) yüksekliği piksel cinsinden ayarlayın
 *
 * Varsayılan değer 150'dir
 *
 * @access public
 * @var integer
 */
var $image_y;

/**
 * Orijinal boyut oranını koruyarak {@link image_x} x {@link image_y} içine sığdırmak için bu değişkeni ayarlayın
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var bool
 */
var $image_ratio;

/**
 * Orijinal boyut oranını koruyarak {@link image_x} x {@link image_y} içine sığdırmak için bu değişkeni ayarlayın
 *
 * Görüntü, tüm alanı dolduracak şekilde yeniden boyutlandırılacak ve fazlalık kırpılacaktır
 *
 * Değer bir dize de olabilir, 'TBLR' (üst, alt, sol ve sağ) karakterlerinden biri veya birkaçı olabilir
 * Dize olarak ayarlanırsa, kırpma sırasında görüntünün hangi tarafının tutulacağını belirler.
 * Varsayılan olarak, görüntünün merkezi korunur, yani her iki tarafta eşit olarak kırpılır
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var mixed
 */
var $image_ratio_crop;

/**
 * Orijinal boyut oranını koruyarak {@link image_x} x {@link image_y} içine sığdırmak için bu değişkeni ayarlayın
 *
 * Görüntü, alanın tamamına sığacak şekilde yeniden boyutlandırılacaktır ve geri kalan alan renklendirilecektir.
 * Varsayılan renk beyazdır, ancak {@link image_default_color} ile ayarlanabilir
 *
 * Değer bir dize de olabilir, 'TBLR' (üst, alt, sol ve sağ) karakterlerinden biri veya birkaçı olabilir
 * Dize olarak ayarlanırsa, görüntünün alanın hangi tarafında görüntüleneceğini belirler.
 * Varsayılan olarak, görüntü merkeze yerleştirilir, yani kalan alanı her iki tarafta da eşit şekilde doldurur
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var mixed
 */
var $image_ratio_fill;

/**
 * {@link image_x} ve {@link image_y} en iyi eşleşmeyi sağlamak için piksel sayısını ayarlayın
 *
 * Görüntü, yaklaşık olarak piksel sayısına sahip olacak şekilde yeniden boyutlandırılacaktır
 * Oran korunacaktır
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var mixed
 */
var $image_ratio_pixels;

/**
 * {@link image_y} kullanarak ve oranı koruyarak {@link image_x}'i otomatik olarak hesaplamak için bu değişkeni ayarlayın
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var bool
 */
var $image_ratio_x;

/**
 * {@link image_x} kullanarak ve oranı koruyarak {@link image_y}'i otomatik olarak hesaplamak için bu değişkeni ayarlayın
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var bool
 */
var $image_ratio_y;

/**
 * (kaldırılacak) Orijinal boyut oranını koruyarak {@link image_x} x {@link image_y} içine sığdırmak için bu değişkeni ayarlayın,
 * ancak yalnızca orijinal görüntü daha büyükse
 *
 * Bu ayar yakında kaldırılacak. Bunun yerine, {@link image_ratio} ve {@link image_no_enlarging} kullanın
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var bool
 */
var $image_ratio_no_zoom_in;

/**
 * (kaldırılacak) Orijinal boyut oranını koruyarak {@link image_x} x {@link image_y} içine sığdırmak için bu değişkeni ayarlayın,
 * ancak yalnızca orijinal görüntü daha küçükse
 *
 * Varsayılan değer false'dur
 *
 * Bu ayar yakında kaldırılacak. Bunun yerine, {@link image_ratio} ve {@link image_no_shrinking} kullanın
 *
 * @access public
 * @var bool
 */
var $image_ratio_no_zoom_out;

/**
 * Yeniden boyutlandırılan görüntü orijinal görüntüden büyükse yeniden boyutlandırmayı iptal edin, büyütmeyi önlemek için
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var bool
 */
var $image_no_enlarging;

/**
 * Yeniden boyutlandırılan görüntü orijinal görüntüden küçükse yeniden boyutlandırmayı iptal edin, küçültmeyi önlemek için
 *
 * Varsayılan değer false'dur
 *
 * @access public
 * @var bool
 */
var $image_no_shrinking;

/**
 * Bir görüntü için maksimum genişlik ayarlamak için bu değişkeni ayarlayın, bu genişliğin üzerine çıkarsa yükleme geçersiz olacaktır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_max_width;

/**
 * Bir görüntü için maksimum yükseklik ayarlamak için bu değişkeni ayarlayın, bu yüksekliğin üzerine çıkarsa yükleme geçersiz olacaktır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_max_height;

/**
 * Bir görüntü için maksimum piksel sayısını ayarlamak için bu değişkeni ayarlayın, bu sayının üzerine çıkarsa yükleme geçersiz olacaktır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var long
 */
var $image_max_pixels;

/**
 * Bir görüntü için maksimum görüntü oranını ayarlamak için bu değişkeni ayarlayın, bu oranın üzerine çıkarsa yükleme geçersiz olacaktır
 *
 * Oranın genişlik / yükseklik olduğunu unutmayın
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var float
 */
var $image_max_ratio;

/**
 * Bir görüntü için minimum genişlik ayarlamak için bu değişkeni ayarlayın, bu genişliğin altına düşerse yükleme geçersiz olacaktır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_min_width;

/**
 * Bir görüntü için minimum yükseklik ayarlamak için bu değişkeni ayarlayın, bu yüksekliğin altına düşerse yükleme geçersiz olacaktır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_min_height;

/**
 * Bir görüntü için minimum piksel sayısını ayarlamak için bu değişkeni ayarlayın, bu sayının altına düşerse yükleme geçersiz olacaktır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var long
 */
var $image_min_pixels;
	
/**
 * Minimum görüntü oranını ayarlamak için bu değişkeni ayarlayın, bu oranın altına düşerse yükleme geçersiz olacaktır
 *
 * Oranın genişlik / yükseklik olduğunu unutmayın
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var float
 */
var $image_min_ratio;

/**
 * PNG görüntüleri için sıkıştırma seviyesi
 *
 * 1 (hızlı ama büyük dosyalar) ile 9 (yavaş ama küçük dosyalar) arasında
 *
 * Varsayılan değer null'dur (Zlib varsayılanı)
 *
 * @access public
 * @var integer
 */
var $png_compression;

/**
 * JPEG oluşturulan/dönüştürülen hedef görüntünün kalitesi
 *
 * Varsayılan değer 85'tir
 *
 * @access public
 * @var integer
 */
var $jpeg_quality;

/**
 * WebP oluşturulan/dönüştürülen hedef görüntünün kalitesi
 *
 * Varsayılan değer 85'tir
 *
 * @access public
 * @var integer
 */
var $webp_quality;

/**
 * İstenen dosya boyutuna uyması için JPG görüntünün kalitesini belirler
 *
 * JPG kalitesi %1 ile %100 arasında ayarlanacaktır
 * Hesaplamalar yaklaşık değerlerdir.
 *
 * Bayt cinsinden değer (tamsayı) veya kısayol bayt değerleri (dize) kullanılabilir.
 * Kullanılabilir seçenekler K (Kilobayt için), M (Megabayt için) ve G (Gigabayt için)'dir
 *
 * Varsayılan değer null'dur (hesaplama yok)
 *
 * @access public
 * @var integer
 */
var $jpeg_size;

/**
 * Ara belleği açar
 *
 * Bu aslında yalnızca JPEG görüntüler için kullanılır ve varsayılan olarak false'dur
 *
 * @access public
 * @var boolean
 */
var $image_interlace;

/**
 * Görüntü şeffaf olduğunda true olarak ayarlanan bayrak
 *
 * Bu aslında yalnızca şeffaf GIF'ler için kullanılır
 *
 * @access public
 * @var boolean
 */
var $image_is_transparent;

/**
 * Bir palet içindeki şeffaf renk
 *
 * Bu aslında yalnızca şeffaf GIF'ler için kullanılır
 *
 * @access public
 * @var boolean
 */
var $image_transparent_color;

/**
 * Şeffaf alanları boyamak için kullanılan arka plan rengi
 *
 * Ayarlanmışsa, şeffaf alanları boyayarak şeffaflığı zorla kaldırır
 * Bu ayar, PNG, WEBP ve GIF'teki tüm şeffaf alanları doldurur, {@link image_default_color}
 * yalnızca BMP, JPEG ve şeffaf GIF'lerdeki alfa şeffaf alanlarda yapar
 * Bu ayar {@link image_default_color} geçersiz kılar
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var string
 */
var $image_background_color;

/**
 * Alfa şeffaf olmayan görüntüler için varsayılan renk
 *
 * Bu ayar, alfa şeffaf olmayan bir görüntünün yarı saydam alanları için bir arka plan rengi tanımlamak için kullanılır
 * eğer çıktı formatı alfa şeffaflığı desteklemiyorsa
 * Alfa şeffaf PNG veya WEBP görüntüsünden veya alfa şeffaf özelliklere sahip bir görüntüden
 * eğer çıktıyı şeffaf GIF olarak almak istiyorsanız, şeffaf alanlar için bir karışım rengi ayarlayabilirsiniz
 * JPEG veya BMP çıktısı alırsanız, bu renk daha önce şeffaf olan alanları doldurmak için kullanılır
 *
 * Varsayılan renk beyazdır
 *
 * @access public
 * @var boolean
 */
var $image_default_color;

/**
 * Görüntü gerçek renk olmadığında true olarak ayarlanan bayrak
 *
 * @access public
 * @var boolean
 */
var $image_is_palette;

/**
 * Görüntü parlaklığını düzeltir
 *
 * Değer -127 ile 127 arasında olabilir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_brightness;

/**
 * Görüntü kontrastını düzeltir
 *
 * Değer -127 ile 127 arasında olabilir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_contrast;

/**
 * Görüntü opaklığını değiştirir
 *
 * Değer 0 ile 100 arasında olabilir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_opacity;

/**
 * Eşik filtresi uygular
 *
 * Değer -127 ile 127 arasında olabilir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_threshold;

/**
 * Görüntüye renk tonu uygular
 *
 * Değer, #FFFFFF gibi onaltılık bir renktir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var string
 */
var $image_tint_color;

/**
 * Görüntüye renkli bir kaplama uygular
 *
 * Değer, #FFFFFF gibi onaltılık bir renktir
 *
 * {@link image_overlay_opacity} ile kullanılır
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var string
 */
var $image_overlay_color;

/**
 * Renkli kaplama için opaklığı ayarlar
 *
 * Değer, 0 (şeffaf) ile 100 (opak) arasında bir yüzde olarak tamsayıdır
 *
 * {@link image_overlay_color} ile kullanılmadıkça, bu ayarın bir etkisi yoktur
 *
 * Varsayılan değer 50'dir
 *
 * @access public
 * @var integer
 */
var $image_overlay_opacity;

/**
 * Bir görüntünün rengini ters çevirir
 *
 * Varsayılan değer FALSE'dir
 *
 * @access public
 * @var boolean
 */
var $image_negative;

/**
 * Görüntüyü gri tonlamaya dönüştürür
 *
 * Varsayılan değer FALSE'dir
 *
 * @access public
 * @var boolean
 */
var $image_greyscale;

/**
 * Görüntüyü pikselleştirir
 *
 * Değer tam sayıdır, blok boyutunu temsil eder
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var integer
 */
var $image_pixelate;

/**
 * Alfa şeffaflık desteğiyle keskin olmayan bir maske uygular
 *
 * Bu keskin olmayan maskenin oldukça kaynak yoğun olduğunu unutmayın
 *
 * Varsayılan değer FALSE'dir
 *
 * @access public
 * @var boolean
 */
var $image_unsharp;

/**
 * Keskin olmayan maske miktarını ayarlar
 *
 * Değer 0 ile 500 arasında bir tamsayıdır, genellikle 50 ile 200 arasında
 *
 * {@link image_unsharp} ile kullanılmadıkça, bu ayarın bir etkisi yoktur
 *
 * Varsayılan değer 80'dir
 *
 * @access public
 * @var integer
 */
var $image_unsharp_amount;

/**
 * Keskin olmayan maskenin yarıçapını ayarlar
 *
 * Değer 0 ile 50 arasında bir tamsayıdır, genellikle 0.5 ile 1 arasında
 * Değiştirilmesi önerilmez, varsayılan en iyi sonucu verir
 *
 * {@link image_unsharp} ile kullanılmadıkça bu ayarın bir etkisi yoktur
 *
 * PHP 5.1'den itibaren imageconvolution kullanılır ve bu ayarın bir etkisi yoktur
 *
 * Varsayılan değer 0.5'tir
 *
 * @access public
 * @var integer
 */
var $image_unsharp_radius;

/**
 * Keskin olmayan maskenin eşik değerini ayarlar
 *
 * Değer 0 ile 255 arasında bir tamsayıdır, genellikle 0 ile 5 arasında
 *
 * {@link image_unsharp} ile kullanılmadıkça bu ayarın bir etkisi yoktur
 *
 * Varsayılan değer 1'dir
 *
 * @access public
 * @var integer
 */
var $image_unsharp_threshold;

/**
 * Görüntüye metin etiketi ekler
 *
 * Değer bir dizedir, herhangi bir metin olabilir. Metin kelime kaydırma yapmaz, ancak metninizde "\n" kullanabilirsiniz
 *
 * Ayarlanmışsa, bu ayar image_text_ ile başlayan tüm diğer ayarların kullanılmasına izin verir
 *
 * Değiştirme belirteçleri dizede kullanılabilir:
 * <pre>
 * gd_version    src_name       src_name_body src_name_ext
 * src_pathname  src_mime       src_x         src_y
 * src_type      src_bits       src_pixels
 * src_size      src_size_kb    src_size_mb   src_size_human
 * dst_path      dst_name_body  dst_pathname
 * dst_name      dst_name_ext   dst_x         dst_y
 * date          time           host          server        ip
 * </pre>
 * Belirteçler köşeli parantez içinde olmalıdır: [dst_x], resmin genişliği ile değiştirilir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var string
 */
var $image_text;

/**
 * Metin etiketi için metin yönünü ayarlar
 *
 * Değer 'h' veya 'v' olabilir, yatay ve dikey
 *
 * TrueType font kullanıyorsanız, bunun yerine {@link image_text_angle} kullanabilirsiniz
 *
 * Varsayılan değer h'dir (yatay)
 *
 * @access public
 * @var string
 */
var $image_text_direction;

/**
 * Metin etiketi için metin rengini ayarlar
 *
 * Değer, #FFFFFF gibi onaltılık bir renktir
 *
 * Varsayılan değer #FFFFFF'tir (beyaz)
 *
 * @access public
 * @var string
 */
var $image_text_color;

/**
 * Metin etiketinde metin opaklığını ayarlar
 *
 * Değer, 0 (şeffaf) ile 100 (opak) arasında bir yüzde olarak tamsayıdır
 *
 * Varsayılan değer 100'dür
 *
 * @access public
 * @var integer
 */
var $image_text_opacity;

/**
 * Metin etiketi için metin arka plan rengini ayarlar
 *
 * Değer, #FFFFFF gibi onaltılık bir renktir
 *
 * Varsayılan değer null'dur (arka plan yok)
 *
 * @access public
 * @var string
 */
var $image_text_background;

/**
 * Metin etiketinde metin arka plan opaklığını ayarlar
 *
 * Değer, 0 (şeffaf) ile 100 (opak) arasında bir yüzde olarak tamsayıdır
 *
 * Varsayılan değer 100'dür
 *
 * @access public
 * @var integer
 */
var $image_text_background_opacity;

/**
 * Metin etiketinde metin fontunu ayarlar
 *
 * Değer, 1 ile 5 arasında bir tamsayıdır. 1 en küçük font, 5 en büyük fonttur
 * Değer ayrıca bir dize olabilir, bu da bir GDF veya TTF fontunun (TrueType) yolunu temsil eder.
 *
 * Varsayılan değer 5'tir
 *
 * @access public
 * @var mixed
 */
var $image_text_font;

/**
 * TrueType fontları için metin font boyutunu ayarlar
 *
 * Değer bir tamsayıdır ve piksel (GD1) veya puan (GD1) cinsinden font boyutunu temsil eder
 *
 * Bu ayarın yalnızca TrueType fontları için geçerli olduğunu ve GD fontlarıyla etkisi olmadığını unutmayın
 *
 * Varsayılan değer 16'dır
 *
 * @access public
 * @var integer
 */
var $image_text_size;

/**
 * TrueType fontları için metin açısını ayarlar
 *
 * Değer, 0 ile 360 arasında bir tamsayıdır, derece cinsindendir ve 0 derece soldan sağa okunan metindir.
 *
 * Bu ayarın yalnızca TrueType fontları için geçerli olduğunu ve GD fontlarıyla etkisi olmadığını unutmayın
 * GD fontları için bunun yerine {@link image_text_direction} kullanabilirsiniz
 *
 * Varsayılan değer null'dur (bu nedenle {@link image_text_direction} değerine göre belirlenir)
 *
 * @access public
 * @var integer
 */
var $image_text_angle;

/**
 * Metin etiketinin görüntü içindeki konumunu ayarlar
 *
 * Değer 'TBLR' (üst, alt, sol, sağ) harflerinden biri veya ikisidir
 *
 * Konumlar aşağıdaki gibidir:
 * <pre>
 *                        TL  T  TR
 *                        L       R
 *                        BL  B  BR
 * </pre>
 *
 * Varsayılan değer null'dur (merkezlenmiş, yatay ve dikey)
 *
 * {@link image_text_x} ve {@link image_text_y} kullanılıyorsa, bu ayarın etkisi olmadığını unutmayın
 *
 * @access public
 * @var string
 */
var $image_text_position;

/**
 * Metin etiketinin görüntü içindeki mutlak X konumunu ayarlar
 *
 * Değer, görüntünün solundan etikete kadar olan mesafeyi temsil eden piksel cinsindendir
 * Negatif bir değer kullanılırsa, etikete kadar olan mesafeyi görüntünün sağından temsil eder
 *
 * Varsayılan değer null'dur (bu nedenle {@link image_text_position} kullanılır)
 *
 * @access public
 * @var integer
 */
var $image_text_x;

/**
 * Metin etiketinin görüntü içindeki mutlak Y konumunu ayarlar
 *
 * Değer, görüntünün üstünden etikete kadar olan mesafeyi temsil eden piksel cinsindendir
 * Negatif bir değer kullanılırsa, etikete kadar olan mesafeyi görüntünün altından temsil eder
 *
 * Varsayılan değer null'dur (bu nedenle {@link image_text_position} kullanılır)
 *
 * @access public
 * @var integer
 */
var $image_text_y;

/**
 * Metin etiketi dolgusunu ayarlar
 *
 * Değer, metin ile etiket arka plan sınırı arasındaki mesafeyi temsil eden piksel cinsindendir
 *
 * Varsayılan değer 0'dır
 *
 * Bu ayar {@link image_text_padding_x} ve {@link image_text_padding_y} ile geçersiz kılınabilir
 *
 * @access public
 * @var integer
 */
var $image_text_padding;

/**
 * Metin etiketi yatay dolgusunu ayarlar
 *
 * Değer, metin ile sol ve sağ etiket arka plan sınırları arasındaki mesafeyi temsil eden piksel cinsindendir
 *
 * Varsayılan değer null'dur
 *
 * Ayarlanırsa, bu ayar {@link image_text_padding} yatay kısmını geçersiz kılar
 *
 * @access public
 * @var integer
 */
var $image_text_padding_x;

/**
 * Metin etiketi dikey dolgusunu ayarlar
 *
 * Değer, metin ile üst ve alt etiket arka plan sınırları arasındaki mesafeyi temsil eden piksel cinsindendir
 *
 * Varsayılan değer null'dur
 *
 * Ayarlanırsa, bu ayar {@link image_text_padding} dikey kısmını geçersiz kılar
 *
 * @access public
 * @var integer
 */
var $image_text_padding_y;

/**
 * Metin hizalamasını ayarlar
 *
 * Değer bir dizedir ve 'L', 'C' veya 'R' olabilir
 *
 * Varsayılan değer 'C'dir
 *
 * Bu ayar yalnızca metin birden fazla satır içeriyorsa ilgilidir.
 *
 * Bu ayarın yalnızca GD fontları için geçerli olduğunu ve TrueType fontlarıyla etkisi olmadığını unutmayın
 *
 * @access public
 * @var string
 */
var $image_text_alignment;

/**
 * Metin satır aralığını ayarlar
 *
 * Değer piksel cinsindendir
 *
 * Varsayılan değer 0'dır
 *
 * Bu ayar yalnızca metin birden fazla satır içeriyorsa ilgilidir.
 *
 * Bu ayarın yalnızca GD fontları için geçerli olduğunu ve TrueType fontlarıyla etkisi olmadığını unutmayın
 *
 * @access public
 * @var integer
 */
var $image_text_line_spacing;

/**
 * Yansımanın yüksekliğini ayarlar
 *
 * Değer piksel cinsinden veya yüzde formatında bir dizedir.
 * Örneğin, değerler şunlar olabilir: 40, '40', '40px' veya '40%'
 *
 * Varsayılan değer null'dur, yansıma yok
 *
 * @access public
 * @var mixed
 */
var $image_reflection_height;

/**
 * Kaynak görüntü ile yansıması arasındaki boşluğu ayarlar
 *
 * Değer, negatif olabilen piksel cinsindendir
 *
 * Varsayılan değer 2'dir
 *
 * Bu ayar yalnızca {@link image_reflection_height} ayarlanmışsa ilgilidir
 *
 * @access public
 * @var integer
 */
var $image_reflection_space;

/**
 * Yansıtmanın başlangıç opaklığını ayarlar
 *
 * Değer, 0 (opaklık yok) ile 100 (tam opaklık) arasında bir tamsayıdır.
 * Yansıma {@link image_reflection_opacity} ile başlayacak ve 0'da sona erecektir
 *
 * Varsayılan değer 60'tır
 *
 * Bu ayar yalnızca {@link image_reflection_height} ayarlanmışsa ilgilidir
 *
 * @access public
 * @var integer
 */
var $image_reflection_opacity;

/**
 * EXIF verilerine göre görüntüyü otomatik olarak döndürür (yalnızca JPEG)
 *
 * Varsayılan değer true'dur
 *
 * @access public
 * @var boolean
 */
var $image_auto_rotate;

/**
 * Görüntüyü dikey veya yatay olarak çevirir
 *
 * Değer 'h' veya 'v' olabilir, yatay ve dikey
 *
 * Varsayılan değer null'dur (çevirme yok)
 *
 * @access public
 * @var string
 */
var $image_flip;

/**
 * Görüntüyü 45 derecelik artışlarla döndürür
 *
 * Değer 90, 180 veya 270 olabilir
 *
 * Varsayılan değer null'dur (döndürme yok)
 *
 * @access public
 * @var string
 */
var $image_rotate;

/**
 * Bir görüntüyü kırpar
 *
 * Değerler dört boyuttur veya iki veya bir (CSS tarzı)
 * Üst, sağ, alt ve sol kırpılan miktarı temsil ederler.
 * Bu değerler bir dizide veya boşlukla ayrılmış bir dizede olabilir.
 * Her değer piksel (px ile veya olmadan) veya yüzde (kaynak görüntünün) olabilir
 *
 * Örneğin, geçerlidir:
 * <pre>
 * $foo->image_crop = 20                  VEYA array(20);
 * $foo->image_crop = '20px'              VEYA array('20px');
 * $foo->image_crop = '20 40'             VEYA array('20', 40);
 * $foo->image_crop = '-20 25%'           VEYA array(-20, '25%');
 * $foo->image_crop = '20px 25%'          VEYA array('20px', '25%');
 * $foo->image_crop = '20% 25%'           VEYA array('20%', '25%');
 * $foo->image_crop = '20% 25% 10% 30%'   VEYA array('20%', '25%', '10%', '30%');
 * $foo->image_crop = '20px 25px 2px 2px' VEYA array('20px', '25%px', '2px', '2px');
 * $foo->image_crop = '20 25% 40px 10%'   VEYA array(20, '25%', '40px', '10%');
 * </pre>
 *
 * Bir değer negatifse, görüntü genişletilecek ve ekstra kısımlar siyahla doldurulacaktır
 *
 * Varsayılan değer null'dur (kırpma yok)
 *
 * @access public
 * @var string VEYA array
 */
var $image_crop;

/**
 * Olası bir yeniden boyutlandırmadan önce bir görüntüyü kırpar
 *
 * Geçerli formatlar için bkz. {@link image_crop}
 *
 * Varsayılan değer null'dur (kırpma yok)
 *
 * @access public
 * @var string VEYA array
 */
var $image_precrop;

/**
 * Görüntüye bevel kenarlık ekler
 *
 * Değer, bevel kalınlığını temsil eden pozitif bir tamsayıdır
 *
 * Bevel renkleri arka planla aynıysa, bir solma efekti oluşturur
 *
 * Varsayılan değer null'dur (bevel yok)
 *
 * @access public
 * @var integer
 */
var $image_bevel;

/**
 * Üst ve sol bevel rengi
 *
 * Değer, onaltılık formatta bir renktir
 * Bu ayar yalnızca {@link image_bevel} ayarlandığında kullanılır
 *
 * Varsayılan değer #FFFFFF'tir
 *
 * @access public
 * @var string
 */
var $image_bevel_color1;

/**
 * Sağ ve alt bevel rengi
 *
 * Değer, onaltılık formatta bir renktir
 * Bu ayar yalnızca {@link image_bevel} ayarlandığında kullanılır
 *
 * Varsayılan değer #000000'dır
 *
 * @access public
 * @var string
 */
var $image_bevel_color2;

/**
 * Görüntünün dışına tek renkli bir kenarlık ekler
 *
 * Değerler dört boyuttur veya iki veya bir (CSS tarzı)
 * Üst, sağ, alt ve sol kenarlık kalınlığını temsil ederler.
 * Bu değerler bir dizide veya boşlukla ayrılmış bir dizede olabilir.
 * Her değer piksel (px ile veya olmadan) veya yüzde (kaynak görüntünün) olabilir
 *
 * Geçerli formatlar için bkz. {@link image_crop}
 *
 * Bir değer negatifse, görüntü kırpılacaktır.
 * Resmin boyutlarının kenarlıkların kalınlığına göre artacağını unutmayın
 *
 * Varsayılan değer null'dur (kenarlık yok)
 *
 * @access public
 * @var integer
 */
var $image_border;

/**
 * Kenarlık rengi
 *
 * Değer, onaltılık formatta bir renktir.
 * Bu ayar yalnızca {@link image_border} ayarlandığında kullanılır
 *
 * Varsayılan değer #FFFFFF'tir
 *
 * @access public
 * @var string
 */
var $image_border_color;

/**
 * Kenarlıklar için opaklığı ayarlar
 *
 * Değer, 0 (şeffaf) ile 100 (opak) arasında bir yüzde olarak tamsayıdır
 *
 * {@link image_border} ile kullanılmadıkça, bu ayarın bir etkisi yoktur
 *
 * Varsayılan değer 100'dür
 *
 * @access public
 * @var integer
 */
var $image_border_opacity;

/**
 * Görüntüye şeffaflığa geçiş yapan bir kenarlık ekler
 *
 * Değerler dört boyuttur veya iki veya bir (CSS tarzı)
 * Üst, sağ, alt ve sol kenarlık kalınlığını temsil ederler.
 * Bu değerler bir dizide veya boşlukla ayrılmış bir dizede olabilir.
 * Her değer piksel (px ile veya olmadan) veya yüzde (kaynak görüntünün) olabilir
 *
 * Geçerli formatlar için bkz. {@link image_crop}
 *
 * Resmin boyutlarının kenarlıkların kalınlığına göre artmayacağını unutmayın
 *
 * Varsayılan değer null'dur (kenarlık yok)
 *
 * @access public
 * @var integer
 */
var $image_border_transparent;

/**
 * Görüntünün dışına çok renkli bir çerçeve ekler
 *
 * Değer bir tamsayıdır. Şu anda iki değer mümkündür:
 * 1 düz kenarlık için, çerçeve yatay ve dikey olarak aynalanır
 * 2 çapraz kenarlık için, çerçeve ters çevrilir, bevel efekti gibi
 *
 * Çerçeve, {@link image_frame_colors} içinde ayarlanmış renkli çizgilerden oluşacaktır
 *
 * Resmin boyutlarının kenarlıkların kalınlığına göre artacağını unutmayın
 *
 * Varsayılan değer null'dur (çerçeve yok)
 *
 * @access public
 * @var integer
 */
var $image_frame;

/**
 * Bir çerçeve çizmek için kullanılan renkleri ayarlar
 *
 * Değer, onaltılık formatta n renk listesidir.
 * Bu değerler bir dizide veya boşlukla ayrılmış bir dizede olabilir.
 *
 * Renkler şu sırayla listelenir: resmin dışından merkezine doğru
 *
 * Örneğin, geçerlidir:
 * <pre>
 * $foo->image_frame_colors = '#FFFFFF #999999 #666666 #000000';
 * $foo->image_frame_colors = array('#FFFFFF', '#999999', '#666666', '#000000');
 * </pre>
 *
 * Bu ayar yalnızca {@link image_frame} ayarlandığında kullanılır
 *
 * Varsayılan değer '#FFFFFF #999999 #666666 #000000'dır
 *
 * @access public
 * @var string VEYA array
 */
var $image_frame_colors;

/**
 * Çerçeve için opaklığı ayarlar
 *
 * Değer, 0 (şeffaf) ile 100 (opak) arasında bir yüzde olarak tamsayıdır
 *
 * {@link image_frame} ile kullanılmadıkça, bu ayarın bir etkisi yoktur
 *
 * Varsayılan değer 100'dür
 *
 * @access public
 * @var integer
 */
var $image_frame_opacity;

/**
 * Görüntüye bir filigran ekler
 *
 * Değer, yerel bir görüntü dosya adıdır, göreli veya mutlak. GIF, JPG, BMP, WEBP ve PNG desteklenir, ayrıca PNG ve WEBP alfa.
 *
 * Ayarlanmışsa, bu ayar image_watermark_ ile başlayan tüm diğer ayarların kullanılmasına izin verir
 *
 * Varsayılan değer null'dur
 *
 * @access public
 * @var string
 */
var $image_watermark;

/**
 * Filigranın görüntü içindeki konumunu ayarlar
 *
 * Değer 'TBLR' (üst, alt, sol, sağ) harflerinden biri veya ikisidir
 *
 * Konumlar şu şekildedir:   TL  T  TR
 *                           L       R
 *                           BL  B  BR
 *
 * Varsayılan değer null'dur (merkezlenmiş, yatay ve dikey)
 *
 * {@link image_watermark_x} ve {@link image_watermark_y} kullanılıyorsa, bu ayarın etkisi olmadığını unutmayın
 *
 * @access public
 * @var string
 */
var $image_watermark_position;

/**
 * Filigranın görüntü içindeki mutlak X konumunu ayarlar
 *
 * Değer, görüntünün üstünden filigrana kadar olan mesafeyi temsil eden piksel cinsindendir
 * Negatif bir değer kullanılırsa, filigrana kadar olan mesafeyi görüntünün altından temsil eder
 *
 * Varsayılan değer null'dur (bu nedenle {@link image_watermark_position} kullanılır)
 *
 * @access public
 * @var integer
 */
var $image_watermark_x;

/**
 * Filigranın görüntü içindeki mutlak Y konumunu ayarlar
 *
 * Değer, görüntünün solundan filigrana kadar olan mesafeyi temsil eden piksel cinsindendir
 * Negatif bir değer kullanılırsa, filigrana kadar olan mesafeyi görüntünün sağından temsil eder
 *
 * Varsayılan değer null'dur (bu nedenle {@link image_watermark_position} kullanılır)
 *
 * @access public
 * @var integer
 */
var $image_watermark_y;

/**
 * Filigranın görüntüden küçükse yeniden boyutlandırılmasını önler
 *
 * Filigran, istenen filigran konumunu dikkate alarak hedef görüntüden küçükse
 * görüntüyü dolduracak şekilde yeniden boyutlandırılacaktır (minus the {@link image_watermark_x} veya {@link image_watermark_y} değerleri)
 *
 * Filigranınızın herhangi bir şekilde yeniden boyutlandırılmasını istemiyorsanız,
 * {@link image_watermark_no_zoom_in} ve {@link image_watermark_no_zoom_out} ayarlarını true olarak ayarlayın
 * Filigranınızın görüntüyü daha iyi doldurması için yukarı veya aşağı yeniden boyutlandırılmasını istiyorsanız,
 * {@link image_watermark_no_zoom_in} ve {@link image_watermark_no_zoom_out} ayarlarını false olarak ayarlayın
 *
 * Varsayılan değer true'dur (bu nedenle filigran büyütülmeyecek, bu çoğu kişinin beklediği davranıştır)
 *
 * @access public
 * @var integer
 */
var $image_watermark_no_zoom_in;

/**
 * Filigranın görüntüden büyükse yeniden boyutlandırılmasını önler
 *
 * Filigran, istenen filigran konumunu dikkate alarak hedef görüntüden büyükse
 * görüntüye sığacak şekilde yeniden boyutlandırılacaktır (minus the {@link image_watermark_x} veya {@link image_watermark_y} değerleri)
 *
 * Filigranınızın herhangi bir şekilde yeniden boyutlandırılmasını istemiyorsanız,
 * {@link image_watermark_no_zoom_in} ve {@link image_watermark_no_zoom_out} ayarlarını true olarak ayarlayın
 * Filigranınızın görüntüyü daha iyi doldurması için yukarı veya aşağı yeniden boyutlandırılmasını istiyorsanız,
 * {@link image_watermark_no_zoom_in} ve {@link image_watermark_no_zoom_out} ayarlarını false olarak ayarlayın
 *
 * Varsayılan değer false'dur (bu nedenle filigran görüntüye sığacak şekilde küçültülebilir)
 *
 * @access public
 * @var integer
 */
var $image_watermark_no_zoom_out;

/**
 * Uzantıya göre MIME türlerinin listesi
 *
 * @access private
 * @var array
 */
var $mime_types;

/**
 * İzin verilen MIME türleri veya dosya uzantıları
 *
 * Varsayılan olarak güvenli mime türlerinin bir seçimi vardır, ancak bunu değiştirmek isteyebilirsiniz
 *
 * Basit joker karakterler MIME türleri için izin verilir, örneğin image/* veya application/*
 * Yalnızca bir MIME türüne veya dosya uzantısına izin verilirse, bir dizi yerine bir dize olabilir
 *
 * @access public
 * @var array VEYA string
 */
var $allowed;

/**
 * Yasaklanan MIME türleri veya dosya uzantıları
 *
 * Varsayılan olarak yasaklanmış dosya uzantılarının bir seçimi vardır, ancak bunu değiştirmek isteyebilirsiniz
 * Yalnızca yasaklanan MIME türlerini kontrol etmek ve diğer her şeye izin vermek için {@link allowed} ayarını array('*/*') olarak ayarlayın (boşluksuz)
 *
 * {@link no_script} etkinleştirilmişse, {@link dangerous} içinde uzantıları olan tehlikeli betiklerin
 * yasaklanmış uzantılar için kontrol edilmeden önce bir .txt uzantısına sahip olacağını unutmayın
 * Betiklerin metin dosyalarına dönüştürülmesi yerine yüklemeleri yasaklamak istiyorsanız, {@link no_script} ayarını false olarak ayarlayın
 *
 * Basit joker karakterler MIME türleri için izin verilir, örneğin image/* veya application/*
 * Yalnızca bir MIME türü veya dosya uzantısı yasaklanmışsa, bir dizi yerine bir dize olabilir
 *
 * @access public
 * @var array VEYA string
 */
var $forbidden;

/**
 * Çevrilmiş hata mesajları dizisi
 *
 * Varsayılan olarak, dil İngilizce'dir (en_GB)
 * Çeviriler ayrı dosyalarda, lang/ alt dizininde olabilir
 *
 * @access public
 * @var array
 */
var $translation;

/**
 * Çeviriler için seçilen dil
 *
 * Varsayılan olarak, dil İngilizce'dir ("en_GB")
 *
 * @access public
 * @var array
 */
var $lang;

/**
 * Tüm işleme değişkenlerini varsayılan değerlerine başlat veya yeniden başlat
 *
 * Bu işlev yapıcıda ve her {@link process} çağrısından sonra çağrılır
 *
 * @access private
 */
function init() {

    // üzerine yazılabilir değişkenler
    $this->file_new_name_body       = null;     // ad gövdesini değiştir
    $this->file_name_body_add       = null;     // ad gövdesine ekle
    $this->file_name_body_pre       = null;     // ad gövdesine ön ekle
    $this->file_new_name_ext        = null;     // dosya uzantısını değiştir
    $this->file_safe_name           = true;     // dosya adını güvenli bir şekilde biçimlendir
    $this->file_force_extension     = true;     // uzantı yoksa zorla ekler
    $this->file_overwrite           = false;    // dosya zaten varsa üzerine yazmaya izin verir
    $this->file_auto_rename         = true;     // dosya zaten varsa otomatik yeniden adlandırma
    $this->dir_auto_create          = true;     // dizin eksikse otomatik oluşturma
    $this->dir_auto_chmod           = true;     // dizin yazılabilir değilse otomatik chmod
    $this->dir_chmod                = 0755;     // kullanılacak varsayılan chmod

    $this->no_script                = true;     // betikleri test dosyalarına dönüştürür
    $this->mime_check               = true;     // mime türünü izin verilen listeye karşı kontrol eder

    // bunlar farklı MIME tespit yöntemleridir. sisteminizde bu yöntemlerden biri çalışmıyorsa,
    // burada devre dışı bırakabilirsiniz; sadece false olarak ayarlayın
    $this->mime_fileinfo            = true;     // Fileinfo PECL uzantısı ile MIME tespiti
    $this->mime_file                = true;     // UNIX file() komutu ile MIME tespiti
    $this->mime_magic               = true;     // mime_magic (mime_content_type()) ile MIME tespiti
    $this->mime_getimagesize        = true;     // getimagesize() ile MIME tespiti

    // php.ini'den varsayılan maksimum boyutu alın
    $this->file_max_size_raw = trim(ini_get('upload_max_filesize'));
    $this->file_max_size = $this->getsize($this->file_max_size_raw);

    $this->image_resize             = false;    // resmi yeniden boyutlandır
    $this->image_convert            = '';       // dönüştür. değerler :''; 'png'; 'jpeg'; 'gif'; 'bmp'; 'webp'

    $this->image_x                  = 150;
    $this->image_y                  = 150;
    $this->image_ratio              = false;    // x ve y boyutları içinde en boy oranını korur
    $this->image_ratio_crop         = false;    // x ve y boyutları içinde en boy oranını korur, alanı doldurur
    $this->image_ratio_fill         = false;    // x ve y boyutları içinde en boy oranını korur, görüntüyü alana sığdırır
    $this->image_ratio_pixels       = false;    // piksel sayısına ulaşmak için en boy oranını korur, x ve y'yi hesaplar
    $this->image_ratio_x            = false;    // $image_x'i hesaplar eğer true ise
    $this->image_ratio_y            = false;    // $image_y'yi hesaplar eğer true ise
    $this->image_ratio_no_zoom_in   = false;
    $this->image_ratio_no_zoom_out  = false;
    $this->image_no_enlarging       = false;
    $this->image_no_shrinking       = false;

    $this->png_compression          = null;
    $this->webp_quality             = 85;
    $this->jpeg_quality             = 85;
    $this->jpeg_size                = null;
    $this->image_interlace          = false;
    $this->image_is_transparent     = false;
    $this->image_transparent_color  = null;
    $this->image_background_color   = null;
    $this->image_default_color      = '#ffffff';
    $this->image_is_palette         = false;

    $this->image_max_width          = null;
    $this->image_max_height         = null;
    $this->image_max_pixels         = null;
    $this->image_max_ratio          = null;
    $this->image_min_width          = null;
    $this->image_min_height         = null;
    $this->image_min_pixels         = null;
    $this->image_min_ratio          = null;

    $this->image_brightness         = null;
    $this->image_contrast           = null;
    $this->image_opacity            = null;
    $this->image_threshold          = null;
    $this->image_tint_color         = null;
    $this->image_overlay_color      = null;
    $this->image_overlay_opacity    = null;
    $this->image_negative           = false;
    $this->image_greyscale          = false;
    $this->image_pixelate           = null;
    $this->image_unsharp            = false;
    $this->image_unsharp_amount     = 80;
    $this->image_unsharp_radius     = 0.5;
    $this->image_unsharp_threshold  = 1;

    $this->image_text               = null;
    $this->image_text_direction     = null;
    $this->image_text_color         = '#FFFFFF';
    $this->image_text_opacity       = 100;
    $this->image_text_background    = null;
    $this->image_text_background_opacity = 100;
    $this->image_text_font          = 5;
    $this->image_text_size          = 16;
    $this->image_text_angle         = null;
    $this->image_text_x             = null;
    $this->image_text_y             = null;
    $this->image_text_position      = null;
    $this->image_text_padding       = 0;
    $this->image_text_padding_x     = null;
    $this->image_text_padding_y     = null;
    $this->image_text_alignment     = 'C';
    $this->image_text_line_spacing  = 0;

    $this->image_reflection_height  = null;
    $this->image_reflection_space   = 2;
    $this->image_reflection_opacity = 60;

    $this->image_watermark          = null;
    $this->image_watermark_x        = null;
    $this->image_watermark_y        = null;
    $this->image_watermark_position = null;
    $this->image_watermark_no_zoom_in  = true;
    $this->image_watermark_no_zoom_out = false;

    $this->image_flip               = null;
    $this->image_auto_rotate        = true;
    $this->image_rotate             = null;
    $this->image_crop               = null;
    $this->image_precrop            = null;

    $this->image_bevel              = null;
    $this->image_bevel_color1       = '#FFFFFF';
    $this->image_bevel_color2       = '#000000';
    $this->image_border             = null;
    $this->image_border_color       = '#FFFFFF';
    $this->image_border_opacity     = 100;
    $this->image_border_transparent = null;
    $this->image_frame              = null;
    $this->image_frame_colors       = '#FFFFFF #999999 #666666 #000000';
    $this->image_frame_opacity      = 100;

    $this->dangerous = array(
        'php',
        'php7',
        'php6',
        'php5',
        'php4',
        'php3',
        'phtml',
        'pht',
        'phpt',
        'phtm',
        'phps',
        'inc',
        'pl',
        'py',
        'cgi',
        'asp',
        'js',
        'sh',
        'bat',
        'phar',
        'wsdl',
        'html',
        'htm',
    );

    $this->forbidden = array_merge($this->dangerous, array(
        'exe',
        'dll',
    ));

    $this->allowed = array(
        'application/arj',
        'application/excel',
        'application/gnutar',
        'application/mspowerpoint',
        'application/msword',
        'application/octet-stream',
        'application/onenote',
        'application/pdf',
        'application/plain',
        'application/postscript',
        'application/powerpoint',
        'application/rar',
        'application/rtf',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel.addin.macroEnabled.12',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.template.macroEnabled.12',
        'application/vnd.ms-office',
        'application/vnd.ms-officetheme',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'application/vnd.ms-powerpoint.slide.macroEnabled.12',
        'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'application/vnd.ms-word',
        'application/vnd.ms-word.document.macroEnabled.12',
        'application/vnd.ms-word.template.macroEnabled.12',
        'application/vnd.oasis.opendocument.chart',
        'application/vnd.oasis.opendocument.database',
        'application/vnd.oasis.opendocument.formula',
        'application/vnd.oasis.opendocument.graphics',
        'application/vnd.oasis.opendocument.graphics-template',
        'application/vnd.oasis.opendocument.image',
        'application/vnd.oasis.opendocument.presentation',
        'application/vnd.oasis.opendocument.presentation-template',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.oasis.opendocument.spreadsheet-template',
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.text-master',
        'application/vnd.oasis.opendocument.text-template',
        'application/vnd.oasis.opendocument.text-web',
        'application/vnd.openofficeorg.extension',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.openxmlformats-officedocument.presentationml.template',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'application/vocaltec-media-file',
        'application/wordperfect',
        'application/haansoftxlsx',
        'application/x-bittorrent',
        'application/x-bzip',
        'application/x-bzip2',
        'application/x-compressed',
        'application/x-excel',
        'application/x-gzip',
        'application/x-latex',
        'application/x-midi',
        'application/xml',
        'application/x-msexcel',
        'application/x-rar',
        'application/x-rar-compressed',
        'application/x-rtf',
        'application/x-shockwave-flash',
        'application/x-sit',
        'application/x-stuffit',
        'application/x-troff-msvideo',
        'application/x-zip',
        'application/x-zip-compressed',
        'application/zip',
        'audio/*',
        'image/*',
        'multipart/x-gzip',
        'multipart/x-zip',
        'text/plain',
        'text/rtf',
        'text/richtext',
        'text/xml',
        'video/*',
        'text/csv',
        'text/x-c',
        'text/x-csv',
        'text/comma-separated-values',
        'text/x-comma-separated-values',
        'application/csv',
        'application/x-csv',
    );

$this->mime_types = array(
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpe' => 'image/jpeg',
    'gif' => 'image/gif',
    'webp' => 'image/webp',
    'png' => 'image/png',
    'bmp' => 'image/bmp',
    'flif' => 'image/flif',
    'flv' => 'video/x-flv',
    'js' => 'application/x-javascript',
    'json' => 'application/json',
    'tiff' => 'image/tiff',
    'css' => 'text/css',
    'xml' => 'application/xml',
    'doc' => 'application/msword',
    'xls' => 'application/vnd.ms-excel',
    'xlt' => 'application/vnd.ms-excel',
    'xlm' => 'application/vnd.ms-excel',
    'xld' => 'application/vnd.ms-excel',
    'xla' => 'application/vnd.ms-excel',
    'xlc' => 'application/vnd.ms-excel',
    'xlw' => 'application/vnd.ms-excel',
    'xll' => 'application/vnd.ms-excel',
    'ppt' => 'application/vnd.ms-powerpoint',
    'pps' => 'application/vnd.ms-powerpoint',
    'rtf' => 'application/rtf',
    'pdf' => 'application/pdf',
    'html' => 'text/html',
    'htm' => 'text/html',
    'php' => 'text/html',
    'txt' => 'text/plain',
    'mpeg' => 'video/mpeg',
    'mpg' => 'video/mpeg',
    'mpe' => 'video/mpeg',
    'mp3' => 'audio/mpeg3',
    'mp4' => 'video/mp4',
    'wav' => 'audio/wav',
    'aiff' => 'audio/aiff',
    'aif' => 'audio/aiff',
    'avi' => 'video/msvideo',
    'wmv' => 'video/x-ms-wmv',
    'mov' => 'video/quicktime',
    'zip' => 'application/zip',
    'tar' => 'application/x-tar',
    'swf' => 'application/x-shockwave-flash',
    'odt' => 'application/vnd.oasis.opendocument.text',
    'ott' => 'application/vnd.oasis.opendocument.text-template',
    'oth' => 'application/vnd.oasis.opendocument.text-web',
    'odm' => 'application/vnd.oasis.opendocument.text-master',
    'odg' => 'application/vnd.oasis.opendocument.graphics',
    'otg' => 'application/vnd.oasis.opendocument.graphics-template',
    'odp' => 'application/vnd.oasis.opendocument.presentation',
    'otp' => 'application/vnd.oasis.opendocument.presentation-template',
    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
    'odc' => 'application/vnd.oasis.opendocument.chart',
    'odf' => 'application/vnd.oasis.opendocument.formula',
    'odb' => 'application/vnd.oasis.opendocument.database',
    'odi' => 'application/vnd.oasis.opendocument.image',
    'oxt' => 'application/vnd.openofficeorg.extension',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
    'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
    'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
    'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
    'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
    'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
    'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
    'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
    'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
    'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
    'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
    'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
    'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
    'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
    'thmx' => 'application/vnd.ms-officetheme',
    'onetoc' => 'application/onenote',
    'onetoc2' => 'application/onenote',
    'onetmp' => 'application/onenote',
    'onepkg' => 'application/onenote',
    'csv' => 'text/csv',
);

/**
 * Yapıcı, PHP5+ için
 */
function  __construct($file, $lang = 'en_GB')  {
    $this->upload($file, $lang);
}

/**
 * Yapıcı, PHP4 için. Dosyanın yüklendiğini kontrol eder
 *
 * Yapıcı, argüman olarak $_FILES['form_field'] dizisini alır
 * form_field form alanının adıdır
 *
 * Yapıcı, dosyanın geçici konumunda yüklenip yüklenmediğini kontrol eder ve
 * buna göre {@link uploaded} ayarlayacaktır (ve bir hata oluştuysa {@link error})
 *
 * Dosya yüklendiyse, yapıcı yükleme bilgilerini tutan tüm değişkenleri dolduracaktır
 * (işleme sınıf değişkenlerinden hiçbiri burada kullanılmaz).
 * Dosya hakkında bilgiye (ad, boyut, MIME türü...) erişebilirsiniz.
 *
 *
 * Alternatif olarak, ilk argümanı yerel bir dosya adı (dize) olarak ayarlayabilirsiniz
 * Bu, dosya yüklenmiş gibi yerel bir dosyanın işlenmesine izin verir
 *
 * İsteğe bağlı ikinci argüman hata mesajları için dili ayarlamanıza izin verir
 *
 * @access private
 * @param  array  $file $_FILES['form_field']
 *    veya   string $file Yerel dosya adı
 * @param  string $lang İsteğe bağlı dil kodu
 */
function upload($file, $lang = 'en_GB') {

    $this->version            = '10/09/2024';

    $this->file_src_name      = '';
    $this->file_src_name_body = '';
    $this->file_src_name_ext  = '';
    $this->file_src_mime      = '';
    $this->file_src_size      = '';
    $this->file_src_error     = '';
    $this->file_src_pathname  = '';
    $this->file_src_temp      = '';

    $this->file_dst_path      = '';
    $this->file_dst_name      = '';
    $this->file_dst_name_body = '';
    $this->file_dst_name_ext  = '';
    $this->file_dst_pathname  = '';

    $this->image_src_x        = null;
    $this->image_src_y        = null;
    $this->image_src_bits     = null;
    $this->image_src_type     = null;
    $this->image_src_pixels   = null;
    $this->image_dst_x        = 0;
    $this->image_dst_y        = 0;
    $this->image_dst_type     = '';

    $this->uploaded           = true;
    $this->no_upload_check    = false;
    $this->processed          = false;
    $this->error              = '';
    $this->log                = '';
    $this->allowed            = array();
    $this->forbidden          = array();
    $this->file_is_image      = false;
    $this->init();
    $info                     = null;
    $mime_from_browser        = null;

    // varsayılan dili ayarlar
    $this->translation        = array();
    $this->translation['file_error']                  = 'Dosya hatası. Lütfen tekrar deneyin.';
    $this->translation['local_file_missing']          = 'Yerel dosya mevcut değil.';
    $this->translation['local_file_not_readable']     = 'Yerel dosya okunabilir değil.';
    $this->translation['uploaded_too_big_ini']        = 'Dosya yükleme hatası (yüklenen dosya php.ini dosyasındaki upload_max_filesize yönergesini aşıyor).';
    $this->translation['uploaded_too_big_html']       = 'Dosya yükleme hatası (yüklenen dosya html formunda belirtilen MAX_FILE_SIZE yönergesini aşıyor).';
    $this->translation['uploaded_partial']            = 'Dosya yükleme hatası (yüklenen dosya yalnızca kısmen yüklendi).';
    $this->translation['uploaded_missing']            = 'Dosya yükleme hatası (dosya yüklenmedi).';
    $this->translation['uploaded_no_tmp_dir']         = 'Dosya yükleme hatası (geçici klasör eksik).';
    $this->translation['uploaded_cant_write']         = 'Dosya yükleme hatası (dosya diske yazılamadı).';
    $this->translation['uploaded_err_extension']      = 'Dosya yükleme hatası (dosya yükleme uzantı tarafından durduruldu).';
    $this->translation['uploaded_unknown']            = 'Dosya yükleme hatası (bilinmeyen hata kodu).';
    $this->translation['try_again']                   = 'Dosya yükleme hatası. Lütfen tekrar deneyin.';
    $this->translation['file_too_big']                = 'Dosya çok büyük.';
    $this->translation['no_mime']                     = 'MIME türü tespit edilemiyor.';
    $this->translation['incorrect_file']              = 'Yanlış türde dosya.';
    $this->translation['image_too_wide']              = 'Görüntü çok geniş.';
    $this->translation['image_too_narrow']            = 'Görüntü çok dar.';
    $this->translation['image_too_high']              = 'Görüntü çok uzun.';
    $this->translation['image_too_short']             = 'Görüntü çok kısa.';
    $this->translation['ratio_too_high']              = 'Görüntü oranı çok yüksek (görüntü çok geniş).';
    $this->translation['ratio_too_low']               = 'Görüntü oranı çok düşük (görüntü çok uzun).';
    $this->translation['too_many_pixels']             = 'Görüntüde çok fazla piksel var.';
    $this->translation['not_enough_pixels']           = 'Görüntüde yeterli piksel yok.';
    $this->translation['file_not_uploaded']           = 'Dosya yüklenmedi. İşleme devam edilemiyor.';
    $this->translation['already_exists']              = '%s zaten var. Lütfen dosya adını değiştirin.';
    $this->translation['temp_file_missing']           = 'Doğru geçici kaynak dosyası yok. İşleme devam edilemiyor.';
    $this->translation['source_missing']              = 'Doğru yüklenmiş kaynak dosyası yok. İşleme devam edilemiyor.';
    $this->translation['destination_dir']             = 'Hedef dizin oluşturulamıyor. İşleme devam edilemiyor.';
    $this->translation['destination_dir_missing']     = 'Hedef dizin mevcut değil. İşleme devam edilemiyor.';
    $this->translation['destination_path_not_dir']    = 'Hedef yol bir dizin değil. İşleme devam edilemiyor.';
    $this->translation['destination_dir_write']       = 'Hedef dizin yazılabilir yapılamıyor. İşleme devam edilemiyor.';
    $this->translation['destination_path_write']      = 'Hedef yol yazılabilir değil. İşleme devam edilemiyor.';
    $this->translation['temp_file']                   = 'Geçici dosya oluşturulamıyor. İşleme devam edilemiyor.';
    $this->translation['source_not_readable']         = 'Kaynak dosya okunabilir değil. İşleme devam edilemiyor.';
    $this->translation['no_create_support']           = '%s oluşturma desteği yok.';
    $this->translation['create_error']                = 'Kaynak dosyadan %s görüntüsü oluşturma hatası.';
    $this->translation['source_invalid']              = 'Görüntü kaynağı okunamıyor. Görüntü değil mi?.';
    $this->translation['gd_missing']                  = 'GD mevcut gibi görünmüyor.';
    $this->translation['watermark_no_create_support'] = '%s oluşturma desteği yok, filigran okunamıyor.';
    $this->translation['watermark_create_error']      = '%s okuma desteği yok, filigran oluşturulamıyor.';
    $this->translation['watermark_invalid']           = 'Bilinmeyen görüntü formatı, filigran okunamıyor.';
    $this->translation['file_create']                 = '%s oluşturma desteği yok.';
    $this->translation['no_conversion_type']          = 'Dönüşüm türü tanımlanmamış.';
    $this->translation['copy_failed']                 = 'Dosya sunucuda kopyalanırken hata oluştu. copy() başarısız oldu.';
    $this->translation['reading_failed']              = 'Dosya okunurken hata oluştu.';

    // dili belirler
    $this->lang               = $lang;
    if ($this->lang != 'en_GB' && file_exists(dirname(__FILE__).'/lang') && file_exists(dirname(__FILE__).'/lang/class.upload.' . $lang . '.php')) {
        $translation = null;
        include(dirname(__FILE__).'/lang/class.upload.' . $lang . '.php');
        if (is_array($translation)) {
            $this->translation = array_merge($this->translation, $translation);
        } else {
            $this->lang = 'en_GB';
        }
    }

    // desteklenen MIME türlerini ve eşleşen görüntü formatını belirler
    $this->image_supported = array();
    if ($this->gdversion()) {
        if (imagetypes() & IMG_GIF) {
            $this->image_supported['image/gif'] = 'gif';
        }
        if (imagetypes() & IMG_JPG) {
            $this->image_supported['image/jpg'] = 'jpg';
            $this->image_supported['image/jpeg'] = 'jpg';
            $this->image_supported['image/pjpeg'] = 'jpg';
        }
        if (imagetypes() & IMG_PNG) {
            $this->image_supported['image/png'] = 'png';
            $this->image_supported['image/x-png'] = 'png';
        }
        if (imagetypes() & IMG_WEBP) {
            $this->image_supported['image/webp'] = 'webp';
            $this->image_supported['image/x-webp'] = 'webp';
        }
        if (imagetypes() & IMG_WBMP) {
            $this->image_supported['image/bmp'] = 'bmp';
            $this->image_supported['image/x-ms-bmp'] = 'bmp';
            $this->image_supported['image/x-windows-bmp'] = 'bmp';
        }
    }

    // bazı sistem bilgilerini görüntüler
    if (empty($this->log)) {
        $this->log .= '<b>sistem bilgisi</b><br />';
        if ($this->function_enabled('ini_get_all')) {
            $inis = ini_get_all();
            $open_basedir = (array_key_exists('open_basedir', $inis) && array_key_exists('local_value', $inis['open_basedir']) && !empty($inis['open_basedir']['local_value'])) ? $inis['open_basedir']['local_value'] : false;
        } else {
            $open_basedir = false;
        }
        $gd           = $this->gdversion() ? $this->gdversion(true) : 'GD mevcut değil';
        $supported    = trim((in_array('png', $this->image_supported) ? 'png' : '') . ' ' .
                             (in_array('webp', $this->image_supported) ? 'webp' : '') . ' ' .
                             (in_array('jpg', $this->image_supported) ? 'jpg' : '') . ' ' .
                             (in_array('gif', $this->image_supported) ? 'gif' : '') . ' ' .
                             (in_array('bmp', $this->image_supported) ? 'bmp' : ''));
        $this->log .= '-&nbsp;sınıf versiyonu           : ' . $this->version . '<br />';
        $this->log .= '-&nbsp;işletim sistemi          : ' . PHP_OS . '<br />';
        $this->log .= '-&nbsp;PHP versiyonu            : ' . PHP_VERSION . '<br />';
        $this->log .= '-&nbsp;GD versiyonu             : ' . $gd . '<br />';
        $this->log .= '-&nbsp;desteklenen görüntü türleri : ' . (!empty($supported) ? $supported : 'yok') . '<br />';
        $this->log .= '-&nbsp;open_basedir            : ' . (!empty($open_basedir) ? $open_basedir : 'kısıtlama yok') . '<br />';
        $this->log .= '-&nbsp;upload_max_filesize     : ' . $this->file_max_size_raw . ' (' . $this->file_max_size . ' bayt)<br />';
        $this->log .= '-&nbsp;dil                     : ' . $this->lang . '<br />';
    }

    if (!$file) {
        $this->uploaded = false;
        $this->error = $this->translate('file_error');
    }
		
// yerel bir dosya adı veya bir PHP akışı gönderip göndermediğimizi kontrol eder
if (!is_array($file)) {
    if (empty($file)) {
        $this->uploaded = false;
        $this->error = $this->translate('file_error');
    } else {
        $file = (string) $file;
        if (substr($file, 0, 4) == 'php:' || substr($file, 0, 5) == 'data:' || substr($file, 0, 7) == 'base64:') {
            $data = null;

            // bu bir PHP akışıdır, yani yüklenmemiştir
            if (substr($file, 0, 4) == 'php:') {
                $file = preg_replace('/^php:(.*)/i', '$1', $file);
                if (!$file) $file = $_SERVER['HTTP_X_FILE_NAME'];
                if (!$file) $file = 'unknown';
                $data = file_get_contents('php://input');
                $this->log .= '<b>kaynak bir PHP akışıdır ' . $file . ' uzunlukta ' . strlen($data) . '</b><br />';

            // bu ham dosya verisidir, base64 kodlanmış, yani yüklenmemiştir
            } else if (substr($file, 0, 7) == 'base64:') {
                $data = base64_decode(preg_replace('/^base64:(.*)/i', '$1', $file));
                $file = 'base64';
                $this->log .= '<b>kaynak bir base64 dizesidir uzunlukta ' . strlen($data) . '</b><br />';

            // bu ham dosya verisidir, base64 kodlanmış, yani yüklenmemiştir
            } else if (substr($file, 0, 5) == 'data:' && strpos($file, 'base64,') !== false) {
                $data = base64_decode(preg_replace('/^data:.*base64,(.*)/i', '$1', $file));
                $file = 'base64';
                $this->log .= '<b>kaynak bir base64 veri dizesidir uzunlukta ' . strlen($data) . '</b><br />';

            // bu ham dosya verisidir, yani yüklenmemiştir
            } else if (substr($file, 0, 5) == 'data:') {
                $data = preg_replace('/^data:(.*)/i', '$1', $file);
                $file = 'data';
                $this->log .= '<b>kaynak bir veri dizesidir uzunlukta ' . strlen($data) . '</b><br />';
            }

            if (!$data) {
                $this->log .= '- kaynak boş!<br />';
                $this->uploaded = false;
                $this->error = $this->translate('source_invalid');
            }

            $this->no_upload_check = true;

            if ($this->uploaded) {
                $this->log .= '- geçici dosya gerekli ... ';
                $hash = $this->temp_dir() . md5($file . rand(1, 1000));
                if ($data && file_put_contents($hash, $data)) {
                    $this->file_src_pathname = $hash;
                    $this->log .= ' dosya oluşturuldu<br />';
                    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;geçici dosya: ' . $this->file_src_pathname . '<br />';
                } else {
                    $this->log .= ' başarısız<br />';
                    $this->uploaded = false;
                    $this->error = $this->translate('temp_file');
                }
            }

            if ($this->uploaded) {
                $this->file_src_name       = $file;
                $this->log .= '- yerel dosya OK<br />';
                preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
                if (is_array($extension) && sizeof($extension) > 0) {
                    $this->file_src_name_ext      = strtolower($extension[1]);
                    $this->file_src_name_body     = substr($this->file_src_name, 0, ((strlen($this->file_src_name) - strlen($this->file_src_name_ext)))-1);
                } else {
                    $this->file_src_name_ext      = '';
                    $this->file_src_name_body     = $this->file_src_name;
                }
                $this->file_src_size = (file_exists($this->file_src_pathname) ? filesize($this->file_src_pathname) : 0);
            }
            $this->file_src_error = 0;

        } else {
            // bu bir yerel dosya adıdır, yani yüklenmemiştir
            $this->log .= '<b>kaynak bir yerel dosyadır ' . $file . '</b><br />';
            $this->no_upload_check = true;

            if ($this->uploaded && !file_exists($file)) {
                $this->uploaded = false;
                $this->error = $this->translate('local_file_missing');
            }

            if ($this->uploaded && !is_readable($file)) {
                $this->uploaded = false;
                $this->error = $this->translate('local_file_not_readable');
            }

            if ($this->uploaded) {
                $this->file_src_pathname   = $file;
                $this->file_src_name       = basename($file);
                $this->log .= '- yerel dosya OK<br />';
                preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
                if (is_array($extension) && sizeof($extension) > 0) {
                    $this->file_src_name_ext      = strtolower($extension[1]);
                    $this->file_src_name_body     = substr($this->file_src_name, 0, ((strlen($this->file_src_name) - strlen($this->file_src_name_ext)))-1);
                } else {
                    $this->file_src_name_ext      = '';
                    $this->file_src_name_body     = $this->file_src_name;
                }
                $this->file_src_size = (file_exists($this->file_src_pathname) ? filesize($this->file_src_pathname) : 0);
            }
            $this->file_src_error = 0;
        }
    }
} else {
    // bu $_FILE'dan bir öğedir, yani yüklenmiş bir dosyadır
    $this->log .= '<b>kaynak yüklenmiş bir dosyadır</b><br />';
    if ($this->uploaded) {
        $this->file_src_error         = trim((int) $file['error']);
        switch($this->file_src_error) {
            case UPLOAD_ERR_OK:
                // her şey OK
                $this->log .= '- yükleme OK<br />';
                break;
            case UPLOAD_ERR_INI_SIZE:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_too_big_ini');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_too_big_html');
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_partial');
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_missing');
                break;
            case @UPLOAD_ERR_NO_TMP_DIR:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_no_tmp_dir');
                break;
            case @UPLOAD_ERR_CANT_WRITE:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_cant_write');
                break;
            case @UPLOAD_ERR_EXTENSION:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_err_extension');
                break;
            default:
                $this->uploaded = false;
                $this->error = $this->translate('uploaded_unknown') . ' ('.$this->file_src_error.')';
        }
    }

    if ($this->uploaded) {
        $this->file_src_pathname   = (string) $file['tmp_name'];
        $this->file_src_name       = (string) $file['name'];
        if ($this->file_src_name == '') {
            $this->uploaded = false;
            $this->error = $this->translate('try_again');
        }
    }

    if ($this->uploaded) {
        $this->log .= '- dosya adı OK<br />';
        preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
        if (is_array($extension) && sizeof($extension) > 0) {
            $this->file_src_name_ext      = strtolower($extension[1]);
            $this->file_src_name_body     = substr($this->file_src_name, 0, ((strlen($this->file_src_name) - strlen($this->file_src_name_ext)))-1);
        } else {
            $this->file_src_name_ext      = '';
            $this->file_src_name_body     = $this->file_src_name;
        }
        $this->file_src_size = (int) $file['size'];
        $mime_from_browser = (string) $file['type'];
    }
}

if ($this->uploaded) {
    $this->log .= '<b>MIME türü belirleniyor</b><br />';
    $this->file_src_mime = null;

    // Fileinfo PECL uzantısı ile MIME türünü kontrol eder
    if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === false) {
        if ($this->mime_fileinfo) {
            $this->log .= '- Fileinfo PECL uzantısı ile MIME türü kontrol ediliyor<br />';
            if ($this->function_enabled('finfo_open')) {
                $path = null;
                if ($this->mime_fileinfo !== '') {
                    if ($this->mime_fileinfo === true) {
                        if (getenv('MAGIC') === false) {
                            if (substr(PHP_OS, 0, 3) == 'WIN') {
                                $path = realpath(ini_get('extension_dir') . '/../') . '/extras/magic';
                                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC yolu varsayılan olarak ' . $path . '<br />';
                            }
                        } else {
                            $path = getenv('MAGIC');
                            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC yolu MAGIC değişkeninden ' . $path . ' olarak ayarlandı<br />';
                        }
                    } else {
                        $path = $this->mime_fileinfo;
                        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC yolu ' . $path . ' olarak ayarlandı<br />';
                    }
                }
                if ($path && file_exists($path)) {
                    $f = @finfo_open(FILEINFO_MIME, $path);
                } else {
                    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC yolu kullanılmayacak<br />';
                    $f = @finfo_open(FILEINFO_MIME);
                }
                if ($f) {
                    $mime = finfo_file($f, realpath($this->file_src_pathname));
                    finfo_close($f);
                    $this->file_src_mime = $mime;
                    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME türü Fileinfo PECL uzantısı tarafından ' . $this->file_src_mime . ' olarak tespit edildi<br />';
                    if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
                        $this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
                        $this->log .= '-&nbsp;MIME ' . $this->file_src_mime . ' olarak doğrulandı<br />';
                    } else {
                        $this->file_src_mime = null;
                    }
                } else {
                    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;Fileinfo PECL uzantısı başarısız oldu (finfo_open)<br />';
                }
            } elseif (@class_exists('finfo', false)) {
                $f = new finfo( FILEINFO_MIME );
                if ($f) {
                    $this->file_src_mime = $f->file(realpath($this->file_src_pathname));
                    $this->log .= '- MIME türü Fileinfo PECL uzantısı tarafından ' . $this->file_src_mime . ' olarak tespit edildi<br />';
                    if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
                        $this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
                        $this->log .= '-&nbsp;MIME ' . $this->file_src_mime . ' olarak doğrulandı<br />';
                    } else {
                        $this->file_src_mime = null;
                    }
                } else {
                    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;Fileinfo PECL uzantısı başarısız oldu (finfo)<br />';
                }
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;Fileinfo PECL uzantısı mevcut değil<br />';
            }
        } else {
            $this->log .= '- Fileinfo PECL uzantısı devre dışı bırakıldı<br />';
        }
    }

    // UNIX erişimine izin veriliyorsa shell ile MIME türünü kontrol eder
    if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === false) {
        if ($this->mime_file) {
            $this->log .= '- UNIX file() komutu ile MIME türü kontrol ediliyor<br />';
            if (substr(PHP_OS, 0, 3) != 'WIN') {
                if ($this->function_enabled('exec') && $this->function_enabled('escapeshellarg')) {
                    if (strlen($mime = @exec("file -bi ".escapeshellarg($this->file_src_pathname))) != 0) {
                        $this->file_src_mime = trim($mime);
                        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME türü UNIX file() komutu tarafından ' . $this->file_src_mime . ' olarak tespit edildi<br />';
                        if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
                            $this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
                            $this->log .= '-&nbsp;MIME ' . $this->file_src_mime . ' olarak doğrulandı<br />';
                        } else {
                            $this->file_src_mime = null;
                        }
                    } else {
                        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;UNIX file() komutu başarısız oldu<br />';
                    }
                } else {
                    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;PHP exec() işlevi devre dışı bırakıldı<br />';
                }
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;UNIX file() komutu mevcut değil<br />';
            }
        } else {
            $this->log .= '- UNIX file() komutu devre dışı bırakıldı<br />';
        }
    }

    // mime_magic ile MIME türünü kontrol eder
    if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === false) {
        if ($this->mime_magic) {
            $this->log .= '- mime.magic dosyası (mime_content_type()) ile MIME türü kontrol ediliyor<br />';
            if ($this->function_enabled('mime_content_type')) {
                $this->file_src_mime = mime_content_type($this->file_src_pathname);
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME türü mime_content_type() tarafından ' . $this->file_src_mime . ' olarak tespit edildi<br />';
                if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
                    $this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
                    $this->log .= '-&nbsp;MIME ' . $this->file_src_mime . ' olarak doğrulandı<br />';
                } else {
                    $this->file_src_mime = null;
                }
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;mime_content_type() mevcut değil<br />';
            }
        } else {
            $this->log .= '- mime.magic dosyası (mime_content_type()) devre dışı bırakıldı<br />';
        }
    }
			
// getimagesize() ile MIME türünü kontrol eder
if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === false) {
    if ($this->mime_getimagesize) {
        $this->log .= '- getimagesize() ile MIME türü kontrol ediliyor<br />';
        $info = getimagesize($this->file_src_pathname);
        if (is_array($info) && array_key_exists('mime', $info)) {
            $this->file_src_mime = trim($info['mime']);
            if (empty($this->file_src_mime)) {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME boş, türden tahmin ediliyor<br />';
                $mime = (is_array($info) && array_key_exists(2, $info) ? $info[2] : null); // 1 = GIF, 2 = JPG, 3 = PNG
                $this->file_src_mime = ($mime==IMAGETYPE_GIF  ? 'image/gif' :
                                       ($mime==IMAGETYPE_JPEG ? 'image/jpeg' :
                                       ($mime==IMAGETYPE_PNG  ? 'image/png' :
                                       ($mime==IMAGETYPE_WEBP  ? 'image/webp' :
                                       ($mime==IMAGETYPE_BMP  ? 'image/bmp' : null)))));
            }
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME türü PHP getimagesize() işlevi tarafından ' . $this->file_src_mime . ' olarak tespit edildi<br />';
            if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
                $this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
                $this->log .= '-&nbsp;MIME ' . $this->file_src_mime . ' olarak doğrulandı<br />';
            } else {
                $this->file_src_mime = null;
            }
        } else {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;getimagesize() başarısız oldu<br />';
        }
    } else {
        $this->log .= '- getimagesize() devre dışı bırakıldı<br />';
    }
}

// tarayıcıdan (veya Flash'tan) gelen MIME varsayılanı
if (!empty($mime_from_browser) && !$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime)) {
    $this->file_src_mime = $mime_from_browser;
    $this->log .= '- MIME türü tarayıcı tarafından ' . $this->file_src_mime . ' olarak tespit edildi<br />';
    if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
        $this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
        $this->log .= '-&nbsp;MIME ' . $this->file_src_mime . ' olarak doğrulandı<br />';
    } else {
        $this->file_src_mime = null;
    }
}

// Flash ile yükleme yapıyorsak biraz sihir yapmamız gerekiyor
if ($this->file_src_mime == 'application/octet-stream' || !$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === false) {
    if ($this->file_src_mime == 'application/octet-stream') $this->log .= '- Flash MIME türünü application/octet-stream olarak yeniden yazabilir<br />';
    $this->log .= '- dosya uzantısından MIME türünü tahmin etmeye çalışılıyor (' . $this->file_src_name_ext . '): ';
    if (array_key_exists($this->file_src_name_ext, $this->mime_types)) $this->file_src_mime = $this->mime_types[$this->file_src_name_ext];
    if ($this->file_src_mime == 'application/octet-stream') {
        $this->log .= 'bilinen bir şey gibi görünmüyor<br />';
    } else {
        $this->log .= 'MIME türü ' . $this->file_src_mime . ' olarak ayarlandı<br />';
    }
}

if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === false) {
    $this->log .= '- MIME türü tespit edilemedi! (' . (string) $this->file_src_mime . ')<br />';
}

// dosyanın bir görüntü olup olmadığını belirler
if ($this->file_src_mime && is_string($this->file_src_mime) && !empty($this->file_src_mime)) {
    if (array_key_exists($this->file_src_mime, $this->image_supported)) {
        $this->file_is_image = true;
        $this->image_src_type = $this->image_supported[$this->file_src_mime];
        $this->log .= '- dosya bir görüntüdür ve türü GD tarafından desteklenir<br />';
    } else if (strpos($this->file_src_mime, 'image/') !== FALSE && sizeof($this->image_supported) == 0) {
        $this->log .= '- dosya bir görüntü olabilir, ancak türü desteklenmiyor; GD yüklü mü?<br />';
    }
}

// dosya bir görüntü ise, bazı kullanışlı verileri toplarız
if ($this->file_is_image) {
    if ($h = fopen($this->file_src_pathname, 'r')) {
        fclose($h);
        $info = getimagesize($this->file_src_pathname);
        if (is_array($info)) {
            $this->image_src_x    = $info[0];
            $this->image_src_y    = $info[1];
            $this->image_dst_x    = $this->image_src_x;
            $this->image_dst_y    = $this->image_src_y;
            $this->image_src_pixels = $this->image_src_x * $this->image_src_y;
            $this->image_src_bits = array_key_exists('bits', $info) ? $info['bits'] : null;
        } else {
            $this->file_is_image = false;
            $this->uploaded = false;
            $this->log .= '- görüntü bilgileri alınamıyor, görüntü değiştirilmiş olabilir<br />';
            $this->error = $this->translate('source_invalid');
        }
    } else {
        $this->log .= '- kaynak dosya doğrudan okunamıyor. open_basedir kısıtlaması var mı?<br />';
    }
}

$this->log .= '<b>kaynak değişkenler</b><br />';
$this->log .= '- process() çağrılmadan önce tüm bunları kullanabilirsiniz<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_name         : ' . $this->file_src_name . '<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_name_body    : ' . $this->file_src_name_body . '<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_name_ext     : ' . $this->file_src_name_ext . '<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_pathname     : ' . $this->file_src_pathname . '<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_mime         : ' . $this->file_src_mime . '<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_size         : ' . $this->file_src_size . ' (max= ' . $this->file_max_size . ')<br />';
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_error        : ' . $this->file_src_error . '<br />';

if ($this->file_is_image) {
    $this->log .= '- kaynak dosya bir görüntüdür<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_x           : ' . $this->image_src_x . '<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_y           : ' . $this->image_src_y . '<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_pixels      : ' . $this->image_src_pixels . '<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_type        : ' . $this->image_src_type . '<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_bits        : ' . $this->image_src_bits . '<br />';
}
}

/**
 * GD sürümünü döndürür
 *
 * @access public
 * @param  boolean  $full İsteğe bağlı tam sürüm bayrağı
 * @return float GD sürümü
 */
function gdversion($full = false) {
    static $gd_version = null;
    static $gd_full_version = null;
    if ($gd_version === null) {
        if ($this->function_enabled('gd_info')) {
            $gd = gd_info();
            $gd = $gd["GD Version"];
            $regex = "/([\d\.]+)/i";
        } else {
            ob_start();
            phpinfo(8);
            $gd = ob_get_contents();
            ob_end_clean();
            $regex = "/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i";
        }
        if (preg_match($regex, $gd, $m)) {
            $gd_full_version = (string) $m[1];
            $gd_version = (float) $m[1];
        } else {
            $gd_full_version = 'none';
            $gd_version = 0;
        }
    }
    if ($full) {
        return $gd_full_version;
    } else {
        return $gd_version;
    }
}

/**
 * Bir işlevin kullanılabilir olup olmadığını kontrol eder
 *
 * @access private
 * @param  string  $func İşlev adı
 * @return boolean Başarı
 */
function function_enabled($func) {
    // devre dışı bırakılan işlevlerin listesini önbelleğe alır
    static $disabled = null;
    if ($disabled === null) $disabled = array_map('trim', array_map('strtolower', explode(',', ini_get('disable_functions'))));
    // suhosin tarafından kara listeye alınan işlevlerin listesini önbelleğe alır
    static $blacklist = null;
    if ($blacklist === null) $blacklist = extension_loaded('suhosin') ? array_map('trim', array_map('strtolower', explode(',', ini_get('  suhosin.executor.func.blacklist')))) : array();
    // işlevin gerçekten etkin olup olmadığını kontrol eder
    return (function_exists($func) && !in_array($func, $disabled) && !in_array($func, $blacklist));
}

/**
 * Dizileri özyinelemeli olarak oluşturur
 *
 * @access private
 * @param  string  $path Oluşturulacak yol
 * @param  integer $mode İsteğe bağlı izinler
 * @return boolean Başarı
 */
function rmkdir($path, $mode = 0755) {
    return is_dir($path) || ( $this->rmkdir(dirname($path), $mode) && $this->_mkdir($path, $mode) );
}

/**
 * Dizin oluşturur
 *
 * @access private
 * @param  string  $path Oluşturulacak yol
 * @param  integer $mode İsteğe bağlı izinler
 * @return boolean Başarı
 */
function _mkdir($path, $mode = 0755) {
    $old = umask(0);
    $res = @mkdir($path, $mode);
    umask($old);
    return $res;
}

/**
 * Hata mesajlarını çevirir
 *
 * @access private
 * @param  string  $str    Çevrilecek mesaj
 * @param  array   $tokens İsteğe bağlı belirteç değerleri
 * @return string Çevrilen dize
 */
function translate($str, $tokens = array()) {
    if (array_key_exists($str, $this->translation)) $str = $this->translation[$str];
    if (is_array($tokens) && sizeof($tokens) > 0)   $str = vsprintf($str, $tokens);
    return $str;
}

/**
 * Geçici dizini döndürür
 *
 * @access private
 * @return string Geçici dizin dizesi
 */
function temp_dir() {
    $dir = '';
    if ($this->function_enabled('sys_get_temp_dir')) $dir = sys_get_temp_dir();
    if (!$dir && $tmp=getenv('TMP'))    $dir = $tmp;
    if (!$dir && $tmp=getenv('TEMP'))   $dir = $tmp;
    if (!$dir && $tmp=getenv('TMPDIR')) $dir = $tmp;
    if (!$dir) {
        $tmp = tempnam(__FILE__,'');
        if (file_exists($tmp)) {
            unlink($tmp);
            $dir = dirname($tmp);
        }
    }
    if (!$dir) return '';
    $slash = (strtolower(substr(PHP_OS, 0, 3)) === 'win' ? '\\' : '/');
    if (substr($dir, -1) != $slash) $dir = $dir . $slash;
    return $dir;
}

/**
 * Bir dosya adını temizler
 *
 * @access private
 * @param  string  $filename Dosya adı
 * @return string Temizlenmiş dosya adı
 */
function sanitize($filename) {
    // HTML etiketlerini kaldırır
    $filename = strip_tags($filename);
    // kesmeyen boşlukları kaldırır
    $filename = preg_replace("#\x{00a0}#siu", ' ', $filename);
    // yasa dışı dosya sistemi karakterlerini kaldırır
    $filename = str_replace(array_map('chr', range(0, 31)), '', $filename);
    // dosya adları için tehlikeli karakterleri kaldırır
    $chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "’", "%20",
                   "+", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", "^", chr(0));
    $filename = str_replace($chars, '-', $filename);
    // satır/kutu/geri dönüş karakterlerini kaldırır
    $filename = preg_replace('/[\r\n\t -]+/', '-', $filename);
    // bazı özel harfleri dönüştürür
    $convert = array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss',
                     'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u');
    $filename = strtr($filename, $convert);
    // yabancı aksanları HTML varlıklarına dönüştürerek kaldırır ve ardından kodu kaldırır
    $filename = html_entity_decode( $filename, ENT_QUOTES, "utf-8" );
    $filename = htmlentities($filename, ENT_QUOTES, "utf-8");
    $filename = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $filename);
    // temizler ve tekrarları kaldırır
    $filename = preg_replace('/_+/', '_', $filename);
    $filename = preg_replace(array('/ +/', '/-+/'), '-', $filename);
    $filename = preg_replace(array('/-*\.-*/', '/\.{2,}/'), '.', $filename);
    // 255 karaktere keser
    $length = 255 - strlen($this->file_dst_name_ext) + 1;
    $filename = extension_loaded('mbstring') ? mb_strcut($filename, 0, $length, mb_detect_encoding($filename)) : substr($filename, 0, $length);
    // başlangıç ve bitişteki kötü karakterleri kaldırır
    $filename = trim($filename, '.-_');
    return $filename;
}

/**
 * Renkleri çözer
 *
 * @access private
 * @param  string  $color  Renk dizesi
 * @return array RGB renkleri
 */
function getcolors($color) {
    $color = str_replace('#', '', $color);
    if (strlen($color) == 3) $color = str_repeat(substr($color, 0, 1), 2) . str_repeat(substr($color, 1, 1), 2) . str_repeat(substr($color, 2, 1), 2);
    $r = sscanf($color, "%2x%2x%2x");
    $red   = (is_array($r) && array_key_exists(0, $r) && is_numeric($r[0]) ? $r[0] : 0);
    $green = (is_array($r) && array_key_exists(1, $r) && is_numeric($r[1]) ? $r[1] : 0);
    $blue  = (is_array($r) && array_key_exists(2, $r) && is_numeric($r[2]) ? $r[2] : 0);
    return array($red, $green, $blue);
}

/**
 * Boyutları çözer
 *
 * @access private
 * @param  string  $size  Bayt cinsinden boyut veya kısayol bayt seçenekleri
 * @return integer Bayt cinsinden boyut
 */
	 
function getsize($size) {
    if ($size === null) return null;
    $last = is_string($size) ? strtolower(substr($size, -1)) : null;
    $size = (int) $size;
    switch($last) {
        case 'g':
            $size *= 1024;
        case 'm':
            $size *= 1024;
        case 'k':
            $size *= 1024;
    }
    return $size;
}

/**
 * Offsets'i çözer
 *
 * @access private
 * @param  misc    $offsets  Offsets, as an integer, a string or an array
 * @param  integer $x        Referans resim genişliği
 * @param  integer $y        Referans resim yüksekliği
 * @param  boolean $round    Döndürmeden önce offsetleri yuvarla
 * @param  boolean $negative Negatif offsetlerin döndürülmesine izin ver
 * @return array Dört offset (TRBL) dizisi
 */
function getoffsets($offsets, $x, $y, $round = true, $negative = true) {
    if (!is_array($offsets)) $offsets = explode(' ', $offsets);
    if (sizeof($offsets) == 4) {
         $ct = $offsets[0]; $cr = $offsets[1]; $cb = $offsets[2]; $cl = $offsets[3];
    } else if (sizeof($offsets) == 2) {
        $ct = $offsets[0]; $cr = $offsets[1]; $cb = $offsets[0]; $cl = $offsets[1];
    } else {
        $ct = $offsets[0]; $cr = $offsets[0]; $cb = $offsets[0]; $cl = $offsets[0];
    }
    if (strpos($ct, '%')>0) $ct = $y * (str_replace('%','',$ct) / 100);
    if (strpos($cr, '%')>0) $cr = $x * (str_replace('%','',$cr) / 100);
    if (strpos($cb, '%')>0) $cb = $y * (str_replace('%','',$cb) / 100);
    if (strpos($cl, '%')>0) $cl = $x * (str_replace('%','',$cl) / 100);
    if (strpos($ct, 'px')>0) $ct = str_replace('px','',$ct);
    if (strpos($cr, 'px')>0) $cr = str_replace('px','',$cr);
    if (strpos($cb, 'px')>0) $cb = str_replace('px','',$cb);
    if (strpos($cl, 'px')>0) $cl = str_replace('px','',$cl);
    $ct = (int) $ct; $cr = (int) $cr; $cb = (int) $cb; $cl = (int) $cl;
    if ($round) {
        $ct = round($ct);
        $cr = round($cr);
        $cb = round($cb);
        $cl = round($cl);
    }
    if (!$negative) {
        if ($ct < 0) $ct = 0;
        if ($cr < 0) $cr = 0;
        if ($cb < 0) $cb = 0;
        if ($cl < 0) $cl = 0;
    }
    return array($ct, $cr, $cb, $cl);
}

/**
 * Bir kap görüntüsü oluşturur
 *
 * @access private
 * @param  integer  $x    Genişlik
 * @param  integer  $y    Yükseklik
 * @param  boolean  $fill Arka plan rengini çizmek veya çizmemek için isteğe bağlı bayrak
 * @param  boolean  $trsp Arka planın şeffaf olmasını ayarlamak için isteğe bağlı bayrak
 * @return resource Kap görüntüsü
 */
function imagecreatenew($x, $y, $fill = true, $trsp = false) {
    $x = (int) $x; $y = (int) $y;
    if ($x < 1) $x = 1; if ($y < 1) $y = 1;
    if ($this->gdversion() >= 2 && !$this->image_is_palette) {
        // gerçek renkli bir görüntü oluştur
        $dst_im = imagecreatetruecolor($x, $y);
        // bu PNG ve WEBP'de şeffaflığı korur, gerçek renkte
        if (empty($this->image_background_color) || $trsp) {
            imagealphablending($dst_im, false );
            imagefilledrectangle($dst_im, 0, 0, $x, $y, imagecolorallocatealpha($dst_im, 0, 0, 0, 127));
        }
    } else {
        // bir palet görüntüsü oluşturur
        $dst_im = imagecreate($x, $y);
        // orijinal görüntüde şeffaflık varsa, palet görüntüleri için şeffaflığı korur
        if (($fill && $this->image_is_transparent && empty($this->image_background_color)) || $trsp) {
            imagefilledrectangle($dst_im, 0, 0, $x, $y, $this->image_transparent_color);
            imagecolortransparent($dst_im, $this->image_transparent_color);
        }
    }
    // herhangi bir arka plan rengi ayarlanmışsa doldurur
    if ($fill && !empty($this->image_background_color) && !$trsp) {
        list($red, $green, $blue) = $this->getcolors($this->image_background_color);
        $background_color = imagecolorallocate($dst_im, $red, $green, $blue);
        imagefilledrectangle($dst_im, 0, 0, $x, $y, $background_color);
    }
    return $dst_im;
}

/**
 * Bir görüntüyü kaptan hedef görüntüye aktarır
 *
 * @access private
 * @param  resource $src_im Kap görüntüsü
 * @param  resource $dst_im Hedef görüntü
 * @return resource Hedef görüntü
 */
function imagetransfer($src_im, $dst_im) {
    $this->imageunset($dst_im);
    $dst_im = & $src_im;
    return $dst_im;
}

/**
 * GD kaynağını yok eder
 *
 * @access private
 * @param  resource $im Görüntü
 */
function imageunset($im) {
    if (is_resource($im)) {
        imagedestroy($im);
    } else if (is_object($im) && $im instanceOf \GdImage) {
        unset($im);
    }
}

/**
 * İki görüntüyü birleştirir
 *
 * Çıktı formatı PNG veya WEBP ise, alfa kanalını korumak için piksel piksel yaparız
 *
 * @access private
 * @param  resource $dst_img Hedef görüntü
 * @param  resource $src_img Kaplama görüntüsü
 * @param  int      $dst_x   Hedef noktanın x koordinatı
 * @param  int      $dst_y   Hedef noktanın y koordinatı
 * @param  int      $src_x   Kaynak noktanın x koordinatı
 * @param  int      $src_y   Kaynak noktanın y koordinatı
 * @param  int      $src_w   Kaynak genişliği
 * @param  int      $src_h   Kaynak yüksekliği
 * @param  int      $pct     İsteğe bağlı kaplama yüzdesi, 0 ile 100 arasında (varsayılan: 100)
 * @return resource Hedef görüntü
 */
function imagecopymergealpha(&$dst_im, &$src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct = 0) {
    $dst_x = (int) $dst_x;
    $dst_y = (int) $dst_y;
    $src_x = (int) $src_x;
    $src_y = (int) $src_y;
    $src_w = (int) $src_w;
    $src_h = (int) $src_h;
    $pct   = (int) $pct;
    $dst_w = imagesx($dst_im);
    $dst_h = imagesy($dst_im);

    for ($y = $src_y; $y < $src_h; $y++) {
        for ($x = $src_x; $x < $src_w; $x++) {

            if ($x + $dst_x >= 0 && $x + $dst_x < $dst_w && $x + $src_x >= 0 && $x + $src_x < $src_w
             && $y + $dst_y >= 0 && $y + $dst_y < $dst_h && $y + $src_y >= 0 && $y + $src_y < $src_h) {

                $dst_pixel = imagecolorsforindex($dst_im, imagecolorat($dst_im, $x + $dst_x, $y + $dst_y));
                $src_pixel = imagecolorsforindex($src_im, imagecolorat($src_im, $x + $src_x, $y + $src_y));

                $src_alpha = 1 - ($src_pixel['alpha'] / 127);
                $dst_alpha = 1 - ($dst_pixel['alpha'] / 127);
                $opacity = $src_alpha * $pct / 100;
                if ($dst_alpha >= $opacity) $alpha = $dst_alpha;
                if ($dst_alpha < $opacity)  $alpha = $opacity;
                if ($alpha > 1) $alpha = 1;

                if ($opacity > 0) {
                    $dst_red   = round(( ($dst_pixel['red']   * $dst_alpha * (1 - $opacity)) ) );
                    $dst_green = round(( ($dst_pixel['green'] * $dst_alpha * (1 - $opacity)) ) );
                    $dst_blue  = round(( ($dst_pixel['blue']  * $dst_alpha * (1 - $opacity)) ) );
                    $src_red   = round((($src_pixel['red']   * $opacity)) );
                    $src_green = round((($src_pixel['green'] * $opacity)) );
                    $src_blue  = round((($src_pixel['blue']  * $opacity)) );
                    $red   = round(($dst_red   + $src_red  ) / ($dst_alpha * (1 - $opacity) + $opacity));
                    $green = round(($dst_green + $src_green) / ($dst_alpha * (1 - $opacity) + $opacity));
                    $blue  = round(($dst_blue  + $src_blue ) / ($dst_alpha * (1 - $opacity) + $opacity));
                    if ($red   > 255) $red   = 255;
                    if ($green > 255) $green = 255;
                    if ($blue  > 255) $blue  = 255;
                    $alpha =  round((1 - $alpha) * 127);
                    $color = imagecolorallocatealpha($dst_im, $red, $green, $blue, $alpha);
                    imagesetpixel($dst_im, $x + $dst_x, $y + $dst_y, $color);
                }
            }
        }
    }
    return true;
}

/**
 * Dosyayı gerçekten yükler ve ayarlanan işleme sınıfı değişkenlerine göre üzerinde işlem yapar
 *
 * Bu işlev, yüklenen dosyayı verilen konuma kopyalar, sonunda üzerinde işlem yapar.
 * Tipik olarak, aynı dosya için {@link process} işlevini birkaç kez çağırabilirsiniz,
 * örneğin aynı dosyanın yeniden boyutlandırılmış bir görüntüsünü ve küçük resmini oluşturmak için.
 * Orijinal yüklenen dosya geçici konumunda kalır, böylece {@link process} işlevini birkaç kez kullanabilirsiniz.
 * Tüm {@link process} çağrılarınızı bitirdiğinizde, yüklenen dosyayı {@link clean} ile silebileceksiniz.
 *
 * Çağrı dosyasında ayarlanan işleme sınıfı değişkenlerine göre, dosya yeniden adlandırılabilir
 * ve eğer bir görüntü ise, yeniden boyutlandırılabilir veya dönüştürülebilir.
 *
 * İşleme tamamlandığında ve dosya yeni konumuna kopyalandığında,
 * işleme sınıfı değişkenleri varsayılan değerlerine sıfırlanacaktır.
 * Bu, yeni özellikler ayarlamanıza ve aynı yüklenen dosya üzerinde başka bir {@link process} gerçekleştirebilmenize olanak tanır
 *
 * İşlev null veya boş bir argümanla çağrılırsa, resmin içeriğini döndürecektir
 *
 * İşlem tamamlandığında, {@link processed} ayarlanacaktır (ve bir hata oluştuysa {@link error})
 *
 * @access public
 * @param  string $server_path Yüklenen dosyanın isteğe bağlı yol konumu, sonlandırma eğik çizgisi ile
 * @return string İsteğe bağlı resim içeriği
 */
function process($server_path = null) {
    $this->error        = '';
    $this->processed    = true;
    $return_mode        = false;
    $return_content     = null;

    // dst değişkenlerini temizle
    $this->file_dst_path        = '';
    $this->file_dst_pathname    = '';
    $this->file_dst_name        = '';
    $this->file_dst_name_body   = '';
    $this->file_dst_name_ext    = '';

    // bazı parametreleri temizle
    $this->file_max_size = $this->getsize($this->file_max_size);
    $this->jpeg_size = $this->getsize($this->jpeg_size);

    // bazı değişkenleri kopyala çünkü onları temiz tutmamız gerekiyor
    $file_src_name = $this->file_src_name;
    $file_src_name_body = $this->file_src_name_body;
    $file_src_name_ext = $this->file_src_name_ext;

    if (!$this->uploaded) {
        $this->error = $this->translate('file_not_uploaded');
        $this->processed = false;
    }

    if ($this->processed) {
        if (empty($server_path) || is_null($server_path)) {
            $this->log .= '<b>dosyayı işleyin ve içeriği döndürün</b><br />';
            $return_mode = true;
        } else {
            if(strtolower(substr(PHP_OS, 0, 3)) === 'win') {
                if (substr($server_path, -1, 1) != '\\') $server_path = $server_path . '\\';
            } else {
                if (substr($server_path, -1, 1) != '/') $server_path = $server_path . '/';
            }
            $this->log .= '<b>dosyayı işleyin ve '  . $server_path . ' konumuna kaydedin</b><br />';
        }
    }

    if ($this->processed) {
        // dosya maksimum boyutunu kontrol eder
        if ($this->file_src_size > $this->file_max_size) {
            $this->processed = false;
            $this->error = $this->translate('file_too_big') . ' : ' . $this->file_src_size . ' > ' . $this->file_max_size;
        } else {
            $this->log .= '- dosya boyutu OK<br />';
        }
    }

    if ($this->processed) {
        // bir uzantısı olmayan bir görüntümüz varsa, ayarlayın
        if ($this->file_force_extension && $this->file_is_image && !$this->file_src_name_ext) $file_src_name_ext = $this->image_src_type;
        // tehlikeli betikleri metin dosyalarına dönüştür
        if ($this->no_script) {
            // dosyanın uzantısı yoksa, MIME türünden tahmin etmeye çalışırız
            if ($this->file_force_extension && empty($file_src_name_ext)) {
                if ($key = array_search($this->file_src_mime, $this->mime_types)) {
                    $file_src_name_ext = $key;
                    $file_src_name = $file_src_name_body . '.' . $file_src_name_ext;
                    $this->log .= '- dosya ' . $file_src_name_body . '.' . $file_src_name_ext . ' olarak yeniden adlandırıldı!<br />';
                }
            }
            // dosya metin tabanlıysa veya tehlikeli bir uzantıya sahipse, .txt olarak yeniden adlandırırız
            if ((((substr($this->file_src_mime, 0, 5) == 'text/' && $this->file_src_mime != 'text/rtf') || strpos($this->file_src_mime, 'javascript') !== false)  && (substr($file_src_name, -4) != '.txt'))
                || preg_match('/\.(' . implode('|', $this->dangerous) . ')/i', $this->file_src_name)
                || $this->file_force_extension && empty($file_src_name_ext)) {
                $this->file_src_mime = 'text/plain';
                if ($this->file_src_name_ext) $file_src_name_body = $file_src_name_body . '.' . $this->file_src_name_ext;
                $file_src_name_ext = 'txt';
                $file_src_name = $file_src_name_body . '.' . $file_src_name_ext;
                $this->log .= '- betik ' . $file_src_name_body . '.' . $file_src_name_ext . ' olarak yeniden adlandırıldı!<br />';
            }
        }
			
if ($this->mime_check && empty($this->file_src_mime)) {
    $this->processed = false;
    $this->error = $this->translate('no_mime');
} else if ($this->mime_check && !empty($this->file_src_mime) && strpos($this->file_src_mime, '/') !== false) {
    list($m1, $m2) = explode('/', $this->file_src_mime);
    $allowed = false;
    // mime türünün veya dosya uzantısının izin verilip verilmediğini kontrol eder
    if (!is_array($this->allowed)) $this->allowed = array($this->allowed);
    foreach($this->allowed as $k => $v) {
        if (strpos($v, '/') == false) {
            if ($v == '*' || strtolower($v) == strtolower($file_src_name_ext)) {
                $allowed = true;
                break;
            }
        } else {
            list($v1, $v2) = explode('/', $v);
            if (($v1 == '*' && $v2 == '*') || ($v1 == $m1 && ($v2 == $m2 || $v2 == '*'))) {
                $allowed = true;
                break;
            }
        }
    }
    if (!$allowed) $this->log .= '- MIME türü ve/veya uzantısına izin verilmiyor!<br />';
    // mime türünün veya dosya uzantısının yasaklanıp yasaklanmadığını kontrol eder
    if (!is_array($this->forbidden)) $this->forbidden = array($this->forbidden);
    foreach($this->forbidden as $k => $v) {
        if (strpos($v, '/') == false) {
            if ($v == '*' || strtolower($v) == strtolower($file_src_name_ext)) {
                $allowed = false;
                $this->log .= '- uzantı ' . $v . ' yasaklanmış!<br />';
                break;
            }
        } else {
            list($v1, $v2) = explode('/', $v);
            if (($v1 == '*' && $v2 == '*') || ($v1 == $m1 && ($v2 == $m2 || $v2 == '*'))) {
                $allowed = false;
                $this->log .= '- MIME türü ' . $v . ' yasaklanmış!<br />';
                break;
            }
        }
    }
    if (!$allowed) {
        $this->processed = false;
        $this->error = $this->translate('incorrect_file');
    } else {
        $this->log .= '- dosya mime OK: ' . $this->file_src_mime . '<br />';
        $this->log .= '- dosya uzantısı OK: ' . $file_src_name_ext . '<br />';
    }
} else {
    $this->log .= '- dosya mime (kontrol edilmedi): ' . $this->file_src_mime . '<br />';
}

// dosya bir görüntü ise, boyutlarını kontrol edebiliriz
// bu kontroller open_basedir kısıtlamaları varsa mevcut değildir
if ($this->file_is_image) {
    if (is_numeric($this->image_src_x) && is_numeric($this->image_src_y)) {
        $ratio = $this->image_src_x / $this->image_src_y;
        if (!is_null($this->image_max_width) && $this->image_src_x > $this->image_max_width) {
            $this->processed = false;
            $this->error = $this->translate('image_too_wide');
        }
        if (!is_null($this->image_min_width) && $this->image_src_x < $this->image_min_width) {
            $this->processed = false;
            $this->error = $this->translate('image_too_narrow');
        }
        if (!is_null($this->image_max_height) && $this->image_src_y > $this->image_max_height) {
            $this->processed = false;
            $this->error = $this->translate('image_too_high');
        }
        if (!is_null($this->image_min_height) && $this->image_src_y < $this->image_min_height) {
            $this->processed = false;
            $this->error = $this->translate('image_too_short');
        }
        if (!is_null($this->image_max_ratio) && $ratio > $this->image_max_ratio) {
            $this->processed = false;
            $this->error = $this->translate('ratio_too_high');
        }
        if (!is_null($this->image_min_ratio) && $ratio < $this->image_min_ratio) {
            $this->processed = false;
            $this->error = $this->translate('ratio_too_low');
        }
        if (!is_null($this->image_max_pixels) && $this->image_src_pixels > $this->image_max_pixels) {
            $this->processed = false;
            $this->error = $this->translate('too_many_pixels');
        }
        if (!is_null($this->image_min_pixels) && $this->image_src_pixels < $this->image_min_pixels) {
            $this->processed = false;
            $this->error = $this->translate('not_enough_pixels');
        }
    } else {
        $this->log .= '- görüntü özellikleri yok, boyut kontrolleri uygulanamıyor: ' . $this->file_src_mime . '<br />';
    }
}

if ($this->processed) {
    $this->file_dst_path        = $server_path;

    // dst değişkenlerini src'den tekrar doldur
    $this->file_dst_name        = $file_src_name;
    $this->file_dst_name_body   = $file_src_name_body;
    $this->file_dst_name_ext    = $file_src_name_ext;
    if ($this->file_overwrite) $this->file_auto_rename = false;

    if ($this->image_convert && $this->file_is_image) { // bir görüntü olarak dönüştürüyorsak
        $this->file_dst_name_ext  = $this->image_convert;
        $this->log .= '- yeni dosya adı uzantısı: ' . $this->file_dst_name_ext . '<br />';
    }
    if (!is_null($this->file_new_name_body)) { // dosya gövdesini yeniden adlandır
        $this->file_dst_name_body = $this->file_new_name_body;
        $this->log .= '- yeni dosya adı gövdesi: ' . $this->file_new_name_body . '<br />';
    }
    if (!is_null($this->file_new_name_ext)) { // dosya uzantısını yeniden adlandır
        $this->file_dst_name_ext  = $this->file_new_name_ext;
        $this->log .= '- yeni dosya adı uzantısı: ' . $this->file_new_name_ext . '<br />';
    }
    if (!is_null($this->file_name_body_add)) { // ada bir dize ekle
        $this->file_dst_name_body  = $this->file_dst_name_body . $this->file_name_body_add;
        $this->log .= '- dosya adı gövdesi ekleme: ' . $this->file_name_body_add . '<br />';
    }
    if (!is_null($this->file_name_body_pre)) { // adı bir dize ile ön ekle
        $this->file_dst_name_body  = $this->file_name_body_pre . $this->file_dst_name_body;
        $this->log .= '- dosya adı gövdesi ön ekle: ' . $this->file_name_body_pre . '<br />';
    }
    if ($this->file_safe_name) { // adı güvenli hale getir
        $this->file_dst_name_body = $this->sanitize($this->file_dst_name_body);
        $this->log .= '- dosya adı güvenli format<br />';
    }

    $this->log .= '- hedef değişkenler<br />';
    if (empty($this->file_dst_path) || is_null($this->file_dst_path)) {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_path         : n/a<br />';
    } else {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_path         : ' . $this->file_dst_path . '<br />';
    }
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name_body    : ' . $this->file_dst_name_body . '<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name_ext     : ' . $this->file_dst_name_ext . '<br />';

    // hedef dosya adını ayarla
    $this->file_dst_name = $this->file_dst_name_body . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');

    if (!$return_mode) {
        if (!$this->file_auto_rename) {
            $this->log .= '- aynı dosya adı varsa auto_rename yok<br />';
            $this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
        } else {
            $this->log .= '- auto_rename kontrol ediliyor<br />';
            $this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
            $body = $this->file_dst_name_body;
            $ext = '';
            // uzantıyı değiştirdiysek, artışımızı önce ekleriz
            if ($file_src_name_ext != $this->file_src_name_ext) {
                if (substr($this->file_dst_name_body, -1 - strlen($this->file_src_name_ext)) == '.' . $this->file_src_name_ext) {
                    $body = substr($this->file_dst_name_body, 0, strlen($this->file_dst_name_body) - 1 - strlen($this->file_src_name_ext));
                    $ext = '.' . $this->file_src_name_ext;
                }
            }
            $cpt = 1;
            while (@file_exists($this->file_dst_pathname)) {
                $this->file_dst_name_body = $body . '_' . $cpt . $ext;
                $this->file_dst_name = $this->file_dst_name_body . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');
                $cpt++;
                $this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
            }
            if ($cpt>1) $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;auto_rename to ' . $this->file_dst_name . '<br />';
        }

        $this->log .= '- hedef dosya detayları<br />';
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name         : ' . $this->file_dst_name . '<br />';
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_pathname     : ' . $this->file_dst_pathname . '<br />';

        if ($this->file_overwrite) {
             $this->log .= '- üzerine yazma kontrolü yok<br />';
        } else {
            if (@file_exists($this->file_dst_pathname)) {
                $this->processed = false;
                $this->error = $this->translate('already_exists', array($this->file_dst_name));
            } else {
                $this->log .= '- ' . $this->file_dst_name . ' zaten mevcut değil<br />';
            }
        }
    }
}

if ($this->processed) {
    // yüklenen dosyayı zaten taşıdıysak, kaynak dosya olarak geçici kopyayı kullanırız ve mevcut olup olmadığını kontrol ederiz
    if (!empty($this->file_src_temp)) {
        $this->log .= '- ikinci işlem olduğu için orijinal dosya yerine geçici dosya kullanılır<br />';
        $this->file_src_pathname   = $this->file_src_temp;
        if (!file_exists($this->file_src_pathname)) {
            $this->processed = false;
            $this->error = $this->translate('temp_file_missing');
        }
    // geçici bir dosyamız yoksa ve yüklemeleri kontrol ediyorsak, is_uploaded_file() kullanırız
    } else if (!$this->no_upload_check) {
        if (!is_uploaded_file($this->file_src_pathname)) {
            $this->processed = false;
            $this->error = $this->translate('source_missing');
        }
    // aksi takdirde, yüklenen dosyaları kontrol etmiyorsak (örneğin yerel dosya), file_exists() kullanırız
    } else {
        if (!file_exists($this->file_src_pathname)) {
            $this->processed = false;
            $this->error = $this->translate('source_missing');
        }
    }

    // hedef dizinin mevcut olup olmadığını kontrol eder ve oluşturmaya çalışır
    if (!$return_mode) {
        if ($this->processed && !file_exists($this->file_dst_path)) {
            if ($this->dir_auto_create) {
                $this->log .= '- ' . $this->file_dst_path . ' mevcut değil. Oluşturma denemesi:';
                if (!$this->rmkdir($this->file_dst_path, $this->dir_chmod)) {
                    $this->log .= ' başarısız<br />';
                    $this->processed = false;
                    $this->error = $this->translate('destination_dir');
                } else {
                    $this->log .= ' başarı<br />';
                }
            } else {
                $this->error = $this->translate('destination_dir_missing');
            }
        }

        if ($this->processed && !is_dir($this->file_dst_path)) {
            $this->processed = false;
            $this->error = $this->translate('destination_path_not_dir');
        }

        // hedef dizinin yazılabilir olup olmadığını kontrol eder ve yazılabilir hale getirmeye çalışır
        $hash = md5($this->file_dst_name_body . rand(1, 1000));
        if ($this->processed && !($f = @fopen($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''), 'a+'))) {
            if ($this->dir_auto_chmod) {
                $this->log .= '- ' . $this->file_dst_path . ' yazılabilir değil. Chmod denemesi:';
                if (!@chmod($this->file_dst_path, $this->dir_chmod)) {
                    $this->log .= ' başarısız<br />';
                    $this->processed = false;
                    $this->error = $this->translate('destination_dir_write');
                } else {
                    $this->log .= ' başarı<br />';
                    if (!($f = @fopen($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''), 'a+'))) { // yeniden kontrol ederiz
                        $this->processed = false;
                        $this->error = $this->translate('destination_dir_write');
                    } else {
                        @fclose($f);
                    }
                }
            } else {
                $this->processed = false;
                $this->error = $this->translate('destination_path_write');
            }
        } else {
            if ($this->processed) @fclose($f);
            @unlink($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''));
        }

        // yüklenen bir dosyamız varsa ve bu ilk işleme ise ve dosyaya doğrudan erişemiyorsak (open_basedir kısıtlaması)
        // o zaman daha sonraki işlemlerde kaynak dosya olarak kullanılacak bir geçici dosya oluştururuz
        // üçüncü koşul, dosyaya *doğrudan* erişilemiyorsa kontrol etmek için oradadır (zaten is_uploaded_file() üzerinden olumlu sonuç vermiştir, bu yüzden vardır)
        if (!$this->no_upload_check && empty($this->file_src_temp) && !@file_exists($this->file_src_pathname)) {
            $this->log .= '- geçici bir dosya kullanma denemesi:';
            $hash = md5($this->file_dst_name_body . rand(1, 1000));
            if (move_uploaded_file($this->file_src_pathname, $this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''))) {
                $this->file_src_pathname = $this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');
                $this->file_src_temp = $this->file_src_pathname;
                $this->log .= ' dosya oluşturuldu<br />';
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;geçici dosya: ' . $this->file_src_temp . '<br />';
            } else {
                $this->log .= ' başarısız<br />';
                $this->processed = false;
                $this->error = $this->translate('temp_file');
            }
        }
    }
}

if ($this->processed) {

    // otomatik döndürme yapmamız gerekip gerekmediğini kontrol eder, EXIF verilerine göre görüntüyü otomatik olarak döndürür (yalnızca JPEG)
    $auto_flip = false;
    $auto_rotate = 0;
    if ($this->file_is_image && $this->image_auto_rotate && $this->image_src_type == 'jpg' && $this->function_enabled('exif_read_data')) {
        $exif = @exif_read_data($this->file_src_pathname);
        if (is_array($exif) && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            switch($orientation) {
              case 1:
                $this->log .= '- EXIF yönü = 1 : varsayılan<br />';
                break;
              case 2:
                $auto_flip = 'v';
                $this->log .= '- EXIF yönü = 2 : dikey flip<br />';
                break;
              case 3:
                $auto_rotate = 180;
                $this->log .= '- EXIF yönü = 3 : 180 sola döndür<br />';
                break;
              case 4:
                $auto_flip = 'h';
                $this->log .= '- EXIF yönü = 4 : yatay flip<br />';
                break;

case 5:
    $auto_flip = 'h';
    $auto_rotate = 90;
    $this->log .= '- EXIF orientation = 5 : horizontal flip + 90 rotate right<br />';
    break;
  case 6:
    $auto_rotate = 90;
    $this->log .= '- EXIF orientation = 6 : 90 rotate right<br />';
    break;
  case 7:
    $auto_flip = 'v';
    $auto_rotate = 90;
    $this->log .= '- EXIF orientation = 7 : vertical flip + 90 rotate right<br />';
    break;
  case 8:
    $auto_rotate = 270;
    $this->log .= '- EXIF orientation = 8 : 90 rotate left<br />';
    break;
  default:
    $this->log .= '- EXIF orientation = '.$orientation.' : unknown<br />';
    break;
}
} else {
    $this->log .= '- EXIF data is invalid or missing<br />';
}
} else {
if (!$this->image_auto_rotate) {
    $this->log .= '- auto-rotate deactivated<br />';
} else if (!$this->image_src_type == 'jpg') {
    $this->log .= '- auto-rotate applies only to JPEG images<br />';
} else if (!$this->function_enabled('exif_read_data')) {
    $this->log .= '- auto-rotate requires function exif_read_data to be enabled<br />';
}
}

// görüntü manipülasyonu yapacak mıyız?
$image_manipulation  = ($this->file_is_image && (
                        $this->image_resize
                     || $this->image_convert != ''
                     || is_numeric($this->image_brightness)
                     || is_numeric($this->image_contrast)
                     || is_numeric($this->image_opacity)
                     || is_numeric($this->image_threshold)
                     || !empty($this->image_tint_color)
                     || !empty($this->image_overlay_color)
                     || $this->image_pixelate
                     || $this->image_unsharp
                     || !empty($this->image_text)
                     || $this->image_greyscale
                     || $this->image_negative
                     || !empty($this->image_watermark)
                     || $auto_rotate || $auto_flip
                     || is_numeric($this->image_rotate)
                     || is_numeric($this->jpeg_size)
                     || !empty($this->image_flip)
                     || !empty($this->image_crop)
                     || !empty($this->image_precrop)
                     || !empty($this->image_border)
                     || !empty($this->image_border_transparent)
                     || $this->image_frame > 0
                     || $this->image_bevel > 0
                     || $this->image_reflection_height));

// dosyanın gerçekten bir görüntü olduğunu hızlıca kontrol ederiz
// bunu yalnızca şimdi yapabiliriz, çünkü open_basedir durumunda daha önce başarısız olurdu
if ($image_manipulation && !@getimagesize($this->file_src_pathname)) {
    $this->log .= '- dosya bir görüntü değil!<br />';
    $image_manipulation = false;
}

if ($image_manipulation) {

    // GD'nin çok fazla şikayet etmemesini sağla
    @ini_set("gd.jpeg_ignore_warning", 1);

    // kaynak dosyanın okunabilir olup olmadığını kontrol eder
    if ($this->processed && !($f = @fopen($this->file_src_pathname, 'r'))) {
        $this->processed = false;
        $this->error = $this->translate('source_not_readable');
    } else {
        @fclose($f);
    }

    // şimdi tüm görüntü manipülasyonlarını yaparız
    $this->log .= '- görüntü yeniden boyutlandırma veya dönüştürme istendi<br />';
    if ($this->gdversion()) {
        switch($this->image_src_type) {
            case 'jpg':
                if (!$this->function_enabled('imagecreatefromjpeg')) {
                    $this->processed = false;
                    $this->error = $this->translate('no_create_support', array('JPEG'));
                } else {
                    $image_src = @imagecreatefromjpeg($this->file_src_pathname);
                    if (!$image_src) {
                        $this->processed = false;
                        $this->error = $this->translate('create_error', array('JPEG'));
                    } else {
                        $this->log .= '- kaynak görüntü JPEG<br />';
                    }
                }
                break;
            case 'png':
                if (!$this->function_enabled('imagecreatefrompng')) {
                    $this->processed = false;
                    $this->error = $this->translate('no_create_support', array('PNG'));
                } else {
                    $image_src = @imagecreatefrompng($this->file_src_pathname);
                    if (!$image_src) {
                        $this->processed = false;
                        $this->error = $this->translate('create_error', array('PNG'));
                    } else {
                        $this->log .= '- kaynak görüntü PNG<br />';
                    }
                }
                break;
            case 'webp':
                if (!$this->function_enabled('imagecreatefromwebp')) {
                    $this->processed = false;
                    $this->error = $this->translate('no_create_support', array('WEBP'));
                } else {
                    $image_src = @imagecreatefromwebp($this->file_src_pathname);
                    if (!$image_src) {
                        $this->processed = false;
                        $this->error = $this->translate('create_error', array('WEBP'));
                    } else {
                        $this->log .= '- kaynak görüntü WEBP<br />';
                    }
                }
                break;
            case 'gif':
                if (!$this->function_enabled('imagecreatefromgif')) {
                    $this->processed = false;
                    $this->error = $this->translate('no_create_support', array('GIF'));
                } else {
                    $image_src = @imagecreatefromgif($this->file_src_pathname);
                    if (!$image_src) {
                        $this->processed = false;
                        $this->error = $this->translate('create_error', array('GIF'));
                    } else {
                        $this->log .= '- kaynak görüntü GIF<br />';
                    }
                }
                break;
            case 'bmp':
                if (!method_exists($this, 'imagecreatefrombmp')) {
                    $this->processed = false;
                    $this->error = $this->translate('no_create_support', array('BMP'));
                } else {
                    $image_src = @$this->imagecreatefrombmp($this->file_src_pathname);
                    if (!$image_src) {
                        $this->processed = false;
                        $this->error = $this->translate('create_error', array('BMP'));
                    } else {
                        $this->log .= '- kaynak görüntü BMP<br />';
                    }
                }
                break;
            default:
                $this->processed = false;
                $this->error = $this->translate('source_invalid');
        }
    } else {
        $this->processed = false;
        $this->error = $this->translate('gd_missing');
    }

    if ($this->processed && $image_src) {

        // image_convert ayarını yapmamız gerekiyorsa, henüz yapılmamışsa
        if (empty($this->image_convert)) {
            $this->log .= '- hedef dosya türü ' . $this->image_src_type . ' olarak ayarlanıyor<br />';
            $this->image_convert = $this->image_src_type;
        } else {
            $this->log .= '- istenen hedef dosya türü ' . $this->image_convert . '<br />';
        }

        if (!in_array($this->image_convert, $this->image_supported)) {
            $this->log .= '- hedef dosya türü ' . $this->image_convert . ' desteklenmiyor; jpg\'ye geçiliyor<br />';
            $this->image_convert = 'jpg';
        }

        // şeffaf bir formatta çıktı vermiyorsak, varsayılan rengin arka plan rengi olmasını sağlarız
        if ($this->image_convert != 'png' && $this->image_convert != 'webp' && $this->image_convert != 'gif' && !empty($this->image_default_color) && empty($this->image_background_color)) $this->image_background_color = $this->image_default_color;
        if (!empty($this->image_background_color)) $this->image_default_color = $this->image_background_color;
        if (empty($this->image_default_color)) $this->image_default_color = '#FFFFFF';

        $this->image_src_x = imagesx($image_src);
        $this->image_src_y = imagesy($image_src);
        $gd_version = $this->gdversion();
        $ratio_crop = null;

        if (!imageistruecolor($image_src)) {  // $this->image_src_type == 'gif'
            $this->log .= '- görüntü paletli olarak algılandı<br />';
            $this->image_is_palette = true;
            $this->image_transparent_color = imagecolortransparent($image_src);
            if ($this->image_transparent_color >= 0 && imagecolorstotal($image_src) > $this->image_transparent_color) {
                $this->image_is_transparent = true;
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;paletli görüntü şeffaf olarak algılandı<br />';
            }
            // görüntü bir palete sahipse (GIF), şeffaflığı koruyarak gerçek renge dönüştürürüz
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;paletli görüntüyü gerçek renge dönüştür<br />';
            $true_color = imagecreatetruecolor($this->image_src_x, $this->image_src_y);
            imagealphablending($true_color, false);
            imagesavealpha($true_color, true);
            for ($x = 0; $x < $this->image_src_x; $x++) {
                for ($y = 0; $y < $this->image_src_y; $y++) {
                    if ($this->image_transparent_color >= 0 && imagecolorat($image_src, $x, $y) == $this->image_transparent_color) {
                        imagesetpixel($true_color, $x, $y, 127 << 24);
                    } else {
                        $rgb = imagecolorsforindex($image_src, imagecolorat($image_src, $x, $y));
                        imagesetpixel($true_color, $x, $y, ($rgb['alpha'] << 24) | ($rgb['red'] << 16) | ($rgb['green'] << 8) | $rgb['blue']);
                    }
                }
            }
            $image_src = $this->imagetransfer($true_color, $image_src);
            imagealphablending($image_src, false);
            imagesavealpha($image_src, true);
            $this->image_is_palette = false;
        }

        $image_dst = & $image_src;

        // görüntüyü otomatik olarak döndür, EXIF verilerine göre (yalnızca JPEG)
        if ($gd_version >= 2 && !empty($auto_flip)) {
            $this->log .= '- görüntü otomatik döndürme: ' . ($auto_flip == 'v' ? 'dikey' : 'yatay') . '<br />';
            $tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);
            for ($x = 0; $x < $this->image_src_x; $x++) {
                for ($y = 0; $y < $this->image_src_y; $y++){
                    if (strpos($auto_flip, 'v') !== false) {
                        imagecopy($tmp, $image_dst, $this->image_src_x - $x - 1, $y, $x, $y, 1, 1);
                    } else {
                        imagecopy($tmp, $image_dst, $x, $this->image_src_y - $y - 1, $x, $y, 1, 1);
                    }
                }
            }
						
// tmp'yi image_dst'ye aktarırız
$image_dst = $this->imagetransfer($tmp, $image_dst);
}

// EXIF verilerine göre görüntüyü otomatik döndür, (yalnızca JPEG)
if ($gd_version >= 2 && is_numeric($auto_rotate)) {
    if (!in_array($auto_rotate, array(0, 90, 180, 270))) $auto_rotate = 0;
    if ($auto_rotate != 0) {
        if ($auto_rotate == 90 || $auto_rotate == 270) {
            $tmp = $this->imagecreatenew($this->image_src_y, $this->image_src_x);
        } else {
            $tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);
        }
        $this->log .= '- görüntüyü otomatik döndür: ' . $auto_rotate . '<br />';
        for ($x = 0; $x < $this->image_src_x; $x++) {
            for ($y = 0; $y < $this->image_src_y; $y++){
                if ($auto_rotate == 90) {
                    imagecopy($tmp, $image_dst, $y, $x, $x, $this->image_src_y - $y - 1, 1, 1);
                } else if ($auto_rotate == 180) {
                    imagecopy($tmp, $image_dst, $x, $y, $this->image_src_x - $x - 1, $this->image_src_y - $y - 1, 1, 1);
                } else if ($auto_rotate == 270) {
                    imagecopy($tmp, $image_dst, $y, $x, $this->image_src_x - $x - 1, $y, 1, 1);
                } else {
                    imagecopy($tmp, $image_dst, $x, $y, $x, $y, 1, 1);
                }
            }
        }
        if ($auto_rotate == 90 || $auto_rotate == 270) {
            $t = $this->image_src_y;
            $this->image_src_y = $this->image_src_x;
            $this->image_src_x = $t;
        }
        // tmp'yi image_dst'ye aktarırız
        $image_dst = $this->imagetransfer($tmp, $image_dst);
    }
}

// yeniden boyutlandırmadan önce görüntüyü ön kırpma
if ((!empty($this->image_precrop))) {
    list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_precrop, $this->image_src_x, $this->image_src_y, true, true);
    $this->log .= '- görüntüyü ön kırpma: ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . ' <br />';
    $this->image_src_x = $this->image_src_x - $cl - $cr;
    $this->image_src_y = $this->image_src_y - $ct - $cb;
    if ($this->image_src_x < 1) $this->image_src_x = 1;
    if ($this->image_src_y < 1) $this->image_src_y = 1;
    $tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);

    // görüntüyü alıcı görüntüye kopyalarız
    imagecopy($tmp, $image_dst, 0, 0, $cl, $ct, $this->image_src_x, $this->image_src_y);

    // negatif kenar boşluklarıyla kırpıyorsak, ekstra parçaların doğru renkte veya şeffaf olduğundan emin olmalıyız
    if ($ct < 0 || $cr < 0 || $cb < 0 || $cl < 0 ) {
        // mevcutsa arka plan rengini kullan
        if (!empty($this->image_background_color)) {
            list($red, $green, $blue) = $this->getcolors($this->image_background_color);
            $fill = imagecolorallocate($tmp, $red, $green, $blue);
        } else {
            $fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        }
        // olası negatif kenar boşluklarını doldurur
        if ($ct < 0) imagefilledrectangle($tmp, 0, 0, $this->image_src_x, -$ct, $fill);
        if ($cr < 0) imagefilledrectangle($tmp, $this->image_src_x + $cr, 0, $this->image_src_x, $this->image_src_y, $fill);
        if ($cb < 0) imagefilledrectangle($tmp, 0, $this->image_src_y + $cb, $this->image_src_x, $this->image_src_y, $fill);
        if ($cl < 0) imagefilledrectangle($tmp, 0, 0, -$cl, $this->image_src_y, $fill);
    }

    // tmp'yi image_dst'ye aktarırız
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// görüntüyü yeniden boyutlandır (ve image_src_x, image_src_y boyutlarını image_dst_x, image_dst_y'ye taşı)
if ($this->image_resize) {
    $this->log .= '- yeniden boyutlandırma...<br />';
    $this->image_dst_x = $this->image_x;
    $this->image_dst_y = $this->image_y;

    // yakında kullanılmayacak ayarlar için geriye dönük uyumluluk
    if ($this->image_ratio_no_zoom_in) {
        $this->image_ratio = true;
        $this->image_no_enlarging = true;
    } else if ($this->image_ratio_no_zoom_out) {
        $this->image_ratio = true;
        $this->image_no_shrinking = true;
    }

    // y'den hesaplanan x boyutuyla en boy oranını korur
    if ($this->image_ratio_x) {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;x boyutunu hesapla<br />';
        $this->image_dst_x = round(($this->image_src_x * $this->image_y) / $this->image_src_y);
        $this->image_dst_y = $this->image_y;

    // x'den hesaplanan y boyutuyla en boy oranını korur
    } else if ($this->image_ratio_y) {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;y boyutunu hesapla<br />';
        $this->image_dst_x = $this->image_x;
        $this->image_dst_y = round(($this->image_src_y * $this->image_x) / $this->image_src_x);

    // belirli bir piksel sayısına yaklaşık olarak x ve y hesaplayarak en boy oranını korur
    } else if (is_numeric($this->image_ratio_pixels)) {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;bir piksel sayısına uyması için x/y boyutunu hesapla<br />';
        $pixels = $this->image_src_y * $this->image_src_x;
        $diff = sqrt($this->image_ratio_pixels / $pixels);
        $this->image_dst_x = round($this->image_src_x * $diff);
        $this->image_dst_y = round($this->image_src_y * $diff);

    // x ve y boyutlarıyla, alanı doldurarak en boy oranını korur
    } else if ($this->image_ratio_crop) {
        if (!is_string($this->image_ratio_crop)) $this->image_ratio_crop = '';
        $this->image_ratio_crop = strtolower($this->image_ratio_crop);
        if (($this->image_src_x/$this->image_x) > ($this->image_src_y/$this->image_y)) {
            $this->image_dst_y = $this->image_y;
            $this->image_dst_x = intval($this->image_src_x*($this->image_y / $this->image_src_y));
            $ratio_crop = array();
            $ratio_crop['x'] = $this->image_dst_x - $this->image_x;
            if (strpos($this->image_ratio_crop, 'l') !== false) {
                $ratio_crop['l'] = 0;
                $ratio_crop['r'] = $ratio_crop['x'];
            } else if (strpos($this->image_ratio_crop, 'r') !== false) {
                $ratio_crop['l'] = $ratio_crop['x'];
                $ratio_crop['r'] = 0;
            } else {
                $ratio_crop['l'] = round($ratio_crop['x']/2);
                $ratio_crop['r'] = $ratio_crop['x'] - $ratio_crop['l'];
            }
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_crop_x         : ' . $ratio_crop['x'] . ' (' . $ratio_crop['l'] . ';' . $ratio_crop['r'] . ')<br />';
            if (is_null($this->image_crop)) $this->image_crop = array(0, 0, 0, 0);
        } else {
            $this->image_dst_x = $this->image_x;
            $this->image_dst_y = intval($this->image_src_y*($this->image_x / $this->image_src_x));
            $ratio_crop = array();
            $ratio_crop['y'] = $this->image_dst_y - $this->image_y;
            if (strpos($this->image_ratio_crop, 't') !== false) {
                $ratio_crop['t'] = 0;
                $ratio_crop['b'] = $ratio_crop['y'];
            } else if (strpos($this->image_ratio_crop, 'b') !== false) {
                $ratio_crop['t'] = $ratio_crop['y'];
                $ratio_crop['b'] = 0;
            } else {
                $ratio_crop['t'] = round($ratio_crop['y']/2);
                $ratio_crop['b'] = $ratio_crop['y'] - $ratio_crop['t'];
            }
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_crop_y         : ' . $ratio_crop['y'] . ' (' . $ratio_crop['t'] . ';' . $ratio_crop['b'] . ')<br />';
            if (is_null($this->image_crop)) $this->image_crop = array(0, 0, 0, 0);
        }

    // x ve y boyutlarıyla en boy oranını korur, görüntüyü alana sığdırır ve geri kalanını renklendirir
    } else if ($this->image_ratio_fill) {
        if (!is_string($this->image_ratio_fill)) $this->image_ratio_fill = '';
        $this->image_ratio_fill = strtolower($this->image_ratio_fill);
        if (($this->image_src_x/$this->image_x) < ($this->image_src_y/$this->image_y)) {
            $this->image_dst_y = $this->image_y;
            $this->image_dst_x = intval($this->image_src_x*($this->image_y / $this->image_src_y));
            $ratio_crop = array();
            $ratio_crop['x'] = $this->image_dst_x - $this->image_x;
            if (strpos($this->image_ratio_fill, 'l') !== false) {
                $ratio_crop['l'] = 0;
                $ratio_crop['r'] = $ratio_crop['x'];
            } else if (strpos($this->image_ratio_fill, 'r') !== false) {
                $ratio_crop['l'] = $ratio_crop['x'];
                $ratio_crop['r'] = 0;
            } else {
                $ratio_crop['l'] = round($ratio_crop['x']/2);
                $ratio_crop['r'] = $ratio_crop['x'] - $ratio_crop['l'];
            }
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_fill_x         : ' . $ratio_crop['x'] . ' (' . $ratio_crop['l'] . ';' . $ratio_crop['r'] . ')<br />';
            if (is_null($this->image_crop)) $this->image_crop = array(0, 0, 0, 0);
        } else {
            $this->image_dst_x = $this->image_x;
            $this->image_dst_y = intval($this->image_src_y*($this->image_x / $this->image_src_x));
            $ratio_crop = array();
            $ratio_crop['y'] = $this->image_dst_y - $this->image_y;
            if (strpos($this->image_ratio_fill, 't') !== false) {
                $ratio_crop['t'] = 0;
                $ratio_crop['b'] = $ratio_crop['y'];
            } else if (strpos($this->image_ratio_fill, 'b') !== false) {
                $ratio_crop['t'] = $ratio_crop['y'];
                $ratio_crop['b'] = 0;
            } else {
                $ratio_crop['t'] = round($ratio_crop['y']/2);
                $ratio_crop['b'] = $ratio_crop['y'] - $ratio_crop['t'];
            }
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_fill_y         : ' . $ratio_crop['y'] . ' (' . $ratio_crop['t'] . ';' . $ratio_crop['b'] . ')<br />';
            if (is_null($this->image_crop)) $this->image_crop = array(0, 0, 0, 0);
        }

    // x ve y boyutlarıyla en boy oranını korur
    } else if ($this->image_ratio) {
        if (($this->image_src_x/$this->image_x) > ($this->image_src_y/$this->image_y)) {
            $this->image_dst_x = $this->image_x;
            $this->image_dst_y = intval($this->image_src_y*($this->image_x / $this->image_src_x));
        } else {
            $this->image_dst_y = $this->image_y;
            $this->image_dst_x = intval($this->image_src_x*($this->image_y / $this->image_src_y));
        }

    // sağlanan kesin boyutlara yeniden boyutlandır
    } else {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;düz boyutları kullan<br />';
        $this->image_dst_x = $this->image_x;
        $this->image_dst_y = $this->image_y;
    }

    if ($this->image_dst_x < 1) $this->image_dst_x = 1;
    if ($this->image_dst_y < 1) $this->image_dst_y = 1;
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_x y        : ' . $this->image_src_x . ' x ' . $this->image_src_y . '<br />';
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_dst_x y        : ' . $this->image_dst_x . ' x ' . $this->image_dst_y . '<br />';

    // görüntüyü büyütmek istemiyorsak emin ol
    if ($this->image_no_enlarging && ($this->image_src_x < $this->image_dst_x || $this->image_src_y < $this->image_dst_y)) {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;yeniden boyutlandırmayı iptal et, çünkü görüntüyü büyütür!<br />';
        $this->image_dst_x = $this->image_src_x;
        $this->image_dst_y = $this->image_src_y;
        $ratio_crop = null;
    }

    // görüntüyü küçültmek istemiyorsak emin ol
    if ($this->image_no_shrinking && ($this->image_src_x > $this->image_dst_x || $this->image_src_y > $this->image_dst_y)) {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;yeniden boyutlandırmayı iptal et, çünkü görüntüyü küçültür!<br />';
        $this->image_dst_x = $this->image_src_x;
        $this->image_dst_y = $this->image_src_y;
        $ratio_crop = null;
    }

    // görüntüyü yeniden boyutlandır
    if ($this->image_dst_x != $this->image_src_x || $this->image_dst_y != $this->image_src_y) {
        $this->image_dst_x = (int) $this->image_dst_x;
        $this->image_dst_y = (int) $this->image_dst_y;
        $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);

        if ($gd_version >= 2) {
            $res = imagecopyresampled($tmp, $image_src, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_src_x, $this->image_src_y);
        } else {
            $res = imagecopyresized($tmp, $image_src, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_src_x, $this->image_src_y);
        }

        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;yeniden boyutlandırılmış görüntü nesnesi oluşturuldu<br />';
         // tmp'yi image_dst'ye aktarırız
        $image_dst = $this->imagetransfer($tmp, $image_dst);
    }

} else {
    $this->image_dst_x = $this->image_src_x;
    $this->image_dst_y = $this->image_src_y;
}
					
// görüntüyü kırp (ve ayrıca image_ratio_crop kullanılıyorsa kırpar)
if ((!empty($this->image_crop) || !is_null($ratio_crop))) {
    list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_crop, $this->image_dst_x, $this->image_dst_y, true, true);
    // image_ratio_crop kullanıyorsak kırpma ayarlarını yaparız
    if (!is_null($ratio_crop)) {
        if (array_key_exists('t', $ratio_crop)) $ct += $ratio_crop['t'];
        if (array_key_exists('r', $ratio_crop)) $cr += $ratio_crop['r'];
        if (array_key_exists('b', $ratio_crop)) $cb += $ratio_crop['b'];
        if (array_key_exists('l', $ratio_crop)) $cl += $ratio_crop['l'];
    }
    if ($ct != 0 || $cr != 0 || $cb != 0 || $cl != 0) {
        $this->log .= '- görüntüyü kırp: ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . ' <br />';
        $this->image_dst_x = $this->image_dst_x - $cl - $cr;
        $this->image_dst_y = $this->image_dst_y - $ct - $cb;
        if ($this->image_dst_x < 1) $this->image_dst_x = 1;
        if ($this->image_dst_y < 1) $this->image_dst_y = 1;
        $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);

        // görüntüyü alıcı görüntüye kopyalarız
        imagecopy($tmp, $image_dst, 0, 0, $cl, $ct, $this->image_dst_x, $this->image_dst_y);

        // negatif kenar boşluklarıyla kırpıyorsak, ekstra parçaların doğru renkte veya şeffaf olduğundan emin olmalıyız
        if ($ct < 0 || $cr < 0 || $cb < 0 || $cl < 0 ) {
            // mevcutsa arka plan rengini kullan
            if (!empty($this->image_background_color)) {
                list($red, $green, $blue) = $this->getcolors($this->image_background_color);
                $fill = imagecolorallocate($tmp, $red, $green, $blue);
            } else {
                $fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
            }
            // olası negatif kenar boşluklarını doldurur
            if ($ct < 0) imagefilledrectangle($tmp, 0, 0, $this->image_dst_x, -$ct-1, $fill);
            if ($cr < 0) imagefilledrectangle($tmp, $this->image_dst_x + $cr, 0, $this->image_dst_x, $this->image_dst_y, $fill);
            if ($cb < 0) imagefilledrectangle($tmp, 0, $this->image_dst_y + $cb, $this->image_dst_x, $this->image_dst_y, $fill);
            if ($cl < 0) imagefilledrectangle($tmp, 0, 0, -$cl-1, $this->image_dst_y, $fill);
        }

        // tmp'yi image_dst'ye aktarırız
        $image_dst = $this->imagetransfer($tmp, $image_dst);
    }
}

// görüntüyü çevir
if ($gd_version >= 2 && !empty($this->image_flip)) {
    $this->image_flip = strtolower($this->image_flip);
    $this->log .= '- görüntüyü çevir: ' . $this->image_flip . '<br />';
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
    for ($x = 0; $x < $this->image_dst_x; $x++) {
        for ($y = 0; $y < $this->image_dst_y; $y++){
            if (strpos($this->image_flip, 'v') !== false) {
                imagecopy($tmp, $image_dst, $this->image_dst_x - $x - 1, $y, $x, $y, 1, 1);
            } else {
                imagecopy($tmp, $image_dst, $x, $this->image_dst_y - $y - 1, $x, $y, 1, 1);
            }
        }
    }
    // tmp'yi image_dst'ye aktarırız
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// görüntüyü döndür
if ($gd_version >= 2 && is_numeric($this->image_rotate)) {
    if (!in_array($this->image_rotate, array(0, 90, 180, 270))) $this->image_rotate = 0;
    if ($this->image_rotate != 0) {
        if ($this->image_rotate == 90 || $this->image_rotate == 270) {
            $tmp = $this->imagecreatenew($this->image_dst_y, $this->image_dst_x);
        } else {
            $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
        }
        $this->log .= '- görüntüyü döndür: ' . $this->image_rotate . '<br />';
        for ($x = 0; $x < $this->image_dst_x; $x++) {
            for ($y = 0; $y < $this->image_dst_y; $y++){
                if ($this->image_rotate == 90) {
                    imagecopy($tmp, $image_dst, $y, $x, $x, $this->image_dst_y - $y - 1, 1, 1);
                } else if ($this->image_rotate == 180) {
                    imagecopy($tmp, $image_dst, $x, $y, $this->image_dst_x - $x - 1, $this->image_dst_y - $y - 1, 1, 1);
                } else if ($this->image_rotate == 270) {
                    imagecopy($tmp, $image_dst, $y, $x, $this->image_dst_x - $x - 1, $y, 1, 1);
                } else {
                    imagecopy($tmp, $image_dst, $x, $y, $x, $y, 1, 1);
                }
            }
        }
        if ($this->image_rotate == 90 || $this->image_rotate == 270) {
            $t = $this->image_dst_y;
            $this->image_dst_y = $this->image_dst_x;
            $this->image_dst_x = $t;
        }
        // tmp'yi image_dst'ye aktarırız
        $image_dst = $this->imagetransfer($tmp, $image_dst);
    }
}

// görüntüyü pikselleştir
if ((is_numeric($this->image_pixelate) && $this->image_pixelate > 0)) {
    $this->log .= '- görüntüyü pikselleştir (' . $this->image_pixelate . 'px)<br />';
    $filter = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
    if ($gd_version >= 2) {
        imagecopyresampled($filter, $image_dst, 0, 0, 0, 0, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate), $this->image_dst_x, $this->image_dst_y);
        imagecopyresampled($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate));
    } else {
        imagecopyresized($filter, $image_dst, 0, 0, 0, 0, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate), $this->image_dst_x, $this->image_dst_y);
        imagecopyresized($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate));
    }
    $this->imageunset($filter);
}

// keskinleştirme maskesi
if ($gd_version >= 2 && $this->image_unsharp && is_numeric($this->image_unsharp_amount) && is_numeric($this->image_unsharp_radius) && is_numeric($this->image_unsharp_threshold)) {
    // PHP için Unsharp Mask - sürüm 2.1.1
    // Torstein Hønsi tarafından geliştirilen Unsharp mask algoritması 2003-07.
    // İzin alınarak kullanılmıştır
    // Alfa şeffaflığı destekleyecek şekilde değiştirilmiştir
    if ($this->image_unsharp_amount > 500)    $this->image_unsharp_amount = 500;
    $this->image_unsharp_amount = $this->image_unsharp_amount * 0.016;
    if ($this->image_unsharp_radius > 50)    $this->image_unsharp_radius = 50;
    $this->image_unsharp_radius = $this->image_unsharp_radius * 2;
    if ($this->image_unsharp_threshold > 255)    $this->image_unsharp_threshold = 255;
    $this->image_unsharp_radius = abs(round($this->image_unsharp_radius));
    if ($this->image_unsharp_radius != 0) {
        $this->image_dst_x = imagesx($image_dst); $this->image_dst_y = imagesy($image_dst);
        $canvas = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, false, true);
        $blur = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, false, true);
        if ($this->function_enabled('imageconvolution')) { // PHP >= 5.1
            $matrix = array(array( 1, 2, 1 ), array( 2, 4, 2 ), array( 1, 2, 1 ));
            imagecopy($blur, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
            imageconvolution($blur, $matrix, 16, 0);
        } else {
            for ($i = 0; $i < $this->image_unsharp_radius; $i++) {
                imagecopy($blur, $image_dst, 0, 0, 1, 0, $this->image_dst_x - 1, $this->image_dst_y); // sol
                $this->imagecopymergealpha($blur, $image_dst, 1, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, 50); // sağ
                $this->imagecopymergealpha($blur, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, 50); // merkez
                imagecopy($canvas, $blur, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
                $this->imagecopymergealpha($blur, $canvas, 0, 0, 0, 1, $this->image_dst_x, $this->image_dst_y - 1, 33.33333 ); // yukarı
                $this->imagecopymergealpha($blur, $canvas, 0, 1, 0, 0, $this->image_dst_x, $this->image_dst_y, 25); // aşağı
            }
        }
        $p_new = array();
        if($this->image_unsharp_threshold>0) {
            for ($x = 0; $x < $this->image_dst_x-1; $x++) {
                for ($y = 0; $y < $this->image_dst_y; $y++) {
                    $p_orig = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                    $p_blur = imagecolorsforindex($blur, imagecolorat($blur, $x, $y));
                    $p_new['red'] = (abs($p_orig['red'] - $p_blur['red']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['red'] - $p_blur['red'])) + $p_orig['red'])) : $p_orig['red'];
                    $p_new['green'] = (abs($p_orig['green'] - $p_blur['green']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['green'] - $p_blur['green'])) + $p_orig['green'])) : $p_orig['green'];
                    $p_new['blue'] = (abs($p_orig['blue'] - $p_blur['blue']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['blue'] - $p_blur['blue'])) + $p_orig['blue'])) : $p_orig['blue'];
                    $p_new['alpha'] = max(-127, min(127, $p_orig['alpha']));
                    if (($p_orig['red'] != $p_new['red']) || ($p_orig['green'] != $p_new['green']) || ($p_orig['blue'] != $p_new['blue'])) {
                        $color = imagecolorallocatealpha($image_dst, (int) $p_new['red'], (int) $p_new['green'], (int) $p_new['blue'], (int) $p_new['alpha']);
                        imagesetpixel($image_dst, $x, $y, $color);
                    }
                }
            }
        } else {
            for ($x = 0; $x < $this->image_dst_x; $x++) {
                for ($y = 0; $y < $this->image_dst_y; $y++) {
                    $p_orig = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                    $p_blur = imagecolorsforindex($blur, imagecolorat($blur, $x, $y));
                    $p_new['red'] = ($this->image_unsharp_amount * ($p_orig['red'] - $p_blur['red'])) + $p_orig['red'];
                    if ($p_new['red']>255) { $p_new['red']=255; } elseif ($p_new['red']<0) { $p_new['red']=0; }
                    $p_new['green'] = ($this->image_unsharp_amount * ($p_orig['green'] - $p_blur['green'])) + $p_orig['green'];
                    if ($p_new['green']>255) { $p_new['green']=255; }  elseif ($p_new['green']<0) { $p_new['green']=0; }
                    $p_new['blue'] = ($this->image_unsharp_amount * ($p_orig['blue'] - $p_blur['blue'])) + $p_orig['blue'];
                    if ($p_new['blue']>255) { $p_new['blue']=255; } elseif ($p_new['blue']<0) { $p_new['blue']=0; }
                    $p_new['alpha'] = round(max(-127, min(127, $p_orig['alpha'])));
                    $color = imagecolorallocatealpha($image_dst, (int) $p_new['red'], (int) $p_new['green'], (int) $p_new['blue'], (int) $p_new['alpha']);
                    imagesetpixel($image_dst, $x, $y, $color);
                }
            }
        }
        $this->imageunset($canvas);
        $this->imageunset($blur);
    }
}

// renk kaplaması ekle
if ($gd_version >= 2 && (is_numeric($this->image_overlay_opacity) && $this->image_overlay_opacity > 0 && !empty($this->image_overlay_color))) {
    $this->log .= '- renk kaplaması uygula<br />';
    list($red, $green, $blue) = $this->getcolors($this->image_overlay_color);
    $filter = imagecreatetruecolor($this->image_dst_x, $this->image_dst_y);
    $color = imagecolorallocate($filter, $red, $green, $blue);
    imagefilledrectangle($filter, 0, 0, $this->image_dst_x, $this->image_dst_y, $color);
    $this->imagecopymergealpha($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_overlay_opacity);
    $this->imageunset($filter);
}

// parlaklık, kontrast ve renk tonu ekler, gri tonlamaya dönüştürür ve renkleri ters çevirir
if ($gd_version >= 2 && ($this->image_negative || $this->image_greyscale || is_numeric($this->image_threshold)|| is_numeric($this->image_brightness) || is_numeric($this->image_contrast) || !empty($this->image_tint_color))) {
    $this->log .= '- renk tonu, aydınlık, kontrast düzeltme, negatif, gri tonlama ve eşik uygula<br />';
    if (!empty($this->image_tint_color)) list($tint_red, $tint_green, $tint_blue) = $this->getcolors($this->image_tint_color);
    //imagealphablending($image_dst, true);
    for($y=0; $y < $this->image_dst_y; $y++) {
        for($x=0; $x < $this->image_dst_x; $x++) {
            if ($this->image_greyscale) {
                $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                $r = $g = $b = round((0.2125 * $pixel['red']) + (0.7154 * $pixel['green']) + (0.0721 * $pixel['blue']));
                $alpha = round(max(-127, min(127, $pixel['alpha'])));
                $color = imagecolorallocatealpha($image_dst, (int) $r, (int) $g, (int) $b, (int) $alpha);
                imagesetpixel($image_dst, $x, $y, $color);
                unset($color); unset($pixel);
            }
            if (is_numeric($this->image_threshold)) {
                $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                $c = (round($pixel['red'] + $pixel['green'] + $pixel['blue']) / 3) - 127;
                $r = $g = $b = ($c > $this->image_threshold ? 255 : 0);
                $alpha = round(max(-127, min(127, $pixel['alpha'])));
                $color = imagecolorallocatealpha($image_dst, (int) $r, (int) $g, (int) $b, (int) $alpha);
                imagesetpixel($image_dst, $x, $y, $color);
                unset($color); unset($pixel);
            }
            if (is_numeric($this->image_brightness)) {
                $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                $r = max(min(round($pixel['red'] + (($this->image_brightness * 2))), 255), 0);
                $g = max(min(round($pixel['green'] + (($this->image_brightness * 2))), 255), 0);
                $b = max(min(round($pixel['blue'] + (($this->image_brightness * 2))), 255), 0);
                $alpha = round(max(-127, min(127, $pixel['alpha'])));
                $color = imagecolorallocatealpha($image_dst, (int) $r, (int) $g, (int) $b, (int) $alpha);
                imagesetpixel($image_dst, $x, $y, $color);
                unset($color); unset($pixel);
            }
            if (is_numeric($this->image_contrast)) {
                $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                $r = max(min(round(($this->image_contrast + 128) * $pixel['red'] / 128), 255), 0);
                $g = max(min(round(($this->image_contrast + 128) * $pixel['green'] / 128), 255), 0);
                $b = max(min(round(($this->image_contrast + 128) * $pixel['blue'] / 128), 255), 0);
                $alpha = round(max(-127, min(127, $pixel['alpha'])));
                $color = imagecolorallocatealpha($image_dst, (int) $r, (int) $g, (int) $b, (int) $alpha);
                imagesetpixel($image_dst, $x, $y, $color);
                unset($color); unset($pixel);
            }
            if (!empty($this->image_tint_color)) {
                $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                $r = min(round($tint_red * $pixel['red'] / 169), 255);
                $g = min(round($tint_green * $pixel['green'] / 169), 255);
                $b = min(round($tint_blue * $pixel['blue'] / 169), 255);
                $alpha = round(max(-127, min(127, $pixel['alpha'])));
                $color = imagecolorallocatealpha($image_dst, (int) $r, (int) $g, (int) $b, (int) $alpha);
                imagesetpixel($image_dst, $x, $y, $color);
                unset($color); unset($pixel);
            }
            if (!empty($this->image_negative)) {
                $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                $r = round(255 - $pixel['red']);
                $g = round(255 - $pixel['green']);
                $b = round(255 - $pixel['blue']);
                $alpha = round(max(-127, min(127, $pixel['alpha'])));
                $color = imagecolorallocatealpha($image_dst, (int) $r, (int) $g, (int) $b, (int) $alpha);
                imagesetpixel($image_dst, $x, $y, $color);
                unset($color); unset($pixel);
            }
        }
    }
}

// kenarlık ekler
if ($gd_version >= 2 && !empty($this->image_border)) {
    list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_border, $this->image_dst_x, $this->image_dst_y, true, false);
    $this->log .= '- kenarlık ekle: ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . '<br />';
    $this->image_dst_x = $this->image_dst_x + $cl + $cr;
    $this->image_dst_y = $this->image_dst_y + $ct + $cb;
    if (!empty($this->image_border_color)) list($red, $green, $blue) = $this->getcolors($this->image_border_color);
    $opacity = (is_numeric($this->image_border_opacity) ? (int) (127 - $this->image_border_opacity / 100 * 127): 0);
    // şimdi kenarlık rengiyle doldurduğumuz bir görüntü oluşturuyoruz
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
    $background = imagecolorallocatealpha($tmp, $red, $green, $blue, $opacity);
    imagefilledrectangle($tmp, 0, 0, $this->image_dst_x, $this->image_dst_y, $background);
    // ardından kaynak görüntüyü yeni görüntüye kopyalarız, böylece yalnızca kenarlık gerçekten tutulur
    imagecopy($tmp, $image_dst, $cl, $ct, 0, 0, $this->image_dst_x - $cr - $cl, $this->image_dst_y - $cb - $ct);
    // tmp'yi image_dst'ye aktarırız
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// şeffaflığa doğru solan kenarlık ekler
if ($gd_version >= 2 && !empty($this->image_border_transparent)) {
    list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_border_transparent, $this->image_dst_x, $this->image_dst_y, true, false);
    $this->log .= '- şeffaf kenarlık ekle: ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . '<br />';
    // şimdi kenarlık rengiyle doldurduğumuz bir görüntü oluşturuyoruz
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
    // ardından kaynak görüntüyü kenarlıklar olmadan yeni görüntüye kopyalarız
    imagecopy($tmp, $image_dst, $cl, $ct, $cl, $ct, $this->image_dst_x - $cr - $cl, $this->image_dst_y - $cb - $ct);
    // şimdi üst kenarlığı ekliyoruz
    $opacity = 100;
    for ($y = $ct - 1; $y >= 0; $y--) {
        $il = (int) ($ct > 0 ? ($cl * ($y / $ct)) : 0);
        $ir = (int) ($ct > 0 ? ($cr * ($y / $ct)) : 0);
        for ($x = $il; $x < $this->image_dst_x - $ir; $x++) {
            $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
            $alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
            if ($alpha > 0) {
                if ($alpha > 1) $alpha = 1;
                $color = imagecolorallocatealpha($tmp, $pixel['red'] , $pixel['green'], $pixel['blue'],  round((1 - $alpha) * 127));
                imagesetpixel($tmp, $x, $y, $color);
            }
        }
        if ($opacity > 0) $opacity = $opacity - (100 / $ct);
    }
    // şimdi sağ kenarlığı ekliyoruz
    $opacity = 100;
    for ($x = $this->image_dst_x - $cr; $x < $this->image_dst_x; $x++) {
        $it = (int) ($cr > 0 ? ($ct * (($this->image_dst_x - $x - 1) / $cr)) : 0);
        $ib = (int) ($cr > 0 ? ($cb * (($this->image_dst_x - $x - 1) / $cr)) : 0);
        for ($y = $it; $y < $this->image_dst_y - $ib; $y++) {
            $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
            $alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
            if ($alpha > 0) {
                if ($alpha > 1) $alpha = 1;
                $color = imagecolorallocatealpha($tmp, $pixel['red'] , $pixel['green'], $pixel['blue'],  round((1 - $alpha) * 127));
                imagesetpixel($tmp, $x, $y, $color);
            }
        }
        if ($opacity > 0) $opacity = $opacity - (100 / $cr);
    }
    // şimdi alt kenarlığı ekliyoruz
    $opacity = 100;
    for ($y = $this->image_dst_y - $cb; $y < $this->image_dst_y; $y++) {
        $il = (int) ($cb > 0 ? ($cl * (($this->image_dst_y - $y - 1) / $cb)) : 0);
        $ir = (int) ($cb > 0 ? ($cr * (($this->image_dst_y - $y - 1) / $cb)) : 0);
        for ($x = $il; $x < $this->image_dst_x - $ir; $x++) {
            $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
            $alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
            if ($alpha > 0) {
                if ($alpha > 1) $alpha = 1;
                $color = imagecolorallocatealpha($tmp, $pixel['red'] , $pixel['green'], $pixel['blue'],  round((1 - $alpha) * 127));
                imagesetpixel($tmp, $x, $y, $color);
            }
        }
        if ($opacity > 0) $opacity = $opacity - (100 / $cb);
    }
    // şimdi sol kenarlığı ekliyoruz
    $opacity = 100;
    for ($x = $cl - 1; $x >= 0; $x--) {
        $it = (int) ($cl > 0 ? ($ct * ($x / $cl)) : 0);
        $ib = (int) ($cl > 0 ? ($cb * ($x / $cl)) : 0);
        for ($y = $it; $y < $this->image_dst_y - $ib; $y++) {
            $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
            $alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
            if ($alpha > 0) {
                if ($alpha > 1) $alpha = 1;
                $color = imagecolorallocatealpha($tmp, $pixel['red'] , $pixel['green'], $pixel['blue'],  round((1 - $alpha) * 127));
                imagesetpixel($tmp, $x, $y, $color);
            }
        }
        if ($opacity > 0) $opacity = $opacity - (100 / $cl);
    }
    // tmp'yi image_dst'ye aktarırız
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// çerçeve kenarlığı ekle
if ($gd_version >= 2 && is_numeric($this->image_frame)) {
    if (is_array($this->image_frame_colors)) {
        $vars = $this->image_frame_colors;
        $this->log .= '- çerçeve ekle: ' . implode(' ', $this->image_frame_colors) . '<br />';
    } else {
        $this->log .= '- çerçeve ekle: ' . $this->image_frame_colors . '<br />';
        $vars = explode(' ', $this->image_frame_colors);
    }
    $nb = sizeof($vars);
    $this->image_dst_x = $this->image_dst_x + ($nb * 2);
    $this->image_dst_y = $this->image_dst_y + ($nb * 2);
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
    imagecopy($tmp, $image_dst, $nb, $nb, 0, 0, $this->image_dst_x - ($nb * 2), $this->image_dst_y - ($nb * 2));
    $opacity = (is_numeric($this->image_frame_opacity) ? (int) (127 - $this->image_frame_opacity / 100 * 127): 0);
    for ($i=0; $i<$nb; list($red, $green, $blue) = $this->getcolors($vars[$i])) {
        $c = imagecolorallocatealpha($tmp, $red, $green, $blue, $opacity);
        if ($this->image_frame == 1) {
            imageline($tmp, $i, $i, $this->image_dst_x - $i -1, $i, $c);
            imageline($tmp, $this->image_dst_x - $i -1, $this->image_dst_y - $i -1, $this->image_dst_x - $i -1, $i, $c);
            imageline($tmp, $this->image_dst_x - $i -1, $this->image_dst_y - $i -1, $i, $this->image_dst_y - $i -1, $c);
            imageline($tmp, $i, $i, $i, $this->image_dst_y - $i -1, $c);
        } else {
            imageline($tmp, $i, $i, $this->image_dst_x - $i -1, $i, $c);
            imageline($tmp, $this->image_dst_x - $nb + $i, $this->image_dst_y - $nb + $i, $this->image_dst_x - $nb + $i, $nb - $i, $c);
            imageline($tmp, $this->image_dst_x - $nb + $i, $this->image_dst_y - $nb + $i, $nb - $i, $this->image_dst_y - $nb + $i, $c);
            imageline($tmp, $i, $i, $i, $this->image_dst_y - $i -1, $c);
        }
    }
    // tmp'yi image_dst'ye aktarırız
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// eğik kenarlık ekle
if ($gd_version >= 2 && $this->image_bevel > 0) {
    if (empty($this->image_bevel_color1)) $this->image_bevel_color1 = '#FFFFFF';
    if (empty($this->image_bevel_color2)) $this->image_bevel_color2 = '#000000';
    list($red1, $green1, $blue1) = $this->getcolors($this->image_bevel_color1);
    list($red2, $green2, $blue2) = $this->getcolors($this->image_bevel_color2);
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
    imagecopy($tmp, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
    imagealphablending($tmp, true);
    for ($i=0; $i<$this->image_bevel; $i++) {
        $alpha = round(($i / $this->image_bevel) * 127);
        $c1 = imagecolorallocatealpha($tmp, $red1, $green1, $blue1, $alpha);
        $c2 = imagecolorallocatealpha($tmp, $red2, $green2, $blue2, $alpha);
        imageline($tmp, $i, $i, $this->image_dst_x - $i -1, $i, $c1);
        imageline($tmp, $this->image_dst_x - $i -1, $this->image_dst_y - $i, $this->image_dst_x - $i -1, $i, $c2);
        imageline($tmp, $this->image_dst_x - $i -1, $this->image_dst_y - $i -1, $i, $this->image_dst_y - $i -1, $c2);
        imageline($tmp, $i, $i, $i, $this->image_dst_y - $i -1, $c1);
    }
    // tmp'yi image_dst'ye aktarırız
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// filigran görüntüsü ekle
if ($this->image_watermark!='' && file_exists($this->image_watermark)) {
    $this->log .= '- filigran ekle<br />';
    $this->image_watermark_position = strtolower((string) $this->image_watermark_position);
    $watermark_info = getimagesize($this->image_watermark);
    $watermark_type = (array_key_exists(2, $watermark_info) ? $watermark_info[2] : null); // 1 = GIF, 2 = JPG, 3 = PNG
    $watermark_checked = false;
    if ($watermark_type == IMAGETYPE_GIF) {
        if (!$this->function_enabled('imagecreatefromgif')) {
            $this->error = $this->translate('watermark_no_create_support', array('GIF'));
        } else {
            $filter = @imagecreatefromgif($this->image_watermark);
            if (!$filter) {
                $this->error = $this->translate('watermark_create_error', array('GIF'));
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;filigran kaynak görüntüsü GIF<br />';
                $watermark_checked = true;
            }
        }
    } else if ($watermark_type == IMAGETYPE_JPEG) {
        if (!$this->function_enabled('imagecreatefromjpeg')) {
            $this->error = $this->translate('watermark_no_create_support', array('JPEG'));
        } else {
            $filter = @imagecreatefromjpeg($this->image_watermark);
            if (!$filter) {
                $this->error = $this->translate('watermark_create_error', array('JPEG'));
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;filigran kaynak görüntüsü JPEG<br />';
                $watermark_checked = true;
            }
        }
    } else if ($watermark_type == IMAGETYPE_PNG) {
        if (!$this->function_enabled('imagecreatefrompng')) {
            $this->error = $this->translate('watermark_no_create_support', array('PNG'));
        } else {
            $filter = @imagecreatefrompng($this->image_watermark);
            if (!$filter) {
                $this->error = $this->translate('watermark_create_error', array('PNG'));
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;filigran kaynak görüntüsü PNG<br />';
                $watermark_checked = true;
            }
        }
    } else if ($watermark_type == IMAGETYPE_WEBP) {
        if (!$this->function_enabled('imagecreatefromwebp')) {
            $this->error = $this->translate('watermark_no_create_support', array('WEBP'));
        } else {
            $filter = @imagecreatefromwebp($this->image_watermark);
            if (!$filter) {
                $this->error = $this->translate('watermark_create_error', array('WEBP'));
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;filigran kaynak görüntüsü WEBP<br />';
                $watermark_checked = true;
            }
        }
    } else if ($watermark_type == IMAGETYPE_BMP) {
        if (!method_exists($this, 'imagecreatefrombmp')) {
            $this->error = $this->translate('watermark_no_create_support', array('BMP'));
        } else {
            $filter = @$this->imagecreatefrombmp($this->image_watermark);
            if (!$filter) {
                $this->error = $this->translate('watermark_create_error', array('BMP'));
            } else {
                $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;filigran kaynak görüntüsü BMP<br />';
                $watermark_checked = true;
            }
        }
    } else {
        $this->error = $this->translate('watermark_invalid');
    }
    if ($watermark_checked) {
        $watermark_dst_width  = $watermark_src_width  = imagesx($filter);
        $watermark_dst_height = $watermark_src_height = imagesy($filter);

        // filigran çok büyük/uzun ise, önce yeniden boyutlandır
        if ((!$this->image_watermark_no_zoom_out && ($watermark_dst_width > $this->image_dst_x || $watermark_dst_height > $this->image_dst_y))
         || (!$this->image_watermark_no_zoom_in && $watermark_dst_width < $this->image_dst_x && $watermark_dst_height < $this->image_dst_y)) {
            $canvas_width  = $this->image_dst_x - abs((int) $this->image_watermark_x);
            $canvas_height = $this->image_dst_y - abs((int) $this->image_watermark_y);
            if (($watermark_src_width/$canvas_width) > ($watermark_src_height/$canvas_height)) {
                $watermark_dst_width = $canvas_width;
                $watermark_dst_height = intval($watermark_src_height*($canvas_width / $watermark_src_width));
            } else {
                $watermark_dst_height = $canvas_height;
                $watermark_dst_width = intval($watermark_src_width*($canvas_height / $watermark_src_height));
            }
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;filigran yeniden boyutlandırıldı '.$watermark_src_width.'x'.$watermark_src_height.' ile '.$watermark_dst_width.'x'.$watermark_dst_height.'<br />';

        }
        // filigran pozisyonunu belirle
        $watermark_x = 0;
        $watermark_y = 0;
        if (is_numeric($this->image_watermark_x)) {
            if ($this->image_watermark_x < 0) {
                $watermark_x = $this->image_dst_x - $watermark_dst_width + $this->image_watermark_x;
            } else {
                $watermark_x = $this->image_watermark_x;
            }
        } else {
            if (strpos($this->image_watermark_position, 'r') !== false) {
                $watermark_x = $this->image_dst_x - $watermark_dst_width;
            } else if (strpos($this->image_watermark_position, 'l') !== false) {
                $watermark_x = 0;
            } else {
                $watermark_x = ($this->image_dst_x - $watermark_dst_width) / 2;
            }
        }
        if (is_numeric($this->image_watermark_y)) {
            if ($this->image_watermark_y < 0) {
                $watermark_y = $this->image_dst_y - $watermark_dst_height + $this->image_watermark_y;
            } else {
                $watermark_y = $this->image_watermark_y;
            }
        } else {
            if (strpos($this->image_watermark_position, 'b') !== false) {
                $watermark_y = $this->image_dst_y - $watermark_dst_height;
            } else if (strpos($this->image_watermark_position, 't') !== false) {
                $watermark_y = 0;
            } else {
                $watermark_y = ($this->image_dst_y - $watermark_dst_height) / 2;
            }
        }
        imagealphablending($image_dst, true);
        imagecopyresampled($image_dst, $filter, $watermark_x, $watermark_y, 0, 0, $watermark_dst_width, $watermark_dst_height, $watermark_src_width, $watermark_src_height);
    } else {
        $this->error = $this->translate('watermark_invalid');
    }
}

// metin ekle
if (!empty($this->image_text)) {
    $this->log .= '- metin ekle<br />';

    // insan tarafından okunabilir formatta boyutları hesapla
    $src_size       = $this->file_src_size / 1024;
    $src_size_mb    = number_format($src_size / 1024, 1, ".", " ");
    $src_size_kb    = number_format($src_size, 1, ".", " ");
    $src_size_human = ($src_size > 1024 ? $src_size_mb . " MB" : $src_size_kb . " kb");

    $this->image_text = str_replace(
        array('[src_name]',
              '[src_name_body]',
              '[src_name_ext]',
              '[src_pathname]',
              '[src_mime]',
              '[src_size]',
              '[src_size_kb]',
              '[src_size_mb]',
              '[src_size_human]',
              '[src_x]',
              '[src_y]',
              '[src_pixels]',
              '[src_type]',
              '[src_bits]',
              '[dst_path]',
              '[dst_name_body]',
              '[dst_name_ext]',
              '[dst_name]',
              '[dst_pathname]',
              '[dst_x]',
              '[dst_y]',
              '[date]',
              '[time]',
              '[host]',
              '[server]',
              '[ip]',
              '[gd_version]'),
        array($this->file_src_name,
              $this->file_src_name_body,
              $this->file_src_name_ext,
              $this->file_src_pathname,
              $this->file_src_mime,
              $this->file_src_size,
              $src_size_kb,
              $src_size_mb,
              $src_size_human,
              $this->image_src_x,
              $this->image_src_y,
              $this->image_src_pixels,
              $this->image_src_type,
              $this->image_src_bits,
              $this->file_dst_path,
              $this->file_dst_name_body,
              $this->file_dst_name_ext,
              $this->file_dst_name,
              $this->file_dst_pathname,
              $this->image_dst_x,
              $this->image_dst_y,
              date('Y-m-d'),
              date('H:i:s'),
              (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'n/a'),
              (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'n/a'),
              (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'n/a'),
              $this->gdversion(true)),
        $this->image_text);

    if (!is_numeric($this->image_text_padding)) $this->image_text_padding = 0;
    if (!is_numeric($this->image_text_line_spacing)) $this->image_text_line_spacing = 0;
    if (!is_numeric($this->image_text_padding_x)) $this->image_text_padding_x = $this->image_text_padding;
    if (!is_numeric($this->image_text_padding_y)) $this->image_text_padding_y = $this->image_text_padding;
    $this->image_text_position = strtolower((string) $this->image_text_position);
    $this->image_text_direction = strtolower((string) $this->image_text_direction);
    $this->image_text_alignment = strtolower((string) $this->image_text_alignment);

    $font_type = 'gd';

    // yazı tipi bir GDF yazı tipi yolu içeren bir dizeyse, bir yazı tipi yüklemek isteyebileceğimizi varsayarız
    if (!is_numeric($this->image_text_font) && strlen($this->image_text_font) > 4 && substr(strtolower($this->image_text_font), -4) == '.gdf') {
        if (strpos($this->image_text_font, '/') === false) $this->image_text_font = "./" . $this->image_text_font;
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;yazı tipi yüklemeyi dene ' . $this->image_text_font . '... ';
        if ($this->image_text_font = @imageloadfont($this->image_text_font)) {
            $this->log .=  'başarılı<br />';
        } else {
            $this->log .=  'hata<br />';
            $this->image_text_font = 5;
        }

    // yazı tipi bir TTF yazı tipi yolu içeren bir dizeyse, yazı tipi dosyasına erişip erişemeyeceğimizi kontrol ederiz
    } else if (!is_numeric($this->image_text_font) && strlen($this->image_text_font) > 4 && substr(strtolower($this->image_text_font), -4) == '.ttf') {
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;yazı tipi yüklemeyi dene ' . $this->image_text_font . '... ';
        if (strpos($this->image_text_font, '/') === false) $this->image_text_font = "./" . $this->image_text_font;
        if (file_exists($this->image_text_font) && is_readable($this->image_text_font)) {
            $this->log .=  'başarılı<br />';
            $font_type = 'tt';
        } else {
            $this->log .=  'hata<br />';
            $this->image_text_font = 5;
        }
    }

// GD yazı tiplerinin metin sınırlayıcı kutusunu al
if ($font_type == 'gd') {
    $text = explode("\n", $this->image_text);
    $char_width = imagefontwidth($this->image_text_font);
    $char_height = imagefontheight($this->image_text_font);
    $text_height = 0;
    $text_width = 0;
    $line_height = 0;
    $line_width = 0;
    foreach ($text as $k => $v) {
        if ($this->image_text_direction == 'v') {
            $h = ($char_width * strlen($v));
            if ($h > $text_height) $text_height = $h;
            $line_width = $char_height;
            $text_width += $line_width + ($k < (sizeof($text)-1) ? $this->image_text_line_spacing : 0);
        } else {
            $w = ($char_width * strlen($v));
            if ($w > $text_width) $text_width = $w;
            $line_height = $char_height;
            $text_height += $line_height + ($k < (sizeof($text)-1) ? $this->image_text_line_spacing : 0);
        }
    }
    $text_width  += (2 * $this->image_text_padding_x);
    $text_height += (2 * $this->image_text_padding_y);

// TrueType yazı tiplerinin metin sınırlayıcı kutusunu al
} else if ($font_type == 'tt') {
    $text = $this->image_text;
    if (!$this->image_text_angle) $this->image_text_angle = $this->image_text_direction == 'v' ? 90 : 0;
    $text_height = 0;
    $text_width = 0;
    $text_offset_x = 0;
    $text_offset_y = 0;
    $rect = imagettfbbox($this->image_text_size, $this->image_text_angle, $this->image_text_font, $text );
    if ($rect) {
        $minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
        $maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
        $minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
        $maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));
        $text_offset_x = abs($minX);
        $text_offset_y = abs($minY);
        $text_width = $maxX - $minX + (2 * $this->image_text_padding_x);
        $text_height = $maxY - $minY + (2 * $this->image_text_padding_y);
    }
}

// metin bloğunu konumlandır
$text_x = 0;
$text_y = 0;
if (is_numeric($this->image_text_x)) {
    if ($this->image_text_x < 0) {
        $text_x = $this->image_dst_x - $text_width + $this->image_text_x;
    } else {
        $text_x = $this->image_text_x;
    }
} else {
    if (strpos($this->image_text_position, 'r') !== false) {
        $text_x = $this->image_dst_x - $text_width;
    } else if (strpos($this->image_text_position, 'l') !== false) {
        $text_x = 0;
    } else {
        $text_x = ($this->image_dst_x - $text_width) / 2;
    }
}
if (is_numeric($this->image_text_y)) {
    if ($this->image_text_y < 0) {
        $text_y = $this->image_dst_y - $text_height + $this->image_text_y;
    } else {
        $text_y = $this->image_text_y;
    }
} else {
    if (strpos($this->image_text_position, 'b') !== false) {
        $text_y = $this->image_dst_y - $text_height;
    } else if (strpos($this->image_text_position, 't') !== false) {
        $text_y = 0;
    } else {
        $text_y = ($this->image_dst_y - $text_height) / 2;
    }
}

// arka plan ekle, belki şeffaf
if (!empty($this->image_text_background)) {
    list($red, $green, $blue) = $this->getcolors($this->image_text_background);
    if ($gd_version >= 2 && (is_numeric($this->image_text_background_opacity)) && $this->image_text_background_opacity >= 0 && $this->image_text_background_opacity <= 100) {
        $filter = imagecreatetruecolor($text_width, $text_height);
        $background_color = imagecolorallocate($filter, $red, $green, $blue);
        imagefilledrectangle($filter, 0, 0, $text_width, $text_height, $background_color);
        $this->imagecopymergealpha($image_dst, $filter, $text_x, $text_y, 0, 0, $text_width, $text_height, $this->image_text_background_opacity);
        $this->imageunset($filter);
    } else {
        $background_color = imagecolorallocate($image_dst ,$red, $green, $blue);
        imagefilledrectangle($image_dst, $text_x, $text_y, $text_x + $text_width, $text_y + $text_height, $background_color);
    }
}

$text_x += $this->image_text_padding_x;
$text_y += $this->image_text_padding_y;
$t_width = $text_width - (2 * $this->image_text_padding_x);
$t_height = $text_height - (2 * $this->image_text_padding_y);
list($red, $green, $blue) = $this->getcolors($this->image_text_color);

// metni ekle, belki şeffaf
if ($gd_version >= 2 && (is_numeric($this->image_text_opacity)) && $this->image_text_opacity >= 0 && $this->image_text_opacity <= 100) {
    if ($t_width < 0) $t_width = 0;
    if ($t_height < 0) $t_height = 0;
    $filter = $this->imagecreatenew($t_width, $t_height, false, true);
    $text_color = imagecolorallocate($filter ,$red, $green, $blue);

    if ($font_type == 'gd') {
        foreach ($text as $k => $v) {
            if ($this->image_text_direction == 'v') {
                imagestringup($filter,
                              $this->image_text_font,
                              (int) ($k * ($line_width  + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0))),
                              (int) ($text_height - (2 * $this->image_text_padding_y) - ($this->image_text_alignment == 'l' ? 0 : (($t_height - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2)))),
                              $v,
                              $text_color);
            } else {
                imagestring($filter,
                            $this->image_text_font,
                            (int) ($this->image_text_alignment == 'l' ? 0 : (($t_width - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
                            (int) ($k * ($line_height  + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0))),
                            $v,
                            $text_color);
            }
        }
    } else if ($font_type == 'tt') {
        imagettftext($filter,
                     $this->image_text_size,
                     $this->image_text_angle,
                     $text_offset_x,
                     $text_offset_y,
                     $text_color,
                     $this->image_text_font,
                     $text);
    }
    $this->imagecopymergealpha($image_dst, $filter, $text_x, $text_y, 0, 0, $t_width, $t_height, $this->image_text_opacity);
    $this->imageunset($filter);

} else {
    $text_color = imagecolorallocate($image_dst ,$red, $green, $blue);
    if ($font_type == 'gd') {
        foreach ($text as $k => $v) {
            if ($this->image_text_direction == 'v') {
                imagestringup($image_dst,
                              $this->image_text_font,
                              $text_x + $k * ($line_width  + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
                              $text_y + $text_height - (2 * $this->image_text_padding_y) - ($this->image_text_alignment == 'l' ? 0 : (($t_height - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
                              $v,
                              $text_color);
            } else {
                imagestring($image_dst,
                            $this->image_text_font,
                            $text_x + ($this->image_text_alignment == 'l' ? 0 : (($t_width - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
                            $text_y + $k * ($line_height  + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
                            $v,
                            $text_color);
            }
        }
    } else if ($font_type == 'tt') {
        imagettftext($image_dst,
                     $this->image_text_size,
                     $this->image_text_angle,
                     $text_offset_x + ($this->image_dst_x / 2) - ($text_width / 2) + $this->image_text_padding_x,
                     $text_offset_y + ($this->image_dst_y / 2) - ($text_height / 2) + $this->image_text_padding_y,
                     $text_color,
                     $this->image_text_font,
                     $text);
    }
}

// yansıma ekle
if ($this->image_reflection_height) {
    $this->log .= '- yansıma ekle: ' . $this->image_reflection_height . '<br />';
    // image_reflection_height'i çözeriz, bu bir tamsayı, piksel veya yüzde cinsinden bir dize olabilir
    $image_reflection_height = $this->image_reflection_height;
    if (strpos($image_reflection_height, '%')>0) $image_reflection_height = $this->image_dst_y * ((int) str_replace('%','',$image_reflection_height) / 100);
    if (strpos($image_reflection_height, 'px')>0) $image_reflection_height = (int) str_replace('px','',$image_reflection_height);
    $image_reflection_height = (int) $image_reflection_height;
    if ($image_reflection_height > $this->image_dst_y) $image_reflection_height = $this->image_dst_y;
    if (empty($this->image_reflection_opacity)) $this->image_reflection_opacity = 60;
    // yeni hedef görüntüyü oluştur
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y + $image_reflection_height + $this->image_reflection_space, true);
    $transparency = $this->image_reflection_opacity;

    // orijinal görüntüyü kopyala
    imagecopy($tmp, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y + ($this->image_reflection_space < 0 ? $this->image_reflection_space : 0));

    // ekstra parçanın doğru renkte veya şeffaf olduğundan emin olmalıyız
    if ($image_reflection_height + $this->image_reflection_space > 0) {
        // mevcutsa arka plan rengini kullan
        if (!empty($this->image_background_color)) {
            list($red, $green, $blue) = $this->getcolors($this->image_background_color);
            $fill = imagecolorallocate($tmp, $red, $green, $blue);
        } else {
            $fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        }
        // ekstra parçanın kenarından doldur
        imagefill($tmp, round($this->image_dst_x / 2), $this->image_dst_y + $image_reflection_height + $this->image_reflection_space - 1, $fill);
    }

    // yansımayı kopyala
    for ($y = 0; $y < $image_reflection_height; $y++) {
        for ($x = 0; $x < $this->image_dst_x; $x++) {
            $pixel_b = imagecolorsforindex($tmp, imagecolorat($tmp, $x, $y + $this->image_dst_y + $this->image_reflection_space));
            $pixel_o = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $this->image_dst_y - $y - 1 + ($this->image_reflection_space < 0 ? $this->image_reflection_space : 0)));
            $alpha_o = 1 - ($pixel_o['alpha'] / 127);
            $alpha_b = 1 - ($pixel_b['alpha'] / 127);
            $opacity = $alpha_o * $transparency / 100;
            if ($opacity > 0) {
                $red   = round((($pixel_o['red']   * $opacity) + ($pixel_b['red']  ) * $alpha_b) / ($alpha_b + $opacity));
                $green = round((($pixel_o['green'] * $opacity) + ($pixel_b['green']) * $alpha_b) / ($alpha_b + $opacity));
                $blue  = round((($pixel_o['blue']  * $opacity) + ($pixel_b['blue'] ) * $alpha_b) / ($alpha_b + $opacity));
                $alpha = ($opacity + $alpha_b);
                if ($alpha > 1) $alpha = 1;
                $alpha =  round((1 - $alpha) * 127);
                $color = imagecolorallocatealpha($tmp, $red, $green, $blue, $alpha);
                imagesetpixel($tmp, $x, $y + $this->image_dst_y + $this->image_reflection_space, $color);
            }
        }
        if ($transparency > 0) $transparency = $transparency - ($this->image_reflection_opacity / $image_reflection_height);
    }

    // sonucu hedef görüntüye kopyala
    $this->image_dst_y = $this->image_dst_y + $image_reflection_height + $this->image_reflection_space;
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// opaklığı değiştir
if ($gd_version >= 2 && is_numeric($this->image_opacity) && $this->image_opacity < 100) {
    $this->log .= '- opaklığı değiştir<br />';
    // yeni hedef görüntüyü oluştur
    $tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, true);
    for($y=0; $y < $this->image_dst_y; $y++) {
        for($x=0; $x < $this->image_dst_x; $x++) {
            $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
            $alpha = $pixel['alpha'] + round((127 - $pixel['alpha']) * (100 - $this->image_opacity) / 100);
            if ($alpha > 127) $alpha = 127;
            if ($alpha > 0) {
                $color = imagecolorallocatealpha($tmp, $pixel['red'] , $pixel['green'], $pixel['blue'], $alpha);
                imagesetpixel($tmp, $x, $y, $color);
            }
        }
    }
    // sonucu hedef görüntüye kopyala
    $image_dst = $this->imagetransfer($tmp, $image_dst);
}

// JPEG görüntüsünü belirli bir boyuta küçült
if (is_numeric($this->jpeg_size) && $this->jpeg_size > 0 && ($this->image_convert == 'jpeg' || $this->image_convert == 'jpg')) {
    // ilham kaynağı: JPEGReducer sınıfı sürüm 1, 25 Kasım 2004, Yazar: Huda M ElMatsani, justhuda at netscape dot net
    $this->log .= '- JPEG istenen dosya boyutu: ' . $this->jpeg_size . '<br />';
    // her görüntünün boyutunu hesapla. %75, %50 ve %25 kalite
    ob_start(); imagejpeg($image_dst,null,75);  $buffer = ob_get_contents(); ob_end_clean();
    $size75 = strlen($buffer);
    ob_start(); imagejpeg($image_dst,null,50);  $buffer = ob_get_contents(); ob_end_clean();
    $size50 = strlen($buffer);
    ob_start(); imagejpeg($image_dst,null,25);  $buffer = ob_get_contents(); ob_end_clean();
    $size25 = strlen($buffer);

    // 0'a bölünmeyeceğinden emin ol
    if ($size50 == $size25) $size50++;
    if ($size75 == $size50 || $size75 == $size25) $size75++;

    // kaliteye göre boyut küçültme eğimini hesapla
    $mgrad1 = 25 / ($size50-$size25);
    $mgrad2 = 25 / ($size75-$size50);
    $mgrad3 = 50 / ($size75-$size25);
    $mgrad  = ($mgrad1 + $mgrad2 + $mgrad3) / 3;
    // beklenen boyut için yaklaşık kalite faktörü
    $q_factor = round($mgrad * ($this->jpeg_size - $size50) + 50);

if ($q_factor<1) {
    $this->jpeg_quality=1;
} elseif ($q_factor>100) {
    $this->jpeg_quality=100;
} else {
    $this->jpeg_quality=$q_factor;
}
$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;JPEG quality factor set to ' . $this->jpeg_quality . '<br />';

// converts image from true color, and fix transparency if needed
$this->log .= '- converting...<br />';
$this->image_dst_type = $this->image_convert;
switch($this->image_convert) {
    case 'gif':
        // if the image is true color, we convert it to a palette
        if (imageistruecolor($image_dst)) {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;true color to palette<br />';
            // creates a black and white mask
            $mask = array(array());
            for ($x = 0; $x < $this->image_dst_x; $x++) {
                for ($y = 0; $y < $this->image_dst_y; $y++) {
                    $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                    $mask[$x][$y] = $pixel['alpha'];
                }
            }
            list($red, $green, $blue) = $this->getcolors($this->image_default_color);
            // first, we merge the image with the background color, so we know which colors we will have
            for ($x = 0; $x < $this->image_dst_x; $x++) {
                for ($y = 0; $y < $this->image_dst_y; $y++) {
                    if ($mask[$x][$y] > 0){
                        // we have some transparency. we combine the color with the default color
                        $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                        $alpha = ($mask[$x][$y] / 127);
                        $pixel['red'] = round(($pixel['red'] * (1 -$alpha) + $red * ($alpha)));
                        $pixel['green'] = round(($pixel['green'] * (1 -$alpha) + $green * ($alpha)));
                        $pixel['blue'] = round(($pixel['blue'] * (1 -$alpha) + $blue * ($alpha)));
                        $color = imagecolorallocate($image_dst, $pixel['red'], $pixel['green'], $pixel['blue']);
                        imagesetpixel($image_dst, $x, $y, $color);
                    }
                }
            }
            // transforms the true color image into palette, with its merged default color
            if (empty($this->image_background_color)) {
                imagetruecolortopalette($image_dst, true, 255);
                $transparency = imagecolorallocate($image_dst, 254, 1, 253);
                imagecolortransparent($image_dst, $transparency);
                // make the transparent areas transparent
                for ($x = 0; $x < $this->image_dst_x; $x++) {
                    for ($y = 0; $y < $this->image_dst_y; $y++) {
                        // we test wether we have enough opacity to justify keeping the color
                        if ($mask[$x][$y] > 120) imagesetpixel($image_dst, $x, $y, $transparency);
                    }
                }
            }
            unset($mask);
        }
        break;
    case 'jpg':
    case 'bmp':
        // if the image doesn't support any transparency, then we merge it with the default color
        $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;fills in transparency with default color<br />';
        list($red, $green, $blue) = $this->getcolors($this->image_default_color);
        $transparency = imagecolorallocate($image_dst, $red, $green, $blue);
        // make the transaparent areas transparent
        for ($x = 0; $x < $this->image_dst_x; $x++) {
            for ($y = 0; $y < $this->image_dst_y; $y++) {
                // we test wether we have some transparency, in which case we will merge the colors
                if (imageistruecolor($image_dst)) {
                    $rgba = imagecolorat($image_dst, $x, $y);
                    $pixel = array('red' => ($rgba >> 16) & 0xFF,
                                   'green' => ($rgba >> 8) & 0xFF,
                                   'blue' => $rgba & 0xFF,
                                   'alpha' => ($rgba & 0x7F000000) >> 24);
                } else {
                    $pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
                }
                if ($pixel['alpha'] == 127) {
                    // we have full transparency. we make the pixel transparent
                    imagesetpixel($image_dst, $x, $y, $transparency);
                } else if ($pixel['alpha'] > 0) {
                    // we have some transparency. we combine the color with the default color
                    $alpha = ($pixel['alpha'] / 127);
                    $pixel['red'] = round(($pixel['red'] * (1 -$alpha) + $red * ($alpha)));
                    $pixel['green'] = round(($pixel['green'] * (1 -$alpha) + $green * ($alpha)));
                    $pixel['blue'] = round(($pixel['blue'] * (1 -$alpha) + $blue * ($alpha)));
                    $color = imagecolorclosest($image_dst, $pixel['red'], $pixel['green'], $pixel['blue']);
                    imagesetpixel($image_dst, $x, $y, $color);
                }
            }
        }

        break;
    default:
        break;
}

// interlace options
if($this->image_interlace) imageinterlace($image_dst, true);

// outputs image
$this->log .= '- saving image...<br />';
switch($this->image_convert) {
    case 'jpeg':
    case 'jpg':
        if (!$return_mode) {
            $result = @imagejpeg($image_dst, $this->file_dst_pathname, $this->jpeg_quality);
        } else {
            ob_start();
            $result = @imagejpeg($image_dst, null, $this->jpeg_quality);
            $return_content = ob_get_contents();
            ob_end_clean();
        }
        if (!$result) {
            $this->processed = false;
            $this->error = $this->translate('file_create', array('JPEG'));
        } else {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;JPEG image created<br />';
        }
        break;
    case 'png':
        imagealphablending( $image_dst, false );
        imagesavealpha( $image_dst, true );
        if (!$return_mode) {
            if (is_numeric($this->png_compression) && version_compare(PHP_VERSION, '5.1.2') >= 0) {
                $result = @imagepng($image_dst, $this->file_dst_pathname, $this->png_compression);
            } else {
                $result = @imagepng($image_dst, $this->file_dst_pathname);
            }
        } else {
            ob_start();
            if (is_numeric($this->png_compression) && version_compare(PHP_VERSION, '5.1.2') >= 0) {
                $result = @imagepng($image_dst, null, $this->png_compression);
            } else {
                $result = @imagepng($image_dst);
            }
            $return_content = ob_get_contents();
            ob_end_clean();
        }
        if (!$result) {
            $this->processed = false;
            $this->error = $this->translate('file_create', array('PNG'));
        } else {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;PNG image created<br />';
        }
        break;
    case 'webp':
        imagealphablending( $image_dst, false );
        imagesavealpha( $image_dst, true );
        if (!$return_mode) {
            $result = @imagewebp($image_dst, $this->file_dst_pathname, $this->webp_quality);
        } else {
            ob_start();
            $result = @imagewebp($image_dst, null, $this->webp_quality);
            $return_content = ob_get_contents();
            ob_end_clean();
        }
        if (!$result) {
            $this->processed = false;
            $this->error = $this->translate('file_create', array('WEBP'));
        } else {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;WEBP image created<br />';
        }
        break;
    case 'gif':
        if (!$return_mode) {
            $result = @imagegif($image_dst, $this->file_dst_pathname);
        } else {
            ob_start();
            $result = @imagegif($image_dst);
            $return_content = ob_get_contents();
            ob_end_clean();
        }
        if (!$result) {
            $this->processed = false;
            $this->error = $this->translate('file_create', array('GIF'));
        } else {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;GIF image created<br />';
        }
        break;
    case 'bmp':
        if (!$return_mode) {
            $result = $this->imagebmp($image_dst, $this->file_dst_pathname);
        } else {
            ob_start();
            $result = $this->imagebmp($image_dst);
            $return_content = ob_get_contents();
            ob_end_clean();
        }
        if (!$result) {
            $this->processed = false;
            $this->error = $this->translate('file_create', array('BMP'));
        } else {
            $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;BMP image created<br />';
        }
        break;

    default:
        $this->processed = false;
        $this->error = $this->translate('no_conversion_type');
}
if ($this->processed) {
    $this->imageunset($image_src);
    $this->imageunset($image_dst);
    $this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image objects destroyed<br />';
}
} else {
    $this->log .= '- no image processing wanted<br />';

    if (!$return_mode) {
        // copy the file to its final destination. we don't use move_uploaded_file here
        // if we happen to have open_basedir restrictions, it is a temp file that we copy, not the original uploaded file
        if (!copy($this->file_src_pathname, $this->file_dst_pathname)) {
            $this->processed = false;
            $this->error = $this->translate('copy_failed');
        }
    } else {
        // returns the file, so that its content can be received by the caller
        $return_content = @file_get_contents($this->file_src_pathname);
        if ($return_content === false) {
            $this->processed = false;
            $this->error = $this->translate('reading_failed');
        }
    }
}

if ($this->processed) {
    $this->log .= '- <b>process OK</b><br />';
} else {
    $this->log .= '- <b>error</b>: ' . $this->error . '<br />';
}

// we reinit all the vars
$this->init();

// we may return the image content
if ($return_mode) return $return_content;
}

/**
 * Deletes the uploaded file from its temporary location
 *
 * When PHP uploads a file, it stores it in a temporary location.
 * When you {@link process} the file, you actually copy the resulting file to the given location, it doesn't alter the original file.
 * Once you have processed the file as many times as you wanted, you can delete the uploaded file.
 * If there is open_basedir restrictions, the uploaded file is in fact a temporary file
 *
 * You might want not to use this function if you work on local files, as it will delete the source file
 *
 * @access public
 */
function clean() {
    $this->log .= '<b>cleanup</b><br />';
    $this->log .= '- delete temp file '  . $this->file_src_pathname . '<br />';
    @unlink($this->file_src_pathname);
}

/**
 * Opens a BMP image
 *
 * This function has been written by DHKold, and is used with permission of the author
 *
 * @access public
 */
function imagecreatefrombmp($filename) {
    if (! $f1 = fopen($filename,"rb")) return false;

    $file = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
    if ($file['file_type'] != 19778) return false;

    $bmp = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                  '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                  '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
    $bmp['colors'] = pow(2,$bmp['bits_per_pixel']);
    if ($bmp['size_bitmap'] == 0) $bmp['size_bitmap'] = $file['file_size'] - $file['bitmap_offset'];
    $bmp['bytes_per_pixel'] = $bmp['bits_per_pixel']/8;
    $bmp['bytes_per_pixel2'] = ceil($bmp['bytes_per_pixel']);
    $bmp['decal'] = ($bmp['width']*$bmp['bytes_per_pixel']/4);
    $bmp['decal'] -= floor($bmp['width']*$bmp['bytes_per_pixel']/4);
    $bmp['decal'] = 4-(4*$bmp['decal']);
    if ($bmp['decal'] == 4) $bmp['decal'] = 0;

    $palette = array();
    if ($bmp['colors'] < 16777216) {
        $palette = unpack('V'.$bmp['colors'], fread($f1,$bmp['colors']*4));
    }

    $im = fread($f1,$bmp['size_bitmap']);
    $vide = chr(0);

    $res = imagecreatetruecolor($bmp['width'],$bmp['height']);
    $P = 0;
    $Y = $bmp['height']-1;
    while ($Y >= 0) {
        $X=0;
        while ($X < $bmp['width']) {
            if ($bmp['bits_per_pixel'] == 24)
                $color = unpack("V",substr($im,$P,3).$vide);
            elseif ($bmp['bits_per_pixel'] == 16) {
                $color = unpack("n",substr($im,$P,2));
                $color[1] = $palette[$color[1]+1];
            } elseif ($bmp['bits_per_pixel'] == 8) {
                $color = unpack("n",$vide.substr($im,$P,1));
                $color[1] = $palette[$color[1]+1];
            } elseif ($bmp['bits_per_pixel'] == 4) {
                $color = unpack("n",$vide.substr($im,floor($P),1));
                if (($P*2)%2 == 0) $color[1] = ($color[1] >> 4) ; else $color[1] = ($color[1] & 0x0F);
                $color[1] = $palette[$color[1]+1];
            } elseif ($bmp['bits_per_pixel'] == 1)  {
                $color = unpack("n",$vide.substr($im,floor($P),1));
                if     (($P*8)%8 == 0) $color[1] =  $color[1]        >>7;
                elseif (($P*8)%8 == 1) $color[1] = ($color[1] & 0x40)>>6;
                elseif (($P*8)%8 == 2) $color[1] = ($color[1] & 0x20)>>5;
                elseif (($P*8)%8 == 3) $color[1] = ($color[1] & 0x10)>>4;
                elseif (($P*8)%8 == 4) $color[1] = ($color[1] & 0x8)>>3;
                elseif (($P*8)%8 == 5) $color[1] = ($color[1] & 0x4)>>2;
                elseif (($P*8)%8 == 6) $color[1] = ($color[1] & 0x2)>>1;
                elseif (($P*8)%8 == 7) $color[1] = ($color[1] & 0x1);
                $color[1] = $palette[$color[1]+1];
            } else
                return false;
            imagesetpixel($res,$X,$Y,$color[1]);
            $X++;
            $P += $bmp['bytes_per_pixel'];
        }
        $Y--;
        $P+=$bmp['decal'];
    }
    fclose($f1);
    return $res;
}

/**
 * Saves a BMP image
 *
 * This function has been published on the PHP website, and can be used freely
 *
 * @access public
 */
function imagebmp(&$im, $filename = "") {

    if (!$im) return false;
    $w = imagesx($im);
    $h = imagesy($im);
    $result = '';

    // if the image is not true color, we convert it first
    if (!imageistruecolor($im)) {
        $tmp = imagecreatetruecolor($w, $h);
        imagecopy($tmp, $im, 0, 0, 0, 0, $w, $h);
        $this->imageunset($im);
        $im = & $tmp;
    }

    $biBPLine = $w * 3;
    $biStride = ($biBPLine + 3) & ~3;
    $biSizeImage = $biStride * $h;
    $bfOffBits = 54;
    $bfSize = $bfOffBits + $biSizeImage;

    $result .= substr('BM', 0, 2);
    $result .=  pack ('VvvV', $bfSize, 0, 0, $bfOffBits);
    $result .= pack ('VVVvvVVVVVV', 40, $w, $h, 1, 24, 0, $biSizeImage, 0, 0, 0, 0);


$numpad = $biStride - $biBPLine;
for ($y = $h - 1; $y >= 0; --$y) {
    for ($x = 0; $x < $w; ++$x) {
        $col = imagecolorat ($im, $x, $y);
        $result .=  substr(pack ('V', $col), 0, 3);
    }
    for ($i = 0; $i < $numpad; ++$i)
        $result .= pack ('C', 0);
}

if($filename==""){
    echo $result;
} else {
    $file = fopen($filename, "wb");
    fwrite($file, $result);
    fclose($file);
}
return true;
}
}
