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
    active boolean DEFAULT false NOT NULL,
    author_id integer NOT NULL,
    img_id integer,
    audio_id integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    views integer NOT NULL,
    CONSTRAINT views_check CHECK ((views >= 0))
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
-- Name: banner; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.banner (
    identifier integer NOT NULL,
    active boolean DEFAULT false NOT NULL,
    name text NOT NULL,
    img_id integer NOT NULL,
    priority integer NOT NULL
);


ALTER TABLE public.banner OWNER TO postgres;

--
-- Name: banner_identifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.banner_identifier_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.banner_identifier_seq OWNER TO postgres;

--
-- Name: banner_identifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.banner_identifier_seq OWNED BY public.banner.identifier;


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
-- Name: banner identifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.banner ALTER COLUMN identifier SET DEFAULT nextval('public.banner_identifier_seq'::regclass);


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
2	admin2	$2y$10$imdQM8v2LJ.G2la8xIcSSuyypMX8UWf63JncAgIAdJzI2Ioe/Wk2K	t	admin2@example.com
1	admin	$2y$12$q/QW6ASrN4ist4/csSjXreOTthlkqUgJdCMJpO75tZnkL/o5GCfqC	t	admin@example.com
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

COPY public.article (identifier, active, author_id, img_id, audio_id, created_at, updated_at, views) FROM stdin;
plaintiff's-failure-to-appear-in-court	t	1	109	65	2025-07-01 12:32:51	2025-07-01 12:35:37	1
using-a-video-recorder	t	1	120	50	2025-06-25 19:24:20	2025-07-09 12:54:04	2
the-constitution-of-ukraine-and-the-sphere-of-military-law	t	1	112	68	2025-07-02 12:44:22	2025-07-02 12:53:49	2
zakon-pro-dorojniy-ruh-ukraini	t	1	121	49	2025-06-25 16:29:19	2025-07-10 14:04:39	1
сircumstances-that-are-not-a-valid-reason-for-missing-a-procedural-deadline	t	1	123	54	2025-06-26 19:26:46	2025-07-10 14:39:41	1
rights-of-a-person-held-administratively-liable	t	1	113	69	2025-07-02 14:41:54	2025-07-03 16:55:03	6
сode-of-administrative-procedure-of-ukraine	t	1	94	52	2025-06-26 13:15:01	2025-06-26 13:24:15	0
passing-the-military-medical-commission	t	1	101	59	2025-06-29 17:45:10	2025-06-29 17:50:58	0
evidence-in-administrative-offense-cases-key-aspects	t	1	115	3	2024-11-05 13:40:26	2025-07-08 10:59:21	0
entering-a-road-with-a-lane-for-route-vehicles	t	1	90	48	2025-06-25 12:54:38	2025-06-25 14:14:33	0
reservation-of-employees-for-the-period-of-mobilization	t	1	105	62	2025-06-30 17:35:55	2025-06-30 17:47:08	1
grounds-for-stopping-a-vehicle-by-police-officers	t	1	119	51	2025-06-26 10:25:57	2025-07-09 12:45:20	1
evidence-in-administrative-law	t	1	98	56	2025-06-28 18:17:49	2025-06-28 18:24:51	2
code-of-ukraine-on-administrative-offenses	t	1	107	63	2025-06-30 19:10:54	2025-06-30 19:20:16	1
traffic-rules	t	1	111	67	2025-07-02 11:42:18	2025-07-02 11:43:42	2
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	t	1	122	53	2025-06-26 16:46:37	2025-07-10 14:33:23	1
impossibility-of-judicial-appeal-of-summons-to-appear-at-the-tcr	t	1	108	64	2025-07-01 12:06:47	2025-07-01 12:06:47	2
military-registration-document	t	1	124	61	2025-06-30 12:26:51	2025-07-11 13:02:22	1
administrative-detention	t	1	97	55	2025-06-27 18:49:55	2025-06-27 18:57:37	0
extension-of-the-guarantee-of-maintaining-a-servicemans-job	t	1	102	60	2025-06-29 19:45:28	2025-06-29 19:49:24	0
amendments-resolution-no-76-27.01.23	t	1	100	58	2025-06-29 14:56:38	2025-06-29 14:59:54	0
laws-and-regulations-governing-the-field-of-military-law	t	1	99	57	2025-06-29 12:42:15	2025-06-29 12:44:17	0
deferrals-from-military-service-for-stepfathers	t	1	110	66	2025-07-02 11:22:05	2025-07-02 11:27:50	0
simplification-of-the-drivers-license-examination-process	t	1	114	1	2024-11-12 17:54:44	2025-07-08 10:48:46	0
document-verification-for-drivers	t	1	2	2	2024-10-31 19:14:03	2024-11-01 11:48:50	0
the-importance-of-seat-belts-when-driving-a-car	t	1	89	47	2025-06-24 18:40:16	2025-06-24 18:47:02	0
increase-fines-for-speeding-violations-2025	t	1	87	46	2025-06-15 13:38:03	2025-06-15 13:38:03	0
\.


--
-- Data for Name: article_category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article_category (article_id, category_id) FROM stdin;
reservation-of-employees-for-the-period-of-mobilization	military-law
reservation-of-employees-for-the-period-of-mobilization	military-reservation
code-of-ukraine-on-administrative-offenses	administrative-process
code-of-ukraine-on-administrative-offenses	administrative-process-legal-framework
evidence-in-administrative-offense-cases-key-aspects	administrative-process
impossibility-of-judicial-appeal-of-summons-to-appear-at-the-tcr	administrative-process
impossibility-of-judicial-appeal-of-summons-to-appear-at-the-tcr	administrative-process-consultations
impossibility-of-judicial-appeal-of-summons-to-appear-at-the-tcr	military-law-judicial-practice
plaintiff's-failure-to-appear-in-court	administrative-process
plaintiff's-failure-to-appear-in-court	administrative-process-consultations
traffic-rules	traffic-legal-framework
deferrals-from-military-service-for-stepfathers	military-law
traffic-rules	traffic
deferrals-from-military-service-for-stepfathers	military-law-judicial-practice
deferrals-from-military-service-for-stepfathers	military-reservation
simplification-of-the-drivers-license-examination-process	traffic
increase-fines-for-speeding-violations-2025	traffic-legislative-changes
increase-fines-for-speeding-violations-2025	traffic
document-verification-for-drivers	traffic-legislative-changes
document-verification-for-drivers	traffic
rights-of-a-person-held-administratively-liable	traffic-common-mistakes
rights-of-a-person-held-administratively-liable	traffic
the-constitution-of-ukraine-and-the-sphere-of-military-law	military-law
сode-of-administrative-procedure-of-ukraine	administrative-process
сode-of-administrative-procedure-of-ukraine	administrative-process-legal-framework
the-constitution-of-ukraine-and-the-sphere-of-military-law	military-law-legal-framework
the-importance-of-seat-belts-when-driving-a-car	traffic-consultations
the-importance-of-seat-belts-when-driving-a-car	traffic
entering-a-road-with-a-lane-for-route-vehicles	traffic-judicial-practice
entering-a-road-with-a-lane-for-route-vehicles	traffic
grounds-for-stopping-a-vehicle-by-police-officers	traffic-vehicle-stop
grounds-for-stopping-a-vehicle-by-police-officers	traffic
using-a-video-recorder	traffic-common-mistakes
using-a-video-recorder	traffic
zakon-pro-dorojniy-ruh-ukraini	traffic-legal-framework
zakon-pro-dorojniy-ruh-ukraini	traffic
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	administrative-process-legislative-changes
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	military-law
administrative-detention	administrative-process
administrative-detention	administrative-process-administrative-detention
evidence-in-administrative-law	administrative-process
evidence-in-administrative-law	evidence
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	military-law-legislative-changes
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	administrative-process
сircumstances-that-are-not-a-valid-reason-for-missing-a-procedural-deadline	administrative-process-consultations
сircumstances-that-are-not-a-valid-reason-for-missing-a-procedural-deadline	administrative-process
military-registration-document	military-law
laws-and-regulations-governing-the-field-of-military-law	military-law
laws-and-regulations-governing-the-field-of-military-law	military-law-legal-framework
military-registration-document	military-registration-document
amendments-resolution-no-76-27.01.23	military-law
amendments-resolution-no-76-27.01.23	military-law-legislative-changes
passing-the-military-medical-commission	military-law
passing-the-military-medical-commission	military-law-mmc
extension-of-the-guarantee-of-maintaining-a-servicemans-job	military-law
extension-of-the-guarantee-of-maintaining-a-servicemans-job	military-law-judicial-practice
\.


