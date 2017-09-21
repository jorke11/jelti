create view vbriefcase as 
drop view vbriefcase;
create view vbriefcase as 
select d.id,invoice,client,d.business_name,
            city,d.status_id,d.responsible_id,d.responsible,
            s.term, d.created_at,d.dispatched,
            d.dispatched + CAST(s.term || ' days' AS INTERVAL) as fecha_vencimiento,
            date_part('day',now() - (d.dispatched + CAST(s.term || ' days' AS INTERVAL))) as dias_vencidos,
            d.paid_out,d.client_id,
           d.total,
           (select sum(value) from briefcase where departure_id=d.id) payed,(select sum(value)::money from briefcase where departure_id=d.id) payedformated
            from vdepartures d
            JOIN stakeholder s ON s.id=d.client_id
            WHERE d.status_id IN(2,7) 
            ORDER BY  date_part('day',now() - (d.dispatched + CAST(s.term || ' days' AS INTERVAL))) DESC,d.dispatched
            
