
--drop view vdepartures;

create view vdepartures as 
select d.id,coalesce(d.invoice,'') invoice,d.branch_id, d.created_at, CASE WHEN d.branch_id IS NULL THEN sta.business ELSE CASE WHEN s.business IS NULL THEN sta.business ELSE s.business END END client,sta.business_name,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,d.warehouse_id,

	CASE WHEN (d.status_id IN(1,8)) THEN 
		(select sum(quantity) from departures_detail where departure_id=d.id)
		ELSE
		(select sum(real_quantity) from departures_detail where departure_id=d.id)
		 END as quantity,

                 CASE 
        WHEN (d.status_id IN(1,8)) 
        THEN (select (round(coalesce(sum(quantity * units_sf * value),0))) from departures_detail JOIN departures ON departures.id= departures_detail.departure_id where departure_id=d.id)
        ELSE (
                select coalesce(sum(real_quantity * units_sf * value),0) 
                from departures_detail 
                JOIN departures ON departures.id= departures_detail.departure_id 
                where departures.id=d.id) 
        END  as subtotalnumeric,

		d.subtotal as subtotalnumeric2,	
CASE WHEN (d.status_id IN(1,8)) 
        THEN 
		(select sum(quantity * (CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END)) 
                from departures_detail where departure_id=d.id)
        ELSE 
		(
                select sum(real_quantity * (CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END)) 
                from departures_detail where departure_id=d.id)
		 END as quantity_packaging,

          CASE WHEN (d.status_id IN(1,8)) THEN 
		(select (round(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0))) 
         from departures_detail JOIN departures ON departures.id= departures_detail.departure_id where departure_id=d.id)
		 ELSE 
		(select (round(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0))) 
                from sales_detail JOIN sales ON sales.id= sales_detail.sale_id where departure_id=d.id)
		 END+coalesce(d.shipping_cost,0)-coalesce(d.discount,0) +(Coalesce(d.shipping_cost,0) * coalesce(d.shipping_cost_tax,0) ) 
         as total,
        d.total as total2,
            
		CASE WHEN (d.status_id IN (1,8)) THEN 
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from departures_detail JOIN departures ON departures.id= departures_detail.departure_id where departure_id=d.id and departures_detail.tax=0.19)
		ELSE
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from sales_detail JOIN sales ON sales.id= sales_detail.sale_id where sales.departure_id=d.id and sales_detail.tax=0.19) 
            END as tax19,
            CASE WHEN (d.status_id IN(1,8)) THEN 
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from departures_detail JOIN departures ON departures.id= departures_detail.departure_id where departure_id=d.id and departures_detail.tax=0.05)
        ELSE
		(select round(coalesce(sum(quantity * units_sf * value * tax),0)) from sales_detail JOIN sales ON sales.id= sales_detail.sale_id where sales.departure_id=d.id and sales_detail.tax=0.05) 
            END as tax5,   
            
             ( SELECT sum(vcreditnote_detail_row.valuetotaltax) AS sum
           FROM vcreditnote_detail_row
             JOIN credit_note c_1 ON c_1.id = vcreditnote_detail_row.id
          WHERE c_1.departure_id = d.id) AS credit_note,d.discount,
           sta.id as client_id,d.created,dest.description as destination,d.destination_id,d.shipping_cost,d.dispatched ,d.paid_out,d.description,d.remission
            from departures d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN stakeholder sta ON sta.id = d.client_id
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN cities dest ON dest.id = d.destination_id
            JOIN parameters p ON p.code = d.status_id AND p.group='entry'
            JOIN users u ON u.id = d.responsible_id