--
-- Data for Name: article_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article_translates (article_id, language, name, description, short_description) FROM stdin;
evidence-in-administrative-law	en	Evidence in administrative law	<p>In the system of administrative justice, evidence plays a crucial role in establishing the factual circumstances of a case. It forms the basis for lawful and well-reasoned judicial decisions. Evidence is defined as any factual data on which the court determines the presence or absence of circumstances relevant to the case.</p>\r\n\r\n<h2>Definition of Evidence</h2>\r\n<p>According to the Code of Administrative Procedure of Ukraine (CAPU), evidence can include any legally admissible means that confirm or refute the claims of the parties. The court evaluates the evidence based on its own internal conviction, guided by the law, logic, and the principle of fairness.</p>\r\n\r\n<h2>Types of Evidence</h2>\r\n<p>CAPU defines several main types of evidence:</p>\r\n<ul>\r\n  <li>Written evidence — official documents, certificates, reports, contracts, correspondence, etc.</li>\r\n  <li>Material evidence — physical objects that may confirm or disprove specific facts (e.g., damaged goods, video recordings).</li>\r\n  <li>Explanations of the parties and third persons — oral or written statements by the claimant, defendant, or third parties concerning the case.</li>\r\n  <li>Witness testimony — information provided by persons who are aware of the circumstances of the case.</li>\r\n  <li>Expert conclusions — specialized knowledge obtained through expert examinations (e.g., economic, technical, linguistic expertise).</li>\r\n</ul>\r\n\r\n<h2>Submission of Evidence</h2>\r\n<p>Participants in the case have the right to submit evidence in support of their claims or objections. According to procedural rules, evidence must be submitted along with the administrative claim or during the trial within the deadlines set by the court.</p>\r\n\r\n<p>The court also has the right to request evidence on its own initiative if it is necessary for the correct resolution of the dispute.</p>\r\n\r\n<h2>Evaluation of Evidence</h2>\r\n<p>The court evaluates evidence based on the following principles:</p>\r\n<ul>\r\n  <li>sufficiency — there must be enough evidence to establish the facts of the case;</li>\r\n  <li>credibility — the evidence must be reliable and verifiable;</li>\r\n  <li>interconnection — individual pieces of evidence are considered in conjunction, not in isolation.</li>\r\n</ul>\r\n\r\n<p>No piece of evidence has predetermined weight. Even an official document may be challenged or deemed inadmissible if obtained in violation of the law.</p>\r\n\r\n<h2>Admissibility of Evidence</h2>\r\n<p>Admissibility means the evidence must be obtained in a lawful manner. For example, an audio recording of a conversation made without the other party’s knowledge may be ruled inadmissible if it was obtained in violation of individual rights or without proper authorization.</p>\r\n\r\n<h2>Storage and Examination of Evidence</h2>\r\n<p>Evidence submitted by the parties is added to the case file and kept in court until the case is resolved. During the hearing, the court examines each piece of evidence separately: reviewing documents, listening to statements, questioning witnesses, and analyzing expert conclusions.</p>\r\n	A general article on the topic of evidence in administrative law, its importance. Start with it.
evidence-in-administrative-law	uk	Докази в адміністративному праві	<p>У системі адміністративного судочинства докази відіграють ключову роль у встановленні фактичних обставин справи. Вони є основою для прийняття законного та обґрунтованого рішення судом. Докази визначаються як будь-які фактичні дані, на підставі яких суд встановлює наявність або відсутність обставин, що мають значення для справи.</p>\r\n\r\n<h2>Поняття доказів</h2>\r\n<p>Згідно з Кодексом адміністративного судочинства України (КАСУ), доказами можуть бути будь-які допустимі за законом засоби, що підтверджують або спростовують доводи сторін. Суд оцінює докази за своїм внутрішнім переконанням, керуючись законом, логікою та принципом справедливості.</p>\r\n\r\n<h2>Види доказів</h2>\r\n<p>КАСУ передбачає декілька основних видів доказів:</p>\r\n<ul>\r\n  <li>Письмові докази — офіційні документи, довідки, акти, договори, листування тощо.</li>\r\n  <li>Речові докази — матеріальні об’єкти, які можуть підтвердити або спростувати певні обставини (наприклад, зіпсовані товари, відеозаписи).</li>\r\n  <li>Пояснення сторін і третіх осіб — усні або письмові заяви позивача, відповідача або третіх осіб щодо обставин справи.</li>\r\n  <li>Свідчення свідків — інформація, отримана від осіб, які мають знання про обставини справи.</li>\r\n  <li>Висновки експертів — спеціальні знання, залучені шляхом експертизи (наприклад, економічна, технічна, лінгвістична експертиза).</li>\r\n</ul>\r\n\r\n<h2>Подання доказів</h2>\r\n<p>Учасники справи мають право подавати докази на підтвердження своїх вимог або заперечень. Згідно з процесуальними нормами, докази подаються разом з адміністративним позовом або під час розгляду справи у строки, визначені судом.</p>\r\n\r\n<p>Суд також має право витребувати докази за власною ініціативою, якщо це необхідно для правильного вирішення спору.</p>\r\n\r\n<h2>Оцінка доказів</h2>\r\n<p>Оцінка доказів здійснюється судом на засадах:</p>\r\n<ul>\r\n  <li>достатності — доказів має бути достатньо для встановлення обставин справи;</li>\r\n  <li>достовірності — докази мають бути надійними й перевіреними;</li>\r\n  <li>взаємозв’язку — окремі докази розглядаються у сукупності, а не ізольовано.</li>\r\n</ul>\r\n\r\n<p>Жоден доказ не має наперед установленої сили. Навіть офіційний документ може бути спростований або визнаний недопустимим, якщо він отриманий з порушенням закону.</p>\r\n\r\n<h2>Допустимість доказів</h2>\r\n<p>Допустимість означає, що доказ повинен бути отриманий законним шляхом. Наприклад, аудіозапис розмови без відома іншої сторони може бути визнаний недопустимим, якщо його отримано з порушенням прав особи або без відповідного дозволу.</p>\r\n\r\n<h2>Зберігання та дослідження доказів</h2>\r\n<p>Докази, подані сторонами, долучаються до матеріалів справи й зберігаються у суді до завершення розгляду. Під час розгляду справи суд досліджує кожен доказ окремо: оглядає документи, заслуховує пояснення, допитує свідків, аналізує висновки експертів.</p>	Загальна стаття на тему доказів в адміністративному праві, їх важливість. Почніть саме з неї.
passing-the-military-medical-commission	en	Passing the military medical commission	<p>Undergoing the Military Medical Commission (MMC) is a mandatory step for all conscripts subject to mobilization, enlistment, or entry into military service. The main purpose of this procedure is to assess a citizen's fitness for service based on their health condition in accordance with current Ukrainian legislation.</p>\r\n\r\n<h2>Legal Grounds for Undergoing the MMC</h2>\r\n\r\n<p>The organization and procedure of military medical commissions are regulated by a number of legal acts, including:</p>\r\n<ul>\r\n  <li>The Law of Ukraine "On Military Duty and Military Service";</li>\r\n  <li>The Regulation on Military Medical Examination in the Armed Forces of Ukraine;</li>\r\n  <li>Orders of the Ministry of Defense of Ukraine and the Ministry of Health.</li>\r\n</ul>\r\n\r\n<p>All citizens subject to enlistment undergo medical examinations at Territorial Centers of Recruitment and Social Support (TCRSS).</p>\r\n\r\n<h2>Composition and Functions of the MMC</h2>\r\n\r\n<p>The Military Medical Commission is composed of doctors of various specializations: a therapist, surgeon, neurologist, psychiatrist, ophthalmologist, ENT specialist, dentist, and the commission chairman. If necessary, other specialists may be involved or additional examinations conducted.</p>\r\n\r\n<p>The commission conducts a comprehensive medical examination, analyzes medical history and diagnostic results, and determines the person's fitness category for military service.</p>\r\n\r\n<h2>Categories of Fitness for Military Service</h2>\r\n\r\n<p>As of 2025, the categories of fitness have been simplified. According to updated regulations, only three main categories are now in effect:</p>\r\n\r\n<ul>\r\n  <li>Fit for service\r\n    <ul>\r\n      <li>the person may be assigned to combat, logistical, medical, training units, or to territorial recruitment and support centers</li>\r\n    </ul>\r\n  </li>\r\n  <li>Temporarily unfit\r\n    <ul>\r\n      <li>applies to individuals with temporary health issues; a follow-up examination is usually scheduled after 6 or 12 months</li>\r\n    </ul>\r\n  </li>\r\n  <li>Unfit for service\r\n    <ul>\r\n      <li>the person cannot serve during peace or wartime; removed from military registration or sent for re-evaluation in one year</li>\r\n    </ul>\r\n  </li>\r\n</ul>\r\n\r\n<p>Previous categories such as "limited fitness", "fit for wartime only", or "unfit in peacetime" have been abolished. This was done to simplify the mobilization process and improve the efficiency of decisions made by the Military Medical Commission.</p>\r\n\r\n<p>The decision of the Military Medical Commission is formalized in the form of a ruling and is valid for 12 months unless another date is specified for re-examination.</p>\r\n\r\n<h2>Rights and Responsibilities of the Conscripts</h2>\r\n\r\n<p>Citizens have the right to:</p>\r\n<ul>\r\n  <li>familiarize themselves with the conclusions of the doctors and the commission;</li>\r\n  <li>appeal the MMC decision to a higher commission or in court;</li>\r\n  <li>request additional examinations if they disagree with the decision.</li>\r\n</ul>\r\n\r\n<p>At the same time, they are obliged to:</p>\r\n<ul>\r\n  <li>appear at the TCRSS at the scheduled time;</li>\r\n  <li>provide accurate medical information and documents;</li>\r\n  <li>comply with the lawful instructions of the doctors and commission members.</li>\r\n</ul>\r\n\r\n<h2>Conclusion</h2>\r\n\r\n<p>Undergoing the Military Medical Commission is an important part of the conscription process, allowing for an objective assessment of a citizen’s health and an informed decision on their suitability for military service. Ensuring transparency, respecting individual rights, and adhering to medical standards are key elements in maintaining public trust in this process.</p>	General information about the VLK - legal basis, composition, functions. Suitability categories.
passing-the-military-medical-commission	uk	Проходження військово-лікарської комісії	<p>Проходження військово-лікарської комісії (ВЛК) є обов’язковим етапом для всіх військовозобов’язаних, які підлягають мобілізації, призову або вступу на військову службу. Основна мета цієї процедури – визначити придатність громадянина до служби за станом здоров’я відповідно до чинного законодавства України.</p>\r\n\r\n<h2>Правові підстави проходження ВЛК</h2>\r\n\r\n<p>Порядок організації та проведення військово-лікарських комісій регулюється низкою нормативно-правових актів, зокрема:</p>\r\n<ul>\r\n  <li>Законом України «Про військовий обов’язок і військову службу»;</li>\r\n  <li>Положенням про військово-лікарську експертизу в Збройних Силах України;</li>\r\n  <li>Наказами Міністерства оборони України та Міністерства охорони здоров’я.</li>\r\n</ul>\r\n\r\n<p>Усі громадяни, які підлягають призову, проходять медичне обстеження в територіальних центрах комплектування та соціальної підтримки (ТЦК та СП).</p>\r\n\r\n<h2>Склад та функції ВЛК</h2>\r\n\r\n<p>Військово-лікарська комісія формується з лікарів різних спеціальностей: терапевта, хірурга, невропатолога, психіатра, офтальмолога, отоларинголога, стоматолога, а також голови комісії. У разі необхідності можуть бути залучені інші фахівці або проведені додаткові обстеження.</p>\r\n\r\n<p>Комісія проводить всебічне медичне обстеження, аналізує історію хвороб, результати діагностичних досліджень та визначає категорію придатності особи до військової служби.</p>\r\n\r\n<h2>Категорії придатності</h2>\r\n\r\n<p>За результатами обстеження особі присвоюється одна з таких категорій:</p>\r\n<ul>\r\n  <li>Придатний<ul>\r\n      <li>до бойової служби, або до служби в тилових, медичних, логістичних, навчальних підрозділах, ТЦК та СП</li>\r\n    </ul>\r\n  </li>\r\n  <li>Тимчасово непридатний<ul>\r\n      <li>надається на визначений період (лікування, відпустка) — конкретний строк зазначається в постанові</li>\r\n      <li>документ дійсний до призначеної дати повторного огляду</li>\r\n    </ul>\r\n  </li>\r\n  <li>Непридатний<ul>\r\n      <li>у мирний чи воєнний час — зі зняттям з обліку або з перевіркою через 6–12 місяців</li>\r\n    </ul>\r\n  </li>\r\n</ul>\r\n\r\n<h2>Права та обов’язки призовника</h2>\r\n\r\n<p>Громадяни мають право:</p>\r\n<ul>\r\n  <li>ознайомлюватись з висновками лікарів та комісії;</li>\r\n  <li>оскаржувати рішення ВЛК у вищій комісії або в судовому порядку;</li>\r\n  <li>вимагати проведення додаткових обстежень при незгоді з рішенням.</li>\r\n</ul>\r\n\r\n<p>При цьому вони зобов’язані:</p>\r\n<ul>\r\n  <li>з’являтись у визначений час до ТЦК та СП;</li>\r\n  <li>надавати достовірну медичну інформацію та документи;</li>\r\n  <li>виконувати законні вимоги лікарів і членів комісії.</li>\r\n</ul>\r\n\r\n<h2>Висновок</h2>\r\n\r\n<p>Проходження військово-лікарської комісії – важлива складова призовної кампанії, яка дозволяє об’єктивно оцінити стан здоров’я громадян та прийняти виважене рішення щодо їхньої участі у військовій службі. Забезпечення прозорості, дотримання прав осіб і медичних стандартів є ключовими чинниками довіри до цього процесу.</p>	Загальна інформація про ВЛК - правова основа, склад, функції. Категорії придатності.
reservation-of-employees-for-the-period-of-mobilization	en	Reservation of employees of enterprises in Ukraine during martial law	<p>Since Russia's full-scale invasion of Ukraine in February 2022, workforce reservation has become crucial for maintaining economic stability.</p>\r\n\r\n<h2>Legal Framework</h2>\r\n<p>Key regulations include:</p>\r\n<ul>\r\n  <li>Ukraine's "On Mobilization Preparation and Mobilization" Law</li>\r\n  <li>Cabinet Resolution No.76 (27.01.2023)</li>\r\n  <li>Decrees by Economy and Defense Ministries</li>\r\n</ul>\r\n\r\n<h2>Eligibility Criteria</h2>\r\n<p>Employees qualify if they:</p>\r\n<ol>\r\n  <li>Maintain critical infrastructure</li>\r\n  <li>Work at economically vital enterprises</li>\r\n  <li>Possess unique qualifications</li>\r\n  <li>Fulfill defense contracts</li>\r\n</ol>\r\n\r\n<h2>Application Process</h2>\r\n<p>Employers must:</p>\r\n<ol>\r\n  <li>Submit ministry application</li>\r\n  <li>Provide employee list with justification</li>\r\n  <li>Obtain approval</li>\r\n  <li>Notify military offices</li>\r\n</ol>\r\n\r\n<h2>Limitations</h2>\r\n<ul>\r\n  <li>Revocable status</li>\r\n  <li>Excludes drafted employees</li>\r\n  <li>Requires periodic renewal</li>\r\n  <li>Peace-time service obligation remains</li>\r\n</ul>\r\n\r\n<h2>Employer Responsibilities</h2>\r\n<ul>\r\n  <li>Ensure actual employment</li>\r\n  <li>Report terminations immediately</li>\r\n  <li>Prevent system abuse</li>\r\n  <li>Cooperate with authorities</li>\r\n</ul>\r\n\r\n<h2>Future Developments</h2>\r\n<ol>\r\n  <li>Streamlined procedures</li>\r\n  <li>Enhanced oversight</li>\r\n  <li>Clearer criteria</li>\r\n  <li>Stronger penalties</li>\r\n</ol>\r\n\r\n<p>This system balances military needs with economic stability during wartime.</p>	A short introductory review article on the topic of booking for the period of martial law. It is useful to start with it.
reservation-of-employees-for-the-period-of-mobilization	uk	Бронювання працівників підприємств в Україні під час воєнного стану	<p>З початком повномасштабного вторгнення російської федерації в Україну в лютому 2022 року, одним із ключових питань для підтримки економіки стало забезпечення стабільної роботи підприємств. Важливим інструментом для цього стало бронювання працівників від мобілізації.</p>\r\n\r\n<h2>Правова основа бронювання</h2>\r\n\r\n<p>Основні норми, що регулюють процес бронювання працівників, містяться у наступних документах:</p>\r\n\r\n<ul>\r\n  <li>Закон України "Про мобілізаційну підготовку та мобілізацію"</li>\r\n  <li>Постанова Кабінету Міністрів України №76 від 27 січня 2023 року</li>\r\n  <li>Накази Міністерства економіки та Міністерства оборони</li>\r\n</ul>\r\n\r\n<h2>Критерії для бронювання</h2>\r\n\r\n<p>Право на бронювання мають працівники підприємств, які:</p>\r\n\r\n<ol>\r\n  <li>Забезпечують функціонування критичної інфраструктури</li>\r\n  <li>Працюють на підприємствах, що мають важливе значення для економіки</li>\r\n  <li>Володіють унікальними кваліфікаціями, необхідними для роботи підприємства</li>\r\n  <li>Забезпечують виконання державного оборонного замовлення</li>\r\n</ol>\r\n\r\n<h2>Процедура оформлення бронювання</h2>\r\n\r\n<p>Для оформлення бронювання роботодавець повинен:</p>\r\n\r\n<ol>\r\n  <li>Подати заявку до відповідного міністерства або відомства</li>\r\n  <li>Надати перелік працівників з обґрунтуванням необхідності їх бронювання</li>\r\n  <li>Отримати рішення про затвердження бронювання</li>\r\n  <li>Інформувати ТЦК та СП про включення працівників до переліку броньованих</li>\r\n</ol>\r\n\r\n<h2>Обмеження та особливості</h2>\r\n\r\n<p>Важливо враховувати, що бронювання:</p>\r\n\r\n<ul>\r\n  <li>Не є абсолютним і може бути скасоване у разі зміни обставин</li>\r\n  <li>Не поширюється на працівників, які вже отримали повістки</li>\r\n  <li>Може бути тимчасовим і потребує періодичного підтвердження</li>\r\n  <li>Не звільняє від обов'язкової військової служби в мирний час</li>\r\n</ul>\r\n\r\n<h2>Відповідальність роботодавців</h2>\r\n\r\n<p>Підприємства, які отримали право на бронювання працівників, зобов'язані:</p>\r\n\r\n<ul>\r\n  <li>Забезпечувати фактичне виконання працівниками своїх обов'язків</li>\r\n  <li>Негайно повідомляти про звільнення броньованих працівників</li>\r\n  <li>Не допускати зловживань при використанні механізму бронювання</li>\r\n  <li>Співпрацювати з органами мобілізації у разі необхідності</li>\r\n</ul>\r\n\r\n<h2>Перспективи розвитку механізму</h2>\r\n\r\n<p>У зв'язку з триваючим воєнним станом, система бронювання продовжує вдосконалюватись. Очікуються зміни, спрямовані на:</p>\r\n\r\n<ol>\r\n  <li>Оптимізацію процедур оформлення</li>\r\n  <li>Удосконалення механізмів контролю</li>\r\n  <li>Більш чітке визначення критеріїв бронювання</li>\r\n  <li>Посилення відповідальності за зловживання</li>\r\n</ol>\r\n\r\n<p>Система бронювання працівників залишається важливим інструментом балансування між потребами армії та необхідністю підтримки функціонування економіки в умовах воєнного стану.</p>	Коротка вступна оглядова стаття на тему бронювання на період воєнного стану. Корисно почати саме з неї.
code-of-ukraine-on-administrative-offenses	en	Code of Ukraine on Administrative Offenses	<p>The Code of Ukraine on Administrative Offenses is the main legal act regulating administrative liability for offenses that infringe upon governance order, public order, property, citizens' rights, and the established order of administration.</p>\r\n\r\n<p>The document was adopted on December 7, 1984, has the number <i>8073-X</i>, and has been repeatedly amended and supplemented to meet the needs of society and legal development.</p><p><a href="https://zakon.rada.gov.ua/laws/show/80731-10#Text" target="_blank">Link to the document</a>.</p>\r\n\r\n<p>The Code consists of a preamble and 5 sections, which are further divided into chapters and articles. Its structure is logically organized, allowing easy navigation through the provisions of the document.</p>\r\n\r\n<h2>Main Sections of the Code</h2>\r\n\r\n<p>Section I. General Provisions — establishes the basics of administrative liability, the concept of an administrative offense, jurisdictional boundaries, and the Code's application in time and space.</p>\r\n\r\n<p>Section II. Administrative Offense and Administrative Liability — contains a list of types of administrative penalties, rules for their imposition, and also defines circumstances that mitigate or aggravate liability.</p>\r\n\r\n<p>Section III. Authorities (Officials) Authorized to Consider Cases of Administrative Offenses — defines the range of bodies authorized to draw up protocols and consider cases of administrative offenses.</p>\r\n\r\n<p>Section IV. Proceedings in Cases of Administrative Offenses — regulates the procedure for drawing up protocols, reviewing cases, issuing decisions, appealing, and enforcing rulings.</p>\r\n\r\n<p>Section V. Features of Proceedings in Cases of Certain Categories — covers specifics of reviewing cases concerning minors, military personnel, foreigners, as well as proceedings in cases related to traffic safety, public order, etc.</p>\r\n\r\n<h2>Significance of the Code</h2>\r\n<p>The Code of Ukraine on Administrative Offenses plays an important role in maintaining public order, discipline, and the rule of law in the state. Its provisions are applied in the daily work of internal affairs bodies, courts, executive authorities, and other subjects of governmental powers.</p>\r\n	An introductory review article about one of the main documents regulating the field of administrative law.
increase-fines-for-speeding-violations-2025	en	Ukraine Plans to Increase Fines for Speeding Violations	<p>Members of the Verkhovna Rada intend to raise fines for drivers who exceed speed limits and eliminate the current tolerance of "+20 km/h." These changes are outlined in Draft Law No. 13314 dated May 26, 2025, titled "On Amendments to the Code of Ukraine on Administrative Offenses Regarding the Introduction of Proportional Liability for Exceeding Established Vehicle Speed Limits."<br><br>The draft is based on the premise that excessive speed is a leading cause of fatalities and injuries resulting from traffic accidents. Lawmakers argue that the Code of Administrative Offenses (CUoAO) fails to fulfill one of its main functions: preventing administrative violations, particularly those related to speeding.<br><br>They cite a survey in which 54% of Ukrainians reportedly support lowering the penalty threshold by 10 km/h. However, a closer look reveals that only 28% fully support the proposed changes.<br><br>The proposed fine structure is as follows:<br><br>No.&nbsp; &nbsp; Speed Limit Exceeded&nbsp; &nbsp; Fine<br>1&nbsp; &nbsp; &gt;10 km/h&nbsp; &nbsp; 340 UAH<br>2&nbsp; &nbsp; &gt;20 km/h&nbsp; &nbsp; 680 UAH<br>3&nbsp; &nbsp; &gt;30 km/h&nbsp; &nbsp; 1,360 UAH<br>4&nbsp; &nbsp; &gt;40 km/h&nbsp; &nbsp; 1,700 UAH<br>5&nbsp; &nbsp; &gt;60 km/h&nbsp; &nbsp; 2,720 UAH<br>6&nbsp; &nbsp; &gt;80 km/h&nbsp; &nbsp; 3,400 UAH<br>7&nbsp; &nbsp; Any of the above (1–6) that causes a hazardous situation&nbsp; &nbsp; License suspension for 6 to 12 months<br><br>Lawmakers aim to reduce the traffic fatality rate by 35%, using Poland’s experience over the past four years as an example. As a reference point, they note that 1,770 people died in 2024 in Ukraine as a result of speeding-related accidents.</p>	Fines for speeding are set to rise in proportion to how much a driver exceeds the speed limit
сode-of-administrative-procedure-of-ukraine	en	Code of Administrative Procedure of Ukraine	<p>The <strong>Code of Administrative Procedure of Ukraine</strong> is the primary legislative act that defines the procedure for appealing decisions, actions (or inaction) of state authorities and local self-government bodies, as well as the time limits and means for representing interests in administrative court cases.\r\n  </p><p><a href="https://zakon.rada.gov.ua/laws/show/2747-15#Text" target="_blank">Link to the official source</a></p><p>Document No. 2747-IV, currently in force.\r\n  </p>\r\n\r\n  <h2>Fundamental Principles Established by the Code:</h2>\r\n  <ul>\r\n    <li>The right to access the court and methods of legal protection;</li>\r\n    <li>Equality of all participants in the judicial process before the law and the court;</li>\r\n    <li>Adversarial nature of proceedings;</li>\r\n    <li>Transparency of the court process;</li>\r\n    <li>Openness of case-related information.</li>\r\n  </ul>\r\n\r\n  <p>\r\n    This legislative document must be followed by all participants in the judicial process — judges, lawyers, plaintiffs, and defendants.\r\n  </p>\r\n\r\n  <h2>Key Chapters Plaintiffs Should Pay Attention To:</h2>\r\n  <ul>\r\n    <li>Jurisdiction</li>\r\n    <li>Parties involved</li>\r\n    <li>Evidence</li>\r\n    <li>Deadlines</li>\r\n    <li>Summons</li>\r\n    <li>Costs</li>\r\n    <li>Application</li>\r\n    <li>Initiation of proceedings</li>\r\n    <li>Case consideration</li>\r\n    <li>Case closure</li>\r\n    <li>Simplified proceedings</li>\r\n    <li>Appeal proceedings</li>\r\n    <li>Cassation proceedings</li>\r\n    <li>Review of decisions</li>\r\n  </ul>\r\n\r\n  <p>\r\n    The Code is quite extensive, comprising approximately 276 A4-format pages and around 400 articles.\r\n    It is not necessary to read and know everything, as much of it is intended for judges.\r\n    However, if you decide to initiate an appeal process, it is essential to familiarize yourself with the sections listed above.\r\n  </p>	A brief overview of one of the key documents in administrative law that governs judicial proceedings.
сode-of-administrative-procedure-of-ukraine	uk	Кодекс адміністративного судочинства України	<p>Кодекс адміністративного судочинства України є основним нормативно‑правовим актом, що визначає порядок оскарження рішень, дій (бездіяльності) органів державної влади й органів місцевого самоврядування, а також строків та засобів представництва інтересів у адміністративних судових справах.<br><br><a href="https://zakon.rada.gov.ua/laws/show/2747-15#Text" target="_blank">Посилання на офіційне джерело</a>&nbsp;<br><br>Документ 2747-IV, чинний.<br><br>Кодекс закріплює такі основні засади:</p><ul><li>право на звернення до суду та способи судового захисту;</li><li>рівність усіх учасників судового процесу перед законом і судом;</li><li>змагальність сторін;</li><li>гласність судового процесу;</li><li>відкритість інформації щодо справи;</li></ul><p>Даним нормативно-правовим документом керуються всі учасники судового процесу - судді, адвокати, позивачі та відповідачі.&nbsp;<br><br></p><h2 class="">Основні глави, на які треба звернути увагу позивачу</h2><ul><li>Юрисдикція</li><li>Учасники</li><li>Докази</li><li>Строки</li><li>Повістки</li><li>Витрати</li><li>Заява</li><li>Відкриття провадження</li><li>Розгляд</li><li>Закриття</li><li>Спрощене провадження</li><li>Апеляційне провадження</li><li>Касаційне провадження</li><li>Перегляд</li></ul><p>Кодекс дуже великим за змістом, має приблизно 276 сторінок формату А4 і 400 статей. Не все потрібно знати та прочитати, тому що велика частка призначена для судів. Але, Якщо ви вирішили почати процес оскарження, то прочитати все що вказано вище необхідно.&nbsp;<br><br></p>	Стислий огляд одного з основних документів адміністративного права, який регулює судовий процес.
amendments-resolution-no-76-27.01.23	en	Amendments to the Resolution of the Cabinet of Ministers on the Reservation of Conscripts No. 27.01.23 No. 76	<div>\r\n  <p class=""><span style="font-weight: normal;">New Changes to the CMU Resolution on Reserving Conscripts No. 27.01.23 No. 76</span></p>\r\n\r\n  <p><a href="https://zakon.rada.gov.ua/laws/show/76-2023-%D0%BF#Text">Link to the resolution</a></p>\r\n\r\n  <p>This resolution defines:</p>\r\n  <ul>\r\n    <li>the procedure for reserving conscripts during mobilization and wartime</li>\r\n    <li>criteria and procedures for identifying enterprises as critically important</li>\r\n  </ul>\r\n\r\n  <h3>Main Changes</h3>\r\n\r\n  <ul>\r\n    <li>Expanded criteria for recognizing enterprises as critically important. Added are legal entities, regardless of organizational-legal form, that guard fuel and energy complex facilities and whose founder, participant (shareholder) is a business company with 100% state-owned shares (directly or indirectly).</li>\r\n    <li>The reservation procedure does not apply to conscripts registered with the Security Service of Ukraine or Ukrainian intelligence agencies.</li>\r\n    <li>The number of conscripted employees in heat energy-related enterprises subject to reservation must not exceed 75% of the total conscripted employees of such enterprises.</li>\r\n  </ul>\r\n</div>\r\n\r\n	Some changes in the criteria for recognizing enterprises as critical. Changes for employees of enterprises related to thermal energy.
increase-fines-for-speeding-violations-2025	uk	В Україні планують підвищити розміри штрафів за порушення швидкісного режиму	<p>Депутати Верховної Ради планують збільшити штрафи водіям за перевищення швидкості та прибрати «плюс 20 км/год». Це передбачається Проектом Закону 13314 від 26.05.2025 "Про внесення змін до Кодексу України про адміністративні правопорушення щодо запровадження пропорційності відповідальності за перевищення встановлених обмежень швидкості руху транспортних засобів".<br><br>Проєкт ґрунтується на тому, що надмірна швидкість є основною причиною смертності та травмування внаслідок ДТП. Депутати стверджують, що КУпАП не виконує одного із основних завдань – запобігати<br>адміністративним правопорушенням, зокрема, які пов’язані із перевищенням швидкості. Депутати приводять опитування, в якому стверджується, що 54% українців погоджують зниження порогу на 10 км для застосування штрафів. Але якщо подивитись опитування, то це не зовсім так. Тільки 28% повністю підтримують нововведення.<br><br>Пропонується така градація:<br>№ Розмір перевищення швидкості руху - Відповідальність<br>1 &gt;10 км/год 340 грн&nbsp;<br>2 &gt;20 км/год 680 грн&nbsp;<br>3 &gt;30 км/год 1360 грн&nbsp;<br>4 &gt;40 км/год 1700 грн&nbsp;<br>5 &gt;60 км/год 2720 грн&nbsp;<br>6 &gt;80 км/год 3400 грн&nbsp;<br>7 Перевищення у п.1 – 6 цієї таблиці, що спричинило створення аварійної обстановки - позбавлення права керування на строк від 6 місяців до 1 року.<br><br>Депутати планують знизити процент смертності на 35% на прикладі Польщі за 4 останніх роки. В якості відправної точки вони вказуть смерті 1770 людини які сталися у 2024 році в результаті перевищення швидкості.</p>	Сума штрафу зростатиме пропорційно до величини перевищення дозволеної швидкості
сircumstances-that-are-not-a-valid-reason-for-missing-a-procedural-deadline	en	Circumstances that are not a valid reason for missing a procedural deadline	 <p>Let us consider the concept of a circumstance that <strong>may or may not be recognized</strong> as a valid reason for missing a procedural deadline.</p>\r\n\r\n  <p><a href="https://reyestr.court.gov.ua/Review/126803587" target="_blank">Reference to the decision</a></p>\r\n\r\n  <p>\r\n    The provisions of the <strong>Code of Administrative Procedure of Ukraine</strong> do not contain a closed list of valid reasons for restoring a missed procedural deadline.\r\n    Each case is assessed individually, taking into account the specific circumstances.\r\n    In other words, the concept of <em>"valid reasons for missing a deadline"</em> is evaluative in nature and is decided at the discretion of the court.\r\n  </p>\r\n\r\n  <p>\r\n    If a person was unaware of a violation of their rights but, from a certain point in time, <strong>should have become aware of it</strong>,\r\n    the procedural period begins from that moment.\r\n    The law is based not only on the person's actual awareness of the violation but also on their <strong>objective ability</strong> to be aware of such a fact.\r\n    Comparing the wording <em>"became aware"</em> and <em>"should have become aware"</em> suggests a presumption of a person's duty to know the status of their rights.\r\n  </p>\r\n\r\n  <p>\r\n    To determine whether the person could and should have known about the violation,\r\n    the court must establish facts that clearly demonstrate a high and sufficient likelihood that the person was or could reasonably be expected to be informed.\r\n    Only then can the missed deadline be deemed to have valid reasons.\r\n  </p>\r\n\r\n  <h2>Conclusion</h2>\r\n  <p>\r\n    The Grand Chamber of the Supreme Court concluded that a person's <strong>subjective understanding</strong> of the legal consequences of an act,\r\n    as well as <strong>ignorance due to indifference to one’s rights</strong> or an intentional avoidance of information,\r\n    <strong>cannot be considered objective reasons</strong> preventing timely recourse to the court.\r\n    Therefore, an incorrect belief that no rights were violated over an extended period\r\n    <strong>does not justify passive behavior</strong> or procedural inaction on the part of the plaintiff.\r\n  </p>	The Grand Chamber of the Supreme Court Provided a Legal Assessment of a Circumstance That Cannot Be Considered a Valid Reason for Missing a Procedural Deadline
сircumstances-that-are-not-a-valid-reason-for-missing-a-procedural-deadline	uk	Обставина, яка не є поважною причиною пропуску процесуального строку	<p>Розглянемо таке поняття як обставина, як може бути або ні визнана поважною причиною пропуску процесуального строку.&nbsp;</p><p><a href="https://reyestr.court.gov.ua/Review/126803587" target="_blank">Посилання на рішення</a><br><br>Норми Кодексу адміністративного судочинства України не містять закритого переліку поважних причин для поновлення пропущеного процесуального строку. Кожна ситуація оцінюється індивідуально з урахуванням обставин конкретної справи. Іншими словами, поняття «поважні причини пропуску строку» має оціночний характер і вирішується судом на власний розсуд.<br><br>Якщо особа не знала про факт порушення своїх прав, але з певного моменту повинна була про нього дізнатись, відлік процесуального строку починається саме з цього моменту. Закон виходить не лише з фактичної обізнаності особи, а й з її об’єктивної можливості бути поінформованою про порушення. Співставлення формулювань «дізналася» і «повинна була дізнатися» свідчить про наявність презумпції обов’язку особи знати про стан своїх прав.<br><br>Для того щоб встановити, чи особа могла і повинна була дізнатись про порушення, суд має з’ясувати обставини, які б підтверджували реальну ймовірність обізнаності на достатньому рівні для висновку про те, що строк звернення був пропущений з об’єктивно поважних причин.<br></p><h2 class="">Висновок</h2><p>Велика Палата Верховного Суду дійшла висновку, що суб’єктивне сприйняття особою правових наслідків правопорушення, а також необізнаність через незацікавленість у власних правах або свідоме уникнення інформації не можуть визнаватися об’єктивними перешкодами для своєчасного звернення до суду. Тому хибна впевненість у відсутності порушення протягом тривалого часу не виправдовує пасивної поведінки позивача та його бездіяльність у процесі.</p>	Велика Палата Верховного Суду надала правову оцінку обставині, яка не може вважатися поважною підставою для поновлення пропущеного процесуального строку.
document-verification-for-drivers	en	Document Verification for Drivers	<h1>Document Verification for Drivers by Police Officers: Updated Requirements and Procedures</h1><p>Since the beginning of 2024, important changes to the legislation regarding the verification of documents for vehicle drivers have come into force in Ukraine. These amendments to the Law of Ukraine "On the National Police" were introduced to improve road safety, reduce the level of offenses, and enhance the procedure for driver-police interaction during roadside checks.</p> <h2>Main Reasons for Document Verification</h2><p>Verifying drivers' documents is one of the key functions of the National Police, carried out to maintain public safety and order on the roads. The law stipulates that police officers have the right to stop vehicles and request the presentation of documents in the following cases:</p> <ul> <li><strong>Violation of traffic rules (TAC)</strong>. This is the most common reason for stopping vehicles. If a driver violates established rules, the police officer has the right to demand the presentation of a driver's license, vehicle registration documents, and insurance policies.</li> <li><strong>Suspicion of technical malfunction of the vehicle</strong>. If the vehicle appears faulty or poses a danger to other road users, the police officer may stop the vehicle for a technical check and document verification.</li> <li><strong>Conducting special operations</strong>. The National Police have the right to check drivers' documents as part of special operations, such as searching for stolen vehicles or criminals.</li> <li><strong>Suspicion of a criminal offense</strong>. If the driver or passengers are suspected of being involved in a criminal offense, the police officer may request documents to confirm their identity and the legality of the vehicle use.</li> <li><strong>Alcohol or drug intoxication</strong>. If the police officer has grounds to believe that the driver is intoxicated, they may stop the vehicle for document verification and direct the driver for a medical examination.</li> </ul> <h2>Documents Drivers Must Present</h2> <p>The law defines a list of documents that the driver is required to carry and present at the request of the police:</p> <ul> <li>A driver's license of the appropriate category.</li> <li>A vehicle registration certificate.</li> <li>A mandatory civil liability insurance policy for vehicle owners (MTPL).</li> <li>For commercial vehicle drivers, additional documents confirming the right to carry out transportation are required.</li> </ul> <h2>Verification Procedure</h2> <p>According to the updated legal norms, the police officer is required to verify the documents strictly within the scope of their powers and in accordance with established procedures. During the vehicle stop, the police officer must identify themselves, state their position, and explain the reason for the stop. The driver, in turn, has the right to know why they were stopped and may ask for clarification on the reasons for the document check.</p> <p>The police officer does not have the right to demand documents from the driver without explaining the reason for the stop or in the absence of legal grounds for the check. Additionally, the driver has the right to record the actions of the police officers using video or audio recording, which helps ensure transparency and compliance with the rights of all road users.</p> <h2>Refusal to Present Documents and Its Consequences</h2> <p>Refusal by the driver to present documents to the police is considered an administrative offense, which can have serious consequences. According to the Code of Administrative Offenses of Ukraine, a driver who refuses to present documents at the request of a police officer may be fined or even temporarily deprived of the right to drive the vehicle.</p> <p>Moreover, attempting to flee from the police or refusing to comply with their lawful demands can lead to more serious legal consequences, including detention or prosecution for resisting law enforcement officers.</p> <h2>Drivers' Rights and Responsibilities During Document Checks</h2> <p>Drivers have several rights during document checks:</p> <ul> <li>To know the reason for the stop and the purpose of the check.</li> <li>To request the police officer's identification.</li> <li>To record interactions with police officers using video or audio devices.</li> <li>To challenge the actions of the police if their powers are violated.</li> </ul> <p>At the same time, drivers are required to:</p> <ul> <li>Present documents at the request of the police officer.</li> <li>Comply with the lawful demands of law enforcement officers.</li> <li>Maintain public order and not obstruct the police in performing their duties.</li> </ul> <h2>New Technologies in Document Verification</h2> <p>With the introduction of digital technologies, the National Police increasingly use electronic means to verify documents. Drivers can present documents in the form of digital copies through the "Diia" app. This significantly simplifies the verification process, as it allows drivers to store all necessary documents electronically and quickly provide them at the police officer's request.</p> <h2>Conclusion</h2> <p>The updated rules for document verification for drivers introduced in Ukraine aim to improve road safety and ensure proper control over compliance with traffic rules. Drivers should be aware of their rights and obligations, as well as comply with the lawful demands of the police to avoid misunderstandings and legal consequences during checks.</p>	Since the beginning of 2024, important changes to the legislation regarding the verification of documents for vehicle drivers have come into force in Ukraine. These amendments to the Law of Ukraine "On the National Police" were introduced to improve road safety, reduce the level of offenses, and enhance the procedure for driver-police interaction during roadside checks.
laws-and-regulations-governing-the-field-of-military-law	en	Laws and regulations governing the field of military law	<p>Military law is an essential part of the national legal system, which defines the legal foundations of the activities of the Armed Forces of Ukraine and other military formations. Its purpose is to ensure the effective defense of the state, the observance of legal order in the Armed Forces, as well as the rights and duties of military personnel.</p>\r\n\r\n<h2>Main Sources of Military Law</h2>\r\n\r\n<p>The key legislative acts regulating the field of military law include:</p>\r\n\r\n<ul>\r\n  <li><em>The Constitution of Ukraine</em> — establishes the basic principles of state defense, the legal status of the Armed Forces, and the obligation of citizens to defend the homeland.</li>\r\n  <li><em>The Law of Ukraine "On the Defense of Ukraine"</em> — defines the legal basis of defense, the procedure for its organization, and the tasks of the Armed Forces of Ukraine.</li>\r\n  <li><em>The Law of Ukraine "On the Armed Forces of Ukraine"</em> — determines the structure, functions, powers, and operational procedures of the Armed Forces.</li>\r\n  <li><em>The Law of Ukraine "On Military Duty and Military Service"</em> — regulates conscription, military service, benefits, and social guarantees for military personnel.</li>\r\n  <li><em>The Criminal Code of Ukraine</em> — contains a section on military crimes, including responsibility for violations of military discipline, desertion, insubordination, and other offenses.</li>\r\n</ul>\r\n\r\n<h2>Subordinate Regulatory Acts</h2>\r\n\r\n<p>In addition to laws, decrees of the President of Ukraine, resolutions of the Cabinet of Ministers, and orders of the Ministry of Defense and the General Staff of the Armed Forces play an important role. They detail legal provisions and regulate practical aspects of military service.</p>\r\n\r\n<p>For example, orders of the Ministry of Defense define:</p>\r\n\r\n<ul>\r\n  <li>the procedure for military service;</li>\r\n  <li>requirements for military uniforms and insignia;</li>\r\n  <li>internal rules in military units;</li>\r\n  <li>mobilization procedures and reservist training.</li>\r\n</ul>\r\n\r\n<h2>International Humanitarian Law</h2>\r\n\r\n<p>An important component of military law is international treaties, in particular the 1949 Geneva Conventions and their Additional Protocols. They regulate the rules of warfare, the protection of civilians, the wounded, and prisoners of war. Ukraine is a party to these international treaties, and their provisions take precedence over national legislation in case of conflict.</p>\r\n\r\n<h2>Judicial Practice and Interpretation</h2>\r\n\r\n<p>Judicial practice, especially the decisions of the Constitutional Court of Ukraine and the Supreme Court, plays a significant role in forming and clarifying military law norms. They provide legal interpretations regarding the application of laws in specific situations, such as mobilization, discharge from military service, and the liability of military personnel.</p>\r\n\r\n<h2>Conclusion</h2>\r\n\r\n<p>The field of military law in Ukraine is governed by a set of laws, subordinate acts, and international treaties. It is dynamic and requires continuous updates in response to changes in security and defense. A clear and effective legal framework ensures the combat readiness of the army, the protection of the rights of service members, and the safeguarding of national interests.</p>\r\n	An introductory article on the topic of military law will introduce the reader to the main regulatory and legal documents in this area.
laws-and-regulations-governing-the-field-of-military-law	uk	Закони та нормативно-правові акти, які регулюють сферу військового права	<p>Військове право є важливою складовою системи національного законодавства, яка визначає правові засади діяльності Збройних Сил України та інших військових формувань. Його мета — забезпечити ефективну оборону держави, дотримання правового порядку у Збройних Силах, а також прав та обов’язків військовослужбовців.</p>\r\n\r\n<h2>Основні джерела військового права</h2>\r\n\r\n<p>До ключових законодавчих актів, які регулюють сферу військового права, належать:</p>\r\n\r\n<ul>\r\n  <li><em>Конституція України</em> — закріплює основні засади оборони держави, правовий статус Збройних Сил та обов’язок громадян щодо захисту Вітчизни.</li>\r\n  <li><em>Закон України «Про оборону України»</em> — визначає правові основи оборони, порядок її організації, завдання Збройних Сил України.</li>\r\n  <li><em>Закон України «Про Збройні Сили України»</em> — встановлює структуру, функції, повноваження та порядок діяльності Збройних Сил.</li>\r\n  <li><em>Закон України «Про військовий обов’язок і військову службу»</em> — регулює призов, проходження служби, пільги та соціальні гарантії військовослужбовців.</li>\r\n  <li><em>Кримінальний кодекс України</em> — містить розділ про військові злочини, які передбачають відповідальність за порушення військової дисципліни, дезертирство, непокору та інші правопорушення.</li>\r\n</ul>\r\n\r\n<h2>Підзаконні нормативно-правові акти</h2>\r\n\r\n<p>Окрім законів, у військовій сфері важливу роль відіграють укази Президента України, постанови Кабінету Міністрів, накази Міністерства оборони та Генерального штабу ЗСУ. Вони деталізують норми законів і регулюють практичні аспекти військової служби.</p>\r\n\r\n<p>Наприклад, накази Міністерства оборони визначають:</p>\r\n\r\n<ul>\r\n  <li>порядок проходження військової служби;</li>\r\n  <li>вимоги до військової форми та відзнак;</li>\r\n  <li>внутрішній розпорядок у військових частинах;</li>\r\n  <li>питання мобілізації та підготовки резервістів.</li>\r\n</ul>\r\n\r\n<h2>Міжнародне гуманітарне право</h2>\r\n\r\n<p>Важливою складовою військового права є міжнародні договори, зокрема Женевські конвенції 1949 року та додаткові протоколи до них. Вони регулюють правила ведення війни, захист цивільного населення, поранених та військовополонених. Україна є стороною цих міжнародних договорів, і відповідні норми мають пріоритет перед національним законодавством у разі суперечностей.</p>\r\n\r\n<h2>Судова практика та тлумачення</h2>\r\n\r\n<p>Судова практика, зокрема рішення Конституційного Суду України та Верховного Суду, відіграє важливу роль у формуванні та уточненні норм військового права. Вони надають юридичні роз’яснення щодо застосування законів у конкретних ситуаціях, зокрема щодо мобілізації, звільнення з військової служби та відповідальності військовослужбовців.</p>\r\n\r\n<h2>Висновок</h2>\r\n\r\n<p>Сфера військового права в Україні регулюється комплексом законів, підзаконних актів та міжнародних договорів. Вона має динамічний характер і потребує постійного оновлення в умовах змін у сфері безпеки та оборони. Чітка та ефективна правова база є запорукою боєздатності армії, дотримання прав військовослужбовців і захисту національних інтересів.</p>\r\n	Ввідна стаття на тему військового права познайомить читача з основними нормативно-правовими документами у цій сфері.
document-verification-for-drivers	uk	Перевірка документі у водіїв транспортних засобів	<h2>Перевірка документів у водіїв працівниками поліції: оновлені вимоги та процедури</h2>\r\n<p>З початку 2024 року в Україні набули чинності важливі зміни до законодавства, що стосуються перевірки документів у водіїв транспортних засобів. Відповідні правки до Закону України «Про Національну поліцію» були внесені для підвищення безпеки на дорогах, зниження рівня правопорушень та вдосконалення процедури взаємодії водіїв із поліцейськими під час дорожніх перевірок.</p>\r\n<h3>Основні причини для перевірки документів</h3>\r\n<ul>Перевірка документів водіїв є однією з важливих функцій Національної поліції, що виконується з метою підтримання громадської безпеки та порядку на дорогах. Закон передбачає, що поліцейські мають право зупиняти транспортні засоби та вимагати у водіїв пред'явлення документів у таких випадках:\r\n    <li>Порушення правил дорожнього руху (ПДР). Це найбільш поширена причина зупинки автомобілів. Якщо водій порушує встановлені правила, поліцейський має право вимагати пред'явити посвідчення водія, реєстраційні документи на транспортний засіб та страхові поліси.</li>\r\n    <li>Виникнення підозри щодо технічної несправності транспортного засобу. Якщо автомобіль виглядає несправним або створює небезпеку для інших учасників руху, поліцейський може зупинити транспорт для перевірки технічного стану та документів.</li>\r\n    <li>Проведення спеціальних заходів. Національна поліція має право перевіряти документи у водіїв у рамках спеціальних операцій, наприклад, пошуку викрадених автомобілів або злочинців.</li>\r\n    <li>Підозра у вчиненні кримінального правопорушення. Якщо водія або пасажирів підозрюють у причетності до кримінального правопорушення, поліцейський може вимагати документи для підтвердження їх особи та законності використання транспортного засобу.</li>\r\n    <li>Стан алкогольного або наркотичного сп'яніння. Якщо у поліцейського є підстави вважати, що водій перебуває у стані сп'яніння, його можуть зупинити для перевірки документів та направлення на медичний огляд.</li>\r\n</ul>\r\n<h3>Документи, які необхідно пред'являти водіям</h3>\r\n<ul>Закон визначає перелік документів, які водій зобов'язаний мати при собі та пред'являти на вимогу поліцейських:\r\n    <li>Посвідчення водія відповідної категорії.</li>\r\n    <li>Свідоцтво про реєстрацію транспортного засобу.</li>\r\n    <li>Поліс обов'язкового страхування цивільно-правової відповідальності власників транспортних засобів (ОСЦПВ).</li>\r\n    <li>Для водіїв комерційних транспортних засобів додатково потрібно мати документи, що підтверджують дозвіл на здійснення перевезень.</li>\r\n</ul>\r\n<h3>Процедура перевірки</h3>\r\n<p>Згідно з оновленими нормами закону, поліцейський зобов'язаний здійснювати перевірку документів виключно в рамках своїх повноважень та у відповідності до встановлених процедур. Під час зупинки транспортного засобу поліцейський повинен представитися, назвати свою посаду та причину зупинки. Водій, у свою чергу, має право знати, чому його зупинили, і може попросити пояснення причин перевірки документів.</p>\r\n<p>Поліцейський не має права вимагати у водія документи без пояснення причини зупинки або за відсутності законних підстав для перевірки. Крім того, водій має право фіксувати дії поліцейських за допомогою відео- або аудіозапису, що допомагає забезпечити прозорість та дотримання прав усіх учасників дорожнього руху.</p>\r\n<h3>Відмова від пред'явлення документів та її наслідки</h3>\r\n<p>Відмова водія від пред'явлення документів поліцейським розглядається як адміністративне правопорушення, яке може мати серйозні наслідки. Відповідно до Кодексу України про адміністративні правопорушення, водію, який відмовився пред'явити документи на вимогу поліцейського, може бути винесено штраф або навіть тимчасове позбавлення права керування транспортним засобом.</p>\r\n<p>Крім того, спроба втечі від поліцейських або відмова від виконання їх законних вимог може призвести до більш серйозних правових наслідків, включно із затриманням або притягненням до відповідальності за опір правоохоронцям.</p>\r\n<h3>Права та обов'язки водіїв під час перевірки документів</h3>\r\n<ul>Водій має ряд прав під час перевірки документів:\r\n    <li>Знати причину зупинки та мету перевірки.</li>\r\n    <li>Вимагати пред'явлення службового посвідчення поліцейського.</li>\r\n    <li>Фіксувати взаємодію з поліцейськими на відео чи аудіо.</li>\r\n    <li>Оскаржити дії поліцейських у разі порушення їхніх повноважень.</li>\r\n</ul>\r\n<ul>Водночас водій зобов'язаний:\r\n<li>Надавати документи на вимогу поліцейського.</li>\r\n    <li>Дотримуватися законних вимог правоохоронців.</li>\r\n    <li>Не порушувати громадський порядок та не перешкоджати виконанню службових обов'язків поліцейських.</li>\r\n</ul>\r\n<h3>Нові технології у перевірці документів</h3>\r\n<p>Із впровадженням цифрових технологій Національна поліція дедалі частіше використовує електронні засоби перевірки документів. Водії можуть пред'являти документи у вигляді цифрових копій через додаток «Дія». Це значно спрощує процес перевірки, оскільки дозволяє зберігати всі необхідні документи в електронному вигляді та швидко надавати їх на вимогу поліцейських.</p>\r\n<h3>Висновок</h3>\r\n<p>Оновлені правила перевірки документів у водіїв, введені в Україні, спрямовані на підвищення безпеки на дорогах та забезпечення належного контролю за дотриманням правил дорожнього руху. Водії повинні знати свої права та обов'язки, а також дотримуватися законних вимог поліцейських, щоб уникнути непорозумінь та правових наслідків під час перевірок.</p>	З початку 2024 року в Україні набули чинності важливі зміни до законодавства в сфері перевірки документів у водіїв працівниками поліції: оновлені вимоги та процедури
military-registration-document	en	Military Registration Document: Importance and Features	<p>The military registration document is an official paper confirming a person's enlistment in the Armed Forces of Ukraine or other military formations. It is mandatory for every citizen who is subject to military registration according to Ukrainian legislation.</p>\r\n\r\n<h2>Types of Military Registration Documents</h2>\r\n\r\n<p>The main types of military registration documents include:</p>\r\n\r\n<ul>\r\n  <li>Certificate of registration with the conscription office (for young men aged 17);</li>\r\n  <li>Military ID card (for conscripts);</li>\r\n  <li>Temporary certificate of a conscript (issued while the military ID is being processed);</li>\r\n  <li>Officer certificate (for reserve or retired officers).</li>\r\n</ul>\r\n\r\n<h2>Importance of the Military Document</h2>\r\n\r\n<p>This document serves several key purposes:</p>\r\n\r\n<ul>\r\n  <li>Confirmation of registration for military service;</li>\r\n  <li>Record of military service, rank, and specialty;</li>\r\n  <li>Basis for mobilization or conscription;</li>\r\n  <li>Required for employment, access to certain state services, and border crossing during martial law.</li>\r\n</ul>\r\n\r\n<h2>Who Must Have a Military Registration Document</h2>\r\n\r\n<p>All men aged 17 to 60, as well as women of certain professions (medical, telecommunications, IT, etc.) who are fit for service, are subject to military registration. Therefore, each eligible individual is required to obtain the corresponding document in a timely manner.</p>\r\n\r\n<h2>Receiving and Storing the Document</h2>\r\n\r\n<p>To receive a military registration document, one must visit the Territorial Center of Recruitment and Social Support. Required documents include a passport, tax ID code, photos, medical certificates, and other relevant paperwork.</p>\r\n\r\n<p>The document must be stored in a secure place. In case of loss, it is necessary to immediately notify the authorities, file a report, and request a duplicate. Failure to possess a military registration document may result in administrative penalties.</p>\r\n\r\n<h2>Liability for Absence or Late Updates</h2>\r\n\r\n<p>Current Ukrainian law provides administrative liability for:</p>\r\n\r\n<ul>\r\n  <li>Evasion of military registration;</li>\r\n  <li>Failure to provide updated information (e.g., change of address, marital status, or employment);</li>\r\n  <li>Loss of the document without proper notification.</li>\r\n</ul>\r\n\r\n<h2>Conclusion</h2>\r\n\r\n<p>The military registration document is an essential part of a conscript's legal status. Timely issuance, careful storage, and regular updates help avoid legal issues and ensure proper fulfillment of civic duties. During martial law, the significance of this document increases, as it forms the basis for military registration, mobilization, and national defense.</p>\r\n	An introductory article on the official document confirming a person's military registration in the Armed Forces of Ukraine. It is worth starting with it.
amendments-resolution-no-76-27.01.23	uk	Зміни до постанови КМУ щодо бронювання військовозобов'язаних № 27.01.23 № 76	<p>Нові зміни до постанови КМУ щодо бронювання військовозобов'язаних № 27.01.23 № 76</p><p><a href="https://zakon.rada.gov.ua/laws/show/76-2023-%D0%BF#Text" target="_blank">Посилання на постанову</a><br><br>Вказана постанова визначає<br></p><ul><li>порядок бронювання військовозобов’язаних на період мобілізації та на воєнний час.</li><li>критерії та порядок, визначення підприємств, які є критично важливими</li></ul><h2 class="">Основні зміни</h2><p><br>Розширені критерії визнання підприємств, які є критично важливими. До них додані юридичні особи незалежно від організаційно-правової форми, які здійснюють охорону об’єктів паливно-енергетичного комплексу і засновником, учасником (акціонером) яких є господарські товариства, у статутному капіталі яких 100 відсотків акцій (часток) прямо чи опосередковано належать державі.<br><br>Правці порядку бронювання не поширюється на військовозобов’язаних, які перебувають на військовому обліку в СБУ, розвідувальних органах України.<br><br>Встановлена кількість військовозобов’язаних працівників підприємств, що пов'язані з тепловою енергією, які підлягають бронюванню, повинна становити не більше 75 відсотків кількості військовозобов’язаних працівників таких підприємств.</p>	Деякі зміни в критеріях визнання підприємств критично важливими. Зміни для працівників підприємств, що пов'язані з тепловою енергією.
military-registration-document	uk	Військово-обліковий документ: значення та особливості	<p>Військово-обліковий документ — це офіційний документ, що підтверджує взяття особи на військовий облік у Збройних Силах України або інших військових формуваннях. Він є обов’язковим для кожного громадянина, який підлягає військовому обліку згідно з чинним законодавством України.</p>\r\n\r\n<h2>Види військово-облікових документів</h2>\r\n\r\n<p>До основних видів військово-облікових документів належать:</p>\r\n\r\n<ul>\r\n  <li>Посвідчення про приписку до призовної дільниці (для юнаків віком 17 років);</li>\r\n  <li>Військовий квиток (для військовозобов’язаних);</li>\r\n  <li>Тимчасове посвідчення військовозобов’язаного (видається на час оформлення військового квитка);</li>\r\n  <li>Офіцерське посвідчення (для осіб офіцерського складу запасу або у відставці).</li>\r\n</ul>\r\n\r\n<h2>Значення військово-облікового документа</h2>\r\n\r\n<p>Цей документ виконує кілька ключових функцій:</p>\r\n\r\n<ul>\r\n  <li>Підтвердження факту взяття на військовий облік;</li>\r\n  <li>Фіксація основних відомостей про проходження служби, звання, спеціальність;</li>\r\n  <li>Підстава для участі у мобілізації або призові;</li>\r\n  <li>Необхідний документ для працевлаштування, отримання деяких державних послуг, перетину кордону в період воєнного стану тощо.</li>\r\n</ul>\r\n\r\n<h2>Хто зобов’язаний мати військово-обліковий документ</h2>\r\n\r\n<p>Військовому обліку підлягають усі чоловіки віком від 17 до 60 років, а також жінки певних спеціальностей (медичних, телекомунікаційних, ІТ тощо), які придатні до проходження служби. Відповідно, кожна особа зобов’язана отримати відповідний обліковий документ у визначений термін.</p>\r\n\r\n<h2>Отримання та зберігання документа</h2>\r\n\r\n<p>Щоб отримати військово-обліковий документ, необхідно звернутися до територіального центру комплектування та соціальної підтримки (колишнього військкомату). При собі слід мати паспорт, ідентифікаційний код, фотографії, медичні довідки та інші документи, які можуть знадобитися під час оформлення.</p>\r\n\r\n<p>Зберігати документ необхідно у надійному місці. У разі втрати слід негайно повідомити органи ТЦК СП, написати заяву та оформити дублікат. За відсутність військово-облікового документа можуть передбачатися адміністративні санкції.</p>\r\n\r\n<h2>Відповідальність за відсутність або невчасне оновлення</h2>\r\n\r\n<p>Чинне законодавство України передбачає адміністративну відповідальність за:</p>\r\n\r\n<ul>\r\n  <li>Ухилення від взяття на військовий облік;</li>\r\n  <li>Ненадання оновленої інформації про зміну місця проживання, сімейного стану або роботи;</li>\r\n  <li>Втрату документа без належного повідомлення органів обліку.</li>\r\n</ul>\r\n\r\n<h2>Висновки</h2>\r\n\r\n<p>Військово-обліковий документ є важливою складовою правового статусу кожного військовозобов’язаного громадянина. Його своєчасне оформлення, зберігання та оновлення даних дозволяє уникнути юридичних проблем і забезпечує належне виконання обов’язків перед державою. В умовах воєнного стану роль цього документа набуває особливого значення, адже він є підставою для реалізації військового обліку, мобілізації та захисту держави.</p>	Ввідна стаття на тему офіційного документа, що підтверджує взяття особи на військовий облік у Збройних Силах України. Варто почати саме з неї.
administrative-detention	en	Administrative detention: legal grounds, terms and features	<p>Administrative detention is the forced delivery of a person to law enforcement agencies to establish identity or consider an offense. It differs from criminal detention and is regulated by the Code of Ukraine on Administrative Offenses (CUAO).</p>\r\n\r\n<div class="important">\r\nImportant: A police officer must clearly explain the reason for detention and present identification.\r\n</div><div class="important"><br></div>\r\n\r\n<h2>Legal Grounds for Administrative Detention</h2>\r\n<p>Detention is only possible in cases provided by law:</p>\r\n<ul>\r\n    <li>Public order violations (fights, offensive behavior, public intoxication - Articles 173-185 CUAO)</li>\r\n    <li>Traffic violations (driving under influence, refusal of testing - Articles 130-132)</li>\r\n    <li>Failure to comply with lawful police requests (Article 185-1)</li>\r\n    <li>Suspicion of committing an administrative offense when unable to present ID</li>\r\n</ul>\r\n\r\n<h2>Terms of Administrative Detention</h2>\r\n<ul>\r\n    <li>Up to 3 hours - standard period for identification and protocol preparation</li>\r\n    <li>Up to 72 hours - if the violation may lead to administrative arrest (e.g., petty hooliganism)</li>\r\n</ul>\r\n<p>After this period, the person is either released or transferred to court.</p>\r\n\r\n<h2>Rights of the Detainee</h2>\r\n<ul>\r\n    <li>Receive information about the reason for detention</li>\r\n    <li>Communicate in native language (with interpreter if needed)</li>\r\n    <li>Notify relatives about the detention</li>\r\n    <li>Request a lawyer - even for administrative offenses</li>\r\n    <li>Refuse testimony (Article 52 of Ukraine's Constitution)</li>\r\n</ul>\r\n\r\n<h2>What to Do If Detained?</h2>\r\n<ul>\r\n    <li>Calmly listen to the reason and check the officer's ID</li>\r\n    <li>Do not resist - this may qualify as disobedience (Article 185 CUAO)</li>\r\n    <li>Record the incident (audio/video recording, witnesses)</li>\r\n    <li>Demand a copy of the protocol</li>\r\n    <li>Contact a lawyer (even for minor offenses)</li>\r\n</ul>\r\n\r\n<h2>Comparison with Criminal Detention</h2>\r\n<table>\r\n    <tbody><tr>\r\n        <th>Criterion</th>\r\n        <th>Administrative</th>\r\n        <th>Criminal</th>\r\n    </tr>\r\n    <tr>\r\n        <td>Grounds</td>\r\n        <td>Minor offense</td>\r\n        <td>Suspicion of crime</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Duration</td>\r\n        <td>Up to 3-72 hours</td>\r\n        <td>Up to 72 hours (+ arrest)</td>\r\n    </tr>\r\n    <tr>\r\n        <td>Consequences</td>\r\n        <td>Fine, arrest up to 15 days</td>\r\n        <td>Criminal liability</td>\r\n    </tr>\r\n</tbody></table>\r\n\r\n<h2><br></h2><h2>How to Appeal Illegal Detention?</h2>\r\n<ol>\r\n    <li>File a complaint with prosecutor's office or court (Article 255 CUAO)</li>\r\n    <li>Demand compensation for moral damages</li>\r\n    <li>Contact the Ombudsman's Office or human rights organizations</li>\r\n</ol>\r\n\r\n<div class="conclusion">\r\n    <h3>Conclusion</h3>\r\n    <p>Administrative detention is not a punishment, but a measure to maintain order. However, it can be abused, so knowing your rights helps protect yourself.</p>\r\n</div>	A brief list of information you need to know and remember to protect your rights and interests.
administrative-detention	uk	Адміністративне затримання: правові підстави, строки та особливості	<p>Адміністративне затримання — це примусова доставка особи до правоохоронних органів для встановлення її особи або розгляду правопорушення. Воно відрізняється від кримінального затримання і регулюється Кодексом України про адміністративні правопорушення (КУпАП).</p><div class="important">\r\n        Важливо<strong>:</strong> Поліцейський має чітко пояснити причину затримання та представитися.</div><h2>Правові підстави для адміністративного затримання</h2>\r\n    <p>Затримання можливе лише у випадках, передбачених законом:</p>\r\n    <ul>\r\n        <li>Порушення громадського порядку (бійка, образливе поводження, сп'яніння у громадських місцях — ст. 173-185 КУпАП)</li>\r\n        <li>Порушення ПДР (керування авто у стані сп'яніння, відмова від перевірки — ст. 130-132)</li>\r\n        <li>Невиконання законних вимог поліції (ст. 185-1)</li>\r\n        <li>Підозра у вчиненні адміністративного правопорушення, якщо особа не може надати документи</li>\r\n    </ul>\r\n\r\n    <h2>Строки адміністративного затримання</h2>\r\n    <ul>\r\n        <li>До 3 годин — стандартний термін для встановлення особи та складання протоколу</li>\r\n        <li>До 72 годин — якщо порушення тягне за собою адміністративний арешт (наприклад, дрібне хуліганство)</li>\r\n    </ul>\r\n    <p>Після цього особу або відпускають, або передають до суду.</p>\r\n\r\n    <h2>Права затриманого</h2>\r\n    <ul>\r\n        <li>Отримати інформацію про причину затримання</li>\r\n        <li>Розмовляти рідною мовою (з перекладачем за потреби)</li>\r\n        <li>Повідомити близьким про затримання</li>\r\n        <li>Вимогати адвоката — навіть у випадку адміністративного правопорушення</li>\r\n        <li>Відмовитися від свідчень (ст. 52 Конституції України)</li>\r\n    </ul>\r\n\r\n    <h2>Що робити, якщо затримали?</h2>\r\n    <ul>\r\n        <li>Спокійно вислухати причину та перевірити посвідчення поліцейського</li>\r\n        <li>Не чинити опір — це може кваліфікуватися як непокора (ст. 185 КУпАП)</li>\r\n        <li>Фіксувати подію (аудіо-, відеозапис, свідки)</li>\r\n        <li>Вимагати копію протоколу</li><li>Звернутися до адвоката (навіть якщо порушення дрібне)</li></ul><h2>Порівняння з кримінальним затриманням</h2>\r\n    <table>\r\n        <tbody><tr>\r\n            <th>Критерій</th>\r\n            <th>Адміністративне</th>\r\n            <th>Кримінальне</th>\r\n        </tr>\r\n        <tr>\r\n            <td>Підстава</td>\r\n            <td>Дрібне правопорушення</td>\r\n            <td>Підозра у злочині</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Строк</td>\r\n            <td>До 3–72 годин</td>\r\n            <td>До 72 годин (+ арешт)</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Наслідки</td>\r\n            <td>Штраф, арешт до 15 діб</td>\r\n            <td>Кримінальна відповідальність</td>\r\n        </tr>\r\n    </tbody></table>\r\n\r\n    <h2><br></h2><h2>Як оскаржити незаконне затримання?</h2>\r\n    <ol>\r\n        <li>Подати скаргу до прокуратури або суду (ст. 255 КУпАП)</li>\r\n        <li>Вимагати компенсації за моральну шкоду</li>\r\n        <li>Звернутися до Офісу Омбудсмена або правозахисних організацій</li>\r\n    </ol>\r\n\r\n    <div class="conclusion">\r\n        <h3>Висновок</h3>\r\n        <p>Адміністративне затримання — це не покарання, а засіб забезпечення порядку. Але ним можуть зловживати представники влади для досягнення своєї мети, тому знання своїх прав допомагає захиститися.</p>\r\n    </div>	Стислий перелік інформації, яку потрібно знати і пам'ятати для захисту своїх прав і інтересів.
evidence-in-administrative-offense-cases-key-aspects	uk	Докази по справі про адміністративне правопорушення: ключові аспекти	        <div>\r\n            <h2>Поняття та види доказів</h2>\r\n            <p>Докази – це будь-які фактичні дані, які підтверджують або спростовують обставини, що мають значення для справи. Вони фіксуються у встановленому законом порядку та визначаються процесуальними нормами.</p>\r\n            <ul>\r\n                <li><strong>Протокол про адміністративне правопорушення</strong> – основний документ, який фіксує факт правопорушення.</li>\r\n                <li><strong>Письмові докази</strong> – документи, акти перевірок, звіти тощо.</li>\r\n                <li><strong>Речові докази</strong> – матеріальні об’єкти, пов’язані з правопорушенням.</li>\r\n                <li><strong>Пояснення осіб</strong> – свідчення правопорушника, потерпілих чи свідків.</li>\r\n                <li><strong>Фото-, відео- та аудіоматеріали</strong> – технічні записи, що фіксують обставини правопорушення.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Процес збирання доказів</h2>\r\n            <p>Збирання доказів здійснюється органами, уповноваженими складати протоколи та розглядати справи, такими як Національна поліція, митні служби, екологічні інспекції тощо. Дотримання законності при зборі доказів є ключовою умовою їх допустимості.</p>\r\n        </div>\r\n        <div>\r\n            <h2>Оцінка доказів</h2>\r\n            <p>Згідно зі ст. 252 КУпАП, орган, що розглядає справу, оцінює докази за внутрішнім переконанням, заснованим на повному та об’єктивному дослідженні. Основні принципи оцінки:</p>\r\n            <ul>\r\n                <li><strong>Належність</strong> – доказ повинен мати зв’язок з обставинами справи.</li>\r\n                <li><strong>Допустимість</strong> – доказ має бути отриманий у встановленому порядку.</li>\r\n                <li><strong>Достатність</strong> – сукупність доказів має бути достатньою для прийняття рішення.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Права сторін у справі</h2>\r\n            <p>Особи, які беруть участь у справі, мають право:</p>\r\n            <ul>\r\n                <li>Подавати власні докази.</li>\r\n                <li>Заявляти клопотання про витребування додаткових доказів.</li>\r\n                <li>Знайомитися з матеріалами справи.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Типові проблеми</h2>\r\n            <p>На практиці часто виникають такі проблеми:</p>\r\n            <ul>\r\n                <li>Неправильне складання протоколу.</li>\r\n                <li>Недостатність доказів.</li>\r\n                <li>Оскарження допустимості доказів.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Висновок</h2>\r\n            <p>Докази є основою прийняття рішень у справах про адміністративні правопорушення. Дотримання принципів належності, допустимості та достатності забезпечує законність і обґрунтованість рішень, що сприяє зміцненню правової держави.</p>\r\n        </div>	Докази у справі про адміністративне правопорушення є основним інструментом для встановлення об’єктивної істини та прийняття законного і обґрунтованого рішення.
rights-of-a-person-held-administratively-liable	en	Rights of a person held administratively liable	<h2>During a vehicle stop</h2>\r\n<p>When a vehicle is stopped, a police officer may issue a ruling in an administrative offense case without preparing a corresponding protocol. At this time, it's important to have the Administrative Code handy or remember your rights specified in Article 268 of the Code of Ukraine on Administrative Offenses.</p>\r\n\r\n<h2>Your possible actions</h2>\r\n<ul>\r\n<li>If you completely agree with the charges, then it's simple - sign the ruling and pay the fine.</li>\r\n<li>If you disagree, you need to have a defense plan before everything begins.</li>\r\n</ul>\r\n\r\n<p>One of the main components of a defense plan is knowing your rights specified in Article 268 of the Code.<br><br>\r\n<a href="https://zakon.rada.gov.ua/laws/show/80732-10#Text" target="_blank">Link to the Code</a></p>\r\n\r\n<h2>A person subject to administrative liability has the right to:</h2>\r\n<ul>\r\n<li>Examine the case materials</li>\r\n<li>Provide explanations</li>\r\n<li>Submit evidence</li>\r\n<li>File petitions</li>\r\n<li>Use legal assistance from a lawyer or other legal professional during case consideration</li>\r\n<li>Use their native language and interpreter services</li>\r\n<li>Appeal the ruling</li>\r\n</ul>\r\n\r\n<p>Administrative offense cases are considered with the person present, except when proper notification was given and no postponement was requested.</p>\r\n\r\n<h2>If you want to protect your rights</h2>\r\n<ol>\r\n<li>Review the case materials (video evidence, witness statements, officer's explanations)</li>\r\n<li>Prepare your written explanation (bring pen and paper)</li>\r\n<li>Request a postponement for legal assistance</li>\r\n<li>Submit available evidence (passenger statements, video recordings, etc.)</li>\r\n</ol>\r\n\r\n<p>Following these steps significantly improves your chances of winning if you appeal.</p>	It is important to know and have it on hand when your vehicle is stopped and a warrant is issued against you.
extension-of-the-guarantee-of-maintaining-a-servicemans-job	en	Extension of the guarantee of maintaining a serviceman's job	<p class=""><span style="font-weight: normal;"><a href="https://reyestr.court.gov.ua/Review/125855203" target="_blank">Court Decision</a></span></p>\r\n\r\n<h3>Who it applies to</h3>\r\n<p>The decision applies to employees who:</p>\r\n<ul>\r\n  <li>are conscripted for compulsory military service,</li>\r\n  <li>serve under conscription of officers,</li>\r\n  <li>serve under conscription during mobilization for a special period,</li>\r\n  <li>serve under conscription as reservists during a special period,</li>\r\n  <li>or have enlisted for military service under a contract, including by signing a new contract for military service.</li>\r\n</ul>\r\n\r\n<h3>What is preserved</h3>\r\n<ul>\r\n  <li>the workplace and position are preserved</li>\r\n  <li>monetary compensation is paid from the State Budget of Ukraine in accordance with the Law of Ukraine "On Social and Legal Protection of Military Servicemen and Their Family Members".</li>\r\n</ul>\r\n\r\n<h3>Guarantees also apply to</h3>\r\n<ul>\r\n  <li>employees who were injured (other health damages) during military service and are undergoing treatment in medical facilities,</li>\r\n  <li>those who were taken prisoner,</li>\r\n  <li>those declared missing.</li>\r\n</ul>\r\n\r\n<h3>Exceptions</h3>\r\n<ul>\r\n  <li>Civil Protection Service,</li>\r\n  <li>persons guilty of committing criminal offenses against the established procedure of military service</li>\r\n</ul>\r\n\r\n<p>The decision applies during the special period until its end or until the actual day of discharge.</p>\r\n	Employees called up for military service during the special period shall retain their place of work and position until its end.
code-of-ukraine-on-administrative-offenses	uk	Кодекс України про адміністративні правопорушення	<p>Кодекс України про адміністративні правопорушення — це основний нормативно-правовий акт, який регулює адміністративну відповідальність за правопорушення, що посягають на порядок управління, громадський порядок, власність, права громадян та встановлений порядок управління.</p><p>Документ був прийнятий 7 грудня 1984 року, має номер <i>8073-X</i> і з того часу неодноразово змінювався та доповнювався відповідно до потреб суспільства та розвитку законодавства.</p><p><a href="https://zakon.rada.gov.ua/laws/show/80731-10#Text" target="_blank">Посилання на документ</a>.</p>\r\n\r\n<p>Кодекс складається з преамбули та 5 розділів, які в свою чергу поділяються на глави та статті. Його структура логічно побудована, що дозволяє легко орієнтуватися в положеннях документа.</p>\r\n\r\n<h2>Основні розділи Кодексу</h2>\r\n\r\n<p>Розділ I. Загальні положення — встановлює основи адміністративної відповідальності, поняття адміністративного правопорушення, межі юрисдикції та дії кодексу у часі та просторі.</p>\r\n\r\n<p>Розділ II. Адміністративне правопорушення і адміністративна відповідальність — містить перелік видів адміністративних стягнень, правила їх накладення, а також визначає обставини, що пом’якшують або обтяжують відповідальність.</p>\r\n\r\n<p>Розділ III. Органи (посадові особи), уповноважені розглядати справи — визначає коло органів, які мають право складати протоколи та розглядати справи про адміністративні правопорушення.</p>\r\n\r\n<p>Розділ IV. Провадження в справах про адміністративні правопорушення — регулює порядок складання протоколів, проведення розгляду справ, винесення постанов, оскарження та виконання рішень.</p>\r\n\r\n<p>Розділ V. Особливості провадження у справах окремих категорій — охоплює специфіку розгляду справ щодо неповнолітніх, військовослужбовців, іноземців, а також провадження у справах, пов’язаних із безпекою руху, громадським порядком тощо.</p>\r\n\r\n<h2>Значення Кодексу</h2>\r\n<p>Кодекс України про адміністративні правопорушення відіграє важливу роль у підтриманні публічного порядку, дисципліни та дотриманні правопорядку в державі. Його положення застосовуються у повсякденній роботі органів внутрішніх справ, судів, органів виконавчої влади та інших суб’єктів владних повноважень.</p>\r\n	Вступна оглядова стаття про один з головних документів, які регулюють сферу адміністративного права.
extension-of-the-guarantee-of-maintaining-a-servicemans-job	uk	Поширення гарантії щодо збереження місця роботи військовослужбовця	<p><a href="https://reyestr.court.gov.ua/Review/125855203" target="_blank">Рішення суду</a><br></p><h2 class="">Кого стосується</h2><p class="">Рішення стосується працівників, які:</p><ul><li>призвані на строкову військову службу,</li><li>військову службу за призовом осіб офіцерського складу,</li><li>військову службу за призовом під час мобілізації, на особливий період,</li><li>військову службу за призовом осіб із числа резервістів в особливий період</li><li>або прийнятими на військову службу за контрактом, у тому числі шляхом укладення нового контракту на проходження військової служби.</li></ul><p></p><h2 class="">Що зберігається</h2><ul><li>зберігаються місце роботи і посада</li><li>здійснюється виплата грошового забезпечення за рахунок коштів Державного бюджету України відповідно до ЗУ «Про соціальний і правовий захист військовослужбовців та членів їх сімей».</li></ul><p>Тако ж гарантії поширюються:</p><ul><li>працівники, які під час проходження військової служби отримали поранення (інші ушкодження здоров`я) та перебувають на лікуванні у медичних закладах,</li><li>також потрапили у полон,</li><li>визнані безвісно відсутніми.</li></ul><h2 class="">Виключення</h2><ul><li>Служба цивільного захисту,</li><li>особи, винні у вчиненні кримінальних правопорушень проти встановленого порядку несення військової служби</li></ul><p>Дія поширюється під час дії особливого періоду на строк до його закінчення або до дня фактичного звільнення.&nbsp;</p>	За працівниками, призваними на строкову військову службу під час дії особливого періоду на строк до його закінчення зберігаються місце роботи і посада.
evidence-in-administrative-offense-cases-key-aspects	en	Evidence in Administrative Offense Cases: Key Aspects	        <div>\r\n            <h2>Definition and Types of Evidence</h2>\r\n            <p>Evidence is any factual information that confirms or refutes circumstances relevant to a case. It is recorded in accordance with legal procedures and defined by procedural norms.</p>\r\n            <ul>\r\n                <li><strong>Administrative Offense Protocol</strong> – the primary document recording the offense.</li>\r\n                <li><strong>Written Evidence</strong> – documents, inspection reports, records, etc.</li>\r\n                <li><strong>Material Evidence</strong> – physical objects linked to the offense.</li>\r\n                <li><strong>Explanations from Individuals</strong> – testimonies from the offender, victims, or witnesses.</li>\r\n                <li><strong>Photo, Video, and Audio Materials</strong> – technical recordings capturing the circumstances of the offense.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Evidence Collection Process</h2>\r\n            <p>Evidence is collected by authorized bodies, such as the National Police, customs authorities, or environmental inspections. Compliance with legal procedures during evidence collection ensures its admissibility in court.</p>\r\n        </div>\r\n        <div>\r\n            <h2>Evaluation of Evidence</h2>\r\n            <p>Under Article 252 of the Code of Administrative Offenses, evidence is evaluated by the authority reviewing the case based on comprehensive, objective, and thorough consideration. Key principles include:</p>\r\n            <ul>\r\n                <li><strong>Relevance</strong> – evidence must directly relate to the case.</li>\r\n                <li><strong>Admissibility</strong> – evidence must be obtained legally.</li>\r\n                <li><strong>Sufficiency</strong> – the body of evidence must be enough to establish the truth.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Rights of the Parties</h2>\r\n            <p>Parties involved in the case have the right to:</p>\r\n            <ul>\r\n                <li>Submit their own evidence.</li>\r\n                <li>Request additional evidence.</li>\r\n                <li>Review case materials.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Common Challenges</h2>\r\n            <p>Typical issues that arise include:</p>\r\n            <ul>\r\n                <li>Errors in protocol preparation.</li>\r\n                <li>Insufficient evidence.</li>\r\n                <li>Disputes over the admissibility of evidence.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Conclusion</h2>\r\n            <p>Evidence forms the foundation for decisions in administrative offense cases. Adherence to principles of relevance, admissibility, and sufficiency ensures lawful and justified resolutions, contributing to a stronger rule of law.</p>\r\n        </div>	Definition and Types of Evidence, Evidence Collection Process, Evaluation.
rights-of-a-person-held-administratively-liable	uk	Права особи, яка притягується до адміністративної відповідальності	<p>Під&nbsp; час зупинки транспортного засобу, поліцейський виносить постанову у справі про адміністративне правопорушення без складання відповідного протоколу. В цей час важливо мати під рукою адміністративний кодекс, або пам'ятати свої права, вказані в ст.268 Кодексу України про адміністративні правопорушення.</p><h2 class="">Можливі ваші дії</h2><ul><li>якщо ви повністю погоджуєтесь з пред'явленими звинуваченнями, тоді все просто - підписали постанову і сплатили штраф.</li><li>якщо ви не згодні, то треба мати план захисту до того, як все почалося.&nbsp;</li></ul><p>Однією з головних складових плану захисту є знання своїх прав, які вказані в ст. 268 Кодексу.<br><br><a href="https://zakon.rada.gov.ua/laws/show/80732-10#Text" target="_blank">Посилання на Кодекс</a><br><br></p><h2 class="">Особа, яка притягається до адміністративної відповідальності має право</h2><ul><li>знайомитися з матеріалами справи,</li><li>давати пояснення,</li><li>подавати докази,</li><li>заявляти клопотання;</li><li>при розгляді справи користуватися юридичною допомогою адвоката, іншого фахівця у галузі права, який за законом має право на надання правової допомоги особисто чи за дорученням юридичної особи,</li><li>виступати рідною мовою і користуватися послугами перекладача, якщо не володіє мовою, якою ведеться провадження;</li><li>оскаржити постанову по справі</li></ul><p>Справа про адміністративне правопорушення розглядається в присутності особи, яка притягається до адміністративної відповідальності.<br>При відсутності лише у випадках, коли є дані про своєчасне її сповіщення про місце і час розгляду справи і якщо від неї не надійшло клопотання про відкладення розгляду справи</p><h2 class="">Якщо ви хочете захистити свої права</h2><ol><li>Ознайомтесь з матеріалами справи - відеофіксація, пояснення свідків, пояснення працівника поліції.</li><li>Дайте своє пояснення. Для цього треба мати з собою ручку та аркуш паперу А4.</li><li>Заявляйте клопотання про відкладення розгляду справи по суті у зв’язку з тим, що ви потребуєте юридичної допомоги. Це теж має бути оформлено вами та вписано до постанови.</li><li>Надайте докази, які маєте - пояснення пасажира, відеознімання і таке інше.&nbsp;</li></ol><p>Якщо ви це зробили та захочете оскаржити постанову в суді, то у вас буде значно більше шансів виграти справу.&nbsp;</p>	Важливо знати та мати під рукою під час зупинки ТЗ та складання на вас постанови.
impossibility-of-judicial-appeal-of-summons-to-appear-at-the-tcr	en	Impossibility of judicial appeal of summons to appear at the Territorial Centres of Recruitment	<div><p>If you want to challenge a Territorial Centers of Recruitment(TCR) summons in court as a way to avoid responsibility for failing to appear, this article is for you.</p>\r\n\r\n  <h2>Legal Framework</h2>\r\n  <p>According to Part 7, Article 1 of the Law of Ukraine "On Military Duty and Military Service," TRCs and military enlistment offices ensure the fulfillment of military obligations.</p>\r\n  <p>Additionally, Part 3, Article 22 of the Law of Ukraine "On Mobilization Preparation and Mobilization" states that citizens are required to report to military units or assembly points upon receiving a summons.</p>\r\n\r\n  <h2>Supreme Court Ruling</h2>\r\n  <ul>\r\n    <li>Issuing a TRC summons does not constitute a decision or action by a public authority under the Code of Administrative Justice of Ukraine.</li>\r\n    <li>The summons cannot be challenged in any court because it is merely a notification for an individual to fulfill their military duty as required by law.</li>\r\n    <li>The obligation of a person liable for military service to report to the relevant TRC or enlistment office is established not by the summons but by Law No. 2232-XII.</li></ul><p><a href="https://reyestr.court.gov.ua/Review/122522303" target="_blank">Supreme Court Resolution</a></p><ul>\r\n  </ul>\r\n</div>	Review of the Supreme Court's decision on the possibility of appealing the summons from the CCC
impossibility-of-judicial-appeal-of-summons-to-appear-at-the-tcr	uk	Неможливість судового оскарження повістки на прибуття до ТЦК	<p>В разі, якщо Ви хочете оскаржити повістку про прибуття до ТЦК в суді, як привід уникнути відповідальності про неприбуття, то ця стаття саме для Вас.</p><h2 class="">Правові засади</h2><p><br>Згідно ч. 7 ст. 1 ЗУ «Про військовий обов`язок і військову службу» ТЦК та СП забезпечують виконання військового обов'язку.<br>Також ч. 3 ст. 22 ЗУ «Про мобілізаційну підготовку та мобілізацію» встановлено, що громадяни зобов'язані прибути до військових частин або на збірні пункти по повістці.<br><br></p><h2 class="">Висновок Верховного суду</h2><ul><li>Виготовлення повістки на прибуття до ТЦК не є рішенням чи дією суб`єкта владних повноважень у розумінні КАС України.</li><li>Повістка не може бути оскаржена в будь-якому суді, тому що цей документ є лише засобом оповіщення особи про необхідність виконати військовий обов`язок відповідно до закону.</li><li>При цьому обов`язок військовозобов`язаної особи з'явитися за викликом до відповідного ТЦК та СП установлений не повісткою, а Законом №2232-XII.</li></ul><p><a href="https://reyestr.court.gov.ua/Review/122522303" target="_blank">Постанова ВС</a></p>	Огляд рішення ВС про можливість оскарження повістки від ТЦК
the-importance-of-seat-belts-when-driving-a-car	en	The importance of seat belts when driving a car	<p>Seat belts are one of the simplest yet most effective means of protecting drivers and passengers in the event of a traffic accident. They save lives, reduce the risk of injury, and are mandatory under Ukrainian law. Despite their obvious importance, many drivers and passengers still ignore this rule, viewing seat belts merely as a “formality” or an “inconvenience.”</p>\r\n\r\n<p>This article explains why using seat belts is critically important, what Ukrainian Traffic Rules say about it, what the consequences are for violators, and debunks common myths.</p>\r\n\r\n<h2>What is a seat belt and how does it work?</h2>\r\n<p>A seat belt is a passive safety device designed to keep a person in place during a collision or sudden braking. Its main function is to prevent ejection from the seat, which can be fatal even at speeds of 30–50 km/h.</p>\r\n\r\n<p>A typical three-point seat belt holds the body in two directions—forward and downward—distributing the impact force over the strongest areas of the body: the clavicles, chest, and pelvis. This significantly reduces the risk of serious injury.</p>\r\n\r\n<h2>Accident statistics: seat belts save lives</h2>\r\n<p>According to the World Health Organization, proper use of seat belts:</p>\r\n<ul>\r\n  <li>reduces the risk of death for drivers and front passengers by <strong>45–50%</strong>;</li>\r\n  <li>reduces the risk of serious injuries for rear passengers by <strong>25–75%</strong>;</li>\r\n  <li>lowers the chance of being ejected from the vehicle by 2–3 times.</li>\r\n</ul>\r\n<p>In Ukraine, tens of thousands of road accidents occur annually, resulting in thousands of deaths and injuries. According to the Patrol Police, a significant number of the deceased were not wearing seat belts.</p>\r\n\r\n<h2>Legal framework: what Ukrainian traffic rules say</h2>\r\n\r\n<p>The use of seat belts is regulated by the <strong>Traffic Rules of Ukraine</strong>, particularly <strong>Section 2: "Duties and rights of drivers of motor vehicles"</strong>.</p>\r\n\r\n<blockquote>\r\n  <p><strong>Clause 2.3 of the Traffic Rules:</strong><br>\r\n  "The driver is obliged to:... (i) wear a seat belt (if available) while driving and not to transport passengers who are not wearing seat belts."</p>\r\n</blockquote>\r\n\r\n<p>This means the driver must not only wear the belt themselves but also ensure that all passengers are wearing theirs.</p>\r\n\r\n<blockquote>\r\n  <p><strong>Clause 5.1 of the Traffic Rules:</strong><br>\r\n  "Passengers must wear seat belts while in a moving vehicle equipped with them."</p>\r\n</blockquote>\r\n\r\n<h2>Administrative liability</h2>\r\n\r\n<p>According to <strong>Article 121 of the Code of Administrative Offenses of Ukraine (CAO)</strong>, failure to use seat belts results in a fine:</p>\r\n\r\n<blockquote>\r\n  <p>"Driving a vehicle without wearing a seat belt... shall result in a fine of <strong>510 UAH</strong>."</p>\r\n</blockquote>\r\n\r\n<p>Repeated violations may lead to temporary license suspension, especially when combined with other serious traffic offenses.</p>\r\n\r\n<h2>Who is exempt from using seat belts?</h2>\r\n\r\n<p>According to the traffic rules, some categories of individuals are exempt from the mandatory use of seat belts:</p>\r\n<ul>\r\n  <li>drivers and passengers of emergency vehicles while on duty;</li>\r\n  <li>driving instructors during training sessions;</li>\r\n  <li>drivers and passengers of vehicles not equipped with seat belts (e.g., old buses).</li>\r\n</ul>\r\n\r\n<h2>Seat belts and children</h2>\r\n\r\n<p>Special attention should be given to transporting children. Traffic rules require drivers to ensure safe transportation of children using child safety seats or belt adapters.</p>\r\n\r\n<blockquote>\r\n  <p><strong>Clause 21.11 of the Traffic Rules:</strong><br>\r\n  "It is prohibited to transport children under the height of 145 cm or under the age of 12 without using special child restraints..."</p>\r\n</blockquote>\r\n\r\n<p>Regular seat belts may injure a child or fail to protect them in a crash. Child safety seats are a necessity, not a luxury.</p>\r\n\r\n<h2>Common myths vs. reality</h2>\r\n\r\n<h3>Myth 1: "I’m a good driver, accidents won’t happen to me"</h3>\r\n<p><strong>Fact:</strong> Over 60% of accidents involve victims who were not at fault. You can be careful, but you cannot control the actions of others on the road.</p>\r\n\r\n<h3>Myth 2: "It’s better to jump out of the car during a crash"</h3>\r\n<p><strong>Fact:</strong> A person ejected from a vehicle is 5 times more likely to die. A belted passenger stays inside, increasing the chance of survival.</p>\r\n\r\n<h3>Myth 3: "There’s no need to buckle up in the back seat"</h3>\r\n<p><strong>Fact:</strong> Unbelted rear passengers can injure themselves and others during a collision, including the driver and front passengers.</p>\r\n\r\n<h2>The psychological aspect</h2>\r\n\r\n<p>Many people avoid using seat belts out of carelessness, habit, or fear of looking "uncool" in front of others. This is an example of cognitive dissonance—when people are aware of the danger but ignore it due to habit or social pressure.</p>\r\n\r\n<p>That’s why public education is essential—starting with teaching children to buckle up and setting a good personal example.</p>\r\n\r\n<h2>Conclusion</h2>\r\n\r\n<p>Seat belts are more than just a vehicle feature. They are a vital line of defense that can save lives. Using them is mandatory under Ukrainian law, and ignoring this rule carries not only legal penalties but also real danger to life.</p>\r\n\r\n<p><strong>Be a responsible driver and passenger — always buckle up, at any speed, in any seat.</strong></p>\r\n	Using seat belts is critically important.
the-importance-of-seat-belts-when-driving-a-car	uk	Важливість ременів безпеки при керуванні автомобілем	<p data-start="248" data-end="653">Ремені безпеки — один із найпростіших, але водночас найефективніших засобів захисту водія та пасажирів у разі дорожньо-транспортної пригоди. Вони рятують життя, зменшують ризик травмування та є обов’язковими до використання згідно з законодавством України. Попри очевидну важливість, досі значна частина водіїв і пасажирів нехтують цим правилом, сприймаючи ремені лише як "формальність" або "незручність".</p>\r\n<p data-start="655" data-end="870">У цьому матеріалі розглянемо, чому використання ременів безпеки є критично важливим, що говорять з цього приводу Правила дорожнього руху України, які наслідки чекають на порушників, а також спростуємо поширені міфи.</p><h2 data-start="655" data-end="870" class=""><span style="font-weight: normal;">Що таке ремінь безпеки і як він працює?</span></h2><p data-start="925" data-end="1180">Ремінь безпеки — це пристрій пасивної безпеки, призначений для утримання людини на місці під час зіткнення або різкого гальмування. Його основна функція — не допустити викидання людини з сидіння, що може стати фатальним навіть при швидкості 30–50 км/год.</p>\r\n<p data-start="1182" data-end="1419">Типовий триточковий ремінь безпеки утримує тіло в двох напрямках — уперед і вниз, розподіляючи сили удару по найбільш міцних ділянках тіла: ключицях, грудній клітці та тазі. Завдяки цьому ризик отримати серйозні травми знижується в рази.</p><h2 data-start="1182" data-end="1419" class=""><span style="font-weight: normal;">Статистика ДТП: ремінь безпеки рятує життя</span></h2><p data-start="1477" data-end="1573">Згідно з даними Всесвітньої організації охорони здоров’я, правильне використання ременя безпеки:</p><ul><li>знижує ризик загибелі водія та переднього пасажира на <strong data-start="1631" data-end="1641">45–50%</strong>;</li><li>зменшує ймовірність серйозних травм у задніх пасажирів на <strong data-start="1703" data-end="1713">25–75%</strong>;</li><li>у 2–3 рази зменшує шанс бути викинутим із транспортного засобу.</li></ul><p data-start="1477" data-end="1573">В Україні щороку трапляються десятки тисяч ДТП, в яких гинуть і травмуються тисячі людей. За даними Патрульної поліції, значна частина загиблих не користувалися ременями безпеки.</p><h2 data-start="1182" data-end="1419" class=""><span style="font-weight: normal;">Нормативна база: що говорять Правила дорожнього руху України</span></h2><p></p>\r\n<p>Використання ременів безпеки регламентується <strong>Правилами дорожнього руху України</strong>, зокрема <strong>розділом 2 «Обов’язки і права водіїв механічних транспортних засобів»</strong>.</p>\r\n\r\n<blockquote>\r\n  <p><strong>Пункт 2.3. ПДР України:</strong><br>\r\n  "Водій зобов'язаний:... ї) під час руху бути пристебнутим засобом безпеки (за наявності) і не перевозити пасажирів, не пристебнутих засобами безпеки."</p>\r\n</blockquote>\r\n\r\n<p>Цей пункт зобов'язує водія не лише самому використовувати ремінь, а й контролювати, щоб усі пасажири в салоні теж були пристебнуті.</p>\r\n\r\n<blockquote>\r\n  <p><strong>Пункт 5.1. ПДР України:</strong><br>\r\n  "Пасажири зобов’язані користуватися ременями безпеки під час руху транспортного засобу, обладнаного такими засобами."</p>\r\n</blockquote>\r\n\r\n<h2><span style="font-weight: normal;">Адміністративна відповідальність</span></h2>\r\n\r\n<p>Відповідно до <strong>статті 121 Кодексу України про адміністративні правопорушення (КУпАП)</strong>, за порушення правил користування ременями безпеки передбачено штраф:</p>\r\n\r\n<blockquote>\r\n  <p>"Керування водієм транспортним засобом, не пристебнутим ременем безпеки... — тягне за собою накладення штрафу в розмірі <strong>510 гривень</strong>."</p>\r\n</blockquote>\r\n\r\n<p>Крім того, за систематичні порушення можливе тимчасове вилучення прав, особливо якщо це поєднується з іншими грубими порушеннями правил.</p>\r\n\r\n<h2><span style="font-weight: normal;">Хто звільняється від обов’язку користуватися ременем?</span></h2>\r\n\r\n<p>Згідно з ПДР, окремі категорії осіб можуть бути звільнені від обов’язкового використання ременів. Це:</p>\r\n<ul>\r\n  <li>водії і пасажири оперативних транспортних засобів під час виконання службових обов'язків;</li>\r\n  <li>інструктори під час навчальної їзди;</li>\r\n  <li>водії і пасажири транспортних засобів, обладнаних сидіннями без ременів (наприклад, старі автобуси).</li>\r\n</ul>\r\n\r\n<h2><span style="font-weight: normal;">Ремінь безпеки та діти</span></h2>\r\n\r\n<p>Особливу увагу варто приділити перевезенню дітей. ПДР зобов’язують водіїв забезпечувати безпечне перевезення дітей за допомогою спеціальних автокрісел або адаптерів ременя.</p>\r\n\r\n<blockquote>\r\n  <p><strong>Пункт 21.11 ПДР України:</strong><br>\r\n  "Забороняється перевозити дітей, зріст яких менше 145 см або вік менше 12 років, без використання спеціальних засобів..."</p>\r\n</blockquote>\r\n\r\n<p>Під час зіткнення звичайний ремінь безпеки може травмувати дитину або взагалі не спрацювати. Тому дитячі автокрісла — не опція, а необхідність.</p>\r\n\r\n<h2><span style="font-weight: normal;">Поширені міфи та реальність</span></h2>\r\n\r\n<h3>Міф 1: «Я добре воджу, аварій не буде»</h3>\r\n<p><strong>Факт:</strong> Понад 60% ДТП відбуваються не з вини того, хто постраждав. Ви можете бути обережним, але не здатні передбачити дії інших водіїв.</p>\r\n\r\n<h3>Міф 2: «При аварії краще вистрибнути»</h3>\r\n<p><strong>Факт:</strong> Людина, яку викидає з машини, має у 5 разів більшу ймовірність загинути. Пристебнутий пасажир залишається в салоні, де більше шансів вижити.</p>\r\n\r\n<h3>Міф 3: «На задньому сидінні не обов’язково пристібатися»</h3>\r\n<p><strong>Факт:</strong> Пасажири на задніх сидіннях, які не пристебнуті, під час аварії можуть травмувати не лише себе, а й водія або переднього пасажира.</p>\r\n\r\n<h2><span style="font-weight: normal;">Психологічний аспект</span></h2>\r\n\r\n<p>Багато людей уникають користування ременями через побутову недбалість, небажання витрачати час або навіть страх виглядати "смішно" в очах інших. Така поведінка — приклад когнітивного дисонансу, коли люди знають про небезпеку, але ігнорують її через звичку або соціальний тиск.</p>\r\n\r\n<p>Саме тому важливо вести інформаційну кампанію, вчити дітей з дитинства пристібатися та демонструвати особистий приклад.</p>\r\n\r\n<h2><span style="font-weight: normal;">Висновки</span></h2>\r\n\r\n<p>Ремінь безпеки — не просто елемент оснащення автомобіля. Це ваша гарантія життя і здоров’я. Його використання є обов’язковим відповідно до Правил дорожнього руху України, і нехтування цим правилом тягне не лише адміністративну відповідальність, а й реальну небезпеку для життя.</p>\r\n\r\n<p><strong>Будьте відповідальними водіями і пасажирами — пристібайтеся завжди, на будь-якій швидкості та на будь-якому сидінні.</strong></p>	Використання ременів безпеки є критично важливим для життя.
entering-a-road-with-a-lane-for-route-vehicles	en	Enter a lane designated for public transport vehicles, for the purpose of dropping off a passenger	<p>This article examines a decision by the Supreme Court regarding whether a driver may stop in a public transport lane.<br><br><a href="https://reyestr.court.gov.ua/Review/89793144" target="_blank">Resolution of the Supreme Court of Ukraine in case No. 201/2179/17 (2-a/201/98/2017) administrative proceedings No. K/9901/21595/18</a><br></p><h2 class="">Case Summary</h2><p>On January 31, 2017, police officers issued a resolution against the plaintiff for an administrative offense, holding him liable under Part 3 of Article 122 of the Code of Ukraine on Administrative Offenses and imposing a fine of 510 UAH.<br><br>In February 2017, the plaintiff filed a lawsuit, arguing that the police resolution was unlawful. While his vehicle did stop at the location indicated in the contested resolution, he claims that his driving was proper and did not violate any rules regarding speed or parking. He also stated that the resolution was issued without considering his remarks, explanations, or the specific traffic situation.<br><br>On June 6, 2017, the Zhovtnevyi District Court of Dnipro upheld the plaintiff’s claims.<br><br>On July 20, 2017, the Dnipropetrovsk Administrative Court of Appeal overturned the lower court’s decision and issued a new ruling denying the plaintiff’s claims.<br><br>The plaintiff then appealed to the Supreme Court, requesting the cancellation of the appellate court's decision. He stated that he had entered and stopped on a road with a designated public transport lane separated by a broken line marking, solely for the purpose of dropping off a passenger — which is allowed by the Traffic Rules of Ukraine. Therefore, he believed there was no legal basis for the administrative offense in this case.<br><br>On June 12, 2020, the Supreme Court reviewed the cassation complaint and issued its ruling.<br></p><h2 class="">Supreme Court Conclusion</h2><ul><li>Taking into account paragraph 17.2 of the Traffic Rules of Ukraine, a driver is permitted to enter a public transport lane separated by a broken line marking to drop off a passenger.</li><li>The case materials confirm that the plaintiff was in fact dropping off a passenger in the designated lane.</li><li>The resolution of the appellate administrative court is annulled, and the decision of the first-instance court is upheld.</li></ul>	A driver is allowed to enter a lane designated for public transport vehicles, separated by a broken line marking, for the purpose of dropping off a passenger. The fact of the passenger drop-off must be proven by the case materials.
entering-a-road-with-a-lane-for-route-vehicles	uk	Заїзд на смугу для маршрутних транспортних засобів, з метою висадки пасажира	<p>В статті розглядаємо рішення Верховного суду щодо можливості зупинки водія у смузі для маршрутних транспортних засобів.&nbsp;</p><p><a href="https://reyestr.court.gov.ua/Review/89793144" target="_blank">Постанова Верховного Суду України по справі №201/2179/17(2-а/201/98/2017) адміністративне провадження №К/9901/21595/18.</a></p><h2 class="">Суть справи</h2><p><br>31 січня 2017 року працівниками поліції на позивача була винесена постанова про адміністративне правопорушення про притягнення до адміністративної відповідальності за частиною третьою статті 122 Кодексу України про адміністративне правопорушення і накладення штрафу в розмірі 510 грн.<br><br>У лютому 2017 року позивач звернувся до суду з позовом, в якому вважає постанову працівників поліції незаконною, оскільки хоча його автомобіль і зупинявся у місці, зазначеному в оскаржуваній постанові, але рухався він правильно, без порушення правил про швидкість і паркування, а постанова складалася відповідачем без врахування його зауважень, пояснень та конкретної дорожньої обстановки.<br></p><p>06 червня 2017 року постановою Жовтневого районного суду м. Дніпропетровська позовні вимоги були задоволені.<br><br>20 липня 2017 року Дніпропетровський апеляційного адміністративного суду скасував рішення суду першої інстанції та прийняв нове рішення про відмову у задоволенні позовних вимог.<br><br>Позивач звернувся до Верховного суду для скасування рішення суду апеляційної інстанції. При цьому позивач вказав, що на дорозі із смугою для маршрутних транспортних засобів, яка відокремлена переривчастою лінією дорожньої розмітки, він заїхав та зупинився біля правого краю проїзної частини, але&nbsp; виключно з метою висадки пасажира, що дозволено Правилами дорожнього руху України. А тому, на його думку, склад адміністративного правопорушення у випадку, що розглядається судом, відсутній.</p><p><span style="background-tag1:#FFFFFF;tag2:Roboto Condensed Light;tag3:14pt;">12 червня 2020 року</span>&nbsp;Верховним судом була розглянута&nbsp;<span align="justify" style="background-tag1:#FFFFFF;tag2:Roboto Condensed Light;tag3:14pt;">касаційна скарга та винесено рішення.</span></p><h2 class="">Висновок Верховного суду</h2><p><br>1. Враховуючи положення пункту 17.2. ПДР України, водій має право, зокрема, заїжджати на дорогу зі смугою для маршрутних транспортних засобів, яка відокремлена переривчастою лінією дорожньої розмітки, для висадки пасажира.<br>2. З матеріалів справи вбачається, що позивач здійснив саме висадку пасажира на вказаній смузі.<br>3. Скасування постанови апеляційного адміністративного суду та залишення в силі постанову суду першої інстанції.</p>	Водієві дозволено, заїжджати на смугу для маршрутних транспортних засобів, відокремлену переривчастою лінією розмітки, з метою висадки пасажира. Факт висадки має буде доведено матеріалами справи.
plaintiff's-failure-to-appear-in-court	en	Plaintiff's failure to appear in court	<div>\r\n  <h1>Analysis of Court Absence Provisions</h1>\r\n\r\n  <p>The Supreme Court noted that according to Part 1 of Article 205 of the Code of Administrative Justice of Ukraine, the absence of any case participant from a court hearing - when properly notified about its time and location - doesn't prevent case consideration, except in circumstances defined by this article.</p>\r\n\r\n  <h2>Consequences of Absence</h2>\r\n  <p>Part 5 establishes that if a plaintiff fails to appear without valid reasons or doesn't explain their absence (and hasn't submitted a request for consideration in absentia), the court may dismiss the claim unless the defendant insists on proceeding with the case based on available evidence. For non-governmental plaintiffs, these provisions only apply after repeated absences.</p>\r\n\r\n  <h2>Procedural Alignment</h2>\r\n  <p>This norm correlates with Article 240(1)(4) of the Code, which similarly permits claim dismissal when a plaintiff (or repeatedly for non-governmental plaintiffs) misses preparatory or main hearings without justification or notice, unless they've requested in-absentia consideration.</p>\r\n\r\n  <h2>Key Legal Principles</h2>\r\n  <ul>\r\n    <li>Claim dismissal requires repeated unexplained absences by non-governmental plaintiffs</li>\r\n    <li>Defendant's insistence on proceeding overrides automatic dismissal</li>\r\n    <li>These rules implement constitutional access-to-justice guarantees</li>\r\n    <li>They presume litigants will actively participate in proceedings</li>\r\n  </ul>\r\n\r\n  <p>Article 205(5) effectively creates a form of procedural accountability for plaintiffs who fail to attend hearings without proper justification, allowing courts to return claims unconsidered as a consequence of such non-participation.</p><p><a href="https://5aa.court.gov.ua/sud4854/pres-centr/news/1702390/" target="_blank">Supreme Court Resolution</a></p></div>	Explanation by the court about the consequences of the plaintiff's failure to appear in court.
plaintiff's-failure-to-appear-in-court	uk	Неявка до суду позивача	<div>\r\n  <h1>Аналіз положень про неявку до суду</h1>\r\n\r\n  <p>Верховний Суд зазначив, що згідно з частиною 1 статті 205 КАС України, неявка будь-якого учасника справи на судове засідання - за умови належного повідомлення про час і місце проведення - не перешкоджає розгляду справи, крім випадків, передбачених цією статтею.</p>\r\n\r\n  <h2>Наслідки неявки</h2>\r\n  <p>Частина 5 встановлює, що у разі неявки позивача без поважних причин або неповідомлення про причини відсутності (і за відсутності заяви про розгляд у його відсутність), суд може залишити позов без розгляду, якщо відповідач не наполягає на продовженні розгляду на підставі наявних доказів. Для позивачів, які не є суб'єктами владних повноважень, ці положення застосовуються лише після повторної неявки.</p>\r\n\r\n  <h2>Процесуальна узгодженість</h2>\r\n  <p>Ця норма корелює зі статтею 240(1)(4) КАС, яка аналогічно дозволяє залишати позов без розгляду, коли позивач (або повторно для недержавних позивачів) відсутній на підготовчих чи основних засіданнях без обґрунтування, якщо не надійшла заява про розгляд у відсутності.</p>\r\n\r\n  <h2>Ключові правові принципи</h2>\r\n  <ul>\r\n    <li>Залишення позову без розгляду вимагає повторної необґрунтованої неявки недержавних позивачів</li>\r\n    <li>Наполягання відповідача на розгляді скасовує автоматичне залишення без розгляду</li>\r\n    <li>Ці норми реалізують конституційні гарантії доступу до правосуддя</li>\r\n    <li>Вони передбачають активну участь сторін у процесі</li>\r\n  </ul>\r\n\r\n  <p>Стаття 205(5) КАС фактично встановлює форму процесуальної відповідальності для позивачів, які не з'являються на засідання без поважних причин, дозволяючи судам повертати позовні заяви без розгляду як наслідок такої неучасті.</p><p><a href="https://5aa.court.gov.ua/sud4854/pres-centr/news/1702390/" target="_blank">Постанова ВС</a></p></div>	Роз'яснення суду про наслідки неявки до суду позивача.
traffic-rules	en	Traffic rules of Ukraine: a complete overview of the regulatory framework	<h2>1. General Information About the Document</h2>\r\n\r\n<p>The main regulatory act governing road traffic in Ukraine is <b>Resolution of the Cabinet of Ministers of Ukraine No. 1306</b> dated October 10, 2001 "On Traffic Rules". This document was adopted by the Cabinet of Ministers of Ukraine in accordance with the requirements of the Law of Ukraine "On Road Traffic" and came into force on January 1, 2002.</p>\r\n\r\n<p>Traffic Rules are mandatory for all road users in Ukraine, including drivers of vehicles, pedestrians, cyclists and passengers.</p>\r\n<p><a href="https://zakon.rada.gov.ua/laws/show/1306-2001-%D0%BF#n16" target="_blank">Link to the document</a></p>\r\n\r\n<h2>2. Document Structure</h2>\r\n\r\n<p>The full text of Traffic Rules contains 33 sections that regulate all aspects of road traffic in detail:</p>\r\n\r\n<ul>\r\n<li>Sections 1-3: General provisions, terminology, obligations of road users</li>\r\n<li>Sections 4-12: Rules for drivers (speed limits, maneuvering, stopping and parking)</li>\r\n<li>Sections 13-15: Requirements for pedestrians, cyclists and animal-drawn vehicles</li>\r\n<li>Sections 16-22: Road signs, traffic lights and road markings</li>\r\n<li>Sections 23-28: Special provisions for cargo transportation, passengers and special vehicles</li>\r\n<li>Sections 29-33: Technical requirements for vehicles, appendices</li>\r\n</ul>\r\n\r\n<h2>3. Key Provisions of Traffic Rules</h2>\r\n\r\n<h3>3.1. Drivers' Obligations</h3>\r\n\r\n<p>The document specifies in detail:</p>\r\n<ul>\r\n<li>Permissible speed limits in various conditions</li>\r\n<li>Overtaking and passing rules</li>\r\n<li>Intersection passing procedures</li>\r\n<li>Stopping and parking requirements</li>\r\n<li>Rules for using lighting devices</li>\r\n<li>Obligations in case of traffic accidents</li>\r\n</ul>\r\n\r\n<h3>3.2. Requirements for Pedestrians</h3>\r\n\r\n<p>Traffic Rules establish clear rules for pedestrians:</p>\r\n<ul>\r\n<li>Designated crossing points</li>\r\n<li>Rules for nighttime road behavior</li>\r\n<li>Restrictions on roadway movement</li>\r\n<li>Interaction rules with vehicles</li>\r\n</ul>\r\n\r\n<h2>4. Recent Changes and Current Amendments</h2>\r\n\r\n<p>Since its adoption, the document has undergone numerous changes. The most significant amendments were made by:</p>\r\n\r\n<ul>\r\n<li><b>CMU Resolution No. 663 of 2023</b>:\r\n  <ul>\r\n  <li>Clarified requirements for retroreflective elements</li>\r\n  <li>Introduced new child transportation rules</li>\r\n  <li>Updated regulations on low beam headlights usage</li>\r\n  </ul>\r\n</li>\r\n<li><b>CMU Resolution No. 111 of 2022</b>:\r\n  <ul>\r\n  <li>Changed rules for uncontrolled intersections</li>\r\n  <li>Introduced new requirements for dangerous goods transportation</li>\r\n  </ul>\r\n</li>\r\n</ul>\r\n\r\n<h2>5. Liability for Violations</h2>\r\n\r\n<p>According to Article 121 of the Code of Ukraine on Administrative Offenses, violation of Traffic Rules entails:</p>\r\n\r\n<ul>\r\n<li>Administrative liability (fines)</li>\r\n<li>Driver's license suspension</li>\r\n<li>Vehicle impoundment in cases provided by law</li>\r\n<li>Civil or criminal liability for traffic accident consequences</li>\r\n</ul>\r\n\r\n<p>Fines for traffic violations are established by separate regulatory acts and are constantly adjusted considering inflation and legislative changes.</p>\r\n	One of the main regulatory legal acts that regulate relations in the field of road traffic. It is the basis for passing exams to obtain a driver's license.
traffic-rules	uk	Правила дорожнього руху України: повний огляд нормативно-правової бази	<h2>1. Загальні відомості про документ</h2>\r\n\r\n<p>Основним нормативним актом, що регулює дорожній рух в Україні, є <b>Постанова Кабінету Міністрів України № 1306</b> від 10 жовтня 2001 року "Про Правила дорожнього руху". Цей документ був прийнятий Кабінетом Міністрів України на виконання вимог Закону України "Про дорожній рух" та набрав чинності з 1 січня 2002 року.</p>\r\n\r\n<p>Правила дорожнього руху є обов'язковими для виконання всіма учасниками дорожнього руху на території України, включаючи водіїв транспортних засобів, пішоходів, велосипедистів та пасажирів.</p><p><a href="https://zakon.rada.gov.ua/laws/show/1306-2001-%D0%BF#n16" target="_blank">Посилання на документ</a></p>\r\n\r\n<h2>2. Структура документа</h2>\r\n\r\n<p>Повний текст ПДР містить 33 розділи, які детально регламентують усі аспекти дорожнього руху:</p>\r\n\r\n<ul>\r\n<li>Розділи 1-3: Загальні положення, термінологія, обов'язки учасників руху</li>\r\n<li>Розділи 4-12: Правила для водіїв (швидкісний режим, маневрування, зупинка та стоянка)</li>\r\n<li>Розділи 13-15: Вимоги до пішоходів, велосипедистів та возників</li>\r\n<li>Розділи 16-22: Дорожні знаки, світлофори та дорожня розмітка</li>\r\n<li>Розділи 23-28: Особливості перевезення вантажів, пасажирів та спецтранспорту</li>\r\n<li>Розділи 29-33: Технічні вимоги до транспортних засобів, додатки</li>\r\n</ul>\r\n\r\n<h2>3. Ключові положення ПДР</h2>\r\n\r\n<h3>3.1. Обов'язки водіїв</h3>\r\n\r\n<p>Документ детально прописує:</p>\r\n<ul>\r\n<li>Види допустимої швидкості в різних умовах</li>\r\n<li>Правила обгону та випередження</li>\r\n<li>Порядок проїзду перехресть</li>\r\n<li>Вимоги до зупинки та стоянки</li>\r\n<li>Правила користування світловими приладами</li>\r\n<li>Обов'язки при ДТП</li>\r\n</ul>\r\n\r\n<h3>3.2. Вимоги до пішоходів</h3>\r\n\r\n<p>ПДР встановлюють чіткі правила для пішоходів:</p>\r\n<ul>\r\n<li>Місця переходу проїзної частини</li>\r\n<li>Правила поведінки на дорозі в темну пору доби</li>\r\n<li>Обмеження для руху по проїзній частині</li>\r\n<li>Правила взаємодії з транспортними засобами</li>\r\n</ul>\r\n\r\n<h2>4. Останні зміни та актуальні новели</h2>\r\n\r\n<p>З моменту прийняття документ зазнав численних змін. Найбільш суттєві корективи були внесені:</p>\r\n\r\n<ul>\r\n<li><b>Постановою КМУ № 663 від 2023 року</b>:\r\n  <ul>\r\n  <li>Уточнено вимоги до світлоповертаючих елементів</li>\r\n  <li>Введено нові правила перевезення дітей</li>\r\n  <li>Оновлено норми щодо використання ближнього світла фар</li>\r\n  </ul>\r\n</li>\r\n<li><b>Постановою КМУ № 111 від 2022 року</b>:\r\n  <ul>\r\n  <li>Змінено правила проїзду нерегульованих перехресть</li>\r\n  <li>Введено нові вимоги до перевезення небезпечних вантажів</li>\r\n  </ul>\r\n</li>\r\n</ul>\r\n\r\n<h2>5. Відповідальність за порушення</h2>\r\n\r\n<p>Відповідно до статті 121 Кодексу України про адміністративні правопорушення, порушення Правил дорожнього руху тягне за собою:</p>\r\n\r\n<ul>\r\n<li>Адміністративну відповідальність (штрафи)</li>\r\n<li>Позбавлення права керування транспортними засобами</li>\r\n<li>Арешту транспортного засобу у випадках, передбачених законом</li>\r\n<li>Цивільну або кримінальну відповідальність за наслідки ДТП</li>\r\n</ul>\r\n\r\n<p>Розміри штрафів за порушення ПДР встановлюються окремими нормативними актами та постійно коректуються з урахуванням інфляції та змін у законодавстві.</p>	Один з основних нормативно-правових актів, які регулюють відносини у сфері дорожнього руху. Є базою для здачі іспитів на отримання посвідчення водія.
grounds-for-stopping-a-vehicle-by-police-officers	en	Grounds for stopping a vehicle by police officers in Ukraine	  <h2>Legal Framework:</h2>\r\n  <p>\r\n    The issue of stopping vehicles is regulated by the following legal acts:\r\n  </p>\r\n  <ul>\r\n    <li><strong>Law of Ukraine "On the National Police"</strong> (Article 35),</li>\r\n    <li><strong>Traffic Rules of Ukraine</strong> (approved by Resolution of the Cabinet of Ministers No. 1306 dated October 10, 2001),</li>\r\n    <li><strong>Code of Ukraine on Administrative Offenses</strong>,</li>\r\n    <li><strong>Law of Ukraine "On Road Traffic"</strong>.</li>\r\n  </ul>\r\n  <p>\r\n    These documents define the list of legal grounds, the procedure for police officers' actions, and the rights of drivers during a traffic stop.\r\n  </p>\r\n\r\n  <h2>Grounds for Stopping a Vehicle:</h2>\r\n\r\n  <ol>\r\n    <li>\r\n      <strong>Violation of traffic rules by the driver.</strong><br>\r\n      If a police officer detects or has reasonable suspicion that the driver has violated traffic rules—such as speeding, running a red light, or malfunctioning lights—he or she has the right to stop the vehicle.\r\n    </li>\r\n    <li>\r\n      <strong>Obvious signs of a vehicle's technical malfunction.</strong><br>\r\n      A vehicle with visible damage or faults that could pose a threat to traffic safety (e.g., broken headlights, faulty brakes) may be stopped.\r\n    </li>\r\n    <li>\r\n      <strong>The need to interview the driver or passengers as witnesses.</strong><br>\r\n      A vehicle can be stopped if its occupants may have witnessed a traffic accident or other violation.\r\n    </li>\r\n    <li>\r\n      <strong>The need to involve the driver in providing assistance to other road users or the police.</strong><br>\r\n      This could include evacuating victims or pursuing a suspect.\r\n    </li>\r\n    <li>\r\n      <strong>Information about the vehicle’s or driver's involvement in a violation.</strong><br>\r\n      If the car is wanted or suspected to be involved in a crime, it may be stopped.\r\n    </li>\r\n    <li>\r\n      <strong>Document checks in areas with special traffic conditions.</strong><br>\r\n      This includes checkpoints, areas near government buildings, or zones under curfew or anti-terrorist operations.\r\n    </li>\r\n    <li>\r\n      <strong>Control over the transportation of dangerous, oversized, or overweight cargo.</strong><br>\r\n      A police officer may stop a vehicle suspected of violating these specific rules for further inspection.\r\n    </li>\r\n    <li>\r\n      <strong>Conducting special operations or alert plans.</strong><br>\r\n      During law enforcement operations (e.g., "Siren", "Filter"), all vehicles in a given area may be subject to stops.\r\n    </li>\r\n    <li>\r\n      <strong>Presence of external signs indicating potential criminal involvement.</strong><br>\r\n      This includes visible blood, damage to the vehicle, or aggressive behavior from occupants.\r\n    </li>\r\n    <li>\r\n      <strong>Weight or environmental inspections.</strong><br>\r\n      This applies particularly to freight or commercial passenger transport and may involve checking for environmental compliance.\r\n    </li>\r\n  </ol>\r\n\r\n  <h2>Additional Requirements for a Stop:</h2>\r\n  <p>\r\n    According to traffic rules and the law, a stop must be performed <strong>with the use of special signals</strong>, the police officer must present a <strong>service ID</strong>, and must <strong>clearly state the reason for the stop</strong>.\r\n    The driver has the right to request an explanation and record the officer’s actions using a video device.\r\n  </p>\r\n  <p>\r\n    An unlawful stop may be considered an <strong>abuse of authority</strong>, which carries legal consequences for the police officer involved.\r\n  </p>	Stopping a vehicle by police officers in Ukraine - regulatory legal acts, grounds.
grounds-for-stopping-a-vehicle-by-police-officers	uk	Підстави для зупинки транспортного засобу працівниками поліції в Україні	<h2 class="">Законодавче регулювання</h2><p>Питання зупинки транспортних засобів регулюється такими нормативно-правовими актами:<br></p><ul><li>Закон України «Про Національну поліцію» (стаття 35),</li><li>Правила дорожнього руху України (затверджені постановою Кабінету Міністрів України №1306 від 10.10.2001),</li><li>Кодекс України про адміністративні правопорушення,</li><li>Закон України «Про дорожній рух».<br></li></ul><p>Ці документи встановлюють перелік законних підстав, порядок дій поліцейських та права водія при зупинці транспортного засобу.<br><br></p><h2 class="">Підстави для зупинки транспортного засобу</h2><p><br>Згідно зі статтею 35 Закону України «Про Національну поліцію», поліцейський має право зупинити транспортний засіб лише у випадках, прямо передбачених законом. Основні підстави:<br><br></p><h3 class="">Порушення правил дорожнього руху водієм.</h3><p>Якщо поліцейський виявив або має обґрунтовану підозру, що водій порушив ПДР, наприклад, перевищення швидкості, проїзд на червоне світло чи несправність зовнішніх світлових приладів, він має право зупинити транспортний засіб.<br><br></p><h3 class="">Очевидні ознаки технічної несправності транспортного засобу.</h3><p><br>Якщо автомобіль має пошкодження чи поломки, які можуть становити загрозу безпеці дорожнього руху (наприклад, відсутність фари, несправне гальмування), це є підставою для зупинки.<br><br></p><h3 class="">Необхідність опитування водія чи пасажирів як свідків події.</h3><p>Поліцейський може зупинити авто, якщо є потреба встановити свідків дорожньо-транспортної пригоди або іншого правопорушення.<br><br></p><h3 class="">Необхідність залучення водія до надання допомоги іншим учасникам руху чи поліції.</h3><p>Наприклад, коли потрібна евакуація постраждалих або переслідування правопорушника.<br><br></p><h3 class="">Наявність інформації про причетність транспортного засобу або його водія до правопорушення.</h3><p>Якщо автомобіль перебуває в розшуку, за орієнтуванням або є підозра щодо участі у злочині — поліцейський має право його зупинити.<br><br></p><h3 class="">Перевірка документів у зонах особливого режиму руху.</h3><p>Наприклад, у контрольних пунктах, біля держустанов, у зонах проведення антитерористичної операції чи комендантської години.<br><br></p><h3 class="">Контроль за дотриманням режиму перевезень небезпечних, великогабаритних або великовагових вантажів.</h3><p>У разі підозри на порушення таких правил з боку водія, транспортний засіб може бути зупинений для перевірки документів і технічного стану.<br><br></p><h3 class="">Проведення спеціальних операцій або планів перехоплення.</h3><p>У разі оголошення плану типу «Сирена», «Фільтр» тощо, поліцейські можуть зупиняти всі транспортні засоби на визначеній території.<br><br></p><h3 class="">Наявність зовнішніх ознак, що свідчать про можливу участь у кримінальному правопорушенні.</h3><p>Наприклад, сліди крові, пошкодження автомобіля, агресивна поведінка водія чи пасажирів.<br><br></p><h3 class="">Здійснення габаритно-вагового контролю або перевірка дотримання екологічних норм.</h3><p>Це може стосуватися, зокрема, вантажного транспорту або комерційного перевезення пасажирів.<br><br></p><h2 class="">Додаткові вимоги до зупинки</h2><p><br>Згідно з ПДР та положеннями законодавства, зупинка повинна проводитися із застосуванням спеціальних сигналів, наявністю службового посвідчення, а також обґрунтованим поясненням причини зупинки. Водій має право вимагати пояснення підстав і фіксувати дії поліцейського за допомогою відеозапису.<br><br>Незаконна зупинка транспортного засобу може розглядатися як перевищення повноважень, що тягне за собою юридичну відповідальність з боку посадової особи.</p>	Зупинка транспортного засобу працівниками поліції в Україні - нормативно правові акти, підстави.
zakon-pro-dorojniy-ruh-ukraini	en	The Law on Road Traffic of Ukraine	<p><p data-start="172" data-end="559"><a href="https://zakon.rada.gov.ua/laws/show/3353-12#Text" target="_blank">Official link on the website of the Verkhovna Rada of Ukraine</a><br></p>Document 3353-XII, current.<br><br>The Law of Ukraine "On Road Traffic" is a fundamental legal act that regulates the relationships between road users, defines their rights and obligations, and establishes the principles for organizing road traffic in Ukraine. It serves as the foundation for ensuring road safety, preventing accidents, and fostering a culture of responsibility among drivers, pedestrians, and passengers.<br><br><h2 class="">Key Provisions of the Law</h2><br>The law was first adopted in 1993 and has since undergone numerous amendments and updates in response to infrastructure development, advancements in the transportation system, and emerging road safety challenges. The main areas regulated by the law include:<br></p><ul><li>behavior rules for road users (drivers, pedestrians, passengers);</li><li>traffic organization and management systems;</li><li>technical requirements for vehicles;</li><li>legal liability for traffic violations;</li><li>the role of the National Police in monitoring and enforcement.</li></ul><h2 class="">Road Users</h2><p>The law clearly states that all road users must be familiar with and comply with traffic rules, remain alert, and avoid endangering others. Drivers have specific responsibilities regarding vehicle condition, adherence to speed limits, yielding to pedestrians, and more. Pedestrians also have duties, such as crossing the road only at designated places.<br><br></p><h2 class="">Safety as a Core Priority</h2><p><br>One of the law’s primary objectives is to ensure road traffic safety. According to the legislation, the state must create conditions for safe movement: maintain roads, provide proper signage and markings, and enforce regulations.<br><br>The law also includes provisions to protect the life and health of all road users, such as mandatory use of seat belts, child safety seats, helmets for motorcyclists, and a strict ban on driving under the influence of alcohol or drugs.<br><br></p><h2 class="">Role of the Police and Legal Responsibility</h2><p><br>Enforcement of traffic regulations is the responsibility of the National Police of Ukraine. Officers are authorized to stop vehicles, check documents, conduct alcohol tests, and issue administrative violation reports.<br><br>Traffic rule violations may lead to administrative or, in some cases, criminal liability. The law defines penalties including fines, license suspension, arrest, and other disciplinary actions.<br><br></p><h2 class="">Relevance and Future of the Law</h2><p><br>In today’s context—characterized by a growing number of vehicles and increasing infrastructure demands—this law remains highly relevant. It requires continuous updates in line with European standards and technological advancements.<br><br>Current reforms focus on road safety enhancement, implementation of automated violation detection, and improvements in driver education, all of which are based on the provisions of this law.</p><h2 class="">Conclusion</h2><p>The Law of Ukraine "On Road Traffic" is a crucial tool for maintaining order and safety on the roads. Complying with its provisions is not only a legal duty but also a means of protecting life and health. The safety of our roads depends largely on the awareness and discipline of all traffic participants.</p>	The Law of Ukraine "On Road Traffic" is a fundamental legal act that regulates the relationships between road users.
zakon-pro-dorojniy-ruh-ukraini	uk	Закон України Про дорожній рух	<h2 class="">Закон про дорожній рух України: основи, принципи та значення для безпеки</h2><p><a href="https://zakon.rada.gov.ua/laws/show/3353-12#Text" target="_blank">Офіційне посилання на сайті ВРУ</a><br><br>Документ 3353-XII, чинний.<br></p><p>Закон України "Про дорожній рух" є базовим нормативно-правовим актом, який регулює відносини між учасниками дорожнього руху, визначає їхні права, обов’язки, а також принципи організації дорожнього руху в Україні. Він є основою для забезпечення безпеки на дорогах, запобігання аваріям та формування правової культури серед водіїв, пішоходів і пасажирів.<br><br></p><h2 class="">Основні положення Закону</h2><p><br>Закон був прийнятий ще в 1993 році, але з того часу багаторазово змінювався та доповнювався відповідно до змін в інфраструктурі, розвитку транспортної системи та нових викликів у сфері безпеки дорожнього руху. Основні питання, які регулює закон:<br></p><ul><li>правила поведінки учасників дорожнього руху (водії, пішоходи, пасажири);</li><li>організація дорожнього руху та система управління ним;</li><li>вимоги до транспортних засобів, їх технічного стану;</li><li>питання відповідальності за порушення правил дорожнього руху;</li><li>діяльність Національної поліції у сфері контролю та безпеки.</li></ul><h2 class="">Учасники дорожнього руху</h2><p><br>Закон чітко визначає, що всі учасники дорожнього руху зобов’язані знати та виконувати правила дорожнього руху, бути уважними та не створювати небезпеки для інших. Для водіїв передбачені окремі обов’язки щодо технічного стану авто, дотримання швидкісного режиму, надання переваги пішоходам тощо. Пішоходи також зобов’язані дотримуватися правил, зокрема переходити дорогу лише у встановлених місцях.<br><br></p><h2 class="">Безпека як головний пріоритет</h2><p><br>Одна з ключових цілей закону – це забезпечення безпеки дорожнього руху. Згідно із законодавством, держава зобов’язана створювати умови для безпечного пересування громадян: ремонтувати дороги, встановлювати відповідну розмітку, забезпечувати контроль за водіями.<br><br>Також закон містить положення про захист життя та здоров’я всіх учасників руху, зокрема через обов’язкове використання пасків безпеки, дитячих крісел, мотошоломів, а також заборону керування у стані сп’яніння.<br><br></p><h2 class="">Роль поліції та відповідальність</h2><p><br>Контроль за дотриманням правил покладено на Національну поліцію України. Інспектори мають право зупиняти транспортні засоби, перевіряти документи, проводити тестування на алкоголь, а також складати протоколи про адміністративні правопорушення.<br><br>Порушення правил дорожнього руху тягне за собою адміністративну, а в окремих випадках – кримінальну відповідальність. Закон визначає систему штрафів, позбавлення прав, арешту та інші заходи впливу.<br><br></p><h2 class="">Актуальність та майбутнє закону</h2><p><br>У сучасних умовах, коли зростає кількість автомобілів і навантаження на інфраструктуру, закон залишається надзвичайно важливим. Він потребує постійного оновлення відповідно до європейських стандартів і технологічного розвитку.<br><br>Реформа у сфері дорожньої безпеки, впровадження відеофіксації порушень, удосконалення системи навчання водіїв – усе це реалізується на базі норм цього закону.<br><br></p><h2 class="">Висновок</h2><p><br>Закон України "Про дорожній рух" є ключовим інструментом забезпечення безпеки та порядку на дорогах. Дотримання його норм — не лише обов’язок, але й запорука збереження життя та здоров’я кожного з нас. Саме від правової свідомості та дисципліни учасників дорожнього руху залежить, наскільки безпечним буде пересування українськими дорогами.</p>	Закон України "Про дорожній рух" є базовим нормативно-правовим актом, який регулює відносини між учасниками дорожнього руху.
using-a-video-recorder	en	Using a Dashcam	<p>In today’s world of rapid vehicle growth and increasing road traffic accidents, more and more drivers are installing dashcams in their cars. This device, though seemingly simple, holds significant legal value. Using a dashcam while driving has become a powerful tool for protecting one’s violated rights, especially in situations where the fault is disputed.<br></p><h2 class="">Dashcam as Evidence in Court</h2><p>One of the main functions of a dashcam is to record real-time events on the road. In the case of an accident or a conflict with other road users, footage from a dashcam can be used as evidence in court or during police proceedings. The video helps establish the sequence of events, vehicle speeds, driver actions, and other important details that may influence the legal assessment of the situation.<br>Ukrainian court practice accepts dashcam footage as admissible evidence, provided it was obtained legally. This means the video must be unedited and authentic. In many cases, such recordings have helped drivers prove their innocence and avoid fines or administrative liability.<br></p><h2 class="">Protection Against Unlawful Actions by Police Officers</h2><p>Sometimes drivers face abuse of authority by law enforcement, such as being stopped without cause or facing fabricated reports. In these cases, a dashcam becomes a key tool for defense. The recording can verify whether the driver actually violated any laws or whether the officer acted improperly.<br>Moreover, the awareness that all actions are being recorded encourages both drivers and police officers to act more responsibly, reducing the likelihood of conflicts on the road.<br></p><h2 class="">Recording Violations by Other Road Users</h2><p>A dashcam not only helps protect the driver but also captures dangerous behavior by others—speeding, running red lights, driving into oncoming traffic, and so on. Drivers can voluntarily submit such footage to the police to assist in holding offenders accountable. These actions not only help improve road safety but also promote legal consciousness and civic responsibility.<br></p><h2 class="">Usefulness in Insurance Disputes</h2><p>Dashcam footage is often crucial in settling insurance claims. Insurance companies usually accept such recordings as valid evidence when assessing the circumstances of an accident. This can speed up investigations, avoid disputes, and ensure fair compensation for damages.<br></p><h2 class="">Legal Aspects of Dashcam Use</h2><p>Using a dashcam must comply with legal regulations, especially regarding personal data protection. While drivers are allowed to film what happens on public roads, publicly sharing footage that includes identifiable individuals without their consent may violate their privacy rights. Therefore, it's important to understand the boundaries of lawful use.</p><h2 class="">Conclusion</h2><p>A dashcam is a vital legal protection tool for drivers. It not only captures an objective view of road events but also serves as an effective means of defending one’s rights in conflict situations. Considering the growing risks on the roads, installing a dashcam is not only advisable but also a necessary step for every responsible driver.</p>	Using a dashcam while driving has become a powerful tool for protecting one’s violated rights.
using-a-video-recorder	uk	Використання відеореєстратора	<p>У сучасних умовах стрімкого розвитку автомобільного транспорту та зростання кількості дорожньо-транспортних пригод (ДТП) дедалі більше водіїв вдаються до встановлення відеореєстраторів у своїх автомобілях. Цей пристрій, на перший погляд простий, має велике юридичне значення. Використання відеореєстратора під час руху транспортного засобу стало потужним інструментом у відстоюванні своїх порушених прав, особливо в ситуаціях, коли провина сторін є спірною.<br></p><h2 class="">Відеореєстратор як доказ у суді</h2><p>Однією з головних функцій відеореєстратора є фіксація подій на дорозі в режимі реального часу. У випадку ДТП або конфлікту з іншими учасниками дорожнього руху запис із відеореєстратора може бути використаний як доказ у суді або під час розгляду справи в поліції. Відео дозволяє встановити послідовність подій, швидкість руху, дії водіїв, а також інші важливі обставини, які можуть вплинути на оцінку правомірності дій сторін.<br><br>Судова практика в Україні визнає відеозапис як допустимий доказ, якщо його було отримано без порушення вимог законодавства. Це означає, що відео має бути цілісним, без ознак монтажу або редагування. У багатьох випадках саме завдяки відеофіксації водій зміг довести свою невинуватість та уникнути штрафу або адміністративної відповідальності.<br></p><h2 class="">Захист від неправомірних дій працівників поліції</h2><p>Іноді водії стикаються з випадками перевищення повноважень з боку працівників поліції, наприклад, при зупинці без належних підстав або при складанні необґрунтованих протоколів про порушення. У таких ситуаціях відеореєстратор стає ключовим елементом захисту. Запис може засвідчити, чи дійсно водій порушив правила, чи мала місце провокація або помилка інспектора.<br><br>До того ж, усвідомлення того, що кожна дія фіксується на відео, дисциплінує як водіїв, так і працівників правоохоронних органів, що сприяє зменшенню кількості конфліктних ситуацій на дорогах.<br></p><h2 class="">Фіксація порушень іншими учасниками руху</h2><p>Відеореєстратор допомагає не тільки захищати себе, але й фіксувати небезпечну поведінку інших учасників руху – порушення швидкісного режиму, проїзд на червоне світло, виїзд на зустрічну смугу тощо. За бажанням водій може передати відео в поліцію для реагування та притягнення до відповідальності порушників. Такі дії не лише сприяють підвищенню безпеки на дорогах, але й формують культуру правосвідомості.<br></p><h2 class="">Корисність у страхових спорах</h2><p>Відеозапис часто є вирішальним фактором під час врегулювання страхових випадків. Страхові компанії охоче приймають записи з реєстраторів як докази обставин ДТП. Це дозволяє пришвидшити процес розслідування, уникнути суперечок та забезпечити справедливе відшкодування збитків.<br></p><h2 class="">Юридичні аспекти використання</h2><p>Використання відеореєстратора повинно відповідати нормам законодавства, зокрема щодо захисту персональних даних. Водій має право знімати те, що відбувається на дорозі, однак публічне поширення відео без згоди осіб, які на ньому зображені, може порушувати їхні права. Тому важливо розуміти межі використання таких записів.</p><h2 class="">Висновок</h2><p><br>Відеореєстратор є важливим елементом правового захисту водія. Його наявність дозволяє не лише фіксувати об'єктивну картину подій на дорозі, але й виступає ефективним засобом доведення правоти у конфліктних ситуаціях. З огляду на зростаючі ризики на дорогах, встановлення реєстратора є не лише доцільним, а й необхідним кроком для кожного відповідального водія.</p>	Використання відеореєстратора під час руху транспортного засобу стало потужним інструментом у відстоюванні своїх порушених прав.
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	en	Restrictions on the right to drive a vehicle during mobilization	<p data-start="202" data-end="437"><span data-start="202" data-end="298">Amendments to the Code of Administrative Procedure of Ukraine under the New Mobilization Law.</span></p><p data-start="202" data-end="437"><span data-start="301" data-end="367"><a href="https://zakon.rada.gov.ua/laws/show/3633-IX#Text" target="_blank">Document No. 3633-IX, currently in force (not the Code itself)</a></span></p><h2 data-start="202" data-end="437" class=""><span data-start="370" data-end="437">Restriction of the Right to Drive a Vehicle During Mobilization</span></h2>\r\n<p data-start="439" data-end="868"><strong data-start="439" data-end="456">Article 283-2</strong> has been supplemented with a provision allowing the <strong data-start="509" data-end="571">Territorial Center of Recruitment and Social Support (TCC)</strong> to apply to the court to restrict a Ukrainian citizen’s right to drive a vehicle during mobilization.<br data-start="673" data-end="676">\r\nThe TCC has the right to apply if the citizen fails to comply with the lawful order of the TCC regarding the fulfillment of their duty.<br data-start="811" data-end="814">\r\nThe case falls under the jurisdiction of local courts.</p>\r\n<p data-start="870" data-end="905">In such a case, the TCC must prove:</p><ul><li>failure to fulfill duties under Part 3 of Article 22 of the Law of Ukraine "On Mobilization Preparation and Mobilization";</li><li>inability to detain and deliver the person to the TCC;</li><li>inability to serve a summons;</li><li>failure to comply with the order issued by the TCC;</li><li>the use of the vehicle is not related to a disability or a child with a disability.</li></ul><h2 class=""><span data-start="1270" data-end="1287">Key Features</span></h2><ul><li>the court decision is subject to immediate enforcement;</li><li>15 days are granted for filing an appeal;</li><li>the appeal must be reviewed within 15 days;</li><li>the decision of the appellate court may be further appealed through cassation.</li></ul><p></p>	Amendments to the Code of Administrative Procedure of Ukraine under the New Mobilization Law Allow TCCs to Restrict the Right to Drive a Vehicle.
Restrictions-on-the-right-to-drive-a-vehicle-during-mobilization	uk	Обмеження у праві керування транспортним засобом під час мобілізації	<p>Зміни до Кодексу про адміністративне судочинство України відповідно до нового мобілізаційного Закону.<br></p><p><a href="https://zakon.rada.gov.ua/laws/show/3633-IX#Text" target="_blank">Документ 3633-IX, чинний (не кодекс)</a></p><h2 class="">Обмеження у праві керування транспортним засобом під час мобілізації</h2><p><br>Стаття 283-2 доповнено можливістю територіального центру комплектування та соціальної підтримки&nbsp; (ТЦК) звернутися до суду для обмеження громадянина України у праві керування транспортним засобом під час мобілізації. ТЦК має право звернутися у разі невиконання громадянином України вимоги такого ТЦК про виконання обов’язку. Справа підсудна місцевим судам.&nbsp;<br><br>При цьому ТЦК має довести:<br></p><ul><li>невиконання обов'язків згідно ч.3 ст.22 ЗУ Про мобілізаційну підготовку та мобілізацію</li><li>неможливість затримання та доставки в ТЦК</li><li>неможливість вручення повістки</li><li>невиконання обов'язку зазначеного в вимозі</li><li>використання ТЗ у зв'язку з інвалідністю або дитини з інвалідністю<br></li></ul><h2 class="">Особливості</h2><ul><li>рішення суду підлягає негайному виконанню</li><li>15 днів на оскарження</li><li>15 днів для розгляду апеляції</li><li>Рішення апеляційного суду може бути оскаржене в касаційному порядку.</li></ul>	Зміни до КАС України відповідно до нового мобілізаційного Закону дозволяють ТЦК обмежувати в праві керування ТЗ.
the-constitution-of-ukraine-and-the-sphere-of-military-law	en	The Constitution of Ukraine and the sphere of military law	<h1>Constitutional Foundations of Military Law</h1>\r\n\r\n<p>The Constitution of Ukraine, adopted on June 28, 1996, is the fundamental law of the state that contains the basic principles of military development and national defense. The military sphere is regulated by a number of constitutional provisions that form the legal basis of national security.</p>\r\n\r\n<p><a href="http://zakon.rada.gov.ua/laws/show/254к/96-вр#Text" target="_blank">Link to the document</a>.</p>\r\n\r\n<p>Article 17 of the Constitution declares that "the defense of the Motherland, the independence and territorial integrity of Ukraine, and respect for its state symbols are the duties of citizens of Ukraine." This provision constitutes the constitutional basis of military service.</p>\r\n\r\n<h2>Key Constitutional Provisions in the Military Sphere</h2>\r\n\r\n<p>The main constitutional provisions regulating the military sphere include:</p>\r\n\r\n<ul>\r\n<li>Article 65 - defines citizens' duty to defend the Motherland</li>\r\n<li>Article 92 - establishes the exclusive competence of the Verkhovna Rada in defense matters</li>\r\n<li>Article 106 - enshrines the powers of the President as Supreme Commander-in-Chief</li>\r\n<li>Article 35 - guarantees the right to alternative service</li>\r\n</ul>\r\n\r\n<h2>Implementation of Constitutional Military Provisions</h2>\r\n\r\n<p>Constitutional norms in the field of defense are implemented through:</p>\r\n\r\n<ol>\r\n<li>A system of special laws ("On Defense of Ukraine", "On Military Duty and Military Service")</li>\r\n<li>Activities of state authorities in the security sphere</li>\r\n<li>Judicial practice regarding the protection of constitutional rights of military personnel</li>\r\n</ol>\r\n\r\n<h2>The Constitution During Martial Law</h2>\r\n\r\n<p>Article 64 of the Constitution provides for the possibility of temporary restrictions on rights and freedoms in case of martial law or state of emergency. However, even under such conditions, the following cannot be restricted:</p>\r\n\r\n<ul>\r\n<li>Right to life</li>\r\n<li>Prohibition of torture</li>\r\n<li>Right to inviolability of private life</li>\r\n</ul>\r\n\r\n<p>The Verkhovna Rada of Ukraine exercises parliamentary control over compliance with constitutional norms in the military sphere, especially during anti-terrorist operations or in case of aggression.</p>\r\n\r\n<h2>Modern Challenges and Constitutional Guarantees</h2>\r\n\r\n<p>In the current conditions of hybrid warfare, constitutional mechanisms for protecting state sovereignty have become particularly important. The Constitutional Court of Ukraine has repeatedly emphasized in its decisions the priority of constitutional norms in the defense sphere over any other normative acts.</p>\r\n\r\n<p>The development of military law in Ukraine occurs in compliance with international standards and constitutional principles, which ensures protection of both national interests and the rights of military personnel.</p>\r\n	A review article on the legal norms that regulate the obligations of the state and the citizen in the military sphere.
the-constitution-of-ukraine-and-the-sphere-of-military-law	uk	Конституція України і сфера військового права	<h2>1. Конституційні засади військового права</h2>\r\n\r\n<p>Конституція України, прийнята 28 червня 1996 року, є основним законом держави, який містить фундаментальні принципи військового будівництва та оборони країни. Військова сфера регулюється низкою конституційних норм, що формують правову основу національної безпеки.</p><p><a href="https://zakon.rada.gov.ua/laws/show/254%D0%BA/96-%D0%B2%D1%80#Text" target="_blank">Посилання на документ</a>.</p>\r\n\r\n<p>Стаття 17 Конституції проголошує, що "захист Вітчизни, незалежності і територіальної цілісності України, шанування її державних символів є обов'язком громадян України". Це положення становить конституційну основу військової служби.</p>\r\n\r\n<h2>2. Основні конституційні норми у військовій сфері</h2>\r\n\r\n<p>До ключових положень Конституції, що регулюють військову сферу, належать:</p>\r\n\r\n<ul>\r\n<li>Стаття 65 - визначає обов'язок громадян захищати Вітчизну</li>\r\n<li>Стаття 92 - встановлює виключну компетенцію Верховної Ради у питаннях оборони</li>\r\n<li>Стаття 106 - закріплює повноваження Президента як Верховного Головнокомандувача</li>\r\n<li>Стаття 35 - гарантує право на альтернативну службу</li>\r\n</ul>\r\n\r\n<h2>3. Реалізація військових положень Конституції</h2>\r\n\r\n<p>Конституційні норми у сфері оборони реалізуються через:</p>\r\n\r\n<ol>\r\n<li>Систему спеціальних законів ("Про оборону України", "Про військовий обов'язок і військову службу")</li>\r\n<li>Діяльність органів державної влади у сфері безпеки</li>\r\n<li>Судову практику з питань захисту конституційних прав військовослужбовців</li>\r\n</ol>\r\n\r\n<h2>4. Конституція під час воєнного стану</h2>\r\n\r\n<p>Стаття 64 Конституції передбачає можливість тимчасового обмеження прав і свобод у разі введення воєнного або надзвичайного стану. Проте навіть у таких умовах не підлягають обмеженню:</p>\r\n\r\n<ul>\r\n<li>Право на життя</li>\r\n<li>Заборона катувань</li>\r\n<li>Право на недоторканність особистої життєвої сфери</li>\r\n</ul>\r\n\r\n<p>Верховна Рада України здійснює парламентський контроль за дотриманням конституційних норм у військовій сфері, особливо під час проведення антитерористичних операцій або у разі агресії.</p>\r\n\r\n<h2>5. Сучасні виклики та конституційні гарантії</h2>\r\n\r\n<p>У сучасних умовах гібридної війни особливого значення набувають конституційні механізми захисту державного суверенітету. Конституційний Суд України у своїх рішеннях неодноразово підкреслював пріоритетність конституційних норм у сфері оборони над будь-якими іншими нормативними актами.</p>\r\n\r\n<p>Розвиток військового права в Україні відбувається з дотриманням міжнародних стандартів і конституційних принципів, що гарантує захист як національних інтересів, так і прав військовослужбовців.</p>\r\n	Оглядова стаття про правові норми, які регулюють обов'язки держави та громадянина у війсковій сфері.
simplification-of-the-drivers-license-examination-process	en	Simplification of the driver's license examination process	<p>Important amendments to Ukraine's traffic rules, which came into effect in 2024, aim to increase road safety and reduce the number of accidents. One of the key innovations is the mandatory use of daytime running lights outside populated areas throughout the year. Previously, drivers were only required to use running lights in the autumn-winter period (from October 1 to May 1), but now this rule is in effect year-round. The decision is aimed at making vehicles more visible to other road users regardless of weather conditions or lighting levels.</p><h2>The Importance of Using Running Lights</h2><p>Headlights reduce the risk of accidents by improving the visibility of cars on the road, especially in poor weather conditions such as rain or fog. Lighting devices help quickly identify approaching vehicles, especially on roads with heavy traffic. Thus, the decision to make running lights mandatory outside the city year-round is fully justified. According to research, the visibility of a car with headlights on can improve the reaction of other drivers and pedestrians by 20-25%, reducing the risk of collisions.</p><h2>Rule Compliance Check</h2><p>The new requirements stipulate that the police can now monitor compliance with this rule on roads outside populated areas. Drivers who ignore this requirement face fines. Since the continuous use of running lights is becoming mandatory, additional control by the police is expected, along with the installation of new surveillance cameras capable of recording violations remotely.</p>	The process of obtaining a driver's license has also changed for future drivers. From now on, candidates can take the theoretical exam without mandatory attendance at driving school courses. 
simplification-of-the-drivers-license-examination-process	uk	Спрощення процесу складання іспитів на права	<p>У 2024 році в Україні було запроваджено зміни, які спрощують процес складання іспитів на отримання водійських прав. Основне нововведення полягає в тому, що тепер кандидати у водії можуть складати теоретичний іспит без обов'язкового навчання в автошколі. Це значне полегшення для тих, хто має базові знання з правил дорожнього руху та здатний самостійно підготуватися до іспиту.&nbsp;</p>\r\n<h2>Мета змін</h2> \r\nЗміни спрямовані на зменшення фінансового навантаження на громадян, адже навчання в автошколах може бути досить витратним. Наразі багато громадян мають можливість навчатися самостійно за допомогою онлайн-ресурсів або спеціалізованих додатків для вивчення ПДР. Скасування обов’язкових курсів у автошколах також робить процес отримання прав більш доступним, особливо для людей з обмеженими фінансовими можливостями або тих, хто не має часу на відвідування навчальних закладів.<p></p> \r\n<p>Особливості нового підходу У нових правилах передбачено, що кандидати можуть самостійно обирати метод підготовки до теоретичного іспиту. Однак вимоги до практичних навичок залишаються незмінними, і для отримання права керувати транспортним засобом необхідно пройти практичне навчання в автошколі та скласти відповідний іспит. Це дозволяє зберегти необхідний рівень безпеки на дорогах, адже управління транспортом вимагає не лише знань теорії, але й певного рівня практичної підготовки під наглядом інструктора.</p> \r\n<h2>Економія часу та ресурсів</h2> \r\n<p>Введення можливості самопідготовки до теоретичного іспиту також скорочує час, необхідний для отримання водійських прав. Раніше кандидати були зобов’язані відвідувати курси в автошколах, які могли тривати кілька місяців. Тепер же, якщо людина вже володіє знаннями або швидко засвоює матеріал, вона може скласти іспит значно швидше. Це дозволяє уникнути довгих черг в автошколах та забезпечує більш оперативний процес отримання водійського посвідчення.</p> \r\n<h2>Виклики нової системи</h2> \r\n<p>Проте спрощення вимог до теоретичного навчання може мати як позитивні, так і негативні наслідки. Деякі експерти вважають, що недостатня підготовка теоретичної частини може призвести до підвищеного ризику на дорогах. Незважаючи на це, держава розраховує на відповідальність майбутніх водіїв, а також на розвиток сучасних інструментів для самостійного навчання. Зокрема, розроблено численні додатки та онлайн-платформи, які дозволяють ефективно та якісно готуватися до теоретичних іспитів.</p>\r\n<h2>Відгуки громадськості</h2> \r\n<p>Зміни в процесі підготовки до іспитів викликали різні реакції в суспільстві. Багато людей вважають, що спрощення умов навчання полегшить доступ до водійських прав і позитивно вплине на мобільність громадян. Водночас є й ті, хто висловлює занепокоєння через можливість зниження загального рівня знань серед нових водіїв. У відповідь на це Міністерство внутрішніх справ заявляє, що система буде постійно контролюватися, а кількість аварій з вини новачків буде аналізуватися, щоб оцінити ефективність нових правил.</p>\r\n<h2>Очікувані результати</h2> \r\n<p>Запроваджені зміни можуть сприяти не лише зменшенню витрат часу і коштів для майбутніх водіїв, але й зниженню навантаження на автошколи та підвищенню доступності водійських прав для широкого кола громадян. Доступність та демократизація навчання на права, зокрема, дозволяють розширити коло тих, хто може законно керувати транспортним засобом, не вдаючись до послуг дорогих курсів. Завдяки цьому у майбутньому очікується підвищення загального рівня мобільності в країні, що особливо актуально для регіонів, де якісні автошколи можуть бути обмежені або недоступні. Таким чином, спрощення процесу складання теоретичних іспитів у 2024 році можна вважати кроком до більш доступного і демократичного процесу отримання водійських прав в Україні.</p>	Для майбутніх водіїв процес отримання прав також зазнав змін. Відтепер кандидати можуть складати теоретичний іспит без обов’язкового відвідування курсів в автошколах. 
deferrals-from-military-service-for-stepfathers	en	Deferrals from military service for stepfathers	<p>As a legal basis for granting deferment from military conscription during mobilization, one may refer to Paragraph 6, Part 1, Article 23 of Law No. 2232-XII (women and men who are guardians, custodians, foster parents, or adoptive parents raising a child with a disability under the age of 18). This provision states that the mentioned reservists are not subject to military conscription during mobilization.</p>\r\n\r\n<p>The Supreme Court noted that a stepfather, being married to the mother of a minor child with a disability, has the right to participate in the child's upbringing (provided they live together as a family). At the same time, the obligation to raise such a child, in accordance with the Family Code of Ukraine, lies, in particular, with the child's father.</p>\r\n\r\n<h3>Conclusion</h3>\r\n\r\n<p>The Supreme Court concluded that since the obligation to raise a child with a disability is imposed on the father under Part 2, Article 157 of the Family Code of Ukraine, and according to Part 1, Article 260 of the same Code, the stepfather exercises this right on a voluntary basis, there are no reasonable grounds to consider that the provisions of Paragraph 6, Part 1, Article 23 of Law No. 2232-XII apply to the stepfather under the circumstances of this case.</p>\r\n\r\n<p><a href="https://reyestr.court.gov.ua/Review/122098050">Court Decision</a></p>	The Supreme Court's position on the possibility of obtaining a deferment from service for a stepfather to care for a child with a disability under the age of 18.
deferrals-from-military-service-for-stepfathers	uk	Відстрочки від призову на військову службу для вітчима	У якості правової підстави для надання відстрочки від призову на військову службу під час мобілізації є можливість керуватися абз. 6 ч. 1 ст. 23 Закону № 2232-ХІІ (жінки та чоловіки, опікуни, піклувальники, прийомні батьки, батьки-вихователі, які виховують дитину з інвалідністю віком до 18 років). Ця норма вказує, що не підлягають призову на військову службу під час мобілізації вказані військовозобов`язані.<br><br>ВС зазначив, що вітчим перебуваючи у шлюбі з матір’ю неповнолітньої дитини з інвалідністю, має право на участь у її вихованні (за умови проживання однією сім`єю). При цьому обов`язок щодо виховання цієї дитини відповідно до положень СК України покладено, зокрема, на її батька.<br><br><h2 class="">Висновок</h2><br>ВС дійшов висновку, що оскільки обов`язок з виховання дитини з інвалідністю, приписами ч. 2 ст. 157 СК України покладено на її батька, а відповідно до ч. 1 ст. 260 СК України вітчим реалізовує таке право на добровільних засадах, відсутні обґрунтовані підстави вважати, що на вітчима, за обставин цієї справи, розповсюджуються положення абз. 6 ч. 1 ст. 23 Закону № 2232-ХІІ.<br><br><a href="https://reyestr.court.gov.ua/Review/122098050" target="_blank">Рішення суду</a>	Позиція ВС щодо можливості отримати відстрочку від служби для вітчима по догляду за дитиною з інвалідністю до 18 років.
\.


--
-- Data for Name: audio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio (identifier, active, name) FROM stdin;
3	t	Audio for article - Evidence in administrative offense cases key aspects
2	t	Audio for article - Document verification for drivers
1	t	Audio for article - Simplification of the drivers license examination process
62	t	Reservation of employees of enterprises in Ukraine during martial law
44	t	test audio
46	t	Ukraine Plans to Increase Fines for Speeding Violations
63	t	Code of Ukraine on Administrative Offenses
47	t	The importance of seat belts when driving a car
64	t	Impossibility of judicial appeal of summons to appear at the Territorial Centres of Recruitment
48	t	The driver is allowed to enter the lane for route vehicles, separated by a broken marking line, for the purpose of dropping off a passenger
49	t	The Law on Road Traffic of Ukraine
65	t	Plaintiff's failure to appear in court
50	t	Using a video recorder
51	t	Grounds for stopping a vehicle by police officers in Ukraine
66	t	Deferrals from military service for stepfathers
52	t	Code of Administrative Procedure of Ukraine
53	t	Restrictions on the right to drive a vehicle during mobilization
67	t	Traffic rules of Ukraine: a complete overview of the regulatory framework
54	t	Circumstances that are not a valid reason for missing a procedural deadline
55	t	Administrative detention: legal grounds, terms and features
68	t	The Constitution of Ukraine and the sphere of military law
56	t	Evidence in administrative law
57	t	Laws and regulations governing the field of military law
58	t	Amendments to the Resolution of the Cabinet of Ministers on the Reservation of Conscripts No. 27.01.23 No. 76
69	t	Rights of a person held administratively liable
59	t	Passing the military medical commission
60	t	Extension of the guarantee of maintaining a serviceman's job
61	t	Military Registration Document: Importance and Features
\.


--
-- Data for Name: audio_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio_translates (audio_id, language, description, path) FROM stdin;
3	en	Evidence in Administrative Offense Cases: Key Aspects	articles/evidence-in-administrative-offense-cases-key-aspects/en-evidence-in-administrative-offense-cases-key-aspects.mp3
3	uk	Докази по справі про адміністративне правопорушення: ключові аспекти	articles/evidence-in-administrative-offense-cases-key-aspects/uk-evidence-in-administrative-offense-cases-key-aspects.mp3
2	en	Document Verification for Drivers by Police Officers: Updated Requirements and Procedures	articles/document-verification-for-drivers/en-Changes-in-driver-document.mp3
2	uk	Перевірка документів у водіїв працівниками поліції: оновлені вимоги та процедури	articles/document-verification-for-drivers/uk-perevirka-dokumentiv-u-vodiiv-transportnih-zasobiv.mp3
1	en	Simplification of the driver's license examination process audio	articles/simplification-of-the-drivers-license-examination-process/en-simplification-of-the-driver's-license-examination-process.mp3
1	uk	Спрощення процесу складання іспитів на права аудіо	articles/simplification-of-the-drivers-license-examination-process/uk-sproshennya-procesu-skladannya-ispitiv-na-prava.mp3
67	en	Traffic rules of Ukraine: a complete overview of the regulatory framework	articles/0x0TNnt9y53MSwmojntN.mp3
67	uk	Правила дорожнього руху України: повний огляд нормативно-правової бази	articles/3cWj7B1btWKqDhGixIUB.mp3
44	en	test track	articles/x1Em4itufDIGoYrcHuXf.mp3
44	uk	Тестовий трек для статті	articles/MTsZCc4rD6sGq7aUjkw6.mp3
46	en	Ukraine Plans to Increase Fines for Speeding Violations	articles/O1bvRPHX8BETSlbDuZkk.mp3
46	uk	В Україні планують підвищити розміри штрафів за порушення швидкісного режиму	articles/Jkyn4R1Wwf18Qgdls3fl.mp3
47	en	The importance of seat belts when driving a car	articles/zGgLQI3RrgejD1knJaLr.mp3
47	uk	Використання ременів безпеки є критично важливим для життя	articles/tBdvhTQhR1Gg31Zp6QnL.mp3
48	uk	Водієві дозволено, заїжджати на смугу для маршрутних транспортних засобів, відокремлену переривчастою лінією розмітки, з метою висадки пасажира	articles/BW7fbMpMB3vINNV4eVUC.mp3
48	en	The driver is allowed to enter the lane for route vehicles, separated by a broken marking line, for the purpose of dropping off a passenger	articles/4UfoZXEOsHmxu6ztgdwB.mp3
49	en	The Law on Road Traffic of Ukraine	articles/ob7mXXdlyLxg4qXThAPs.mp3
49	uk	Закон України Про дорожній рух	articles/Vz6KtZNhcWE2c1j5BFKo.mp3
50	en	Using a Dashcam	articles/toIMsEPQPOnf7qqxDcBj.mp3
50	uk	Використання відеореєстратора	articles/Hfc7jAV7SJNeEsgD5inE.mp3
51	en	Grounds for stopping a vehicle by police officers in Ukraine	articles/UePtTK4su18WJTFMUNHK.mp3
51	uk	Підстави для зупинки транспортного засобу працівниками поліції в Україні	articles/J5KGQrQYC5zDSNAw6XEJ.mp3
52	en	Code of Administrative Procedure of Ukraine	articles/VL0ThdYLPqCimyu7m1Mj.mp3
52	uk	Кодекс адміністративного судочинства України	articles/O3Ad9eclztWfCYPSyfmU.mp3
53	en	Restrictions on the right to drive a vehicle during mobilization	articles/80kepExwm7JOLlvi3Hn8.mp3
53	uk	Обмеження у праві керування транспортним засобом під час мобілізації	articles/Eli90j2FRLTY9nQisTg6.mp3
54	en	Circumstances that are not a valid reason for missing a procedural deadline	articles/ENPlJB6AvKW17aaYbZ8k.mp3
54	uk	Обставина, яка не є поважною причиною пропуску процесуального строку	articles/ZmE3qPdLkHrRYmMIJtHI.mp3
55	en	Administrative detention: legal grounds, terms and features	articles/rlFwMNzn6DijO4j4ud1P.mp3
55	uk	Адміністративне затримання: правові підстави, строки та особливості	articles/GCVyIHOKrxNgbfLtaEPM.mp3
56	en	Evidence in administrative law	articles/5e2kXdhfYT5X9thi1vsr.mp3
56	uk	Докази в адміністративному праві	articles/VERNx2uuhEUapgQNzrPh.mp3
57	en	Laws and regulations governing the field of military law	articles/Lo6l9AxA7ssBi95tP5Lv.mp3
57	uk	Закони та нормативно-правові акти, які регулюють сферу військового права	articles/WzkJozZG5XzSLqlSCWCW.mp3
58	en	Amendments to the Resolution of the Cabinet of Ministers on the Reservation of Conscripts No. 27.01.23 No. 76	articles/s60hWJ8A2Coz2GsfOyFv.mp3
58	uk	Зміни до постанови КМУ щодо бронювання військовозобов'язаних № 27.01.23 № 76	articles/5JID12owEKTk94MNxyAj.mp3
59	en	Passing the military medical commission	articles/P1Acn3i2Evh3qxq5eKff.mp3
59	uk	Проходження військово-лікарської комісії	articles/VuStIy44IluC0wQWXRXK.mp3
60	en	Extension of the guarantee of maintaining a serviceman's job	articles/97vH4dAUtFBo20Imz4AN.mp3
60	uk	Поширення гарантії щодо збереження місця роботи військовослужбовця	articles/B5Me5PYYcZq91Rs8I2gV.mp3
61	en	Military Registration Document: Importance and Features	articles/hkmaQdlvCALDOlotyYJj.mp3
61	uk	Військовий обліковий документ: значення та особливості	articles/VbqpYx0J8kpEcbdq91Om.mp3
62	en	Reservation of employees of enterprises in Ukraine during martial law	articles/P7psxYLRoIJrcelv265j.mp3
62	uk	Бронювання працівників підприємств в Україні під час воєнного стану	articles/7Iw6RApX9Etnh0LQKJhq.mp3
63	en	Code of Ukraine on Administrative Offenses	articles/HuxgSQUTVEmWUtSfTvzw.mp3
63	uk	Кодекс України про адміністративні правопорушення	articles/VcN4L87gq1dPgM93LP1b.mp3
64	en	Impossibility of judicial appeal of summons to appear at the Territorial Centres of Recruitment	articles/WI6AKCuYy0zWxr4lJPiC.mp3
64	uk	Неможливість судового оскарження повістки на прибуття до ТЦК	articles/24MCyyzjxxgTPHPThf0O.mp3
65	en	Plaintiff's failure to appear in court	articles/DKyUwQbuNiKNTo9tqfrY.mp3
65	uk	Неявка до суду позивача	articles/slugbiKdeVwigCfa4q7V.mp3
68	en	The Constitution of Ukraine and the sphere of military law	articles/DDBXLApy4Ept4RFwSge0.mp3
68	uk	Конституція України і сфера військового права	articles/bu64rPwOJOw3aneo6BKL.mp3
66	en	Deferrals from military service for stepfathers	articles/0Q9HyCWIMlrRUn7XzwJS.mp3
66	uk	Відстрочки від призову на військову службу для вітчима	articles/ajA9waWtO2clYoSJU5xd.mp3
69	en	Rights of a person held administratively liable	articles/MZMfV0odLD1TEyGmR7x2.mp3
69	uk	Права особи, яка притягується до адміністративної відповідальності	articles/oEdo05xfbKCIJgw463AX.mp3
\.


--
-- Data for Name: author; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author (identifier, name, active) FROM stdin;
3	Freepik	t
18	Test author 1	t
1	AI	t
\.


--
-- Data for Name: author_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author_translates (author_id, language, description) FROM stdin;
3	en	Freepik
3	uk	Freepik
18	en	Test author
18	uk	Тестовий автор
1	en	AI
1	uk	Штучний інтелект
\.


--
-- Data for Name: banner; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.banner (identifier, active, name, img_id, priority) FROM stdin;
8	t	Stand With Ukraine	116	10
10	t	Choose your future	118	5
\.


--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category (identifier, active) FROM stdin;
traffic-legislative-changes	t
traffic-consultations	t
traffic-judicial-practice	t
traffic-legal-framework	t
traffic-common-mistakes	t
traffic-vehicle-stop	t
administrative-process-legal-framework	t
administrative-process-legislative-changes	t
administrative-process-consultations	t
administrative-process-administrative-detention	t
evidence	t
military-law	t
military-law-legal-framework	t
military-law-legislative-changes	t
military-law-mmc	t
military-law-judicial-practice	t
military-registration-document	t
military-reservation	t
administrative-process	t
traffic	t
\.


--
-- Data for Name: category_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category_translates (category_id, language, name, description) FROM stdin;
military-law-mmc	en	Military Medical Commission	The section is dedicated to everything related to the VLK - regulatory documents, recent changes, precedents, consultations.
military-registration-document	en	Military registration document	A selection of articles on the topic of military registration documents - legal framework, legislative changes, practical application.
traffic-legislative-changes	en	Traffic legislative changes	Always stay up to date with the latest legislative changes in the field of road traffic. Whether you are a driver or a pedestrian, this section will be useful for everyone.
traffic-legislative-changes	uk	Законодавчі зміни в дорожньому русі	Будьте завжди в курсі останніх законодавчих змін в сфері дорожнього руху. Водій ви, або пішохід, цей розділ буде корисним для кожного. 
traffic-consultations	en	Traffic consultations	Materials on the topic of road traffic. Useful tips, analysis of specific life cases. Consultations are provided in case of legal assistance to our company. Personal data of clients is not disclosed.
traffic-consultations	uk	Консультації з питань дорожнього руху	Матеріали по темі дорожнього руху. Корисні поради, розбір конкретних життєвих випадків. Консультації надаються в разі звернення за юридичною допомогою в нашу компанію. Особисті дані клієнтів не розголошуються.
traffic-judicial-practice	en	Traffic judicial practice	One of the important elements of the legal system of Ukraine is legal practice. It is this element that combines the norms of administrative law into a single whole and is implemented in the form of a court decision. The sphere of road traffic.
traffic-judicial-practice	uk	Судова практика з питань дорожнього руху	Одним з важливих елементів правової системи України є юридична практика. Саме цей елемент поєдную в єдине ціле норми адміністративного права і реалізується у вигляді судового рішення. Статті про застосування юридичних норм у сфері дорожнього руху.
traffic-legal-framework	en	Traffic legal framework	Collection of regulatory legal acts and documents regulating relations in the field of road traffic
traffic-legal-framework	uk	Правова база дорожнього руху	Збір нормативно-правових актів та документів, якими регулюються відносини у сфері дорожнього руху
traffic-common-mistakes	en	Traffic common mistakes	A set of tips and actions that will help you avoid violating traffic rules and defend your violated rights.
traffic-common-mistakes	uk	Поширені помилки в сфері правил дорожнього руху	Набір порад, дій, які допоможуть Вам уникнути порушення правил дорожнього руху, відстояти свої порушені права.
traffic-vehicle-stop	en	Vehicle Stop	Everything drivers need to know when a vehicle is stopped by police officers - the grounds, procedure, consequences, and powers of the parties.
traffic-vehicle-stop	uk	Зупинка транспортного засобу	Все що треба знати водіям під час зупинки транспортного засобу працівниками поліції - підстави, порядок дій, наслідки, повноваження сторін.
administrative-process-legal-framework	en	Administrative process legal framework	Collection of materials on regulatory legal acts regulating the sphere of administrative process in Ukraine
administrative-process-legal-framework	uk	Правова база адміністративного процесу	Збірка матеріалів по нормативно-правовим актам, які регулюють сферу адміністративного процесу України
administrative-process-legislative-changes	en	Administrative process legislative changes	All changes in the legislation regarding administrative justice in Ukraine. You will always be up to date - you will be the first.
administrative-process-legislative-changes	uk	Зміни в законодавстві щодо адміністративного судочинства	Всі зміни в законодавстві щодо адміністративного судочинства України. Будете завжди в курсі - будете першим.
administrative-process-consultations	en	Administrative process consultations	A set of materials that highlight specific actions that can help a litigant achieve their goal.
administrative-process-consultations	uk	Консультації з питань адміністративного судочинства	Набір матеріалів, які висвітлюють конкретні дії, які можуть допомогти учаснику судового процесу досягти своєї мети. 
military-law-legislative-changes	en	Changes in legislation regarding military law	Current changes in the legislation regarding the military law of Ukraine. Laws, acts of the Cabinet of Ministers, orders of law enforcement agencies and others. To know means to be ready.
military-law-legislative-changes	uk	Зміни в законодавстві щодо військового права	Актуальні зміни в законодавстві щодо військового права України. Закони, акти кабміну, накази правоохоронних органів і інші. Знати - означає бути готовим.
military-law-mmc	uk	Військово-лікарська комісія	Розділ присвячений всьому, з чим пов'язана ВЛК - нормативно-правові документи, останні зміни, прецеденти, консультації.
administrative-process-administrative-detention	en	Administrative detention	A collection of materials that will help you protect your rights during administrative detention by police officers. Legislation, advice, examples.
administrative-process-administrative-detention	uk	Адміністративне затримання	Збірка матеріалів, які допоможуть захистити свої права під час адміністративного затримання працівниками поліції. Законодавство, поради, приклади.
military-law-judicial-practice	en	Military law judicial practice	Real actions, decisions of law enforcement agencies, the judiciary, and military representatives.
military-law-judicial-practice	uk	Юридична практика в сфері військового права	Реальні дії, рішення правоохоронних органів, судової влади та військових представництв.
evidence	en	Evidence	Evidence plays a big role in administrative law. Its absence or presence by one of the parties can have a decisive impact on the court's decision. Evidence is usually collected at the initial stage, so knowledge about it is necessary to have before that.
evidence	uk	Докази	Докази в адміністративному праві відіграють велику роль. Їх відсутність чи наявність в однієї зі сторін може мати вирішальний вплив на рішення суду. Докази, як правило, збираються на початковому етапі, тому знання про них потрібно мати до того.
military-registration-document	uk	Військово-обліковий документ	Підбірка статей на тему військово-облікового документа - правова база, законодавчі зміни, практичне застосування.
military-reservation	en	Reservation of employees for the period of mobilization	Stay up to date with everything related to the topic of booking you or your employees - legal regulations, recent changes, important decisions of government authorities.
military-reservation	uk	Бронювання працівників на період мобілізації	Будьте в курсі всього, що стосується теми бронювання вас або ваших працівників - норми права, останні зміни, важливі рішення органів влади.
military-law	en	Military law	Everything you need to know to protect your rights and fulfill your duties in the field of military law. Regulatory acts, consultations, legal positions of authorities.
military-law	uk	Військове право	Все що потрібно знати для захисту своїх прав та виконання обов'язків у сфері військового права. Нормативні акти, консультації, правові позиції органів влади. 
military-law-legal-framework	en	Military law legal framework	A collection of articles describing regulatory legal acts in the field of military law, such as laws, government decrees, and others.
military-law-legal-framework	uk	Нормативна база військового права	Збірка статей, які описують нормативно-правові акти у сфері військового право, такі як закони, постанови уряду та інші.
administrative-process	en	Administrative Process 	Adjudication of administrative cases in courts, refers to the procedures and practices employed to resolve disputes arising from the application of administrative law
administrative-process	uk	Адміністративний процес	Адміністративно-процесуальними нормами врегульована діяльність публічної адміністрації, яка спрямована на застосування положень матеріального права під час розгляду та вирішення конкретних індивідуальних справ
traffic	en	Traffic law	Traffic law refers to the regulations and rules established by authorities to ensure the safe and efficient movement of vehicles and pedestrians on roads
traffic	uk	Законодавство про дорожній рух	Все про закони про дорожній рух які стосуються правил і норм, встановлених владою для забезпечення безпеки та ефективного руху транспортних засобів і пішоходів на дорогах
\.


--
-- Data for Name: img; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img (identifier, name, author_id, path, active) FROM stdin;
2	document-verification-for-drivers	1	articles/perevirka-documentiv/1.webp	t
4	stub-coming-soon-article-list-view	1	common/coming-soon-2000-2000.webp	t
111	A road intersection with two cars and a pedestrian.	1	articles/kTIz5gCHXgwWy5UjRqJr.webp	t
86	Test image	1	articles/MtehBneVhhzq7UQmJZqZ.webp	t
87	Ukraine Plans to Increase Fines for Speeding Violations	1	articles/JC6uDKOhOTfTW4llZ7v6.webp	t
123	Alarm clock and sticker Later	1	articles/WxqSHIish3hAwUevO6v7.webp	t
89	The importance of seat belts when driving a car	1	articles/UhVz7uQ1CtyKxiBqJjAI.webp	t
90	A driver is allowed to enter a lane designated for public transport vehicles, separated by a broken line marking, for the purpose of dropping off a passenger	3	articles/TStMRBIsHNvvofI8dxak.webp	t
124	A soldier looks at the paperwork	1	articles/OAl25ihbrJtvpivnuuga.webp	t
94	Code of Administrative Procedure of Ukraine	1	articles/xM4I08ZxocyONRNBJ1y6.webp	t
97	The man was detained by police officers.	1	articles/Brj5m1UuDpv5Wpmb6YLt.webp	t
98	Evidence	1	articles/YejljIOCfWrUW6CJOaVq.webp	t
99	Laws and regulations governing the field of military law	1	articles/bwJnyKH6OTXUWtvvyQUA.webp	t
100	Employee in the field of heat energy supply and overdrinking Reservation	1	articles/qTQmeyuYbNixetNLE943.webp	t
101	A doctor examines a conscript	1	articles/MGOtwPwMFXLkiuzepUxD.webp	t
102	Чоловік сидить за столом та тримає в руках зарплатну відомість	1	articles/VWhiJJMStVIrC4VLv913.webp	t
112	Doctor and soldier next to the Constitution	1	articles/gq91ghsZvDDF7hGyy3mh.webp	t
105	Reservation of employees of enterprises in Ukraine during martial law	1	articles/YESXKyzWfKbM2LZYZPDK.webp	t
106	Temporary image while the main image is being prepared	18	common/PGZ8DSsNjDOpiUGHKAUW.webp	t
107	Office space with a desk and the Administrative Code on it	1	articles/1FExiCl5qNVziNVapLsD.webp	t
108	Judge at the table and a folder with the inscription "Subpoena"	1	articles/j8ZqRbZgYUwzphTpscDD.webp	t
109	The plaintiff did not come to court. The judge and the defendant were alone.	1	articles/Yr8jWGTQv2KAawW0Y5nw.webp	t
110	A man at a table looks at a summons. Nearby, a child and a woman are minding their own business.	1	articles/cBgQdk9MwKeT9PzytowI.webp	t
113	A police officer draws up a warrant for the driver of a vehicle	1	articles/i2CQpp9FY4mb3JzJdWJS.webp	t
114	Two women in the middle of a car smiling while driving	1	articles/CLTj5cTF7ks2SS86NahJ.webp	t
115	An open diary with a magnifying glass pointed at it. Nearby is a sheet of paper with notes, but they cannot be made out.	1	articles/3WYiOAT87ljoDuP6S1K1.webp	t
116	Sheets of paper with the inscription Stand with Ukraine and a pen next to it on a blue background	1	articles/2izC3OOru2ldMiVVMo1F.webp	t
118	View from inside the car onto the road. Several cars ahead, mountains, and the sun.	1	common/qtd11SDaWnYdigYA2oI3.webp	t
119	Policeman stops a car on the road with a stop sign in his hands	1	articles/0jaGsGdFjIzT0jt44VKQ.webp	t
120	A girl takes a picture of herself in a car mirror	1	articles/pamrM7zAdfC4UVYi14Ew.webp	t
121	Law and justice (books, sheet, gavel)	1	articles/KTEVyZpsMI65hYL6suzq.webp	t
122	Restriction of the Right to Drive a Vehicle	1	articles/ONNqbsXELiklQyyXS2tk.webp	t
\.


--
-- Data for Name: img_cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img_cache (key, data, type, created_at) FROM stdin;
\.


--
-- Data for Name: img_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img_translates (img_id, language, description) FROM stdin;
2	en	Document Verification for Drivers
2	uk	Перевірка документі у водіїв транспортних засобів
4	en	Coming soon
4	uk	Скоро буде
112	en	Doctor and soldier next to the Constitution
112	uk	Лікар і військовий поруч з Конституцією
86	en	Test image
86	uk	Тестова картинка
113	en	A police officer draws up a warrant for the driver of a vehicle
113	uk	Поліцейський складає постанову на водія траспортного засобу
87	en	Ukraine Plans to Increase Fines for Speeding Violations
87	uk	В Україні планують підвищити розміри штрафів за порушення швидкісного режиму
114	en	Two women in the middle of a car smiling while driving
114	uk	Дві жінки в середині автомобіля посміхаються під час їзди
89	en	The importance of seat belts when driving a car
89	uk	Важливість ременів безпеки при керуванні автомобілем
115	en	An open diary with a magnifying glass pointed at it. Nearby is a sheet of paper with notes, but they cannot be made out.
115	uk	Відкритий щоденник з наведеною лупою. Поруч аркуш паперу з записами, але їх не розібрати.
90	en	A driver is allowed to enter a lane designated for public transport vehicles, separated by a broken line marking, for the purpose of dropping off a passenger
90	uk	Водієві дозволено, заїжджати на смугу для маршрутних транспортних засобів, відокремлену переривчастою лінією розмітки, з метою висадки пасажира
116	en	Sheets of paper with the inscription Stand with Ukraine and a pen next to it on a blue background
116	uk	Аркуші паперу з надписом Stand with Ukraine і ручкою поруч на блакитному фоні
94	en	Code of Administrative Procedure of Ukraine
94	uk	Кодекс адміністративного судочинства України
118	en	View from inside the car onto the road. Several cars ahead, mountains, and the sun.
119	en	Policeman stops a car on the road with a stop sign in his hands
97	en	The man was detained by police officers.
97	uk	Чоловіка затримали співробітники поліції.
119	uk	Поліцейський зупиняє автомобіль на дорозі зі знаком стоп в руках
98	en	Evidence 
98	uk	Докази
120	en	A girl takes a picture of herself in a car mirror
99	en	Laws and regulations governing the field of military law
99	uk	Закони та нормативно-правові акти, які регулюють сферу військового права
120	uk	Дівчина фотографує себе в дзеркалі автомобіля
100	en	Employee in the field of heat energy supply and overdrinking Reservation
100	uk	Працівник сфери постачання теплової енергії і надпим Бронювання
121	en	Law and justice (books, sheet, gavel)
101	en	A doctor examines a conscript
101	uk	Лікар оглядає призовника
121	uk	Закон і правосуддя (книги, аркуш, молоток)
102	en	A man sits at a table and holds a pay slip in his hands (uk)
102	uk	Чоловік сидить за столом та тримає в руках зарплатну відомість (укр)
122	en	Restriction of the Right to Drive a Vehicle
122	uk	Обмеження права керування транспортним засобом
123	en	Alarm clock and sticker Later
123	uk	Білий будильник і наклейка Пізніше
105	en	Reservation of employees of enterprises in Ukraine during martial law
105	uk	Бронювання працівників підприємств в Україні під час воєнного стану
124	en	A soldier looks at the paperwork
106	en	Temporary image while the main image is being prepared
106	uk	Тимчасове зображення, поки головне зображення готується
124	uk	Військовий дивиться на оформлення документів
107	en	Office space with a desk and the Administrative Code on it
107	uk	Офісне приміщення зі столом і Адміністративним кодексом не ньому
108	en	Judge at the table and a folder with the inscription "Subpoena"
108	uk	Суддя за столом і папка з надписом "Повістка"
109	en	The plaintiff did not come to court. The judge and the defendant were alone.
109	uk	Позивач не прийшов до суду. Суддя і відповідач самі.
110	en	A man at a table looks at a summons. Nearby, a child and a woman are minding their own business.
110	uk	Чоловік за столом дивиться на повістку. Поруч дитина і жінка займаються своїми справами.
111	en	A road intersection with two cars and a pedestrian.
111	uk	Перехрестя дороги на якому є два автомобіля і пішохід.
118	uk	Вид зсередини автомобіля на дорогу. Попереду декілька автомобілів, гори та сонце.
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
article.view.photo-by	en	Photo By
article.view.photo-by	uk	Фото зроблено
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
admin.image-with-id-not-exist	en	Image with id %s not exist
admin.image-with-id-not-exist	uk	Зображення з id %s не існує
admin.data-success-saved	en	Data was successfully saved
admin.data-success-saved	uk	Дані успішно збережено
global.please-select	en	Please select
global.please-select	uk	Будь ласка, оберіть варіант
article.view.by	uk	Автор
article.view.by	en	Author
admin.audio-with-id-not-exist	en	Audio with id %s not exist
admin.audio-with-id-not-exist	uk	Аудіо з id %s не існує
admin.audio-translate-with-language-not-exist	en	Audio with id %s: translation for language %s does not exist
admin.audio-translate-with-language-not-exist	uk	Для аудіо з id %s перекладу мовою %s не існує
admin.data-success-delete	en	Data was successfully deleted
admin.data-success-delete	uk	Дані були успішно видалені
admin.could-not-delete	en	Could not delete, check error and try again
admin.could-not-delete	uk	Неможливо видалити, перевірте помилку та спробуйте знову
admin.article-with-id-not-exist	en	Article with id %s not exist
admin.article-with-id-not-exist	uk	Статті з id %s не існує
filter.limit	en	Limit
filter.limit	uk	Кількість
filter.direction	en	Direction
filter.direction	uk	Напрямок
filter.order-by	en	Order By
filter.order-by	uk	Сортувати за
created_at	en	Сreated at
created_at	uk	Дата створення
identifier	en	Identifier
identifier	uk	Ідентифікатор
desc	en	Descending
desc	uk	За спаданням
asc	en	Ascending
asc	uk	За зростанням
category.page.table.name	en	Category name
category.page.table.name	uk	Назва категорії
category.page.table.description	en	Category description
category.page.table.description	uk	Опис категорії
category.page.table.articles-count	en	Articles count
category.page.table.articles-count	uk	Кількість статей
category.page.name	en	Article categories
category.page.name	uk	Категорії статей
category.page.description	en	A page with a list of all categories in which articles are located. Choose the one that interests you and start reading the materials.
category.page.description	uk	Сторінка зі списком усіх категорій, в яких знаходяться статті. Оберіть, яка Вас цікавить і перейдіть до читання матеріалів.
admin.banner-with-id-not-exist	en	Banner with id %s not exist
admin.banner-with-id-not-exist	uk	Банера з id %s не існує
root.news-header	en	Read the latest news today
root.news-header	uk	Останні новини
root.statistic.name	en	A bit of statistics from Lawshield
root.statistic.name	uk	Трохи статистики від Lawshield
root.statistic.description	en	Our lawyers participated last month
root.statistic.description	uk	Наші юристи брали участь минулого місяця
root.statistic.body	en	                            <li class="list-group-item">30 - total cases</li>                             <li class="list-group-item">15 - releases within 3 hours after entering the case</li>                             <li class="list-group-item">10 - cases have been handled in courts of various levels                             </li>                             <li class="list-group-item">3 - favorable rulings for our clients</li>                             <li class="list-group-item">0 - negative rulings</li>
root.statistic.body	uk	<li class="list-group-item">30 – загальна кількість справ</li> <li class="list-group-item">15 – звільнення протягом 3 годин після надходження до справи</li> <li class="list-group-item">10 – справи розглядалися в судах різних рівнів </li> <li class="list-group-item">3 – сприятливі рішення для наших клієнтів</li> <li class="list-group-item">0 – негативні рішення</li>
root.ads.name	en	Advertisement on the site
root.ads.name	uk	Реклама на сайті
root.ads.body	en	Today, you have the opportunity to order any type of advertisement on our website with an                             additional <span class="text-white bg-success px-1">15% discount</span>. <a                                 href="#">Learn                                 more now!</a>
root.ads.body	uk	Сьогодні у вас є можливість замовити будь-який тип реклами на нашому веб-сайті з додатковою <span class="text-white bg-success px-1">15% знижкою</span>. <a href="#">Дізнайтеся більше зараз!</a>
menu.latest	en	Latest
menu.latest	uk	Останні
menu.traffic	en	Traffic
menu.traffic	uk	Дорожній рух
menu.legislative-changes	en	Legislative changes
menu.legislative-changes	uk	Законодавчі зміни
menu.all	en	All articles
menu.all	uk	 Усі матеріали
article.h2.publications	en	Last publications
article.h2.publications	uk	Останні публікації
menu.consultations	en	Consultations
menu.consultations	uk	Консультації
menu.judicial-practice	en	Judicial practice
menu.judicial-practice	uk	Юридична практика
menu.legal-framework	en	Legal framework
menu.legal-framework	uk	Правова база
menu.common-mistakes	en	Common mistakes
menu.common-mistakes	uk	Поширені помилки
menu.traffic-vehicle-stop	en	Vehicle stop
menu.traffic-vehicle-stop	uk	Зупинка транспортного засобу
footer.by_romanenko	en	by Romanenko Serhii, the copyright for the media files and text belongs to the indicated authors.
footer.by_romanenko	uk	належить Романенко Сергію, авторське право на медіа файли та текст належить вказаним авторам
footer.copyright	en	Copyright for the site code and design
footer.copyright	uk	Авторські права на код та дизайн сайту
menu.administrative-process	en	Administrative Process
menu.administrative-process	uk	Адміністративний процес
menu.administrative-detention	en	Administrative detention
menu.administrative-detention	uk	Адміністративне затримання
menu.evidence	en	Evidence
menu.evidence	uk	Докази
menu.military-law	en	Military law
menu.military-law	uk	Військове право
menu.military-medical-commission	en	Military Medical Commission
menu.military-medical-commission	uk	Військово-лікарська комісія
menu.military-registration-document	en	Military registration document
menu.military-registration-document	uk	Військовий обліковий документ
menu.reservation	en	Reservation
menu.reservation	uk	Бронювання
404.description	en	Requested page was not found on our server
404.description	uk	Запитана сторінка не знайдена на нашому сервері
admin.category-with-id-not-exist	en	Category with id %s does not exist
admin.category-with-id-not-exist	uk	Категорії з id %s не існує
most-visited.h1	en	Most Visited
most-visited.h1	uk	Найбільш відвідувані
comments	en	comments
comments	uk	коментарі
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
admin.audio-with-id-not-exist
admin.audio-translate-with-language-not-exist
admin.data-success-delete
admin.could-not-delete
admin.article-with-id-not-exist
filter.limit
filter.direction
filter.order-by
created_at
identifier
desc
asc
category.page.table.name
category.page.table.description
category.page.table.articles-count
category.page.name
category.page.description
admin.banner-with-id-not-exist
root.news-header
root.statistic.name
root.statistic.description
root.statistic.body
root.ads.name
root.ads.body
menu.latest
menu.traffic
menu.legislative-changes
menu.all
menu.consultations
menu.judicial-practice
menu.legal-framework
menu.common-mistakes
menu.traffic-vehicle-stop
menu.administrative-process
menu.administrative-detention
menu.evidence
menu.military-law
menu.military-medical-commission
menu.military-registration-document
menu.reservation
admin.category-with-id-not-exist
most-visited.h1
comments
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

SELECT pg_catalog.setval('public.audio_identifier_seq', 69, true);


--
-- Name: author_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.author_identifier_seq', 53, true);


--
-- Name: banner_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.banner_identifier_seq', 10, true);


--
-- Name: img_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.img_identifier_seq', 124, true);


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
-- Name: banner banner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.banner
    ADD CONSTRAINT banner_pkey PRIMARY KEY (identifier);


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
-- Name: img img_path_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.img
    ADD CONSTRAINT img_path_unique UNIQUE (path);


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
    ADD CONSTRAINT article_category_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.category(identifier) ON UPDATE CASCADE ON DELETE CASCADE;


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
-- Name: banner banner_img_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.banner
    ADD CONSTRAINT banner_img_id_fkey FOREIGN KEY (img_id) REFERENCES public.img(identifier) ON UPDATE CASCADE;


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

