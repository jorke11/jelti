CREATE OR REPLACE FUNCTION invoice() RETURNS trigger AS $invoice$
	DECLARE consecutivo int;
	BEGIN
		consecutivo:=(select current+1 from consecutive WHERE id=1);
		update consecutives set current=consecutivo where id=1;
		update departures set consecutive = consecutivo where id=NEW.id;
		
	return NEW;
	END;

$invoice$ LANGUAGE plpgsql;

CREATE TRIGGER invoice BEFORE INSERT OR UPDATE ON departures
    FOR EACH ROW EXECUTE PROCEDURE invoice();


