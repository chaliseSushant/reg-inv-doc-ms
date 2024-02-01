<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Municipality;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['Hatuwagadhi','Bhojpur'],
            ['Ramprasad Rai','Bhojpur'],
            ['Aamchok','Bhojpur'],
            ['Tyamke Maiyum','Bhojpur'],
            ['Arun','Bhojpur'],
            ['Pauwadungma','Bhojpur'],
            ['Salpasilichho','Bhojpur'],
            ['Sangurigadhi','Dhankuta'],
            ['Chaubise','Dhankuta'],
            ['Sahidbhumi','Dhankuta'],
            ['Chhathar Jorpati','Dhankuta'],
            ['Phakphokthum','Ilam'],
            ['Mai Jogmai','Ilam'],
            ['Chulachuli','Ilam'],
            ['Rong','Ilam'],
            ['Mangsebung','Ilam'],
            ['Sandakpur','Ilam'],
            ['Kamal','Jhapa'],
            ['Buddha Shanti','Jhapa'],
            ['Kachankawal','Jhapa'],
            ['Jhapa','Jhapa'],
            ['Barhadashi','Jhapa'],
            ['Gaurigunj','Jhapa'],
            ['Haldibari','Jhapa'],
            ['Khotehang','Khotang'],
            ['Diprung','Khotang'],
            ['Aiselukharka','Khotang'],
            ['Jantedhunga','Khotang'],
            ['Kepilasgadhi','Khotang'],
            ['Barahpokhari','Khotang'],
            ['Rawabesi','Khotang'],
            ['Sakela','Khotang'],
            ['Jahada','Morang'],
            ['Budi Ganga','Morang'],
            ['Katahari','Morang'],
            ['Dhanpalthan','Morang'],
            ['Kanepokhari','Morang'],
            ['Gramthan','Morang'],
            ['Kerabari','Morang'],
            ['Miklajung','Morang'],
            ['Manebhanjyang','Okhaldhunga'],
            ['Champadevi','Okhaldhunga'],
            ['Sunkoshi','Okhaldhunga'],
            ['Molung','Okhaldhunga'],
            ['Chisankhugadhi','Okhaldhunga'],
            ['Khiji Demba','Okhaldhunga'],
            ['Likhu','Okhaldhunga'],
            ['Miklajung','Panchthar'],
            ['Phalgunanda','Panchthar'],
            ['Hilihang','Panchthar'],
            ['Phalelung','Panchthar'],
            ['Yangwarak','Panchthar'],
            ['Kummayak','Panchthar'],
            ['Tumbewa','Panchthar '],
            ['Makalu','Sankhuwasabha'],
            ['Silichong','Sankhuwasabha'],
            ['Sabhapokhari','Sankhuwasabha'],
            ['Chichila','Sankhuwasabha'],
            ['Bhot Khola','Sankhuwasabha'],
            ['Dudhakaushika','Solukhumbu'],
            ['Necha Salyan','Solukhumbu'],
            ['Dudhkoshi','Solukhumbu'],
            ['Maha Kulung','Solukhumbu'],
            ['Sotang','Solukhumbu'],
            ['Khumbu Pasang Lhamu','Solukhumbu'],
            ['Likhu Pike','Solukhumbu'],
            ['Koshi','Sunsari'],
            ['Harinagara','Sunsari'],
            ['Bhokraha','Sunsari'],
            ['Dewanganj','Sunsari'],
            ['Gadhi','Sunsari'],
            ['Barju','Sunsari'],
            ['Sirijangha','Taplejung'],
            ['Aathrai Triveni','Taplejung'],
            ['Pathibhara Yangwarak','Taplejung'],
            ['Meringden','Taplejung'],
            ['Sidingwa','Taplejung'],
            ['Phaktanglung','Taplejung'],
            ['Maiwa Khola','Taplejung'],
            ['Mikwa Khola','Taplejung'],
            ['Aathrai','Terhathum'],
            ['Phedap','Terhathum'],
            ['Chhathar','Terhathum'],
            ['Menchayayem','Terhathum'],
            ['Udayapurgadhi','Udayapur'],
            ['Rautamai','Udayapur'],
            ['Tapli','Udayapur'],
            ['Limchungbung','Udayapur'],

            ['Suwarna','Bara'],
            ['Adarsha Kotwal','Bara'],
            ['Baragadhi','Bara'],
            ['Pheta','Bara'],
            ['Karaiyamai','Bara'],
            ['Prasauni','Bara'],
            ['Bishrampur','Bara'],
            ['Devtal','Bara'],
            ['Parwanipur','Bara'],
            ['Lakshminya','Dhanusha'],
            ['Mukhiyapatti Musharniya','Dhanusha'],
            ['Janaknandini','Dhanusha'],
            ['Aurahi','Dhanusha'],
            ['Bateshwar','Dhanusha'],
            ['Dhanauji','Dhanusha'],
            ['Sonama','Mahottari'],
            ['Pipra','Mahottari'],
            ['Samsi','Mahottari'],
            ['Ekdara','Mahottari'],
            ['Mahottari','Mahottari'],
            ['Sakhuwa Prasauni','Parsa'],
            ['Jagarnathpur','Parsa'],
            ['Chhipahrmai','Parsa'],
            ['Bindabasini','Parsa'],
            ['Paterwa Sugauli','Parsa'],
            ['Jirabhawani','Parsa'],
            ['Kalikamai','Parsa'],
            ['Pakaha Mainpur','Parsa'],
            ['Thori','Parsa'],
            ['Dhobini','Parsa'],
            ['Durga Bhagawati','Rautahat'],
            ['Yamunamai','Rautahat'],
            ['Tilathi Koiladi','Saptari'],
            ['Rajgadh','Saptari'],
            ['Chhinnamasta','Saptari'],
            ['Mahadeva','Saptari'],
            ['Agnisaira Krishnasavaran','Saptari'],
            ['Rupani','Saptari'],
            ['Balan-Bihul','Saptari'],
            ['Bishnupur','Saptari'],
            ['Tirhut','Saptari'],
            ['Chandranagar','Sarlahi'],
            ['Brahampuri','Sarlahi'],
            ['Ramnagar','Sarlahi'],
            ['Chakraghatta','Sarlahi'],
            ['Kaudena','Sarlahi'],
            ['Dhankaul','Sarlahi'],
            ['Bishnu','Sarlahi'],
            ['Basbariya','Sarlahi'],
            ['Parsa','Sarlahi'],
            ['Laksmipur Patari','Siraha'],
            ['Bariyarpatti','Siraha'],
            ['Aurahi','Siraha'],
            ['Arnama','Siraha'],
            ['Bhagwanpur','Siraha'],
            ['Naraha','Siraha'],
            ['Navarajpur','Siraha'],
            ['Sakhuwanankarkatti','Siraha'],
            ['Bishnupur','Siraha'],

            ['Ichchhakamana','Chitwan'],
            ['Thakre','Dhading'],
            ['Benighat Rorang','Dhading'],
            ['Galchhi','Dhading'],
            ['Gajuri','Dhading'],
            ['Jwalamukhi','Dhading'],
            ['Siddhalekh','Dhading'],
            ['Tripurasundari','Dhading'],
            ['Gangajamuna','Dhading'],
            ['Netrawati Dabjong','Dhading'],
            ['Khaniyabas','Dhading'],
            ['Rubi Valley','Dhading'],
            ['Kalinchok','Dolakha'],
            ['Melung','Dolakha'],
            ['Shailung','Dolakha'],
            ['Baiteshwar','Dolakha'],
            ['Tamakoshi','Dolakha'],
            ['Bigu','Dolakha'],
            ['Gaurishankar','Dolakha'],
            ['Roshi','Kavrepalanchok'],
            ['Temal','Kavrepalanchok'],
            ['Chaunri Deurali','Kavrepalanchok'],
            ['Bhumlu','Kavrepalanchok'],
            ['Mahabharat','Kavrepalanchok'],
            ['Bethanchok','Kavrepalanchok'],
            ['Khanikhola','Kavrepalanchok'],
            ['Bagmati','Lalitpur'],
            ['Konjyosom','Lalitpur'],
            ['Mahankal','Lalitpur'],
            ['Bakaiya','Makawanpur'],
            ['Manahari','Makawanpur'],
            ['Bagmati','Makawanpur'],
            ['Raksirang','Makawanpur'],
            ['Makawanpurgadhi','Makawanpur'],
            ['Kailash','Makawanpur'],
            ['Bhimphedi','Makawanpur'],
            ['Indrasarowar','Makawanpur'],
            ['Kakani','Nuwakot'],
            ['Dupcheshwar','Nuwakot'],
            ['Shivapuri','Nuwakot'],
            ['Tadi','Nuwakot'],
            ['Likhu','Nuwakot'],
            ['Suryagadhi','Nuwakot'],
            ['Panchakanya','Nuwakot'],
            ['Tarkeshwar','Nuwakot'],
            ['Kispang','Nuwakot'],
            ['Myagang','Nuwakot'],
            ['Khandadevi','Ramechhap'],
            ['Likhu Tamakoshi','Ramechhap'],
            ['Doramba','Ramechhap'],
            ['Gokulganga','Ramechhap'],
            ['Sunapati','Ramechhap'],
            ['Umakunda','Ramechhap'],
            ['Naukunda','Rasuwa'],
            ['Kalika','Rasuwa'],
            ['Uttargaya','Rasuwa'],
            ['Gosaikund','Rasuwa'],
            ['Aamachodingmo','Rasuwa'],
            ['Tinpatan','Sindhuli'],
            ['Marin','Sindhuli'],
            ['Hariharpurgadhi','Sindhuli'],
            ['Sunkoshi','Sindhuli'],
            ['Golanjor','Sindhuli'],
            ['Phikkal','Sindhuli'],
            ['Ghyanglekh','Sindhuli'],
            ['Indrawati','Sindhupalchok'],
            ['Panchpokhari Thangpal','Sindhupalchok'],
            ['Jugal','Sindhupalchok'],
            ['Balephi','Sindhupalchok'],
            ['Helambu','Sindhupalchok'],
            ['Bhotekoshi','Sindhupalchok'],
            ['Sunkoshi','Sindhupalchok'],
            ['Lisankhu Pakhar','Sindhupalchok'],
            ['Tripurasundari','Sindhupalchok'],

            ['Badigad','Baglung'],
            ['Kathekhola','Baglung'],
            ['Nisikhola','Baglung'],
            ['Bareng','Baglung'],
            ['Tarakhola','Baglung'],
            ['Tamankhola','Baglung'],
            ['Shahid Lakhan','Gorkha'],
            ['Barpak Sulikot','Gorkha'],
            ['Aarughat','Gorkha'],
            ['Siranchowk','Gorkha'],
            ['Gandaki','Gorkha'],
            ['Bhimsen Thapa','Gorkha'],
            ['Ajirkot','Gorkha'],
            ['Dharche','Gorkha'],
            ['Tsum Nubri','Gorkha'],
            ['Annapurna','Kaski'],
            ['Machhapuchhre','Kaski'],
            ['Madi','Kaski'],
            ['Rupa','Kaski'],
            ['Marsyangdi','Lamjung'],
            ['Dordi','Lamjung'],
            ['Dudhpokhari','Lamjung'],
            ['Kwaholasothar','Lamjung'],
            ['Manang Disyang','Manang'],
            ['Nason','Manang'],
            ['Chame','Manang'],
            ['Narpa Bhumi','Manang'],
            ['Gharapjhong','Mustang'],
            ['Thasang','Mustang'],
            ['Baragung Muktichhetra','Mustang'],
            ['Lomanthang','Mustang'],
            ['Lo-Ghekar Damodarkunda','Mustang'],
            ['Malika','Myagdi'],
            ['Mangala','Myagdi'],
            ['Raghuganga','Myagdi'],
            ['Dhaulagiri','Myagdi'],
            ['Annapurna','Myagdi'],
            ['Hupsekot','Nawalpur'],
            ['Binayi Triveni','Nawalpur'],
            ['Bulingtar','Nawalpur'],
            ['Baudikali','Nawalpur'],
            ['Jaljala','Parbat'],
            ['Modi','Parbat'],
            ['Paiyun','Parbat'],
            ['Bihadi','Parbat'],
            ['Mahashila','Parbat'],
            ['Kaligandaki','Syangja'],
            ['Biruwa','Syangja'],
            ['Harinas','Syangja'],
            ['Aandhikhola','Syangja'],
            ['Arjun Chaupari','Syangja'],
            ['Phedikhola','Syangja'],
            ['Rishing','Tanahun'],
            ['Myagde','Tanahun'],
            ['Aanbu Khaireni','Tanahun'],
            ['Bandipur','Tanahun'],
            ['Ghiring','Tanahun'],
            ['Devghat','Tanahun'],

            ['Malarani','Arghakhanchi'],
            ['Panini','Arghakhanchi'],
            ['Chhatradev','Arghakhanchi'],
            ['Raptisonari','Banke'],
            ['Baijanath','Banke'],
            ['Khajura','Banke'],
            ['Janaki','Banke'],
            ['Duduwa','Banke'],
            ['Narainapur','Banke'],
            ['Badhaiyatal','Bardiya'],
            ['Geruwa','Bardiya'],
            ['Rapti','Dang'],
            ['Gadhawa','Dang'],
            ['Babai','Dang'],
            ['Shantinagar','Dang'],
            ['Rajpur','Dang'],
            ['Banglachuli','Dang'],
            ['Dangisharan','Dang'],
            ['Satyawati','Gulmi'],
            ['Dhurkot','Gulmi'],
            ['Gulmi Darbar','Gulmi'],
            ['Madane','Gulmi'],
            ['Chandrakot','Gulmi'],
            ['Malika','Gulmi'],
            ['Chhatrakot','Gulmi'],
            ['Isma','Gulmi'],
            ['Kaligandaki','Gulmi'],
            ['Ruru','Gulmi'],
            ['Mayadevi','Kapilvastu'],
            ['Suddhodhan','Kapilvastu'],
            ['Yasodhara','Kapilvastu'],
            ['Bijaynagar','Kapilvastu'],
            ['Susta','Parasi'],
            ['Pratappur','Parasi'],
            ['Sarawal','Parasi'],
            ['Palhinandan','Parasi'],
            ['Rainadevi Chhahara','Palpa'],
            ['Mathagadhi','Palpa'],
            ['Nisdi','Palpa'],
            ['Bagnaskali','Palpa'],
            ['Rambha','Palpa'],
            ['Purbakhola','Palpa'],
            ['Tinau','Palpa'],
            ['Ribdikot','Palpa'],
            ['Naubahini','Pyuthan'],
            ['Jhimruk','Pyuthan'],
            ['Gaumukhi','Pyuthan'],
            ['Airawati','Pyuthan'],
            ['Sarumarani','Pyuthan'],
            ['Mallarani','Pyuthan'],
            ['Mandavi','Pyuthan'],
            ['Sunilsmriti','Rolpa'],
            ['Runtigadhi','Rolpa'],
            ['Lungri','Rolpa'],
            ['Triveni','Rolpa'],
            ['Paribartan','Rolpa'],
            ['Gangadev','Rolpa'],
            ['Madi','Rolpa'],
            ['Sunchhahari','Rolpa'],
            ['Thabang','Rolpa'],
            ['Bhume','Eastern Rukum'],
            ['Putha Uttarganga','Eastern Rukum'],
            ['Sisne','Eastern Rukum'],
            ['Gaidhawa','Rupandehi'],
            ['Mayadevi','Rupandehi'],
            ['Kotahimai','Rupandehi'],
            ['Marchawarimai','Rupandehi'],
            ['Siyari','Rupandehi'],
            ['Sammarimai','Rupandehi'],
            ['Rohini','Rupandehi'],
            ['Shuddhodhan','Rupandehi'],
            ['Omsatiya','Rupandehi'],
            ['Kanchan','Rupandehi'],

        ['Gurans','Dailekh'],
        ['Bhairabi','Dailekh'],
        ['Naumule','Dailekh'],
        ['Mahabu','Dailekh'],
        ['Thantikandh','Dailekh'],
        ['Bhagawatimai','Dailekh'],
        ['Dungeshwar','Dailekh'],
        ['Mudkechula','Dolpa'],
        ['Kaike','Dolpa'],
        ['She Phoksundo','Dolpa'],
        ['Jagadulla','Dolpa'],
        ['Dolpo Buddha','Dolpa'],
        ['Chharka Tangsong','Dolpa'],
        ['Simkot','Humla'],
        ['Sarkegad','Humla'],
        ['Adanchuli','Humla'],
        ['Kharpunath','Humla'],
        ['Tanjakot','Humla'],
        ['Chankheli','Humla'],
        ['Namkha','Humla'],
        ['Junichande','Jajarkot'],
        ['Kushe','Jajarkot'],
        ['Barekot','Jajarkot'],
        ['Shivalaya','Jajarkot'],
        ['Tatopani','Jumla'],
        ['Patarasi','Jumla'],
        ['Tila','Jumla'],
        ['Kankasundari','Jumla'],
        ['Sinja','Jumla'],
        ['Hima','Jumla'],
        ['Guthichaur','Jumla'],
        ['Narharinath','Kalikot'],
        ['Palata','Kalikot'],
        ['Shubha Kalika','Kalikot'],
        ['Sanni Triveni','Kalikot'],
        ['Pachaljharana','Kalikot'],
        ['Mahawai','Kalikot'],
        ['Khatyad','Mugu'],
        ['Soru','Mugu'],
        ['Mugum Karmarong','Mugu'],
        ['Sani Bheri','Western Rukum'],
        ['Tribeni','Western Rukum'],
        ['Banphikot','Western Rukum'],
        ['Kumakh','Salyan'],
        ['Kalimati','Salyan'],
        ['Chhatreshwari','Salyan'],
        ['Darma','Salyan'],
        ['Kapurkot','Salyan'],
        ['Tribeni','Salyan'],
        ['Siddha Kumakh','Salyan'],
        ['Barahatal','Surkhet'],
        ['Simta','Surkhet'],
        ['Chaukune','Surkhet'],
        ['Chingad','Surkhet'],


        ['Ramaroshan','Achham'],
        ['Chaurpati','Achham'],
        ['Turmakhand','Achham'],
        ['Mellekh','Achham'],
        ['Dhankari','Achham'],
        ['Bannigadi Jayagad','Achham'],
        ['Dogdakedar','Baitadi'],
        ['Dilashaini','Baitadi'],
        ['Sigas','Baitadi'],
        ['Pancheshwar','Baitadi'],
        ['Surnaya','Baitadi'],
        ['Shivanath','Baitadi'],
        ['Kedarsyu','Bajhang'],
        ['Thalara','Bajhang'],
        ['Bitthadchir','Bajhang'],
        ['Chhabis Pathibhera','Bajhang'],
        ['Khaptad Chhanna','Bajhang'],
        ['Masta','Bajhang'],
        ['Durgathali','Bajhang'],
        ['Talkot','Bajhang'],
        ['Surma','Bajhang'],
        ['Saipal','Bajhang'],
        ['Khaptad Chhededaha','Bajura'],
        ['Swami Kartik Khapar','Bajura'],
        ['Jagannath','Bajura'],
        ['Himali','Bajura'],
        ['Gaumul','Bajura'],
        ['Navadurga','Dadeldhura'],
        ['Aalitaal','Dadeldhura'],
        ['Ganyapadhura','Dadeldhura'],
        ['Bhageshwar','Dadeldhura'],
        ['Ajaymeru','Dadeldhura'],
        ['Naugad','Darchula'],
        ['Malikarjun','Darchula'],
        ['Marma','Darchula'],
        ['Lekam','Darchula'],
        ['Duhun Rural Municipality','Darchula'],
        ['Vyans (Byans)','Darchula'],
        ['Api Himal','Darchula'],
        ['Aadarsha','Doti'],
        ['Purbichauki','Doti'],
        ['K.I. Singh','Doti'],
        ['Jorayal','Doti'],
        ['Sayal','Doti'],
        ['Bogatan-Phudsil','Doti'],
        ['Badikedar','Doti'],
        ['Janaki','Kailali'],
        ['Kailari','Kailali'],
        ['Joshipur','Kailali'],
        ['Bardagoriya','Kailali'],
        ['Mohanyal','Kailali'],
        ['Chure','Kailali'],
        ['Laljhadi','Kanchanpur'],
        ['Beldandi','Kanchanpur'],

            ['Kathmandu','Kathmandu'],
            ['Pokhara','Kaski'],
            ['Bharatpur','Chitwan'],
            ['Lalitpur','Lalitpur'],
            ['Birgunj','Parsa'],
            ['Biratnagar','Morang'],
            ['Dhangadhi','Kailali'],
            ['Ghorahi','Dang'],
            ['Itahari','Sunsari'],
            ['Hetauda','Makawanpur'],
            ['Janakpur','Dhanusha'],
            ['Butwal','Rupandehi'],
            ['Tulsipur','Dang'],
            ['Dharan','Sunsari'],
            ['Nepalgunj','Banke'],
            ['Kalaiya','Bara'],
            ['Jitpursimara','Bara'],
            ['Budhanilkantha','Kathmandu'],
            ['Birendranagar','Surkhet'],
            ['Tarakeshwar','Kathmandu'],
            ['Gokarneshwar','Kathmandu'],
            ['Tilottama','Rupandehi'],
            ['Suryabinayak','Bhaktapur'],
            ['Chandragiri','Kathmandu'],
            ['Tokha','Kathmandu'],
            ['Kageshwari-Manohara','Kathmandu'],
            ['Mechinagar','Jhapa'],
            ['Bhimdatta','Kanchanpur'],
            ['Sundar Haraincha','Morang'],
            ['Madhyapur Thimi','Bhaktapur'],
            ['Mahalaxmi','Lalitpur'],
            ['Birtamod','Jhapa'],
            ['Nagarjun','Kathmandu'],
            ['Damak','Jhapa'],
            ['Triyuga','Udayapur'],
            ['Lahan','Siraha'],
            ['Godawari','Lalitpur'],
            ['Kohalpur','Banke'],
            ['Tikapur','Kailali'],
            ['Siraha','Siraha'],
            ['Bhaktapur','Bhaktapur'],
            ['Godawari','Kailali'],
            ['Barahachhetra','Sunsari'],
            ['Kapilvastu','Kapilvastu'],
            ['Lamki Chuha','Kailali'],
            ['Ghodaghodi','Kailali'],
            ['Banganga','Kapilvastu'],
            ['Lumbini Sanskritik','Rupandehi'],
            ['Chandrapur','Rautahat'],
            ['Vyas','Tanahun'],
            ['Ratnanagar','Chitwan'],
            ['Barahathwa','Sarlahi'],
            ['Rajbiraj','Saptari'],
            ['Barbardiya','Bardiya'],
            ['Shivaraj','Kapilvastu'],
            ['Gulariya','Bardiya'],
            ['Gaushala','Mahottari'],
            ['Bardibas','Mahottari'],
            ['Belbari','Morang'],
            ['Kirtipur','Kathmandu'],
            ['Bhadrapur','Jhapa'],
            ['Dudhauli','Sindhuli'],
            ['Kamalamai','Sindhuli'],
            ['Buddhabhumi','Kapilvastu'],
            ['Shivasatakshi','Jhapa'],
            ['Inaruwa','Sunsari'],
            ['Siddharthanagar','Rupandehi'],
            ['Pathari-Shanischare','Morang'],
            ['Kawasoti','Nawalpur'],
            ['Krishnanagar','Kapilvastu'],
            ['Arjundhara','Jhapa'],
            ['Ishwarpur','Sarlahi'],
            ['Rajapur','Bardiya'],
            ['Ramgram','Parasi'],
            ['Lalbandi','Sarlahi'],
            ['Gaindakot','Nawalpur'],
            ['Jaleshwar','Mahottari'],
            ['Nilkantha','Dhading'],
            ['Baglung','Baglung'],
            ['Rapti','Chitwan'],
            ['Suryodaya','Ilam'],
            ['Krishnapur','Kanchanpur'],
            ['Duhabi','Sunsari'],
            ['Katari','Udayapur'],
            ['Khairhani','Chitwan'],
            ['Bansgadhi','Bardiya'],
            ['Sainamaina','Rupandehi'],
            ['Banepa','Kavrepalanchok'],
            ['Changunarayan','Bhaktapur'],
            ['Sunwal','Parasi'],
            ['Bardghat','Parasi'],
            ['Ratuwamai','Morang'],
            ['Gauriganga','Kailali'],
            ['Maharajganj','Kapilvastu'],
            ['Urlabari','Morang'],
            ['Mahagadhimai','Bara'],
            ['Bidur','Nuwakot'],
            ['Madhyabindu','Nawalpur'],
            ['Punarbas','Kanchanpur'],
            ['Belauri','Kanchanpur'],
            ['Devdaha','Rupandehi'],
            ['Gauradaha','Jhapa'],
            ['Rangeli','Morang'],
            ['Bhajani','Kailali'],
            ['Ramdhuni','Sunsari'],
            ['Waling','Syangja'],
            ['Golbazar','Siraha'],
            ['Sunawarshi','Morang'],
            ['Garuda','Rautahat'],
            ['Tansen','Palpa'],
            ['Mirchaiya','Siraha'],
            ['Simraungadh','Bara'],
            ['Manara Shiswa','Mahottari'],
            ['Bedkot','Kanchanpur'],
            ['Kalyanpur','Siraha'],
            ['Gorkha','Gorkha'],
            ['Phidim','Panchthar'],
            ['Chaudandigadhi','Udayapur'],
            ['Ilam','Ilam'],
            ['Shuklagandaki','Tanahun'],
            ['Godaita','Sarlahi'],
            ['Lamahi','Dang'],
            ['Dhangadimai','Siraha'],
            ['Rupakot Majhuwagadhi','Khotang'],
            ['Shuklaphanta','Kanchanpur'],
            ['Bhangaha','Mahottari'],
            ['Paunauti','Kavrepalanchok'],
            ['Gujara','Rautahat'],
            ['Malangwa','Sarlahi'],
            ['Chautara Sangachokgadhi','Sindhupalchok'],
            ['Madhuwan','Bardiya'],
            ['Sabaila','Dhanusha'],
            ['Bhanu','Tanahun'],
            ['Hanumannagar Kankalini','Saptari'],
            ['Dhanushadham','Dhanusha'],
            ['Manthali','Ramechhap'],
            ['Khadak','Saptari'],
            ['Melamchi','Sindhupalchok'],
            ['Balara','Sarlahi'],
            ['Mithila','Dhanusha'],
            ['Putalibazar','Syangja'],
            ['Dakneshwari','Saptari'],
            ['Thakurbaba','Bardiya'],
            ['Surunga','Saptari'],
            ['Hariwan','Sarlahi'],
            ['Gurbhakot','Surkhet'],
            ['Sitganga','Arghakhanchi'],
            ['Bodebarsain','Saptari'],
            ['Kolhabi','Bara'],
            ['Shahidnagar','Dhanusha'],
            ['Brindaban','Rautahat'],
            ['Devchuli','Nawalpur'],
            ['Chhireshwarnath','Dhanusha'],
            ['Belaka','Udayapur'],
            ['Balawa','Mahottari'],
            ['Kabilasi','Sarlahi'],
            ['Kalika','Chitwan'],
            ['Thaha','Makawanpur'],
            ['Dullu','Dailekh'],
            ['Ishnath','Rautahat'],
            ['Bheriganga','Surkhet'],
            ['Sandhikharka','Arghakhanchi'],
            ['Rajpur','Rautahat'],
            ['Gadhimai','Rautahat'],
            ['Bagmati','Sarlahi'],
            ['Kankai','Jhapa'],
            ['Belkotgadhi','Nuwakot'],
            ['Bahudarmai','Parsa'],
            ['Kushma','Parbat'],
            ['Loharpatti','Mahottari'],
            ['Besisahar','Lamjung'],
            ['Mahakali','Kanchanpur'],
            ['Purchaudi','Baitadi'],
            ['Hansapur','Dhanusha'],
            ['Kamala','Dhanusha'],
            ['Pyuthan','Pyuthan'],
            ['Katahariya','Rautahat'],
            ['Palungtar','Gorkha'],
            ['Parsagadhi','Parsa'],
            ['Shambhunath','Saptari'],
            ['Panchkhal','Kavrepalanchok'],
            ['Madi','Chitwan'],
            ['Sukhipur','Siraha'],
            ['Paroha','Rautahat'],
            ['Haripur','Sarlahi'],
            ['Ganeshman Charanath','Dhanusha'],
            ['Galyang','Syangja'],
            ['Dhankuta','Dhankuta'],
            ['Phatuwa Bijayapur','Rautahat'],
            ['Baudhimai','Rautahat'],
            ['Bangad Kupinde','Salyan'],
            ['Haripurwa','Sarlahi'],
            ['Rampur','Palpa'],
            ['Chhedagad','Jajarkot'],
            ['Kanchanrup','Saptari'],
            ['Parshuram','Dadeldhura'],
            ['Nagarain','Dhanusha'],
            ['Dasharathchand','Baitadi'],
            ['Nijgadh','Bara'],
            ['Madhav Narayan','Rautahat'],
            ['Gaur','Rautahat'],
            ['Pacharauta','Bara'],
            ['Bagchaur','Salyan'],
            ['Sanphebagar','Achham'],
            ['Shaarda','Salyan'],
            ['Aathabiskot','Western Rukum'],
            ['Mithila Bihari','Dhanusha'],
            ['Bheri','Jajarkot'],
            ['Beni','Myagdi'],
            ['Bungal','Bajhang'],
            ['Galkot','Baglung'],
            ['Dipayal Silgadhi','Doti'],
            ['Musikot','Western Rukum'],
            ['Deumai','Ilam'],
            ['Pokhariya','Parsa'],
            ['Musikot','Gulmi'],
            ['Rolpa','Rolpa'],
            ['Mandandeupur','Kavrepalanchok'],
            ['Bhumikasthan','Arghakhanchi'],
            ['Mai','Ilam'],
            ['Resunga','Gulmi'],
            ['Mangalsen','Achham'],
            ['Bideha','Dhanusha'],
            ['Panchapuri','Surkhet'],
            ['Dhulikhel','Kavrepalanchok'],
            ['Dewahi Gonahi','Rautahat'],
            ['Letang Bhogateni','Morang'],
            ['Shikhar','Doti'],
            ['Aurahi','Mahottari'],
            ['Shadanand','Bhojpur'],
            ['Bhimeshwar','Dolakha'],
            ['Jaimini','Baglung'],
            ['Bhimad','Tanahun'],
            ['Rajdevi','Rautahat'],
            ['Khandbari','Sankhuwasabha'],
            ['Dhunibeshi','Dhading'],
            ['Matihani','Mahottari'],
            ['Karjanha','Siraha'],
            ['Swargadwari','Pyuthan'],
            ['Patan','Baitadi'],
            ['Lekbeshi','Surkhet'],
            ['Ramgopalpur','Mahottari'],
            ['Halesi Tuwachung','Khotang'],
            ['Namobuddha','Kavrepalanchok'],
            ['Aathabis','Dailekh'],
            ['Ramechhap','Ramechhap'],
            ['Siddhicharan','Okhaldhunga'],
            ['Panchadewal Binayak','Achham'],
            ['Chaurjahari','Western Rukum'],
            ['Chainpur','Sankhuwasabha'],
            ['Bhojpur','Bhojpur'],
            ['Narayan','Dailekh'],
            ['Sundarbazar','Lamjung'],
            ['Barhabise','Sindhupalchok'],
            ['Maulapur','Rautahat'],
            ['Taplejung(Phungling)','Taplejung'],
            ['Dhorpatan','Baglung'],
            ['Chamunda Bindrasaini','Dailekh'],
            ['Chapakot','Syangja'],
            ['Nalgad','Jajarkot'],
            ['Bhirkot','Syangja'],
            ['Shankharapur','Kathmandu'],
            ['Mahalaxmi','Dhankuta'],
            ['Phalewas','Parbat'],
            ['Dakshinkali','Kathmandu'],
            ['Kamalbazar','Achham'],
            ['Madhya Nepal','Lamjung'],
            ['Melauli','Baitadi'],
            ['Jaya Prithvi','Bajhang'],
            ['Pakhribas','Dhankuta'],
            ['Shailyashikhar','Darchula'],
            ['Budhiganga','Bajura'],
            ['Amargadhi','Dadeldhura'],
            ['Mahakali','Darchula'],
            ['Saptakoshi','Saptari'],
            ['Solu Dudhkunda','Solukhumbu'],
            ['Khandachakra','Kalikot'],
            ['Chhayanath Rara','Mugu'],
            ['Myanglung','Terhathum'],
            ['Chandannath','Jumla'],
            ['Budhinanda','Bajura'],
            ['Rainas','Lamjung'],
            ['Tribeni','Bajura'],
            ['Dharmadevi','Sankhuwasabha'],
            ['Panchkhapan','Sankhuwasabha'],
            ['Laligurans','Terhathum'],
            ['Badimalika','Bajura'],
            ['Raskot','Kalikot'],
            ['Tilagupha','Kalikot'],
            ['Jiri','Dolakha'],
            ['Madi','Sankhuwasabha'],
            ['Tripura Sundari','Dolpa'],
            ['Thuli Bheri','Dolpa'],


        ];

        foreach ($data as $datum) {
            $district = District::where('name',$datum[1])->first();
            $municipality = new Municipality();
            $municipality->name = $datum[0];
            $municipality->district_id = $district->id;
            $municipality->identifier = strtolower(str_replace(' ','_',$district->name)).'_'.strtolower(str_replace(' ','_',$datum[0]));
            $municipality->save();
        }
    }
}