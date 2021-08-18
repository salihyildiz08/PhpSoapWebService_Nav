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

* Daha Sonra web servisi kullanabilmek için aşağıdaki include dahil ediyoruz.

->Öncelikle kullanmak istediğiniz sayfaya
-> include 'ntlm/Client.php';
->dahil ediniz.

* Daha sonra verileri çekmek için bu işlemleri yapıyoruz.
* To be able to use the web service later, we include the following include.

->$pageURL değişkeninde Client.php içerisinde bulunan $baseURL ve $cur değişkenleri include sayesinde dahil ediyoruz. Son satırda yer alan Items ise Microsoft Dynamics Nav üzerinde oluşturduğumuz. Soap Web servisimizin ismidir.
->Thanks to inclusion, we include the variables $baseURL and $cur in the variable ->$pageURL in Client.php. The items in the last row are items we created in Microsoft Dynamics Nav. Soap is the name of our Web service.

-> $params değişkenine yapmak istediğimiz filtreleri tanımlıyoruz.
-> We define the filters we want to do in the $params variable.

-> $page değişkeni ile yeni $pageURL objesi oluşturuyoruz.
-> We create a new $pageURL object with the $page variable.

-> $params değişkeni ile filtlerimizi ayarlıyoruz. fieldleri kullanarak birden fazla field ekleyerek filtreleme işlemini gerçekleştirebiliriz.
-> We set our filters with the $params variable. We can perform filtering by adding more than one field using fields.

-> $result değişkeni ile $page değişkenine $params filtresini uyguluyoruz.
-> With the $result variable, we apply the $params filter to the $page variable.

-> $items değişkeni ile verilerimizi çekmeye hazırız.
-> We are ready to pull our data with the $items variable.

->is_array($items) kontrol ederek foreach kullanarak döngü oluşturduk değilse else bloğu çalışarak veriler gelecektir.
->By checking ->is_array($items), we created a loop using foreach, otherwise the else block will work and the data will come.

    $pageURL = $baseURL.rawurlencode($cur).'/Page/Items'; 
              $page = new NTLMSoapClient($pageURL);
              $params = array('filter' => array( 
                array('Field' => 'Block',
                  'Criteria' => 'No'
                )
              ),
              'setSize' => 0); 

              $result = $page->ReadMultiple($params); 
              $items = $result->ReadMultiple_Result->Items;

                if (is_array($items)) { 
                      foreach($items as $item)
                    { 
                        echo $item->Item_No.' -> '$item->Description;
                    }
                }

                else{
                    echo $items->Item_No.' -> '$items->Description;
                }