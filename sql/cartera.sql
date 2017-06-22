drop view vbriefcase
            create view vbriefcase as 
       select d.id,coalesce(d.invoice,'') invoice, coalesce(s.business_name,'') as client,
            c.description as city,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,
            s.term, d.created_at,d.created_at + CAST(s.term || ' days' AS INTERVAL) as fecha_vencimiento,
            date_part('day',now()-(d.created_at + CAST(s.term || ' days' AS INTERVAL))) as dias_vencidos,d.paid_out,d.client_id,
            (select (ceil(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0)) + d.shipping_cost)::money from departures_detail where departure_id=d.id) totalFormated,
           (select (ceil(coalesce(sum(quantity * units_sf * value * tax),0) + coalesce(sum(quantity * units_sf * value),0)) + d.shipping_cost) from departures_detail where departure_id=d.id) total
            from departures d
            JOIN branch_office s ON s.id = d.branch_id
            JOIN cities c ON c.id = d.city_id
            JOIN users u ON u.id = d.responsible_id
            WHERE d.status_id=2 
            AND date_part('day',now()-(d.created_at + CAST(s.term || ' days' AS INTERVAL))) < 5
            ORDER BY  (d.created_at + CAST(s.term || ' days' AS INTERVAL),date_part('day',now()-(d.created_at + CAST(s.term || ' days' AS INTERVAL)))) DESC;