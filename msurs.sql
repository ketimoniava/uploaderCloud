-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2014 at 02:39 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `msurs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `user_password` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `mail_address` varchar(150) NOT NULL,
  `video_name` varchar(70) NOT NULL,
  `keywords` text NOT NULL,
  `site_description` text NOT NULL,
  `title_geo` varchar(100) NOT NULL,
  `title_eng` varchar(100) NOT NULL,
  `language_visibility` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_password`, `user`, `mail_address`, `video_name`, `keywords`, `site_description`, `title_geo`, `title_eng`, `language_visibility`) VALUES
(1, 'bbad8d72c1fac1d081727158807a8798', 'admin', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `tablename` varchar(20) NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `horizontal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vertical` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `tablename`, `sort`, `horizontal`, `vertical`) VALUES
(1, 'სიახლეები', 'media', 0, 1, 0),
(3, 'ჩვენს შესახებ', 'common', 0, 1, 0),
(5, 'კონტაქტი', 'contacts', 0, 1, 1),
(105, 'ბრენდები', 'brands', 0, 1, 1),
(104, 'users', 'users', 0, 0, 0),
(103, 'პროდუქცია', 'products', 0, 1, 1),
(2, 'აუქციონის შესახებ', 'common', 0, 0, 0),
(109, 'ხშირად დასმული შეკითხვები', 'common', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `common`
--

CREATE TABLE IF NOT EXISTS `common` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pagetitle` varchar(100) NOT NULL,
  `bodytext` text NOT NULL,
  `published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hasphoto` tinyint(1) unsigned NOT NULL,
  `categoryid` tinyint(3) unsigned NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `common`
--

INSERT INTO `common` (`id`, `pagetitle`, `bodytext`, `published`, `hasphoto`, `categoryid`, `sort`) VALUES
(1, 'აუქციონის შესახებ', 'auction.service.ge გახლავთ პირველი კერძო ინტერნეტ აუქციონი საქართველოში.  აუქციონის დამფუძნებელია შპს „ქვანტუმ გრუფი“. 2005 წელიდან კომპანია ახორციელებს სხვადასხვა ტექნოლოგიურ პროექტებს.აუქციონში მონაწილეობის წესები მაქსიმალურად არის გამარტივებული და ხელმისაწვდომი ყველა კატეგორიის მომხმარებლისთვის. ამჟამად აუქციონზე ლოტების განთავსდება ხდება მხოლოდ საიტის ადმინისტრატორის მეშვეობით. მომავალში გათვალისწინებულია, რომ რეგისტრირებულმა მომხმარებელმა თავად განათავსოს ლოტი აუქციონზე. გთხოვთ მოგვაწოდოთ თქვენი შენიშვნები და რეკომენდაციები მისამართზე: auction@service.ge ;', '2013-02-04 20:44:39', 1, 2, 9),
(40, 'როგორ განვათავსო ლოტი აუქციონზე?', 'ამჟამად ლოტის აუქციონზე განთავსება ხდება მხოლოდ აუქციონის ადმინისტრატორის მეშვეობით. გააგზავნეთ თქვენი მოთხოვნა მისამართზე auction@service.ge, მიუთითეთ წერილში თქვენი საკონტაქტო მონაცემები და მაქსილურად ამომწურავი ინფორმაცია ლოტის შესახებ.', '2013-03-01 00:52:38', 0, 109, 8),
(4, 'მაქსიმალური განაცხადი', '<p>მაქსიმალური განაცხადის დაფიქსირება შეუძლია საიტზე  დარეგისტრირებულ ნებისმიერ მომხმარებელს აუქციონზე გამოტანილ ნებისმიერ ლოტზე.</p>    <p>მაქსიმალური განაცხადის მაქსიმალური ზღვარი არ არსებობს,  მინიმალური კი არის ლოტზე ბოლოს დაფიქსირებულ განაცხადს + ბიჯი + 1, მაგ: აუციონზე  ბოლო განაცხადია  20 ლარი თუ აუქციონის ბიჯია  5 ლარი, მაშინ მაქსიმალური განაცხადის მინიმალური თანხა იქნება 26 ლარი (20+5+1). ამ  შემთხვევაში თუ თმომხმარებელი აუქციონზე გააკეთებს უფრო მეტი თანხის შეთავაზებას, საიტი  თქვენს ნაცვლად ავტომატურად გააკეთებს განაცხადს სხვა მომხმარებლის მიერ განაცხადის  დაფიქსირების შემთხვევაში და მომხმარებელი იქნება ტოპ განმცხადებელი, მანამ, სანამ  არ ამოიწურება მის მიერ მაქსიმალურ განაცხადზე დაფიქსირებული თანხა. </p>        <p>მაქსიმალური  განაცხადის უპირატესობები</p>    <p>მაქსიმალური განაცხადის დაფიქსირება მომხმარებლის მხრიდან,  მობილურს ხდის აუქციონის მსვლელობას და ამით აუქციონის მონაწილეს აძლევს შესაძლებლობას  საიტზე მისი არყოფნის შემთხვევაშიც კი, განათავსოს განაცხადი.</p>    <p>გაითვალისწინეთ!!!  აუქციონზე  დაფიქსირებული განაცხადის შეცვლა არ არის შესაძლებელი, ამიტომ მიუთითეთ ზუსტად ის თანხა  რის გადახდასაც აპირებთ.</p>    <p>აუქციონის დასრულებისას გამარჯვებული მომხმარებელი იხდის  ბოლოს დაფიქსირებული განაცხადის შესაბამის თანხას და არა მაქსიმალური განაცხადის ველში  მითითებულ თანხას. მაგ: მომხმარებელს აუქციონზე დაფიქსირებული აქვს 50 ლარი, და მაქსიმალური  განაცხადის ველში 100 ლარი, ზემოთ აღნიშნული აუქციონის წესების თანახმად, აუქციონის  დასრულებისას იხდის 50 ლარს და არა 100 ლარს. იმის მიუხედავად, არის თუ არა მაქსიმალური  განაცხადი დაფიქსირებული რომელიმე მომხმარებლის მხრიდან, მიმდინარე განაცხადი თუ არ  აღემატება რეზერვირებულ თანხას აუქციონს გამარჯვებული არ ეყოლება.</p>    <p>ასევე გაითვალისწინეთ!!! მომხმარებლის მხრიდან დაფიქსირებულ მაქსიმალურ განაცხადს  სხვა მომხმარებლები ვერ ხედავენ, ჩვეულებრივ ლოტის დეტალურ გვერდზე ჩანს მხოლოდ მიმდინარე  განაცხადები, ამის გამო მომხმარებლის მხრიდან განაცხადის განთავსების პროცესში, გამოვა  შეტყობინება არასაკმარისი თანხა, თუნდაც საიტზე მითითებულ თანხას უთითებდეს აუქციონის  მონაწილე. ამის მიუხედავად, განაცხადი მაინც განთავსდება, თუმცა მას შემდეგ დაფიქსირებული  იქნება ავტომატური განაცხადი, რომლის ოდენობაც ერთი ბიჯით აღემატება მიმდინარე განაცხადს.</p>    <p>უკვე დაფიქსირებული მაქსიმალური განაცხადის  გაუქმება არ არის შესაძლებელი ისევე, როგორც მიმდინარე განაცხადის.</p>', '2013-02-28 21:13:36', 0, 2, 2),
(29, 'განაცხადის გაკეთება აუქციონზე', '<p><p>ავტორიზებულ მომხმარებლებს აუქციონის მსვლელობისას ლოტის  დეტალურ გვერდზე შესაძლებლობა აქვს გააკეთოს განაცხადი და ის გახდეს ტოპ განმცხადებელი.  განაცხადის ფორმაზე არის მოცემული ის მინიმალური თანხა, რომლის მითითების შემთხვევაშიც  განაცხადი განთავსდება საიტზე და დაფიქსირდება განაცხადების დეტალურ გვერდზე. თანხა  მოცემულია ლარებში და არა სხვა რომელიმე ვალუტაში. განაცხადის მაქსიმალური ზღვარი დაფიქსირებული  არ არის, რაც ნიშნავს იმას, რომ მინიმალურ ნიშნულზე ზევით თანხის ნებისმიერი ოდენობის  დაფიქსირება შეუძლია მომხმარებელს.</p>    <p>გაითვალისწინეთ!!! დაფიქსირებული განაცხადის გაუქმება არ არის შესაძლებელი.</p>    <p>შესრულებულ ოპერაციაზე (განაცხადის დაფიქსირება) მომხმარებელი  იღებს შეტყობინებას, როგორც მეილზე ასევე მობილური ტელეფონის იმ ნომერზე, რომელიც მითითებული  აქვს სარეგისტრაციო ველში.</p></p>', '2013-01-16 18:42:09', 0, 2, 4),
(31, 'ლოტის ღირებულების გადახდა/ანგარიშსწორება', '<p><p>აუქციონში  გამარჯვების შემთხვევაში</p>    <ol>   <li>მომხმარებელმა მის ბალანსზე უნდა იქონიოს ლოტის       ღირებულების გადასახდელათ საკმარისი თანხა, რათა მოხდეს თანხის ჩამოჭრა მისი ანგარიშიდან       ან გადაიხადოს ლოტის ღირებულება 10 დღის ვადაში;</li>   <li>საიტის ადმინისტრაცია ვალდებულია გადახდის შემთხვევაში       მიაწოდოს მომხმარებელს მისი კუთვნილი ლოტი 3 სამუშაო დღის ვადაში;</li>  </ol>    <p>აუქციონზე გამარჯვების შემთხვევაში მომხმარებელს უფლება  აქვს არ გადაიხადოს ლოტის სრული ღირებულება ან უკან მოითხოვოს გადახდილი თანხა თუ:</p>    <ol>   <li>საიტზე არსებული წესები დაირღვევა საიტის ადმინისტრაციის       მხრიდან;</li>   <li>ადმინისტრაცია შეცვლის ლოტის დეტალურ გვერდზე არსებულ       მახასიათებლებს;</li>   <li>ადმინისტრაცია დაარღვევს ლოტის მიწოდების პირობებს;</li>   <li>თუ საიტზე არსებული მახასიათებლები არ დაემთხვევა       მიღებული ლოტის მახასიათებლებს;</li>  </ol></p>', '2013-01-16 18:40:47', 0, 2, 3),
(32, 'განაცხადების ისტორია', '<p>  \r\n <p>ავტორიზებულ მომხმარებელს, აუქციონის მსვლელობისას,   აქვს შესაძლებლობა იხილოს ყველა განაცხადი,  რომელიც დაფიქსირებულია მიმდინარე აუქციონზე. აუქციონის განაცხადები წარმოდგენილია   ცხრილის სახით, სადაც არის მითითებული მომხმარებლის  სახელი (დაშიფრულად, მისივე უსაფრთხოების მიზნით), განაცხადის ოდენობა(თანხა გამოიხატება  ლარებში) და განაცხადის განთავსების თარიღი. ავტომატური განაცხადები მოცემულია განსხვავებული  ფერით. ამავე გვერდზე არის შესაძლებელი თქვენი მაქსიმალური განაცხადის დაფიქსირება.</p>\r\n</p>', '2013-01-18 21:38:46', 0, 2, 5),
(33, 'აუქციონის წესები', '<p>აუქციონში მონაწილეობის მისაღებად, უკვე რეგისტრირებული მომხმარებელი ირჩევს მისთვის სასურველ ლოტს განაცხადის ველში, რომელიც განთავსებულია ლოტის დეტალურ გვერდზე, უთითებს თანხის ოდენობას და ღილაკზე მაუსის დაკლიკებით აკეთებს განაცხადს. თანხის მინიმალური ოდენობა, რომლის დაფიქსირებაც შეუძლია მომხმარებელს,აუცილებლად არის მოცემული იმავე გვერდზე, სადაც ხდება განაცხადის გაკეთება, თუმცა მომხმარებელს ამ თანხის გაზრდაც შეუძლია. უფრო დეტალურად იხილეთ განაცხადის გაკეთება</p>    <p>გამარჯვებული მომხმარებელი ვლინდება მას შემდეგ, რაც აუქციონის დასრულებამდე მითითებული ვადა ამოიწურება.</p>    <p>ვადის ამოწურვის შემდგომ, ბოლო განმცხადებელი - მაქსიმალური განაცხადის ავტორი არის აუქციონის გამარჯვებული, თუ ეს განაცხადი აღემატება რეზერვირებულ თანხას (აუქციონის რეზერვირების შემთხვევაში).</p>   <p>აუქციონის ტიპები:  რეზერვირებული და არარეზერვირებული</p>  <p>რეზერვირებულია აუქციონი იმ შემთხვევაში, თუ ლოტის ღირებულების მინიმალური ზღვარი არის დაწესებული, თუ აუქციონზე ბოლოს დაფიქსირებული განაცხადი არ აღემატება მინიმალურ ღირებულებას, აუქციონს გამარჯვებული არ ეყოლება, ლოტის მინიმალურ ღირებულებას ადგენს საიტის ადმინისტრაცია თითოეული ლოტის განთავსებისას, მაგრამ მისი ნახვა აუქციონის დასრულებამდე არ არის შესაძლებელი. ლოტის დეტალურ გვერდზე მხოლოდ აუქციონის ტიპია მოცემული.</p>   <p>არარეზერვირების შემთხვევაში ლოტის გაყიდვა ნებისმიერ ფასად არის შესაძლებელი, ბოლო განმცხადებელი აუქციონის დასრულებისას ავტომატურად ხდება აუქციონის გამარჯვებული.</p>     <p>იმ შემთხვევაში, თუ ვადის ამოწურვამდე, აუქციონის მსვლელობისას განაცხადი არ დაფიქსირდა,  ადმინისტრაცია იტოვებს უფლებას ლოტი მოხსნას აუქციონიდან  ან ხელახლა გამოაცხადოს აუქციონი ახალი პირობების მითითებით. </p>', '2013-03-01 00:58:41', 0, 2, 1),
(34, 'საიტის ადმინისტრაციის მოვალეობები', '<p><p>საიტის ადმინისტრაციას ეკრძალება:</p>    <ol>   <li>აუქციონის მიმდინარეობის პროცესში შეცვალოს აუქციონის       ვადები (იგულისხმება დასრულების ვადა) - გაგრძელების ან შემცირების       მიზნით;</li>   <li>შეცვალოს ლოტის ძირითადი მახასიათებლები;</li>   <li>შეწყვიტოს აუქციონი ვადის ამოწურვამდე;</li>   <li>აუქციონის წესების თანახმად აუქციონში გამარჯვებულ       მომხმარებელს, ღირებულების გადახდის შემდგომ არ მიაწოდოს მისი კუთვნილი ლოტი დათქმულ       ვადებში;</li>   <li>შეცვალოს მომხმარებლის პირადი მონაცემები ან გადასცეს       მესამე პირს(გარდა სახელმწიფო კანონმდებლობით დადგენილი წესებისა);</li>   <li>გააუქმოს მომხმარებლის გვერდი წინასწარ მომხმარებლისთვის       შეტყობინების გაგზავნის გარეშე (მეილზე ან/და სმს-ით) და საიტზე არსებული წესების       დარღვევით;</li>  </ol>        <p>საიტის ადმინისტრაციის მოვალეობები</p>    <ol>   <li>უზრუნველყოს ვებ-გვერდის უსაფრთხოება 24 საათის       განმავლობაში;</li>   <li>დროულად მოახდინოს რეაგირება საიტზე წვდომის არ       არსებობის შემთხვევაში;</li>   <li>დაიცვას მომხმარებლების კონფიდენციალობა;</li>   <li>დროულად გასცეს მომხმარებლების მხრიდან დასმულ       ყველა კითხვას პასუხი;</li>   <li>დროულად მიაწოდოს ინფორმაცია მომხმარებელს მის       მიერ გაკეთებული განაცხადების შესახებ, ეს იქნება მეილი თუ სმს შეტყობინება;</li>   <li>არ დაარღვიოს მომხმარებლის უფლებები;</li>  </ol></p>', '2013-02-28 23:18:05', 0, 2, 10),
(35, 'მომხმარებლის მოვალეობები', '<p>  <ol>    <li>აუციონის წესების თანახმად გამარჯვების შემთხვევაში გადაიხადოს ლოტის ღირებულება</li>    <li>არ გადასცეს მისი გვერდი სხვა მომხმარებელს</li>   </ol>    <p>ზემოთმდებარე წესების თანახმად საიტის ადმინისტრაცია იტოვებს უფლებას გააუქმოს მომხმარებლის გვერდი თუ მომხმარებელი დაარღვევს არსებულ წესებს.</p>   <p>მომხმარებლის უფლებები</p>   <ol>    <li>მომხმარებელს უფლება აქვს უკან მოითხოვოს მის მიერ გადახდილი თანხა ლოტის არ მიღების შემთხვევაში;</li>    <li>მოითხოვოს კუთვნილი თანხა იმ შემთხვევაში თუ მიღებული ლოტის მახასიათებლები არ ემთხვევა საიტზე არსებულ მახასიათებლებს;</li>    <li>მოითხოვოს კუთვნილი თანხა იმ შემთხვევაში თუ მიიღებს სხვა ლოტს (არა იმ ლოტს, რომელიც უნდა მიიღოს აუქციონში გამარჯვების შედეგად);</li>    <li>მოითხოვოს მისი გვერდის გაუქმება, თუ ის, რომელიმე აუქციონში არ იღებს მონაწილეობას და არ აქვს დავალიანება საიტზე;</li>    <li>გამოთქვას შენიშვნები საიტთან დაკავშირებით და მოგვაწოდოს მისი იდეები ისევ და ისევ ვებ-გვერდთან დაკავშირებით, შემდგომში მისი დახვეწის მიზნით;</li>   </ol>  </p>', '2013-02-28 21:13:32', 0, 2, 6),
(38, 'აუქციონში მონაწილეობის მიღება', '<p><p>იმისთვის, რომ აუქციონში  მიიღოთ მონაწილეობა საჭიროა დარეგისტრირდეთ საიტზე <a href="http://auction.service.ge" title="ონლაინ აუქციონი">http://auction.service.ge.</a></p>    <p>საიტზე  რეგისტრაცია</p>    <p>საიტზე რეგისტრაცია შეუძლია ყველა იმ პირს, რომლის ასაკიც  აღემატება 20 წელს ანუ არის მინიმუმ 21 წლის.</p>    <p>რეგისტრაციის პროცესი:</p>    <p>სტანდარტული ფორმა, სადაც უნდა მიუთითოთ სახელი, გვარი,  ტელეფონის ნომერი, როგორც სახლის ასევე მობილურის (აუცილებელი), მეილი (აუცილებელი),  დაბადების თარიღი, მომხმარებლის სახელი, პაროლი.</p>    <p>მომხმარებლის სახელი და მეილი უნდა იყოს უნიკალური.  ერთი და იმავე მეილით ორჯერ ან მეტჯერ ვერ დარეგისტრირდებით.</p>    <p>იმისთვის, რომ დარეგისტრირდეთ აუცილებლად უნდა შეავსოთ  ყველა სავალდებულო ველი. გთხოვთ მიუთითოთ სწორი მონაცემები, რაც პრობლების არსებობის  შემთხვევაში გააადვილებს თქვენს იდენტიფიცირებას.</p>    <p>გაითვალისწინეთ!!! არ მიუთითოთ სხვისი ტელ. ნომერი ან მეილი, რადგან რეგისტრაციის  შემდგომ თქვენ მეილზე ან/და მობილურ ტელეფონზე მიიღებთ შეტყობინებას-კოდს, რომლის მეშვეობითაც შეძლებთ სისტემაში შესვლას  და თქვენი გვერდის აქტივაციას,  სხვა შემთხვევაში ამას ვერ მოახერხებთ.</p>    <p>ავტორიზებულ მომხმარებელს შესაძლებლობა აქვს მიიღოს  მონაწილეობა ჩვენს საიტზე გამოცხადებულ ნებისმიერ აუქციონში, და გადაიხადოს ლოტის ღირებულება  გამარჯვების შემთხვევაში.  </p></p>', '2013-01-16 18:41:13', 0, 2, 7),
(41, 'ewerwer', 'werwer', '2013-02-28 23:34:28', 0, 3, 1),
(42, 'ewerwer', 'werwer', '2013-02-28 23:34:44', 0, 3, 1),
(43, 'ewerwer', 'werwer', '2013-02-28 23:35:01', 0, 3, 1),
(44, 'ewerwer', 'werwer', '2013-02-28 23:35:21', 0, 3, 10),
(45, 'sdfsdfs', 'sdfsdfsdfsdf', '2013-02-28 23:35:33', 0, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `commonphotos`
--

CREATE TABLE IF NOT EXISTS `commonphotos` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(30) NOT NULL,
  `relid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `commonphotos`
--

INSERT INTO `commonphotos` (`id`, `filename`, `relid`) VALUES
(15, '7423769.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(24) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `phone`, `email`, `address`) VALUES
(1, '3737457457', 'garcha@gio.com', 'faliashvili 634 ');

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `extension` varchar(5) CHARACTER SET ascii NOT NULL,
  `user_id` smallint(5) unsigned NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `folder` varchar(100) DEFAULT NULL COMMENT 'folder optional, because if rename folder data is unnessesary',
  `size` varchar(20) DEFAULT NULL COMMENT 'Ex: 20kb. 1.2mb. 10 bytes',
  `OK` binary(3) DEFAULT NULL COMMENT 'Optional Key, length 3',
  `comment` tinytext,
  `orig_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `name`, `extension`, `user_id`, `added`, `folder`, `size`, `OK`, `comment`, `orig_name`) VALUES
(1, 'PH-RT34wEJyHrYVM', 'jpg', 1, '2013-11-20 14:06:49', NULL, '0.73 mb', 'WSH', NULL, 'DSCN3807.JPG'),
(2, 'PH-fWQ5gvjHyrSY7', 'jpg', 1, '2013-11-20 14:07:24', NULL, '0.73 mb', 'WSH', NULL, 'DSCN3807.JPG'),
(3, 'PH-JGyd3Ezr5hQ49', 'jpg', 1, '2013-11-20 14:09:07', NULL, '0.73 mb', 'WSH', NULL, 'DSCN3807.JPG'),
(4, 'PH-PyhAqbxUndv2k', 'jpg', 1, '2013-11-20 14:09:56', NULL, '0.73 mb', 'WSH', NULL, 'DSCN3807.JPG'),
(5, 'PH-9HCGa82BNpSYA', 'jpg', 1, '2013-11-21 11:37:51', NULL, '0.224 mb', 'WSH', NULL, 'DSCN3807 - Copy.JPG'),
(6, 'PH-WyxS4gbTsnhdJ', 'jpg', 1, '2013-12-06 14:15:14', NULL, '0.101 mb', 'WSH', NULL, 'house_electro_music_wallpaper_5-3188.jpg'),
(7, 'PH-G8jQEVFfNYugs', 'jpg', 1, '2013-12-06 15:06:03', NULL, '0.03 mb', 'WSH', NULL, 'XN201 Mobile Digital Pen.JPG'),
(8, 'PH-AqQZtHG2Bf8bC', 'jpg', 1, '2014-03-25 11:23:36', NULL, '0.306 mb', 'WSH', NULL, '1274605_10203411046183458_1826044448_o.jpg'),
(9, 'PH-PfbyQxH8JFWMe', 'jpg', 1, '2014-03-25 11:23:50', NULL, '0.306 mb', 'WSH', NULL, '1274605_10203411046183458_1826044448_o.jpg'),
(10, 'PH-cpf8eXKnSkgdP', 'jpg', 1, '2014-03-25 11:25:33', NULL, '0.306 mb', 'WSH', NULL, '1274605_10203411046183458_1826044448_o.jpg'),
(11, 'PH-gqNx3SKQXMHPh', 'jpg', 1, '2014-03-25 11:27:01', NULL, '0.114 mb', 'WSH', NULL, '1238015_10202015197048102_2028785733_n.jpg'),
(12, 'PH-pq8524XMdPzUZ', 'jpg', 1, '2014-03-25 12:06:28', NULL, '0.26 mb', 'WSH', NULL, '1795928_10203391961706358_184899787_o.jpg'),
(13, 'PH-nQuscvdGYjx3M', 'jpg', 1, '2014-04-04 07:53:54', NULL, '0.024 mb', 'WSH', NULL, '13033528_02.jpg'),
(14, 'PH-76hZbnTdQfSF3', 'jpg', 1, '2014-04-04 07:54:57', NULL, '0.041 mb', 'WSH', NULL, '13065576_10-13000018_0U-13083589_02.jpg'),
(15, 'PH-wxESvkhucDad4', 'jpg', 1, '2014-04-04 07:55:49', NULL, '0.027 mb', 'WSH', NULL, '11035506_M1-13090219_02-16085520_02.jpg'),
(16, 'PH-Dum6BdbejM4AG', 'jpg', 1, '2014-04-04 08:18:31', NULL, '0.037 mb', 'WSH', NULL, '11055504_G5-11065619_03-13083589_02.jpg'),
(17, 'PH-E7k9RxbW5TGth', 'jpg', 1, '2014-04-04 08:19:02', NULL, '0.037 mb', 'WSH', NULL, '11055504_G5-11065619_03-13083589_02.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `fp`
--

CREATE TABLE IF NOT EXISTS `fp` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` tinyint(3) unsigned NOT NULL,
  `hascategoryphoto` tinyint(1) unsigned NOT NULL,
  `haseditorphoto` tinyint(3) unsigned NOT NULL,
  `fpcategoryid` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `fp`
--

INSERT INTO `fp` (`id`, `itemid`, `hascategoryphoto`, `haseditorphoto`, `fpcategoryid`) VALUES
(1, 1, 1, 0, 1),
(2, 4, 1, 0, 2),
(3, 4, 1, 0, 3),
(4, 6, 1, 0, 4),
(5, 3, 0, 0, 5),
(6, 33, 1, 0, 6),
(7, 38, 0, 0, 7),
(8, 29, 0, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `fp_categories`
--

CREATE TABLE IF NOT EXISTS `fp_categories` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `categoryid` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `fp_categories`
--

INSERT INTO `fp_categories` (`id`, `title`, `categoryid`) VALUES
(6, 'ჩვენი გუნდი', 2),
(7, 'ჩვენი პროექტები', 2),
(8, 'ღონისძიებები', 2),
(1, 'მთავარი გვერდი', 2);

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `user_id` int(10) unsigned NOT NULL,
  `friend_id` int(10) unsigned NOT NULL,
  `accept_date` date DEFAULT NULL COMMENT 'the day they connected',
  `type` enum('1','2') CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '1' COMMENT '1 = friend, 2 = block',
  UNIQUE KEY `user_friend` (`user_id`,`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE IF NOT EXISTS `friend_request` (
  `user` int(10) unsigned NOT NULL,
  `friend_id` int(10) unsigned NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `from_to` (`user`,`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friend_request`
--

INSERT INTO `friend_request` (`user`, `friend_id`, `request_date`) VALUES
(1, 3, '2013-12-29 19:01:55'),
(1, 4, '2014-01-12 21:39:06'),
(2, 13, '2014-04-03 12:43:12'),
(13, 145, '2014-04-03 12:05:49'),
(13, 180, '2014-04-03 12:20:04'),
(13, 292, '2014-04-03 12:06:32'),
(13, 311, '2014-04-03 12:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) CHARACTER SET ascii NOT NULL,
  `pass` varchar(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `mail` varchar(50) CHARACTER SET ascii DEFAULT NULL,
  `fullName` varchar(40) DEFAULT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=328 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `mail`, `fullName`, `lastLogin`) VALUES
(1, 'admin', 'pass', 'george.garcha@gmail.com', 'George Garcha', '2013-10-12 17:39:03'),
(3, 'Test2', 'testpass2', 'garchagudashvili@yahoo.com', 'Test2 User', '2013-10-12 17:39:03'),
(4, 'Test3', 'testpass3', 'garchagudashvili@yahoo.com', 'Test3 User', '2013-10-12 17:39:03'),
(327, 'Test', 'testpass', 'garchagudashvili@yahoo.com', 'George Yahoo', '2014-03-28 06:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(3) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT 'user who would see the event',
  `body` text NOT NULL COMMENT 'notification text',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` timestamp NULL DEFAULT NULL,
  `link` varchar(120) DEFAULT NULL,
  `from_user_id` int(10) unsigned NOT NULL COMMENT 'user who caused event',
  `wish_id` int(10) unsigned NOT NULL,
  `data` varchar(120) CHARACTER SET ascii DEFAULT NULL COMMENT 'To pass additional information, whaterver you like',
  PRIMARY KEY (`id`),
  KEY `wish_id` (`wish_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `type_id`, `user_id`, `body`, `created`, `seen`, `link`, `from_user_id`, `wish_id`, `data`) VALUES
(6, 2, 1, 'მეგობარმა თქვენი სურვილი მონიშნა', '2013-12-18 15:09:19', '2013-12-18 15:09:29', NULL, 2, 11, '1'),
(12, 6, 3, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2013-12-29 19:01:55', NULL, NULL, 1, 0, NULL),
(15, 6, 4, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-01-12 21:39:06', NULL, NULL, 1, 0, NULL),
(16, 1, 1, 'თქვენ დაამატეთ სურვილი', '2014-01-21 07:42:42', '2014-01-21 11:50:35', NULL, 1, 12, NULL),
(17, 1, 1, 'თქვენ დაამატეთ სურვილი', '2014-03-11 08:19:20', '2014-03-12 08:37:02', NULL, 1, 13, NULL),
(18, 1, 1, 'თქვენ დაამატეთ სურვილი', '2014-03-12 07:02:31', '2014-03-12 08:37:02', NULL, 1, 14, NULL),
(19, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-03-20 12:45:06', '2014-03-24 11:10:33', NULL, 13, 15, NULL),
(22, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-03-25 11:23:36', '2014-03-26 06:43:53', NULL, 13, 18, NULL),
(24, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-03-25 11:25:34', '2014-03-26 06:43:53', NULL, 13, 20, NULL),
(25, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-03-25 12:06:28', '2014-03-26 06:43:53', NULL, 13, 21, NULL),
(26, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-03-26 08:18:33', '2014-03-26 08:25:06', NULL, 13, 22, NULL),
(27, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-01 11:43:53', NULL, NULL, 13, 0, NULL),
(28, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-01 11:58:37', NULL, NULL, 13, 0, NULL),
(29, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-01 12:13:11', NULL, NULL, 13, 0, NULL),
(30, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-01 13:21:37', NULL, NULL, 13, 0, NULL),
(31, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:20:02', NULL, NULL, 13, 0, NULL),
(32, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:33:03', NULL, NULL, 13, 0, NULL),
(33, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:35:15', NULL, NULL, 13, 0, NULL),
(34, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:36:41', NULL, NULL, 13, 0, NULL),
(35, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:42:25', NULL, NULL, 13, 0, NULL),
(36, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:44:03', NULL, NULL, 13, 0, NULL),
(37, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:45:17', NULL, NULL, 13, 0, NULL),
(38, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 10:56:51', NULL, NULL, 13, 0, NULL),
(39, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 11:03:33', NULL, NULL, 13, 0, NULL),
(40, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 11:04:29', NULL, NULL, 13, 0, NULL),
(41, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 11:07:45', NULL, NULL, 13, 0, NULL),
(42, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 11:14:26', NULL, NULL, 13, 0, NULL),
(43, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-02 12:56:08', NULL, NULL, 13, 0, NULL),
(44, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 11:30:22', NULL, NULL, 13, 0, NULL),
(45, 6, 173, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 11:49:53', NULL, NULL, 13, 0, NULL),
(46, 6, 87, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:02:25', NULL, NULL, 13, 0, NULL),
(47, 6, 173, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:02:30', NULL, NULL, 13, 0, NULL),
(48, 6, 145, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:05:49', NULL, NULL, 13, 0, NULL),
(49, 6, 322, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:05:53', NULL, NULL, 13, 0, NULL),
(50, 6, 221, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:06:19', NULL, NULL, 13, 0, NULL),
(51, 6, 292, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:06:32', NULL, NULL, 13, 0, NULL),
(52, 6, 180, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:20:04', NULL, NULL, 13, 0, NULL),
(53, 6, 311, 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა', '2014-04-03 12:21:41', NULL, NULL, 13, 0, NULL),
(54, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-04-04 07:53:54', NULL, NULL, 13, 23, NULL),
(55, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-04-04 07:54:58', NULL, NULL, 13, 24, NULL),
(56, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-04-04 07:55:49', NULL, NULL, 13, 25, NULL),
(57, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-04-04 08:18:32', NULL, NULL, 13, 26, NULL),
(58, 1, 13, 'თქვენ დაამატეთ სურვილი', '2014-04-04 08:19:02', NULL, NULL, 13, 27, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_type`
--

CREATE TABLE IF NOT EXISTS `user_notification_type` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET ascii NOT NULL,
  `cmnt` varchar(255) NOT NULL COMMENT 'comment you may use for displaying',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user_notification_type`
--

INSERT INTO `user_notification_type` (`id`, `name`, `cmnt`) VALUES
(1, 'YOU_ADDED_WISH', 'თქვენ დაამატეთ სურვილი'),
(2, 'YOUR_WISH_SELECTED', 'მეგობარმა თქვენი სურვილი მონიშნა'),
(3, 'YOUR_WISH_EXPIRES', 'თქვენს სურვილს ვადა გასდის'),
(4, 'YOUR_WISH_EXPIRED', 'თქვენს სურვილს ვადა ამოეწურა'),
(5, 'YOUR_FRIEND_ADDED_WISH', 'თქვენმა მეგობარმა დაამატა სურვილი'),
(6, 'FRIENDSHIP_REQUESTED', 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა'),
(7, 'FRIENDSHIP_ACCEPTED', 'თქვენს მეგობრობას დათანხმდნენ'),
(8, 'YOUR_SELECTED_WISH_EXPIRES', 'თქვენს მიერ მონიშნულ სურვილს ვადა გასდის'),
(9, 'YOUR_SELECTED_WISH_EXPIRED', 'თქვენს მიერ მონიშნულ სურვილს ვადა გაუვიდა');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `user_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('1','2') NOT NULL,
  `cmnt` text,
  `display_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `file_id`, `birth_date`, `gender`, `cmnt`, `display_name`) VALUES
(1, NULL, '1960-01-21', '1', NULL, 'George garcha'),
(2, NULL, '1960-01-21', '1', NULL, 'Test garcha'),
(3, NULL, '1960-01-21', '1', NULL, 'Test2 garcha2'),
(4, NULL, '1960-01-21', '1', NULL, 'Test3 garcha3');

-- --------------------------------------------------------

--
-- Table structure for table `wish`
--

CREATE TABLE IF NOT EXISTS `wish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(12) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expire` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `privacy` tinyint(3) unsigned NOT NULL,
  `text` text NOT NULL,
  `richtext` text NOT NULL,
  `type` varchar(10) CHARACTER SET ascii DEFAULT NULL,
  `link` text,
  `title` varchar(255) NOT NULL,
  `fulfilled_by` int(10) unsigned DEFAULT NULL,
  `fulfil_select_date` timestamp NULL DEFAULT NULL,
  `show_to_owner` tinyint(1) unsigned DEFAULT NULL COMMENT 'if selected user sees who selected his/her wish',
  PRIMARY KEY (`id`),
  KEY `fulfilled_by` (`fulfilled_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `wish`
--

INSERT INTO `wish` (`id`, `file_id`, `user_id`, `added`, `expire`, `category_id`, `privacy`, `text`, `richtext`, `type`, `link`, `title`, `fulfilled_by`, `fulfil_select_date`, `show_to_owner`) VALUES
(1, NULL, 1, '2013-11-21 11:37:20', NULL, 2, 2, 'this is body text so i want to test \r\nthis script how \r\nit''s working', '', 'status', NULL, 'this is test so lets go', NULL, NULL, NULL),
(2, 5, 2, '2013-11-21 11:37:51', NULL, 5, 2, 'test custom privacy', '', 'photo', NULL, 'yvarelis ambebi', NULL, NULL, NULL),
(3, NULL, 2, '2013-11-21 11:38:32', NULL, 3, 2, 'custom privacy 2', '', 'link', 'http://ravaxarshen.me/hehe.html', 'this is joke relly', 2, '2013-12-06 14:13:37', 1),
(4, NULL, 1, '2013-11-26 08:56:35', '2013-11-30', 2, 9, 'fdsg sdfg sdgsdgf sgf', '', 'link', 'sdfg', 's dfg sdfg', NULL, NULL, NULL),
(5, NULL, 3, '2013-11-28 08:45:47', '2013-11-27', 4, 2, 'asdf asdf as', '', 'status', NULL, 'wert w', NULL, NULL, NULL),
(6, NULL, 3, '2013-11-28 08:45:57', NULL, 3, 3, 'asdfa sdf', '', 'status', NULL, 'mxolod me', NULL, NULL, NULL),
(7, NULL, 1, '2013-11-28 08:46:36', NULL, 4, 2, 'asdf asdf sdf asdf', '', 'status', NULL, 'sdfsdf me 1', 2, '2013-12-13 17:41:52', 1),
(8, NULL, 1, '2013-11-28 08:46:47', NULL, 4, 2, 'asdf sdf a', '', 'status', NULL, 'megobrebi 1', 1, '2013-12-06 15:10:09', 1),
(9, 6, 2, '2013-12-06 14:15:15', '2013-12-20', 4, 3, 'dsfgs dfg', '', 'photo', NULL, 'dsfg sdfg', NULL, NULL, NULL),
(12, NULL, 1, '2014-01-21 07:42:42', '2014-01-25', 4, 2, 'asdasd', '', 'status', NULL, 'ass', NULL, NULL, NULL),
(13, NULL, 1, '2014-03-11 08:19:20', '2014-03-31', 4, 2, 'კაბა', '', 'status', NULL, 'კაბა', NULL, NULL, NULL),
(14, NULL, 1, '2014-03-12 07:02:31', '2014-03-31', 4, 3, 'grew', '', 'status', NULL, 'retetertete', NULL, NULL, NULL),
(15, NULL, 13, '2014-03-20 12:45:06', NULL, 4, 2, 'dfgh df ghdfhg dfh', '', 'status', NULL, 'fgdhfghfh', NULL, NULL, NULL),
(18, 8, 13, '2014-03-25 11:23:36', NULL, 4, 2, 'test photo', '', 'photo', NULL, 'tesst', NULL, NULL, NULL),
(20, 10, 13, '2014-03-25 11:25:34', NULL, 4, 3, 'sdf sdf sfd s', '', 'photo', NULL, 'sfd sf', NULL, NULL, NULL),
(21, 12, 13, '2014-03-25 12:06:28', '2014-03-29', 4, 2, 'me m inda aseti kaba zalian', '', 'photo', NULL, 'kaba', NULL, NULL, NULL),
(22, NULL, 13, '2014-03-26 08:18:32', '2014-03-27', 4, 3, 'new wish descr', '', 'link', 'http://news.ge/ge/', 'new wish', NULL, NULL, NULL),
(23, 13, 13, '2014-04-04 07:53:54', '2014-04-30', 4, 3, 'ახალი ფეხსაცმელი', '', 'photo', NULL, 'ახალი სურვილი', NULL, NULL, NULL),
(24, 14, 13, '2014-04-04 07:54:58', '2014-05-03', 4, 3, 'ძალიან მინდა ეს სამოსი', '', 'photo', NULL, 'ახალი გარდერობი', NULL, NULL, NULL),
(25, 15, 13, '2014-04-04 07:55:49', '2014-07-04', 4, 3, 'სასიამოვნო მაისური, სასიამოვნო ფერები', '', 'photo', NULL, 'მაისური', NULL, NULL, NULL),
(26, 16, 13, '2014-04-04 08:18:32', '2014-04-16', 4, 3, 'სადა სტილი', '', 'photo', NULL, 'casual look', NULL, NULL, NULL),
(27, 17, 13, '2014-04-04 08:19:02', '2014-04-17', 4, 3, 'სადა სტილი', '', 'photo', NULL, 'სადა ლუქი', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wish_access_list`
--

CREATE TABLE IF NOT EXISTS `wish_access_list` (
  `wish_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `wish_user` (`wish_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wish_access_list`
--

INSERT INTO `wish_access_list` (`wish_id`, `user_id`) VALUES
(1, 0),
(2, 13),
(3, 13),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `wish_category`
--

CREATE TABLE IF NOT EXISTS `wish_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `user_id` int(10) DEFAULT NULL COMMENT 'if it''s user created category',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_cat_uniq` (`user_id`,`name`) COMMENT 'for each user can have one cat with the name'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `wish_category`
--

INSERT INTO `wish_category` (`id`, `name`, `user_id`) VALUES
(1, 'Test', NULL),
(4, 'ახალი წელი', -1),
(2, 'დღესასწაული', -1),
(3, 'ვალენტინობა', -1),
(5, 'garcha cusotm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wish_comment`
--

CREATE TABLE IF NOT EXISTS `wish_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wish_id` int(10) unsigned NOT NULL,
  `body` text NOT NULL COMMENT 'comment text',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `wish_comment`
--

INSERT INTO `wish_comment` (`id`, `wish_id`, `body`, `created`, `user_id`) VALUES
(10, 3, 'jk hljkhkj', '2013-11-26 08:01:24', 1),
(11, 3, 'j hl;k;', '2013-11-26 08:01:32', 1),
(13, 4, 'this is haha this is hoho :D', '2013-11-27 12:01:32', 1),
(16, 3, 'fsdf', '2013-12-06 14:03:03', 2),
(18, 8, 'ftgs dfgdfg', '2013-12-06 15:09:34', 1),
(25, 12, 'fwrewrew', '2014-01-21 07:44:17', 1),
(26, 4, 'jo/;o;jh', '2014-03-01 09:07:48', 1),
(27, 22, 'my comment is here', '2014-03-27 06:13:19', 13),
(28, 22, 'second coment', '2014-03-27 06:26:26', 13),
(29, 3, 'my comment', '2014-03-27 11:37:51', 13);

-- --------------------------------------------------------

--
-- Table structure for table `wish_type`
--

CREATE TABLE IF NOT EXISTS `wish_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
