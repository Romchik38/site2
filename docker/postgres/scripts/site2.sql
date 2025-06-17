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
-- Name: banner; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.banner (
    identifier integer NOT NULL,
    active boolean DEFAULT false NOT NULL,
    name text NOT NULL,
    img_id integer NOT NULL
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

COPY public.article (identifier, active, author_id, img_id, audio_id) FROM stdin;
simplification-of-the-drivers-license-examination-process	t	1	1	1
evidence-in-administrative-offense-cases-key-aspects	t	1	3	3
document-verification-for-drivers	t	1	2	2
increase-fines-for-speeding-violations-2025	t	18	87	46
article-9	t	1	86	44
\.


--
-- Data for Name: article_category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article_category (article_id, category_id) FROM stdin;
simplification-of-the-drivers-license-examination-process	traffic
evidence-in-administrative-offense-cases-key-aspects	administrative-process
document-verification-for-drivers	traffic
increase-fines-for-speeding-violations-2025	traffic
article-9	test-category
\.


--
-- Data for Name: article_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.article_translates (article_id, language, name, description, created_at, updated_at, short_description) FROM stdin;
document-verification-for-drivers	en	Document Verification for Drivers	<h1>Document Verification for Drivers by Police Officers: Updated Requirements and Procedures</h1><p>Since the beginning of 2024, important changes to the legislation regarding the verification of documents for vehicle drivers have come into force in Ukraine. These amendments to the Law of Ukraine "On the National Police" were introduced to improve road safety, reduce the level of offenses, and enhance the procedure for driver-police interaction during roadside checks.</p> <h2>Main Reasons for Document Verification</h2><p>Verifying drivers' documents is one of the key functions of the National Police, carried out to maintain public safety and order on the roads. The law stipulates that police officers have the right to stop vehicles and request the presentation of documents in the following cases:</p> <ul> <li><strong>Violation of traffic rules (TAC)</strong>. This is the most common reason for stopping vehicles. If a driver violates established rules, the police officer has the right to demand the presentation of a driver's license, vehicle registration documents, and insurance policies.</li> <li><strong>Suspicion of technical malfunction of the vehicle</strong>. If the vehicle appears faulty or poses a danger to other road users, the police officer may stop the vehicle for a technical check and document verification.</li> <li><strong>Conducting special operations</strong>. The National Police have the right to check drivers' documents as part of special operations, such as searching for stolen vehicles or criminals.</li> <li><strong>Suspicion of a criminal offense</strong>. If the driver or passengers are suspected of being involved in a criminal offense, the police officer may request documents to confirm their identity and the legality of the vehicle use.</li> <li><strong>Alcohol or drug intoxication</strong>. If the police officer has grounds to believe that the driver is intoxicated, they may stop the vehicle for document verification and direct the driver for a medical examination.</li> </ul> <h2>Documents Drivers Must Present</h2> <p>The law defines a list of documents that the driver is required to carry and present at the request of the police:</p> <ul> <li>A driver's license of the appropriate category.</li> <li>A vehicle registration certificate.</li> <li>A mandatory civil liability insurance policy for vehicle owners (MTPL).</li> <li>For commercial vehicle drivers, additional documents confirming the right to carry out transportation are required.</li> </ul> <h2>Verification Procedure</h2> <p>According to the updated legal norms, the police officer is required to verify the documents strictly within the scope of their powers and in accordance with established procedures. During the vehicle stop, the police officer must identify themselves, state their position, and explain the reason for the stop. The driver, in turn, has the right to know why they were stopped and may ask for clarification on the reasons for the document check.</p> <p>The police officer does not have the right to demand documents from the driver without explaining the reason for the stop or in the absence of legal grounds for the check. Additionally, the driver has the right to record the actions of the police officers using video or audio recording, which helps ensure transparency and compliance with the rights of all road users.</p> <h2>Refusal to Present Documents and Its Consequences</h2> <p>Refusal by the driver to present documents to the police is considered an administrative offense, which can have serious consequences. According to the Code of Administrative Offenses of Ukraine, a driver who refuses to present documents at the request of a police officer may be fined or even temporarily deprived of the right to drive the vehicle.</p> <p>Moreover, attempting to flee from the police or refusing to comply with their lawful demands can lead to more serious legal consequences, including detention or prosecution for resisting law enforcement officers.</p> <h2>Drivers' Rights and Responsibilities During Document Checks</h2> <p>Drivers have several rights during document checks:</p> <ul> <li>To know the reason for the stop and the purpose of the check.</li> <li>To request the police officer's identification.</li> <li>To record interactions with police officers using video or audio devices.</li> <li>To challenge the actions of the police if their powers are violated.</li> </ul> <p>At the same time, drivers are required to:</p> <ul> <li>Present documents at the request of the police officer.</li> <li>Comply with the lawful demands of law enforcement officers.</li> <li>Maintain public order and not obstruct the police in performing their duties.</li> </ul> <h2>New Technologies in Document Verification</h2> <p>With the introduction of digital technologies, the National Police increasingly use electronic means to verify documents. Drivers can present documents in the form of digital copies through the "Diia" app. This significantly simplifies the verification process, as it allows drivers to store all necessary documents electronically and quickly provide them at the police officer's request.</p> <h2>Conclusion</h2> <p>The updated rules for document verification for drivers introduced in Ukraine aim to improve road safety and ensure proper control over compliance with traffic rules. Drivers should be aware of their rights and obligations, as well as comply with the lawful demands of the police to avoid misunderstandings and legal consequences during checks.</p>	2024-10-27 11:48:50	2024-10-27 11:48:50	Since the beginning of 2024, important changes to the legislation regarding the verification of documents for vehicle drivers have come into force in Ukraine. These amendments to the Law of Ukraine "On the National Police" were introduced to improve road safety, reduce the level of offenses, and enhance the procedure for driver-police interaction during roadside checks.
document-verification-for-drivers	uk	Перевірка документі у водіїв транспортних засобів	<h2>Перевірка документів у водіїв працівниками поліції: оновлені вимоги та процедури</h2>\r\n<p>З початку 2024 року в Україні набули чинності важливі зміни до законодавства, що стосуються перевірки документів у водіїв транспортних засобів. Відповідні правки до Закону України «Про Національну поліцію» були внесені для підвищення безпеки на дорогах, зниження рівня правопорушень та вдосконалення процедури взаємодії водіїв із поліцейськими під час дорожніх перевірок.</p>\r\n<h3>Основні причини для перевірки документів</h3>\r\n<ul>Перевірка документів водіїв є однією з важливих функцій Національної поліції, що виконується з метою підтримання громадської безпеки та порядку на дорогах. Закон передбачає, що поліцейські мають право зупиняти транспортні засоби та вимагати у водіїв пред'явлення документів у таких випадках:\r\n    <li>Порушення правил дорожнього руху (ПДР). Це найбільш поширена причина зупинки автомобілів. Якщо водій порушує встановлені правила, поліцейський має право вимагати пред'явити посвідчення водія, реєстраційні документи на транспортний засіб та страхові поліси.</li>\r\n    <li>Виникнення підозри щодо технічної несправності транспортного засобу. Якщо автомобіль виглядає несправним або створює небезпеку для інших учасників руху, поліцейський може зупинити транспорт для перевірки технічного стану та документів.</li>\r\n    <li>Проведення спеціальних заходів. Національна поліція має право перевіряти документи у водіїв у рамках спеціальних операцій, наприклад, пошуку викрадених автомобілів або злочинців.</li>\r\n    <li>Підозра у вчиненні кримінального правопорушення. Якщо водія або пасажирів підозрюють у причетності до кримінального правопорушення, поліцейський може вимагати документи для підтвердження їх особи та законності використання транспортного засобу.</li>\r\n    <li>Стан алкогольного або наркотичного сп'яніння. Якщо у поліцейського є підстави вважати, що водій перебуває у стані сп'яніння, його можуть зупинити для перевірки документів та направлення на медичний огляд.</li>\r\n</ul>\r\n<h3>Документи, які необхідно пред'являти водіям</h3>\r\n<ul>Закон визначає перелік документів, які водій зобов'язаний мати при собі та пред'являти на вимогу поліцейських:\r\n    <li>Посвідчення водія відповідної категорії.</li>\r\n    <li>Свідоцтво про реєстрацію транспортного засобу.</li>\r\n    <li>Поліс обов'язкового страхування цивільно-правової відповідальності власників транспортних засобів (ОСЦПВ).</li>\r\n    <li>Для водіїв комерційних транспортних засобів додатково потрібно мати документи, що підтверджують дозвіл на здійснення перевезень.</li>\r\n</ul>\r\n<h3>Процедура перевірки</h3>\r\n<p>Згідно з оновленими нормами закону, поліцейський зобов'язаний здійснювати перевірку документів виключно в рамках своїх повноважень та у відповідності до встановлених процедур. Під час зупинки транспортного засобу поліцейський повинен представитися, назвати свою посаду та причину зупинки. Водій, у свою чергу, має право знати, чому його зупинили, і може попросити пояснення причин перевірки документів.</p>\r\n<p>Поліцейський не має права вимагати у водія документи без пояснення причини зупинки або за відсутності законних підстав для перевірки. Крім того, водій має право фіксувати дії поліцейських за допомогою відео- або аудіозапису, що допомагає забезпечити прозорість та дотримання прав усіх учасників дорожнього руху.</p>\r\n<h3>Відмова від пред'явлення документів та її наслідки</h3>\r\n<p>Відмова водія від пред'явлення документів поліцейським розглядається як адміністративне правопорушення, яке може мати серйозні наслідки. Відповідно до Кодексу України про адміністративні правопорушення, водію, який відмовився пред'явити документи на вимогу поліцейського, може бути винесено штраф або навіть тимчасове позбавлення права керування транспортним засобом.</p>\r\n<p>Крім того, спроба втечі від поліцейських або відмова від виконання їх законних вимог може призвести до більш серйозних правових наслідків, включно із затриманням або притягненням до відповідальності за опір правоохоронцям.</p>\r\n<h3>Права та обов'язки водіїв під час перевірки документів</h3>\r\n<ul>Водій має ряд прав під час перевірки документів:\r\n    <li>Знати причину зупинки та мету перевірки.</li>\r\n    <li>Вимагати пред'явлення службового посвідчення поліцейського.</li>\r\n    <li>Фіксувати взаємодію з поліцейськими на відео чи аудіо.</li>\r\n    <li>Оскаржити дії поліцейських у разі порушення їхніх повноважень.</li>\r\n</ul>\r\n<ul>Водночас водій зобов'язаний:\r\n<li>Надавати документи на вимогу поліцейського.</li>\r\n    <li>Дотримуватися законних вимог правоохоронців.</li>\r\n    <li>Не порушувати громадський порядок та не перешкоджати виконанню службових обов'язків поліцейських.</li>\r\n</ul>\r\n<h3>Нові технології у перевірці документів</h3>\r\n<p>Із впровадженням цифрових технологій Національна поліція дедалі частіше використовує електронні засоби перевірки документів. Водії можуть пред'являти документи у вигляді цифрових копій через додаток «Дія». Це значно спрощує процес перевірки, оскільки дозволяє зберігати всі необхідні документи в електронному вигляді та швидко надавати їх на вимогу поліцейських.</p>\r\n<h3>Висновок</h3>\r\n<p>Оновлені правила перевірки документів у водіїв, введені в Україні, спрямовані на підвищення безпеки на дорогах та забезпечення належного контролю за дотриманням правил дорожнього руху. Водії повинні знати свої права та обов'язки, а також дотримуватися законних вимог поліцейських, щоб уникнути непорозумінь та правових наслідків під час перевірок.</p>	2024-10-31 19:14:03	2025-06-12 17:55:11	З початку 2024 року в Україні набули чинності важливі зміни до законодавства в сфері перевірки документів у водіїв працівниками поліції: оновлені вимоги та процедури
article-9	en	Test Article	<p>Every day we encounter countless texts — in the news, on social media, in documents, or even in everyday conversations. But before publishing any material, especially on official or public platforms, it’s essential to test the text. That’s exactly what a test article is for.<br><br>A test article is a sample or draft text used to check various aspects: structure, formatting, technical layout, adaptability to different publication formats, and sometimes even the overall writing quality. It can contain real content or placeholder text similar to "Lorem ipsum." However, more often than not, a test article carries meaningful content to better reflect logical flow.<br><br>The purpose of creating such an article can include: </p><ol><li>Layout testing. Designers and web developers often use test texts to see how content will look in different areas of a website: headings, paragraphs, lists, quotes, and so on.</li><li>Reader perception. Editors and authors may use them to evaluate how readable the text is, and whether it matches a specific style, tone, or genre. </li><li>Platform launch preparation. When a new portal, blog, or informational resource is being built, it's wise to test the content management system (CMS), article placement, and internal navigation before publishing real content. </li><li>Educational purposes. Test articles are commonly used in copywriting, journalism, SMM, or content marketing courses to practice writing and editing skills. </li></ol><p>Another interesting aspect of test articles is their versatility. The topic can be anything: from event reviews to product instructions. What matters is having a structured and cohesive format. Sometimes the texts are written manually; other times they’re automatically generated. Regardless of their origin, it’s important that they reflect real-life content conditions.<br><br>For example, if the website focuses on educational material, the test article should include more complex paragraphs, terminology, and source citations. On a commercial platform, it would make sense to insert sample CTAs (calls to action), placeholders for contact info, or ad banners.<br><br>In this way, a test article is more than just a random collection of words. It’s a crucial tool in the process of preparing high-quality content. It helps identify and fix issues before the real text reaches the audience. And although the term “test” may imply something temporary or secondary, its role in building an effective information environment is hard to overestimate.</p>	2024-11-12 17:54:44	2025-06-09 17:55:02	In today’s world, information plays an incredibly important role
simplification-of-the-drivers-license-examination-process	en	Simplification of the driver's license examination process	<p>Important amendments to Ukraine's traffic rules, which came into effect in 2024, aim to increase road safety and reduce the number of accidents. One of the key innovations is the mandatory use of daytime running lights outside populated areas throughout the year. Previously, drivers were only required to use running lights in the autumn-winter period (from October 1 to May 1), but now this rule is in effect year-round. The decision is aimed at making vehicles more visible to other road users regardless of weather conditions or lighting levels.</p><h2>The Importance of Using Running Lights</h2><p>Headlights reduce the risk of accidents by improving the visibility of cars on the road, especially in poor weather conditions such as rain or fog. Lighting devices help quickly identify approaching vehicles, especially on roads with heavy traffic. Thus, the decision to make running lights mandatory outside the city year-round is fully justified. According to research, the visibility of a car with headlights on can improve the reaction of other drivers and pedestrians by 20-25%, reducing the risk of collisions.</p><h2>Rule Compliance Check</h2><p>The new requirements stipulate that the police can now monitor compliance with this rule on roads outside populated areas. Drivers who ignore this requirement face fines. Since the continuous use of running lights is becoming mandatory, additional control by the police is expected, along with the installation of new surveillance cameras capable of recording violations remotely.</p>	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	The process of obtaining a driver's license has also changed for future drivers. From now on, candidates can take the theoretical exam without mandatory attendance at driving school courses. This reduces the financial burden on candidates and allows them to prepare for exams independently. However, practical training remains an important step that must be completed before obtaining a driver's license.
simplification-of-the-drivers-license-examination-process	uk	Спрощення процесу складання іспитів на права	<p>У 2024 році в Україні було запроваджено зміни, які спрощують процес складання іспитів на отримання водійських прав. Основне нововведення полягає в тому, що тепер кандидати у водії можуть складати теоретичний іспит без обов'язкового навчання в автошколі. Це значне полегшення для тих, хто має базові знання з правил дорожнього руху та здатний самостійно підготуватися до іспиту.</p>\n<h2>Мета змін</h2> \nЗміни спрямовані на зменшення фінансового навантаження на громадян, адже навчання в автошколах може бути досить витратним. Наразі багато громадян мають можливість навчатися самостійно за допомогою онлайн-ресурсів або спеціалізованих додатків для вивчення ПДР. Скасування обов’язкових курсів у автошколах також робить процес отримання прав більш доступним, особливо для людей з обмеженими фінансовими можливостями або тих, хто не має часу на відвідування навчальних закладів.</p> \n<p>Особливості нового підходу У нових правилах передбачено, що кандидати можуть самостійно обирати метод підготовки до теоретичного іспиту. Однак вимоги до практичних навичок залишаються незмінними, і для отримання права керувати транспортним засобом необхідно пройти практичне навчання в автошколі та скласти відповідний іспит. Це дозволяє зберегти необхідний рівень безпеки на дорогах, адже управління транспортом вимагає не лише знань теорії, але й певного рівня практичної підготовки під наглядом інструктора.</p> \n<h2>Економія часу та ресурсів</h2> \n<p>Введення можливості самопідготовки до теоретичного іспиту також скорочує час, необхідний для отримання водійських прав. Раніше кандидати були зобов’язані відвідувати курси в автошколах, які могли тривати кілька місяців. Тепер же, якщо людина вже володіє знаннями або швидко засвоює матеріал, вона може скласти іспит значно швидше. Це дозволяє уникнути довгих черг в автошколах та забезпечує більш оперативний процес отримання водійського посвідчення.</p> \n<h2>Виклики нової системи</h2> \n<p>Проте спрощення вимог до теоретичного навчання може мати як позитивні, так і негативні наслідки. Деякі експерти вважають, що недостатня підготовка теоретичної частини може призвести до підвищеного ризику на дорогах. Незважаючи на це, держава розраховує на відповідальність майбутніх водіїв, а також на розвиток сучасних інструментів для самостійного навчання. Зокрема, розроблено численні додатки та онлайн-платформи, які дозволяють ефективно та якісно готуватися до теоретичних іспитів.</p>\n<h2>Відгуки громадськості</h2> \n<p>Зміни в процесі підготовки до іспитів викликали різні реакції в суспільстві. Багато людей вважають, що спрощення умов навчання полегшить доступ до водійських прав і позитивно вплине на мобільність громадян. Водночас є й ті, хто висловлює занепокоєння через можливість зниження загального рівня знань серед нових водіїв. У відповідь на це Міністерство внутрішніх справ заявляє, що система буде постійно контролюватися, а кількість аварій з вини новачків буде аналізуватися, щоб оцінити ефективність нових правил.</p>\n<h2>Очікувані результати</h2> \n<p>Запроваджені зміни можуть сприяти не лише зменшенню витрат часу і коштів для майбутніх водіїв, але й зниженню навантаження на автошколи та підвищенню доступності водійських прав для широкого кола громадян. Доступність та демократизація навчання на права, зокрема, дозволяють розширити коло тих, хто може законно керувати транспортним засобом, не вдаючись до послуг дорогих курсів. Завдяки цьому у майбутньому очікується підвищення загального рівня мобільності в країні, що особливо актуально для регіонів, де якісні автошколи можуть бути обмежені або недоступні. Таким чином, спрощення процесу складання теоретичних іспитів у 2024 році можна вважати кроком до більш доступного і демократичного процесу отримання водійських прав в Україні.</p>	2024-11-12 17:54:44.091927	2024-11-12 17:54:44.091927	Для майбутніх водіїв процес отримання прав також зазнав змін. Відтепер кандидати можуть складати теоретичний іспит без обов’язкового відвідування курсів в автошколах. Це зменшує фінансове навантаження на кандидатів і дозволяє їм готуватися до екзаменів самостійно. Однак практична підготовка залишається важливим етапом, який необхідно пройти перед отриманням посвідчення водія.
article-9	uk	Тестова стаття	<p class="">Щодня ми стикаємося з безліччю текстів — у новинах, соціальних мережах, документах чи навіть у побутовому спілкуванні. Але перед тим, як публікувати будь-який матеріал, особливо якщо йдеться про офіційні чи публічні джерела, необхідно провести тестування тексту. Саме з цією метою часто створюється тестова стаття</p><p class="">Тестова стаття — це умовний або пробний текст, який використовується для перевірки різних аспектів: структури, оформлення, технічної верстки, адаптації до різних форматів публікації, а іноді й для оцінки загальної якості написання. Вона може містити як справжній зміст, так і умовний текст, подібний до «Lorem ipsum». Однак найчастіше тестова стаття все ж має сенсове навантаження, що дозволяє краще відчути логіку викладу.</p><p class="">Метою створення такої статті може бути:</p><ol><li><strong data-start="957" data-end="979">Перевірка верстки.</strong> Дизайнери та розробники сайтів часто використовують тестові тексти, щоби побачити, як виглядатиме матеріал у різних блоках сайту: заголовки, абзаци, списки, цитати тощо.</li><li><strong data-start="1153" data-end="1186">Оцінка читацького сприйняття.</strong> Редактори й автори можуть перевіряти, наскільки текст є зручним для читання, чи відповідає він певному стилю, тону або жанру.</li><li><strong data-start="1316" data-end="1352">Підготовка до запуску платформи.</strong> Коли створюється новий портал, блог або інформаційний ресурс, перш ніж наповнювати його реальним контентом, варто протестувати систему управління вмістом (CMS), розміщення матеріалів, внутрішню навігацію.</li><li><strong data-start="1561" data-end="1580">Навчальні цілі.</strong> Тестові статті часто використовуються на курсах копірайтингу, журналістики, SMM або контент-маркетингу для тренування навичок написання та редагування.</li></ol><p>Ще один цікавий аспект тестових статей — це їхня універсальність. Тема може бути будь-якою: від огляду подій до інструкцій із використання певного сервісу. Головне — дотримання структури та загального відчуття цілісності. Іноді тестові тексти пишуться повністю вручну, іноді — генеруються автоматично. Але незалежно від походження, важливо, щоб вони відповідали реальним умовам роботи з текстом.</p><p data-start="2131" data-end="2400">Наприклад, якщо сайт орієнтований на освітній контент, тестова стаття має містити складніші абзаци, термінологію, посилання на джерела. Якщо ж це комерційна платформа, доцільно вставити умовні CTA (заклики до дії), перевірити місце для контактної інформації чи банерів.</p>\r\n<p data-start="2402" data-end="2765">Таким чином, тестова стаття — це не просто набір випадкових слів. Це важливий інструмент у процесі підготовки якісного контенту. Вона дозволяє знайти та виправити недоліки ще до того, як справжній текст потрапить до читача. І хоча її назва натякає на тимчасовість або допоміжну функцію, її роль у створенні ефективного інформаційного простору складно переоцінити.</p><p><br></p>	2024-11-12 17:54:44	2025-06-09 17:52:53	У сучасному світі інформація відіграє надзвичайно важливу роль
increase-fines-for-speeding-violations-2025	en	Ukraine Plans to Increase Fines for Speeding Violations	<p>Members of the Verkhovna Rada intend to raise fines for drivers who exceed speed limits and eliminate the current tolerance of "+20 km/h." These changes are outlined in Draft Law No. 13314 dated May 26, 2025, titled "On Amendments to the Code of Ukraine on Administrative Offenses Regarding the Introduction of Proportional Liability for Exceeding Established Vehicle Speed Limits."<br><br>The draft is based on the premise that excessive speed is a leading cause of fatalities and injuries resulting from traffic accidents. Lawmakers argue that the Code of Administrative Offenses (CUoAO) fails to fulfill one of its main functions: preventing administrative violations, particularly those related to speeding.<br><br>They cite a survey in which 54% of Ukrainians reportedly support lowering the penalty threshold by 10 km/h. However, a closer look reveals that only 28% fully support the proposed changes.<br><br>The proposed fine structure is as follows:<br><br>No.&nbsp; &nbsp; Speed Limit Exceeded&nbsp; &nbsp; Fine<br>1&nbsp; &nbsp; &gt;10 km/h&nbsp; &nbsp; 340 UAH<br>2&nbsp; &nbsp; &gt;20 km/h&nbsp; &nbsp; 680 UAH<br>3&nbsp; &nbsp; &gt;30 km/h&nbsp; &nbsp; 1,360 UAH<br>4&nbsp; &nbsp; &gt;40 km/h&nbsp; &nbsp; 1,700 UAH<br>5&nbsp; &nbsp; &gt;60 km/h&nbsp; &nbsp; 2,720 UAH<br>6&nbsp; &nbsp; &gt;80 km/h&nbsp; &nbsp; 3,400 UAH<br>7&nbsp; &nbsp; Any of the above (1–6) that causes a hazardous situation&nbsp; &nbsp; License suspension for 6 to 12 months<br><br>Lawmakers aim to reduce the traffic fatality rate by 35%, using Poland’s experience over the past four years as an example. As a reference point, they note that 1,770 people died in 2024 in Ukraine as a result of speeding-related accidents.</p>	2025-06-15 13:38:03	2025-06-15 13:38:03	Fines for speeding are set to rise in proportion to how much a driver exceeds the speed limit
increase-fines-for-speeding-violations-2025	uk	В Україні планують підвищити розміри штрафів за порушення швидкісного режиму	<p>Депутати Верховної Ради планують збільшити штрафи водіям за перевищення швидкості та прибрати «плюс 20 км/год». Це передбачається Проектом Закону 13314 від 26.05.2025 "Про внесення змін до Кодексу України про адміністративні правопорушення щодо запровадження пропорційності відповідальності за перевищення встановлених обмежень швидкості руху транспортних засобів".<br><br>Проєкт ґрунтується на тому, що надмірна швидкість є основною причиною смертності та травмування внаслідок ДТП. Депутати стверджують, що КУпАП не виконує одного із основних завдань – запобігати<br>адміністративним правопорушенням, зокрема, які пов’язані із перевищенням швидкості. Депутати приводять опитування, в якому стверджується, що 54% українців погоджують зниження порогу на 10 км для застосування штрафів. Але якщо подивитись опитування, то це не зовсім так. Тільки 28% повністю підтримують нововведення.<br><br>Пропонується така градація:<br>№ Розмір перевищення швидкості руху - Відповідальність<br>1 &gt;10 км/год 340 грн&nbsp;<br>2 &gt;20 км/год 680 грн&nbsp;<br>3 &gt;30 км/год 1360 грн&nbsp;<br>4 &gt;40 км/год 1700 грн&nbsp;<br>5 &gt;60 км/год 2720 грн&nbsp;<br>6 &gt;80 км/год 3400 грн&nbsp;<br>7 Перевищення у п.1 – 6 цієї таблиці, що спричинило створення аварійної обстановки - позбавлення права керування на строк від 6 місяців до 1 року.<br><br>Депутати планують знизити процент смертності на 35% на прикладі Польщі за 4 останніх роки. В якості відправної точки вони вказуть смерті 1770 людини які сталися у 2024 році в результаті перевищення швидкості.</p>	2025-06-15 13:38:03	2025-06-15 13:51:14	Сума штрафу зростатиме пропорційно до величини перевищення дозволеної швидкості
evidence-in-administrative-offense-cases-key-aspects	uk	Докази по справі про адміністративне правопорушення: ключові аспекти	        <div>\r\n            <h2>Поняття та види доказів</h2>\r\n            <p>Докази – це будь-які фактичні дані, які підтверджують або спростовують обставини, що мають значення для справи. Вони фіксуються у встановленому законом порядку та визначаються процесуальними нормами.</p>\r\n            <ul>\r\n                <li><strong>Протокол про адміністративне правопорушення</strong> – основний документ, який фіксує факт правопорушення.</li>\r\n                <li><strong>Письмові докази</strong> – документи, акти перевірок, звіти тощо.</li>\r\n                <li><strong>Речові докази</strong> – матеріальні об’єкти, пов’язані з правопорушенням.</li>\r\n                <li><strong>Пояснення осіб</strong> – свідчення правопорушника, потерпілих чи свідків.</li>\r\n                <li><strong>Фото-, відео- та аудіоматеріали</strong> – технічні записи, що фіксують обставини правопорушення.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Процес збирання доказів</h2>\r\n            <p>Збирання доказів здійснюється органами, уповноваженими складати протоколи та розглядати справи, такими як Національна поліція, митні служби, екологічні інспекції тощо. Дотримання законності при зборі доказів є ключовою умовою їх допустимості.</p>\r\n        </div>\r\n        <div>\r\n            <h2>Оцінка доказів</h2>\r\n            <p>Згідно зі ст. 252 КУпАП, орган, що розглядає справу, оцінює докази за внутрішнім переконанням, заснованим на повному та об’єктивному дослідженні. Основні принципи оцінки:</p>\r\n            <ul>\r\n                <li><strong>Належність</strong> – доказ повинен мати зв’язок з обставинами справи.</li>\r\n                <li><strong>Допустимість</strong> – доказ має бути отриманий у встановленому порядку.</li>\r\n                <li><strong>Достатність</strong> – сукупність доказів має бути достатньою для прийняття рішення.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Права сторін у справі</h2>\r\n            <p>Особи, які беруть участь у справі, мають право:</p>\r\n            <ul>\r\n                <li>Подавати власні докази.</li>\r\n                <li>Заявляти клопотання про витребування додаткових доказів.</li>\r\n                <li>Знайомитися з матеріалами справи.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Типові проблеми</h2>\r\n            <p>На практиці часто виникають такі проблеми:</p>\r\n            <ul>\r\n                <li>Неправильне складання протоколу.</li>\r\n                <li>Недостатність доказів.</li>\r\n                <li>Оскарження допустимості доказів.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Висновок</h2>\r\n            <p>Докази є основою прийняття рішень у справах про адміністративні правопорушення. Дотримання принципів належності, допустимості та достатності забезпечує законність і обґрунтованість рішень, що сприяє зміцненню правової держави.</p>\r\n        </div>	2024-11-05 13:40:26	2025-06-10 12:10:06	Докази у справі про адміністративне правопорушення є основним інструментом для встановлення об’єктивної істини та прийняття законного і обґрунтованого рішення.
evidence-in-administrative-offense-cases-key-aspects	en	Evidence in Administrative Offense Cases: Key Aspects	        <div>\r\n            <h2>Definition and Types of Evidence</h2>\r\n            <p>Evidence is any factual information that confirms or refutes circumstances relevant to a case. It is recorded in accordance with legal procedures and defined by procedural norms.</p>\r\n            <ul>\r\n                <li><strong>Administrative Offense Protocol</strong> – the primary document recording the offense.</li>\r\n                <li><strong>Written Evidence</strong> – documents, inspection reports, records, etc.</li>\r\n                <li><strong>Material Evidence</strong> – physical objects linked to the offense.</li>\r\n                <li><strong>Explanations from Individuals</strong> – testimonies from the offender, victims, or witnesses.</li>\r\n                <li><strong>Photo, Video, and Audio Materials</strong> – technical recordings capturing the circumstances of the offense.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Evidence Collection Process</h2>\r\n            <p>Evidence is collected by authorized bodies, such as the National Police, customs authorities, or environmental inspections. Compliance with legal procedures during evidence collection ensures its admissibility in court.</p>\r\n        </div>\r\n        <div>\r\n            <h2>Evaluation of Evidence</h2>\r\n            <p>Under Article 252 of the Code of Administrative Offenses, evidence is evaluated by the authority reviewing the case based on comprehensive, objective, and thorough consideration. Key principles include:</p>\r\n            <ul>\r\n                <li><strong>Relevance</strong> – evidence must directly relate to the case.</li>\r\n                <li><strong>Admissibility</strong> – evidence must be obtained legally.</li>\r\n                <li><strong>Sufficiency</strong> – the body of evidence must be enough to establish the truth.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Rights of the Parties</h2>\r\n            <p>Parties involved in the case have the right to:</p>\r\n            <ul>\r\n                <li>Submit their own evidence.</li>\r\n                <li>Request additional evidence.</li>\r\n                <li>Review case materials.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Common Challenges</h2>\r\n            <p>Typical issues that arise include:</p>\r\n            <ul>\r\n                <li>Errors in protocol preparation.</li>\r\n                <li>Insufficient evidence.</li>\r\n                <li>Disputes over the admissibility of evidence.</li>\r\n            </ul>\r\n        </div>\r\n        <div>\r\n            <h2>Conclusion</h2>\r\n            <p>Evidence forms the foundation for decisions in administrative offense cases. Adherence to principles of relevance, admissibility, and sufficiency ensures lawful and justified resolutions, contributing to a stronger rule of law.</p>\r\n        </div>	2024-10-26 12:28:44	2025-06-10 12:10:06	Definition and Types of Evidence, Evidence Collection Process, Evaluation.
\.


--
-- Data for Name: audio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio (identifier, active, name) FROM stdin;
3	t	Audio for article - Evidence in administrative offense cases key aspects
2	t	Audio for article - Document verification for drivers
1	t	Audio for article - Simplification of the drivers license examination process
44	t	test audio
46	t	Ukraine Plans to Increase Fines for Speeding Violations
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
44	en	test track	articles/x1Em4itufDIGoYrcHuXf.mp3
44	uk	Тестовий трек для статті	articles/MTsZCc4rD6sGq7aUjkw6.mp3
46	en	Ukraine Plans to Increase Fines for Speeding Violations	articles/O1bvRPHX8BETSlbDuZkk.mp3
46	uk	В Україні планують підвищити розміри штрафів за порушення швидкісного режиму	articles/Jkyn4R1Wwf18Qgdls3fl.mp3
\.


--
-- Data for Name: author; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author (identifier, name, active) FROM stdin;
3	Freepik	t
2	Depositphotos	t
1	AI	t
18	Test author 1	t
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
18	en	Test author
18	uk	Тестовий автор
\.


--
-- Data for Name: banner; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.banner (identifier, active, name, img_id) FROM stdin;
1	f	some banner	85
\.


--
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category (identifier, active) FROM stdin;
administrative-process	t
traffic	t
test-category	f
\.


--
-- Data for Name: category_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category_translates (category_id, language, name, description) FROM stdin;
administrative-process	en	Administrative Process 	Adjudication of administrative cases in courts, refers to the procedures and practices employed to resolve disputes arising from the application of administrative law
administrative-process	uk	Адміністративний процес	Адміністративно-процесуальними нормами врегульована діяльність публічної адміністрації, яка спрямована на застосування положень матеріального права під час розгляду та вирішення конкретних індивідуальних справ
traffic	en	Traffic law	Traffic law refers to the regulations and rules established by authorities to ensure the safe and efficient movement of vehicles and pedestrians on roads
traffic	uk	Законодавство про дорожній рух	Все про закони про дорожній рух які стосуються правил і норм, встановлених владою для забезпечення безпеки та ефективного руху транспортних засобів і пішоходів на дорогах
test-category	en	Test category	Test category desc
test-category	uk	Тестова категорія	Опис тестової категорії
\.


--
-- Data for Name: img; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img (identifier, name, author_id, path, active) FROM stdin;
2	document-verification-for-drivers	1	articles/perevirka-documentiv/1.webp	t
1	simplification-of-the-drivers-license-examination-process	2	articles/simplification-of-the-drivers-license-examination-process/1.webp	t
3	evidence-in-administrative-offense-cases-key-aspects	3	articles/dokazi-po-spravi/vidence-in-administrative-offense-cases-key-aspects.webp	t
4	stub-coming-soon-article-list-view	1	common/coming-soon-2000-2000.webp	t
86	Test image	1	articles/MtehBneVhhzq7UQmJZqZ.webp	t
85	Notes	3	common/43MIHt1Qk1PHeiIXiCTF.webp	f
87	Ukraine Plans to Increase Fines for Speeding Violations	1	articles/JC6uDKOhOTfTW4llZ7v6.webp	t
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
1	en	Simplification of the drivers license examination process last year
1	uk	Минулого року спрощено процедуру іспиту на отримання водійських прав
2	en	Document Verification for Drivers
2	uk	Перевірка документі у водіїв транспортних засобів
3	en	Evidence in Administrative Offense Cases: Key Aspects
3	uk	Докази по справі про адміністративне правопорушення: ключові аспекти
4	en	Coming soon
4	uk	Скоро буде
86	en	Test image
86	uk	Тестова картинка
85	en	Notes
85	uk	Замітки
87	en	Ukraine Plans to Increase Fines for Speeding Violations
87	uk	В Україні планують підвищити розміри штрафів за порушення швидкісного режиму
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

SELECT pg_catalog.setval('public.audio_identifier_seq', 46, true);


--
-- Name: author_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.author_identifier_seq', 53, true);


--
-- Name: banner_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.banner_identifier_seq', 1, true);


--
-- Name: img_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.img_identifier_seq', 87, true);


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

