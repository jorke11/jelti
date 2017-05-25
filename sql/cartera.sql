       select d.id,d.consecutive,coalesce(d.invoice,'') invoice, coalesce(s.business_name,'') as client,w.description as warehouse,
            c.description as city,p.description status,d.status_id,d.responsible_id,u.name ||' '|| u.last_name as responsible,
            s.term, d.created_at,d.created_at + CAST(s.term || ' days' AS INTERVAL),date_part('day',now()-(d.created_at + CAST(s.term || ' days' AS INTERVAL)))
            from departures d
            JOIN branch_office s ON s.id = d.branch_id
            
            JOIN warehouses w ON w.id = d.warehouse_id
            JOIN cities c ON c.id = d.city_id
            JOIN parameters p ON p.id = d.status_id
            JOIN users u ON u.id = d.responsible_id
            WHERE p.group='entry'
            ORDER BY d.id DESC;