/*create table agnus (
	nomina varchar(100),	
	informatio varchar(1000),
	idem int not null auto_increment
);

create table oratio (
	amen int,
	verba varchar(1000),
	agnus varchar(100)
);*/

create table if not exists oratio (
	amen int not null,
	verba varchar(10000) not null
);

insert into oratio values (0, "<span class=\"Unicode\">Отче нашъ, сущій на небесахъ!<br>да святится имя Твое;<br>да пріидетъ Царствіе Твое;<br>да будетъ воля Твоя и на землѣ, какъ на небѣ;<br>хлѣбъ нашъ насущный дай намъ на сей день;<br>			и прости намъ долги наши, какъ и мы прощаемъ должникамъ нашимъ;<br>и не введи насъ в искушеніе, но избавь насъ от лукаваго</span>");
insert into oratio values (0, "<p><strong>Живый в помощи  Вышняго, в крове Бога Небеснаго водворится.<br>          Речет Господеви:  Заступник мой еси &nbsp;и прибежище мое, Бог  мой, и уповаю на Него.<br>          Яко Той избавит  тя от сети ловчи, и от словесе мятежна,<br>          плещма Своима осенит  тя, и под криле Его надеешися: оружием обыдет тя истина Его.<br>          Не убоишися от  страха нощнаго, от стрелы летящия во дни,<br>          от вещи во тме  переходящия, от сряща, и беса полуденнаго.<br>          Падет от страны  твоея тысяща, и тма одесную тебе, к тебе же не приближится: <br>          обаче очима  твоима смотриши, и воздаяние грешников узриши.<br>          Яко Ты, Господи,  упование мое, Вышняго положил еси прибежище твое.<br>          Не приидет к тебе  зло, и рана не приближится телеси твоему:<br>          яко Ангелом Своим  заповесть о тебе, сохранити тя во всех путех твоих.<br>          На руках возмут  тя, да некогда преткнеши о камень ногу твою:<br>          на аспида и  василиска наступиши, и попереши льва и змия. <br>          Яко на Мя упова,  и избавлю и: <br>          покрыю и, яко  позна имя Мое. Воззовет ко Мне, и услышу его: с ним есмь в скорби, <br>          изму его, и  прославлю его, долготою дней исполню его, <br>          и явлю ему  спасение Мое.</strong></p>");
insert into oratio values (0, "<p><strong>Огради мя,  Господи, силою Честнаго и Животворящаго Твоего креста,<br>          и сохрани мя от всякаго  зла.</strong></p>");
insert into oratio values (0, "Круто! Теперь можно ставить свечи онлайн и фотаться со свечками!");

select * from oratio ORDER BY amen desc limit 0, 5;