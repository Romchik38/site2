--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: audio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio (identifier, active, name) FROM stdin;
1	t	Audio for article - Simplification of the drivers license examination process
2	t	Audio for article - Document verification for drivers
3	t	Audio for article - Evidence in administrative offense cases key aspects
\.


--
-- Data for Name: author; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author (identifier, name, active) FROM stdin;
2	Depositphotos	t
1	AI	t
3	Freepik	t
\.


--
-- Data for Name: img; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.img (identifier, name, author_id, path, active) FROM stdin;
2	document-verification-for-drivers	1	articles/perevirka-documentiv/1.webp	t
4	stub-coming-soon-article-list-view	1	common/coming-soon-2000-2000.webp	t
1	simplification-of-the-drivers-license-examination-process	2	articles/simplification-of-the-drivers-license-examination-process/1.webp	t
3	evidence-in-administrative-offense-cases-key-aspects	3	articles/dokazi-po-spravi/vidence-in-administrative-offense-cases-key-aspects.webp	t
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
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category (identifier, active) FROM stdin;
category-2	t
traffic	t
administrative-process	t
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
-- Data for Name: translate_lang; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translate_lang (language, active) FROM stdin;
en	t
uk	t
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
-- Data for Name: author_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.author_translates (author_id, language, description) FROM stdin;
1	en	AI
1	uk	Штучний інтелект
2	en	Depositphotos/Depositphotos.com
2	uk	Depositphotos/Depositphotos.com
3	en	Freepik
3	uk	Freepik
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
-- Data for Name: person; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.person (identifier, active) FROM stdin;
1	t
2	t
3	t
\.


--
-- Data for Name: person_translates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.person_translates (person_id, language, first_name, last_name, middle_name) FROM stdin;
1	en	Dmitro	Snigirev	\N
2	en	Ivan	Zatyajniy	\N
3	en	Serhii	Kolenko	\N
1	uk	Дмитро	Снігірьов	\N
2	uk	Іван	Затяжний	\N
3	uk	Сергій	Kolenko	\N
\.


--
-- Data for Name: translate_keys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translate_keys (key) FROM stdin;
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
\.


--
-- Data for Name: translate_entities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.translate_entities (entity_id, key, language, phrase) FROM stdin;
95	article.page_name	en	Materials on administrative law
96	article.page_name	uk	Матеріли на тему адміністративного права
97	article.description	en	We offer the latest materials analyzing legislative acts, court decisions, or procedures that regulate the activities of public authorities and their interaction with citizens. Such articles explain legal norms, their application, and their impact on social relations.
98	article.description	uk	Ми пропонуємо найсвіжіші матеріали, що аналізують законодавчі акти, судові рішення або процедури, які регулюють діяльність органів державної влади та взаємодію з громадянами. Такі статті пояснюють норми права, їх застосування та вплив на суспільні відносини.
99	article.h2.publications	en	Publications
100	article.h2.publications	uk	Публікації
101	read-length-formatter.a-few-minutes	en	a few minutes
102	read-length-formatter.a-few-minutes	uk	декілька хвилин
103	read-length-formatter.min	en	min
104	read-length-formatter.min	uk	хв
105	read-length-formatter.hour	en	h
106	read-length-formatter.hour	uk	год
107	read-length-formatter.day	en	d
108	read-length-formatter.day	uk	доба
109	article.read	en	read
110	article.read	uk	читати
111	header.link.sitemap	en	Sitemap
112	header.link.sitemap	uk	Мапа сайту
113	article.view.seeall	en	see all
114	article.view.seeall	uk	подивитись усі
115	article.view.photo-by	en	Photo By
116	article.view.photo-by	uk	Фото зроблено
119	article.view.by	uk	Автор
120	article.view.month.January	en	January
121	article.view.month.February	en	February
122	article.view.month.March	en	March
123	article.view.month.April	en	April
124	article.view.month.May	en	May
125	article.view.month.June	en	June
126	article.view.month.July	en	July
127	article.view.month.August	en	August
128	article.view.month.September	en	September
129	article.view.month.October	en	October
130	article.view.month.November	en	November
131	article.view.month.December	en	December
132	article.view.month.January	uk	Січня
133	article.view.month.February	uk	Лютого
134	article.view.month.March	uk	Березня
135	article.view.month.April	uk	Квітня
136	article.view.month.May	uk	Травня
137	article.view.month.June	uk	Червня
138	article.view.month.July	uk	Липня
139	article.view.month.August	uk	Серпня
140	article.view.month.September	uk	Вересня
141	article.view.month.October	uk	Жовтня
142	article.view.month.November	uk	Листопада
143	article.view.month.December	uk	Грудня
144	article.view.similar	en	Similar articles
145	article.view.similar	uk	Схожі матеріали
146	article.view.continue.reading	en	Continue reading
147	article.view.continue.reading	uk	Продовжити читати
148	404.page_name	en	Page not found (404)
149	404.description	en	Requested page was not found on our server
150	404.page_name	uk	Сторінка не знайдена (404)
151	404.description	uk	Запитана сторінка не знайдена на нашому сервері
152	server-error-example.page_name	en	Server error example page
153	server-error-example.page_name	uk	Сторінка, яка демонструє вигляд помилки серверу
154	sitemap.page_name	en	Sitemap
155	sitemap.description	en	Public sitemap - visit all our resources
156	sitemap.page_name	uk	Мапа сайту
157	sitemap.description	uk	Загальнодоступна мапа сайту - відвідайте всі наші ресурси
158	article.category	en	Category
67	global.language	en	English
68	global.language	uk	Українська
69	root.page_name	en	Home page
70	root.page_name	uk	Домашня сторінка
71	root.about	en	About Page
72	root.about	uk	Сторінка про компанію
73	root.contacts	en	Contacts Page
74	root.contacts	uk	Наші контакти
75	server-error.header	en	Server error page
76	server-error.header	uk	Сторінка помилки серверу
77	server-error.message	en	Sorry, we have an error on our side. Please try again later
78	server-error.message	uk	Вибачте, нажаль сталася помилка на стороні серверу. Спробуйте повторити запит пізніше
79	404.header	en	The requested page was not found on our server
80	404.header	uk	Запрошена сторінка не знайдена на нашому сервері
81	404.message	en	Please check the request and try again
82	404.message	uk	Будь ласка, перевірте адресну строку та спробуйте знову
83	header.logo	en	Lawshield
84	header.logo	uk	Правощит
85	header.sing_in	en	Sing in
86	header.sing_in	uk	Увійти
87	header.subscribe	en	Subscribe
88	header.subscribe	uk	Підписатися
89	footer.copyright	en	Copyright
90	footer.copyright	uk	Авторське право
91	footer.by_romanenko	en	by Romanenko Serhii
92	footer.by_romanenko	uk	належить Романенко Сергію
159	article.category	uk	Категорія
\.


--
-- Name: audio_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audio_identifier_seq', 1, false);


--
-- Name: author_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.author_identifier_seq', 1, false);


--
-- Name: img_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.img_identifier_seq', 1, false);


--
-- Name: links_link_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.links_link_id_seq', 1, false);


--
-- Name: persons_identifier_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.persons_identifier_seq', 1, false);


--
-- Name: translate_entities_entity_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.translate_entities_entity_id_seq', 159, true);


--
-- PostgreSQL database dump complete
--

