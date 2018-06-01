CREATE OR REPLACE VIEW vstock AS
select to_char(e.created_at,'DD-MM-yyyy') as date,p.title product,coalesce(sum(e.real_quantity),0) entries,
coalesce((select sum(quantity) from purchases_detail where product_id=e.product_id),0) purchases,
coalesce((select sum(quantity) from departures_detail where product_id=e.product_id),0) departures,
coalesce((select sum(quantity) from sales_detail where product_id=e.product_id),0) sales,
(coalesce(sum(e.real_quantity),0))
- (coalesce((select sum(quantity) from departures_detail where product_id=e.product_id),0) +coalesce((select sum(quantity) from sales_detail where product_id=e.product_id),0)) available
from entries_detail e
JOIN products p ON p.id=e.product_id
group by 1,2,e.product_id;



CREATE VIEW vsupplier AS
SELECT s.id,s.business_name,s.business,coalesce(s.name,'') as name,coalesce(s.last_name,'') as last_name,s.document,s.email,coalesce(s.address,'') as address,s.phone,
s.contact,s.phone_contact,s.term,c.description as city,s.web_site,coalesce(typeperson.description,'') as typeperson,typeregime.description as typeregime,
typestakeholder.description as typestakeholder,status.description as status,s.responsible_id
FROM stakeholder s
JOIN cities c ON c.id=s.city_id
LEFT JOIN parameters as typeperson ON typeperson.code=s.type_person_id and typeperson."group"='typeperson'
LEFT JOIN parameters as typeregime ON typeregime.code=s.type_regime_id and typeregime."group"='typeregime'
LEFT JOIN parameters as typestakeholder ON typestakeholder.code=s.type_stakeholder and typestakeholder."group"='typestakeholder'
LEFT JOIN parameters as status ON status.code=s.status_id and status."group"='generic'
WHERE s.type_stakeholder=2;


--﻿﻿drop view vclient
CREATE VIEW vclient AS
SELECT s.id,s.business_name,s.business,coalesce(s.name,'') as name,coalesce(s.last_name,'') as last_name,s.document,s.email,coalesce(s.address_send,'') as address,s.phone,
s.contact,s.phone_contact,s.term,c.description as city,s.web_site,coalesce(typeperson.description,'') as typeperson,typeregime.description as typeregime,
typestakeholder.description as typestakeholder,status.description as status,s.responsible_id,coalesce(u.name,'') ||' '||coalesce(u.last_name,'') as responsible,
s.created_at,s.address_invoice,send.description city_invoice,(select dispatched from sales where client_id=s.id and dispatched is not null order by 1 desc limit 1) last_invoice,s.sector_id,
sector.description sector,s.updated_at
FROM stakeholder s
JOIN cities c ON c.id=s.city_id
LEFT JOIN cities send ON send.id=s.invoice_city_id
LEFT JOIN users as u ON u.id=s.responsible_id
LEFT JOIN parameters as typeperson ON typeperson.code=s.type_person_id and typeperson."group"='typeperson'
LEFT JOIN parameters as typeregime ON typeregime.code=s.type_regime_id and typeregime."group"='typeregime'
LEFT JOIN parameters as sector ON sector.code=s.sector_id and sector."group"='sector'
LEFT JOIN parameters as typestakeholder ON typestakeholder.code=s.type_stakeholder and typestakeholder."group"='typestakeholder'
JOIN parameters as status ON status.code=s.status_id and status."group"='generic'
WHERE s.type_stakeholder=1 


drop view vproducts
create view vproducts as
select p.id,p.title,substring(p.description from 1 for 30) || ' ...' as description,s.business as supplier,p.reference,p.bar_code,p.units_supplier,p.units_sf,
p.cost_sf,p.tax,p.price_sf,
(select path from products_image where product_id=p.id and main=true limit 1) as image,
(select thumbnail from products_image where product_id=p.id and main=true limit 1) as thumbnail,status.description as status,p.status_id,p.category_id,p.supplier_id,
p.short_description,p.packaging,p.characteristic,p.about,p.why,p.ingredients,p.warehouse,p.slug,cat.description as category,p.minimum_stock
from products p
JOIN stakeholder s ON s.id=p.supplier_id
JOIN categories cat ON cat.id=p.category_id
LEFT JOIN parameters as status ON status.code=p.status_id and status."group"='generic'
WHERE p.type_product_id IS NULL



create view vservices as
select p.id,p.title,substring(p.description from 1 for 30) || ' ...' as description,s.business as supplier,p.reference,p.bar_code,p.units_supplier,p.units_sf,p.cost_sf,p.tax,p.price_sf,
p.image,status.description as status
from products p
JOIN stakeholder s ON s.id=p.supplier_id
LEFT JOIN parameters as status ON status.code=p.status_id and status."group"='generic'
WHERE p.type_product_id IS NOT NULL




