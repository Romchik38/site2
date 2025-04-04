# Diff Details

Date : 2025-04-04 18:11:45

Directory /home/ser/Projects/Docker/site2/app

Total : 154 files,  -107376 codes, -4383 comments, -17196 blanks, all -128955 lines

[Summary](results.md) / [Details](details.md) / [Diff Summary](diff.md) / Diff Details

## Files
| filename | language | code | comment | blank | total |
| :--- | :--- | ---: | ---: | ---: | ---: |
| [LICENSE.md](/LICENSE.md) | Markdown | -5 | 0 | -5 | -10 |
| [compose.yaml](/compose.yaml) | YAML | -49 | 0 | -6 | -55 |
| [composer.json](/composer.json) | JSON | -60 | 0 | -3 | -63 |
| [composer.lock](/composer.lock) | JSON | -2,927 | 0 | -1 | -2,928 |
| [deptrac.yaml](/deptrac.yaml) | YAML | -25 | 0 | -1 | -26 |
| [doc/Entities/Article.md](/doc/Entities/Article.md) | Markdown | -7 | 0 | -2 | -9 |
| [doc/Entities/Audio.md](/doc/Entities/Audio.md) | Markdown | -7 | 0 | -3 | -10 |
| [doc/Entities/Author.md](/doc/Entities/Author.md) | Markdown | -9 | 0 | -3 | -12 |
| [doc/Entities/Category.md](/doc/Entities/Category.md) | Markdown | -7 | 0 | -3 | -10 |
| [doc/Entities/Img.md](/doc/Entities/Img.md) | Markdown | -7 | 0 | -3 | -10 |
| [doc/Entities/Language.md](/doc/Entities/Language.md) | Markdown | -11 | 0 | -2 | -13 |
| [doc/Entities/Person.md](/doc/Entities/Person.md) | Markdown | -7 | 0 | -3 | -10 |
| [doc/Image\_Converter/01\_readme.md](/doc/Image_Converter/01_readme.md) | Markdown | -17 | 0 | -12 | -29 |
| [doc/admin/authorization.md](/doc/admin/authorization.md) | Markdown | -3 | 0 | -3 | -6 |
| [doc/admin/routes.md](/doc/admin/routes.md) | Markdown | -25 | 0 | -5 | -30 |
| [doc/admin/schema.md](/doc/admin/schema.md) | Markdown | -14 | 0 | -4 | -18 |
| [doc/bootstrap/00\_readme.md](/doc/bootstrap/00_readme.md) | Markdown | -5 | 0 | -3 | -8 |
| [doc/bootstrap/Container.md](/doc/bootstrap/Container.md) | Markdown | -3 | 0 | -3 | -6 |
| [doc/design/01-readme.md](/doc/design/01-readme.md) | Markdown | -4 | 0 | -1 | -5 |
| [doc/design/bootstrap.md](/doc/design/bootstrap.md) | Markdown | -3 | 0 | -3 | -6 |
| [doc/design/responsive.md](/doc/design/responsive.md) | Markdown | -29 | 0 | -5 | -34 |
| [doc/docker/00\_readme.md](/doc/docker/00_readme.md) | Markdown | -7 | 0 | -4 | -11 |
| [doc/errors/errors.md](/doc/errors/errors.md) | Markdown | -4 | 0 | -3 | -7 |
| [doc/errors/not-found/00-readme.md](/doc/errors/not-found/00-readme.md) | Markdown | -4 | 0 | -2 | -6 |
| [doc/errors/server-errors/00-readme.md](/doc/errors/server-errors/00-readme.md) | Markdown | -4 | 0 | -2 | -6 |
| [doc/errors/server-errors/01-how-it-works.md](/doc/errors/server-errors/01-how-it-works.md) | Markdown | -19 | 0 | -10 | -29 |
| [doc/errors/server-errors/02-server-error-controller.md](/doc/errors/server-errors/02-server-error-controller.md) | Markdown | -12 | 0 | -8 | -20 |
| [doc/errors/server-errors/03-php-fpm-service-error.md](/doc/errors/server-errors/03-php-fpm-service-error.md) | Markdown | -17 | 0 | -10 | -27 |
| [doc/frontend/routes.md](/doc/frontend/routes.md) | Markdown | -13 | 0 | -5 | -18 |
| [doc/language/01-readme.md](/doc/language/01-readme.md) | Markdown | -6 | 0 | -3 | -9 |
| [doc/language/action.md](/doc/language/action.md) | Markdown | -20 | 0 | -5 | -25 |
| [doc/language/sketches.md](/doc/language/sketches.md) | Markdown | -39 | 0 | -20 | -59 |
| [doc/mail/docker.md](/doc/mail/docker.md) | Markdown | -3 | 0 | -2 | -5 |
| [doc/security/csrf.md](/doc/security/csrf.md) | Markdown | -16 | 0 | -12 | -28 |
| [doc/templates/01-readme.md](/doc/templates/01-readme.md) | Markdown | -41 | 0 | -19 | -60 |
| [docker/nginx/conf.d/default.conf](/docker/nginx/conf.d/default.conf) | Properties | -27 | -6 | -7 | -40 |
| [docker/php-fpm/Dockerfile](/docker/php-fpm/Dockerfile) | Docker | -14 | 0 | -6 | -20 |
| [docker/php-fpm/php/conf.d/site2.ini](/docker/php-fpm/php/conf.d/site2.ini) | Ini | -2 | 0 | 0 | -2 |
| [docker/php-fpm/readme.md](/docker/php-fpm/readme.md) | Markdown | -20 | 0 | -6 | -26 |
| [docker/postgres/Dockerfile](/docker/postgres/Dockerfile) | Docker | -3 | 0 | -1 | -4 |
| [docker/postgres/readme.md](/docker/postgres/readme.md) | Markdown | -11 | 0 | -6 | -17 |
| [docker/postgres/scripts/database.sql](/docker/postgres/scripts/database.sql) | MS SQL | -5 | 0 | 0 | -5 |
| [docker/postgres/scripts/site2.sql](/docker/postgres/scripts/site2.sql) | MS SQL | -736 | -383 | -411 | -1,530 |
| [nginx/simple.conf](/nginx/simple.conf) | Properties | -39 | -8 | -12 | -59 |
| [phpcs.xml](/phpcs.xml) | XML | -13 | -3 | -4 | -20 |
| [phpunit.xml](/phpunit.xml) | XML | -13 | -1 | 0 | -14 |
| [public/http/img.php](/public/http/img.php) | PHP | -91 | -12 | -11 | -114 |
| [public/http/index.php](/public/http/index.php) | PHP | -14 | -5 | -7 | -26 |
| [public/http/media/css/admin/admin.css](/public/http/media/css/admin/admin.css) | CSS | -18 | 0 | -5 | -23 |
| [public/http/media/css/admin\_main.css](/public/http/media/css/admin_main.css) | CSS | -7 | 0 | -2 | -9 |
| [public/http/media/css/article.css](/public/http/media/css/article.css) | CSS | -6 | 0 | -1 | -7 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.css) | CSS | -3,886 | -6 | -193 | -4,085 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.min.css) | CSS | -1 | -5 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.rtl.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.rtl.css) | CSS | -3,886 | -6 | -192 | -4,084 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.rtl.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-grid.rtl.min.css) | CSS | -1 | -5 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.css) | CSS | -518 | -14 | -65 | -597 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.min.css) | CSS | -1 | -5 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.rtl.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.rtl.css) | CSS | -524 | -6 | -64 | -594 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.rtl.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-reboot.rtl.min.css) | CSS | -1 | -5 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.css) | CSS | -4,891 | -8 | -503 | -5,402 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.min.css) | CSS | -1 | -5 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.rtl.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.rtl.css) | CSS | -4,887 | -6 | -500 | -5,393 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.rtl.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap-utilities.rtl.min.css) | CSS | -1 | -5 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.css) | CSS | -11,136 | -24 | -897 | -12,057 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.min.css) | CSS | -2 | -4 | 0 | -6 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.rtl.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.rtl.css) | CSS | -11,138 | -6 | -886 | -12,030 |
| [public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css](/public/http/media/css/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css) | CSS | -2 | -4 | 0 | -6 |
| [public/http/media/css/bootstrap/bootstrap-grid.css](/public/http/media/css/bootstrap/bootstrap-grid.css) | CSS | -3,865 | -7 | -1,130 | -5,002 |
| [public/http/media/css/bootstrap/bootstrap-grid.min.css](/public/http/media/css/bootstrap/bootstrap-grid.min.css) | CSS | -1 | -6 | 0 | -7 |
| [public/http/media/css/bootstrap/bootstrap-grid.rtl.css](/public/http/media/css/bootstrap/bootstrap-grid.rtl.css) | CSS | -3,865 | -7 | -1,129 | -5,001 |
| [public/http/media/css/bootstrap/bootstrap-grid.rtl.min.css](/public/http/media/css/bootstrap/bootstrap-grid.rtl.min.css) | CSS | -1 | -6 | 0 | -7 |
| [public/http/media/css/bootstrap/bootstrap-reboot.css](/public/http/media/css/bootstrap/bootstrap-reboot.css) | CSS | -346 | -16 | -64 | -426 |
| [public/http/media/css/bootstrap/bootstrap-reboot.min.css](/public/http/media/css/bootstrap/bootstrap-reboot.min.css) | CSS | -1 | -7 | 0 | -8 |
| [public/http/media/css/bootstrap/bootstrap-reboot.rtl.css](/public/http/media/css/bootstrap/bootstrap-reboot.rtl.css) | CSS | -352 | -8 | -63 | -423 |
| [public/http/media/css/bootstrap/bootstrap-reboot.rtl.min.css](/public/http/media/css/bootstrap/bootstrap-reboot.rtl.min.css) | CSS | -1 | -7 | 0 | -8 |
| [public/http/media/css/bootstrap/bootstrap-utilities.css](/public/http/media/css/bootstrap/bootstrap-utilities.css) | CSS | -3,634 | -9 | -1,109 | -4,752 |
| [public/http/media/css/bootstrap/bootstrap-utilities.min.css](/public/http/media/css/bootstrap/bootstrap-utilities.min.css) | CSS | -1 | -6 | 0 | -7 |
| [public/http/media/css/bootstrap/bootstrap-utilities.rtl.css](/public/http/media/css/bootstrap/bootstrap-utilities.rtl.css) | CSS | -3,630 | -7 | -1,106 | -4,743 |
| [public/http/media/css/bootstrap/bootstrap-utilities.rtl.min.css](/public/http/media/css/bootstrap/bootstrap-utilities.rtl.min.css) | CSS | -1 | -6 | 0 | -7 |
| [public/http/media/css/bootstrap/bootstrap.css](/public/http/media/css/bootstrap/bootstrap.css) | CSS | -9,102 | -27 | -1,708 | -10,837 |
| [public/http/media/css/bootstrap/bootstrap.min.css](/public/http/media/css/bootstrap/bootstrap.min.css) | CSS | -2 | -5 | 0 | -7 |
| [public/http/media/css/bootstrap/bootstrap.rtl.css](/public/http/media/css/bootstrap/bootstrap.rtl.css) | CSS | -9,104 | -7 | -1,702 | -10,813 |
| [public/http/media/css/bootstrap/bootstrap.rtl.min.css](/public/http/media/css/bootstrap/bootstrap.rtl.min.css) | CSS | -2 | -5 | 0 | -7 |
| [public/http/media/css/category.css](/public/http/media/css/category.css) | CSS | -25 | 0 | -3 | -28 |
| [public/http/media/css/home.css](/public/http/media/css/home.css) | CSS | -27 | -12 | -10 | -49 |
| [public/http/media/css/main.css](/public/http/media/css/main.css) | CSS | -73 | -13 | -24 | -110 |
| [public/http/media/html/article-with-img-1080.html](/public/http/media/html/article-with-img-1080.html) | HTML | -319 | -22 | -16 | -357 |
| [public/http/media/html/category.html](/public/http/media/html/category.html) | HTML | -437 | -40 | -28 | -505 |
| [public/http/media/html/errors/not-found-404.html](/public/http/media/html/errors/not-found-404.html) | HTML | -37 | -8 | -10 | -55 |
| [public/http/media/html/errors/server-error-500.html](/public/http/media/html/errors/server-error-500.html) | HTML | -147 | -1 | -15 | -163 |
| [public/http/media/html/errors/server-error-502.html](/public/http/media/html/errors/server-error-502.html) | HTML | -147 | -1 | -15 | -163 |
| [public/http/media/html/footer-copyrights.html](/public/http/media/html/footer-copyrights.html) | HTML | -34 | -4 | -7 | -45 |
| [public/http/media/html/footer-infoline.html](/public/http/media/html/footer-infoline.html) | HTML | -55 | -6 | -8 | -69 |
| [public/http/media/html/footer-links.html](/public/http/media/html/footer-links.html) | HTML | -76 | -5 | -9 | -90 |
| [public/http/media/html/footer-policy.html](/public/http/media/html/footer-policy.html) | HTML | -39 | -6 | -7 | -52 |
| [public/http/media/html/footer-social-links.html](/public/http/media/html/footer-social-links.html) | HTML | -37 | -6 | -9 | -52 |
| [public/http/media/html/header-breadcrumbs.html](/public/http/media/html/header-breadcrumbs.html) | HTML | -35 | -4 | -9 | -48 |
| [public/http/media/html/header-infoline.html](/public/http/media/html/header-infoline.html) | HTML | -39 | -2 | -7 | -48 |
| [public/http/media/html/header-logo.html](/public/http/media/html/header-logo.html) | HTML | -55 | -6 | -9 | -70 |
| [public/http/media/html/header-nav.html](/public/http/media/html/header-nav.html) | HTML | -131 | -8 | -10 | -149 |
| [public/http/media/html/home.html](/public/http/media/html/home.html) | HTML | -452 | -41 | -19 | -512 |
| [public/http/media/html/proto.html](/public/http/media/html/proto.html) | HTML | -52 | -2 | -6 | -60 |
| [public/http/media/html/skeleton.html](/public/http/media/html/skeleton.html) | HTML | -58 | -26 | -21 | -105 |
| [public/http/media/js/admin/userinfo.js](/public/http/media/js/admin/userinfo.js) | JavaScript | -42 | -1 | -10 | -53 |
| [public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.bundle.js](/public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.bundle.js) | JavaScript | -5,064 | -655 | -596 | -6,315 |
| [public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js](/public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js) | JavaScript | -1 | -6 | 0 | -7 |
| [public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.esm.js](/public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.esm.js) | JavaScript | -3,568 | -578 | -302 | -4,448 |
| [public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.esm.min.js](/public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.esm.min.js) | JavaScript | -1 | -6 | 0 | -7 |
| [public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.js](/public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.js) | JavaScript | -3,604 | -584 | -307 | -4,495 |
| [public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.min.js](/public/http/media/js/bootstrap-5.3.3-dist/js/bootstrap.min.js) | JavaScript | -1 | -6 | 0 | -7 |
| [public/http/media/js/bootstrap.bundle.js](/public/http/media/js/bootstrap.bundle.js) | JavaScript | -4,836 | -571 | -1,342 | -6,749 |
| [public/http/media/js/bootstrap.bundle.min.js](/public/http/media/js/bootstrap.bundle.min.js) | JavaScript | -1 | -6 | 0 | -7 |
| [public/http/media/js/bootstrap.esm.js](/public/http/media/js/bootstrap.esm.js) | JavaScript | -3,425 | -483 | -1,060 | -4,968 |
| [public/http/media/js/bootstrap.esm.min.js](/public/http/media/js/bootstrap.esm.min.js) | JavaScript | -1 | -6 | 0 | -7 |
| [public/http/media/js/bootstrap.js](/public/http/media/js/bootstrap.js) | JavaScript | -3,464 | -489 | -1,064 | -5,017 |
| [public/http/media/js/bootstrap.min.js](/public/http/media/js/bootstrap.min.js) | JavaScript | -1 | -6 | 0 | -7 |
| [public/http/media/js/frontend/userinfo.js](/public/http/media/js/frontend/userinfo.js) | JavaScript | -51 | -4 | -10 | -65 |
| [public/http/media/js/language.js](/public/http/media/js/language.js) | JavaScript | -18 | -4 | -10 | -32 |
| [public/http/media/js/modules/urlbuilder/dynamicTarget.js](/public/http/media/js/modules/urlbuilder/dynamicTarget.js) | JavaScript | -14 | 0 | -2 | -16 |
| [public/http/media/js/modules/urlbuilder/urlbuilder.js](/public/http/media/js/modules/urlbuilder/urlbuilder.js) | JavaScript | -6 | 0 | -1 | -7 |
| [public/http/media/js/popper.min.js](/public/http/media/js/popper.min.js) | JavaScript | -1 | -4 | -2 | -7 |
| [readme.md](/readme.md) | Markdown | -35 | 0 | -12 | -47 |
| [server/Api/Models/SearchCriteria/FilterInterface.php](/server/Api/Models/SearchCriteria/FilterInterface.php) | PHP | -8 | -2 | -5 | -15 |
| [server/Api/Models/SearchCriteria/LimitInterface.php](/server/Api/Models/SearchCriteria/LimitInterface.php) | PHP | -6 | 0 | -3 | -9 |
| [server/Api/Models/SearchCriteria/OffsetInterface.php](/server/Api/Models/SearchCriteria/OffsetInterface.php) | PHP | -6 | 0 | -3 | -9 |
| [server/Api/Models/SearchCriteria/OrderByInterface.php](/server/Api/Models/SearchCriteria/OrderByInterface.php) | PHP | -13 | 0 | -5 | -18 |
| [server/Api/Models/SearchCriteria/SearchCriteriaFactoryInterface.php](/server/Api/Models/SearchCriteria/SearchCriteriaFactoryInterface.php) | PHP | -11 | -1 | -4 | -16 |
| [server/Api/Models/SearchCriteria/SearchCriteriaInterface.php](/server/Api/Models/SearchCriteria/SearchCriteriaInterface.php) | PHP | -16 | -15 | -17 | -48 |
| [server/Models/Sql/SearchCriteria/Filter.php](/server/Models/Sql/SearchCriteria/Filter.php) | PHP | -19 | 0 | -7 | -26 |
| [server/Models/Sql/SearchCriteria/Limit.php](/server/Models/Sql/SearchCriteria/Limit.php) | PHP | -28 | 0 | -8 | -36 |
| [server/Models/Sql/SearchCriteria/Offset.php](/server/Models/Sql/SearchCriteria/Offset.php) | PHP | -17 | 0 | -7 | -24 |
| [server/Models/Sql/SearchCriteria/OrderBy.php](/server/Models/Sql/SearchCriteria/OrderBy.php) | PHP | -41 | -5 | -11 | -57 |
| [server/Models/Sql/SearchCriteria/SearchCriteria.php](/server/Models/Sql/SearchCriteria/SearchCriteria.php) | PHP | -60 | -5 | -16 | -81 |
| [sql/admin\_users.sql](/sql/admin_users.sql) | MS SQL | -45 | 0 | -6 | -51 |
| [sql/article.sql](/sql/article.sql) | MS SQL | -129 | -1 | -6 | -136 |
| [sql/articleListView/author.sql](/sql/articleListView/author.sql) | MS SQL | -39 | 0 | -2 | -41 |
| [sql/articleListView/select.sql](/sql/articleListView/select.sql) | MS SQL | -63 | -4 | -3 | -70 |
| [sql/audio.sql](/sql/audio.sql) | MS SQL | -26 | 0 | -3 | -29 |
| [sql/author.sql](/sql/author.sql) | MS SQL | -20 | 0 | -5 | -25 |
| [sql/category.sql](/sql/category.sql) | MS SQL | -13 | 0 | -2 | -15 |
| [sql/database.sql](/sql/database.sql) | MS SQL | -5 | 0 | 0 | -5 |
| [sql/img.sql](/sql/img.sql) | MS SQL | -25 | 0 | -5 | -30 |
| [sql/img\_cache.sql](/sql/img_cache.sql) | MS SQL | -7 | 0 | 0 | -7 |
| [sql/language.sql](/sql/language.sql) | MS SQL | -9 | 0 | -1 | -10 |
| [sql/links.sql](/sql/links.sql) | MS SQL | -40 | -3 | -5 | -48 |
| [sql/persons.sql](/sql/persons.sql) | MS SQL | -25 | -2 | -4 | -31 |
| [sql/rights.sql](/sql/rights.sql) | MS SQL | -13 | 0 | -1 | -14 |
| [sql/translate\_entities.sql](/sql/translate_entities.sql) | MS SQL | -133 | -7 | -3 | -143 |
| [sql/translate\_keys.sql](/sql/translate_keys.sql) | MS SQL | -68 | -5 | -3 | -76 |
| [tests/Unit/Domain/Image/ImageTest.php](/tests/Unit/Domain/Image/ImageTest.php) | PHP | -735 | -43 | -90 | -868 |
| [tests/Unit/Infrastructure/Controllers/Sitemap/DefaultAction/SitemapDTOFactoryTest.php](/tests/Unit/Infrastructure/Controllers/Sitemap/DefaultAction/SitemapDTOFactoryTest.php) | PHP | -47 | 0 | -16 | -63 |
| [tests/Unit/Infrastructure/Controllers/Sitemap/DefaultAction/SitemapDTOTest.php](/tests/Unit/Infrastructure/Controllers/Sitemap/DefaultAction/SitemapDTOTest.php) | PHP | -14 | 0 | -7 | -21 |
| [tests/Unit/Infrastructure/Views/Html/Classes/SitemapLinkTreeToHtmlTest.php](/tests/Unit/Infrastructure/Views/Html/Classes/SitemapLinkTreeToHtmlTest.php) | PHP | -36 | 0 | -12 | -48 |
| [todo.md](/todo.md) | Markdown | -18 | 0 | -7 | -25 |

[Summary](results.md) / [Details](details.md) / [Diff Summary](diff.md) / Diff Details