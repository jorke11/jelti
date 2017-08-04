----drop view vbriefcase;
create view vbriefcase as 
select d.id,coalesce(d.invoice,'') invoice,  coalesce(s.business_name ,sta.business_name) as client,
            c.description as city,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,
            s.term, d.created_at,d.created_at + CAST(s.term || ' days' AS INTERVAL) as fecha_vencimiento,
            date_part('day',now()-(d.created_at + CAST(s.term || ' days' AS INTERVAL))) as dias_vencidos,d.paid_out,d.client_id,
            (select (coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0) + d.shipping_cost)::money from departures_detail where departure_id=d.id and product_id is not null) totalFormated,
           (select (ceil(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0)) + d.shipping_cost) from departures_detail where departure_id=d.id and product_id is not null) total,
           (select sum(value) from briefcase where departure_id=d.id) payed,(select sum(value)::money from briefcase where departure_id=d.id) payedformated
            from departures d
            LEFT JOIN branch_office s ON s.id = d.branch_id
            JOIN stakeholder sta ON sta.id = d.client_id
            JOIN cities c ON c.id = d.city_id
            JOIN users u ON u.id = d.responsible_id
            WHERE d.status_id=2  and (paid_out = false OR paid_out is null)
            ORDER BY  (d.created_at + CAST(s.term || ' days' AS INTERVAL),date_part('day',now()-(d.created_at + CAST(s.term || ' days' AS INTERVAL)))) DESC;