--drop view vdepartures;
--drop view vsamples
create view vsamples as 

select d.id,coalesce(d.invoice,'') invoice,d.branch_id, d.created_at, CASE WHEN d.branch_id IS NULL THEN sta.business ELSE CASE WHEN s.business IS NULL THEN sta.business ELSE s.business END END client,sta.business_name,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,d.warehouse_id,

	CASE WHEN (d.status_id IN(1,8)) THEN 
		(select sum(quantity) from samples_detail where sample_id=d.id)
		ELSE
		(select sum(real_quantity) from samples_detail where sample_id=d.id)
		 END as quantity,
               
        CASE WHEN (d.status_id IN(1,8)) 
        THEN 
		(select sum(quantity * (CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END)) from samples_detail where sample_id=d.id)
        ELSE 
		(select sum(real_quantity * (CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END)) from samples_detail where sample_id=d.id)
		 END as quantity_packaging,
            
        CASE WHEN (d.status_id IN(1,8)) THEN 
		(select (round(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0))) 
         from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id)
		 ELSE 
		(select (round(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0))) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id)
		 END+coalesce(d.shipping_cost,0)-coalesce(d.discount,0) +(Coalesce(d.shipping_cost,0) * coalesce(d.shipping_cost_tax,0) ) 
         as total,
		 (select (round(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0))) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id) 
		 +coalesce(d.shipping_cost,0)-coalesce(d.discount,0) as totalnew,
		 
		CASE 
        WHEN (d.status_id IN(1,8)) 
        THEN (select (round(coalesce(sum(quantity * units_sf * value),0))) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id)
        ELSE (
                select coalesce(sum(real_quantity * units_sf * value),0) 
                from samples_detail 
                JOIN samples ON samples.id= samples_detail.sample_id 
                where samples.id=d.id) 
        END  as subtotal,	 
        
        (select (round(coalesce(sum(quantity * units_sf * value),0))) 
        	from samples_detail 
         	JOIN samples ON samples.id= samples_detail.sample_id 
         	where sample_id=d.id) 
            as subtotalnew,
            
		CASE WHEN (d.status_id IN (1,8)) THEN 
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id and samples_detail.tax=0.19)
		ELSE
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from samples_detail JOIN sales ON sales.id= samples_detail.sample_id where samples_detail.sample_id=d.id and samples_detail.tax=0.19) 
            END as tax19,
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id and samples_detail.tax=0.19)
		as tax19new,
            
            CASE WHEN (d.status_id IN(1,8)) THEN 
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id and samples_detail.tax=0.05)
        ELSE
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from samples_detail JOIN sales ON sales.id= samples_detail.sample_id where samples_detail.sample_id=d.id and samples_detail.tax=0.05) 
            END as tax5,
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from samples_detail JOIN samples ON samples.id= samples_detail.sample_id where sample_id=d.id and samples_detail.tax=0.05)
		as tax5new,   
             d.discount,
            
           sta.id as client_id,d.created,dest.description as destination,d.destination_id,d.shipping_cost,d.dispatched ,d.paid_out,d.description
            from samples d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN stakeholder sta ON sta.id = d.client_id
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN cities dest ON dest.id = d.destination_id
            JOIN parameters p ON p.code = d.status_id AND p.group='entry'
            JOIN users u ON u.id = d.responsible_id


drop view vsample
create view vsample as 
select d.id,coalesce(d.invoice,'') invoice,d.branch_id, d.created_at, CASE WHEN d.branch_id IS NULL THEN sta.business ELSE CASE WHEN s.business IS NULL THEN sta.business ELSE s.business END END client,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,d.warehouse_id,
            (select coalesce(sum(quantity),0)::int from samples_detail where sample_id=d.id) quantity,
            (select coalesce(sum(quantity),0)::int from samples_detail where samples_detail.sample_id=d.id) quantity_packaging,
		d.total,d.subtotal, sta.id as client_id,d.created,dest.description as destination,d.destination_id,d.shipping_cost,d.dispatched
            from samples d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN stakeholder sta ON sta.id = d.client_id
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN cities dest ON dest.id = d.destination_id
            JOIN parameters p ON p.code = d.status_id AND p.group='entry'
            JOIN users u ON u.id = d.responsible_id
            ORDER BY d.status_id,d.id asc;


create view vcities as 
select c.id,c.description city,d.description department,c.code
from cities c
join departments d ON d.id=c.department_id;


