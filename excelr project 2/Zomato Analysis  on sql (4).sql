drop database zomato;
create database zomato;


use zomato;

create table sheet1 (restaurantid int,restaurantname varchar(255),country_code varchar(10),city varchar(255),address varchar(255),Locality varchar(255) 
,LocalityVerbose varchar(250) ,Longitude float ,Latitude float ,Cuisines varchar(255) ,Currency varchar(255) ,Has_Table_booking varchar(255) 
,Has_Online_delivery varchar(255) ,Is_delivering_now varchar(255) ,Switch_to_order_menu varchar(255) ,Price_range varchar(255), Votes varchar(255) 
,Average_Cost_for_two varchar(255) ,Rating varchar(255) ,Datekey_Opening varchar(255));

LOAD DATA  LOCAL INFILE 'C:/Users/Neha/Downloads/Zomata-Main.csv' 
INTO TABLE sheet1 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;

create table sheet2 (countryid int,country_name varchar(50), primary key(countryid));

LOAD DATA  LOCAL INFILE 'C:/Users/Neha/Downloads/Zomata-Country.csv' 
INTO TABLE sheet2 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;

create table sheet3 
   ( currency VARCHAR(50) PRIMARY KEY,
    USD_Rate DECIMAL(10, 4)
);

LOAD DATA  LOCAL INFILE 'C:/Users/Neha/Downloads/Zomata-Currency.csv' 
INTO TABLE sheet3 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;

UPDATE sheet1 SET Datekey_Opening = REPLACE(Datekey_Opening, '_', '/') WHERE Datekey_Opening LIKE '%_%';
alter table sheet1 modify column Datekey_Opening date;
#.....KPI.2.Calender table..................

select * from sheet1;
create view kpi2 as
select year(Datekey_Opening) years,
month(Datekey_Opening)  months, 
day(Datekey_Opening) day ,
monthname(Datekey_Opening) monthname,Quarter(Datekey_Opening)as quarter,
concat(year(Datekey_Opening),'-',monthname(Datekey_Opening)) yearmonth, 
weekday(Datekey_Opening) weekday,
dayname(Datekey_Opening)dayname, 

case when monthname(Datekey_Opening) in ('January' ,'February' ,'March' )then 'Q1'
when monthname(Datekey_Opening) in ('April' ,'May' ,'June' )then 'Q2'
when monthname(Datekey_Opening) in ('July' ,'August' ,'September' )then 'Q3'
else  'Q4' end as quarters,

case when monthname(Datekey_Opening)='January' then 'FM10' 
when monthname(Datekey_Opening)='January' then 'FM11'
when monthname(Datekey_Opening)='February' then 'FM12'
when monthname(Datekey_Opening)='March' then 'FM1'
when monthname(Datekey_Opening)='April'then'FM2'
when monthname(Datekey_Opening)='May' then 'FM3'
when monthname(Datekey_Opening)='June' then 'FM4'
when monthname(Datekey_Opening)='July' then 'FM5'
when monthname(Datekey_Opening)='August' then 'FM6'
when monthname(Datekey_Opening)='September' then 'FM7'
when monthname(Datekey_Opening)='October' then 'FM8'
when monthname(Datekey_Opening)='November' then 'FM9'
when monthname(Datekey_Opening)='December'then 'FM10'
end Financial_months,

case when monthname(Datekey_Opening) in ('January' ,'February' ,'March' )then 'Q4'
when monthname(Datekey_Opening) in ('April' ,'May' ,'June' )then 'Q1'
when monthname(Datekey_Opening) in ('July' ,'August' ,'September' )then 'Q2'
else  'Q3' end as financial_quarters
from sheet1;

#..KPI-3. convert the avg cost for 2column into usd dollars.....

create table currency (
  currency varchar(100),
  Average_Cost_for_two decimal(10,2),
  Average_Cost_in_USD varchar(100)
  );

insert into currency(currency,Average_cost_for_two, Average_Cost_in_usd)

