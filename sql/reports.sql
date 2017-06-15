--total las ventas
select d.id,p.id as product_id,d.quantity,d.value,d.units_sf,p.title,p.units_sf,(d.value*d.quantity*d.units_sf) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null

--product x total cantidades y total valor
create or replace view vreportproduct as 
select s.created,p.title as product,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf)) as total
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN products p ON p.id=d.product_id  
where product_id is not null
group by 1,2
order by 3 DESC



--total Ventas
select round(sum(d.value * d.quantity * d.units_sf)) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null

-- Proveedor por productos
select s.business proveedor,p.title producto,round(sum(d.quantity*d.units_sf)) unidades,round(sum(d.value * d.quantity * d.units_sf)) total
from sales_detail d
JOIN products p ON p.id=d.product_id  
JOIN stakeholder s ON s.id=p.supplier_id  
where product_id is not null
group by 1,2
order by 4 desc

-- Compras Proveedor
select s.business proveedor,round(sum(d.quantity*d.units_sf)) unidades,round(sum(d.value * d.quantity * d.units_sf)) total
from sales_detail d
JOIN products p ON p.id=d.product_id  
JOIN stakeholder s ON s.id=p.supplier_id  
where product_id is not null
group by 1
order by 3 desc


CREATE OR REPLACE VIEW public.vreportsupplier AS 
 SELECT s.business,
    round(sum(d.quantity::numeric * d.units_sf)) AS totalunidades,
    round(sum(d.value * d.quantity::numeric * d.units_sf)) AS total
   FROM sales_detail d
     JOIN products p ON p.id = d.product_id
     JOIN stakeholder s ON s.id = p.supplier_id
  WHERE d.product_id IS NOT NULL
  GROUP BY s.business
  ORDER BY (round(sum(d.value * d.quantity::numeric * d.units_sf))) DESC;

--ventas por comercial
create or replace view vreportcommercial as 
select u.name ||' '|| u.last_name as vendedor,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf)) total
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN users u ON u.id=s.responsible_id
group by 1
order by 2 desc

--informe ventas por cliente
create view vdepartures as 

            select d.id,coalesce(d.invoice,'') invoice, d.created_at,d.created ,coalesce(sta.business_name ,sta.business_name) as client,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,d.warehouse_id,sta.id as client_id
            from departures d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN stakeholder sta ON sta.id = d.client_id
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN parameters p ON p.id = d.status_id
            JOIN users u ON u.id = d.responsible_id
            WHERE p.group='entry'
            ORDER BY d.status_id,d.id asc


---totales por meses
select substring(s.created::text from 1 for 7),sum(d.quantity*d.value*d.units_sf)
from sales_detail d
JOIN sales s ON s.id=d.sale_id
group by 1