create or replace view vpurchases as 
select p.id,coalesce(p.description,'') as description,p.warehouse_id,p.created_at,s.business || ' '|| s.business_name as business,w.description as warehouse,c.description as city,param.description as status,
p.responsible_id
from purchases p    
JOIN stakeholder s ON s.id=p.supplier_id
JOIN warehouses w ON w.id=p.warehouse_id
JOIN cities c ON c.id=p.city_id
JOIN parameters param ON param.id=p.status_id and param.group='entry'
ORDER BY p.id DESC;

create view vcontacts as 
select c.id,c.name,c.last_name,c.email,c.mobile,ci.description city,c.stakeholder_id
from contacts c
LEFT JOIN cities ci ON ci.id=c.city_id


create view ventries as 
select e.id, s.business,e.description,e.created_at,e.invoice, w.description as warehouse,c.description as city, p.description as status,p.code,e.status_id,
e.responsible_id,e.warehouse_id
From entries e
JOIN warehouses w ON w.id=e.warehouse_id
JOIN stakeholder s ON s.id=e.supplier_id
JOIN cities c ON c.id=e.city_id
JOIN parameters p ON p.code=e.status_id and p.group='entry'
ORDER BY p.code


--     drop view vcreditnote
create view  vcreditnote as 
            select id,coalesce(invoice,'') invoice, created_at, client,warehouse,
            city,status,status_id,responsible_id, responsible,subtotal,total,
            (select count(*) from credit_note where credit_note.departure_id=vdepartures.id) credit_note_quantity,
            (select array_agg(id) from credit_note where credit_note.departure_id=vdepartures.id) credit_note_dep,credit_note
            from vdepartures
            WHERE status_id IN (2,7)
            ORDER BY id DESC;


create view vcreditnote_detail as 
select c.id,d.invoice,d.client ,d.id as departure_id
from credit_note c  
JOIN vdepartures d ON d.id=c.departure_id


drop view vbranch_office
CREATE VIEW vbranch_office AS
SELECT s.id,s.business_name,coalesce(s.business,'') as business,s.document,s.email,coalesce(s.address_send,'') as address,s.mobile,
s.term,c.description as city,s.web_site,status.description as status,s.stakeholder_id
FROM branch_office s
JOIN cities c ON c.id=s.city_id
JOIN parameters as status ON status.code=s.status_id and status."group"='generic'



drop view vprice_special
create view vprice_special as
select s.id,s.client_id,stake.business client,s.product_id,p.title product,p.reference,s.price_sf::money,s.margin,s.margin_sf,s.tax,s.item,s.packaging
from prices_special s
JOIN stakeholder stake On stake.id=s.client_id
JOIN products p On p.id=s.product_id;


drop view vcreditnote_detail_row
create view vcreditnote_detail_row as 
select c.id,d.quantity,s.tax,p.title product,s.product_id,s.value,s.units_sf,st.business as stakeholder,d.quantity * s.units_sf as  quantitytotal,
d.quantity * s.units_sf* s.value as valuetotal,(d.quantity * s.units_sf* s.value * s.tax) + (d.quantity * s.units_sf* s.value) as valuetotaltax,c.created_at
from credit_note_detail d
LEFT JOIN credit_note c ON c.id=d.creditnote_id
LEFT JOIN departures_detail s ON s.departure_id=c.departure_id and s.product_id=d.product_id
LEFT JOIN products p ON p.id=d.product_id
LEFT JOIN stakeholder st ON st.id=p.supplier_id


create view vcategories as 
select c.id,c.description,c.image,c.order,c.short_description,
CASE WHEN c.status_id = 1 THEN 'Activo' ELSE 'Inactivo' END status, c.banner,c2.description as node
from categories c
LEFT JOIN categories c2 ON c2.id=c.node_id

drop view vcategories_blog

create view vcategories_blog as 
select c.id,c.description,c.image,c.order,c.short_description,
CASE WHEN c.status_id = 1 THEN 'Activo' ELSE 'Inactivo' END status, c.banner,c2.description as node
from categories_blog c
LEFT JOIN categories_blog c2 ON c2.id=c.node_id


create view vtransfer as 
select t.id,w.description origin, d.description destination,t.created_at,t.status_id
from transfer t
JOIN warehouses w ON w.id=t.origin_id
JOIN warehouses d ON d.id=t.destination_id

create view vusers as 
select  users.id,users.name,users.last_name,stakeholder.business as stakeholder,users.email,users.document,roles.description as role,cities.description as city,parameters.description as status
from users
JOIN roles ON roles.id =users.role_id
LEFT JOIN stakeholder ON stakeholder.id= users.stakeholder_id
LEFT JOIN cities ON cities.id =users.city_id
LEFT JOIN parameters ON parameters.code = users.status_id and parameters.group='generic'


select i.id,w.description as warehouse,p.title as product,i.cost_sf,i.price_sf,i.quantity
from inventory i
JOIN products p ON p.id=i.product_id
JOIN warehouses w ON w.id=i.warehouse_id