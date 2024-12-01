# Dinamik QR Kod Yönetim Sistemi

Bu proje, dinamik olarak QR kodları oluşturmanıza ve yönetmenize olanak sağlayan bir web uygulamasıdır. Oluşturulan QR kodların hedef URL'lerini, QR kodun kendisini değiştirmeden güncelleyebilirsiniz.

## Özellikler

- QR kod oluşturma ve yönetme
- Dinamik URL yönlendirme
- QR kod hedef URL'lerini güncelleme
- Tüm QR kodları listeleme ve yönetme
- Kolay kullanımlı web arayüzü

## Gereksinimler

- PHP 8.2 veya üzeri
- MySQL/MariaDB veritabanı
- Composer (PHP paket yöneticisi)
- Web sunucusu (Apache/Nginx)

## Kurulum

1. Projeyi klonlayın veya indirin
2. Composer bağımlılıklarını yükleyin:
```bash
composer install
```

3. Veritabanını oluşturun:
   - MySQL/MariaDB'de yeni bir veritabanı oluşturun
   - `qr_code_db.sql` dosyasını veritabanına import edin

4. Veritabanı bağlantı ayarlarını yapın:
   - `db.php` dosyasındaki veritabanı bilgilerini güncelleyin

## Kullanım

1. QR Kod Oluşturma:
   - Ana sayfada "Create QR Code" formunu kullanın
   - Hedef URL'yi girin ve QR kodu oluşturun
   - Oluşturulan QR kodu indirin veya kaydedin

2. QR Kod Güncelleme:
   - Mevcut QR kodları listesinden güncellemek istediğiniz kodu seçin
   - "Update" butonuna tıklayın
   - Yeni hedef URL'yi girin ve kaydedin

3. QR Kodları Yönetme:
   - Tüm QR kodlarınızı ana sayfada görebilirsiniz
   - Her QR kod için hedef URL'yi güncelleyebilirsiniz
   - QR kodların oluşturulma tarihlerini görebilirsiniz

## Kullanım Örnekleri

- Restoran menüleri
- Etkinlik bağlantıları
- Kampanya yönetimi
- Geçici yönlendirmeler
- Dijital kartvizitler

## Güvenlik

- QR kodlar benzersiz ID'ler ile oluşturulur
- Yönlendirmeler güvenli bir şekilde yönetilir
- Veritabanı bağlantıları güvenli bir şekilde yapılır

## Lisans

Bu proje açık kaynak olarak lisanslanmıştır.

## İletişim

Proje ile ilgili sorularınız için iletişime geçebilirsiniz.
