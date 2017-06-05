--total las ventas
select d.id,p.id as product_id,d.quantity,d.value,d.units_sf,p.title,p.units_sf,(d.value*d.quantity*d.units_sf) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null

--product x total cantidades y total valor
create or replace view vreportproduct as 
select p.title as product,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf)) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null
group by 1
order by 2 DESC


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
create or replace view vreportclient as 
select cli.business,sum(d.quantity) totalunidades,sum(d.value*d.quantity*d.units_sf) total
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN departures dep ON dep.id=s.departure_id
JOIN stakeholder cli ON cli.id=s.client_id
where product_id is not null
group by 1
order by 3 desc