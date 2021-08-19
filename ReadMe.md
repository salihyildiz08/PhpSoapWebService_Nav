MERHABA İYİ GÜNLER,
HELLO GOOD DAY,

* ÖNCELİKLE NTLM KLASÖRÜNÜ İNDİRİNİZ VE PROJENİZE DAHİL EDİNİZ.
* DOWNLOAD NTLM FOLDER FIRST AND ADD IT TO YOUR PROJECT.

* NTLM klasörü içinde Client.php scriptine gidiniz.
* Go to the Client.php script in the NTLM folder.

 ->Burada
 ->Here

 -> $baseURL = 'http://192.1.1.1:1010/DynamicsNAV100/WS/';
 ->$cur='SASTARSOFT NAV2018'; 

 ->değişkelerini kendinize göre uyarlayınız.
 ->Customize your variables.

* Daha sonra NTLM klasörü içinde NTLMUserID.php scriptine gidip burayıda kendinize göre uyarlayınız.
* Then go to the NTLMUserID.php script in the NTLM folder and adapt it for yourself.

->Microsoft Dynamics Nav'da Web service için oluşturduğumuz kullanıcı ve parolayı kullanıyoruz.
->We use the user and password we created for the Web service in Microsoft Dynamics Nav.

->define('USERPWD','verilerin çekileceği ip adresi veya uzantı maili : şifre'); 
->->define('USERPWD','ip address or extension mail from which data will be pulled : Password'); 

->burayıda kendinize göre uyarlayınız.
->Customize it for yourself here.

* Daha Sonra Sepetteki Ürünleri Eklemek için aşağıdaki yönergeleri takip ediniz.

->Öncelikle kullanmak istediğiniz sayfaya
->Mysql bağlantısı olan connection.php'yi dahil ediyoruz.
-> include 'ntlm/Client.php';
->dahil ediniz.

* 
if (isset($_POST['saveOrder'])) { //saveOrder isimli buttona tıklanırsa oluşacak eylem
                                  // the action that will occur if the button named saveOrder is clicked

    $pageURL = $baseURL.rawurlencode($cur).'/Page/SalesOrder'; //SalesOrder cart kısmının soap web servisini tanımlıyoruz.
                                                                //We define the soap web service of the SalesOrder cart part.

    $service = new NTLMSoapClient($pageURL); //$pageURL soap web servis url'i obje olarak oluşturuyoruz.
                                            //$pageURL soap We are creating the web service url as an object.

    $create = new stdClass(); //stdClass sınıfından 1 obje oluşturuyoruz.
                              // We create 1 object from the stdClass class.

    $sq = new stdClass();     //stdClass sınıfından 1 obje oluşturuyoruz.
                              // We create 1 object from the stdClass class.

    $sq->Sell_to_Customer_Name="Customer Name"; //$sq objemize alıcı müşteri adını veriyoruz.
                                                // We give our $sq object the name of the client client.
    
    $create->SalesOrder = $sq; //$create objemizin SalesOrder kısmına $sq değerini veriyoruz.
                                // We give the value $sq to the SalesOrder part of our $create object.

    $result = $service->create($create); //$create ile aldığımız değerle $service soap web servisinde bulunan sales header kısmını oluşturuyoruz.
                                          // With the value we get with $create, we create the sales header part of the $service soap web service.

    $key = $result->SalesOrder->Key; // oluşturduğumuz sales headerin hangi sales line'a bağlanacağı için $key ile key verisini alıyoruz.
                                    // We get the key data with $key for which sales line the sales header we created will be connected to.

    $update = new stdClass(); //stdClass sınıfından 1 obje oluşturuyoruz. İşlem sonunda update etmemiz gerekiyor.
                              // We create 1 object from the stdClass class. At the end of the process, we need to update it.

    $sq->Key = $key; //$keyde oluşturduğumuz veriyi $sq'nun key değerine atıyoruz.
                    // We assign the data we created in $key to the key value of $sq.

    $basket=$db->prepare("SELECT * FROM basket where customerID=:id"); //mysql veri tabanında bulunan o müşteriye ait sepetteki ürünleri çekiyoruz.
                                                                      // We are pulling the products in the basket of that customer in the mysql database.
    $basket->execute(array(
        'id' => "customer id"
    ));

    $counter=0; //sayaç belirleyerek sales line da birden fazla veri ekleyeceğiz.
                // We will add more than one data in the sales line by specifying a counter.

    $salesLineList = new stdClass(); //sales line list için bir stdClass objesi oluşturuyoruz.
                                      //We create a stdClass object for the sales line list.

    while($basketResult=$basket->fetch(PDO::FETCH_ASSOC)) { //while Döngüsü ile sepetteki verileri alıp sales line'a kaydedeceğiz.
                                                            //While Loop, we will take the data in the basket and save it to the sales line.

        $qty=$basketResult['qty']; //sepetteki adet datası
                                  // quantity data in the basket

        $itemNo=$basketResult['itemNo'];//sepetteki madde numarası datası
                                        // item number data in the cart

        $variantCode=$basketResult['variantCode'];//sepetteki varyant numarası datası
                                                  //variant number data in the cart

        $salesLine = new stdClass(); // Sales line için yeni stdClass objesi oluşturuyoruz.
                                      // We create a new stdClass object for the sales line.

        $salesLine->No = $itemNo; //sales line'deki No'ya datayı veriyoruz 
                                  // give the data to No on the sales line

        $salesLine->Type = 'Item';//sales line'deki Type datayı veriyoruz
                                  // We give the Type data in the sales line
                                  
        $salesLine->Variant_Code =$variantCode;//sales Variant_Code'deki datayı veriyoruz
                                               // give the data in sales Variant_Code

        $salesLine->Quantity = $qty;//sales Quantity'deki datayı veriyoruz
                                    //give the data in sales Quantity

        $salesLineList->Sales_Order_Line[$counter] = $salesLine; //Bütün dataları verdikten sonra $counter sayacı ile hangi satıra eklediğimizi veriyoruz.
                                                                //After giving all the data, we give the line we added with the $counter counter.

        $sq->SalesLines = $salesLineList; // $sq'daki SalesLines'a verimizi atıyoruz.
                                          // We are sending our data to SalesLines in $sq.

        $counter++; //sayaç değerini artırarak yeni satıra geçerken hangi satır olduğunu belirtiriz.
                    // By increasing the counter value, we indicate which line it is when switching to the new line.

        }
    

    $update->SalesOrder = $sq; //Bütün değerler satırlara eklendikten sonra  $sq ile oluşturduğumuz SalesLines'i SalesOrder'a atıyoruz.
                              //After all the values are added to the rows, we assign the SalesLines we created with $sq to SalesOrder.

    $result = $service->Update($update); //ve son olarak saop web servisimizi  Update ederek bitiriyoruz.
                                          // and finally we finish by updating our saop web service.
}


