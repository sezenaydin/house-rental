-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Nis 2025, 15:20:58
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `house_rental`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Test Adı', 'test@example.com', 'Test Konu', 'Test mesajı', 'read', '2025-04-18 21:34:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `house_id`, `created_at`) VALUES
(10, 10, 22, '2025-04-19 23:25:04'),
(12, 9, 20, '2025-04-19 23:34:50'),
(13, 9, 18, '2025-04-19 23:34:51'),
(14, 9, 22, '2025-04-19 23:34:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `houses`
--

CREATE TABLE `houses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `year_built` year(4) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `houses`
--

INSERT INTO `houses` (`id`, `user_id`, `title`, `description`, `price`, `image`, `created_at`, `location`, `size`, `bedrooms`, `bathrooms`, `year_built`, `features`, `status`) VALUES
(14, 9, 'Modern 3+1 Daire, Merkezde', 'Şehir merkezine sadece birkaç dakika mesafede yer alan bu modern 3+1 daire, hem ulaşım kolaylığı hem de konforlu yaşam alanı sunuyor. Ferah salonu ve geniş balkonuyla özellikle aileler için ideal bir seçenek. Evin içi, modern tasarımı ve kaliteli malzemeleriyle dikkat çekiyor. Her odasında yerden ısıtma ve akıllı ev sistemleri bulunuyor, bu da yaşam kalitesini arttıran özelliklerden sadece bazıları.', 120000.00, 'uploads/1745100822_1.jpg', '2025-04-19 22:13:42', 'İstanbul, Kadıköy', 120, 3, 2, '2015', 'Akıllı ev sistemi, ısı yalıtımı, merkezi ısıtma, otopark, güvenlik kamerası, balkon, kaliteli iç mekan malzemeleri, yüksek hızlı internet altyapısı, açık hava spor alanı.', 'rented'),
(15, 9, 'Şehir Manzaralı 1+1 Daire', 'Bu şık 1+1 daire, şehir manzarasına sahip yüksek katta yer alıyor ve modern bir yaşam alanı sunuyor. İç mekan, zarif tasarım ve fonksiyonel kullanım alanlarıyla tasarlandı. Yüksek tavanları ve geniş pencereleriyle doğal ışık dolu bir atmosfer yaratıyor. Özellikle genç profesyoneller ve tek yaşayanlar için mükemmel bir seçenek olan bu daire, şehir merkezine yakınlığıyla da büyük avantaj sağlıyor.', 75000.00, 'uploads/1745100867_6.jpg', '2025-04-19 22:14:27', 'Ankara, Çankaya', 50, 1, 1, '2020', 'Merkezi ısıtma, açık mutfak, asansör, geniş balkon, yüksek hızlı internet altyapısı, güvenlik, akıllı ev sistemleri, spor salonu, sosyal alanlar.', 'available'),
(16, 9, 'Lüks Villada 5+2', 'Denize sıfır konumda yer alan bu muazzam lüks villa, büyük bir bahçeye ve geniş bir yüzme havuzuna sahip. Her odası suit olarak dizayn edilmiş olup, villa içi ve dışı modern tasarımıyla göz kamaştırıyor. Evin iç kısmında kaliteli taş zeminler, yüksek tavanlar ve geniş camlar bulunuyor. Ayrıca villa, tamamen akıllı ev teknolojisiyle donatılmış, her açıdan konforlu bir yaşam alanı sunuyor. Evin bahçesinde barbekü alanı ve yürüyüş yolları da bulunuyor.', 350000.00, 'uploads/1745100900_9.jpg', '2025-04-19 22:15:00', 'Muğla, Bodrum', 350, 5, 4, '2018', 'Özel yüzme havuzu, sauna, açık hava mutfağı, spor salonu, sinema odası, akıllı ev sistemi, barbekü alanı, özel bahçe, otopark.', 'available'),
(17, 9, 'Doğa İçinde 2+1 Müstakil Ev', 'Şehirden uzak, doğa içinde huzurlu bir yaşam isteyenler için ideal olan bu 2+1 müstakil ev, doğal taşlarla inşa edilmiştir. Geniş bahçesi, zeytin ağaçları ve organik sebze bahçesiyle çevrili bu ev, doğayla iç içe bir yaşam sunuyor. Modern iç mekan tasarımı, doğal taşlar ve ahşap detaylarla sıcak bir atmosfer yaratırken, evdeki geniş pencereler doğanın manzarasını tam anlamıyla içeri alıyor. Doğal havalandırma ve enerji tasarruflu yapısı ile çevre dostu bir seçenek.', 65000.00, 'uploads/1745100955_10.jpg', '2025-04-19 22:15:55', 'İzmir, Çeşme', 85, 2, 1, '2024', 'Bahçe, barbekü alanı, organik tarım alanı, doğa yürüyüş yolları, yerel taş yapılar, merkezi ısıtma, doğa manzaralı balkon, sessiz ve huzurlu konum.', 'available'),
(18, 9, 'Merkezde 4+1 Daire', 'Şehir merkezinin tam kalbinde yer alan bu geniş 4+1 daire, her açıdan konforlu bir yaşam alanı sunuyor. Hem aileler hem de yatırımcılar için ideal bir seçenek olan bu daire, kaliteli malzemelerle inşa edilmiş olup, geniş odaları ve modern iç mekan tasarımıyla dikkat çekiyor. Ayrıca, ulaşım noktalarına çok yakın olması, alışveriş ve sosyal alanlara kolay erişim sağlıyor. Evin büyük balkonlarından şehir manzarasının keyfini çıkarabilirsiniz.', 160000.00, 'uploads/1745101013_4.jpg', '2025-04-19 22:16:53', 'İstanbul, Beşiktaş', 160, 4, 3, '2010', 'Balkon, klima, merkezi ısıtma, güvenlik, teras, yüksek hızlı internet altyapısı, otopark, asansör, geniş salon.', 'available'),
(20, 10, 'Sahil Kenarında 3+1 Daire', 'Denize sıfır konumda yer alan bu lüks daire, etkileyici bir deniz manzarasına sahip. Hem tatil havası estiren hem de modern yaşam gereksinimlerini karşılayan bu daire, yüksek kaliteli iç mekan tasarımıyla dikkat çekiyor. Salondan denizi izlerken, balkonun tadını çıkarabilirsiniz. Evin geniş pencereleri, doğrudan deniz manzarasına odaklanıyor, evin doğal ışık almasını sağlıyor. Ayrıca daire, güvenlikli bir sitede yer alıyor ve çevresinde sosyal olanaklar da mevcut.', 80000.00, '../uploads1745102050_5.jpg', '2025-04-19 22:34:10', 'Antalya, Konyaaltı', 130, 3, 2, '2025', 'Otopark, güvenlik, balkon, deniz manzaralı, merkezi ısıtma, spor salonu, yüzme havuzu, geniş camlar, modern iç mekan.', 'available'),
(21, 10, 'Yeni Yapım 1+1 Stüdyo', ' Modern tasarımlı ve kompakt olan bu 1+1 daire, genç profesyoneller ve ilk kez ev sahibi olacaklar için ideal. Şehir merkezine yakınlığı ve ulaşım imkanlarıyla dikkat çeken bu daire, minimal yaşam alanı arayanlar için harika bir seçenek. Geniş pencereleri sayesinde oldukça ferah olan daire, açık mutfak tasarımıyla kullanışlı. Ayrıca asansörlü binada, sosyal olanaklar da mevcuttur.', 50000.00, '../uploads1745102099_7.jpg', '2025-04-19 22:34:59', 'İstanbul, Kadıköy', 45, 1, 1, '2023', 'Merkezi ısıtma, açık mutfak, asansör, geniş balkon, güvenlik, yüksek hızlı internet altyapısı, sosyal alanlar, fitness salonu.', 'available'),
(22, 10, 'Tarihi Evde 3+1', 'Şehrin kalbinde, tarihi dokusu korunmuş bir evde yaşamak isteyenler için mükemmel bir fırsat. Bu 3+1 daire, özgün taş duvarları ve yüksek tavanlarıyla tarihi bir havası olan bir yaşam alanı sunuyor. Modern yaşam olanaklarıyla donatılmış olan ev, klasik tarzı ve işlevselliği bir arada sunuyor. Konforlu odaları ve geniş salonuyla, büyük aileler için ideal bir seçenek.', 110000.00, '../uploads1745102151_2.jpg', '2025-04-19 22:35:51', 'İzmir, Alsancak', 100, 3, 1, '1990', 'Yüksek tavanlar, orijinal taş duvarlar, merkezi ısıtma, balkon, tarihi yapılar, güvenlik, sakin bir sokak.', 'available'),
(24, 10, 'Modern 2+1 Daire, Dış Cephe', 'Yeni inşa edilen bu 2+1 daire, modern iç tasarımı ve dış cephe özellikleriyle göz dolduruyor. Geniş pencereler ve açık mutfak tasarımı, daireyi oldukça ferah hale getiriyor. Ayrıca evin konumu, şehrin merkezine ve alışveriş merkezlerine oldukça yakın. Sosyal olanaklar açısından oldukça zengin olan bu daire, özellikle genç çiftler ve küçük aileler için ideal.', 85000.00, '../uploads1745102316_3.jpg', '2025-04-19 22:38:36', 'Ankara, Çankaya', 95, 2, 1, '2022', 'Balkon, merkezi ısıtma, güvenlik, spor salonu, yüzme havuzu, açık mutfak, asansör, sosyal alanlar, geniş salon.', 'available'),
(25, 10, '6+1 Lüks Villa', 'Burası, muazzam deniz manzarasına sahip 6+1 lüks bir villa. Her odası geniş, ferah ve modern bir tasarıma sahip. Açık yüzme havuzu, özel sauna ve spor salonu gibi özelliklerle konforlu bir yaşam sunan villa, geniş aileler ve konforlu bir yaşam isteyenler için ideal. Ayrıca villanın bahçesinde barbekü alanı ve yüzme havuzuyla yaz aylarında keyifli vakit geçirebilirsiniz.', 260000.00, '../uploads1745102355_8.jpg', '2025-04-19 22:39:15', 'Muğla, Fethiye', 450, 6, 5, '2025', 'Yüzme havuzu, sauna, spor salonu, açık havuz barı, akıllı ev sistemi, geniş bahçe, otopark, barbekü alanı, panoramik deniz manzarası.', 'available');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `card_number` varchar(19) DEFAULT NULL,
  `expiry_date` varchar(5) DEFAULT NULL,
  `cvv` varchar(3) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `house_id`, `amount`, `payment_date`, `card_number`, `expiry_date`, `cvv`, `full_name`, `email`, `phone`) VALUES
(24, 9, 14, 0.00, '2025-04-19 23:33:38', '1234 5678 9123 4567', '2025-', '123', 'Sezen', 'sezen@example.com', '05555026598');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `house_id`, `start_date`, `end_date`, `status`) VALUES
(5, 9, 14, '2025-04-21', '2025-04-28', 'active');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `theme` varchar(10) DEFAULT 'light',
  `language` varchar(10) DEFAULT 'tr',
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `email_notifications` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `theme`, `language`, `full_name`, `phone`, `profile_photo`, `email_notifications`) VALUES
(9, 'User', 'user@example.com', '$2y$10$Z2HJWejeRI5gs6TUS8doHutdCgUwVmTw1InLQlJnn54umWUtHhYrC', 'user', '2025-04-19 22:00:57', 'light', 'tr', 'USER', '0555555555', 'uploads/68041fb42aaaf-profile.jpg', 1),
(10, 'Admin', 'admin@mail.com', '$2y$10$PXqfszPTiJ71A.l/jB4RR.Tm/uaIBR6icYHlmg1vFCxxmhOrJH.ly', 'admin', '2025-04-19 22:17:31', 'light', 'tr', 'ADMİN', '0555555555', NULL, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `house_id` (`house_id`);

--
-- Tablo için indeksler `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_house` (`house_id`);

--
-- Tablo için indeksler `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `houses`
--
ALTER TABLE `houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_house` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