select currency,
         Round(Average_Cost_for_two, 2) as Average_Cost_for_two,
         case
             when currency = 'Indian Rupees(Rs.)'then concat(round(Average_Cost_for_two * 0.0120, 2), '$')
		      when currency = 'Dollar($) 'then concat(round(Average_Cost_for_two * 1.0000, 2), '$')
               when currency = 'Pounds(Œ£)'then concat(round(Average_Cost_for_two * 1.2500, 2), '$')
                when currency = 'NewZealand($)'then concat(round(Average_Cost_for_two * 0.6200, 2), '$')
				 when currency = 'Emirati Diram(AED)'then concat(round(Average_Cost_for_two * 0.2700, 2), '$')
                  when currency = 'Brazilian Real(R$)'then concat(round(Average_Cost_for_two * 0.2000, 2), '$')
				   when currency = 'Turkish Lira(TL)'then concat(round(Average_Cost_for_two * 0.0510, 2), '$')
					when currency = 'Qatari Rial(QR)'then concat(round(Average_Cost_for_two * 0.2700, 2), '$')
                     when currency = 'Rand(R)'then concat(round(Average_Cost_for_two * 0.0520, 2), '$')
                      when currency = 'Botswana Pula(P)'then concat(round(Average_Cost_for_two * 0.0740, 2), '$') 
					   when currency = 'Sri Lankan Rupee(LKR)'then concat(round(Average_Cost_for_two * 0.0032, 2), '$') 
					    when currency = 'Indonesian Rupiah(IDR)'then concat(round(Average_Cost_for_two * 0.00007, 2), '$') 
                    end as Average_Cost_in_USD
from sheet1;

select * from kpi4;
select * from kpi2;
select * from sheet3;
select * from currency;
#...KPI-4.....find the number of restaurant based on city & country....
create view kpi4 as
select sheet2.country_name,sheet1.city,count(restaurantid)no_of_restaurants
from sheet1 inner join sheet2 
on sheet1.country_code=sheet2.countryid 
group by sheet2.country_name,sheet1.city;

#....KPI-5..No. of resturant opening based on year , quarter, month
create view kpi5 as select year(datekey_opening)year,quarter(datekey_opening)quarter,monthname(datekey_opening)monthname,count(restaurantid)as no_of_restaurants 
from sheet1 group by year(datekey_opening),quarter(datekey_opening),monthname(datekey_opening) 
order by year(datekey_opening),quarter(datekey_opening),monthname(datekey_opening) ;

#..KPI-6...No. of resurant based on Avg rating...
create view kpi6 as select case when rating <=2 then "0-2" when rating <=3 then "2-3" when rating <=4 then "3-4" when Rating<=5 then "4-5" end rating_range,count(restaurantid) 
from sheet1 group by rating_range order by rating_range;

#...KPI-7..create buckets based on avg price of reasonable size & no of resturants fall in each buckets..
create view kpi7 as select case when price_range=1 then "0-500" when price_range=2 then "500-3000" when Price_range=3 then "3000-10000" when Price_range=4 then ">10000" end price_range,count(restaurantid)
from sheet1 group by price_range order by Price_range;

#...KPI-8..Percentage of Resturants based on "Has_Table_booking"....
create view kpi8 as select has_online_delivery,concat(round(count(Has_Online_delivery)/100,1),"%") percentage 
from sheet1 group by has_online_delivery;

#...KPI-9..Percentage of Resturants based on "Has_Online_delivery"....
create view kpi9 as select has_table_booking,concat(round(count(has_table_booking)/100,1),"%") percentage from sheet1 group by has_table_booking;

#...KPI-10..Total no of restaurants based on city , cuisines & country ....
create view kpi10 as select sheet2.country_name,sheet1.city,sheet1.cuisines, count(restaurantid)no_of_restaurants
from sheet1 inner join sheet2 
on sheet1.country_code=sheet2.countryid 
group by sheet2.country_name,sheet1.city,sheet1.cuisines;

#...KPI-11.. top 5 restaurants who has more number of votes
create view kpi11 as select  country_name,restaurantname,votes,Average_Cost_for_two from sheet1 inner join sheet2 on sheet1.country_code=sheet2.countryid
group by sheet2.country_name,restaurantname,votes,Average_Cost_for_two
order by votes desc limit 5;

select * from kpi2;
select * from kpi3;
select * from kpi4;
select * from kpi5;
select * from kpi6;
select * from kpi7;
select * from kpi8;
select * from kpi9;
select * from kpi10;
select * from kpi11;
