
create or replace function invoice() returns trigger as $invoice$
declare 
newinvoice integer;
newin text;
begin 
	IF NEW.status_id = 2  THEN
		newinvoice :=(select current + 1 from consecutives where id=1);
		newin :=newinvoice::text;
		update departures set invoice='1' where id =102;
		update consecutives set current=newinvoice::int where id=1;
	end IF;
	return NEW;
END;
$invoice$ language plpgsql;



create trigger invoice AFTER INSERT OR UPDATE ON departures
	for each row execute procedure invoice();


select * from departures where consecutive='dep0067'
update departures set status_id=2 where id=102

select * from consecutives
update departures set invoice=1 where id =102;
