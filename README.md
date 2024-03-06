<h2 align="center">Демо версия</h2>
<a href="http://doslab.kadastrcard.ru/admin/site/login" target="_blank">http://doslab.kadastrcard.ru/admin/site/login</a>

```
login:admin
password:123456
```

<h2 align="center">Тестовое задание</h2>
<p class=MsoNoSpacing><b style='mso-bidi-font-weight:normal'>Разработать
приложение учета книг на основе шаблона yii2. База данных <span class=SpellE>postgresql</span>.</b><b
style='mso-bidi-font-weight:normal'><span lang=EN-US style='mso-ansi-language:
EN-US'><o:p></o:p></span></b></p>

<p class=MsoNoSpacing><b style='mso-bidi-font-weight:normal'><span lang=EN-US
style='mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNoSpacing>Функциональные требования:<o:p></o:p></p>

<p class=MsoNoSpacing>- Функционал входа/выхода в систему<o:p></o:p></p>

<p class=MsoNoSpacing>- Добавление книг (Наименование, артикул, Дата
поступления, Автор<span class=GramE> )</span><o:p></o:p></p>

<p class=MsoNoSpacing>- Добавление сотрудников (ФИО, должность)<o:p></o:p></p>

<p class=MsoNoSpacing>- Добавление клиентов (ФИО, серия и номер паспорта)<o:p></o:p></p>

<p class=MsoNoSpacing>- Функционал выдачи книг клиенту. Фиксируется дата <span
class=SpellE>выдачы</span>, книга, сотрудник, срок выдачи<o:p></o:p></p>

<p class=MsoNoSpacing>- Функционал <span class=SpellE>возрата</span> книг.
Данные для фиксации: дата возврата, <span class=SpellE>книга<span class=GramE>,с</span>отрудник,состоянии</span>
книги (из справочника)<o:p></o:p></p>

<p class=MsoNoSpacing>- Страница отображения списка книг с фильтрами: название
книги, в наличии или нет,<o:p></o:p></p>

<p class=MsoNoSpacing>- Страница клиентов с фильтрами: клиенты без книг/с
книгами, ФИО. <o:p></o:p></p>

<p class=MsoNoSpacing>Так же должна быть предусмотрена подробная информация о
взятых книгах (<span class=SpellE>Наименование<span class=GramE>,д</span>ата</span>
возврата) <o:p></o:p></p>

<p class=MsoNoSpacing><o:p>&nbsp;</o:p></p>

<p class=MsoNoSpacing><b style='mso-bidi-font-weight:normal'>Дополнительно:<o:p></o:p></b></p>

<p class=MsoNoSpacing>-Фильтры, расположенные на страницах должны, работать
асинхронно. <o:p></o:p></p>

<p class=MsoNoSpacing>-Рекомендуется использование <span class=SpellE>js</span>
<span class=SpellE>фреймворков</span>. <o:p></o:p></p>

<p class=MsoNoSpacing>-Структура БД произвольная.</p>

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
