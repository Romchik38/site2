--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4 (Debian 17.4-1.pgdg120+2)
-- Dumped by pg_dump version 17.4 (Debian 17.4-1.pgdg120+2)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: admin_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin_roles (
    identifier integer NOT NULL,
    name text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.admin_roles OWNER TO postgres;

--
-- Name: admin_roles_identifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admin_roles_identifier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admin_roles_identifier_seq OWNER TO postgres;

--
-- Name: admin_roles_identifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admin_roles_identifier_seq OWNED BY public.admin_roles.identifier;


--
-- Name: admin_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin_users (
    identifier integer NOT NULL,
    username text NOT NULL,
    password_hash text NOT NULL,
    active boolean DEFAULT false NOT NULL,
    email text NOT NULL
);


ALTER TABLE public.admin_users OWNER TO postgres;

--
-- Name: admin_users_identifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.admin_users_identifier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admin_users_identifier_seq OWNER TO postgres;

--
-- Name: admin_users_identifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.admin_users_identifier_seq OWNED BY public.admin_users.identifier;


--
-- Name: admin_users_with_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin_users_with_roles (
    user_id integer NOT NULL,
    role_id integer NOT NULL
);


ALTER TABLE public.admin_users_with_roles OWNER TO postgres;

--
-- Name: article; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.article (
    identifier text NOT NULL,
    active boolean DEFAULT false,
    author_id integer NOT NULL,
    img_id integer,
    audio_id integer
);


ALTER TABLE public.article OWNER TO postgres;

--
-- Name: article_category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.article_category (
    article_id text NOT NULL,
    category_id text NOT NULL
);


ALTER TABLE public.article_category OWNER TO postgres;

--
-- Name: article_translates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.article_translates (
    article_id text NOT NULL,
    language text NOT NULL,
    name text NOT NULL,
    description text NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    short_description text NOT NULL
);


ALTER TABLE public.article_translates OWNER TO postgres;

--
-- Name: audio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.audio (
    identifier integer NOT NULL,
    active boolean DEFAULT false NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.audio OWNER TO postgres;

--
-- Name: audio_identifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.audio_identifier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.audio_identifier_seq OWNER TO postgres;

--
-- Name: audio_identifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.audio_identifier_seq OWNED BY public.audio.identifier;


--
-- Name: audio_translates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.audio_translates (
    audio_id integer NOT NULL,
    language text NOT NULL,
    description text NOT NULL,
    path text NOT NULL
);


ALTER TABLE public.audio_translates OWNER TO postgres;

--
-- Name: author; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.author (
    identifier integer NOT NULL,
    name text NOT NULL,
    active boolean DEFAULT false NOT NULL
);


ALTER TABLE public.author OWNER TO postgres;

--
-- Name: author_identifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.author_identifier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.author_identifier_seq OWNER TO postgres;

--
-- Name: author_identifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.author_identifier_seq OWNED BY public.author.identifier;


--
-- Name: author_translates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.author_translates (
    author_id integer NOT NULL,
    language text NOT NULL,
    description text
);


ALTER TABLE public.author_translates OWNER TO postgres;

--
-- Name: category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category (
    identifier text NOT NULL,
    active boolean DEFAULT false NOT NULL
);


ALTER TABLE public.category OWNER TO postgres;

--
-- Name: category_translates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category_translates (
    category_id text NOT NULL,
    language text NOT NULL,
    name text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.category_translates OWNER TO postgres;

--
-- Name: img; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.img (
    identifier integer NOT NULL,
    name text NOT NULL,
    author_id integer NOT NULL,
    path text NOT NULL,
    active boolean DEFAULT false NOT NULL
);


ALTER TABLE public.img OWNER TO postgres;

--
-- Name: img_cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.img_cache (
    key text NOT NULL,
    data text NOT NULL,
    type text NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT img_cache_type_check CHECK ((type = 'webp'::text))
);


ALTER TABLE public.img_cache OWNER TO postgres;

--
-- Name: img_identifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.img_identifier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.img_identifier_seq OWNER TO postgres;

--
-- Name: img_identifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.img_identifier_seq OWNED BY public.img.identifier;


--
-- Name: img_translates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.img_translates (
    img_id integer NOT NULL,
    language text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.img_translates OWNER TO postgres;

--
-- Name: language; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.language (
    identifier text NOT NULL,
    active boolean DEFAULT false NOT NULL
);


ALTER TABLE public.language OWNER TO postgres;

--
-- Name: links; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.links (
    link_id integer NOT NULL,
    path text[]
);


ALTER TABLE public.links OWNER TO postgres;

--
-- Name: links_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.links_link_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.links_link_id_seq OWNER TO postgres;

--
-- Name: links_link_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.links_link_id_seq OWNED BY public.links.link_id;


--
-- Name: links_translates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.links_translates (
    link_id integer NOT NULL,
    language text NOT NULL,
    name text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.links_translates OWNER TO postgres;

--
-- Name: translate_entities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.translate_entities (
    key text NOT NULL,
    language text NOT NULL,
    phrase text NOT NULL
);


ALTER TABLE public.translate_entities OWNER TO postgres;

--
-- Name: translate_keys; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.translate_keys (
    identifier text NOT NULL
);


ALTER TABLE public.translate_keys OWNER TO postgres;

--
-- Name: admin_roles identifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_roles ALTER COLUMN identifier SET DEFAULT nextval('public.admin_roles_identifier_seq'::regclass);


--
-- Name: admin_users identifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users ALTER COLUMN identifier SET DEFAULT nextval('public.admin_users_identifier_seq'::regclass);


--
-- Name: audio identifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audio ALTER COLUMN identifier SET DEFAULT nextval('public.audio_identifier_seq'::regclass);


--
-- Name: author identifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.author ALTER COLUMN identifier SET DEFAULT nextval('public.author_identifier_seq'::regclass);


--
-- Name: img identifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img ALTER COLUMN identifier SET DEFAULT nextval('public.img_identifier_seq'::regclass);


--
-- Name: links link_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links ALTER COLUMN link_id SET DEFAULT nextval('public.links_link_id_seq'::regclass);


--
-- Data for Name: admin_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admin_roles (identifier, name, description) FROM stdin;
1	ADMIN_ROOT	Can do anything
2	ADMIN_LOGIN	Can login into
\.


--
-- Data for Name: admin_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admin_users (identifier, username, password_hash, active, email) FROM stdin;
1	admin	$2y$10$wyrush/aig9nQd3DVZvjuudH/FOIA.II2k1y64ZlYlbodcM8jK5sC	t	admin@example.com
2	admin2	$2y$10$imdQM8v2LJ.G2la8xIcSSuyypMX8UWf63JncAgIAdJzI2Ioe/Wk2K	t	admin2@example.com
\.


--
-- Data for Name: admin_users_with_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admin_users_with_roles (user_id, role_id) FROM stdin;
1	1
2	2
\.


--
-- Data for Name: article; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article (identifier, active, author_id, img_id, audio_id) FROM stdin;
article-3	f	1	\N	\N
article-4	f	1	\N	\N
article-5	f	1	\N	\N
article-6	f	1	\N	\N
article-7	f	1	\N	\N
article-8	f	1	\N	\N
article-9	f	1	\N	\N
article-10	f	1	\N	\N
article-11	f	1	\N	\N
article-12	f	1	\N	\N
article-13	f	1	\N	\N
article-14	f	1	\N	\N
article-15	f	1	\N	\N
article-16	f	1	\N	\N
article-17	f	1	\N	\N
article-18	f	1	\N	\N
article-19	f	1	\N	\N
article-20	f	1	\N	\N
article-21	f	1	\N	\N
simplification-of-the-drivers-license-examination-process	t	1	1	1
document-verification-for-drivers	t	1	2	2
evidence-in-administrative-offense-cases-key-aspects	t	1	3	3
\.


--
-- Data for Name: article_category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article_category (article_id, category_id) FROM stdin;
article-5	category-2
article-6	category-2
article-7	category-2
article-13	category-2
article-14	category-2
article-16	category-2
article-20	category-2
article-21	category-2
simplification-of-the-drivers-license-examination-process	traffic
article-8	traffic
article-9	traffic
article-10	traffic
article-18	traffic
article-19	traffic
evidence-in-administrative-offense-cases-key-aspects	category-2
document-verification-for-drivers	traffic
article-3	administrative-process
article-4	administrative-process
article-11	administrative-process
article-12	administrative-process
article-15	administrative-process
article-17	administrative-process
evidence-in-administrative-offense-cases-key-aspects	administrative-process
\.


--
-- Data for Name: article_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article_translates (article_id, language, name, description, created_at, updated_at, short_description) FROM stdin;
article-3	en	Article 3 name	Article 3 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 3 short description
article-4	en	Article 4 name	Article 4 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 4 short description
article-5	en	Article 5 name	Article 5 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 5 short description
article-6	en	Article 6 name	Article 6 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 6 short description
article-7	en	Article 7 name	Article 7 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 7 short description
article-8	en	Article 8 name	Article 8 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 8 short description
article-9	en	Article 9 name	Article 9 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 9 short description
article-10	en	Article 10 name	Article 10 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 10 short description
article-11	en	Article 11 name	Article 11 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 11 short description
article-12	en	Article 12 name	Article 12 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 12 short description
article-13	en	Article 13 name	Article 13 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 13 short description
article-14	en	Article 14 name	Article 14 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 14 short description
article-15	en	Article 15 name	Article 15 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 15 short description
article-16	en	Article 16 name	Article 16 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 16 short description
article-17	en	Article 17 name	Article 17 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 17 short description
article-18	en	Article 18 name	Article 18 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 18 short description
article-19	en	Article 19 name	Article 19 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 19 short description
article-20	en	Article 20 name	Article 20 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 20 short description
article-21	en	Article 21 name	Article 21 description	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Article 21 short description
article-3	uk	Матеріал 3 им'я	Матеріал 3 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 3 короткий опис
article-4	uk	Матеріал 4 им'я	Матеріал 4 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 4 короткий опис
article-5	uk	Матеріал 5 им'я	Матеріал 5 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 5 короткий опис
article-6	uk	Матеріал 6 им'я	Матеріал 6 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 6 короткий опис
article-7	uk	Матеріал 7 им'я	Матеріал 7 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 7 короткий опис
article-8	uk	Матеріал 8 им'я	Матеріал 8 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 8 короткий опис
article-9	uk	Матеріал 9 им'я	Матеріал 9 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 9 короткий опис
article-10	uk	Матеріал 10 им'я	Матеріал 10 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 10 короткий опис
article-11	uk	Матеріал 11 им'я	Матеріал 11 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 11 короткий опис
article-12	uk	Матеріал 12 им'я	Матеріал 12 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 12 короткий опис
article-13	uk	Матеріал 13 им'я	Матеріал 13 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 13 короткий опис
article-14	uk	Матеріал 14 им'я	Матеріал 14 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 14 короткий опис
article-15	uk	Матеріал 15 им'я	Матеріал 15 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 15 короткий опис
article-16	uk	Матеріал 16 им'я	Матеріал 16 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 16 короткий опис
article-17	uk	Матеріал 17 им'я	Матеріал 17 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 17 короткий опис
article-18	uk	Матеріал 18 им'я	Матеріал 18 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 18 короткий опис
article-19	uk	Матеріал 19 им'я	Матеріал 19 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 19 короткий опис
article-20	uk	Матеріал 20 им'я	Матеріал 20 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 20 короткий опис
article-21	uk	Матеріал 21 им'я	Матеріал 21 повний опис	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Матеріал 21 короткий опис
document-verification-for-drivers	en	Document Verification for Drivers	<h1>Document Verification for Drivers by Police Officers: Updated Requirements and Procedures</h1><p>Since the beginning of 2024, important changes to the legislation regarding the verification of documents for vehicle drivers have come into force in Ukraine. These amendments to the Law of Ukraine "On the National Police" were introduced to improve road safety, reduce the level of offenses, and enhance the procedure for driver-police interaction during roadside checks.</p> <h2>Main Reasons for Document Verification</h2><p>Verifying drivers' documents is one of the key functions of the National Police, carried out to maintain public safety and order on the roads. The law stipulates that police officers have the right to stop vehicles and request the presentation of documents in the following cases:</p> <ul> <li><strong>Violation of traffic rules (TAC)</strong>. This is the most common reason for stopping vehicles. If a driver violates established rules, the police officer has the right to demand the presentation of a driver's license, vehicle registration documents, and insurance policies.</li> <li><strong>Suspicion of technical malfunction of the vehicle</strong>. If the vehicle appears faulty or poses a danger to other road users, the police officer may stop the vehicle for a technical check and document verification.</li> <li><strong>Conducting special operations</strong>. The National Police have the right to check drivers' documents as part of special operations, such as searching for stolen vehicles or criminals.</li> <li><strong>Suspicion of a criminal offense</strong>. If the driver or passengers are suspected of being involved in a criminal offense, the police officer may request documents to confirm their identity and the legality of the vehicle use.</li> <li><strong>Alcohol or drug intoxication</strong>. If the police officer has grounds to believe that the driver is intoxicated, they may stop the vehicle for document verification and direct the driver for a medical examination.</li> </ul> <h2>Documents Drivers Must Present</h2> <p>The law defines a list of documents that the driver is required to carry and present at the request of the police:</p> <ul> <li>A driver's license of the appropriate category.</li> <li>A vehicle registration certificate.</li> <li>A mandatory civil liability insurance policy for vehicle owners (MTPL).</li> <li>For commercial vehicle drivers, additional documents confirming the right to carry out transportation are required.</li> </ul> <h2>Verification Procedure</h2> <p>According to the updated legal norms, the police officer is required to verify the documents strictly within the scope of their powers and in accordance with established procedures. During the vehicle stop, the police officer must identify themselves, state their position, and explain the reason for the stop. The driver, in turn, has the right to know why they were stopped and may ask for clarification on the reasons for the document check.</p> <p>The police officer does not have the right to demand documents from the driver without explaining the reason for the stop or in the absence of legal grounds for the check. Additionally, the driver has the right to record the actions of the police officers using video or audio recording, which helps ensure transparency and compliance with the rights of all road users.</p> <h2>Refusal to Present Documents and Its Consequences</h2> <p>Refusal by the driver to present documents to the police is considered an administrative offense, which can have serious consequences. According to the Code of Administrative Offenses of Ukraine, a driver who refuses to present documents at the request of a police officer may be fined or even temporarily deprived of the right to drive the vehicle.</p> <p>Moreover, attempting to flee from the police or refusing to comply with their lawful demands can lead to more serious legal consequences, including detention or prosecution for resisting law enforcement officers.</p> <h2>Drivers' Rights and Responsibilities During Document Checks</h2> <p>Drivers have several rights during document checks:</p> <ul> <li>To know the reason for the stop and the purpose of the check.</li> <li>To request the police officer's identification.</li> <li>To record interactions with police officers using video or audio devices.</li> <li>To challenge the actions of the police if their powers are violated.</li> </ul> <p>At the same time, drivers are required to:</p> <ul> <li>Present documents at the request of the police officer.</li> <li>Comply with the lawful demands of law enforcement officers.</li> <li>Maintain public order and not obstruct the police in performing their duties.</li> </ul> <h2>New Technologies in Document Verification</h2> <p>With the introduction of digital technologies, the National Police increasingly use electronic means to verify documents. Drivers can present documents in the form of digital copies through the "Diia" app. This significantly simplifies the verification process, as it allows drivers to store all necessary documents electronically and quickly provide them at the police officer's request.</p> <h2>Conclusion</h2> <p>The updated rules for document verification for drivers introduced in Ukraine aim to improve road safety and ensure proper control over compliance with traffic rules. Drivers should be aware of their rights and obligations, as well as comply with the lawful demands of the police to avoid misunderstandings and legal consequences during checks.</p>	2024-10-27 11:48:50.201527	2024-10-27 11:48:50.201527	Since the beginning of 2024, important changes to the legislation regarding the verification of documents for vehicle drivers have come into force in Ukraine. These amendments to the Law of Ukraine "On the National Police" were introduced to improve road safety, reduce the level of offenses, and enhance the procedure for driver-police interaction during roadside checks.
document-verification-for-drivers	uk	Перевірка документі у водіїв транспортних засобів	<h2>Перевірка документів у водіїв працівниками поліції: оновлені вимоги та процедури</h2>\n<p>З початку 2024 року в Україні набули чинності важливі зміни до законодавства, що стосуються перевірки документів у водіїв транспортних засобів. Відповідні правки до Закону України «Про Національну поліцію» були внесені для підвищення безпеки на дорогах, зниження рівня правопорушень та вдосконалення процедури взаємодії водіїв із поліцейськими під час дорожніх перевірок.</p>\n<h3>Основні причини для перевірки документів</h3>\n<ul>Перевірка документів водіїв є однією з важливих функцій Національної поліції, що виконується з метою підтримання громадської безпеки та порядку на дорогах. Закон передбачає, що поліцейські мають право зупиняти транспортні засоби та вимагати у водіїв пред'явлення документів у таких випадках:\n    <li>Порушення правил дорожнього руху (ПДР). Це найбільш поширена причина зупинки автомобілів. Якщо водій порушує встановлені правила, поліцейський має право вимагати пред'явити посвідчення водія, реєстраційні документи на транспортний засіб та страхові поліси.</li>\n    <li>Виникнення підозри щодо технічної несправності транспортного засобу. Якщо автомобіль виглядає несправним або створює небезпеку для інших учасників руху, поліцейський може зупинити транспорт для перевірки технічного стану та документів.</li>\n    <li>Проведення спеціальних заходів. Національна поліція має право перевіряти документи у водіїв у рамках спеціальних операцій, наприклад, пошуку викрадених автомобілів або злочинців.</li>\n    <li>Підозра у вчиненні кримінального правопорушення. Якщо водія або пасажирів підозрюють у причетності до кримінального правопорушення, поліцейський може вимагати документи для підтвердження їх особи та законності використання транспортного засобу.</li>\n    <li>Стан алкогольного або наркотичного сп'яніння. Якщо у поліцейського є підстави вважати, що водій перебуває у стані сп'яніння, його можуть зупинити для перевірки документів та направлення на медичний огляд.</li>\n</ul>\n<h3>Документи, які необхідно пред'являти водіям</h3>\n<ul>Закон визначає перелік документів, які водій зобов'язаний мати при собі та пред'являти на вимогу поліцейських:\n    <li>Посвідчення водія відповідної категорії.</li>\n    <li>Свідоцтво про реєстрацію транспортного засобу.</li>\n    <li>Поліс обов'язкового страхування цивільно-правової відповідальності власників транспортних засобів (ОСЦПВ).</li>\n    <li>Для водіїв комерційних транспортних засобів додатково потрібно мати документи, що підтверджують дозвіл на здійснення перевезень.</li>\n</ul>\n<h3>Процедура перевірки</h3>\n<p>Згідно з оновленими нормами закону, поліцейський зобов'язаний здійснювати перевірку документів виключно в рамках своїх повноважень та у відповідності до встановлених процедур. Під час зупинки транспортного засобу поліцейський повинен представитися, назвати свою посаду та причину зупинки. Водій, у свою чергу, має право знати, чому його зупинили, і може попросити пояснення причин перевірки документів.</p>\n<p>Поліцейський не має права вимагати у водія документи без пояснення причини зупинки або за відсутності законних підстав для перевірки. Крім того, водій має право фіксувати дії поліцейських за допомогою відео- або аудіозапису, що допомагає забезпечити прозорість та дотримання прав усіх учасників дорожнього руху.</p>\n<h3>Відмова від пред'явлення документів та її наслідки</h3>\n<p>Відмова водія від пред'явлення документів поліцейським розглядається як адміністративне правопорушення, яке може мати серйозні наслідки. Відповідно до Кодексу України про адміністративні правопорушення, водію, який відмовився пред'явити документи на вимогу поліцейського, може бути винесено штраф або навіть тимчасове позбавлення права керування транспортним засобом.</p>\n<p>Крім того, спроба втечі від поліцейських або відмова від виконання їх законних вимог може призвести до більш серйозних правових наслідків, включно із затриманням або притягненням до відповідальності за опір правоохоронцям.</p>\n<h3>Права та обов'язки водіїв під час перевірки документів</h3>\n<ul>Водій має ряд прав під час перевірки документів:\n    <li>Знати причину зупинки та мету перевірки.</li>\n    <li>Вимагати пред'явлення службового посвідчення поліцейського.</li>\n    <li>Фіксувати взаємодію з поліцейськими на відео чи аудіо.</li>\n    <li>Оскаржити дії поліцейських у разі порушення їхніх повноважень.</li>\n</ul>\n<ul>Водночас водій зобов'язаний:\n<li>Надавати документи на вимогу поліцейського.</li>\n    <li>Дотримуватися законних вимог правоохоронців.</li>\n    <li>Не порушувати громадський порядок та не перешкоджати виконанню службових обов'язків поліцейських.</li>\n</ul>\n<h3>Нові технології у перевірці документів</h3>\n<p>Із впровадженням цифрових технологій Національна поліція дедалі частіше використовує електронні засоби перевірки документів. Водії можуть пред'являти документи у вигляді цифрових копій через додаток «Дія». Це значно спрощує процес перевірки, оскільки дозволяє зберігати всі необхідні документи в електронному вигляді та швидко надавати їх на вимогу поліцейських.</p>\n<h3>Висновок</h3>\n<p>Оновлені правила перевірки документів у водіїв, введені в Україні, спрямовані на підвищення безпеки на дорогах та забезпечення належного контролю за дотриманням правил дорожнього руху. Водії повинні знати свої права та обов'язки, а також дотримуватися законних вимог поліцейських, щоб уникнути непорозумінь та правових наслідків під час перевірок.</p>	2024-10-31 19:14:03.38871	2024-10-31 19:14:03.38871	З початку 2024 року в Україні набули чинності важливі зміни до законодавства в сфері перевірки документів у водіїв працівниками поліції: оновлені вимоги та процедури
evidence-in-administrative-offense-cases-key-aspects	uk	Докази по справі про адміністративне правопорушення: ключові аспекти	        <div>\n            <h2>Поняття та види доказів</h2>\n            <p>Докази – це будь-які фактичні дані, які підтверджують або спростовують обставини, що мають значення для справи. Вони фіксуються у встановленому законом порядку та визначаються процесуальними нормами.</p>\n            <ul>\n                <li><strong>Протокол про адміністративне правопорушення</strong> – основний документ, який фіксує факт правопорушення.</li>\n                <li><strong>Письмові докази</strong> – документи, акти перевірок, звіти тощо.</li>\n                <li><strong>Речові докази</strong> – матеріальні об’єкти, пов’язані з правопорушенням.</li>\n                <li><strong>Пояснення осіб</strong> – свідчення правопорушника, потерпілих чи свідків.</li>\n                <li><strong>Фото-, відео- та аудіоматеріали</strong> – технічні записи, що фіксують обставини правопорушення.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Процес збирання доказів</h2>\n            <p>Збирання доказів здійснюється органами, уповноваженими складати протоколи та розглядати справи, такими як Національна поліція, митні служби, екологічні інспекції тощо. Дотримання законності при зборі доказів є ключовою умовою їх допустимості.</p>\n        </div>\n        <div>\n            <h2>Оцінка доказів</h2>\n            <p>Згідно зі ст. 252 КУпАП, орган, що розглядає справу, оцінює докази за внутрішнім переконанням, заснованим на повному та об’єктивному дослідженні. Основні принципи оцінки:</p>\n            <ul>\n                <li><strong>Належність</strong> – доказ повинен мати зв’язок з обставинами справи.</li>\n                <li><strong>Допустимість</strong> – доказ має бути отриманий у встановленому порядку.</li>\n                <li><strong>Достатність</strong> – сукупність доказів має бути достатньою для прийняття рішення.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Права сторін у справі</h2>\n            <p>Особи, які беруть участь у справі, мають право:</p>\n            <ul>\n                <li>Подавати власні докази.</li>\n                <li>Заявляти клопотання про витребування додаткових доказів.</li>\n                <li>Знайомитися з матеріалами справи.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Типові проблеми</h2>\n            <p>На практиці часто виникають такі проблеми:</p>\n            <ul>\n                <li>Неправильне складання протоколу.</li>\n                <li>Недостатність доказів.</li>\n                <li>Оскарження допустимості доказів.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Висновок</h2>\n            <p>Докази є основою прийняття рішень у справах про адміністративні правопорушення. Дотримання принципів належності, допустимості та достатності забезпечує законність і обґрунтованість рішень, що сприяє зміцненню правової держави.</p>\n        </div>	2024-11-05 13:40:26.615282	2024-11-05 13:40:26.615282	Докази у справі про адміністративне правопорушення є основним інструментом для встановлення об’єктивної істини та прийняття законного і обґрунтованого рішення.
simplification-of-the-drivers-license-examination-process	en	Simplification of the driver's license examination process	<p>Important amendments to Ukraine's traffic rules, which came into effect in 2024, aim to increase road safety and reduce the number of accidents. One of the key innovations is the mandatory use of daytime running lights outside populated areas throughout the year. Previously, drivers were only required to use running lights in the autumn-winter period (from October 1 to May 1), but now this rule is in effect year-round. The decision is aimed at making vehicles more visible to other road users regardless of weather conditions or lighting levels.</p><h2>The Importance of Using Running Lights</h2><p>Headlights reduce the risk of accidents by improving the visibility of cars on the road, especially in poor weather conditions such as rain or fog. Lighting devices help quickly identify approaching vehicles, especially on roads with heavy traffic. Thus, the decision to make running lights mandatory outside the city year-round is fully justified. According to research, the visibility of a car with headlights on can improve the reaction of other drivers and pedestrians by 20-25%, reducing the risk of collisions.</p><h2>Rule Compliance Check</h2><p>The new requirements stipulate that the police can now monitor compliance with this rule on roads outside populated areas. Drivers who ignore this requirement face fines. Since the continuous use of running lights is becoming mandatory, additional control by the police is expected, along with the installation of new surveillance cameras capable of recording violations remotely.</p>	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	The process of obtaining a driver's license has also changed for future drivers. From now on, candidates can take the theoretical exam without mandatory attendance at driving school courses. This reduces the financial burden on candidates and allows them to prepare for exams independently. However, practical training remains an important step that must be completed before obtaining a driver's license.
simplification-of-the-drivers-license-examination-process	uk	Спрощення процесу складання іспитів на права	<p>У 2024 році в Україні було запроваджено зміни, які спрощують процес складання іспитів на отримання водійських прав. Основне нововведення полягає в тому, що тепер кандидати у водії можуть складати теоретичний іспит без обов'язкового навчання в автошколі. Це значне полегшення для тих, хто має базові знання з правил дорожнього руху та здатний самостійно підготуватися до іспиту.</p>\n<h2>Мета змін</h2> \nЗміни спрямовані на зменшення фінансового навантаження на громадян, адже навчання в автошколах може бути досить витратним. Наразі багато громадян мають можливість навчатися самостійно за допомогою онлайн-ресурсів або спеціалізованих додатків для вивчення ПДР. Скасування обов’язкових курсів у автошколах також робить процес отримання прав більш доступним, особливо для людей з обмеженими фінансовими можливостями або тих, хто не має часу на відвідування навчальних закладів.</p> \n<p>Особливості нового підходу У нових правилах передбачено, що кандидати можуть самостійно обирати метод підготовки до теоретичного іспиту. Однак вимоги до практичних навичок залишаються незмінними, і для отримання права керувати транспортним засобом необхідно пройти практичне навчання в автошколі та скласти відповідний іспит. Це дозволяє зберегти необхідний рівень безпеки на дорогах, адже управління транспортом вимагає не лише знань теорії, але й певного рівня практичної підготовки під наглядом інструктора.</p> \n<h2>Економія часу та ресурсів</h2> \n<p>Введення можливості самопідготовки до теоретичного іспиту також скорочує час, необхідний для отримання водійських прав. Раніше кандидати були зобов’язані відвідувати курси в автошколах, які могли тривати кілька місяців. Тепер же, якщо людина вже володіє знаннями або швидко засвоює матеріал, вона може скласти іспит значно швидше. Це дозволяє уникнути довгих черг в автошколах та забезпечує більш оперативний процес отримання водійського посвідчення.</p> \n<h2>Виклики нової системи</h2> \n<p>Проте спрощення вимог до теоретичного навчання може мати як позитивні, так і негативні наслідки. Деякі експерти вважають, що недостатня підготовка теоретичної частини може призвести до підвищеного ризику на дорогах. Незважаючи на це, держава розраховує на відповідальність майбутніх водіїв, а також на розвиток сучасних інструментів для самостійного навчання. Зокрема, розроблено численні додатки та онлайн-платформи, які дозволяють ефективно та якісно готуватися до теоретичних іспитів.</p>\n<h2>Відгуки громадськості</h2> \n<p>Зміни в процесі підготовки до іспитів викликали різні реакції в суспільстві. Багато людей вважають, що спрощення умов навчання полегшить доступ до водійських прав і позитивно вплине на мобільність громадян. Водночас є й ті, хто висловлює занепокоєння через можливість зниження загального рівня знань серед нових водіїв. У відповідь на це Міністерство внутрішніх справ заявляє, що система буде постійно контролюватися, а кількість аварій з вини новачків буде аналізуватися, щоб оцінити ефективність нових правил.</p>\n<h2>Очікувані результати</h2> \n<p>Запроваджені зміни можуть сприяти не лише зменшенню витрат часу і коштів для майбутніх водіїв, але й зниженню навантаження на автошколи та підвищенню доступності водійських прав для широкого кола громадян. Доступність та демократизація навчання на права, зокрема, дозволяють розширити коло тих, хто може законно керувати транспортним засобом, не вдаючись до послуг дорогих курсів. Завдяки цьому у майбутньому очікується підвищення загального рівня мобільності в країні, що особливо актуально для регіонів, де якісні автошколи можуть бути обмежені або недоступні. Таким чином, спрощення процесу складання теоретичних іспитів у 2024 році можна вважати кроком до більш доступного і демократичного процесу отримання водійських прав в Україні.</p>	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Для майбутніх водіїв процес отримання прав також зазнав змін. Відтепер кандидати можуть складати теоретичний іспит без обов’язкового відвідування курсів в автошколах. Це зменшує фінансове навантаження на кандидатів і дозволяє їм готуватися до екзаменів самостійно. Однак практична підготовка залишається важливим етапом, який необхідно пройти перед отриманням посвідчення водія.
evidence-in-administrative-offense-cases-key-aspects	en	Evidence in Administrative Offense Cases: Key Aspects	        <div>\n            <h2>Definition and Types of Evidence</h2>\n            <p>Evidence is any factual information that confirms or refutes circumstances relevant to a case. It is recorded in accordance with legal procedures and defined by procedural norms.</p>\n            <ul>\n                <li><strong>Administrative Offense Protocol</strong> – the primary document recording the offense.</li>\n                <li><strong>Written Evidence</strong> – documents, inspection reports, records, etc.</li>\n                <li><strong>Material Evidence</strong> – physical objects linked to the offense.</li>\n                <li><strong>Explanations from Individuals</strong> – testimonies from the offender, victims, or witnesses.</li>\n                <li><strong>Photo, Video, and Audio Materials</strong> – technical recordings capturing the circumstances of the offense.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Evidence Collection Process</h2>\n            <p>Evidence is collected by authorized bodies, such as the National Police, customs authorities, or environmental inspections. Compliance with legal procedures during evidence collection ensures its admissibility in court.</p>\n        </div>\n        <div>\n            <h2>Evaluation of Evidence</h2>\n            <p>Under Article 252 of the Code of Administrative Offenses, evidence is evaluated by the authority reviewing the case based on comprehensive, objective, and thorough consideration. Key principles include:</p>\n            <ul>\n                <li><strong>Relevance</strong> – evidence must directly relate to the case.</li>\n                <li><strong>Admissibility</strong> – evidence must be obtained legally.</li>\n                <li><strong>Sufficiency</strong> – the body of evidence must be enough to establish the truth.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Rights of the Parties</h2>\n            <p>Parties involved in the case have the right to:</p>\n            <ul>\n                <li>Submit their own evidence.</li>\n                <li>Request additional evidence.</li>\n                <li>Review case materials.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Common Challenges</h2>\n            <p>Typical issues that arise include:</p>\n            <ul>\n                <li>Errors in protocol preparation.</li>\n                <li>Insufficient evidence.</li>\n                <li>Disputes over the admissibility of evidence.</li>\n            </ul>\n        </div>\n        <div>\n            <h2>Conclusion</h2>\n            <p>Evidence forms the foundation for decisions in administrative offense cases. Adherence to principles of relevance, admissibility, and sufficiency ensures lawful and justified resolutions, contributing to a stronger rule of law.</p>\n        </div>	2024-10-26 12:28:44.705341	2024-10-26 12:28:44.705341	Definition and Types of Evidence, Evidence Collection Process, Evaluation.
\.


--
-- Data for Name: audio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio (identifier, active, name) FROM stdin;
1	t	Audio for article - Simplification of the drivers license examination process
2	t	Audio for article - Document verification for drivers
3	t	Audio for article - Evidence in administrative offense cases key aspects
\.


--
-- Data for Name: audio_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio_translates (audio_id, language, description, path) FROM stdin;
1	en	Simplification of the driver's license examination process audio	articles/simplification-of-the-drivers-license-examination-process/en-simplification-of-the-driver's-license-examination-process.mp3
1	uk	Спрощення процесу складання іспитів на права аудіо	articles/simplification-of-the-drivers-license-examination-process/uk-sproshennya-procesu-skladannya-ispitiv-na-prava.mp3
2	en	Document Verification for Drivers by Police Officers: Updated Requirements and Procedures	articles/document-verification-for-drivers/en-Changes-in-driver-document.mp3
2	uk	Перевірка документів у водіїв працівниками поліції: оновлені вимоги та процедури	articles/document-verification-for-drivers/uk-perevirka-dokumentiv-u-vodiiv-transportnih-zasobiv.mp3
3	en	Evidence in Administrative Offense Cases: Key Aspects	articles/evidence-in-administrative-offense-cases-key-aspects/en-evidence-in-administrative-offense-cases-key-aspects.mp3
3	uk	Докази по справі про адміністративне правопорушення: ключові аспекти	articles/evidence-in-administrative-offense-cases-key-aspects/uk-evidence-in-administrative-offense-cases-key-aspects.mp3
\.


--
-- Data for Name: author; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author (identifier, name, active) FROM stdin;
3	Freepik	t
2	Depositphotos	t
1	AI	t
16	Test author	f
\.


--
-- Data for Name: author_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author_translates (author_id, language, description) FROM stdin;
3	en	Freepik
3	uk	Freepik
2	en	Depositphotos/Depositphotos.com
2	uk	Depositphotos/Depositphotos.com
1	en	AI
1	uk	Штучний інтелект
16	en	test
16	uk	тест
\.


--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category (identifier, active) FROM stdin;
category-2	t
traffic	t
administrative-process	t
\.


--
-- Data for Name: category_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category_translates (category_id, language, name, description) FROM stdin;
category-2	en	Some category 2	Category 2 represents articles ...
category-2	uk	Якась категорія 2	Категорія 2 містить матеріали з ...
traffic	en	Traffic law	Traffic law refers to the regulations and rules established by authorities to ensure the safe and efficient movement of vehicles and pedestrians on roads
traffic	uk	Законодавство про дорожній рух	Все про закони про дорожній рух які стосуються правил і норм, встановлених владою для забезпечення безпеки та ефективного руху транспортних засобів і пішоходів на дорогах
administrative-process	en	Administrative Process 	Adjudication of administrative cases in courts, refers to the procedures and practices employed to resolve disputes arising from the application of administrative law
administrative-process	uk	Адміністративний процес	Адміністративно-процесуальними нормами врегульована діяльність публічної адміністрації, яка спрямована на застосування положень матеріального права під час розгляду та вирішення конкретних індивідуальних справ
\.


--
-- Data for Name: img; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img (identifier, name, author_id, path, active) FROM stdin;
2	document-verification-for-drivers	1	articles/perevirka-documentiv/1.webp	t
1	simplification-of-the-drivers-license-examination-process	2	articles/simplification-of-the-drivers-license-examination-process/1.webp	t
3	evidence-in-administrative-offense-cases-key-aspects	3	articles/dokazi-po-spravi/vidence-in-administrative-offense-cases-key-aspects.webp	t
4	stub-coming-soon-article-list-view	1	common/coming-soon-2000-2000.webp	t
\.


--
-- Data for Name: img_cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img_cache (key, data, type, created_at) FROM stdin;
id:4<>type:webp<>width:200<>height:100	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	webp	2025-04-09 17:28:03
id:1<>type:webp<>width:200<>height:100	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	webp	2025-04-09 17:28:03
id:3<>type:webp<>width:200<>height:100	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	webp	2025-04-09 17:28:03
id:2<>type:webp<>width:200<>height:100	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	webp	2025-04-09 17:28:04
\.


--
-- Data for Name: img_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img_translates (img_id, language, description) FROM stdin;
1	en	Simplification of the drivers license examination process last year
1	uk	Минулого року спрощено процедуру іспиту на отримання водійських прав
2	en	Document Verification for Drivers
2	uk	Перевірка документі у водіїв транспортних засобів
3	en	Evidence in Administrative Offense Cases: Key Aspects
3	uk	Докази по справі про адміністративне правопорушення: ключові аспекти
4	en	Coming soon
4	uk	Скоро буде
\.


--
-- Data for Name: language; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.language (identifier, active) FROM stdin;
en	t
uk	t
\.


--
-- Data for Name: links; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.links (link_id, path) FROM stdin;
0	{}
1	{root}
2	{root,about}
3	{root,sitemap}
4	{root,server-error-example}
5	{root,article}
\.


--
-- Data for Name: links_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.links_translates (link_id, language, name, description) FROM stdin;
1	en	Home	Home Page
1	uk	Головна	Головна сторінка
2	en	About	About Page
2	uk	Про компанію	Сторінка про компанію
3	en	Sitemap	Sitemap Page - all links on one page
3	uk	Мапа сайту	Мапа сайту - усі посилання на одній сторінці
4	en	Server error example	Server error example page
4	uk	Приклад помилки серверу	Приклад сторінки помилки серверу
5	en	Article	Article page
5	uk	Матеріли	Матеріли на тему адміністративного права
\.


--
-- Data for Name: translate_entities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translate_entities (key, language, phrase) FROM stdin;
article.page_name	en	Materials on administrative law
article.page_name	uk	Матеріли на тему адміністративного права
article.description	en	We offer the latest materials analyzing legislative acts, court decisions, or procedures that regulate the activities of public authorities and their interaction with citizens. Such articles explain legal norms, their application, and their impact on social relations.
article.description	uk	Ми пропонуємо найсвіжіші матеріали, що аналізують законодавчі акти, судові рішення або процедури, які регулюють діяльність органів державної влади та взаємодію з громадянами. Такі статті пояснюють норми права, їх застосування та вплив на суспільні відносини.
article.h2.publications	en	Publications
article.h2.publications	uk	Публікації
read-length-formatter.a-few-minutes	en	a few minutes
read-length-formatter.a-few-minutes	uk	декілька хвилин
read-length-formatter.min	en	min
read-length-formatter.min	uk	хв
read-length-formatter.hour	en	h
read-length-formatter.hour	uk	год
read-length-formatter.day	en	d
read-length-formatter.day	uk	доба
article.read	en	read
article.read	uk	читати
header.link.sitemap	en	Sitemap
header.link.sitemap	uk	Мапа сайту
article.view.seeall	en	see all
article.view.seeall	uk	подивитись усі
article.view.photo-by	en	Photo By
article.view.photo-by	uk	Фото зроблено
article.view.by	uk	Автор
article.view.month.January	en	January
article.view.month.February	en	February
article.view.month.March	en	March
article.view.month.April	en	April
article.view.month.May	en	May
article.view.month.June	en	June
article.view.month.July	en	July
article.view.month.August	en	August
article.view.month.September	en	September
article.view.month.October	en	October
article.view.month.November	en	November
article.view.month.December	en	December
article.view.month.January	uk	Січня
article.view.month.February	uk	Лютого
article.view.month.March	uk	Березня
article.view.month.April	uk	Квітня
article.view.month.May	uk	Травня
article.view.month.June	uk	Червня
article.view.month.July	uk	Липня
article.view.month.August	uk	Серпня
article.view.month.September	uk	Вересня
article.view.month.October	uk	Жовтня
article.view.month.November	uk	Листопада
article.view.month.December	uk	Грудня
article.view.similar	en	Similar articles
article.view.similar	uk	Схожі матеріали
article.view.continue.reading	en	Continue reading
article.view.continue.reading	uk	Продовжити читати
404.page_name	en	Page not found (404)
404.page_name	uk	Сторінка не знайдена (404)
server-error-example.page_name	en	Server error example page
server-error-example.page_name	uk	Сторінка, яка демонструє вигляд помилки серверу
sitemap.page_name	en	Sitemap
sitemap.description	en	Public sitemap - visit all our resources
sitemap.page_name	uk	Мапа сайту
sitemap.description	uk	Загальнодоступна мапа сайту - відвідайте всі наші ресурси
article.category	en	Category
global.language	en	English
global.language	uk	Українська
root.page_name	en	Home page
root.page_name	uk	Домашня сторінка
root.about	en	About Page
root.about	uk	Сторінка про компанію
root.contacts	en	Contacts Page
root.contacts	uk	Наші контакти
server-error.header	en	Server error page
server-error.header	uk	Сторінка помилки серверу
server-error.message	en	Sorry, we have an error on our side. Please try again later
server-error.message	uk	Вибачте, нажаль сталася помилка на стороні серверу. Спробуйте повторити запит пізніше
404.header	en	The requested page was not found on our server
404.header	uk	Запрошена сторінка не знайдена на нашому сервері
404.message	en	Please check the request and try again
404.message	uk	Будь ласка, перевірте адресну строку та спробуйте знову
header.logo	en	Lawshield
header.logo	uk	Правощит
header.sing_in	en	Sing in
header.sing_in	uk	Увійти
header.subscribe	en	Subscribe
header.subscribe	uk	Підписатися
footer.copyright	en	Copyright
footer.copyright	uk	Авторське право
footer.by_romanenko	en	by Romanenko Serhii
footer.by_romanenko	uk	належить Романенко Сергію
article.category	uk	Категорія
server-error.description	en	This page is now works as expected
server-error.description	uk	Ця сторінка не працює як очікувалося, сталася помилка серверу
auth.wrong-password	en	Wrong password, please check and try again
auth.wrong-username	en	Wrong username, please check and try again
auth.success-logged-in	en	You have successfully logged in
auth.not-active	uk	Обліковий запис не активний
auth.wrong-password	uk	Неправильний пароль, перевірте та повторіть спробу
auth.wrong-username	uk	Неправильне ім'я користувача, перевірте та повторіть спробу
auth.success-logged-in	uk	Ви успішно увійшли у систему
auth.not-active	en	Account is not active
error.during-check-fix-and-try	en	Error during check: %s. Please fix it and try again
error.during-check-fix-and-try	uk	Помилка під час перевірки: %s. Виправте це та повторіть спробу
logout.you-must-login-first	en	You must login first
logout.you-must-login-first	uk	Ви маєте спочатку увійти в систему
middleware.form-data-is-outdated	en	Received data is outdated, please fill form and send again
middleware.form-data-is-outdated	uk	Отримані дані застаріли, заповніть форму та надішліть її повторно
middleware.form-error	en	Form was sent with error data, please fill it and send again
middleware.form-error	uk	Форма була надіслана з помилковими даними, заповніть її та надішліть ще раз
admin.roles.you-do-not-have-enough-permissions	en	You do not have enough permissions
admin.roles.you-do-not-have-enough-permissions	uk	У вас недостатньо прав доступу
admin.image-cache.cache-cleared	en	Image cache was cleared
admin.image-cache.cache-cleared	uk	Кеш зображень очищено
admin.data-success-update	en	Information successfully updated
admin.data-success-update	uk	Дані успішно оновлені
admin.author-with-id-not-exist	en	Author with id %s does not exist
admin.author-with-id-not-exist	uk	Автора з вказаним id %s не існує
admin.could-not-change-activity	en	Could not change activity - %s
admin.could-not-change-activity	uk	Не вдалося змінити активність - %s
admin.could-not-save	en	Could not save, check error and try again
admin.could-not-save	uk	Не вдалося зберегти, перевірте помилку та повторіть спробу
admin.data-could-not-delete	en	An error occurred while attempting to delete, please check and try again
admin.data-could-not-delete	uk	Під час спроби видалення сталася помилка, перевірьте те спробуйте знову
admin.data-was-deleted-successfully	en	Data was successfully deleted.
admin.data-was-deleted-successfully	uk	Дані були успішно видалені
admin.query-was-processed-successfully	en	Query was processed successfully
admin.query-was-processed-successfully	uk	Запит було оброблено успішно
404.description	en	Requested page was not found on our server
404.description	uk	Запитана сторінка не знайдена на нашому сервері
admin.image-with-id-not-exist	en	Image with id %s not exist
admin.image-with-id-not-exist	uk	Зображення з id %s не існує
admin.data-success-saved	en	Data was successfully saved
admin.data-success-saved	uk	Дані успішно збережено
global.please-select	en	Please select
global.please-select	uk	Будь ласка, оберіть варіант
\.


--
-- Data for Name: translate_keys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translate_keys (identifier) FROM stdin;
global.language
root.page_name
server-error.header
server-error.message
root.about
root.contacts
404.header
404.message
header.logo
header.sing_in
header.subscribe
footer.copyright
footer.by_romanenko
article.page_name
article.description
article.h2.publications
read-length-formatter.a-few-minutes
read-length-formatter.min
read-length-formatter.hour
read-length-formatter.day
article.read
header.link.sitemap
article.view.seeall
article.view.photo-by
article.view.by
article.view.month.January
article.view.month.February
article.view.month.March
article.view.month.April
article.view.month.May
article.view.month.June
article.view.month.July
article.view.month.August
article.view.month.September
article.view.month.October
article.view.month.November
article.view.month.December
article.view.similar
article.view.continue.reading
404.page_name
404.description
server-error-example.page_name
sitemap.page_name
sitemap.description
article.category
server-error.description
auth.not-active
auth.wrong-password
auth.wrong-username
auth.success-logged-in
error.during-check-fix-and-try
logout.you-must-login-first
middleware.form-data-is-outdated
middleware.form-error
admin.roles.you-do-not-have-enough-permissions
admin.image-cache.cache-cleared
admin.data-success-update
admin.author-with-id-not-exist
admin.could-not-change-activity
admin.could-not-save
admin.data-could-not-delete
admin.data-was-deleted-successfully
admin.query-was-processed-successfully
admin.image-with-id-not-exist
admin.data-success-saved
global.please-select
\.


--
-- Name: admin_roles_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admin_roles_identifier_seq', 1, false);


--
-- Name: admin_users_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admin_users_identifier_seq', 1, false);


--
-- Name: audio_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audio_identifier_seq', 1, false);


--
-- Name: author_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.author_identifier_seq', 16, true);


--
-- Name: img_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.img_identifier_seq', 84, true);


--
-- Name: links_link_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.links_link_id_seq', 1, false);


--
-- Name: admin_roles admin_roles_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_roles
    ADD CONSTRAINT admin_roles_name_key UNIQUE (name);


--
-- Name: admin_roles admin_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_roles
    ADD CONSTRAINT admin_roles_pkey PRIMARY KEY (identifier);


--
-- Name: admin_users admin_users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users
    ADD CONSTRAINT admin_users_email_key UNIQUE (email);


--
-- Name: admin_users admin_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users
    ADD CONSTRAINT admin_users_pkey PRIMARY KEY (identifier);


--
-- Name: admin_users admin_users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users
    ADD CONSTRAINT admin_users_username_key UNIQUE (username);


--
-- Name: article article_identifier_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_identifier_key UNIQUE (identifier);


--
-- Name: article article_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_pkey PRIMARY KEY (identifier);


--
-- Name: article_translates article_translates_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_translates
    ADD CONSTRAINT article_translates_name_key UNIQUE (name);


--
-- Name: audio audio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audio
    ADD CONSTRAINT audio_pkey PRIMARY KEY (identifier);


--
-- Name: author author_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.author
    ADD CONSTRAINT author_pkey PRIMARY KEY (identifier);


--
-- Name: category category_identifier_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_identifier_key UNIQUE (identifier);


--
-- Name: category_translates category_translates_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_translates
    ADD CONSTRAINT category_translates_name_key UNIQUE (name);


--
-- Name: img_cache img_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img_cache
    ADD CONSTRAINT img_cache_pkey PRIMARY KEY (key);


--
-- Name: img img_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img
    ADD CONSTRAINT img_pkey PRIMARY KEY (identifier);


--
-- Name: links links_path_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links
    ADD CONSTRAINT links_path_key UNIQUE (path);


--
-- Name: links links_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links
    ADD CONSTRAINT links_pkey PRIMARY KEY (link_id);


--
-- Name: links_translates links_translates_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links_translates
    ADD CONSTRAINT links_translates_name_key UNIQUE (name);


--
-- Name: admin_users_with_roles pk_admin_users_roles; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users_with_roles
    ADD CONSTRAINT pk_admin_users_roles PRIMARY KEY (user_id, role_id);


--
-- Name: article_category pk_article_category; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_category
    ADD CONSTRAINT pk_article_category PRIMARY KEY (article_id, category_id);


--
-- Name: article_translates pk_article_translates; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_translates
    ADD CONSTRAINT pk_article_translates PRIMARY KEY (article_id, language);


--
-- Name: author_translates pk_author_translates; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.author_translates
    ADD CONSTRAINT pk_author_translates PRIMARY KEY (author_id, language);


--
-- Name: category_translates pk_category_translates; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_translates
    ADD CONSTRAINT pk_category_translates PRIMARY KEY (category_id, language);


--
-- Name: img_translates pk_img_translates; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img_translates
    ADD CONSTRAINT pk_img_translates PRIMARY KEY (img_id, language);


--
-- Name: links_translates pk_links_translates; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links_translates
    ADD CONSTRAINT pk_links_translates PRIMARY KEY (link_id, language);


--
-- Name: translate_entities pk_translate_entities; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_entities
    ADD CONSTRAINT pk_translate_entities PRIMARY KEY (key, language);


--
-- Name: translate_keys translate_keys_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_keys
    ADD CONSTRAINT translate_keys_pkey PRIMARY KEY (identifier);


--
-- Name: language translate_lang_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.language
    ADD CONSTRAINT translate_lang_pkey PRIMARY KEY (identifier);


--
-- Name: admin_users_with_roles admin_users_with_roles_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users_with_roles
    ADD CONSTRAINT admin_users_with_roles_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.admin_roles(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: admin_users_with_roles admin_users_with_roles_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_users_with_roles
    ADD CONSTRAINT admin_users_with_roles_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.admin_users(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: article article_audio_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_audio_id_fkey FOREIGN KEY (audio_id) REFERENCES public.audio(identifier) ON UPDATE CASCADE;


--
-- Name: article article_author_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_author_id_fkey FOREIGN KEY (author_id) REFERENCES public.author(identifier) ON UPDATE CASCADE;


--
-- Name: article_category article_category_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_category
    ADD CONSTRAINT article_category_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.article(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: article_category article_category_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_category
    ADD CONSTRAINT article_category_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.category(identifier) ON UPDATE CASCADE;


--
-- Name: article article_img_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article
    ADD CONSTRAINT article_img_id_fkey FOREIGN KEY (img_id) REFERENCES public.img(identifier) ON UPDATE CASCADE;


--
-- Name: article_translates article_translates_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_translates
    ADD CONSTRAINT article_translates_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.article(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: article_translates article_translates_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.article_translates
    ADD CONSTRAINT article_translates_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON UPDATE CASCADE;


--
-- Name: audio_translates audio_translates_audio_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audio_translates
    ADD CONSTRAINT audio_translates_audio_id_fkey FOREIGN KEY (audio_id) REFERENCES public.audio(identifier) ON UPDATE CASCADE;


--
-- Name: audio_translates audio_translates_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audio_translates
    ADD CONSTRAINT audio_translates_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON UPDATE CASCADE;


--
-- Name: author_translates author_translates_author_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.author_translates
    ADD CONSTRAINT author_translates_author_id_fkey FOREIGN KEY (author_id) REFERENCES public.author(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: author_translates author_translates_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.author_translates
    ADD CONSTRAINT author_translates_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON UPDATE CASCADE;


--
-- Name: category_translates category_translates_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_translates
    ADD CONSTRAINT category_translates_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.category(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: category_translates category_translates_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_translates
    ADD CONSTRAINT category_translates_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON UPDATE CASCADE;


--
-- Name: img img_author_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img
    ADD CONSTRAINT img_author_id_fkey FOREIGN KEY (author_id) REFERENCES public.author(identifier) ON UPDATE CASCADE;


--
-- Name: img_translates img_translates_img_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img_translates
    ADD CONSTRAINT img_translates_img_id_fkey FOREIGN KEY (img_id) REFERENCES public.img(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: img_translates img_translates_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img_translates
    ADD CONSTRAINT img_translates_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: links_translates links_translates_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links_translates
    ADD CONSTRAINT links_translates_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON DELETE CASCADE;


--
-- Name: links_translates links_translates_link_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.links_translates
    ADD CONSTRAINT links_translates_link_id_fkey FOREIGN KEY (link_id) REFERENCES public.links(link_id) ON DELETE CASCADE;


--
-- Name: translate_entities translate_entities_key_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_entities
    ADD CONSTRAINT translate_entities_key_fkey FOREIGN KEY (key) REFERENCES public.translate_keys(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: translate_entities translate_entities_language_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.translate_entities
    ADD CONSTRAINT translate_entities_language_fkey FOREIGN KEY (language) REFERENCES public.language(identifier) ON UPDATE CASCADE;


--
-- PostgreSQL database dump complete
--

