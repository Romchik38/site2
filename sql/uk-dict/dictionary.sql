-- Creating a dictionary
CREATE TEXT SEARCH DICTIONARY ukrainian_huns (
    TEMPLATE = ispell,
    DictFile = uk_UA,
    AffFile = uk_UA,
    StopWords = ukrainian
);

-- Creating a dictionary of stop words
CREATE TEXT SEARCH DICTIONARY ukrainian_stem (
    template = simple,
    stopwords = ukrainian
);

-- Creating a configuration
CREATE TEXT SEARCH CONFIGURATION ukrainian (PARSER=default);

-- Configuration settings
ALTER TEXT SEARCH CONFIGURATION ukrainian ALTER MAPPING FOR  hword, hword_part, word WITH ukrainian_huns, ukrainian_stem;
ALTER TEXT SEARCH CONFIGURATION ukrainian ALTER MAPPING FOR  int, uint, numhword, numword, hword_numpart, email, float, file, url, url_path, version, host, sfloat WITH simple;
ALTER TEXT SEARCH CONFIGURATION ukrainian ALTER MAPPING FOR asciihword, asciiword, hword_asciipart WITH english_stem;
