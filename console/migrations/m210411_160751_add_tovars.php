<?php

use yii\db\Migration;

/**
 * Class m210411_160751_add_tovars
 */
class m210411_160751_add_tovars extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('tovars', [
            'name' => "Samsung Odyssey G5 LC27G54T Black (LC27G54TQWIXCI)", 
            'description' => "Максимальное разрешение дисплея 2560 x 1440 Время реакции матрицы 1 мс (GtG) Яркость дисплея 250 кд/м² Тип матрицы VA Контрастность дисплея 2500:1 Особенности 'Безрамочный' (Сinema screen) Flicker-Free Изогнутый экран",
            'url_image' => json_encode(['../../images/tovar/odyssey1.png','../../images/tovar/odyssey2.png','../../images/tovar/odyssey3.png','../../images/tovar/odyssey4.png','../../images/tovar/odyssey5.png']), 
            'count' => "3000", 
            'price' => "5600", 
            'category_id' => "2",
            'discount_id' => '1'
        ]);

        $this->insert('tovars', [
            'name' => "Acer Nitro EI242QRPbiipx (UM.UE2EE.P01)", 
            'description' => "Максимальное разрешение дисплея 1920 x 1080 Время реакции матрицы 1 мс Яркость дисплея 250 кд/м² Тип матрицы VA Контрастность дисплея 3000:1 Особенности 'Безрамочный' (Сinema screen) Изогнутый экран",
            'url_image' => json_encode(['../../images/tovar/MonitorAcerNitro1.png','../../images/tovar/MonitorAcerNitro2.png','../../images/tovar/MonitorAcerNitro3.png']), 
            'count' => "500", 
            'price' => "10500", 
            'category_id' => "2", 
            'discount_id' => '2'
        ]);

        $this->insert('tovars', [
            'name' => "Samsung Curved C27F396F (LC27F396FHIXCI)", 
            'description' => " Максимальное разрешение дисплея 1920 x 1080 Время реакции матрицы 4 мс Яркость дисплея 250 кд/м² Тип матрицы VA Контрастность дисплея 3000:1 Особенности Flicker-Free Изогнутый экран",
            'url_image' => json_encode(['../../images/tovar/SamsungCurved1.png','../../images/tovar/SamsungCurved2.png','../../images/tovar/SamsungCurved3.png','../../images/tovar/SamsungCurved4.png']), 
            'count' => "540", 
            'price' => "7800", 
            'category_id' => "2", 
            'discount_id' => '2'
        ]);

        $this->insert('tovars', [
            'name' => "Acer Nitro 5 AN515-55-51Y2 (NH.Q7QEU.009) Obsidian Black", 
            'description' => "Экран 15.6 IPS (1920x1080) Full HD 144 Гц, матовый / Intel Core i5-10300H (2.5 - 4.5 ГГц) / RAM 16 ГБ / SSD 512 ГБ / nVidia GeForce RTX 2060, 6 ГБ / без ОД / LAN / Wi-Fi / Bluetooth / веб-камера / без ОС / 2.3 кг / черный",
            'url_image' => json_encode(['../../images/tovar/LaptopAcerNitro1.png','../../images/tovar/LaptopAcerNitro2.png','../../images/tovar/LaptopAcerNitro3.png','../../images/tovar/LaptopAcerNitro4.png','../../images/tovar/LaptopAcerNitro5.png','../../images/tovar/LaptopAcerNitro6.png']), 
            'count' => "7000", 
            'price' => "23650", 
            'category_id' => "1", 
            'discount_id' => '3'
        ]);

        $this->insert('tovars', [
            'name' => "Asus ROG Strix G15 G512LI-HN058 (90NR0381-M01630) Black", 
            'description' => "Экран 15.6 IPS (1920x1080) Full HD 144 Гц, матовый / Intel Core i5-10300H (2.5 - 4.5 ГГц) / RAM 16 ГБ / SSD 512 ГБ / nVidia GeForce GTX 1650 Ti, 4 ГБ / без ОД / LAN / Wi-Fi / Bluetooth / без ОС / 2.39 кг / черный",
            'url_image' => json_encode(['../../images/tovar/AsusROGStrix1.png','../../images/tovar/AsusROGStrix2.png','../../images/tovar/AsusROGStrix3.png','../../images/tovar/AsusROGStrix4.png','../../images/tovar/AsusROGStrix5.png','../../images/tovar/AsusROGStrix6.png']),  
            'count' => "900", 
            'price' => "12700", 
            'category_id' => "1", 
            'discount_id' => '4'
        ]);
        $this->insert('tovars', [
            'name' => "Acer Predator Helios 300 PH315-53-59HQ (NH.Q7ZEU.006) Abyssal Black", 
            'description' => "Экран 15.6 IPS (1920x1080) Full HD 144 Гц, матовый / Intel Core i5-10300H (2.5 - 4.5 ГГц) / RAM 16 ГБ / SSD 512 ГБ / nVidia GeForce RTX 2070 Max-Q, 8 ГБ / без ОД / LAN / Wi-Fi / Bluetooth / веб-камера / без ОС / 2.5 кг / черный",
            'url_image' => json_encode(['../../images/tovar/AcerPredatorHelios1.png','../../images/tovar/AcerPredatorHelios2.png','../../images/tovar/AcerPredatorHelios3.png','../../images/tovar/AcerPredatorHelios4.png','../../images/tovar/AcerPredatorHelios5.png','../../images/tovar/AcerPredatorHelios6.png']), 
            'count' => "200", 
            'price' => "45000", 
            'category_id' => "1", 
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210411_160751_add_tovars cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210411_160751_add_tovars cannot be reverted.\n";

        return false;
    }
    */
}
