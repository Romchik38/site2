-- create a function
CREATE OR REPLACE FUNCTION article_tsvector_update() RETURNS trigger AS $$
DECLARE
  lang_config regconfig;
BEGIN
  lang_config := CASE LOWER(NEW.language)
    WHEN 'en' THEN 'english'
    WHEN 'uk' THEN 'ukrainian'
    ELSE 'english' -- default
  END::regconfig;

  NEW.tsv := to_tsvector(lang_config, NEW.description) || to_tsvector(lang_config, NEW.name);
  RETURN NEW;
END
$$ LANGUAGE plpgsql;

-- create a trigger
CREATE TRIGGER trg_article_tsvector_update
BEFORE INSERT OR UPDATE ON article_translates
FOR EACH ROW
EXECUTE FUNCTION article_tsvector_update();