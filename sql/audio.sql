CREATE TABLE audio
(
    identifier serial NOT NULL PRIMARY KEY,
    active boolean NOT NULL DEFAULT false,
    name text not NULL
);

CREATE table
    audio_translates(
        audio_id int NOT NULL REFERENCES audio (identifier) ON UPDATE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE,
        description text NOT NULL,
        path text NOT NULL
    );

INSERT INTO audio (identifier, active, name) VALUES
    (1, 't', 'Audio for article - Simplification of the drivers license examination process'),
    (2, 't', 'Audio for article - Document verification for drivers'),
    (3, 't', 'Audio for article - Evidence in administrative offense cases key aspects')
;        

INSERT INTO audio_translates (audio_id, language, description, path) VALUES
    (1,'en','Simplification of the driver''s license examination process audio','articles/simplification-of-the-drivers-license-examination-process/en-simplification-of-the-driver''s-license-examination-process.mp3'),
    (1,'uk','Спрощення процесу складання іспитів на права аудіо','articles/simplification-of-the-drivers-license-examination-process/uk-sproshennya-procesu-skladannya-ispitiv-na-prava.mp3'),
    (2,'en','Document Verification for Drivers by Police Officers: Updated Requirements and Procedures','articles/document-verification-for-drivers/en-Changes-in-driver-document.mp3'),
    (2,'uk','Перевірка документів у водіїв працівниками поліції: оновлені вимоги та процедури','articles/document-verification-for-drivers/uk-perevirka-dokumentiv-u-vodiiv-transportnih-zasobiv.mp3'),
    (3,'en','Evidence in Administrative Offense Cases: Key Aspects','articles/evidence-in-administrative-offense-cases-key-aspects/en-evidence-in-administrative-offense-cases-key-aspects.mp3'),
    (3,'uk','Докази по справі про адміністративне правопорушення: ключові аспекти','articles/evidence-in-administrative-offense-cases-key-aspects/uk-evidence-in-administrative-offense-cases-key-aspects.mp3')
;