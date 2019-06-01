-- phpMyAdmin SQL Dump
-- version 3.4.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 24 2012 г., 22:22
-- Версия сервера: 5.5.13
-- Версия PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `regauth`
--

-- --------------------------------------------------------

--
-- Структура таблицы `statti`
--

CREATE TABLE IF NOT EXISTS `statti` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `meta_k` varchar(255) NOT NULL,
  `meta_d` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `img_src` varchar(255) NOT NULL,
  `mini_discr` varchar(255) NOT NULL,
  `discription` text NOT NULL,
  `text` text NOT NULL,
  `cat` int(5) NOT NULL,
  `view` int(5) NOT NULL DEFAULT '0',
  `ball` int(11) NOT NULL DEFAULT '1',
  `kol_gol` int(11) NOT NULL DEFAULT '1',
  `sl` int(1) NOT NULL DEFAULT '0',
  `source` varchar(255) NOT NULL,
  `cat_top` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `text` (`text`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=102 ;

--
-- Дамп данных таблицы `statti`
--

INSERT INTO `statti` (`id`, `title`, `meta_k`, `meta_d`, `author`, `date`, `img_src`, `mini_discr`, `discription`, `text`, `cat`, `view`, `ball`, `kol_gol`, `sl`, `source`, `cat_top`) VALUES
(1, 'История и развитие Ford GT', 'Автомобиль Ford GT', 'Автомобиль Ford GT', 'Uncnown', '2010-06-26', 'images/ford.jpg', 'В середине 60-х Ford впервые выпустил GT40 и автомобиль сразу же получил самую высокую оценку, разойдясь огромным тиражом. Существовала гоночная версия, которая собрала массу призов', 'В середине 60-х Ford впервые выпустил GT40 и автомобиль сразу же получил самую высокую оценку, разойдясь огромным тиражом. Существовала гоночная версия, которая собрала массу призов, в том числе и четырежды в знаменитой гонке "24 часа в Ле-Ман". К созданию гоночного автомобиля Ford шёл долго, в 60-е лидирующие позиции этого сегмента принадлежали Ferrari, чтобы добиться успеха и признания в Европе нужны были победы на престижных гонках. Для достижения этой цели в 1963 году Ford хотел купить за $18 млн. у команды Ferrari пакет всех чемпионских технологий. Однако Энцо Феррари не продался даже за такие огромные деньги. Поэтому Ford ничего не оставалось, как начать самому строить суперкар для участия в Ле-Мане. ', '<p>В середине 60-х Ford впервые выпустил GT40 и автомобиль сразу же получил самую высокую оценку, разойдясь огромным тиражом. Существовала гоночная версия, которая собрала массу призов, в том числе и четырежды в знаменитой гонке "24 часа в Ле-Ман". К созданию гоночного автомобиля Ford шёл долго, в 60-е лидирующие позиции этого сегмента принадлежали Ferrari, чтобы добиться успеха и признания в Европе нужны были победы на престижных гонках. Для достижения этой цели в 1963 году Ford хотел купить за $18 млн. у команды Ferrari пакет всех чемпионских технологий. Однако Энцо Феррари не продался даже за такие огромные деньги. Поэтому Ford ничего не оставалось, как начать самому строить суперкар для участия в Ле-Мане. В 1964 году был создан Ford GT, который на первой же гонке провалился. После этого Генри Форд второй нанимает на работу Кэррола Шелби, и уже в 1965 году свет увидел автомобиль, которому будет суждено одерживать ошеломляющие победы в течение пяти лет. Сердцем GT40 служил 4,7 литровый двигатель, а в 1966 году под капотом находился 7 литровый агрегат. Цифра 40 в названии автомобиля означает его высоту - на модели 60-х годов она составляла ровно 40 дюймов. Тесный кокпит, среднемоторная компоновка, огромные надписи Goodyear Eagle на боковинах покрышек, резко скошенная корма - таким запомнился современникам этот суперкар. Модель этих годов считается одним из любимых и популярных автомобилей за всю историю автомобилестроения.</p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_1.jpg"></p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_2.jpg"></p>\r\n<p>Когда в 1968 г. вступили в силу ограничения по рабочему объему гоночных двигателей, "сердце" GT40 оснастили новыми головками цилиндров Weslake, и его объем сократился до 5 л. В таком виде автомобиль вновь был первым в Ле-Мане - в 1968 и 1969 гг. Вскоре появилась и дорожная версия рекордсмена с 4,7 л двигателем, развивавшим мощность 335, 340 и даже 385 л. с. Скорость 385-сильной версии зашкаливала за 300 км/час. Эта машина оснащалась 5-ступенчатой коробкой ZF и дисковыми тормозами Girling, бак вмещал 140 л топлива. Всего было продано 107 таких авто.</p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_3.jpg"></p>\r\n<p>Но были и неудачи, к которым, например, принято отностить Ford GT70. Он был представлен публике в январе 1971 года. Индекс "70" по замыслу создателей машины должен был означать начало эпохи раллийных автомобилей специальной постройки, которая, как прогнозировали специалисты, наступит в 70-е годы. Ford GT70 представлял собой двухместное купе. В качестве силового элемента шасси использовалась сварная рама из стальных замкнутых прямоугольных профилей, к которым было приварено днище кузова. Каркас безопасности служил дополнительной опорой крыши и боковин кузова и был приварен к раме. Панели кузова были выполнены из стеклопластика и крепились к раме в 10 точках. Кузов имел коэффициент аэродинамического сопротивления 0,36. На данную модель планировалось устанавливать V-образные шестерки рабочим объемом 2,6 л, 3 л агрегат из серийной гаммы и 1,6 л 4-цилиндровый двигатель. Трансмиссия состояла из сухого однодискового сцепления и четырех- и пятиступенчатой коробок передач ZF. Для Ford GT70 были специально отлиты 13-дюймовые диски колес шириной от 7 до 10 дюймов, на которые монтировались радиальные шины Dunlop размером 195/70R13. Реечный рулевой механизм и передние дисковые тормоза перешли на GT70 с Ford Taunus. Спереди устанавливался радиатор системы охлаждения двигателя с отводом теплого воздуха в колесные ниши, резервуары гидравлических систем и убирающиеся фары. Посадка была удобной, несмотря на то, что из-за продольного расположения двигателя и маленькой базы (2324 мм) сиденья были сильно сдвинуты вперед. Автомобиль вызвал большой интерес у спортивной общественности, и оставалось дождаться результатов первых соревнований, в которых Ford GT70 участвовал в ранге прототипа, но в ход истории вмешались профсоюзы, в начале 1971 года организовавшие на заводах Ford длительную забастовку. Она поставила под сомнение осуществление многих планов не только спортивной, но и производственной программы компании. Работа над машиной фактически прекратилась, но тем не менее удалось построить четыре прототипа, которые приняли участие в некоторых соревнованиях. Первый выход состоялся на асфальтовом ралли Ronde Cevenole во Франции в 1971 году, где автомобиль с 2,9 л V6 сошел из-за неполадки в двигателе. Несколько недель спустя другой прототип был списан из-за аварии после четвертого этапа гонки Tour de France. В 1972 году автомобиль с двигателем Cosworth BDA стартовал на этапе чемпионата мира, ралли Tour de Corse на Корсике. Ford GT70 снова не повезло - не выдержал подшипник ступицы, и команда лишилась возможности продолжить гонку. После этих неудач на спортивной карьере Ford GT70 был поставлен крест. После 1973 года машины были переданы Ford South Africa, и их следы затерялись где-то в ЮАР. Так завершилась история болида, обещавшего стать грозным соперником Renault-Alpine, Porsche и Lancia.</p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_5.jpg"></p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_6.jpg"></p>\r\n<p>В 1994 году, в год 30-летного юбилея Ford GT40, который победил Ferrari, в ознаменование этой важной даты было принято решение о создании суперкара. Весной того же года проект получил зелёный свет. В результате команда GT90 выполнила свою задачу менее чем за шесть месяцев - от идеи до ходового образца. Доминирующей темой дизайна GT90 стал треугольник. Клюв капота, воздухазаборники, диски колёс, зеркала заднего вида, элементы крыши, стоп - сигналы, выхлопные трубы - здесь всё пронизано "треугольной темой". Перед увенчан огромным воздухозаборником радиатора, вертикальными каналами для охлаждения передних тормозных дисков, что напоминает Ford GT40. Боковые отверстия подающие воздух к промежуточным охладителям надува, также перекликаются с Ford GT40. Колпак кабины из тонированного голубого стекла опирается на стальной каркас, а двери врезаны в крышу, как на GT40. Центр задка подчеркнут треугольным килем, облегающим "активное" антикрыло, которое при достижении определённой скорости поднимается на двух стойках и создаёт дополнительную прижимающую силу, обеспечивая устойчивость аVтомобиля. Благодаря тщательно проработанной конструкции коэффициенту аэродинамического сопротивления составил 0,32. Дизайн интерьера максимально функционален. Материалы отделки разнообразны. Внутреннее цветовое решение - голубой цвет с жёлтым треугольником на рулевом колесе. "Треугольная тема" проступает и в решении центральной консоли. Анатомические сидения, обтянутые голубой кожей и замшей, оснащены четырёхточечными ремнями безопасности. Отделка из углеродного волокна использована на потолке, центральной консоли и зеркале заднего вида. Приборы на панели смонтированы по отдельности и в разных плоскостях в порядке приоритетности и визуальной привлекательности. Стёкла приборов дымчатые. Силовой агрегат GT90 рабочим объёмом 6,0 литра, выполненный целиком из алюминия, - модульный V-образный 12-цилиндровый с четырёхступенчатым турбонаддувом. Расположен продольно. По предварительным оценкам, мощность силового агрегата составила 720 л.с. при 6600 оборотов в минуту, а крутящий момент 881 Нм при 4750 об/мин. При снаряжённой массе 1450 кг Ford GT90 разгоняется до 97 км/ч за 3,1 секунды, до 160 км/ч за 6,2 секунды, и максимальная скорость концепткара составляет 378 км/ч. Но проект так и остался концептом и дальнейшего развития не получил.</p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_4.jpg"></p>\r\n<p>Век гоночных машин обратно пропорционален их скорости. Практически все специалисты уже относили Ford GT40 к славному, но, увы, безвозвратному прошлому. Так продолжалось до тех пор, пока концепт, носящий громкое имя Ford GT40, не потряс автомобильную общественность в январе 2002 г. на международном автосалоне в Детройте. В честь 100-летнего юбилея концерна Ford был представлен новый GT, созданный по образу и подобию легендарных Ford GT40 образца 60-х годов. По мнению экспертов, в этом шаге нет ничего ностальгического. Просто выяснилось, что автомобильные легенды и сегодня могут приносить вполне реальную прибыль, что побудило Ford Motor Co. открыть специальную дизайнерскую студию, которая так и называется - Living Legends. Именно ее стараниями к линейке концептуальных "живых легенд" (Forty-Nine, Continental, Bullitt Mustang, Thunderbird) добавился концепт Ford GT40. Автомобиль представляет собой новую версию знаменитого 2-местного суперкар. Модель сохранила старое название, как дань уважения легендарному прародителю, хотя высота теперь стала больше и составляет 44 дюйма или 1 м 117 мм. Приземистая поясная линия красиво огибает передние 18-дюймовые колеса, затем немного опускается к дверям, а сзади снова подъем. Только уже выше. Ведь задние колеса, чтобы реализовать колоссальную мощность двигателя, как и на оригинальном GT40, сделали больше передних. Шины, как и 36 лет назад, Goodyear Eagle (спереди - 245/45R18, сзади - 285/45R19), сквозь спицы литых дисков, выполненных в стиле 60-х, просматриваются 380-миллиметровые керамические диски с шестипоршневыми суппортами Alcon. Конструкторы отказались от используемой в 60- х годах технологии монокока из сотового композита в пользу пространственной алюминиевой рамы и углепластиковых внешних панелей. Подвеска всех колес независимая гоночного типа, на поперечных алюминиевых рычагах разной длины с продольно установленными амортизаторами. В конструкции Ford GT 2005 были использованы не только абсолютно новые технические решения, но и хорошо проверенные временем. Рулевая колонка нового спорткара позаимствована у родственного Ford Focus, а кнопки управления и подушки безопасности - у Ford Mondeo. А вот проблема расположения топливного бака решена совсем по-новому. Обычно у машин со среднемоторной компоновкой бак располагается внизу, позади пассажирского отсека. У нового GT40 он имеет продолговатую форму, что позволило установить его в трансмиссионном тоннеле. Рядом смонтированы основные элементы системы подачи топлива. С топливной темой связано и другое интересное конструкторское решение. Это так называемая топливная дверца, устранившая надобность в топливном колпачке. Теперь достаточно просто открыть ее и вставить шланг с бензином. О герметичности можно не беспокоиться - специальные прокладки (на них Ford получил патент) не только воспрепятствуют потекам бензина, но и снимут статическое электричество. Двигатель, оснащенный нагнетателем и интеркулером 550-сильный Eaton (5, 4 л V8, 500 л. с. при 5.250 об/мин и 600 Нм при 3.250 об/мин) расположен продольно, перед коробкой передач (это опять-таки механическая ZF, правда, передач в ней стало шесть). До GT40 этот мотор с успехом применялся на Mustang Cobra, F150 Lighting и Lincoln Navigator. Благодаря своим характеристикам силовой агрегат способен разгонять 1, 5-тонный Ford GT до максимальной скорости, 330 км/час. При этом на достижение с места 100 км/час автомобилю требуется всего 3, 9 сек. Фанаты скоростных машин знают, что подобными динамическими характеристиками может похвастаться разве что итальянский суперкар Ferrari 360 Modena. Именно ему, по замыслу американских инженеров, и призвана противостоять возрожденная легенда.\r\nВ салоне также сохранен антураж давно минувшей эпохи: помимо огромных спидометра и тахометра массивная приборная панель вмещает четыре стрелочных указателя поменьше и несколько мощных тумблеров, а на центральном тоннеле, рядом с водителем, нашлось место для огнетушителя. В общем, все как у «предка». Сиденья, как положено настоящему гоночному автомобилю, — жесткие нерегулируемые «ковши» с перфорацией (для естественной вентиляции тела седока). Однако разработчики не забыли и о комфорте: на GT40 установлены великолепная аудиосистема и климат-контроль.\r\n</p>\r\n<p align="center"><img src="file/08.06.2010/autowp.ru_7.jpg"></p>', 2, 129, 1, 1, 0, '', 0),
(2, 'Обзор нового BMW M3 GT (E36)', 'BMW M3 GT (E36)', 'BMW M3 GT (E36)', 'Uncnown', '2010-06-06', 'images/bmw.jpg', 'Эта специальная серия была выпущена для омологации, чтобы допустить M3 к участию в гонках серии FIA GT 2 и IMSA GT USA. Всего было выпущено 356 экземпляров (350 + 6 прототипов). ', 'Эта специальная серия была выпущена для омологации, чтобы допустить M3 к участию в гонках серии FIA GT 2 и IMSA GT USA. Всего было выпущено 356 экземпляров (350 + 6 прототипов). Все автомобили окрашивались в цвет British Racing Green и отличались форсированным до 295 лошадиных сил двигателем, а также развитым передним спойлером и задним антикрылом.', '<p>Эта специальная серия была выпущена для омологации, чтобы допустить M3 к участию в гонках серии FIA GT 2 и IMSA GT USA. Всего было выпущено 356 экземпляров (350 + 6 прототипов). Все автомобили окрашивались в цвет British Racing Green и отличались форсированным до 295 лошадиных сил двигателем, а также развитым передним спойлером и задним антикрылом.</p>\r\n<p align="center"><img src="file/08.06.2010/bmw.jpg"></p>\r\n<h3>Отличительные особенности версии M3 GT:</h3>\r\n<h3><img align="right" src="file/08.06.2010/bmw (2).jpg" />Экстерьер:</h3>\r\n\r\n<ul style="list-style-type:disc; margin:10px;" type="disc">\r\n  <li class="list_type">единственный цвет: тёмно-зелёный металлик &quot;British Racing Green&quot; </li>\r\n  <li class="list_type">заднее антикрыло и спойлер переднего бампера с разделителем воздушного потока для улучшения       аэродинамики и прижимной силы </li>\r\n  <li class="list_type">логотипы&nbsp;&quot;BMW Motorsport International&quot; на молдингах дверей </li>\r\n\r\n<li class="list_type">легкосплавные&nbsp;колёсные диски BMW Motorsport  &quot;Forget M Double Spoke&quot; (7.5Jx17&quot;-передние,  8.5Jx17&quot;-задние)</li></ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p> \r\n<br>\r\n<br>\r\n<br>\r\n<h3><img align="right" src="file/08.06.2010/autowp.ru_61.jpg" />Интерьер:</h3>\r\n<ul style="list-style-type:disc; margin:10px;" type="disc">\r\n  <li class="list_type">Обивка центральной&nbsp;части       сидений и вставок дверных панелей с дверными ручками&nbsp;-       зелёная&nbsp;кожа&nbsp;Nappa Mexico Green. </li>\r\n  <li class="list_type">Отделка карбоном центральной       консоли, карбоновые накладки с логотипами &quot;BMW Motorsport       International&quot; на внутренней части дверных порогов.</li>\r\n  <li class="list_type">Трёхспицевый руль с подушкой       безопасности </li>\r\n\r\n<li class="list_type">Карбоновая планка с шильдиком &quot;BMW Motorsport  International Limited Edition&quot; над крышкой перчаточного ящика</li></ul>\r\n<p>&nbsp;</p>\r\n<br>\r\n<br>\r\n<br>\r\n<h3><img align="right" src="file/08.06.2010/autowp.ru_71.jpg" />Технические:</h3>\r\n<ul style="list-style-type:disc; margin:10px;" type="disc">\r\n  <li class="list_type">Двигатель объёмом 3 литра и       мощностью 295 л.с. (серийно 3,0 литра 286 л.с.) </li>\r\n  <li class="list_type">Облегчённые двери из алюминия</li>\r\n  <li class="list_type">Более жёсткая подвеска</li>\r\n  <li class="list_type">Распорка передних стоек </li>\r\n</ul>\r\n<p>Стоимость M3 GT Coupe на момент выхода  DM 91.000.- </p>\r\n<br>\r\n<br>\r\n<img src="file/08.06.2010/autowp.ru_8.jpg">\r\n<img src="file/08.06.2010/autowp.ru_9.jpg">', 2, 121, 10, 3, 0, '', 0),
(3, 'Десять лучших обвесов по версии журнала Importtuner', 'Десять лучших авто', 'Десять лучших авто', 'Uncnown', '2010-06-06', 'images/ten_car.jpg', 'Что может превратить обычный семейный автомобиль в злое уличное авто? Придать городской машине аэродинамические свойства болида? Важный элемент автомобиля - аэродинамический обвес. ', 'Что может превратить обычный семейный автомобиль в злое уличное авто? Придать городской машине аэродинамические свойства болида формулы-1? Самый важный элемент экстерьера автомобиля - аэродинамический обвес. Некоторые обвесы представляют собой сложные инженерные изобретения, изготовление которых сопровождается множеством научных расчётов. Есть комплекты бамперов, которые были придуманы и сделаны в обычном гараже, без каких либо математических выкладок. Но главная цель установки любых обвесов — это придание агрессивного и неповторимого облика своему авто.', '<p>Что может превратить обычный семейный автомобиль в злое уличное авто? Придать городской машине аэродинамические свойства болида формулы-1? Самый важный элемент экстерьера автомобиля - аэродинамический обвес. Некоторые обвесы представляют собой сложные инженерные изобретения, изготовление которых сопровождается множеством научных расчётов. Есть комплекты бамперов, которые были придуманы и сделаны в обычном гараже, без каких либо математических выкладок. Но главная цель установки любых обвесов — это придание агрессивного и неповторимого облика своему авто.\r\nНиже представлены 10 самых “горячих” обвесов по версии журнала Importtuner.\r\n</p>\r\n<p>1. Feel’s для Honda Civic (EK)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_1.jpg"></p>\r\n<p>2. RE Amemiya GT Widebody для Mazda RX-7 (FD3S)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_2.jpg" /></p>\r\n<p>3. Top Secret Widebody для Nissan 350Z (Z33)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_3.jpg" /></p>\r\n<p>4. Mugen для Acura RSX</p>\r\n<p align="center"><img src="file/08.06.2010/3600_4.jpg" /></p>\r\n<p>5. Charge Speed Widebody Application: Subaru WRX (GDA)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_5.jpg" /></p>\r\n<p>6. APR Widebody для Mitsubishi Evolution VIII</p>\r\n<p align="center"><img src="file/08.06.2010/3600_6.jpg" /></p>\r\n<p>7. Top Secret GT300 Widebody для Toyota Supra (JZA80)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_7.jpg" /></p>\r\n<p>8. Mugen для Honda CRX</p>\r\n<p align="center"><img src="file/08.06.2010/3600_8.jpg" /></p>\r\n<p>9. GP Sport G-Sonic Type-1 для Nissan 240SX (S13)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_9.jpg" /></p>\r\n<p>10. Jubiride для Toyota Corolla (AE86)</p>\r\n<p align="center"><img src="file/08.06.2010/3600_10.jpg" /></p>', 2, 108, 1, 1, 0, '', 0),
(4, 'Новинка 2010 года - Suzuki Kizashi', 'Suzuki Kizashi', 'Новинка 2010 года - Suzuki Kizashi', '', '2010-06-26', 'images/suzuki_kizashi_mini.jpg', 'Серийная версия Suzuki Kizashi (Сузуки Кидзаши) уже доступна для просмотра пользова-телями сети Интернет.', 'Серийная версия Suzuki Kizashi (Сузуки Кидзаши) уже доступна для просмотра пользователями сети Интернет. Несмотря на это, о новинке имеются весьма скудные сведения. Мы предлагаем вашему вниманию краткое описание данной машины, которая вполне заслуживает внимания автоолюбителя. Знакомьтесь, Suzuki Kizashi – новинка авто 2010 модельного года.', '<p>Серийная версия Suzuki Kizashi (Сузуки Кидзаши) уже доступна для просмотра пользователями сети Интернет. Несмотря на это, о новинке имеются весьма скудные сведения. Мы предлагаем вашему вниманию краткое описание данной машины, которая вполне заслуживает внимания автоолюбителя. Знакомьтесь, Suzuki Kizashi – новинка авто 2010 модельного года.</p>\r\n<p align="center"><img  src="file/08.06.2010/suzuki_kizashi_01.jpg" alt="">\r\n</p>\r\n<p>Сразу отметим, что седан Suzuki Kizashi «замахнулся» на конкурирование с автомобилями Honda Accord, Toyota Camry и Mazda6 – отважно, не правда ли? Так, Кидзаши выигрывает в колесной базе у Toyota Camry, но «пролетает» в длине – Suzuki Kizashi короче Toyota Camry на 165 мм, зато салон у Suzuki куда более просторный, нежели у Camry.\r\n  Теперь перейдем к вопросу линейки двигателей новинки авто 2010. Спектр моторов включает в себя два бензиновых «движка» по 2,3 и 3,6 литра соответственно, а также турбодизель 2,0 л. Базовая версия Suzuki Kizashi обещает быть переднеприводной, а вот автомобиль с полным приводом – своеобразная роскошь, доступная в виде опции избранных комплектаций. Шестиступенчатую коробку «автомат» можно будет регулировать с помощью подрулевых лепестков, доступных в базовой версии. \r\n  </p>\r\n<p align="center"><img src="file/08.06.2010/Suzuki_Kizashi.jpg" /></p>\r\n<p>В Европу Suzuki Kizashi завезут в середине 2010 года, кстати, в кузовных версиях универсал и хэтчбек. Предварительно, в США цена на Suzuki Kizashi 2010 модельного года стартует от 21000 $. Соответственно, в Украине новинку можно будет приобрести за сумму, которая находится в районе 40000 $. </p>', 1, 53, 70, 15, 0, '', 0),
(5, 'Audi', 'Audi', 'Audi', '', '2010-06-06', 'images/audi_mini.jpg', 'Новая Audi S4 доказывает, что немцы всерьез взялись за спортивные седаны. Гонка с BMW не прекращается и это нам только на руку', 'Ребята из Ингольштадта празднуют в 2009 году юбилей, поэтому разработок и новинок у них хоть отбавляй. И, как ни странно, общий уровень продаж у них растет. В скором времени из конюшен Audi выкатятся новые кабриолеты A5 и S5 (причем с новыми двигателями), R8 получит новый мотор V10 объемом 5,2 литра. Но самое главное, Audi выпустит новый седан S4.', '<p>Ребята из Ингольштадта празднуют в 2009 году юбилей, поэтому разработок и новинок у них хоть отбавляй. И, как ни странно, общий уровень продаж у них растет. В скором времени из конюшен Audi выкатятся новые кабриолеты A5 и S5 (причем с новыми двигателями), R8 получит новый мотор V10 объемом 5,2 литра. Но самое главное, Audi выпустит новый седан S4.</p>\r\n<p align="center"><img src="file/08.06.2010/audi.jpg"></p>\r\n<p>Новая Audi S4 доказывает, что немцы всерьез взялись за спортивные седаны. Гонка с BMW не прекращается и это нам только на руку. S4 2010 года получит 3-литровый мотор TFSI V6. Этот турбодвигатель производит 333 лошади с крутящим моментом 440 Нм. Этого вполне достаточно, чтобы каждый день бороться за превосходство «четырех колец» на дорогах. Добавим к этому быструю 6-ступенчатую механику и новый 7-ступенчатый автомат с двумя сцеплениями, полный привод quattro и получим 5,1 секунды до 100 км/ч. Напоследок, Audi S4 будет еще и экономичной – 13,5 литров по городу. Стоить Audi S4 2010 будет от 49 тыс. долларов США.\r\n\r\n</p>', 1, 60, 6, 2, 0, '', 0),
(6, 'Aston Martin', 'Aston Martin', 'Aston Martin', 'http://autoportal.ua', '2010-06-06', 'images/aston_martin_mini.jpg', 'В салонах дилеров появится долгожданный четырехдверный AM Rapide и открытый родстер DBS...', '!Следующий год станет поистине важным для этой компании. Мало того, что в салонах дилеров появится долгожданный четырехдверный AM Rapide и открытый родстер DBS Volante, в будущем году будут выпущены новые Aston Martin One-77.', '<p>Следующий год станет поистине важным для этой компании. Мало того, что в салонах дилеров появится долгожданный четырехдверный AM Rapide и открытый родстер DBS Volante, в будущем году будут выпущены новые Aston Martin One-77.</p>\r\n<p align="center"><img src="file/08.06.2010/aston martin.jpg"></p>\r\n<p>Эта модель будет выпущено весьма ограниченным тиражом. Шесть будет собрано в следующем году, а всего их будет 77 (не сложно было догадаться, правда?). Каждый автомобиль будет подгоняться индивидуально под покупателя. Это в AM называют уникальностью. Подтверждать столь дерзкий статус придется 7,2-литровому двигателю V12 мощностью 700 л.с. Заказы на этот автомобиль уже принимаются. Цена британского эксклюзива, относительно, не высокая – 2 млн. долларов США.\r\n</p>', 1, 58, 19, 7, 0, '-', 0),
(7, 'Москва VW Polo Saloon ', 'Москва VW Polo Saloon ', 'Москва VW Polo Saloon ', '', '2010-06-07', 'images/vw.jpg', 'Мировая премьера давно ожидаемого Volkswagen Polo Saloon, разработанного специально для российского рынка, на этой неделе прошла в Москве. ', 'Мировая премьера давно ожидаемого Volkswagen Polo Saloon, разработанного специально для российского рынка, на этой неделе прошла в Москве. ', '<p>Мировая премьера давно ожидаемого Volkswagen Polo Saloon, разработанного специально для российского рынка, на этой неделе прошла в Москве. В самое ближайшее время начнутся продажи этой версии автомобиля, сборка которой осуществляется на заводе Volkswagen в Калуге.\r\n«Новый Volkswagen Polo Saloon не только соответствует самым высоким современным стандартам автомобильной промышленности, но также получил инновационные технологии, новые системы активной и пассивной безопасности, в сочетании с качественными материалами, применяемых при изготовлении автомобиля» - говорится в релизе.\r\nVolkswagen Polo Saloon оснащен 1.6-литровым двигателем Otto, мощностью 105 л.с. (77 кВт), который может комплектоваться как ручной пятиступенчатой, так и автоматической шестискоростной коробкой передач Tiptronic.</p>\r\n<p align="center"><img src="file/08.06.2010/VW.jpg"></p>\r\nВ плане безопасности имеется две подушки безопасности, ABS – это в стандартной комплектации, для версии Highline добавляются боковые подушки и ESP.\r\n«Polo Saloon расширяет модельный ряд Volkswagen в России, который станет неплохим дополнением к уже имеющимся Passat и Jetta. Автомобиль соответствует самым жестким стандартам немецкой компании и при этом предлагается по сравнительно привлекательной стоимости, которая будет начинаться от 10 000 евро».\r\n\r\n</p>', 3, 48, 1, 1, 0, '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `confirm` enum('0','1') NOT NULL DEFAULT '0',
  `sess` varchar(32) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `name`, `hash`, `confirm`, `sess`, `email`) VALUES
(1, 'Meits', '50ba9dd15f115aeb550f11146a43dfb9', 'Viktor', 'd3e2e195f839feb577a776f659ac8b95', '1', '656ddb7e3a66f30f037ee7b3474b0602', 'mail@mail.ru'),
(3, 'Metiz', '202cb962ac59075b964b07152d234b70', 'Metiz', '91267b93890205d8ff0198a8418d48f5', '1', NULL, 'metiz@mail.ru'),
(4, 'Viktor', '827ccb0eea8a706c4c34a16891f84e7b', 'Viktor', '59373b6989d9c826bcd75978b576dd1a', '1', 'b18cea8d9199ffaa10b61ba561ac4d94', 'mail.ru');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
