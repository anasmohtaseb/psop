ALTER TABLE registrations ADD COLUMN track_id INT NULL AFTER competition_edition_id;
ALTER TABLE registrations ADD CONSTRAINT fk_registrations_track FOREIGN KEY (track_id) REFERENCES competition_tracks(id) ON DELETE SET NULL;
