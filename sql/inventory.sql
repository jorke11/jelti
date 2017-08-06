
select w.description,SUM(d.quantity) entradas,pro.title,pro.reference,
(
select SUM(d.quantity) 
from sales_detail d 
JOIN sales s ON s.id=d.sale_id
JOIN warehouses w ON w.id=s.warehouse_id
where d.product_id IS NOT NULL
AND d.product_id IN (select id from products where bar_code='7503008669000')
AND s.warehouse_id=2
) salidas,SUM(d.quantity)-(
select SUM(d.quantity) 
from sales_detail d 
JOIN sales s ON s.id=d.sale_id
JOIN warehouses w ON w.id=s.warehouse_id
where d.product_id IS NOT NULL
AND d.product_id IN (select id from products where bar_code='7503008669000')
AND s.warehouse_id=2
) total
from entries_detail d
JOIN entries en ON en.id=d.entry_id
JOIN warehouses w ON w.id=en.warehouse_id
JOIN products pro ON pro.id=d.product_id
WHERE en.status_id=2 
AND d.product_id IN (select id from products where bar_code='7503008669000')
AND en.warehouse_id=2
group by w.description,pro.title,pro.reference


---

select products.id,products.title,sum(entries_detail.quantity) entradas,
coalesce((select sum(quantity) from sales_detail where product_id=products.id and product_id IS NOT NULL),0) salidas,
sum(entries_detail.quantity) - coalesce((select sum(quantity) from sales_detail where product_id=products.id and product_id IS NOT NULL),0) total
from products
JOIN entries_detail ON entries_detail.product_id=products.id
JOIN entries ON entries.id = entries_detail.entry_id and entries.status_id=2
group by 1
order by 5 desc


