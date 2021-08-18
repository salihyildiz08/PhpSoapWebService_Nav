<?php 
 include 'ntlm/Client.php'; //ntlm klasörü içinde Client.php scripti dahil ederek kullanabiliriz.
                            //We can use it by including the Client.php script in the ntlm folder.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php Microsoft Dynamics Nav Web Service</title>
</head>
<body>
    <table>
        <thead>
            <th>Item No</th>
            <th>Item Description</th>
        </thead>
        <tbody>
            <?php
            //Web servisle bağlantısını yaptığımız verileri çekmek
            // Pulling the data that we connected with the web service
              $pageURL = $baseURL.rawurlencode($cur).'/Page/Items';  //Burada yer alan Items değeri hangi sayfadan veri çekilecekse o sayfanın web serviste oluşturulan adı yazılır.
                                                                    //The name of the page created in the web service is written from whichever page the Items value will be taken from.
              $page = new NTLMSoapClient($pageURL); //Sayfa urlini alarak yeni bir Soap web servis objesi oluşturuyoruz.
                                                    // We create a new Soap web service object by taking the page url.

              $params = array('filter' => array(  //Filtreleme vererek verilere daha uygun şekilde ulaşabiliriz. 
                                                  // By filtering, we can access the data more appropriately.
                array('Field' => 'Block',
                  'Criteria' =>"No"
                )
                /*
                ---------- Birden fazla filtreleme girebiliriz. array fieldleri ekleyerek devam edebiliriz. --------
                ---------- We can enter more than one filtering. We can continue by adding array fields. --------
                 array('Field' => 'Block',
                  'Criteria' =>"No"
              ),
               array('Field' => 'Search_Description',
                  'Criteria' =>"Wood|Iron"
                )
                */
              ),
              'setSize' => 0); //burada yazan 0 değeri uzun bir işlem yapacaktır. Veri boyutunuzu biliyorsanız buraya veri boyut değerini yazarak hız konusunda performans kazanabilirsiniz.
                                //0 value written here will do a long operation. If you know your data size, you can gain performance in speed by typing the data size value here.

              $result = $page->ReadMultiple($params); 
              $items = $result->ReadMultiple_Result->Items; //Burada yer alan Items değeri hangi sayfadan veri çekilecekse o sayfanın web serviste oluşturulan adı yazılır.
                                                            //The name of the page created in the web service is written from whichever page the Items value will be taken from.

              if (is_array($items)) {  //is_array(items) yaparak veriler bir arraysa birden fazla veri ise foreach içerisinde kullanıyoruz
                                        //is_array(items) If the data is an array, we use it in foreach if it is more than one data
                foreach($items as $item1s)
                { 
                ?>
            <tr>
                <td><?php echo $item1s->Item_No; ?></td>
                <td><?php echo $item1s->Item_Description; ?></td>
            </tr>
            <?php
                }
            } 
            else {
            ?>
                <tr>
                <td><?php echo $items->Item_No; ?></td>
                <td><?php echo $items->Item_Description; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>