# House Rental Agency – PHP Tabanlı Ev Kiralama Platformu

**House Rental Agency**, kullanıcıların kiralık evleri arayabileceği, favorilere ekleyebileceği ve ödeme yapabileceği bir platform sunar. Aynı zamanda site yöneticilerinin evleri, kullanıcıları ve mesajları yönetebileceği bir admin paneli sağlar. Bu proje, PHP, MySQL ve modern web teknolojileri kullanılarak geliştirilmiştir.

---

## **Admin Paneli**

Admin Paneli, siteyi yönetmek ve kullanıcıları denetlemek için admin yetkilerine sahip kişilere yönelik bir bölümdür. Admin, evlerin eklenmesi, düzenlenmesi, silinmesi, kullanıcı yönetimi, raporlama ve mesaj yönetimi gibi işlemleri yapabilir.

### **Admin Paneli Özellikleri:**

- **Ev Yönetimi:**
  - Admin, evleri ekleyebilir, düzenleyebilir ve silebilir.
  - Her evin detaylarını (başlık, açıklama, fiyat, konum, fotoğraf vb.) değiştirebilir.

- **Kullanıcı Yönetimi:**
  - Admin, kullanıcı hesaplarını düzenleyebilir ve silebilir.
  - Kullanıcıların hesap durumu (admin/user) kontrol edilebilir.

- **Mesaj Yönetimi:**
  - Admin, kullanıcılar tarafından gönderilen mesajları kontrol edebilir.
  - İletişim mesajları okunmuş ya da okunmamış olarak işaretlenebilir.

- **Raporlama:**
  - Admin, siteye dair raporlar alabilir. Örneğin, aktif evlerin sayısı, kullanıcıların sayısı ve kiralanan evlerin aylık grafiği gibi bilgiler.

---

## **Kullanıcı Paneli**

Kullanıcı Paneli, siteyi kullanan ve ev kiralamak isteyen kişiler için hazırlanmış bir bölüm olup, kullanıcıların kiralama işlemleri yapmasına olanak tanır.

### **Kullanıcı Paneli Özellikleri:**

- **Kayıt ve Giriş:**
  - Kullanıcılar, sisteme kaydolabilir ve giriş yapabilir.

- **Ev Arama ve Filtreleme:**
  - Kullanıcılar, çeşitli kriterlere göre evleri arayabilir (fiyat, konum, yatak odası sayısı, vb.).

- **Ev Ekleme:**
  - Kullanıcılar sayfaya ev ekleyebilirler. Bu evleri "Evlerim" sayfasında görebilirler.

- **Favorilere Ekleme:**
  - Kullanıcılar beğendikleri evleri favorilerine ekleyebilir.

- **Ev Detayları:**
  - Kullanıcılar, her evin detaylarına (fiyat, açıklama, fotoğraf, konum) bakabilir.

- **Ödeme İşlemleri:**
  - Kullanıcılar, seçtikleri evler için ödeme işlemleri gerçekleştirebilir.

- **Hesap Yönetimi:**
  - Kullanıcılar, hesap bilgilerini düzenleyebilir veya hesaplarını silebilir.

---

## **Kullanılan Teknolojiler**

### **Backend:**

- **PHP:** Sunucu tarafı programlama dili olarak kullanılmıştır. Hem Admin Paneli hem de Kullanıcı Paneli için PHP ile dinamik işlevsellik sağlanmıştır.
- **PDO (PHP Data Objects):** Veritabanı işlemleri için güvenli ve esnek bir bağlantı sağlamak amacıyla PDO kullanılmıştır.
- **MySQL:** Projenin veritabanı yönetimi için kullanılmıştır. Kullanıcılar, evler ve favoriler gibi tüm veriler MySQL veritabanında depolanmaktadır.

### **Frontend:**

- **HTML5:** Sayfa yapılarının oluşturulmasında kullanılan temel işaretleme dilidir.
- **CSS3:** Sayfa stilizasyonu ve tasarımı için kullanılmıştır.
- **Tailwind CSS:** Mobil uyumlu, modern ve şık tasarımlar için kullanılan bir CSS framework'üdür. Hızlı stil düzenlemeleri ve özelleştirmeler sağlar.
- **JavaScript:** Sayfa üzerinde dinamik işlevsellik ve kullanıcı etkileşimleri için kullanılmıştır.
- **jQuery:** JavaScript işlevselliğini basitleştirmek ve daha etkili hale getirmek amacıyla kullanılmıştır.

### **Sunucu:**

- **Apache:** Web sunucusu olarak projeyi çalıştırmak için Apache kullanılmaktadır. XAMPP veya WAMP ile birlikte Apache yapılandırılmıştır.

### **Veritabanı Yönetimi:**

- **phpMyAdmin:** MySQL veritabanını yönetmek için phpMyAdmin kullanılmaktadır. Veritabanı bağlantısı ve tablo yönetimi burada yapılmaktadır.

---

## **Kurulum ve Çalıştırma Adımları**

### **1. Gerekli Yazılımların Kurulumu:**
- XAMPP veya WAMP paketini indirip kurarak Apache ve PHP'yi çalıştırın.
- phpMyAdmin üzerinden MySQL veritabanınızı oluşturun.

### **2. Veritabanının Yüklenmesi:**
- phpMyAdmin üzerinden yeni bir veritabanı oluşturun. Örneğin: `house_rental`
- Projeye ait `database/house_rental.sql` dosyasını phpMyAdmin üzerinden içe aktarın:
  1. phpMyAdmin paneline gidin (`http://localhost/phpmyadmin`).
  2. Sol menüden oluşturduğunuz veritabanını seçin (örneğin `house_rental`).
  3. Üst menüden `Import` sekmesine tıklayın.
  4. `File to Import` kısmından `house_rental.sql` dosyasını seçin.
  5. `Go` butonuna tıklayarak veritabanını yükleyin.

### **3. Proje Dosyalarının Yüklenmesi:**
- Proje dosyalarını sunucunuzun `htdocs` (XAMPP) veya `www` (WAMP) dizinine yükleyin.

### **4. Veritabanı Bağlantılarının Yapılandırılması:**
- `includes/config.php` dosyasındaki veritabanı bağlantı bilgilerini doğru şekilde ayarlayın.

$host = 'localhost';    // Veritabanı sunucusu
$db   = 'house_rental'; // Oluşturduğunuz veritabanı adı
$user = 'root';         // MySQL kullanıcı adı
$pass = '';             // MySQL şifresi (genellikle XAMPP ve WAMP'de boş)

### **5. Admin Paneline Giriş:**
- Admin giriş bilgilerini veritabanında belirleyin (örneğin, admin kullanıcı adı ve şifresi).
- Admin paneline giriş yaparak evleri yönetebilir ve kullanıcıları kontrol edebilirsiniz.

### **6. Kullanıcı Paneline Giriş:**
- Kullanıcılar için kayıt ve giriş sistemini kullanarak siteyi kullanmaya başlayabilir.

---

Bu adımları takip ederek **House Rental Agency** projenizi kurabilir ve çalıştırabilirsiniz. Hem admin paneli hem de kullanıcı paneli ile kullanıcıların evleri arayıp favorilerine ekleyebileceği, kiralayabileceği bir platform oluşturabilirsiniz.

---

**Lisans:**  
Bu proje, MIT Lisansı altında lisanslanmıştır.
