<?php
include('includes/config.php');
include('includes/header.php');
?>

<div class="container mt-5 mb-5">
  <h2 class="text-center mb-4">Sıkça Sorulan Sorular</h2>
  <p class="text-center text-muted mb-5">Ev kiralama süreciyle ilgili en çok merak edilen soruların yanıtlarını aşağıda bulabilirsiniz.</p>

  <div class="accordion" id="faqAccordion">

    <!-- Soru 1 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
          Ev ilanı oluşturmak ücretli mi?
        </button>
      </h2>
      <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Hayır, ev ilanı oluşturmak tamamen ücretsizdir. Ancak ilanlar, sistem yöneticileri tarafından onaylandıktan sonra yayına alınır.
        </div>
      </div>
    </div>

    <!-- Soru 2 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
          Favori evleri nereden görebilirim?
        </button>
      </h2>
      <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Giriş yaptıktan sonra kullanıcı panelinizdeki “Favorilerim” sekmesinden favori evlerinize ulaşabilirsiniz.
        </div>
      </div>
    </div>

    <!-- Soru 3 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
          Şifremi unuttum, ne yapmalıyım?
        </button>
      </h2>
      <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Giriş sayfasında bulunan “Şifremi Unuttum” bağlantısını kullanarak e-posta adresinize sıfırlama bağlantısı gönderebilirsiniz.
        </div>
      </div>
    </div>

    <!-- Soru 4 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
          Ev arama filtreleri nasıl kullanılır?
        </button>
      </h2>
      <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          “Evler” sayfasında yer alan filtreleme bölümünden il, ilçe, fiyat aralığı, oda sayısı gibi kriterleri belirleyerek kolayca arama yapabilirsiniz.
        </div>
      </div>
    </div>

    <!-- Soru 5 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingFive">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
          Evleri kiralamak için ödeme işlemi nasıl gerçekleşiyor?
        </button>
      </h2>
      <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Ödeme işlemleri, güvenli ödeme altyapımız üzerinden gerçekleştirilir. Kiralama işlemi tamamlandığında ödeme bilgileri sistemde saklanmaz.
        </div>
      </div>
    </div>

    <!-- Soru 6 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingSix">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
          Ev ekledikten sonra düzenleme yapabilir miyim?
        </button>
      </h2>
      <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Evet, kullanıcı panelinizdeki “Evlerim” sekmesinden ilanınızı düzenleyebilir veya silebilirsiniz.
        </div>
      </div>
    </div>

  </div>
</div>

<?php include 'includes/footer.php'; ?>
