select d.id,p.id as product_id,d.quantity,d.value,d.units_sf,p.title,p.units_sf,(d.value*d.quantity*d.units_sf) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null


select p.id as product_id,p.title,sum(d.quantity) cantidadTotal,round(sum(d.value * d.quantity * d.units_sf)) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null
group by p.id,2
order by round(sum(d.value * d.quantity * d.units_sf)) DESC



select round(sum(d.value * d.quantity * d.units_sf)) as total
from sales_detail d
JOIN products p ON p.id=d.product_id  
where product_id is not null


select s.id,s.business proveedor,p.title producto,round(sum(d.quantity*d.units_sf)) unidades,round(sum(d.value * d.quantity * d.units_sf)) total
from sales_detail d
JOIN products p ON p.id=d.product_id  
JOIN stakeholder s ON s.id=p.supplier_id  
where product_id is not null
group by 1,2,3
order by round(sum(d.value * d.quantity * d.units_sf)) desc


select u.name,round(sum(d.value * d.quantity * d.units_sf)) total
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN users u ON u.id=s.responsible_id
group by 1

select cli.id,cli.business,round(sum(d.value * d.quantity * d.units_sf)) total
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN stakeholder cli ON cli.id=s.client_id
where product_id is not null
group by 1
order by round(sum(d.value * d.quantity * d.units_sf)) desc



select d.id,d.product_id,dep.invoice,d.value,d.quantity,sum(d.value*d.quantity*d.units_sf)
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN departures dep ON dep.id=s.departure_id
JOIN stakeholder cli ON cli.id=s.client_id
where product_id is not null
and cli.id=185
group by 1,2,3,4


select sum(d.value*d.quantity*d.units_sf)
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN departures dep ON dep.id=s.departure_id
JOIN stakeholder cli ON cli.id=s.client_id
where product_id is not null
and dep.invoice='0002933'
and cli.id=185




select sum(d.value*d.quantity*d.units_sf)
from sales_detail d
JOIN sales s ON s.id=d.sale_id
JOIN stakeholder cli ON cli.id=s.client_id
where product_id is not null
and cli.id=185
