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


CREATE VIEW vclient AS
SELECT s.id,s.business_name,s.business,coalesce(s.name,'') as name,coalesce(s.last_name,'') as last_name,s.document,s.email,coalesce(s.address,'') as address,s.phone,
s.contact,s.phone_contact,s.term,c.description as city,s.web_site,coalesce(typeperson.description,'') as typeperson,typeregime.description as typeregime,
typestakeholder.description as typestakeholder,status.description as status,s.responsible_id
FROM stakeholder s
JOIN cities c ON c.id=s.city_id
LEFT JOIN parameters as typeperson ON typeperson.code=s.type_person_id and typeperson."group"='typeperson'
LEFT JOIN parameters as typeregime ON typeregime.code=s.type_regime_id and typeregime."group"='typeregime'
LEFT JOIN parameters as typestakeholder ON typestakeholder.code=s.type_stakeholder and typestakeholder."group"='typestakeholder'
LEFT JOIN parameters as status ON status.code=s.status_id and status."group"='generic'
WHERE s.type_stakeholder=1;


create view vproducts as
select p.id,p.title,substring(p.description from 1 for 30) || ' ...' as description,s.business as supplier,p.reference,p.bar_code,p.units_supplier,p.units_sf,p.cost_sf,p.tax,p.price_sf,
p.price_cust,p.image,status.description as status
from products p
JOIN stakeholder s ON s.id=p.supplier_id
LEFT JOIN parameters as status ON status.code=p.status_id and status."group"='generic';

create view vdepartures as 

            select d.id,coalesce(d.invoice,'') invoice, d.created_at, coalesce(s.business_name ,sta.business_name) as client,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,d.warehouse_id,
            (select coalesce(sum(quantity),0)::int from departures_detail where departure_id=d.id) quantity,
            (select coalesce(sum(quantity * units_sf * value),0)::money from departures_detail where departure_id=d.id) subtotal,
            (select coalesce(sum(quantity * units_sf * value),0) from departures_detail where departure_id=d.id) subtotalnumeric,sta.id as client_id,d.created

            from departures d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN stakeholder sta ON sta.id = d.client_id
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN parameters p ON p.id = d.status_id
            JOIN users u ON u.id = d.responsible_id
            WHERE p.group='entry'
            ORDER BY d.status_id,d.id asc

create view vcities as 
select c.id,c.description city,d.description department,c.code
from cities c
join departments d ON d.id=c.department_id;


create view vpurchases as 
select p.id, p.consecutive,coalesce(p.description,'') as description,p.created_at,s.business || ' '|| s.business_name as stakeholder,w.description as warehouse,c.description as city,param.description as status,
p.responsible_id
from purchases p
JOIN stakeholder s ON s.id=p.supplier_id
JOIN warehouses w ON w.id=p.warehouse_id
JOIN cities c ON c.id=p.city_id
JOIN parameters param ON param.id=p.status_id and param.group='entry';

create view vcontacts as 
select c.id,c.name,c.last_name,c.email,c.mobile,ci.description city,c.stakeholder_id
from contacts c
JOIN cities ci ON ci.id=c.city_id


create view ventries as 
select e.id, e.consecutive,e.description,e.created_at,e.invoice, w.description as warehouse,c.description as city, p.description as status,p.code
From entries e
JOIN warehouses w ON w.id=e.warehouse_id
JOIN cities c ON c.id=e.city_id
JOIN parameters p ON p.code=e.status_id and p.group='entry'
ORDER BY p.code


create view vcreditnote as 
             select d.id,d.consecutive,coalesce(d.invoice,'') invoice, d.created_at, coalesce(s.business_name,'') as client,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,(select count(*) from credit_note where credit_note.departure_id=d.id) credit_note
            from departures d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN parameters p ON p.id = d.status_id
            JOIN users u ON u.id = d.responsible_id
            WHERE p.group='entry' and d.invoice IS NOT NULL
            ORDER BY d.id DESC;

